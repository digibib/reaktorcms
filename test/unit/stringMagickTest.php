<?php

/**
 * Unit tests for the stringMagick library
 * 
 * PHP version 5
 * 
 * @author    Kjell-Magne Oierud <kjellm@linpro.no>
 * @copyright 2008 Linpro AS
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 * @version   SVN: $Id: stringMagickTest.php 524 2008-03-28 00:58:49Z kjellm $
 */

$test_dir = dirname(__FILE__).'/..';
require $test_dir.'/bootstrap/unit.php';
require_once $test_dir.'/../apps/reaktor/lib/stringMagick.class.php';
 
$t  = new lime_test(4, new lime_output_color());

$t->is(strlen(stringMagick::randomString()), 5, "Default length of random string");
$t->is(strlen(stringMagick::randomString(10)), 10, "Return a string with proper length");

try {
  stringMagick::randomString(-1);
  $t->fail("Exception thrown for negative length");
} catch (Exception $e) {
  $t->pass("Exception thrown for negative length");
}

try {
  stringMagick::randomString("asdfs");
  $t->fail("Exception thrown for non-numeric length");
} catch (Exception $e) {
  $t->pass("Exception thrown for non-numeric length");
}
