<?php
/**
 * Test script for Upload actions
 * 
 * Covers:
 *  Submitting empty field
 *  Database creation of upload
 *  Correct messages when linking to existing
 *  Logged in status
 * 
 * Does not cover:
 *  Verifying the transcoding process (if applicable)
 *  Client side validation
 * 
 * PHP version 5
 * 
 * @author    Russ Flynn <russ@linpro.no>
 * @copyright 2008 Linpro AS
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 */

include(dirname(__FILE__).'/../../bootstrap/functional.php');

// create a new test browser
$b = new reaktorTestBrowser();
$b->initialize();


$b->get("/en/upload");

$b->isStatusCode(200);
$b->isRequestParameter('module', 'upload');
$b->isRequestParameter('action', 'upload');

//We should be presented with a login message, since this page is only ever for logged in users
$b->checkResponseElement("div#content_main", "*You need to log in*");



//Lets log in - this user should always exist in test db
$b->setField('password', 'admin');
$b->setField('username', 'admin');
$b->click('Sign in');
$b->followRedirect();

//Now we should be presented with the file dialogue, if login went well
$b->checkResponseElement("div#content_main", "*Step 1: File upload*");

// Lets try going here via a generated link for linking a file to artwork
// First we need to get a specific artwork, just in case primary keys are changing due to repeated fixtures loading
$c = new Criteria();
$c->add(ReaktorArtworkPeer::ARTWORK_IDENTIFIER, "image");
$artworkObject = ReaktorArtworkPeer::doSelectOne($c);
$b->get("/en/upload/link/".$artworkObject->getId());

//We should now be expecting an image file to link
$b->checkResponseElement("div#content_main", "*Add file to artwork*");
$b->checkResponseElement("div#content_main", "*Image*");

//Again with audio type
$c = new Criteria();
$c->add(ReaktorArtworkPeer::ARTWORK_IDENTIFIER, "audio");
$artworkObject = ReaktorArtworkPeer::doSelectOne($c);
$b->get("/en/upload/link/".$artworkObject->getId());

//We should now be expecting an image file to link
$b->checkResponseElement("div#content_main", "*Add file to artwork*");
$b->checkResponseElement("div#content_main", "*Audio*");

//Now with video type
$c = new Criteria();
$c->add(ReaktorArtworkPeer::ARTWORK_IDENTIFIER, "video");
$artworkObject = ReaktorArtworkPeer::doSelectOne($c);
$b->get("/en/upload/link/".$artworkObject->getId());

//We should now be expecting an image file to link
$b->checkResponseElement("div#content_main", "*Add file to artwork*");
$b->checkResponseElement("div#content_main", "*Video*");

//Now with text type
$c = new Criteria();
$c->add(ReaktorArtworkPeer::ARTWORK_IDENTIFIER, "text");
$artworkObject = ReaktorArtworkPeer::doSelectOne($c);
$b->get("/en/upload/link/".$artworkObject->getId());

//We should now be expecting an image file to link
$b->checkResponseElement("div#content_main", "*Add file to artwork*");
$b->checkResponseElement("div#content_main", "*Text*");

//Finally with pdf type
$c = new Criteria();
$c->add(ReaktorArtworkPeer::ARTWORK_IDENTIFIER, "pdf");
$artworkObject = ReaktorArtworkPeer::doSelectOne($c);
$b->get("/en/upload/link/".$artworkObject->getId());

//We should now be expecting an image file to link
$b->checkResponseElement("div#content_main", "*Add file to artwork*");
$b->checkResponseElement("div#content_main", "*Pdf*");

/*
// ZOID: File uploads not supported, however there is a patch, and they will be in 1.1
// Now lets add a file of the wrong mime type for this link
//$b->setField("file", sfConfig::get("sf_test_dir")."/data/audio-test-1.wav");
//echo "trying: ".sfConfig::get("sf_test_dir")."/data/audio-test-1.wav\n";
//$b->click("Add");
//$b->checkResponseElement("div#content_main", "*Wrong file type*");
*/

