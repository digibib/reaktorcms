#!/usr/bin/env ruby
#
# = Synopsis 
#
# This is the test suite that does all the tests
#
# = Author
#
# - Robert Strind mailto:robert@linpro.no
#
# = Version
#
# $Id:$
#

require 'test/unit'

puts "Removing old logs..."
`rm -f log/*.log`

# Add your testcases here
require 'test/t_c_filter'
#require 'test/t_c_id_store'
#require 'test/t_c_reaktoruser_artworkgroups_plugin'
#require 'test/t_c_artwork_data_plugin'
#require 'test/t_c_reaktoruser_image_plugin'
#require 'test/t_c_reaktoruser_type_plugin'
#require 'test/t_c_reaktoruser_site_plugin'
#require 'test/t_c_artwork_internal_discussion_plugin'
