<?php
/**
 * Test script for login form
 * 
 * Covers:
 *  Link following
 *  Submitting empty form
 *  Submitting with empty username only
 *  Submitting with empty password only
 *  Submitting with unknown user
 *  Submitting with wrong password
 *  Submitting with strange characters in username field
 *  Submitting with strange characters in password field
 *  Checking that we stay logged in between pages
 * 
 * PHP version 5
 * 
 * @author    Russ Flynn <russ@linpro.no>
 * @author    Daniel Andre Eikeland <dae@linpro.no>
 * @copyright 2008 Linpro AS
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 */

include(dirname(__FILE__).'/../../bootstrap/functional.php');

// create a new test browser
$b = new reaktorTestBrowser();
$b->initialize();


$b->get("/no/profile");

$b->isStatusCode(302);
$b->isRequestParameter('module', 'profile');
$b->isRequestParameter('action', 'edit');

$b->get("/no"); 

// Test clicking the login button with empty fields
$b->click('Sign in');

// Lets take a look at the resulting page so far
// It should be returning errors due to empty form fields
$b->responseContains("Username required");
$b->responseContains("Password required");

// Now lets populate the username box and submit - this time it should not have the username error
$b->setField('username', 'random');
$b->click('Sign in');
$b->checkResponseElement("body", "!*Username required*");
$b->checkResponseElement("div#sf_guard_auth_password", "*Password required*");

// We need to restart for the next test
$b->restart();
$b->get('/no');

// Do the same with the password box
$b->setField('password', 'random');
$b->click('Sign in');
$b->checkResponseElement("div#sf_guard_auth_password", "!*Password required*");
$b->checkResponseElement("div#sf_guard_auth_username", "*Username required*");

// We need to restart for the next test
$b->restart();
$b->get('/no');

// Now popluate both fields to check for different error
$b->setField('password', 'random');
$b->setField('username', 'random');
$b->click('Sign in');
$b->checkResponseElement("div#sf_guard_auth_password", "!*Password required*");
$b->checkResponseElement("div#sf_guard_auth_username", "!*Username required*");
$b->responseContains("Username or password is not valid");

// Now popluate both fields with all sorts of random characters
$b->setField('password', '!"#¤%&/()=?+90+\'".,<>*\'^~"');
$b->setField('username', '!"#¤%&/()=?+90+\'".,<>*\'^~"');
$b->click('Sign in');
$b->checkResponseElement("div#sf_guard_auth_password", "!*Password required*");
$b->checkResponseElement("div#sf_guard_auth_username", "!*Username required*");
$b->responseContains("Username or password is not valid");

// Check that the form returns username but not password
$b->setField('password', 'randompassword');
$b->setField('username', 'randomusername');
$b->click('Sign in');
$b->checkResponseElement("div#sf_guard_auth_password", "!*randompassword*");
$b->responseContains("randomusername");

// Ok, so lets try with a user we know is in the database
// This test might fail at a later date when this user is removed from the db!
$b->setField('password', 'admin');
$b->setField('username', 'nottherightpassword');
$b->click('Sign in');
$b->checkResponseElement("div#sf_guard_auth_password", "!*Password required*");
$b->checkResponseElement("div#sf_guard_auth_username", "!*Username required*");
$b->checkResponseElement("div#sf_guard_auth_username", "*Username or password is not valid*");

// try to log into an invalid account
$c = new Criteria();
$c->add(sfGuardUserPeer::USERNAME,'admin');
$c->addAscendingOrderByColumn('id');

$db_user = sfGuardUserPeer::doSelect($c);
$db_user[0]->setIsActive(0);
$db_user[0]->save();

$b->setField('password', 'admin');
$b->setField('username', 'admin');
$b->click('Sign in');
$b->checkResponseElement("body", "!*Password required*");
$b->checkResponseElement("body", "!*Username required*");
$b->checkResponseElement("div#sf_guard_auth_username", "!*Username or password is not valid*");
$b->checkResponseElement("body", "*The account is not validated*");

// Finally, we test a correct login, we should be directed to the referred page
$db_user[0]->setIsActive(1);
$db_user[0]->save(); 

$b->setField('password', 'admin');
$b->setField('username', 'admin');
$b->click('Sign in');
$b->checkResponseElement("body", "!*password is required*");
$b->checkResponseElement("body", "!*username is required*");
$b->checkResponseElement("div#sf_guard_auth_username", "!*Username or password is not valid*");

// redirect the browser
$b->isRedirected()->followRedirect(); 

// check that the page loads correctly
$b->isStatusCode(200);
$b->checkResponseElement("body", "*my editorial center*");

// Finally we should check that the login state is maintained across the site
// I won't use click functionality here as the links may change

$b->get("@register");
$b->reload();
$b->back();
$b->get("/no");

$b->isStatusCode(200);

//End of current test file
