<?php
/**
 * Test script for the admin frontpage
 * 
 * 
 * PHP version 5
 * 
 * @author    Ole-Petter Wikene <olepw@linpro.no>
 * @copyright 2008 Linpro AS
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 */

include(dirname(__FILE__).'/../../bootstrap/functional.php');

// create a new test browser
$b = new sfTestBrowser();
$b->initialize();

//first check that admin module is not viewable when not logged in
$b->get("/en/admin");

$b->isStatusCode(200);
$b->checkResponseElement('div#content_main' , '*You need to log in to view this page*');

$b->get("/en"); 
$b->setField('username', 'admin');
$b->setField('password', 'admin');

// Log in and check that we are redirected to admin page
$b->click('Sign in');
$b->isRedirected()->followRedirect();
$b->isRequestParameter('module', 'admin');
$b->isRequestParameter('action', 'index');

$b->get('/no/artwork/edit/2');

// check that we're editing the correct artwork
$b->checkResponseElement('div#artwork_main_container', '/Editing: The fancy gallery/');

// check that it contains the author information
$b->checkResponseElement('div#artwork_main_container', '/userboy/');

// check that the artwork image is displayed
$b->checkResponseElement('div#artwork_div a[href="/index.php/content/3/lovely.jpg"]');

// check that it contains the description
$b->checkResponseElement('textarea#description_value', 'This is an awesome gallery');

// check that it contains the drag and drop file list
$b->checkResponseElement('ul#artwork_files');
$b->checkResponseElement('li#file_3');
$b->checkResponseElement('li#file_4');
$b->checkResponseElement('li#file_8');

$b->checkResponseElement('div[id="relate_artwork_see_also"]');

$b->checkResponseElement('div[id="categorySelect"]');
$b->checkResponseElement('div[id="subreaktor_list"]');
$b->checkResponseElement('div[id="category_list"]');

//$b->checkResponseElement('div[id="artwork_edit_link"]', '/Switch to view mode/');
$b->checkResponseElement('div#artwork_main_container', '/View mode/');

$b->responseContains('Add tag(s)');

$b->responseContains('Current tags');
