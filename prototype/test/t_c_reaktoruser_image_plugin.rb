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
require 'reaktoruser_image_plugin'

class TC_ReaktoruserImagePlugin < Test::Unit::TestCase
  
  def setup
    $dbh_pg = DBI.connect("dbi:Pg:reaktor:", "", "") unless $dbh_pg
  end
  
  #
  # Import all records from artwork table and test regression
  #
  def test_import
    Log.remove(ReaktoruserImagePlugin.log_name)
    
    query = 'SELECT * FROM reaktoruser'
    sth = $dbh_pg.execute(query)

    while row = sth.fetch
      ReaktoruserImagePlugin.new('image', row)
    end

    ReaktoruserImagePlugin.flush_logs
    Log.test_regression(ReaktoruserImagePlugin.log_name)
    ReaktoruserImagePlugin.write_report
  end
end
