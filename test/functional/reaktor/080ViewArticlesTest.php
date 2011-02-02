<?php
/**
 * Test for article viewing
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

function publish($b, $type, $title = null, $intro = null, $content = null)
{
  return $b
    ->setField("article_type", $type)
    ->setField("article_title", $title)
    ->setField("article_ingress", $intro)
    ->setField("article_content", $content)
    ->click("Save and continue")
    ->isStatusCode(302)
    ->isRedirected()->followRedirect()
    ->setField("status", ArticlePeer::PUBLISHED)
    ->setField("frontpage", 1)
    ->click("Save changes")
    ->isStatusCode(302)
    ->isRedirected()->followRedirect();
}
$b
  ->login("articleboy", "articleboy", "/no/admin/article/create")
  ->isStatusCode(200)
  ->isRequestParameter('module', 'articles')
  ->checkResponseElement('div#article_main_container h2', '*Create new article*');

$title = "This is a test article";
$permlink = "This_is_a_test_article";
$intro = "This article has no content so only the ingress should show up";

// Write a regular article
publish($b, ArticlePeer::REGULAR_ARTICLE, $title, $intro)->logout();

$b->get("/");

// Make sure it shows up on the frontpage
$b
  ->checkResponseElement("div#navigation_block_wrapper .article_summary_block", "*$title*")
  ->checkResponseElement("div#navigation_block_wrapper .article_summary_block", "*$intro*");

// Userboy should not see any articles in "my page articles"
$b->login("userboy", "userboy", "/no/mypage/userboy");
$b->checkResponseElement("div#mypage_articles ul", false);

// Make sure we can access the list of articles
$b
  ->login("articleboy", "articleboy", "/no/admin/articles/list")
  ->isStatusCode(200);

// Retrieve the recently submitted article
$b->get("/no/admin/article/edit/12")
  ->isStatusCode(200);
// And change the article to mypage article
$b->setField("article_type", ArticlePeer::MY_PAGE_ARTICLE);
$b->click("Save changes")
  ->isStatusCode(302)
  ->isRedirected()->followRedirect();

// Now userboy should see the article on mypage
$b->login("userboy", "userboy", "/no/mypage/userboy");
$b->checkResponseElement("div#mypage_articles ul", true);
$b->checkResponseElement("div#mypage_articles ul li", "*$title*");

// Log in as articleboy
$b->login("articleboy", "articleboy", "/no/admin");
// He shouldn't see any internal articles now
$b->checkResponseElement("div#internal_articles ul", false);

// But if we change the article to internal one..
$b->get("/no/admin/article/edit/12")
  ->isStatusCode(200);
$b->setField("article_type", ArticlePeer::INTERNAL_ARTICLE);
$b->click("Save changes")
  ->isStatusCode(302)
  ->isRedirected()->followRedirect();

// Admin should see the article now
$b->checkResponseElement("div#internal_articles ul", true);
$b->checkResponseElement("div#internal_articles ul li", "*$title*");

// And be able to view it
$b->get("/no/article/$permlink")->isStatusCode(200)->responseContains($intro);


// But monkeyboy, or unlogged in user, on the other hand can't
$b->login("monkeyboy", "monkeyboy", "/no/article/$permlink")->isStatusCode(404);
$b->logout();
$b->get("/no/article/$permlink")->isStatusCode(404);

// Log in as articleboy
$b->login("articleboy", "articleboy", "/no/admin");
// Associate an subreaktor with the article
$b->post("/no/artwork/categoryAction", array("articleId" => 12, "subreaktorClick" => 1, "subreaktorChecked" => array(1)))->isStatusCode(200);

// Reclassify the article as help article
$b->get("/no/admin/article/edit/12")
  ->isStatusCode(200)
  ->setField("article_type", ArticlePeer::HELP_ARTICLE)
  ->click("Save changes")
  ->isStatusCode(302)
  ->isRedirected()->followRedirect()
  ->setField("tags", "upload")
  ->click("Add");

// H4X0R it to be in the foto subreaktor
$b->post("/no/artwork/categoryAction", array("articleId" => 12, "subreaktorClick" => 1, "subreaktorChecked" => array(1)))->isStatusCode(200);
// H4X0R the category 'mannesker'
$b->post("/no/artwork/categoryAction", array("articleId" => 12, "add" => 8))->isStatusCode(200);


// We should now see the help article on the fancy gallery page
$b->logout();
$b->get("/no/artwork/show/2/The+fancy+gallery")
  ->checkResponseElement("div.colored_article_container", true)
  ->checkResponseElement("div.colored_article_container ul li", "*$title*");


