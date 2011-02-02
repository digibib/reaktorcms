# 
# Run tests on IdStore class
#
$:.unshift File.join(File.dirname(__FILE__),'..','lib')

require 'test/unit'
require 'dbi'
require 'id_store'
require 'log'

class TC_IdStore < Test::Unit::TestCase

  def setup
    $dbh_pg = DBI.connect("dbi:Pg:reaktor:", "", "") unless $dbh_pg
    IdStore.drop_db_table
  end

  def test_store_get
    data = 2800670
    robert = IdStore.new('robert', 'strind')
    robert.store(data.to_s)
    assert_equal(data.to_s, robert.get)
  end
  
  def test_store_get_static
    data = 2800670
    IdStore.new('robert', 'strind').store(data.to_s)
    assert_equal(data.to_s, IdStore.get('robert', 'strind'))
  end
  
  def test_store_get_datatypes
    key = [:ruby, 'testcase', 280670]
    data = 2800670
    IdStore.new(*key).store(data)
    assert_equal(data.to_s, IdStore.get(*key))
  end
  
  def test_store_mixed_datatypes
    key = ['280670', 280670]
    data = 2800670
    IdStore.new(*key).store(data)
    assert_equal(data.to_s, IdStore.get(*key.reverse))
  end
end
