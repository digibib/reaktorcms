<?php
/**
 * Functional tests for user story 46 - Embed Artwork
 * 
 * Fred needs to publish his artwork of othersites so that he can reach
 * a broader audience
 *
 *
 * This test should cover:
 * - See a link to embed artwork on another site
 * - View my artwork on another site with a link back to reaktor
 * - "Bookmark with" (social engines
 *
 *
 * PHP version 5
 *
 * @author bjori <bjori@linpro.no>
 * @copyright 2008 Linpro
 * @license http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 */

include(dirname(__FILE__).'/../../bootstrap/functional.php');

$t = new reaktorTestBrowser();
$t->initialize();

// Approve a graphic
$foo = new genericArtwork(10);
$foo->changeStatus(1, 3);

define("IMAGE",   1);
define("PDF",     0);
define("GRAPHIC", 1);

// URLs we are going to test
$urls = array(
  "/no/artwork/show/2/The+fancy+gallery" => IMAGE,
  "/no/artwork/show/3/My+Pdf"            => PDF,
  "/no/artwork/show/10/Magic+roundabout+-+Swindon" => GRAPHIC,
);

foreach($urls as $URL => $item) {
  // Open up an artwork page
  $t->get($URL);

  $pageDom = $t->getResponseDom();
  $artwork = $pageDom->getElementById("artwork_div")->getElementsByTagName("a")->item(0);
  $artimg = $pageDom->getElementById("artwork_div")->getElementsByTagName("img")->item($item);

  // Check if "Embed this artwork on another website" works
  $embed    = $pageDom->getElementById("embed_link")->getAttribute("value");
  $text     = html_entity_decode($embed); # All the HTML is escaped
  $tmp      = new DomDocument('1.0', sfConfig::get('sf_charset'));
  $tmp->validateOnParse = true;
  $tmp->loadHTML($text); # Load the content of <input id="embed_link" value="" /> into dom

  $a      = $tmp->getElementsByTagName("a")->item(0);
  // Match the embedded link title to the artwork title
  $alt    = $a->getAttribute("alt");
  $t->test()->is($alt, $artwork->getAttribute("title"), "Check if the embedded link title matches the artwork title");

  // Match the embedded link url
  $href   = $a->getAttribute("href");
  $path   = parse_url($href, PHP_URL_PATH);
  $t->test()->ok(strpos($path, $URL)!==false, "Check if the embedded link matches the actual artwork uri");

  $img = $tmp->getElementsByTagName("img")->item(0);
  // Match the embedded image title to the artwork title
  $alt = $img->getAttribute("title");
  $t->test()->ok(strpos($alt, $artwork->getAttribute("title"))!==false, "Check if the embedded image title matches the artwork title");

  // Match the embedded image src to the artwork src
  $src = $img->getAttribute("src");
  $path = parse_url($src, PHP_URL_PATH);
  # Note: pdf files add ".jpg" to the url (to workaround bbcode issues) so we 
  # have to just strpos() check it
  $t->test()->ok(strpos($path, $artimg->getAttribute("src"))!==false, "Check if the embedded image src matches the artwork src");


  // Check if the "Direct path to this artwork" is correct
  $embed    = $pageDom->getElementById("file_path")->getAttribute("value");
  $path     = parse_url($embed, PHP_URL_PATH);
  $t->test()->is($path, $artwork->getAttribute("href"), "Check the 'direct path'");

  $bb = $pageDom->getElementById("embed_link_bb")->getAttribute("value");
  $t->test()->ok(strpos($bb, "$URL]") !== false, "Match the BB url against the artwork url");
  $t->test()->ok(strpos($bb, $artimg->getAttribute("src"))!==false, "Match the BB image against the artwork image");
  # Note: BBCode doesn't support titles


  // Social bookmarks

  $social = $pageDom->getElementById("socialBookmarks");
  $bookmarks = $social->getElementsByTagName("li");
  $req = $t->getRequest();
  $HOST = $req->getHost() . $req->getScriptName();
  
  # These use the actual artwork title for some reason
  $title = $pageDom->getElementById("artwork_info_header")->getElementsByTagName("h2")->item(0)->nodeValue;
  foreach($bookmarks as $li) {
    $service = $li->getAttribute("class");
    $onclick = $li->getElementsByTagName("a")->item(0)->getAttribute("onclick");
    if ($service == "print") {
      $js = "window.print(); return false;";
    } else {
      $js = "share" . ucfirst($service) . "('http://" .$HOST. $URL. "', '" . $title. "'); return false;";
    }
    $t->test()->is($onclick, $js, "Check if {$service} link is OK");
  }
}


