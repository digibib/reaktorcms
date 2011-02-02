<?php
/**
 * Functional tests for user story 25 - Group adminstration.
 * This test covers:
 * 
 * Checking that functionality isn't available without proper settings
 * create group
 * check that it is listed
 * TODO: delete group (see error message, by running it)
 * 
 *
 * PHP version 5
 *
 * @author juneih <juneih@linpro.no>
 * @copyright 2008 Linpro
 * @license http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 */

include(dirname(__FILE__).'/../../bootstrap/functional.php');

// create a new test browser
$b = new reaktorTestBrowser();
$b->initialize();

//Check if functionality is protected for users not logged in
$b->get('/no/admin/list/groups')->responseContains("You need to log in");

//Check if functionality is protected for logged in users without access
$b->
  setField('username', 'userboy')->
  setField('password', 'userboy')->
  click('Sign in');

$b->get('/no/admin/list/groups')->responseContains("You don't have the requested permission")->get('/no/logout');

// Log in as user with access 
$b->get('/no')->setField('username', 'admin')->setField('password', 'admin')->click('Sign in');

//
//create group
//
$b->get('/no/sfGuardGroup/create')
  ->isStatusCode(200)
  ->isRequestParameter('module', 'sfGuardGroup')
  ->isRequestParameter('action', 'create');

//$b->checkResponseElement('body [type="checkbox"]') //input[class="sf_admin_batch_checkbox"]
//input id="associated_permissions_1" type="checkbox" value="1" name="associated_permissions[]
$b->setField('sf_guard_group[name]', 'editor')
  ->setField('sf_guard_group[description]', 'Editor description')
  ->setField('associated_permissions[]', array(1,2,3))
  ->click('Save')
  ->isRedirected()
  ->followRedirect()  
  ->responseContains('Editor description')
  ->responseContains('Editor');

//
//List groups, check new group is there
//
$b->get('/no/admin/list/groups')
  ->isStatusCode(200)
  ->isRequestParameter('module', 'sfGuardGroup')
  ->isRequestParameter('action', 'list')
  ->responseContains('Group list')
  ->responseContains('Editor description')
  ->responseContains('Editor');
  
//
//Delete group
//
/* There's a bug in propel that makes this test fail.. no workaround at this time..
$b->click('publishers')
  ->click('Delete group')
  ->isRedirected()  
  ->followRedirect()
  ->responseContains('Members')
  ->responseContains('!/Editor description/')
  ->responseContains('!/Editor/')
  ->isRequestParameter('module', 'sfGuardGroup')
  ->isRequestParameter('action', 'list');
*/

