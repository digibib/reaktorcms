#
# = Synopsis 
#
# This class stores a value in the database with an index based on the md5
# key calculated from concatenated argument strings. The imigration algorithm
# uses this class to make available primary key ids that are generated when
# inserting data to the database.
#
# = Author
#
# - Robert Strind mailto:robert@linpro.no
#
# = Version
#
# $Id:$
#
require 'digest/md5'

class IdStore
  
  @@table_name = 'id_store'
  @@create_table = true
  @@num_ids = 0
  @@report_name = 'report'
  @@log_name = 'id_store'
  
  attr_reader :hash, :value, :args
  
  def self.create_db_table
    unless $dbh_pg.execute("SELECT relname FROM pg_class WHERE relname = '#{@@table_name}'").fetch
      $dbh_pg.execute(%Q{
          CREATE TABLE #{@@table_name} (
            id text NOT NULL PRIMARY KEY,
            value text NOT NULL
          )
        })
    end
    @@create_table = nil
  end
  
  def self.drop_db_table
    unless $dbh_pg.execute("SELECT relname FROM pg_class WHERE relname = '#{@@table_name}'").fetch.nil?
      $dbh_pg.execute(%Q{DROP TABLE #{@@table_name}})
    end
    @@create_table = true
  end
  
  def self.make_hash(*args)
    Digest::MD5.hexdigest(args * '')
  end
  
  def self.get(*args)
    hash = self.make_hash(args * '')
    query = %Q{
              SELECT value
              FROM #{@@table_name}
              WHERE id = '#{hash}'}
    begin
      sth = $dbh_pg.execute(query).fetch
    rescue
      $stderr.puts "### Error in #{__FILE__} on line #{__LINE__}. See errorlog"
      Log.write_log('error', "Could not select id. Message: #{$!}. query: \"#{get_query_string(sth)}\"")
      raise
      exit
    end
    unless sth
      STDERR.puts "IdStore::get(#{args * ','}) No value in database for hash: #{hash}"
      raise
    else
      return sth[0]
    end
  end

  def initialize(*args)
    @value = nil
    @args = args
    if @@create_table
      IdStore.create_db_table
    end
    @hash = self.make_hash(args * '')
    raise "Hash id allready exist in database: #{@hash}" unless unique_hash
  end
  
  def make_hash(*args)
    Digest::MD5.hexdigest(args * '')
  end
  
  def unique_hash
    begin
      r = $dbh_pg.execute(%Q{SELECT * from id_store WHERE id = '#{@hash}'}).fetch
    rescue
      $stderr.puts "### Error in #{__FILE__} on line #{__LINE__}. See errorlog"
      Log.write_log('error', "Could not select id. Message: #{$!}. query: \"#{get_query_string(sth)}\"")
      raise
      exit
    end
    return true unless r
    return nil
  end
  
  def inspect
    "#<IdStore (hash: #{@hash}, args: (#{args * ','}) value: #{@value})>"
  end
  
  def store(value)
    raise "Value has allready been set. id = #{@hash} value = #{@value}" unless @value.nil?
    query = %Q{INSERT INTO #{@@table_name} (id, value) VALUES ('#{@hash}', '#{value}')}
    begin
      $dbh_pg.execute(query)
    rescue
      $stderr.puts "### Error in #{__FILE__} on line #{__LINE__}. See errorlog."
      Log.write_log('error', "Could not insert new record. Message: #{$!} Query: #{query}")
    end
    @value = value
    @@num_ids += 1
    Log.write_log(@@log_name, "Stored #{@hash} args: (#{args * ','}) value: #{@value}")
  end
  
  def get
    unless @value
      raise "Value has not been set for hash: #{@hash}"
      return nil
    end
    return @value
  end
  
  def self.flush_logs
    Log.flush_log(@@report_name)
    Log.flush_log(@@log_name)
  end
  
  def self.write_report
    Log.write_log(@@report_name, "IdStore:")
    Log.write_log(@@report_name, "\t#{@@num_ids} total number of ids stored")
  end
end
