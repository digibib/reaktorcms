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
$b->get('/en/admin/list/rejected')->isStatusCode(200);
$b->checkResponseElement('div#content_main', '*You need to log in to view this page, please use the login form to the right*');

$b->get('/en');

$b->setField('username', 'monkeyboy');
$b->setField('password','monkeyboy');
$b->click('Sign in');

$b->isRedirected()->followRedirect();

$b->checkResponseElement("div#user_summary .nickname", "monkeyboy");

// open approveartwork
$b->restart();
$b->get('/en/admin/list/rejected')->isStatusCode(200);
$b->checkResponseElement('div#content_main', "*You need to log in to view this page, please use the login form to the right.*");

$b->restart();
$b->get('/en/logout');

$b->get('/en');
$b->setField('username', 'admin');
$b->setField('password','admin');
$b->click('Sign in');

$b->isRedirected()->followRedirect();

$b->responseContains('my editorial center');
//Reject an artwork
$b->restart();
$b->login("admin", "admin");
$b->get('/en/admin/listUnapproved');
$b->checkResponseElement('li', '!/No artworks/');

//lets get rejected artworks
$c = new Criteria();
$c->add(ReaktorArtworkPeer::STATUS,2);
$artworks = ReaktorArtworkPeer::doSelect($c);

$first_artwork = array_shift($artworks);

$b->get('/en/artwork/reject/'.$first_artwork->getId());
$b->responseContains('Reject artwork');
$b->responseContains('Note! You are about to reject an artwork');
$b->click('Reject');

$b->setField('rejectionmsg','This artwork is not approriate');
$b->click('Reject');
$b->responseContains('Please choose why this artwork is rejected');
$b->checkResponseElement('body','!/Please enter a rejection message/');

$b->setField('rejectionmsg','');
$b->setField('rejectiontype','1');
$b->click('Reject');
$b->checkResponseElement('body','!/Please choose why this artwork is rejected/');
$b->checkResponseElement('body','/Please enter a rejection message/');

$b->setField('rejectiontype','1');
$b->setField('rejectionmsg','This artwork is not approriate');
$b->click('Reject');
$b->isRedirected()->followRedirect();
$b->responseContains('Show rejection message');
$b->responseContains('This artwork is not approriate');

$artwork = ReaktorArtworkPeer::retrieveByPK($first_artwork->getId());

$b->checkResponseElement('div#content_main', '*Rejected on '.date("d/m/Y", strtotime($artwork->getActionedAt())).' at ' .date("H:i", strtotime($artwork->getActionedAt())).' by admin*');

