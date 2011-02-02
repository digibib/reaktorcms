<?php

/**
 * Unit tests for the videoFrame library
 * 
 * PHP version 5
 * 
 * @author    Kjell-Magne Oierud <kjellm@linpro.no>
 * @copyright 2008 Linpro AS
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 * @version   SVN: $Id: videoFrameTest.php 524 2008-03-28 00:58:49Z kjellm $
 */

$test_dir = dirname(__FILE__).'/..';

require_once $test_dir.'/../apps/reaktor/lib/videoInfo.class.php';
require $test_dir.'/bootstrap/unit.php';

$t  = new lime_test(2, new lime_output_color());
                             
try 
{
  $vf = videoInfo::videoLength('/this/file/does/really_unlikely/exist');
  $t->fail("File not found should result in an Exception");
}
catch (Exception $e)
{
  $t->pass("File not found should result in an Exception");
}

$len = videoInfo::videoLength($test_dir.'/data/video-test-1.avi');

//FIX Allow for floating point roundinng errors?
$t->is($len, 2.8, "Checking correct length returned"); 
