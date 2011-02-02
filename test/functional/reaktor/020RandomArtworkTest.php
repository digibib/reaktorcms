<?php
/**
 *
 * Random artwork list should not contain artworks from other lists, such as 
 * "most popular", "latest artwork", "we recommend" + other lists on frontpage
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


# Run these checks few times as the minithumbs are randomly picked
foreach(range(1, 5) as $i)
{
  $b->test()->pass("Loop#$i");
  // Iterate over few reaktors
  foreach(array("", "/foto", "/tegning", "/film", "/lyd", "/tegneserier") as $uri)
  {
    $b->get("/no$uri");
    $dom = $b->getResponseDom();
    $home = $dom->getElementById("home_content");

    $thumbs = $hrefs = array();
    // Fetch all the bigthumbnails
    foreach($home->getElementsByTagName("div") as $div)
    {
      if (strpos($div->getAttribute("class"), "big_artwork") !== false)
      {
        foreach($div->getElementsByTagName("div") as $subdiv)
        {
          if (strpos($subdiv->getAttribute("class"), "big_thumbnail") !== false)
          {
            $link    = $subdiv->getElementsByTagName("a");
            // Skip missing bigthumbnails (nothing in the reaktor)
            if (!$link->length)
            {
              $b->test()->pass("No bigthumbnail here");
              continue;
            }
            // Fetch the link
            $hrefs[] = $link->item(0)->getAttribute("href");
          }
        }
      }
    }
    // Make sure we didn't get to many bigthumbnails
    # To many means either fault in the logic above or changed frontpages
    $b->test()->ok(count($hrefs) < 4, "At most three big thumbnails");

    // Fetch the minithumbs id
    $minithumbs = $dom->getElementById("minithumbs");
    if (!$minithumbs) {
      $b->test()->pass("No thumbnails, probably because the reaktor has to little test data");
      continue;
    }
    // And iterate over all the minithumbs
    foreach($minithumbs->getElementsByTagName("li") as $li)
    {
      $link = $li->getElementsByTagName("a")->item(0)->getAttribute("href");
      // Make sure thei aren't the same as the bigthumbs
      $b->test()->ok(!in_array($link, $hrefs), "Check if the minithumblink is one of the bigthumbnails");
      // And make sure the same minithumb isn't twice
      $b->test()->ok(!in_array($link, $thumbs), "Check if the minithumblink is only once");
      $thumbs[] = $link;
    }
  }
}


