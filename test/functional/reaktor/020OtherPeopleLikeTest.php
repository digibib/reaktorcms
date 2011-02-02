<?php
/**
 * Other people, who like this artwork, also like tests
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


// Approve the wonderful artwork
$aw = new genericArtwork(1);
$aw->changeStatus(1, 3, "hello world");
$aw->save();

$urls = array(
  1 => "/no/artwork/show/1/The+wonderful+painting",
  "/no/artwork/show/2/The+fancy+gallery",
  4 => "/no/artwork/show/4/Fingers",
  8 => "/no/artwork/show/8/Nice+monkeys",
);
foreach($urls as $id => $url)
{
  $c = new Criteria();
  $c->add(FavouritePeer::ARTWORK_ID, $id);
  $favs = FavouritePeer::doSelect($c);

  $t->get($url);
  $div = $t->getResponseDom()->getElementById("related_artwork_imagelist");

  $thumbs = array();
  if (is_object($div))
  {
    foreach($div->getElementsByTagName("a") as $thumb)
    {
      $tmp = trim($t->getResponseDom()->saveXML($thumb));
      $tmp = html_entity_decode($tmp);
      if (preg_match("@<h3>(.*)</h3>@", $tmp, $match))
      {
        $thumbs[] = $match[1];
        $t->test()->pass("Found {$match[1]}");
      }
      else
      {
        $t->test()->fail("Was unable to find title from {$tmp}");
      }
    }
  }

  foreach($favs as $fav)
  {
    $user = sfGuardUserPeer::retrieveByPK($fav->getUserId());
    // Make sure all these users actually like this artwork
    $t->checkResponseElement("div#artwork_actions_and_favourites", "*{$user->getUsername()}*");

    // Then check if any of them like anything else
    $c = new Criteria();
    $c->add(FavouritePeer::USER_ID, $fav->getUserId());
    $c->add(FavouritePeer::FAV_TYPE, "artwork");
    $otherfavs = FavouritePeer::doSelect($c);
    if (count($otherfavs) == 1)
    {
      $t->test()->pass("User only had one favourite");
    }
    else
    {
      $t->test()->pass("User has more favourites");
      foreach($otherfavs as $otherfav)
      {
        if ($otherfav->getArtworkId() != $fav->getArtworkId())
        {
          $artwork = new genericArtwork($otherfav->getArtworkId());
          $text = $artwork->getTitle();
          if (false !== ($i = array_search($text, $thumbs)))
          {
            $t->test()->pass("Found artwork in other favourites");
            unset($thumbs[$i]);
          }
          else
          {
            # This is not neciserally a failure, but since we don't have so much test data 
            # the favs can never outgrow the actual artowkrs :]
            $t->test()->fail("Didn't find artwork in other favs");
            var_dump($text, $thumbs);
          }
        }
      }
    }
  }
}

