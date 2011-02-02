<?php
/**
 * Test script for Artwork discussion
 * 
 * PHP version 5
 * 
 * @author   Ole-Petter Wikene <olepw@linpro.no>
 * @copyright 2008 Linpro AS
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 */

include(dirname(__FILE__).'/../../bootstrap/functional.php');

// create a new test browser
$b = new reaktorTestBrowser();
$b->initialize();

// View an artworks comments
$b->get("/no/artwork/show/2/The+fancy+gallery");
$b->isStatusCode(200);
$b->checkResponseElement('div#commentlist','!/Write a comment/');
$b->setField('password', 'monkeyboy');
$b->setField('username', 'monkeyboy');
$b->click('Sign in');
$b->isRedirected()->followRedirect();
$b->checkResponseElement('div#commentlist','/Write a comment/');

//post a comment
$b->setField('sf_comment_title','A comment to the artwork');
$b->setField('sf_comment','Testing comments 123...');

// Ajax functionality cannot be tested here

?>