<?php

/**
 * Unit tests for the id3v1 library
 * 
 * PHP version 5
 * 
 * @author    Kjell-Magne Oierud <kjellm@linpro.no>
 * @copyright 2008 Linpro AS
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 * @version   SVN: $Id: transcoderTest.php 437 2008-03-05 22:30:27Z kjellm $
 */

$test_dir = dirname(__FILE__).'/..';
require $test_dir.'/bootstrap/unit.php';
require_once $test_dir.'/../apps/reaktor/lib/id3v1.class.php';
 
$t  = new lime_test(8, new lime_output_color());

$id3 = new id3v1('test/data/audio-test-3.mp3', true);

$t->is($id3->getTitle(), "Test 3", "Title");
$t->is($id3->getArtist(), "NA", "Title");
$t->is($id3->getAlbum(), "Test album", "Title");
$t->is($id3->getComment(), "Just an aaaaaaaaaaaaaaaaaaa", "Title");
$t->is($id3->getGenre(), "R&B", "Title");
$t->is($id3->getGenreId(), 14, "Title");
$t->is($id3->getYear(), "2008", "Title");
$t->is($id3->getTrack(), "1", "Title");