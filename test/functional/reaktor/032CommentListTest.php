<?php
/**
 * Functional test for comment listing by date/user
 * Also tests pagination to an extent, may break after some tweaking is done to this
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

// Try to be here without specifying a file
$b->get("/no/admin/list/comments/user/3"); 
$b->isStatusCode(404);
$b->isRequestParameter('module', 'sfComment');
$b->isRequestParameter('action', 'listComments');

//We should be presented with a login message, since this page is only ever for logged in users
$b->checkResponseElement("div#content_main", "*the page or content that you have requested does not exist*");

//Lets log in as the wrong user - this user should always exist in test db, and is not admin
$b->setField('password', 'monkeyboy');
$b->setField('username', 'monkeyboy');
$b->click('Sign in');
$b->isRedirected()->followRedirect();

$b->checkResponseElement("div#content_main", "*you do not have the required permissions to access this content*");

// Ok, so we need to log out and log in again as an admin user
$b->click('Log out');
$b->isRedirected()->followRedirect();
$b->setField('password', 'admin');
$b->setField('username', 'admin');
$b->click('Sign in');
$b->isRedirected()->followRedirect();

$thisUser = sfGuardUserPeer::retrieveByPK(3);

// Lets make sure we have enough comments for the test (to test pagination)
$testComments = array(
  array("title" => "Random comment 1", "text" => "Random text 1\nsdvwevbewåvøæøå\ngmkls", "created" => "2007-03-01"),
  array("title" => "Random comment 2", "text" => "Random text 2\n\nkvnsdkdåødsøvåøsdv", "created" => "2007-04-24"),
  array("title" => "Random comment 3", "text" => "Random text 3\nvdvdsvdæv'æ'æåsdøvæ", "created" => "2007-04-24"),
  array("title" => "Random comment 4", "text" => "Random text 4\n\n\nddsvæ'dvslpøøåøsdv2345678%&/(", "created" => "2007-01-01"),
  array("title" => "Random comment 5", "text" => "Random text 5\nmoo moo moo moo moo moo moo", "created" => "2007-04-01")
  );

foreach ($testComments as $commentArray)
{
  $myComment = new sfComment();
  $myComment->setTitle($commentArray["title"]);
  $myComment->setText($commentArray["text"]);
  $myComment->setAuthorId(3);
  $myComment->setNamespace("frontend");
  $myComment->setCommentableModel("ReaktorArtwork");
  $myComment->setCommentableId(3);
  $myComment->setCreatedAt($commentArray["created"]);
  $myComment->save();
}
  
// Ok, let's get all this user's comments
$c = new Criteria();
$c->add(sfCommentPeer::AUTHOR_ID, 3);
$c->addDescendingOrderByColumn(sfCommentPeer::CREATED_AT);
$c->addDescendingOrderByColumn(sfCommentPeer::ID);
$comments = sfCommentPeer::doSelect($c);

// Lets force a low pagination so we know that it will paginate
sfConfig::set("app_admin_commentlistmax", 3);

$b->get("/no/admin/list/comments/user/3"); 
$b->checkResponseElement("div#content_main", "*Comments made by ".$thisUser->getUsername()."*");

// Check for pagination
$b->ResponseContains("/admin/list/comments/user/3/page/2");

// Check for latest comment on this page
$b->checkResponseElement("div#content_main", "*".$comments[0]->getTitle()."*");

// Check that the first comment is not on this page, since it should be paginated
$b->checkResponseElement("div#content_main", "!*".$comments[count($comments) - 1]->getTitle()."*");

// Now lets click the last page link and test for that comment again...
$b->click("Last");
$b->checkResponseElement("div#content_main", "*".$comments[count($comments) - 1]->getTitle()."*");

// Right, all good so far - lets try the date functionality
$b->get("/no/admin/comments");

// Should show the current month since we didn't specify one
$b->checkResponseElement("div#content_main", "*Comments made in ".date("F")."*");
#echo "This month: ".date("F");

$nextMonth = date("F", mktime(0, 0, 0, date("m")+1, date("d"),   date("Y")));

// Click the next month and check it is being displayed
$b->click($nextMonth);
//echo "Next month: ".$nextMonth;

$b->checkResponseElement("div#content_main", "*Comments made in ".$nextMonth."*");

// Ok we made some comments above, most were in April 2007 so lets go there
$b->get("/no/admin/comments/date/2007-04-01");
$b->checkResponseElement("div#content_main", "*Comments made in April*");

// There should be a clickable number of comments on April 24th... might be some more in fixtures so best check
// We can't really click it, since it's a number and might be repeated elsewhere in the calendar
$c = new Criteria();
$c->add(sfCommentPeer::CREATED_AT, "created_at LIKE '2007-04-24%'", Criteria::CUSTOM);
$countOn24 = sfCommentPeer::doCount($c);

//echo "Comment count on 24th April: [ ".$countOn24." ]";

// We should be able to click a link which matches the above count, lets just check it exists
$b->responseContains('admin/list/comments/date/2007-04-24">'.$countOn24.'</a>');

// Now we know it's there, let's emulate the click - since we want to make sure we are going to the right place
$b->get("/no/admin/list/comments/date/2007-04-24");
$b->isStatusCode();
$b->isRequestParameter('module', 'admin');
$b->isRequestParameter('action', 'listComments');

$b->checkResponseElement("div#content_main", "*Comments made on 24/04/2007*");

// We've already tested comment display and pagination which uses the same engine, 
// so lets just check the change date link and be done with it

$b->click("change date");
$b->checkResponseElement("div#content_main", "*Comments made in ".date("F")."*");
