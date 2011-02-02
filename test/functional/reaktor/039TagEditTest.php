<?php
/**
 * 
 *
 * PHP Version 5
 *
 * @author    Russ Flynn <russ@linpro.no>
 * @copyright 2008 Linpro AS
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 *
 */

include(dirname(__FILE__).'/../../bootstrap/functional.php');

// create a new test browser
$b = new reaktorTestBrowser();
$b->initialize();

//We can't test a lot, but lets at least test that the tags are appearing correctly

$b->get("/no/upload/edit/1");
$b->isStatusCode();
$b->isRequestParameter('module', 'upload');
$b->isRequestParameter('action', 'edit');

//We should be presented with a login message, since this page is only ever for logged in users
$b->checkResponseElement("div#content_main", "*You need to log in*");

//Lets log in - this user should always exist in test db
$b->setField('password', 'admin');
$b->setField('username', 'admin');
$b->click('Sign in');
$b->followRedirect();

//Now we should be presented with the file dialogue, if login went well
$b->checkResponseElement("div#content_main", "*Modify upload details*");

// Lets get all the tags for this object
// so we can check if they are appearing on the page
// hopefully file 1 will always have some tags! but we'll
// add some later just in case

$thisFile = new artworkFile(1);
$tags     = $thisFile->getTags();

// Lets check they are all displayed in the tag box
foreach($tags as $tag)
{
  $b->checkResponseElement("div#thumbnail_editpage", "*".$tag."*");
}

// And just to be on the safe side to make sure the test is executing correctly
$badTags = array("notatag", "1234567", "1d1d1d1d", "looney looney");
foreach($badTags as $tag)
{
  $b->checkResponseElement("div#thumbnail_editpage", "!*".$tag."*");
}

// Lets add a tag and check for that, just in case there were none
// in the first place
// Since it's an Ajax call we need to do it manually
$thisFile->addTag("randomtag");
$thisFile->save();
$b->get("/no/upload/edit/1");
$b->isStatusCode();
$b->isRequestParameter('module', 'upload');
$b->isRequestParameter('action', 'edit');
$b->checkResponseElement("div#thumbnail_editpage", "*randomtag*");

// We could now test the various functions for deleting/approving but
// Since they are also Ajax calls, they will simply mimic the unit tests
// for these functions - there's really not a lot more I can test.
