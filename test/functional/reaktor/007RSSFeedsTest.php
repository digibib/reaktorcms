<?php
/**
 * Sanitycheck for feeeds
 *
 *
 * Makes sures various feeds are actually feeds and contain correct amount of 
 * entries.
 * 
 * PHP version 5
 * 
 * @author    Hannes Magnusson <bjori@linpro.no>
 * @copyright 2008 Linpro AS
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 */

include(dirname(__FILE__).'/../../bootstrap/functional.php');

// create a new test browser
$b = new reaktorTestBrowser();
$b->initialize();

// Array of feeds
$feeds = array(
  "/no/feed/latest_commented",
  "/no/feed/latest_users",
  "/no/feed/latest_artworks",
  "/no/feed/popular_foto",

  "/no/foto/feed/most_popular",
  "/no/foto/feed/latest_comments",
  "/no/foto/feed/latest_users",
  "/no/foto/feed/latest_artworks",

  "/no/groruddalen/feed/most_popular",
  "/no/groruddalen/feed/latest_users",
  "/no/groruddalen/feed/latest_artworks",
  "/no/groruddalen/feed/latest_comments",

  "/no/groruddalen-foto/feed/most_popular",
  "/no/groruddalen-foto/feed/latest_comments",
  "/no/groruddalen-foto/feed/latest_users",
  "/no/groruddalen-foto/feed/latest_artworks",
);

$maxitems = sfConfig::get('app_rss_artwork_items', 5);
foreach($feeds as $URI) {
  $b->get($URI);
  $b->isStatusCode(200);

  // Retrieve the feed
  $xml = $b->getResponse()->getContent();

  $feed = sfFeedPeer::createFromXML($xml, $URI);

  $items = $feed->getItems();
  // And sanitycheck it
  $b->test()->ok(count($items) <= $maxitems, "Checking for max number of items");
}


