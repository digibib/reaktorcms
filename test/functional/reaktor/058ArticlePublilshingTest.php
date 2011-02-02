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

function change($b, $article)
{
  foreach($article as $id => $value)
  {
    $b->setField($id, $value);
  }
  return $b;
}

function verify($b, $article, $saved = false)
{
  // Check and see if all our fields are still there
  foreach($article as $id => $value)
  {
    switch($id)
    {
    case "article_type":
      $b->checkResponseElement('body select[id="'.$id.'"] option[value="'.$value.'"][selected]', true);
      break;

    case "article_title":
      if ($article["article_type"] == ArticlePeer::FOOTER_ARTICLE)
      {
        // Translations default to the norwegian title, if no other specified on 
        // save
        if ($saved)
        {
          $langs = array("no" => $value, "nn" => $value, "en" => $value);
        }
        else
        {
          $langs = array("no" => $value, "nn" => "", "en" => "");
        }
        foreach ($langs as $lang => $title)
        {
          $b->checkResponseElement('body input[id="'.$id.'_i18n_'.$lang.'"][type="text"][value="'.$title.'"]');
        }
        break;
      }
      // break omitted intentionally
    case "article_ingress":
      $b->checkResponseElement('body input[id="'.$id.'"][type="text"][value="'.$value.'"]');
      break;

    case "article_content":
      $b->checkResponseElement('body textarea#'.$id, $value);
      break;
    }
  }
  return $b;
}

// create a new test browser
$b = new reaktorTestBrowser();
$b->initialize();

// Access articles without logging in
$b->get("/no/admin/article/create")
  ->isStatusCode(404)
  ->isRequestParameter('module', 'articles')
  ->isRequestParameter('action', 'edit')
  ->responseContains("do not have the required permissions to access this content");

// Normal users can't create articles
$b->login("monkeyboy", "monkeyboy", "/no/admin/article/create")
  ->isStatusCode(404)
  ->isRequestParameter('module', 'articles')
  ->isRequestParameter('action', 'edit')
  ->responseContains("do not have the required permissions to access this content");

// Only articleboy can
$b->login("articleboy", "articleboy", "/no/admin/article/create")
  ->isStatusCode(200)
  ->isRequestParameter('module', 'articles')
  ->isRequestParameter('action', 'edit')
  ->responseContains("Create new article");


// Write an article
$articles = array(
  array(
    "article_type"    => ArticlePeer::HELP_ARTICLE,
    "article_title"   => "Article1",
    "article_ingress" => "",
    "article_content" => "This is my article",
  ),
  array(
    "article_type"    => ArticlePeer::THEME_ARTICLE,
    "article_title"   => "Article2",
    "article_ingress" => "This is an ingress which I am writing now",
    "article_content" => "This is not really my article, honestly",
  ),
  array(
    "article_type"    => ArticlePeer::INTERNAL_ARTICLE,
    "article_title"   => "Article3",
    "article_ingress" => "I don't know if I need to specify this",
    "article_content" => "asdfkljalkdf asdlkfj asdflkj",
  ),
  array(
    "article_type"    => ArticlePeer::FOOTER_ARTICLE,
    "article_title"   => "Article4",
    "article_ingress" => "",
    "article_content" => "But This should be the one is not really my article, honestly",
  ),
  array(
    "article_type"    => ArticlePeer::MY_PAGE_ARTICLE,
    "article_title"   => "Article5",
    "article_ingress" => "ritney to the B",
    "article_content" => "I'm not a girl. Not yet a woman. All I need is time.",
  ),
  array(
    "article_type"    => ArticlePeer::REGULAR_ARTICLE,
    "article_title"   => "Article6",
    "article_ingress" => "",
    "article_content" => "Bored of writing content.",
  ),
  array(
    "article_type"    => ArticlePeer::SPECIAL_ARTICLE,
    "article_title"   => "Article7",
    "article_ingress" => "",
    "article_content" => "Handycapped article?",
  ),
);


foreach($articles as $article)
{

  $b->get("/no/admin/article/create");
  // Save the article as draft
  change($b, $article)->click("Save and continue")->isRedirected()->followRedirect();

  // Make sure we are now editing the article
  $b->responseContains("Editing article")
    ->checkResponseElement("div.createdby_block", "*articleboy*")
    ->checkResponseElement("div.updatedby_block", "!*articleboy*");

  verify($b, $article);

  // Change the content
  $article["article_content"] .= "*CHANGED*";
  change($b, $article)->click("Save changes")->isRedirected()->followRedirect()->checkResponseElement("div.updatedby_block", "*articleboy*");
  verify($b, $article, true);

  // Change 
  do {
    $article["article_type"] = rand(1, 6);
  } while($article["article_type"] == ArticlePeer::FOOTER_ARTICLE);
  change($b, $article)->click("Save changes")->isRedirected()->followRedirect();
  verify($b, $article, true);
}
/*
Fleh... This is all AJAX (which XHMLHttpRequest checks) so we cannot test it :(
// OK. Now we have 5 draft articles. Lets try to relate few of them
// to published articles (from the fixtures)

// We only have two articles in the fixtures so our first inserted article is nr3
$b->get("/no/admin/article/edit/3");
// Relate Lorem Ipsum to article#3
$b->setField("relate_article_select", array(2));
$b->click("Relate article");
# Since its an AJAX request we need to reload the page
$b->get("/no/admin/article/edit/3");
// Did it work?
$b->checkResponseElement("ul#related_articles ul", "*Lorem Ipsum*");
*/

