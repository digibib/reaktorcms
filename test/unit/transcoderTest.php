<?php

/**
 * Unit tests for the transcoder library
 * 
 * PHP version 5
 * 
 * @author    Kjell-Magne Oierud <kjellm@linpro.no>
 * @copyright 2008 Linpro AS
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 * @version   SVN: $Id: transcoderTest.php 558 2008-04-03 01:18:56Z kjellm $
 */

/* We seem to be running inside a function, so I need to register
 * these as globals (Hope that doesn't brake anything ...)) */
global $tmp_dir, $test_dir, $t, $tc;

$test_dir = dirname(__FILE__).'/..';
$tmp_dir  = $test_dir.'/tmp-transcoder';

require $test_dir.'/bootstrap/unit.php';
require_once $test_dir.'/../apps/reaktor/lib/transcoder.class.php';
 
$t  = new lime_test(27, new lime_output_color());

exec("rm -rf $tmp_dir");
mkdir($tmp_dir);
mkdir($tmp_dir.'/audio');
mkdir($tmp_dir.'/video');

$tc = new transcoder($tmp_dir.'/');

////////////////////////////////////////////////////////////////////////////////

$t->diag('transcode() error handling');
try 
{
  $tc->transcode('this file should not exist!', '/tmp');
  $t->fail('File not found throws exception');
} 
catch (Exception $e) 
{
  $t->pass('File not found throws exception');
}

try 
{
  touch($tmp_dir .'/empty');
  $tc->transcode($tmp_dir .'/empty', '/tmp');
  $t->fail('Empty file throws exception');
} 
catch (Exception $e) 
{
  $t->pass('Empty file throws exception');
}

try 
{
  $tc->transcode(__FILE__, '/tmp');
  $t->fail('Trying to transcode a text file');
} 
catch (Exception $e) 
{
  $t->pass('Trying to transcode a text file');
}



////////////////////////////////////////////////////////////////////////////////

function test_video($comment, $filename, $expected_filesize) {
  global $tmp_dir, $test_dir, $t, $tc;

  $basename = substr($filename, 0, strrpos($filename, '.'));

  $t->diag($comment);
  /* The MD5 approach does not work in this case, since a timestamp gets
   * embeded in the flv.  Testing on filesize instead. */
  $ret = $tc->transcode($test_dir.'/data/'.$filename, $filename);
  $t->is(filesize($tmp_dir.'/video/'.$basename.'.flv'), 
         $expected_filesize, 
         'flv filesize matches');
  $t->is($ret['newFileName'], $basename.'.flv', 'Returned filename');
  $t->is($ret['convertedMime'], 'video/flv', 'Returned mime type');
}


test_video('Video - AVI', 'video-test-1.avi', 144989);
test_video('Video - OGG/Theora', 'video-test-2.ogg', 152358);
test_video('Video - FLV', 'video-test-3.flv', 144989);
test_video('Video - WMV', 'video-test-4.wmv', 143608);


function test_audio($comment, $filename, $expected_md5sum) {
  global $tmp_dir, $test_dir, $t, $tc;

  $basename = substr($filename, 0, strrpos($filename, '.'));

  $t->diag($comment);
  $ret = $tc->transcode($test_dir.'/data/'.$filename, $filename);
  $t->is(md5_file($tmp_dir.'/audio/'.$basename.'.mp3'), $expected_md5sum, 
         'Conversion to mp3, MD5 matches');
  $t->is($ret['newFileName'], $basename.'.mp3', 'Returned filename');
  $t->is($ret['convertedMime'], 'audio/mpeg', 'Returned mime type');

}

test_audio('Audio - WAV', 'audio-test-1.wav', '1eec95a85007dfb0d9529de9dc3a5d58');
test_audio('Audio - OGG/Vorbis', 'audio-test-2.ogg', '991f8cceeff61b44cee5b687bd70d494');
test_audio('Audio - MP3', 'audio-test-3.mp3', '6d97d184bfba72e0a18e117ff62e1641');
test_audio('Audio - MIDI', 'audio-test-4.mid', '0778b9c3b16871354ada59b983def3ff');

