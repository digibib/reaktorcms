<?php
/**
 * Testing approveArtwork
 * 
 *  
 * PHP version 5
 * 
 * @author    Daniel Andre Eikeland <dae@linpro.no>
 * @copyright 2008 Linpro AS
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 */
 
include(dirname(__FILE__).'/../../bootstrap/functional.php');

// create a new test browser
$b = new reaktorTestBrowser();
$b->initialize();

//check that page doesnt show when not logged in
$b->get('/no/admin/list/unapprovedmyteams');
$b->checkResponseElement('div#content_main', '*You need to log in*');

$b->get('/no/admin/list/unapprovedmyteams');

//Try to log in as a user without the proper credentials
$b->setField('username', 'monkeyboy');
$b->setField('password','monkeyboy');
$b->click('Sign in');
$b->isRedirected()->followRedirect();
$b->checkResponseElement('div#content_main', "*You don't have the requested permission to access this page*");

// Log in as admin
$b->click('Log out');
$b->get('/no/admin/list/unapprovedmyteams');
$b->setField('username', 'admin');
$b->setField('password','admin');
$b->click('Sign in');
$b->isRedirected()->followRedirect();

//Check it has the correct header
$b->checkResponseElement('div#content_main h1', '/Artworks pending queue/');

// We can't test the functionality of the page because all the buttons are ajax, but we can
// Simulate the effects, first lets check that some of the unapproved artworks are showing

$c = new Criteria();
$c->add(ReaktorArtworkPeer::STATUS, 2);
$c->setLimit(2); // Just get a couple to play with
$c->addAscendingOrderByColumn(ReaktorArtworkPeer::SUBMITTED_AT);

$unapprovedArtworks = ReaktorArtworkPeer::doselect($c);
if (count($unapprovedArtworks) < 2)
{
  throw new exception ("Need 2 or more unapproved artworks for this test to be useful");
}

foreach($unapprovedArtworks as $artwork)
{
  $b->checkResponseElement('div#content_main', '*'.$artwork->getTitle().'*');
  $displayedArtworks[$artwork->getId()] = $artwork->getTitle(); 
}

// Ok, lets approve the first one
reset($displayedArtworks);
$thisArtwork = new genericArtwork(key($displayedArtworks));
$thisArtwork->changeStatus(1, 3, "something");
$thisArtwork->save();

// Now we should not see it on the page, since we just approved it
$b->get('/no/admin/list/unapprovedmyteams');
$b->checkResponseElement('div#content_main', '!*'.$thisArtwork->getTitle().'*');

// But we should still see the other one
$b->checkResponseElement('div#content_main', '*'.next($displayedArtworks).'*');

?>
