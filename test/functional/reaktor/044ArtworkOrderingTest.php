<?php
/**
 * Testing artwork reordering
 * 
 *  
 * PHP version 5
 * 
 * @author    Ole-Petter Wikene <olepw@linpro.no>
 * @copyright 2008 Linpro AS
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 */

include(dirname(__FILE__).'/../../bootstrap/functional.php');

// create a new test browser
$b = new reaktorTestBrowser();
$b->initialize();

//log in

$b->get('/en');

$b->setField('username', 'monkeyboy');
$b->setField('password','monkeyboy');
$b->click('Sign in');

$b->isRedirected()->followRedirect();

$b->checkResponseElement("div#user_summary .nickname", "monkeyboy");

//check for javascript code and page title
$b->get('/en/mypage/content/manage/allartwork');
$b->responseContains('My Artworks');
$b->responseContains('Sortable.create');


//check that we have all artworks in list
$c = new Criteria();
$c->addJoin(SfGuardUserPeer::ID,ReaktorArtworkPeer::USER_ID);
$c->add(SfGuardUserPeer::USERNAME,'monkeyboy');
$artworks = ReaktorArtworkPeer::doSelect($c);
foreach ($artworks as $artwork)
{
  $b->responseContains($artwork->getTitle());
}

?>
