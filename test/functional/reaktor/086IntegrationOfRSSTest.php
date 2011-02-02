<?php
/**
 * Integration of RSS feeds
 *
 * This is almost impossible to test for, but we can at least make sure the feed 
 * is there...
 *
 * NOTE: This test WILL FAIL if there is no network access, or the feed fetching 
 * timed out.
 * 
 * PHP Version 5
 *
 * @author    Hannes Magnusson <bjori@linpro.no>
 * @copyright 2008 Linpro AS
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 *
 */
// Apparently this functionality is not wanted
return;
include(dirname(__FILE__).'/../../bootstrap/functional.php');

$nick = "admin";
$t = new reaktorTestBrowser();
$t->initialize();

$t->get("/"); 
$t->isStatusCode(200);

// Make sure there is a feed there displaying
$t->checkResponseElement("div#sidebar_articles div.foreignfeed_normal ul li", true);
// With a headline
$t->checkResponseElement("div#sidebar_articles div.foreignfeed_normal ul li h4", "News from Deichman");
// And that there is a link to the original location
$t->checkResponseElement('div#sidebar_articles div.foreignfeed_normal ul a', "*Read more*");


