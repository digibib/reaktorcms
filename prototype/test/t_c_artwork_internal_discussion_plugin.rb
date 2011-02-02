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
require 'id_store'

require 'plugin'
require 'artwork_internal_discussion_plugin'

class IdStore
  def self.get(*args)
    1
  end
end

class TC_ArtworkInternalDiscussionPlugin < Test::Unit::TestCase

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
    Log.remove(ArtworkInternalDiscussionPlugin.log_name)
    
    query = 'SELECT * FROM artwork'
    sth = $dbh_pg.execute(query)

    while row = sth.fetch
      ArtworkInternalDiscussionPlugin.new('internal_discussion', row)
    end
    
    ArtworkInternalDiscussionPlugin.flush_logs
    #Log.test_regression(ArtworkInternalDiscussionPlugin.log_name) TODO: regression test?
    ArtworkInternalDiscussionPlugin.write_report
    IdStore.write_report
  end
  
  def teardown
  end
end
