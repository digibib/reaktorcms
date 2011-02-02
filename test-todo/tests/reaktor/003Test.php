<?php
/**
 * Testing profile editing. This test covers:
 * 
 * Change email address
 * Change profile information
 * Make sure you cannot edit profile information if not logged in
 *  
 * PHP version 5
 * 
 * @author    Daniel Andre Eikeland <dae@linpro.no>
 * @copyright 2008 Linpro AS
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 */
 

include(dirname(__FILE__).'/../../bootstrap/functional.php');

// create a new test browser
$b = new sfTestBrowser();
$b->initialize();

//check that /profile brings us to register page when not logged in
$b->get('/register');
$b->isStatusCode(200);
$b->isRequestParameter('module', 'profile');
$b->isRequestParameter('action', 'register');
$b->responseContains('Register as a user');

$b->get('/');
$b->setField('username', 'monkeyboy');
$b->setField('password','monkeyboy');
$b->click('Sign in');

$b->isRedirected()->followRedirect();

$b->responseContains('Log out');

// open editprofile
$b->restart();
$b->get('/profile');
$b->responseContains('Edit profile of monkeyboy');

// generate some bogus data  
$bogus1 = '#¤%&/!!!';
$bogus2 = '########';

// $b->restart();
// $b->get('/profile');
// Save "full name" and check that it's stored
$b->setField('name', 'chimp');
$b->click('Save changes');

$b->isRedirected()->followRedirect();

$b->responseContains('chimp');

$b->setField('email', 'root@localhost.localdomain');
$b->click('Save changes');

$b->isRedirected()->followRedirect();

$b->responseContains('verification email has been sent');

$b->click('here');

$b->checkResponseElement('body', '!/verification email has been sent/');
/*$b->setField('username', $bogus1)->
    setField('password',$bogus1)->
    setField('password_repeat',$bogus2)->
    setField('email',$bogus1)->
    setField('phone',$bogus1)->
    click('save')->
    responseContains('tjall');   
*/
