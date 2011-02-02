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
$b = new reaktorTestBrowser();
$b->initialize();

// Check that the front page is loaded with test tags
$b->get('/no');
$b->isStatusCode(200);
$b->isRequestParameter('module', 'home');
$b->isRequestParameter('action', 'index');
$b->checkResponseElement('div.tag_block', '/(.*)[animal|cute|silly](.*)/');

$b->get('/no/tags/tagAction?file=1');
$b->isStatusCode(200);
#$b->checkResponse Element('div.tag_block', '/(.*)[animal|cute|silly](.*)/');
