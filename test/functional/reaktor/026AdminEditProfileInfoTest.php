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

define('NO_CLEAR', true);
include(dirname(__FILE__).'/../../bootstrap/functional.php');

$nick = 'admin';

// create a new test browser
$b = new reaktorTestBrowser();
$b->initialize();

// first check that admin user edit page is not viewable when not logged in
$b->get("/en/admin/list/users");

// should not be accessible 
$b->isStatusCode(200);
$b->responseContains('need to log in to view');

$b->get("/en"); 
$b->isStatusCode(200);

// log in as admin
$b->setField('password', $nick);
$b->setField('username', $nick);
$b->click('Sign in');
$b->followRedirect();

// click the list users link in the admin portal
$b->click('List users');
$b->isStatusCode(200);
$b->isRequestParameter('module', 'sfGuardUser');
$b->isRequestParameter('action', 'list');

// check that we have arrived
$b->checkResponseElement('h1', '/List of users/');

// edit monkeyboy
$b->click('monkeyboy');

// check that we have the correct edit page
$b->checkResponseElement('div#content_main', '/Edit monkeyboy user/');
$b->checkResponseElement('input[id="sf_guard_user_username"][value="monkeyboy"]');
$b->checkResponseElement('input[id="sf_guard_user_email"][value="monkeyboy@linpro.no"]');

// try to change the password but not get it right
$b->setField('sf_guard_user[password]', 'fubar123');
$b->setField('sf_guard_user[password_bis]', 'fubar124');

$b->click('Save');

// should give you an error
$b->checkResponseElement('div#content_main', '/Passwords do not match/');

// change the password
$b->setField('sf_guard_user[password]', 'fubar123');
$b->setField('sf_guard_user[password_bis]', 'fubar123');

$b->click('Save');

// should save, then redirect (wouldn't redirect if the validation failed - save didn't happen)
$b->followRedirect();

// should not give you an error
$b->checkResponseElement('div#content_main', '!/Passwords do not match/');

// go to edit profile page for monkeyboy (id 2)
$b->get('/en/profile/edit/2');

// check that we are at the profile page for monkeyboy
$b->checkResponseElement('div#content_main', '/Edit profile of monkeyboy/');
$b->checkResponseElement('input[id="username_profile"][value="monkeyboy"]');
$b->checkResponseElement('input[id="email"][value="monkeyboy@linpro.no"]');

/*
//###Password changing has been moved to a seperate page

// change passwords, but don't do it right
//$b->setField('password_profile', 'fubar123');
//$b->setField('password_repeat', 'fubar12500000');

//$b->click('Save changes');

// should give you an error
//$b->checkResponseElement('div#error_for_password_repeat', '/passwords do not match/');

// change passwords properly
//$b->setField('password_profile', 'fubar123');
//$b->setField('password_repeat', 'fubar123');

//$b->click('Save changes');
//$b->followRedirect();

//$b->checkResponseElement('div#error_for_password_repeat', '!/passwords do not match/');
*/

// edit some other information, like email and full name
$b->setField('email', 'fubar@fubar.com');
$b->setField('name', 'Fubar Johnson');

$b->click('Save changes');
$b->followRedirect();

// check that the information is updated
$b->checkResponseElement('input[id="email"][value="fubar@fubar.com"]');
$b->checkResponseElement('input[id="name"][value="Fubar Johnson"]');

//change back e-mail address and name so we don't have to clear the database when this test runs next time
$b->setField('email', 'monkeyboy@linpro.no');
$b->setField('name', 'monkey johns son');
$b->click('Save changes');
$b->isRedirected();
$b->followRedirect();

