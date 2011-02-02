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
require 'id_store'

require 'plugin'
require 'artwork_data_plugin'

#
# Test stubs
#
class ArtworkDataPlugin < Plugin
  def get_user_id(id)
    return id
  end
end

class KeyMap
  def self.get_new_primary_key(old_table, old_pk)
    return {old_table => old_pk}
  end
end

#
# Test case
#
class TC_ArtworkDataPlugin < Test::Unit::TestCase
  
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
    Log.remove(ArtworkDataPlugin.log_name)
    
    query = 'SELECT * FROM artwork'
    sth = $dbh_pg.execute(query)

    while row = sth.fetch
      ArtworkDataPlugin.new('data', row)
    end
    
    ArtworkDataPlugin.flush_logs
    Log.test_regression(ArtworkDataPlugin.log_name)
    ArtworkDataPlugin.write_report
    IdStore.write_report
  end
  
  def teardown
  end
end
