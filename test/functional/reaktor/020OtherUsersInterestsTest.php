<?php
/**
 * Other users with same interests as you (random 5)
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
$b = new reaktorTestBrowser();
$b->initialize();

$users = array(
  2, # monkeyboy
  4, # leo
  7, # languageboy
);

foreach($users as $userid)
{
  $username = sfGuardUserPeer::retrieveByPK($userid)->getUsername();
  $isthisguyreallyinterestedinphoto = false;
  foreach(range(1, 2) as $i)
  {
    // Login
    $b->login($username, $username);

    // Fetch his current interests
    $interests = UserInterestPeer::retrieveByUser($userid);
    foreach((array)$interests as $interestObj) {
      $interest = $interestObj->getSubreaktorId();
      $userIds = UserInterestPeer::retrieveUsersIdLiking($interest);

      foreach($userIds as $matchingUser) {
        $matchusername = sfGuardUserPeer::retrieveByPK($matchingUser->getUserId())->getUsername();
        // If another user likes the same stuff as I do, and he isn't me
        if ($matchusername != $username)
        {
          $b->login($matchusername, $matchusername)->isStatusCode(200);
          $b->get("/no/mypage/$matchusername")->isStatusCode(200);
          // Then I should show up on his interests page
          $b->checkResponseElement("div#matcing_interests_user_list ul", "*$username*");

          // And he on mine
          $b->login($username, $username)->get("/no/mypage/$username")->isStatusCode(200);
          // Then I should show up on his interests page
          $b->checkResponseElement("div#matcing_interests_user_list ul", "*$matchusername*");
        }
      }
    }
    if (!$isthisguyreallyinterestedinphoto) {
      $isthisguyreallyinterestedinphoto = true;

      $b->login($username, $username);
      $b->get("/no/profile")->isStatusCode(200);
      // he didn't like photos, but now he does!
      $b->setField("Foto", 1);
      $b->click("Save changes")->isRedirected()->followRedirect()->isStatusCode(200);
    }
  }
}

