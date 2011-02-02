<?php
/**
 * Functional test for tags+user search
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

// try to find artworks with 'car'
$b->get("/no/tags/find/tag/car"); 
$b->isStatusCode(200);
$b->isRequestParameter('module', 'tags');
$b->isRequestParameter('action', 'find');

// check that it tries to display the results
$b->checkResponseElement("div#content_main", "/Work tagged with car/");

// check that it has a result in it
$b->checkResponseElement("div#content_main div.searchresult_row h4", '/My Pdf.*userboy/');

// click a tag in the results
$b->click('camping');

// check that it displays the new tag
$b->checkResponseElement("div#content_main", "/Work tagged with camping/");

// and that it displays more results
$b->checkResponseElement("div#content_main", '/The fancy gallery.*userboy/');

// try to combine more than one tag
$b->get("/no/tags/find/tag/car,lakes");

// check that it tries to display all tags
$b->checkResponseElement("div#content_main", "/Work tagged with car/");
$b->checkResponseElement("div#content_main", "/Work tagged with lakes/");


// check that it has a new artwork that will only be there if the new tag was displayed
$b->responseContains('Nice monkeys');

// try to find a user that doesn't exist
$b->get("/no/tags/find/tag/car/findtype/user");
$b->responseContains('Sorry, could not find any users');

// try to find monkeyboy
$b->get("/no/tags/find/tag/monkeyboy/findtype/user");

// should end up on monkeyboys portfolio page
$b->followRedirect();
$b->isStatusCode(200);
$b->isRequestParameter('module', 'profile');
$b->isRequestParameter('action', 'portfolio');

?>
