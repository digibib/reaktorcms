<?php

/**
 * Unit tests for the home helper library
 * 
 * PHP version 5
 * 
 * @author    Kjell-Magne Oierud <kjellm@linpro.no>
 * @copyright 2008 Linpro AS
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 * @version   SVN: $Id: homeHelperTest.php 524 2008-03-28 00:58:49Z kjellm $
 */

$test_dir = dirname(__FILE__).'/..';
require $test_dir.'/bootstrap/unit.php';
require_once $test_dir.'/../apps/reaktor/lib/helper/homeHelper.php';

////////////////////////////////////////////////////////////////////////////////
// MOCK

                             
function image_tag() {
  return '<img>';
}

if (!class_exists('sfConfig')) {
  class sfConfig {
    function get() {
      return 6;
    }
  }
}


////////////////////////////////////////////////////////////////////////////////

$t  = new lime_test(1, new lime_output_color());

$t->is(substr_count(showScore(4), '<img>'), 4, 'Correct num images returned');
