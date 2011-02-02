<?php

/**
 * Write an article and edit it
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

// Access articles without logging in
$b->get("/no/admin/article/edit/browse/artworks/1")
  ->isStatusCode(404)
  ->isRequestParameter("module", "artwork")
  ->responseContains("or you do not have the required permissions");

// Normal users shouldn't be able either
$b->login("monkeyboy", "monkeyboy", "/no/admin/article/edit/browse/artworks/1")
  ->isStatusCode(404)
  ->isRequestParameter("module", "artwork")
  ->responseContains("you do not have the required permissions to access this content");

// But admin can
$b->login("admin", "admin", "/no/admin/article/create")
  ->isStatusCode(200)
  ->isRequestParameter("module", "articles")
  ->isRequestParameter("action", "edit")
  ->responseContains("Create new article");

// Write an article
$article = array(
  "article_type"    => 1,
  "article_title"   => "Article1",
  "article_ingress" => "",
  "article_content" => "This is my article",
);
foreach($article as $opt => $val)
{
  $b->setField($opt, $val);
}

// Save as draft so we can associate artworks to it
$b->click("Save and continue");#->isStatusCode(302)->isRedirected()->followRedirect();

// Since this is all javascript we cannot really test it, except checking if the 
// functionality exists there
$b->get("/no/admin/article/edit/browse/artworks/1");
  $b->responseContains("The fancy gallery")
  ->responseContains("My Pdf")
  ->responseContains("Fingers")
  ->responseContains("Embed this artwork")
  ->responseContains("Relate this artwork");

// Only show artworks tagged with russ
$b->setField("filter", "russ");
$b->click("Filter by tag")
  ->responseContains("The fancy gallery")
  ->responseContains("My Pdf")
  ->checkResponseElement("artworkslist", "!/Fingers/")
  ->checkResponseElement("artworkslist", "!/Nice monkeys/");



