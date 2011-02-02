# 
# To change this template, choose Tools | Templates
# and open the template in the editor.
 

$:.unshift File.join(File.dirname(__FILE__),'..','lib')

require 'test/unit'
require 'dbi'
require 'pp'
require 'filter'
require 'log'
require 'mapping'

class TC_Filter < Test::Unit::TestCase

  def setup
    $dbh_pg = DBI.connect("dbi:Pg:reaktor:", "", "") unless $dbh_pg
    unless $dbh_ms
      $dbh_ms = DBI.connect("dbi:Mysql:reaktor_imp:", "", "")
      $dbh_ms.do("SET sql_mode='TRADITIONAL,ANSI'")
      $dbh_ms.do("SET NAMES 'utf8'")
    end
  end
  
  def test_invert
    f = Filter.invert
    assert_equal(f.call(nil, nil), true)
    assert_equal(f.call(true, nil), false)
  end
  
  def test_boolean_to_integer
    f = Filter.boolean_to_integer
    assert(f.call('t', nil) == 1)
    assert(f.call('f', nil) == 0)
  end
  
  def test_upcase
    f = Filter.upcase
    assert_equal('HEI', f.call('hei', nil))
  end
  
  def test_downcase
    f = Filter.downcase
    assert_equal('hei', f.call('HEI', nil))
  end
  
  def test_if_null
    def Filter.testcase
      lambda do |value, row|
        return 'testcase'
      end
    end
    f = Filter.if_null(Filter.testcase)
    assert(f.call(nil, nil) == 'testcase')
    assert(f.call(true, nil))
  end
  
  def test_set_value
    f1 = Filter.set_value('testcase')
    assert_equal('testcase', f1.call(nil, {'testcase' => 'Ruby'}))
    f2 = Filter.set_value('%testcase')
    assert_equal('Ruby', f2.call(nil, {'testcase' => 'Ruby'}))
  end
  
  def test_add_prefix
    f = Filter.add_prefix('testcase_')
    assert(f.call('ruby', nil) == 'testcase_ruby')
  end
  
  def test_add_postfix
    f = Filter.add_postfix('_testcase')
    assert(f.call('ruby', nil) == 'ruby_testcase')
  end
  
  def test_truncate_from
    f = Filter.truncate_from('ruby')
    assert(f.call('testcase_ruby', nil) == 'testcase_')
  end
  
  def test_override_if
    f = Filter.override_if('ruby', 'testcase')
    assert(f.call('robert', {'ruby' => 'is cool'}) == 'testcase')
  end
  
  def test_default_if_null
    f = Filter.default_if_null('default')
    assert(f.call(nil, nil) == 'default')
    assert(f.call('ruby', nil) == 'ruby')
  end
  
  def test_domain_value_to_id
    f = Filter.domain_value_to_id('sf_guard_user', 'username')
    assert_equal(1, f.call('admin', nil))
  end
  
  def test_get_value_from_db
    f = Filter.get_value_from_db($dbh_pg, 'reaktoruser', 'id', 'nick')
    assert(f.call(13645, nil) == 'arneska')
  end
  
  def test_truncate
    f1 = Filter.truncate(15)
    f2 = Filter.truncate(15, '')
    short_string = 'robert strind'
    log_string = 'robert strind robert strind'
    assert_equal(short_string, f1.call(short_string, nil))
    assert_equal('robert strin...', f1.call(log_string, nil))
    assert_equal(short_string, f2.call(short_string, nil))
    assert_equal('robert strind r', f2.call(log_string, nil))
  end
  
  def test_apply_map
    map = {:ruby => :robert}
    f = Filter.apply_map(map)
    assert(f.call(:ruby, nil) == :robert)
  end
  
  def test_extract_filename
    f = Filter.extract_filename
    data = %q{#.(make-instance 'file::image-jpeg :filename "FD0CDDFB906081693CF628AE0E53DA85D3AF8E02E2A9A27D165381507A2C0078.jpg" :filesize 585585 :permanent T :sizex 1600 :sizey 1200)}
    assert(f.call(data, nil) == 'FD0CDDFB906081693CF628AE0E53DA85D3AF8E02E2A9A27D165381507A2C0078.jpg')
  end
  
  def test_trim_lisp_encl_params
    f = Filter.trim_lisp_encl_params
    data = %q{("Arrangeres det turer til dette stedet? :)")}
    assert(f.call(data, nil) == 'Arrangeres det turer til dette stedet? :)')
  end
  
  def test_parse_artwork_description
    f = Filter.parse_artwork_description
    data = <<EOF
#.(make-instance 'richtext::richtext-simple :parsed-text '("Side om Lars Ramslie på " (:HREF "http://www.litteraturnettet.no/r/ramslie.lars.asp" "Litteraturnettet") :P "<b>Ramslies bøker:</b>\r
 <p>\r
 " (:HREF "http://www.deich.folkebibl.no/cgi-bin/websok?ccl=Ramslie,+Lars%2ffo&st=ccl&sortering=aar" "Lån bøkene i Oslo") "<br>\r
 " (:HREF "http://www.trondheim.folkebibl.no/cgi-bin/websok?ccl=Ramslie,+Lars%2ffo&st=ccl&sortering=aar" "Lån bøkene i Trondheim") "\r
 </p>" :P "<b>Ramslies anbefalinger:</b>\r
 <p>\r
 Hunter S. Thompson. <i>Frykt og avsky i Las Vegas</i><br>\r
 " (:HREF "http://www.deich.folkebibl.no/cgi-bin/websok?mode=p&tnr=364236&st=p" "Lån boka i Oslo") "<br>\r
 " (:HREF "http://www.trondheim.folkebibl.no/cgi-bin/websok?mode=p&tnr=142215&st=p" "Lån boka i Trondheim") "\r
 </p>\r
 <p>\r
 William Burroughs. <i>Naken Lunsj</i><br>\r
 " (:HREF "http://www.deich.folkebibl.no/cgi-bin/websok?mode=p&tnr=193086&st=p" "Lån boka i Oslo") "<br>\r
 " (:HREF "http://www.trondheim.folkebibl.no/cgi-bin/websok?mode=p&tnr=105684&st=p" "\r
 Lån boka i Trondheim") "\r
 </p>\r
 <p>\r
 Ingvar Ambjørnsen. <i>Jesus står i porten</i><br>\r
 " (:HREF "http://www.deich.folkebibl.no/cgi-bin/websok?mode=p&tnr=242632&st=p" "Lån boka i Oslo") "<br>\r
 " (:HREF "http://www.trondheim.folkebibl.no/cgi-bin/websok?mode=p&tnr=87571&st=p" "Lån boka i Trondheim") "\r
 </p>" :P "<p>\r
 Dalton Trumbo. <i>Jonny got his gun</i><br>\r
 " (:HREF "http://www.deich.folkebibl.no/cgi-bin/websok?mode=p&tnr=219074&st=p" "Lån boka i Oslo") "<br>\r
 " (:HREF "http://www.trondheim.folkebibl.no/cgi-bin/websok?mode=p&tnr=19076&st=p" "Lån boka i Trondheim") "\r
 </p>"))
EOF
    new_data = <<EOF
Side om Lars Ramslie på <a href="http://www.litteraturnettet.no/r/ramslie.lars.asp">Litteraturnettet</a><b>Ramslies bøker:</b>
 <p>
 <a href="http://www.deich.folkebibl.no/cgi-bin/websok?ccl=Ramslie,+Lars%2ffo&st=ccl&sortering=aar">Lån bøkene i Oslo</a><br>
 <a href="http://www.trondheim.folkebibl.no/cgi-bin/websok?ccl=Ramslie,+Lars%2ffo&st=ccl&sortering=aar">Lån bøkene i Trondheim</a>
 </p><b>Ramslies anbefalinger:</b>
 <p>
 Hunter S. Thompson. <i>Frykt og avsky i Las Vegas</i><br>
 <a href="http://www.deich.folkebibl.no/cgi-bin/websok?mode=p&tnr=364236&st=p">Lån boka i Oslo</a><br>
 <a href="http://www.trondheim.folkebibl.no/cgi-bin/websok?mode=p&tnr=142215&st=p">Lån boka i Trondheim</a>
 </p>
 <p>
 William Burroughs. <i>Naken Lunsj</i><br>
 <a href="http://www.deich.folkebibl.no/cgi-bin/websok?mode=p&tnr=193086&st=p">Lån boka i Oslo</a><br>
 <a href="http://www.trondheim.folkebibl.no/cgi-bin/websok?mode=p&tnr=105684&st=p">
 Lån boka i Trondheim</a>
 </p>
 <p>
 Ingvar Ambjørnsen. <i>Jesus står i porten</i><br>
 <a href="http://www.deich.folkebibl.no/cgi-bin/websok?mode=p&tnr=242632&st=p">Lån boka i Oslo</a><br>
 <a href="http://www.trondheim.folkebibl.no/cgi-bin/websok?mode=p&tnr=87571&st=p">Lån boka i Trondheim</a>
 </p><p>
 Dalton Trumbo. <i>Jonny got his gun</i><br>
 <a href="http://www.deich.folkebibl.no/cgi-bin/websok?mode=p&tnr=219074&st=p">Lån boka i Oslo</a><br>
 <a href="http://www.trondheim.folkebibl.no/cgi-bin/websok?mode=p&tnr=19076&st=p">Lån boka i Trondheim</a>
 </p>
EOF
    puts f.call(data, nil)
    assert(f.call(data, nil) == new_data)
  end
end
