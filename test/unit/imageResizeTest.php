<?php

/**
 * Unit tests for the imageResize library
 * 
 * PHP version 5
 * 
 * @author    Kjell-Magne Oierud <kjellm@linpro.no>
 * @copyright 2008 Linpro AS
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 * @version   SVN: $Id: imageResizeTest.php 524 2008-03-28 00:58:49Z kjellm $
 */

$test_dir = dirname(__FILE__).'/..';
require $test_dir.'/bootstrap/unit.php';
require_once $test_dir.'/../apps/reaktor/lib/imageResize.class.php';

$tmp_dir  = $test_dir.'/tmp-imageresize';
exec("rm -rf $tmp_dir");
mkdir($tmp_dir);


$t  = new lime_test(2, new lime_output_color());

$ir = new imageResize('test/data/image-test-1.jpg', $tmp_dir.'/resized.jpg', 100, 100);
$ir->imageWrite();
$t->is(md5($tmp_dir.'/resized.jpg'), '7f3438458c50196c4489f1022cca0011', 'Resized md5 matches');

try {
  $ir = new imageResize(__FILE__, $tmp_dir.'/resized.jpg', 100, 100);
  $t->fail('Trying to resize a text file');
} catch (Exception $e) {
  $t->pass('Trying to resize a text file');
}
