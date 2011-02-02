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
 * @author    Daniel Andre Eikeland <dae@linpro.no>
 * @copyright 2008 Linpro AS
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 */

include(dirname(__FILE__).'/../../bootstrap/functional.php');

// create a new test browser
$b = new sfTestBrowser();
$b->initialize();

$b->get("/tags/index");

$b->isStatusCode(200);
$b->isRequestParameter('module', 'tags');
$b->isRequestParameter('action', 'index');

// Make sure the tag cloud is displaying, and that it is styled
$b->checkResponseElement('ul[class="tag-cloud"]', '/fred/');
$b->checkResponseElement('big', '/bob/');
$b->checkResponseElement('small', '/elephant/');

// Click the fred tag
$b->click('fred');

// Make sure it lists results
$b->checkResponseElement('h3', '/Files tagged with fred/');
$b->checkResponseElement('body', '/My first nice pdf/');
$b->checkResponseElement('body', '/My second nice image/');
