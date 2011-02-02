# = Synopsis 
#
# Classes that store schema mapping information. 
#
# = Author
#
# - Kjell-Magne Oierud mailto:kjellm@linpro.no
#
# = Version
#
# $Id: mapping.rb 2442 2008-09-04 15:31:10Z robert $
#


#
# Stores the mapping for a table
#
class PrototypeTableMap

  attr :name

  def method_missing(m, *args)
    instance_variable_set("@#{m}".to_sym, args[0]) unless args.empty?
    instance_variable_get("@#{m}".to_sym)
  end

  def initialize(name, &blk)
    @name = name
    @primary_key = find_primary_key()
    @__filter_rows__ = nil
    @__precondition__ = nil
    @__set__ = []
    @__default_table__ = nil
    self.instance_eval(&blk)
  end

  def each_column
    instance_variables.sort.each do |attr|
      
      next if attr[0..2] == "@__"
      next if attr[0..1] != "@_"

      yield(attr[2..-1], instance_variable_get(attr))
    end
  end

  def find_primary_key
    query = %Q{
      SELECT column_name
        FROM information_schema.table_constraints tc
             INNER JOIN
             information_schema.key_column_usage kcu
             ON tc.constraint_name = kcu.constraint_name
       WHERE constraint_type  = 'PRIMARY KEY'
         AND tc.table_catalog = 'reaktor'
         AND tc.table_schema  = 'public'
         AND tc.table_name    = '#{@name}'
       ORDER BY ordinal_position;
    }
    begin
      sth = $dbh_pg.execute(query)
    rescue
      $stderr.puts "### Error in #{__FILE__} on line #{__LINE__}. See errorlog"
      Log.write_log('error', "Could not find primary key. Message: #{$!}.")
      raise
      exit
    end
    pk = []
    while row = sth.fetch
      pk << row[0]
    end
    return pk
  end
end


#
# Stores the mapping of a single column
#
class ReaktorColumn

  
  attr :name
  attr :table
  attr :filters
  attr :value

  def initialize(attrs = {})
    attrs.each do |k, v|
      instance_variable_set("@#{k}", v)
    end
  end

  def fill_in_defaults(default_table, default_column)
    @table   ||= default_table
    @name    ||= default_column
    @filters ||= nil
    @value   = nil unless instance_variable_defined?(:@value)
  end

  def inspect
    '#<ReaktorColumn (table: %s, name: %s, filters: %d, value: %s)>' % [@table, @name, [@filters].flatten.length, @value.inspect]
  end

  def to_s; inspect; end
  
  #
  # Creates a ReaktorColumn object and make use of its parse_value method
  # => value: Default value for column
  # => attr_value: Column row value
  # => row: SQL result set
  #
  def self.parse_value(value, attr_value, row)
    rc = ReaktorColumn.new({'value' => value})
    rc.parse_value(attr_value, row)
  end
  
  #
  # Parses the column value
  # %value returns the value on column value
  # %_ returns the value of column with the name attr_name
  # If no % prefix the column value is returned
  # => attr_name: Column name for this column
  # => row: SQL result set
  #
  def parse_value(attr_value, row)
    unless row.class == DBI::Row
      $stderr.puts  "### Error in #{__FILE__} on line #{__LINE__}. See errorlog"
      Log.write_log('error', "parse_value(): row is not a DBI::Row but a #{row.class}")
      exit 1
    end
    return @value if @value.nil?
    return @value unless @value.kind_of?(String)

    if @value[0] == '%'[0]
      if @value == '%_'
        return attr_value
      else
        unless row.to_h.key?(@value[1..-1])
          $stderr.puts  "### Error in #{__FILE__} on line #{__LINE__}. See errorlog"
          Log.write_log('error', "parse_value failed. Data does not contain value indexed by \"#{@value[1..-1]}\". row = #{row.to_h.inspect}, attr_value = #{attr_value.inspect}")
          raise
          exit
        end
        unless row[@value[1..-1]]
          return ''
        else
          return row[@value[1..-1]]
        end
      end
    end
    return @value
  end
end


#
# Stores information on an entire row
#
class ReaktorRow

  attr :table
  attr :columns
  attr :idstore

  def initialize(table, columns, idstore = nil)
    @table   = table
    @columns = columns
    @idstore = idstore
  end

  def inspect
    '#<ReaktorRow (table: %s, columns: [%s])>' % [table, (@columns.inject("") {|r, c| r << c.inspect << ', '})]
  end

  def to_s; inspect; end
end



#
# Used to signal the import algorithm that this value should be
# ignored.
#
class IGNORE; end


#
# Stores a SQL query that is to be executed on the prototype. The
# result of executing the query should typically be a single value.
#
class Query
  attr :sql

  def initialize(sql)
    @sql = sql
  end

  def inspect
    '#<Query (sql: %s)>' % sql
  end

  def to_s; inspect; end
end

