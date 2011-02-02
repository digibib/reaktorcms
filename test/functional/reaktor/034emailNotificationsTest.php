<?php
/**
 * Functional tests for user story 34 - Email Notifications
 * 
 * Bob must be able to set email notifications for editorial events to any user, 
 * and jim should also be able to control this himself. This means anybody can 
 * be notified if necessary.
 *
 * Options:
 *  - No email
 *  - Email when queue not empty
 *  - Email on every artwork
 *
 *
 * This test should cover:
 *  - Admin can change settings for editorial staff
 *  - Editorial staff can change its own settings
 *
 * NOTE: The actual email sending/retrieving is not covered by this test
 *
 *
 * PHP version 5
 *
 * @author bjori <bjori@linpro.no>
 * @copyright 2008 Linpro
 * @license http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 */

include(dirname(__FILE__).'/../../bootstrap/functional.php');

// User
$u = new reaktorTestBrowser();
$u->initialize();

$editors = array(
  "admin" => "user_1",
  "editorialboy1" => "user_8",
  "editorialboy2" => "user_9",
);
$options = array(
  "No email",
  "Email on first incoming artwork",
  "Email on all incoming artworks",
);

/* This stuff has changed drastically */
return;

// Iterate over editorialboy1, 2 and 3
foreach($editors as $username => $userid) {
  // Login and open the notification page
  $u->login($username, $username, "/en/admin/list/myteams");

  // Iterate over the combobox and make sure they are there
  foreach($options as $key => $value) {
    $u->checkResponseElement('body div select[id="' .$userid. '"] option[value="' .$key. '"]', $value);
  }

  // Iterate over all possible choices and click them
  foreach($options as $key => $value) {
    $u->setField($userid, $key)->click("Save");

    // and make sure only the field we picked is selected
    foreach($options as $k => $v) {
      $u->checkResponseElement('body div select[id="' .$userid. '"] option[value="' .$k. '"][selected]', $k == $key);
    }
  }

}

foreach($editors as $username => $userid) {
  // Now login as admin and bring up the notification page
  $u->login("admin", "admin", "/en/admin/list/myteams");
  // Make sure we have these three editorialboys there
  $u->responseContains($username);

  // Iterate over all possible choices and click them
  foreach($options as $key => $value) {
    $u->login("admin", "admin", "/en/admin/list/myteams");
    $u->setField($userid, $key)->click("Save");

    // and make sure only the field we picked is selected
    foreach($options as $k => $v) {
      $u->checkResponseElement('body div select[id="' .$userid. '"] option[value="' .$k. '"][selected]', $k == $key);
    }

    // Log in as the user and check if it really updated his settings
    $u->login($username, $username, "/en/admin/list/myteams");
    foreach($options as $k => $v) {
      $u->checkResponseElement('body div select[id="' .$userid. '"] option[value="' .$k. '"][selected]', $k == $key);
    }
  }

}


