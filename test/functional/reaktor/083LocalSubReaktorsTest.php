<?php
/**
 * Functional tests for user story 083 - Local subReaktors
 * This test should cover:
 * 
 * As Bob I need to be able to define a subreaktor based on the users residence 
 * so that I can create local subreaktors based on one or more city and/or 
 * country.
 * Example: "StavangerReaktor" - artworks from users with redisence in Stavanger
 *
 *
 * Criteria:
 *  - Should be able to "tick" checkboxes in subreaktor setup to define the 
 *    residence for that subreakter.
 *  - Content by users from selected areas should appear in appropriate reaktors
 *
 * @author bjori <bjori@linpro.no>
 * @copyright 2008 Linpro
 * @license http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 */

include(dirname(__FILE__).'/../../bootstrap/functional.php');

$t = new reaktorTestBrowser();
$t->initialize();


// Login as admin and open the subreaktor listing
$t->login("admin", "admin", "/no/admin/list/subreaktors")
  ->responseContains("Add a new subReaktor")
  // Create new reaktor
  ->setField("name", "NewLokalSubReaktor")
  ->setField("reference", "tlokalreaktor")
  ->click("Create")
# If it doesn't redirect here then a common error is your 
# "apps/reaktor/modules/subreaktors/templates/" folder isn't writable
  ->isRedirected()
  ->followRedirect()
  // Make sure the URI is correct
//  ->checkResponseElement("form#sf_admin_edit_form a", "http://reaktor/tlokalreaktor");
  ->checkResponseElement('a[href$="/no/tlokalreaktor"]', "http://reaktor/tlokalreaktor");

$uri = $t->getResponseDom()->getElementById("sf_admin_edit_form")->getAttribute("action");

// Set the reaktor as live & as lokalreaktor
$t->checkResponseElement('form#sf_admin_edit_form', true);
$t->
post($uri,
  array(
    "subreaktor_live" => "1",
    "subreaktor_reference" => "tlokalreaktor",
    "subreaktor_lokalreaktor" => "1",
    "commit" => "Update subReaktor",
  ))
->isRedirected()
->followRedirect();


// Associate "Finnmark" (4) with it (monkeyboy is from finnmark)
$t->post($uri,
  array(
    "subreaktor_live" => "1",
    "subreaktor_lokalreaktor" => "1",
    "associated_lokalreaktor_residence[]" => "4",
    "commit" => "Update subReaktor",
  ))
->isRedirected()
->followRedirect();



$t->logout();

$t
// Open the newly created lokalcityreaktor and check if monkeyboy has the latest artwork
  ->get("/no/tlokalreaktor-film")
  ->responseContains("dokumentar") # Tag cloud
  ->checkResponseElement('div#top_block_center div.artwork_link', "*Magic animations*")
  ->checkResponseElement('div#top_block_center div.artwork_link', "*monkeyboy*");

# Cleanup
unlink(dirname(__FILE__).'/../../../apps/reaktor/modules/subreaktors/templates/tlokalreaktorReaktorSuccess.php');
unlink(dirname(__FILE__).'/../../../web/images/logoTlokalreaktor.gif');

