<?php
/**
 *
 *  Userlist + sort by username
 *  FAIL: probably fixture related
 *
 * PHP Version 5
 *
 * @author    Hannes Magnusson <bjori@linpro.no>
 * @copyright 2008 Linpro AS
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 *
 */
include(dirname(__FILE__).'/../../bootstrap/functional.php');

// create a new test browser
$t = new reaktorTestBrowser();
$t->initialize();

$chars = array("a", "A", "e", "E", "l", "L", "u", "U");
$users = array(
  "a" => array(
  ),
  "e" => array(
  ),
  "l" => array(
    "leo",
  ),
  "u" => array(
    "userboy",
  ),
);
$skip = array(
  "a" => array(
    "admin",
  ),
  "e" => array(
    "editorialboy1", "editorialboy2", "editorialboy3",
  ),
  "l" => array(
    "languageboy",
  ),
);

// Iterate over few chars
foreach($chars as $char)
{
  // Fetch a list of users startin with $char
  $t->get("/no/list/users/startingwith/$char");
  if (strtolower($char) == 'a')
  {
    // Admin should not be displaed
    $t->checkResponseElement("div#content_main ul", "!*admin*");
  }
  if (empty($users[strtolower($char)]))
  {
    // Make sure this list is empty
    $t->checkResponseElement("div#content_main", "*Sorry, could not find any users*");
    continue;
  }

  foreach($users[strtolower($char)] as $user)
  {
    // And make sure all known users are there
    $t->checkResponseElement("div#content_main ul", "*$user*");
  }
  if ($char == 'u')
  {
    // Disable userboy
    $t->login("admin", "admin", "/no/admin/edit/user/3")
      ->setField("sf_guard_user[is_active]", "0")
      #->setField("sf_guard_user[show_content]", "0")
      ->click("Save")
      ->isRedirected()
      ->followRedirect();
    # And delete userboy from the array as he shouldn't show up disabled
    $users["u"] = array();
  }
}


