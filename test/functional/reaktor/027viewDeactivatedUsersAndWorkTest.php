<?php
/**
 * Functional tests for user story 27 - View deactivated users/work
 * This test should cover:
 * 
 * Needs to be able to see a list of all deactivated accounts with links to all 
 * work which users have submitted.
 *
 * Benefit: To review and make decisions on users status
 * 
 *
 * PHP version 5
 *
 * @author bjori <bjori@linpro.no>
 * @copyright 2008 Linpro
 * @license http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 */

include(dirname(__FILE__).'/../../bootstrap/functional.php');

$t = new reaktorTestBrowser();
$t->initialize();

// Check if the functionality is protected for users not logged in
$t->get('/no/admin/list/users')->responseContains("You need to log in");

// Check if functionality is protected for logged in users without access
$t
  ->setField('username', 'userboy')
  ->setField('password', 'userboy')
  ->click('Sign in');

$t
  ->get('/no/admin/list/groups')
  ->responseContains("You don't have the requested permission")
  ->get('/no/logout');


// Log in as user with access 
$t
  ->get('/no/admin/list/users')
  ->setField('username', 'admin')
  ->setField('password', 'admin')
  ->click('Sign in');

// Open up userboys profile
$t
  ->get('no/admin/edit/user/3')
  ->responseContains("Edit userboy user")
// Make sure the "Activated" checkbox is checked
  ->checkResponseElement('body div input[id="sf_guard_user_is_active"][type="checkbox"][checked="checked"]', true);

$t
// Uncheck the "activated" checkbox
  ->setField("sf_guard_user[is_active]", "0")
  ->click("Save")
  ->isRedirected()
  ->followRedirect()
// Make sure the modifications have been saved
  ->responseContains("Your modifications have been saved")
// ...and then make sure the checkbox is not cliked
  ->checkResponseElement('body div input[id="sf_guard_user_is_active"][type="checkbox"][checked="checked"]', false);


// List all deactivated users
$t
  ->get('/no/admin/list/users')
  ->setField("filters[is_active]", 0)
  ->click("filter")
// userboy should be deactivated
  ->responseContains("userboy")
// But monkeyboy should not show up here
  ->checkResponseElement("div#sf_admin_content", "!/monkeyboy/");

// List all activated users
$t
  ->get('/no/admin/list/users')
  ->setField("filters[is_active]", 1)
  ->click("filter")
// userboy should not show up here
  ->checkResponseElement("div#sf_admin_content", "!/userboy/")
// But monkeyboy should
  ->checkResponseElement("div#sf_admin_content", "/monkeyboy/");


// Check if I can still see userboys portfolio
$t
  ->get("/no/portfolio/userboy")
  ->responseContains("userboy's portfolio")
  ->responseContains("The fancy gallery") # Name of a artwork he has in his portfolio
;

// Open up monkeyboys profile
$t
  ->get('no/admin/edit/user/2')
  ->responseContains("Edit monkeyboy user")
// Make sure the "Activated" checkbox is checked and then uncheck it
  ->checkResponseElement('body div input[id="sf_guard_user_is_active"][type="checkbox"][checked="checked"]', true)
  ->setField("sf_guard_user[is_active]", "0")
  ->click("Save")
  ->isRedirected()
  ->followRedirect()
// Make sure the modifications have been saved
  ->responseContains("Your modifications have been saved")
// ...and then make sure the checkbox is not cliked
  ->checkResponseElement('body div input[id="sf_guard_user_is_active"][type="checkbox"][checked="checked"]', false);


// List all activated users
$t
  ->get('/no/admin/list/users')
  ->setField("filters[is_active]", 1)
  ->click("filter")
// userboy should not show up here
  ->checkResponseElement("div#sf_admin_content", "!/userboy/")
// and monkeyboy should neither
  ->checkResponseElement("div#sf_admin_content", "!/monkeyboy/");

// List all deactivated users
$t
  ->get('/no/admin/list/users')
  ->setField("filters[is_active]", 0)
  ->click("filter")
// userboy should show up here
  ->checkResponseElement("div#sf_admin_content", "/userboy/")
// and monkeyboy should too
  ->checkResponseElement("div#sf_admin_content", "/monkeyboy/");

// Open up monkeyboys profile
$t
  ->get('no/admin/edit/user/2')
  ->responseContains("Edit monkeyboy user")
// Make sure the "Activated" checkbox isn't checked
  ->checkResponseElement('body div input[id="sf_guard_user_is_active"][type="checkbox"][checked="checked"]', false)
  // check it (activate the user)
  ->setField("sf_guard_user[is_active]", "1")
  ->click("Save")
  ->isRedirected()
  ->followRedirect()
// Make sure the modifications have been saved
  ->responseContains("Your modifications have been saved")
// ...and then make sure the checkbox is checked
  ->checkResponseElement('body div input[id="sf_guard_user_is_active"][type="checkbox"][checked="checked"]', true);

// Make sure monkeyboy is no longer in the deactivated list
$t
  ->get('/no/admin/list/users')
  ->setField("filters[is_active]", 0)
  ->click("filter")
// userboy should still be there
  ->checkResponseElement("div#sf_admin_content", "/userboy/")
// But monkeyboy not
  ->checkResponseElement("div#sf_admin_content", "!/monkeyboy/");


