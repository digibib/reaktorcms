<?php
/**
 * Functional tests for user story 28 - Deactivate user (re-activate)
 * This test should cover:
 *
 * Should be able to remove user from group and add various standalone 
 * permissions
 *
 * @author bjori <bjori@linpro.no>
 * @copyright 2008 Linpro
 * @license http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 */

include(dirname(__FILE__).'/../../bootstrap/functional.php');

class localTestBrowser extends reaktorTestBrowser {
  static $permissions =  array(
    35, # Post new comments
    36, # Upload new content
    37, # Send messages to users
    38, # Rate artwork
    39, # Mark users/artwork as favourite
  );

  function enable($userid, $permission) {
    is_integer($userid) or die("Expecting integer as userid , got " . gettype($userid));
    is_integer($permission) or die("Expecting integer, got " . gettype($permission));

    // Login as admin
    $this->login("admin", "admin", '/en/admin/edit/user/'.$userid)
      ->responseContains("Edit userboy user");

    // Enable it
    return $this->setField("associated_permissions[]", array($permission))
      ->click("Save")
      ->isRedirected()
      ->followRedirect()
      // Check if its really enabled
      ->checkResponseElement('body div input[id="associated_permissions_' .$permission. '"][type="checkbox"][checked="checked"]', true);
  }

}

$USERID = 3;
$USERNAME = "userboy";
$PASSWORD = "userboy";


$t = new localTestBrowser();
$t->initialize();


// Login as admin and open userboys profile
$t->login("admin", "admin", '/en/admin/edit/user/'. $USERID)
  ->responseContains("Edit userboy user");

$t
// He currently has the "user" role
  ->checkResponseElement('body div input[id="associated_groups_2"][type="checkbox"][checked="checked"]', true)
// Lets remove it
  ->setField("associated_groups[]", null)
  ->click("Save")
  ->isRedirected()
  ->followRedirect()
// Make sure the modifications have been saved
  ->responseContains("Your modifications have been saved");

// Logout as admin
$t->logout();

// Login as userboy
$t->login($USERNAME, $PASSWORD, '/en/artwork/show/4/Fingers');

// Add a comment should fail
$t->checkResponseElement("body", "/You don't have permission to comment/");

// Enable it & test
$t->enable($USERID, 35)
  ->login($USERNAME, $PASSWORD, '/en/artwork/show/4/Fingers')
  ->setField("sf_comment", "This is my test comment :D")
  ->setField("sf_comment_title", "Test comment title")
  ->click("Post this comment")
  ->responseContains("This is my test comment :D");

// He can't mark user as favourite
$t->checkResponseElement("body", "!/Mark this user as favourite/");
$t->enable($USERID, 34);
$t->login($USERNAME, $PASSWORD, '/en/artwork/show/4/Fingers')
  ->responseContains("Mark this user as favourite");

// He can't rate it
$t->checkResponseElement("body", "!/Rate it 5 stars/");
$t->enable($USERID, 33);
$t->login($USERNAME, $PASSWORD, '/en/artwork/show/4/Fingers')
// But now he can
  ->checkResponseElement("body", "/Rate it 5 stars/");

// He can't upload anything
$t->checkResponseElement("body", "!/Upload artwork now/");
$t->enable($USERID, 31);
$t->login($USERNAME, $PASSWORD, '/en/artwork/show/4/Fingers')
// But now he can
  ->checkResponseElement("body", "/Upload artwork now/");
 
// He can't send messages
$t->checkResponseElement("body", "!/Write new/");
$t->enable($USERID, 32);
$t->login($USERNAME, $PASSWORD, '/en/artwork/show/4/Fingers')
// But now he can
  ->checkResponseElement("body", "/Write new/");


