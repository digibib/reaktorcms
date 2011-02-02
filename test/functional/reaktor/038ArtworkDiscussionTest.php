<?php
/**
 * Test script for Artwork discussion
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

// View the list of artworks under discussion
$b->get("/no/admin/listDiscussion");
$b->isStatusCode();
$b->isRequestParameter('module', 'admin');
$b->isRequestParameter('action', 'listDiscussion');

//We should be presented with a login message, since this page is only ever for logged in users
$b->checkResponseElement("div#content_main", "*You need to log in*");

//Lets log in as a non admin user - this user should always exist in test db
$b->setField('password', 'userboy');
$b->setField('username', 'userboy');
$b->click('Sign in');
$b->isRedirected()->followRedirect();

// Userboy should not be trying to look at this page
$b->checkResponseElement("div#content_main", "*You don't have the requested*");

// Try with admin
$b->click('Log out');
$b->get("/no/admin/listDiscussion");

$b->setField('password', 'admin');
$b->setField('username', 'admin');
$b->click('Sign in');
$b->isRedirected()->followRedirect();

$b->isStatusCode();
$b->isRequestParameter('module', 'admin');
$b->isRequestParameter('action', 'listDiscussion');

// Now we should be looking at the edit page
$b->checkResponseElement("div#content_main", "*Under discussion*");

// Lets get something from the database that is under discussion
$c = new Criteria();
$c->add(ReaktorArtworkPeer::UNDER_DISCUSSION, 1);

$underDiscussion = ReaktorArtworkPeer::doSelect($c);
if ($underDiscussion)
{
  $discussedObject = $underDiscussion[0];
}
else
{
  echo "Nothing to test! Following tests will fail. Check fixtures for at least one object for discussion";
}

// We should see info about the object under discussion
$b->checkResponseElement("div#content_main", "*".$discussedObject->getTitle()."*");
$b->responseContains(url_for("@show_discussion?type=artwork&id=".$discussedObject->getId()."&title=".$discussedObject->getTitle()));

// Lets click the link and take a look then
$b->get(url_for("@show_discussion?type=artwork&id=".$discussedObject->getId()."&title=".$discussedObject->getTitle()));
// Check we can see the comments
$b->checkResponseElement("div#content_main", "/As a member of editorial staff, you can discuss this artwork/");

/*
 * The comments use Ajax for processing, but also fall back to a standard page post if Javascript is disabled
 * We can test that here, however the Ajax functionality should be tested manually also.
 */

//Lets get a count of comments for this artwork, in case some have been added to fixtures
$c = new Criteria();
$c->add(ReaktorArtworkPeer::ID, $discussedObject->getId());
$c->add(sfCommentPeer::COMMENTABLE_MODEL, "ReaktorArtwork");
$commentCount = sfCommentPeer::doCount($c);
echo "Comment count for this artwork in fixtures is: ".$commentCount."\n";
