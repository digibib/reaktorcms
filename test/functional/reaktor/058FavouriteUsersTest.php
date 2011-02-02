<?php
/**
 * Test for favourites functionality on a users portofolio
 *
 * PHP Version 5
 *
 * @author    June Henriksen <juneih@linpro.no>
 * @copyright 2008 Linpro AS
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 *
 */
include(dirname(__FILE__).'/../../bootstrap/functional.php');

// create a new test browser
$b = new reaktorTestBrowser();
$b->initialize();

// Access the portofolio without specifying a file
$b->get("/no/portfolio/monkeyboy")->isStatusCode(200);
$b->isRequestParameter('module', 'profile');
$b->isRequestParameter('action', 'portfolio');

// Not logged in yet so we should see the list but not the links
$b->checkResponseElement("div#favourite_with_block", "*Users who have marked monkeyboy as favourite*");
$b->checkResponseElement("div#favourite_with_block", "!*Add as favourite*");
$b->checkResponseElement("div#favourite_with_block", "!*Remove as favourite*");

// Lets clear monkeyboy's favourites (artwork and user favourites) 
$c = new Criteria();
$c->add(favouritePeer::USER_ID, 3);
FavouritePeer::doDelete($c);

//Lets log in as monkeyboy and do the business
$b->setField('password', sfGuardUserPeer::retrieveByPK(3)->getUsername());
$b->setField('username', sfGuardUserPeer::retrieveByPK(3)->getUsername());
$b->click('Sign in');
$b->isRedirected()->followRedirect();

// Now let's add monkeyboy as a favourite and check again...
Favourite::addFavourite(2, "user", 3);

// Final check is to see that monkeyboy is displayed in userboy's favourite users list on his portfolio
$b->get("/no/portfolio/userboy");
$b->checkResponseElement("div#my_favourite_users_block", "*monkeyboy*");



