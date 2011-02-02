<?php
/**
 * Functional test for testing mypage
 * 
 * PHP Version 5
 *
 * @author    Olepw <olepw@linpro.no>
 * @author    Russ  <russ@linpro.no>
 * 
 * @copyright 2008 Linpro AS
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 *
 */

include(dirname(__FILE__).'/../../bootstrap/functional.php');

$nick = "monkeyboy";
// create a new test browser
$b = new reaktorTestBrowser();
$b->initialize();

// Try to be here without being logged in
$b->get("/no/mypage/". $nick); 
$b->isStatusCode(404);

$b->setField('password', $nick);
$b->setField('username', $nick);
$b->click('Sign in');
$b->isRedirected()->followRedirect();

$b->isRequestParameter('module', 'profile');
$b->isRequestParameter('action', 'myPage');

//Now we are logged in, we should see our daddy in the latest commented list
$b->checkResponseElement("div#latestcommented", "/Fingers/");

$b->checkResponseElement("div#content_main", "/My artwork/");

$b->checkResponseElement("div#mypage_left", "/Recieved comments/");
$b->checkResponseElement("div#mypage_left", "/Not me/");

$b->checkResponseElement("div#mypage_left", "/My latest commented artworks/");
$b->checkResponseElement("div#mypage_left", "/Fingers/");

$b->checkResponseElement("div#content_main", "/a favourite with/");
$b->checkResponseElement("div#content_main", "/dave/");

$b->checkResponseElement("div#content_main", "/My favourite users/");
$b->checkResponseElement("div#content_main", "/admin/");

$b->checkResponseElement("body", "/My favourite artworks/");
$b->checkResponseElement("body", "/The fancy gallery/");

$b->checkResponseElement("body", "/Users with shared interests/");
$b->checkResponseElement("body", "/There are no users with matching interests\./");

$b->checkResponseElement("body", "/Written comments/");
$b->checkResponseElement("body", "/Music to my ears/");
$b->checkResponseElement("body", "/All comments/");

$b->checkResponseElement("div#mypage_right", "/Manage my artworks/");
$b->checkResponseElement("div#mypage_right", "/manage and order artwork/");

$b->checkResponseElement("div#mypage_right", "/My resources /");
$b->checkResponseElement("div#mypage_right", "/http:\/\/vg.no/");
$b->checkResponseElement("div#mypage_right", "/Add a resource/");

$b->checkResponseElement("div#mypage_right", "/My favourite articles/");
$b->checkResponseElement("div#mypage_right", "/There are no favourites in this list/");
Favourite::ADDFavourite(3, "article", 2);
$b->reload();
$b->checkResponseElement("div#mypage_right", "!/There are no favourites in this list/");
$b->checkResponseElement("div#mypage_right", "/What is up in the tech world/");


?>
