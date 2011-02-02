<?php

/**
 * Tag an article with an associated format so that users will see my help
 * article when viewing artwork in the chosen format
 *
 * PHP Version 5
 *
 * @author    Hannes Magnusson <bjori@linpro.no>
 * @copyright 2008 Linpro AS
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 *
 */
include(dirname(__FILE__).'/../../bootstrap/functional.php');
function disable($ids)
{
  foreach((array)$ids as $id)
  {
    $article = ArticlePeer::retrieveByPK($id);
    $article->setDraft();
    $article->save();
  }
}

// Disable the theme article, internal article and mypage article in the fixtures
disable(array(4, 7, 9));


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
  "article_type"    => ArticlePeer::HELP_ARTICLE,
  "article_title"   => "Article1",
  "article_ingress" => "",
  "article_content" => "This is my article",
);
foreach($article as $opt => $val)
{
  $b->setField($opt, $val);
}

// Save as draft so we can associate artworks to it
$b->click("Save and continue");
$b->isStatusCode(302)->followRedirect();

// We have to associate a subreatkor to the help article
$b->post("/no/artwork/categoryAction", array("articleId" => 12, "subreaktorClick" => 1, "subreaktorChecked" => array(1)))->isStatusCode(200);
$b->get("/no/admin/article/edit/12");

// Publish it
$b->setField("status", ArticlePeer::PUBLISHED);
$b->click("Save changes");
$b->isStatusCode(302)->followRedirect();

// Check for the subreaktor / formats checkboxes
$b->checkResponseElement('div#subreaktor_list input[value="7"]', false); # Groruddals
$b->checkResponseElement('div#subreaktor_list input[value="1"]', true); # Foto
$b->checkResponseElement('div#subreaktor_list input[value="2"]', true); # Tegning/grafikk
$b->checkResponseElement('div#subreaktor_list input[value="3"]', true); # Film/Animasjon

// Add a tag to the article
$b->setField("tags", "russ");
$b->click("Add");

// Retrieve a known help article
$b->get("/no/admin/article/edit/1");

// Check for the subreaktor / formats checkboxes
$b->checkResponseElement('div#subreaktor_list input[value="7"]', false); # Groruddals
$b->checkResponseElement('div#subreaktor_list input[value="1"][checked]', true); # Foto
$b->checkResponseElement('div#subreaktor_list input[value="2"]', true); # Tegning/grafikk
$b->checkResponseElement('div#subreaktor_list input[value="3"]', true); # Film/Animasjon


// Couple of fixtures articles have the 'latin' tag
$b->get("/no/tags/find/tag/latin");
$b->checkResponseElement("div#article_search_tag_latin", "*Lorem Ipsum*");
$b->checkResponseElement("div#article_search_tag_latin", "*What is Lorem Ipsum?*");

// Check for our new article
$b->get("/no/tags/find/tag/russ");
$b->checkResponseElement("div#article_search_tag_russ", "*Article1*");


