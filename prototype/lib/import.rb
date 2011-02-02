#!/usr/bin/env ruby

# = Synopsis
#
# Imports the data from the prototype into a mysql database with the
# new reaktor schema following the rules defined in the schema map.
#
# = Author
#
# * Kjell-Magne Oierud mailto:kjellm@linpro.no
# * Robert Strind mailto:robert@linpro.no
#
# = Version
#
# $Id: import.rb 2579 2008-09-29 10:03:17Z robert $
#

# Expand ruby search path
$: << File.expand_path(File.join(File.dirname(__FILE__), '..', 'lib'))
$: << File.expand_path(File.join(File.dirname(__FILE__), '..', 'plugins'))

require 'dbi';
require 'ostruct'
require 'pp'

require 'log'
require 'filter'
require 'mapping'
require 'key_map'
require 'domain_maps'
require 'insert_row'
require 'id_store'
require 'utf8_converter'

require 'plugin'
require 'artwork_data_plugin'
require 'reaktoruser_artworkgroups_plugin'
require 'reaktoruser_image_plugin'
require 'reaktoruser_type_plugin'
require 'reaktoruser_site_plugin'
require 'artwork_internal_discussion_plugin'
require 'artwork_topic_tagging_plugin'

#
# Perform the migration
# Input: Hash witl all configuration data
#
def import(cnf)
  #
  # Connect to databases
  #
  begin
    $dbh_pg = DBI.connect(
      "dbi:Pg:#{cnf[:from_db_name]}:",
      cnf[:from_db_user],
      cnf[:from_db_password]
    )
  rescue
    STDERR.puts "### Error in #{__FILE__} on line #{__LINE__}. See errorlog."
    Log.write_log(:error, "Could not connect to database. Message: #{$!}\ncnf:#{cnf.inspect}")
    exit
  end
  begin
    $dbh_ms = DBI.connect(
      "dbi:Mysql:#{cnf[:to_db_name]}:",
      cnf[:to_db_user],
      cnf[:to_db_password]
    )
  rescue
    STDERR.puts "### Error in #{__FILE__} on line #{__LINE__}. See errorlog."
    Log.write_log(:error, "Could not connect to database. Message: #{$!}")
    exit
  end
  $dbh_ms.do("SET sql_mode='TRADITIONAL,ANSI'")
  $dbh_ms.do("SET NAMES 'utf8'")
  
  $reaktor_insert_count = 0
  $import_log = 'import'
  $debug = cnf[:debug]
  
  #
  # Initialize plugins
  #
  ArtworkDataPlugin::set_data_path(cnf[:path_data])
  
  #
  # Drop id_store table if it exists
  #
  begin
    sth = $dbh_pg.execute("SELECT relname FROM pg_class WHERE relname = 'id_store'")
  rescue
    $stderr.puts "### Error in #{__FILE__} on line #{__LINE__}. See errorlog"
    Log.write_log('error', "Could not process query. Message: #{$!} query: #{get_query_string(sth)}.")
    raise
    exit
  end
  relname = sth.fetch
  
  if relname
    begin
      sth = $dbh_pg.execute(%Q{DROP TABLE id_store})
    rescue
      $stderr.puts "### Error in #{__FILE__} on line #{__LINE__}. See errorlog"
      Log.write_log('error', "Could not process query. Message: #{$!} query: #{get_query_string(sth)}.")
      raise
      exit
    end
    STDERR.puts "Dropped id_store table from prototype."
  end
  
  #
  # Load the schema map
  #
  require 'schema_map'
  
  #
  # Process tables
  #
  $schema.each do |t|
    process_table(t)
  end
  
  #
  # Write reports
  #
  ArtworkDataPlugin.flush_logs
  ArtworkDataPlugin.write_report
  
  ArtworkTopicTaggingPlugin::flush_logs
  ArtworkTopicTaggingPlugin::write_report
  
  ArtworkInternalDiscussionPlugin::flush_logs
  ArtworkInternalDiscussionPlugin::write_report
  
  ReaktoruserArtworkgroupsPlugin::flush_logs
  ReaktoruserArtworkgroupsPlugin::write_report
end

#
# process_table
# Input: PrototypeTableMap object
#
def process_table(table)
  
  $stderr.puts "Processing table: %-15s to default table: #{table.__default_table__}" % table.name
  Log.write_log(table.name,  "Processing table: #{table.name}")
  table.each_column do |attr_name, maps_to|
    if maps_to.kind_of?(ReaktorColumn)
      maps_to.fill_in_defaults(table.__default_table__, attr_name)
    end
  end
  table.__set__.each do |rc|
    rc.fill_in_defaults(table.__default_table__, nil)
  end
  if table.instance_variable_defined?(:@__query__)
    query = table.__query__
  else
    query = build_query(table.name, table.__filter_rows__)
  end
  Log.write_log(table.name, "Query: #{query}")
  begin
    sth = $dbh_pg.execute(query)
  rescue
    $stderr.puts "### Error in #{__FILE__} on line #{__LINE__}. See errorlog"
    Log.write_log('error', "Could not process query. Message: #{$!} query: #{get_query_string(sth)}.")
    raise
    exit
  end
  while row = sth.fetch
    next unless preconditions_met?(row, table.__precondition__)

    process_row(table, row).each do |r|
      reaktor_insert(r) unless r.nil?
    end
  end
end


#
# parse_value
#
# If value is a reference (First character is '%'), substitutes the
# value with a value from 'row_value' when value is '%_' otherwise
# from data.
#
def parse_value(value, row_value, data)
  return value if value.nil?
  return value unless value.kind_of?(String)

  if value[0] == '%'[0]
    if value == '%_'
      return row_value
    else
      if not data[value[1..-1]]
        $stderr.puts  "### Error in #{__FILE__} on line #{__LINE__}. See errorlog"
        Log.write_log('error', "parse_value failed. data does not contain value indexed by \"#{value[1..-1]}\"")
        exit
      else
        return data[value[1..-1]]
      end
    end
  end
  return value
end


#
# Process a row from the old database
# Input: PrototypeTableMap object and SQL result set from prototype table
#
def process_row(table, row)
  Log.write_log(table.name, "Processing row: #{row.pretty_inspect}")
  row.each do |v|
    row.to_h.each do |k,v|
      row[k] = Utf8_Converter::convert(v) if v.kind_of?(String)
    end
  end
  pk_string = ''
  table.primary_key.each do |pk|
    pk_string << row[pk].to_s
  end
  if pk_string.empty?
    row.each {|c| pk_string << c.to_s}
  end
  if (table.__id_store__)
    default_table_row = InsertRow.new(table.__default_table__, IdStore.new(table.name, pk_string))
  else
    default_table_row = InsertRow.new(table.__default_table__)
  end
  default_table_row.prototype_table_map = table
  default_table_row.prototype_result_set = row
  table_rows = []

  table.each_column do |attr_name, maps_to|
    next if maps_to == IGNORE

    if maps_to.kind_of?(ReaktorColumn)
      #
      # ReaktorColumn
      #
      default_table_row.add(*process_reaktor_column(maps_to, attr_name, row))
    elsif maps_to.kind_of?(ReaktorRow)
      #
      # ReaktorRow
      #
      table_rows << process_reaktor_row(maps_to, attr_name, row)
    elsif maps_to.kind_of?(Class)
      #
      # Plugin
      #
      plugin = process_plugin(maps_to, attr_name, row)
      list = plugin.each
      if list.kind_of?(Array)
        list.each do |reaktor_object|
          if reaktor_object.kind_of?(ReaktorColumn)
            default_table_row.add(*process_reaktor_column(reaktor_object, attr_name, row))
          elsif reaktor_object.kind_of?(ReaktorRow)
            table_rows << process_reaktor_row(reaktor_object, attr_name, row)
          else
            STDERR.puts "reaktor_object was a #{reaktor_object.class} class"
            exit
          end
        end
      end
    else
      STDERR.puts "maps_to was of class: #{maps_to.class} and not processed"
      exit
    end
  end
  
  table.__set__.each do |set|
    t = set.value
    if set.value.kind_of?(Query)
      tsth = $dbh_pg.prepare(set.value.sql)
      begin
        tsth.execute(row[:id])
      rescue
        $stderr.puts "### Error in #{__FILE__} on line #{__LINE__}. See errorlog"
        Log.write_log('error', "Could not process query. Message: #{$!} query: #{get_query_string(tsth)}.")
        raise
        exit
      end
      r = tsth.fetch
      t = r.nil? ? r : r[0]
    else
      t = set.parse_value(nil, row)
    end
    t = Filter.apply_filters(t, row, set.filters)
    default_table_row.add(set.name, t)
  end
  table_rows.insert(0, default_table_row) unless table.__default_table__.nil?
  return table_rows
end

#
# Extract column name and value from a ReaktorColumn
# => rco: ReaktorColumn object
# => attr_name: Attribute name defined in PrototypeTableMap
# => row: SQL result set from prototype table
# <= [column_name, value]
#
def process_reaktor_column(rco, attr_name, row)
  begin
    val = Filter.apply_filters(row[attr_name], row, rco.filters)
  rescue Exception
    STDERR.puts "row: #{row.inspect}"
    raise
  end
  Log.write_log(rco.table, "Setting column: #{rco.inspect} value = #{val.inspect}")
  return  [rco.name,val]
end

#
# Extract table name, column names and values from a ReaktorRow object
# => rro: ReaktorRow object
# => attr_name: Attribute name see: schema_map.rb
# => row: SQL result set from prototype table
# <= InsertRow object
#
def process_reaktor_row(rro, attr_name, row)
    return nil if row[attr_name].nil?
    table_row_data = InsertRow.new(rro.table, rro.idstore)
    rro.columns.each do |column|
      val = column.parse_value(row[attr_name], row)
      val = Filter.apply_filters(val, row, column.filters)
      table_row_data.add(column.name, val)
    end
    Log.write_log(rro.table, "Setting row: #{rro.pretty_inspect}")
    return table_row_data
end

#
# Run a plugin
# => po: Plugin object
# => attr_name: Attribute name see: schema_map.rb
# => row: SQL result set from prototype table
# <= A list of ReaktorRow objects
def process_plugin(po, attr_name, row)
  po.new(attr_name, row)
end

#
# precondition_met?
#
# Executes and evaluates the precondition query. The query can contain
# references to row values ('%foo') which will be replaced before
# execution.
#
def preconditions_met?(row, precondition)
  unless precondition.nil?
    pre_query = precondition.gsub(/%(\w+)/) do |m|
      if row[$1].kind_of?(String)
        row[$1].downcase
      else
        row[$1]
      end
    end

    begin
      r = $dbh_ms.select_one(pre_query)
    rescue
      $stderr.puts "### Error in #{__FILE__} on line #{__LINE__}. See errorlog"
      Log.write_log('error', "Could not process pre-query. Message: #{$!}. Pre-query: \"#{pre_query}\"")
      STDERR.puts "r: #{r.inspect}"
      raise
      exit
    end
    if r[0] == 0
      Log.write_log('not_met_preconditions', "Row does not satisfy pre condition. Pre-query: #{pre_query}")
      return false
    end
  end

  return true
end

#
# Insert values to database
# => row: A InsertRow object
#
def reaktor_insert(row)
  insert_id = 0
  unless row.idstore.nil?
    Log.write_log($import_log, "reaktor_insert: Table: #{row.table_name} args: #{row.idstore.args * ', '}")
  else
    Log.write_log($import_log, "reaktor_insert: Table: #{row.table_name} No IdStore object")
  end
  query = "INSERT INTO #{row.table_name} (#{row.get_column_name_string})\n  VALUES (#{(['?']*row.size).join(', ')})"
  sth = $dbh_ms.prepare(query)
  begin
    sth.execute(*row.get_column_values)
  rescue
    $stderr.puts "### Error in #{__FILE__} on line #{__LINE__}. See errorlog"
    Log.write_log('error', "Could not insert data. Message: #{$!}. query: \"#{get_query_string(sth)}\"")
    raise
    exit
  end
  begin
    insert_id = $dbh_ms.func(:insert_id) unless row.idstore.nil?
  rescue
    $stderr.puts "### Error in #{__FILE__} on line #{__LINE__}. See errorlog"
    Log.write_log('error', "Could not get insert id. Message: #{$!}.")
    raise
    exit
  end
  if insert_id > 0
    row.store_id(insert_id)
    Log.write_log($import_log, "Insert id store to table: #{row.table_name} id_store parameters: (#{row.idstore.args * ', '}) id: #{insert_id}")
  else
    unless row.idstore.nil?
      Log.write_log($import_log, "No id stored for table: #{row.table_name} id_store parameters: (#{row.idstore.args * ', '})")
    else
      Log.write_log($import_log, "No id stored for table: #{row.table_name} No IdStore object")
    end
    
  end
end

def get_query_string(sth)
  return '' if sth.nil?
  eval(sth.inspect[/@result[^\]]*\]/].gsub(/@result=/,'')).to_s
end

#
# find_primary_key
#
# Queries the database (information_schema) to find the primary key
# for a table.
#
def find_primary_key(table)
  query = %q{
    SELECT column_name
      FROM information_schema.table_constraints tc
           INNER JOIN
           information_schema.key_column_usage kcu
           ON tc.constraint_name = kcu.constraint_name
     WHERE constraint_type  = 'PRIMARY KEY'
       AND tc.table_catalog = 'reaktor'
       AND tc.table_schema  = 'public'
       AND tc.table_name    = ?
     ORDER BY ordinal_position;
  }

  sth = $dbh_pg.prepare(query)
  begin
    sth.execute(table.to_s)
  rescue
    $stderr.puts "### Error in #{__FILE__} on line #{__LINE__}. See errorlog"
    Log.write_log('error', "Could not find primary key. Message: #{$!}. query: #{get_query_string(sth)}")
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
# build_query
#
# Generates a query that selects everything from a table ordered by
# the primary key.
#
def build_query(table_name, where_expression)
  query = %Q{SELECT *\n   FROM "#{table_name}"}
  unless where_expression.nil?
    query << "\n  WHERE #{where_expression}"
  end
  unless (pk = find_primary_key(table_name)).empty?
    query << "\n  ORDER BY " << pk.join(', ')
  end
  return query
end
