<?php
/**
 * Functional tests for user story 28 - Deactivate user (re-activate)
 * This test should cover:
 * 
 * Should be able to deactivate a user, hiding all of their work&profile at the 
 * same time (and reverse).
 *
 * Benefit: To provide a quick way to hide inapropriate content or disable a 
 * "rule breaker"
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

// Make sure userboy can log in
$t->login("userboy", "userboy")
   ->checkResponseElement("div#user_summary .nickname", "userboy")
// And that he has artwork on the frontpage
  ->checkResponseElement("div#popular_block", "/The fancy gallery/");

// Logout
$t->logout();

// Login as admin
$t->login("admin", "admin", "/no/admin/list/users");

// Open up userboys profile
$t
  ->get('/en/admin/edit/user/3')
  ->responseContains("Edit userboy user")
// Make sure the "Activated" checkbox is checked
  ->checkResponseElement('body div input[id="sf_guard_user_is_active"][type="checkbox"][checked="checked"]', true)
// and the "show content" checkbox
  ->checkResponseElement('body div input[id="sf_guard_user_show_content"][type="checkbox"][checked="checked"]', true)
// Then uncheck both of them
  ->setField("sf_guard_user[is_active]", "0")
  ->setField("sf_guard_user[show_content]", "0")
  ->click("Save")
  ->isRedirected()
  ->followRedirect()
// Make sure the modifications have been saved
  ->responseContains("Your modifications have been saved")
// ...and then make sure the checkbox is not cliked
  ->checkResponseElement('body div input[id="sf_guard_user_is_active"][type="checkbox"][checked="checked"]', false)
  ->checkResponseElement('body div input[id="sf_guard_user_show_content"][type="checkbox"][checked="checked"]', false);

// Try to login as the deactivated user (userboy)
$t
  ->login("userboy", "userboy", "/en", false)
  ->responseContains("There was an error with your login, please check your details and try again.")
  ->responseContains("The account is not validated");

// Make sure his portofilio has been blocked
$t
  ->get("/en/portfolio/userboy")
  ->responseContains("This users portfolio has been blocked");

// Login as admin
$t->login("admin", "admin", "/en/admin/list/users");

// Open up userboys profile
$t
  ->get('/en/admin/edit/user/3')
  ->responseContains("Edit userboy user")
// Make sure the "Activated" checkbox is unchecked
  ->checkResponseElement('body div input[id="sf_guard_user_is_active"][type="checkbox"][checked="checked"]', false)
// and the "show content" checkbox
  ->checkResponseElement('body div input[id="sf_guard_user_show_content"][type="checkbox"][checked="checked"]', false)
// Then activate his account - without enabling his content
  ->setField("sf_guard_user[is_active]", "1")
  ->click("Save")
  ->isRedirected()
  ->followRedirect()
// Make sure the modifications have been saved
  ->responseContains("Your modifications have been saved")
// ...and then make sure the checkbox is not cliked
  ->checkResponseElement('body div input[id="sf_guard_user_is_active"][type="checkbox"][checked="checked"]', true)
  ->checkResponseElement('body div input[id="sf_guard_user_show_content"][type="checkbox"][checked="checked"]', false);

// Logout
$t->logout();

// Make sure userboys portofolio is still blocked
$t
  ->get("/en/portfolio/userboy")
  ->responseContains("This users portfolio has been blocked");

// His portofolio is blocked, but userboy should be able to login
$t
  ->login("userboy", "userboy")
  ->checkResponseElement("div#user_summary .nickname", "userboy")
// Make sure his artwork is no longer on the frontpage
  ->checkResponseElement("div#popular_block", "!/The fancy gallery/");

// He can see his own portofolio, even if its blocked
$t
  ->get("/en/portfolio/userboy")
# FIXME: He should get some note about the fact his content is disabled
  ->responseContains("userboy's portfolio");


