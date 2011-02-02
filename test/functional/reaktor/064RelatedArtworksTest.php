<?php
/**
 * Test related artwork functionality
 *  
 * This test checks that 
 * - related artwork is displayed on the artwork/show page
 * - you can add related artwork
 * - "more work by this user" is shown if there is no related artwork
 * 
 * PHP version 5
 *
 * @author Daniel Andre Eikeland <dae@linpro.no>
 * @copyright 2008 Linpro
 * @license http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 */
include(dirname(__FILE__).'/../../bootstrap/functional.php');

// Create a new test browser
$b = new reaktorTestBrowser();
$b->initialize();

//Check page exist and that the content is correct
$b->get('/no/artwork/show/2/3/The+fancy+gallery');
$b->isStatusCode(200);
$b->isRequestParameter('module', 'artwork');
$b->isRequestParameter('action', 'show');

// Check to see that we have a "See also" block
//$b->checkResponseElement('div#relate_artwork_see_also', '*More work by*');

// Check that it contains a link to another artwork
$b->responseContains('"UnTip()" href="/index.php/no/artwork/show/3/My+Pdf"');

// Add another related artwork
$r = new RelatedArtwork();
$r->setFirstArtwork(2);
$r->setSecondArtwork(4);
$r->save();

// Get the page again and see if the second artwork is added
$b->get('/no/artwork/show/2/3/The+fancy+gallery');
$b->isStatusCode(200);
$b->isRequestParameter('module', 'artwork');
$b->isRequestParameter('action', 'show');

// Check to see that we have a "See also" block
$b->checkResponseElement('div#relate_artwork_see_also', '*See also*');

// Check that it contains the link to artwork
$b->responseContains('"UnTip()" href="/index.php/no/artwork/show/3/My+Pdf"');

// Delete all related artwork for artwork 2
$c = new Criteria();
$c->add(RelatedArtworkPeer::FIRST_ARTWORK, 2);
RelatedArtworkPeer::doDelete($c);

// Get the page again
$b->get('/no/artwork/show/2/3/The+fancy+gallery');
$b->isStatusCode(200);
$b->isRequestParameter('module', 'artwork');
$b->isRequestParameter('action', 'show');

// Check that the "See also" block now contains "More work by"
$b->checkResponseElement('div#relate_artwork_see_also', '/More work by/');

// Check that it also displays links to other artwork by this user
$b->responseContains('UnTip()" href="/index.php/no/artwork/show/3/My+Pdf"><img');

$c = new Criteria();
$c->add(ReaktorArtworkPeer::ID, 1);
$art = ReaktorArtworkPeer::doSelectOne($c);

$art->setStatus(3);
$art->save();

$b->setField('password', 'admin');
$b->setField('username', 'admin');
$b->click('Sign in');

//switch to edit page
$b->get('/no/artwork/edit/2');
$b->responseContains("Other artworks related to this one");


