# 
# To change this template, choose Tools | Templates
# and open the template in the editor.
 

$:.unshift File.join(File.dirname(__FILE__),'..','plugins')
$:.unshift File.join(File.dirname(__FILE__),'..','lib')

require 'dbi'
require 'test/unit'
require 'pp'

require 'log'
require 'domain_maps'
require 'mapping'
require 'key_map'
require 'insert_row'
require 'id_store'

require 'plugin'
require 'reaktoruser_site_plugin'

class TC_ReaktoruserSitePlugin < Test::Unit::TestCase
  
  def setup
    $dbh_pg = DBI.connect("dbi:Pg:reaktor:", "", "") unless $dbh_pg
    unless $dbh_ms
      $dbh_ms = DBI.connect("dbi:Mysql:reaktor_imp:", "", "")
      $dbh_ms.do("SET sql_mode='TRADITIONAL,ANSI'")
      $dbh_ms.do("SET NAMES 'utf8'")
    end
  end
  
  #
  # Import all records from artwork table and test regression
  #
  def test_import
    ReaktoruserSitePlugin.drop_db_table
    IdStore.drop_db_table
    Log.remove(ReaktoruserSitePlugin.log_name)
    
    IdStore.new('site', '3960').store(1)
    IdStore.new('site', '393').store(2)
    IdStore.new('site', '4421').store(3)
    IdStore.new('site', '4').store(4)
    IdStore.new('site', '1397').store(5)

    query = 'SELECT * FROM reaktoruser'
    sth = $dbh_pg.execute(query)
    while row = sth.fetch
      ReaktoruserSitePlugin.new('site', row)
    end
    
    ReaktoruserSitePlugin.flush_logs
    Log.test_regression(ReaktoruserSitePlugin.log_name)
    ReaktoruserSitePlugin.write_report
    IdStore.write_report
  end
end
