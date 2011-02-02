#
# = Synopsis 
#
# Reaktoruser site plugin
#
# = Author
#
# - Robert Strind mailto:robert@linpro.no
#
# = Version
#
# $Id:$
#

class ReaktoruserSitePlugin < Plugin
  @@totals = {
    :saved => 0, # Total number of rows parsed
  }
  @@table_name = :sf_guard_user_group
  @@log_name = :reaktoruser_site_plugin
  @@report_name = 'report'
  
  def self.report_name
    @@report_name
  end
  
  def self.log_name
    @@log_name
  end

  #
  # Create transit table
  # 
  def self.create_db_table
    unless $dbh_pg.execute("SELECT relname FROM pg_class WHERE relname = '#{@@table_name}'").fetch
      query = %Q{
              CREATE TABLE #{@@table_name} (
                user_id integer NOT NULL,
                group_id integer NOT NULL
              )}
      $dbh_pg.execute(query)
      Log.write_log(@@log_name, "Created transit table: #{@@table_name}")
    end
  end
  
  #
  # Drop transit table
  #
  def self.drop_db_table
    if $dbh_pg.execute("SELECT relname FROM pg_class WHERE relname = '#{@@table_name}'").fetch
      $dbh_pg.execute("DROP TABLE #{@@table_name}")
      Log.write_log(@@log_name, "Dropped transit table: #{@@table_name}")
    end
  end
  
  attr_reader :result

  def initialize(attr_name, row)
    return [] unless row[attr_name]
    ReaktoruserSitePlugin.create_db_table
    query = %Q{INSERT INTO #{@@table_name} (user_id, group_id) VALUES (?, ?)}
    sf_guard_group_id = IdStore.get('site', row[attr_name])
    $dbh_pg.prepare(query).execute(row['id'], sf_guard_group_id)
    Log.write_log(@@log_name, "Saved relation #{row['id']}, #{sf_guard_group_id}")
    @@totals[:saved] += 1
  end
  
  def each
    IGNORE
  end
  
  def self.flush_logs
    Log.flush_log(@@report_name)
    Log.flush_log(@@log_name)
  end
  
  def self.write_report
    Log.write_log(@@report_name, "ReaktoruserSitePlugin:")
    Log.write_log(@@report_name, "\t#{@@totals[:saved]} total number of saved group relations")
    Log.write_log(@@report_name, "\trelations saved to postreSQL table: #{@@table_name}")
    Log.flush_log(@@report_name)
  end
end
