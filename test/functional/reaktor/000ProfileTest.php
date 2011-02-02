<?php
/**
 * Test script for the profile page
 * 
 * PHP version 5
 * 
 * @author    Daniel Andre Eikeland <dae@linpro.no>
 * @copyright 2008 Linpro AS
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 */

include(dirname(__FILE__).'/../../bootstrap/functional.php');

$nick = 'monkeyboy';

// create a new test browser
$b = new sfTestBrowser();
$b->initialize();

// first check that profile page is not viewable when not logged in
$b->get("/en/profile");

// should forward to register page 
$b->isRedirected();
$b->followRedirect();
$b->isStatusCode(200);
$b->isRequestParameter('module', 'profile');
$b->isRequestParameter('action', 'register');

$b->get("/en"); 
$b->isStatusCode(200);

$b->setField('password', $nick);
$b->setField('username', $nick);
$b->click('Sign in');
$b->followRedirect();

// click the edit profile link
$b->click('Edit profile');
$b->isStatusCode(200);
$b->isRequestParameter('module', 'profile');
$b->isRequestParameter('action', 'edit');

// check that we have arrived
$b->checkResponseElement('h1', '/Edit profile of monkeyboy/');

// do some basic editing
$b->setField('username_profile', 'userboy');
$b->click('Save changes');
$b->checkResponseElement('div#error_for_username_profile', '/already in use/');

$b->setField('residence_id', 1);
$b->setField('dob_day', 4);
$b->setField('dob_month', 5);
$b->setField('dob_year', 1983);
// (yes, this is my birthday)
$b->click('Save changes');

$b->checkResponseElement('div#error_for_dob', '!/not valid/');
$b->checkResponseElement('div#error_for_dob', '!/complete date/');
$b->checkResponseElement('div#error_for_residence', '!/must choose/');

?>