<?php

/**
 * Unit tests for the videoFrame library
 * 
 * PHP version 5
 * 
 * @author    Kjell-Magne Oierud <kjellm@linpro.no>
 * @copyright 2008 Linpro AS
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 * @version   SVN: $Id: videoFrameTest.php 675 2008-04-16 20:07:25Z kjellm $
 */

$test_dir = dirname(__FILE__).'/..';

require_once $test_dir.'/../apps/reaktor/lib/videoFrame.class.php';
require $test_dir.'/bootstrap/unit.php';

$t  = new lime_test(3, new lime_output_color());
                             
try 
{
  $vf = videoFrame::fromVideoFile('/this/file/does/really_unlikely/exist');
  $t->fail("File not found should result in an Exception");
}
catch (Exception $e)
{
  $t->pass("File not found should result in an Exception");
}

$vf = videoFrame::fromVideoFile($test_dir.'/data/video-test-1.avi');
$t->is(strlen($vf->getContent()), 32498);
$t->is(md5($vf->getContent()), '0cdd2f777e6207e3ad2c23a1cac2c1e0');
$t->is($vf->getMime(), 'image/jpeg');
