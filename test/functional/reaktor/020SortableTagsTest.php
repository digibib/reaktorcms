<?php
/**
 *
 * Tag result lists should be sortable by:
 *        - title
 *        - date
 *        - rating
 *        - username
 *
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

$t->get("/no/");
$tags = array("car", "cute", "abigail", "grass");
$t->setField("tag", implode(", ", $tags));
$t->click("Find");

// Tags are alphabetically sorted
sort($tags);

foreach(array("title", "date", "rating", "username") as $sortby)
{
  foreach(array("asc", "desc") as $dir)
  {
    $t->click($sortby);
    foreach($tags as $tag)
    {
      $dates = $users = $titles = array();
      $t->responseContains("Work tagged with $tag");
      $container = $t->getResponseDom()->getElementById("artwork_search_tag_" .$tag);
      foreach($container->getElementsByTagName("div") as $div)
      {
        if ($div->getAttribute("class") != "searchresult_row")
        {
          continue;
        }

        $titles[] = $div->getElementsByTagName("h4")->item(0)->getElementsByTagName("a")->item(0)->nodeValue;
        $users[]  = $div->getElementsByTagName("h4")->item(0)->getElementsByTagName("span")->item(0)->nodeValue;
        foreach($div->getElementsByTagName("span") as $item)
        {
          if ($item->getAttribute("class") == "upload_time")
          {
            $dates[] = strtotime($item->nodeValue);
            break;
          }
        }
      }

      $t->test()->pass("Testing $tag - $sortby - $dir");
      switch($sortby) {
        case "date":
          $odates = $dates;
          sort($dates);
          if ($dir == "desc")
          {
            $dates = array_reverse($dates);
          }
          $t->test()->ok($odates === $dates, "Dates are correctly sorted");
          break;

        case "title":
          $otitles = $titles;
          natsort($titles);

          if ($dir == "desc")
          {
            $titles = array_reverse($titles);
          }
          $t->test()->ok($titles === $otitles, "Titles alphabetically sorted");
          break;

        case "rating":
          $t->test()->todo("How the heck? Parse the image names or what?"); # TODO
          break;

        case "username":
          $users = array_unique($users); # Workaround annoying feature of the natural sorting algorithm, stupid quicksort based sorts algos!!
          $ousers = $users;
          natsort($users);

          if ($dir == "desc")
          {
            $users = array_reverse($users);
          }
          $t->test()->ok($users === $ousers, "Usernames alphabetically sorted");

          break;
        default:
          $t->test()->fail("Unknown sort: $sortby");
      }
    }
  }
}


