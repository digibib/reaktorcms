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

require 'plugin'
require 'reaktoruser_type_plugin'

class TC_ReaktoruserTypePlugin < Test::Unit::TestCase
  
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
    ReaktoruserTypePlugin.drop_db_table
    Log.remove(ReaktoruserTypePlugin.log_name)
    
    query = 'SELECT * FROM reaktoruser'
    sth = $dbh_pg.execute(query)
    while row = sth.fetch
      ReaktoruserTypePlugin.new('type', row)
    end
    
    ReaktoruserTypePlugin.flush_logs
    Log.test_regression(ReaktoruserTypePlugin.log_name)
    ReaktoruserTypePlugin.write_report
  end
end
