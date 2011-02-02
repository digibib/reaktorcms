<?php
/**
 * Unit tests for the tag cloud helper.
 *  
 * PHP version 5
 * 
 * @author    Kjell-Magne Øierud <kjellm@linpro.no>
 * @copyright 2008 Linpro AS
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 */

$test_dir = dirname(__FILE__).'/..';

require $test_dir.'/bootstrap/unit.php';
require_once $test_dir.'/../apps/reaktor/lib/helper/cloudHelper.php';
 
////////////////////////////////////////////////////////////////////////////////
// MOCKS

function link_to() {
  return '<a>';
}

//
////////////////////////////////////////////////////////////////////////////////

$t  = new lime_test(1, new lime_output_color());
                             
$tags = array('a' => array('count' => 2), 
              'b' => array('count' => 3));
$t->is(substr_count(tag_cloud_with_count($tags, 'foo'), '<a>'), 2, 'Correct num anchors returned');
