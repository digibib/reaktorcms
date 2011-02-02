<?php
/**
 * Test for favourites functionality on artwork page 
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
$b->get("/no/artwork/show/2/The+fancy+gallery"); 
$b->isStatusCode();
$b->isRequestParameter('module', 'artwork');
$b->isRequestParameter('action', 'show');

// Not logged in yet so we should see the list but not the links
$b->checkResponseElement("div#content_main", "* users like this artwork*");

# NOTE: If the "users like this artwork" test above failes this will most 
# definetly fail to!!
$dom = $b->getResponseDom();
$favs_count = $dom->getElementById("artwork_actions_and_favourites_js")->getElementsByTagName("ul")->item(0)->getElementsByTagName("li")->length;


// Make sure the count is correct
$b->checkResponseElement("div#content_main", "*$favs_count users like this artwork*");

$b->checkResponseElement("div#artwork_actions_and_favourites", "!*Add as favourite*");
$b->checkResponseElement("div#artwork_actions_and_favourites", "!*Remove as favourite*");

// Lets clear the favourite for userboy if it exists, so we know where we are with the tests
//Lets log in and do the business
$b->setField('password', sfGuardUserPeer::retrieveByPK(2)->getUsername());
$b->setField('username', sfGuardUserPeer::retrieveByPK(2)->getUsername());
$b->click('Sign in');
$b->isRedirected()->followRedirect();

// Now we should see an remove as favourite link

$b->checkResponseElement("div#artwork_actions_and_favourites", "!*Mark artwork as favourite*");
$b->checkResponseElement("div#artwork_actions_and_favourites", "*You like this artwork*");

// Now let's remove it as a favourite and check again...
// (manually since we can't do the ajax)
Favourite::deleteFavourite(2, "artwork", 2);
$b->get("/no/artwork/show/2/The+fancy+gallery"); 
$b->checkResponseElement("div#artwork_actions_and_favourites", "!*Remove as favourite*");
$b->checkResponseElement("div#artwork_actions_and_favourites", "*Mark this artwork as favourite*");
// Final check really is to just see that favourite users are displayed correctly on the page...
Favourite::addFavourite(2, "artwork", 2);
$b->get("/no/artwork/show/2/The+fancy+gallery"); 
$b->checkResponseElement("div#artwork_actions_and_favourites", "*".sfGuardUserPeer::retrieveByPK(2)->getUsername()."*");


