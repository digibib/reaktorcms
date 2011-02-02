<?php
/**
 * Testing rejectedArtwork Reconsideration
 * 
 *  
 * PHP version 5
 * 
 * @author    Ole-Petter Wikene <olepw@linpro.no>
 * @copyright 2008 Linpro AS
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 */
 

include(dirname(__FILE__).'/../../bootstrap/functional.php');

// create a new test browser
$b = new reaktorTestBrowser();
$b->initialize();

//check that page doesnt show when not logged in
$b->get('no/admin/list/rejected');
$b->responseContains('You need to log in to view this page');

// Ok, lets log in as a user that does not have admin priveledges
$b->setField('username', 'monkeyboy');
$b->setField('password','monkeyboy');
$b->click('Sign in');
$b->isRedirected()->followRedirect();

// open approveartwork
$b->get('no/admin/list/rejected');
$b->responseContains("You don't have the requested permission to access this page");

//Ok so we should log out and back in again as admin
$b->click('Log out');

$b->get('no/admin/list/rejected');
$b->setField('username', 'admin');
$b->setField('password','admin');
$b->click('Sign in');
$b->isRedirected()->followRedirect();

$b->checkResponseElement('div#content_main', '/No artworks/');

//lets get rejected artworks
$c = new Criteria();
$c->add(ReaktorArtworkPeer::STATUS,2);
$artworks = ReaktorArtworkPeer::doSelect($c);

$first_artwork = array_shift($artworks);

$b->get('/no/artwork/reject/'.$first_artwork->getId());

$b->setField('rejectiontype','1');
$b->setField('rejectionmsg','This artwork is not approriate');
$b->click('Reject');
$b->isRedirected()->followRedirect();

$b->checkResponseElement('div#content_main', '!/No artworks/');

$artwork = ReaktorArtworkPeer::retrieveByPK($first_artwork->getId());

$b->checkResponseElement('div#content_main', '*Rejected on '.date("d/m/Y", strtotime($artwork->getActionedAt())).' at ' .date("H:i", strtotime($artwork->getActionedAt())).' by admin*');


/*
This part here has become Ajax... Todo: Make test cover this as well
$b->restart();
$b->get(url_for('@listrejected'));
$b->checkResponseElement('li', '/No artworks/');

$b->restart();
$b->get('/no/artwork/changeStatus/status/4/id/6');
$b->checkResponseElement('body', '/Reject artwork/');
$b->setField('rejectiontype','1');
$b->setField('rejectionmsg','This artwork is not approriate');
$b->click('Reject');
$b->isRedirected()->followRedirect();

$b->restart();
$b->get('@listRejected');
$b->checkResponseElement('li', '!/No artworks/');
$b->responseContains("Status 'Rejected' set by admin at");
$b->click('Flag for discussion');
$b->isRedirected()->followRedirect();

$b->restart();
$b->get('@listRejected');
$b->checkResponseElement('li', '/No artworks/');

$b->restart();
$b->get('@listdiscussion');
$b->checkResponseElement('li', '!/No artworks/');
$b->responseContains("Status 'Discussion' set by admin");
*/



?>
