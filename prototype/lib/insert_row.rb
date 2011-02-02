#!/usr/bin/env ruby
#
# = Synopsis 
#
# This class holds data rows to be inserted into a database table
#
# = Author
#
# - Robert Strind mailto:robert@linpro.no
#
# = Version
#
# $Id:$
#

class Array
  
  #
  # Escapes all elements: ["element", ...]
  #
  def escape
    self.collect {|c| "\"#{c.to_s}\"" }
  end
  
  #
  # This function makes it posible to sort a list of symbols
  #
  def sort_sym
    self.sort {|a,b| a.to_s <=> b.to_s }
  end
end

class InsertRow
  
  attr_accessor :prototype_table_map, :prototype_result_set, :idstore
  attr_reader :table_name
  
  @@log_name = 'insert_row'
  
  #
  # => name: Name of the table to insert to
  # => idstore: IdStore object
  #
  def initialize(name, idstore = nil)
    @table_name = name
    @idstore = idstore
    @columns = {}
    Log.write_log('insert_row', "Created InsertRow object. name = #{name}, #{idstore.inspect}")
  end
  
  def inspect
    "#<InsertRow (@table_name: #{@table_name}, @idstore: #{@idstore.inspect}, columns: #{@columns.inspect})>"
  end
  
  #
  # Return a sorted comma seperated list of column names
  #
  def get_column_name_string
    @columns.keys.sort_sym.escape.join(', ')
  end
  
  #
  # Return value from column
  # => name: Name of column to return value from
  #
  def column(name)
    @columns[name]
  end
  
  #
  # Return the number of columns
  #
  def size
    @columns.length
  end
  
  #
  # Returns a list of column values sorted by column name
  #
  def get_column_values
    @columns.each {|c| @columns[c[0]] = c[1].get if c[1].kind_of?(IdStore)}
    @columns.values_at(*@columns.keys.sort_sym)
  end
  
  #
  # Add a column name - value pair to the row
  # => pair: A list: [column name, value]
  #
  def add(column_name, value)
    @columns[column_name] = value
  end
  
  #
  # Find the primary key for this table
  # => db_handle: A DBI handle
  # => database: Database name
  # Returns a list of primary keys
  #
  def find_primary_key(db_handle, database)
    query = %q{
    SELECT k.column_name
    FROM information_schema.table_constraints t
    JOIN information_schema.key_column_usage k
    USING(constraint_name,table_schema,table_name)
    WHERE t.constraint_type='PRIMARY KEY'
      AND t.table_schema='?'
      AND t.table_name='?';
    }
    sth = db_handle.prepare(query)
    begin
      sth.execute(database, @table_name)
    rescue
      $stderr.puts "### Error in #{__FILE__} on line #{__LINE__}. See errorlog"
      Log.write_log('error', "Could not find primary key. Message: #{$!}. query: \"#{get_query_string(sth)}\"")
      raise
      exit
    end
    pk = []
    while row = sth.fetch
      pk << row[0]
    end
    return pk
  end
  
  #
  # Get primary key set
  # => db_handle: A DBI handle
  # => database: Database name
  # <= {column_name => value, ...}
  #
  def get_primary_key_set(db_handle, database)
    @primary_key_set = {}
    find_primary_key(db_handle, database).each do |pk|
       @primary_key_set.store(pk, @columns[pk])
    end
  end
  
  def store_id(value)
    Log.write_log(@@log_name, "Storing id for table #{@table_name} IdStore args: #{@idstore.args * ','}")
    @idstore.store(value) unless @idstore.nil?
  end
end
