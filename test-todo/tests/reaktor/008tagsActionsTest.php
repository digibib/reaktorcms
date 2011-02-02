<?php
/**
 * Test script for tags
 * 
 * covers:
 *   Check that the tags-page is loaded fully
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

// Check that the tags page is loaded completely
$b->get('/tags');
$b->isStatusCode(200);
$b->isRequestParameter('module', 'tags');
$b->isRequestParameter('action', 'index');
$b->checkResponseElement('body', '/tagsEnd/');

// Check that we do not add any test tags
$b->checkResponseElement('body', '/not manipulating/');

// log in with "admin/admin" 
// !! depends on the sfGuardUser plugin to function properly !!
$b->get('/login');

$b->setField('password', 'admin');
$b->setField('username', 'admin');
$b->click('sign in');
// !! we should be logged in now - end depends !!

// if we are logged in, then a test tag will be created and stored
// and then it will be removed 

// navigate to the 'tags' page again, and add test tag
$b->get('/tags/index/addtag/fu');
$b->checkResponseElement('body', '/added/');

// search for the test tag and confirm that it's added
$b->get('/tags/find/tag/fu');
$b->checkResponseElement('body', '!/None/');

// navigate to the 'tags' page again, and delete test tag
$b->get('/tags/index/deltag/fu');
$b->checkResponseElement('body', '/deleted/');