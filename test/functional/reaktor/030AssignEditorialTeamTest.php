<?php
/**
 * Tests for the edit and view of approving by editorial teams
 *
 * FAIL: Looks like a fixture problem
 *
 * PHP version 5
 *
 * @author    juneih <juneih@linpro.no>
 * @copyright 2008 Linpro
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 * 
 */

include(dirname(__FILE__).'/../../bootstrap/functional.php');

// create a new test browser
$b = new reaktorTestBrowser();
$b->initialize();

//Navigate to an artwork without logging in, and check that we don't see which editorial team approved
$b->get("/no/artwork/show/2/The+fancy+gallery/")
  ->checkResponseElement("div#artwork_editorialteam_tag", "!/Approved in Deichman by admin/");

//Log in as userboy and check that we still don't see which editorial team approved
$b->setField('password', 'userboy')
  ->setField('username', 'userboy')
  ->click('Sign in')
  ->isRedirected()
  ->followRedirect()
  ->checkResponseElement("div#artwork_editorialteam_tag", "!/Approved in Deichman by admin/");
  
//Log in as staff and check that we do have access to see which editorial team approved
$b->click('Log out')
  ->get("/no/artwork/show/2/The+fancy+gallery/")
  ->setField('password', 'editorialboy1')
  ->setField('username', 'editorialboy1')
  ->click('Sign in')
  ->isRedirected()
  ->followRedirect()
  ->checkResponseElement("div#artwork_editorialteam_tag", "*Approved in Deichman by admin*");
  
//This artwork is already approved, let's view an artwork that isn't and check it has a dropdown and different message
$b->get("no/artwork/show/6/Dolor+Sit")
  ->checkResponseElement("div#artwork_editorialteam_tag", "*Awaiting approval by*")
  ->checkResponseElement("#new_editorialteam", true);
  
//Using the dropdown fires an ajax request which we cannot test here, so this is where it ends
