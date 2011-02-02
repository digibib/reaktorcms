<?php
/**
 * Functional tests for user story 25 - Permission adminstration.
 * This test covers:
 * 
 * Testing that permissions work for permission administration
 * Creating a new permission, and connecting it to user
 * A check to see if new permission is in list
 * Delete the permission
 *
 * PHP version 5
 *
 * @author juneih <juneih@linpro.no>
 * @copyright 2008 Linpro
 * @license http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 */

include(dirname(__FILE__).'/../../bootstrap/functional.php');

// create a new test browser
$b = new sfTestBrowser();
$b->initialize();

//Check if functionality is protected for users not logged in
$b->get('/sfGuardPermission/list')->responseContains("You need to log in");

//Check if functionality is protected for logged in users without access
$b->setField('username', 'userboy')->setField('password', 'userboy')->click('sign in');

$b->get('/sfGuardPermission/list')->responseContains("You don't have the requested permission")->get('/logout');

// Log in as user with access 
$b->get('/')->setField('username', 'admin')->setField('password', 'admin')->click('sign in');

//
//Create Permission, and check it's added to list
//
$b->get('/sfGuardPermission/create')
  ->isStatusCode(200)
  ->isRequestParameter('module', 'sfGuardPermission')
  ->isRequestParameter('action', 'create')
  ->setField('sf_guard_permission[name]', 'joketelling')
  ->setField('sf_guard_permission[description]', 'joketelling description')
  ->setField('associated_permissions[]', array(1,2,3))
  ->click('Save and continue editing')
  ->followRedirect()  
  ->responseContains('joketelling description')
  ->responseContains('joketelling');

//
//Delete permission
//
$b->get('/sfGuardPermission/list')
  ->isStatusCode(200)
  ->isRequestParameter('module', 'sfGuardPermission')
  ->isRequestParameter('action', 'list')
  ->click('joketelling')
  ->click('Delete permission')
  ->followRedirect()
  ->responseContains('Permission list')
  ->isRequestParameter('module', 'sfGuardPermission')
  ->isRequestParameter('action', 'list');

?>