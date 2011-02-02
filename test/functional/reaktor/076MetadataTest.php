<?php
/**
 * Functional test for metadata form
 * Tests access control, and that the metadata form is displayed properly
 * 
 * PHP Version 5
 *
 * @author    Daniel Andre Eikeland <dae@linpro.no>
 * @copyright 2008 Linpro AS
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 *
 */

include(dirname(__FILE__).'/../../bootstrap/functional.php');

$nick = "admin";
// create a new test browser
$b = new reaktorTestBrowser();
$b->initialize();

// Try to go to edit metadata page without being logged in
$b->get("/no/artwork/showmetadata/2/The+fancy+gallery"); 
$b->isStatusCode(200);
$b->isRequestParameter('module', 'artwork');
$b->isRequestParameter('action', 'showMetadata');

// Check that we don't get the metadata edit page
$b->checkResponseElement("div#content_main", "!/Metadata for/");

// Log in as admin
$b->setField('password', $nick);
$b->setField('username', $nick);
$b->click('Sign in');
$b->isRedirected()->followRedirect();
$b->checkResponseElement("div#content_main", "/Metadata for The fancy gallery/");

// Go to edit metadata page
$b->isRequestParameter('module', 'artwork');
$b->isRequestParameter('action', 'showMetadata');

// check that we are on the edit metadata page
$b->checkResponseElement("div#content_main", "/Metadata for/");

// Check that the metadata is correctly displayed
$b->responseContains('Saudi Arabia, Bahrain, Squash, boat, water, psalive');

?>