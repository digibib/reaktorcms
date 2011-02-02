<?php 
/**
 * Test for rejecting unsuitable content
 *
 * PHP version 5
 *
 * @author    Ole-Petter Wikene <olepw@linpro.no>
 * @copyright 2008 Linpro
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 */


include(dirname(__FILE__).'/../../bootstrap/functional.php');

// create a new test browser
$b = new reaktorTestBrowser();
$b->initialize();

//First we check that the security is up for viewing list of artworks under discussion
$b->
  get("/no/admin/tags/list/page/ALL")->  
  isStatusCode(200)->
  isRequestParameter('module', 'tags')->
  isRequestParameter('action', 'listTags')->
  checkResponseElement('div#secure_notice p','*You need to log in*');
  
$b->
  setField('password', 'userboy')->
  setField('username', 'userboy')->
  click('Sign in')->  
  isRedirected()->
  followRedirect()->
  isStatusCode(200)->
  checkResponseElement('div#content_main p','You don\'t have the requested permission to access this page.');
  
$b->click('Log out')->
  isRedirected()->
  followRedirect()->
  isStatusCode(200);

$b->
  get("/no/admin/tags/list/page/ALL")->
  setField('password', 'admin')->
  setField('username', 'admin')->
  click('Sign in')->  
  isRedirected()->
  followRedirect()->
  isStatusCode(200)->
  checkResponseElement('div#content_main p','!*You don\'t have the requested permission to access this page*');
  
  //get all tags from DB
  $c = new Criteria();
  $c->addAscendingOrderByColumn(TagPeer::NAME);
  $tags = TagPeer::doSelect($c);
  
  //check that they are all displayed
  $content = $b->getResponse()->getContent();
  $tag = current($tags);
  $b->checkResponseElement("div#content_main", "/".$tag->getName()."/");

  foreach ($tags as $tag)
  {
    $b->checkResponseElement("div#content_main", "/".$tag->getName()."/");
  }

  $b->get("/no/admin/tags/unapproved/page/ALL");
  foreach ($tags as $tag)
  {
    if ($tag->getApproved() == 0)
      $b->responseContains($tag->getName());
    else
      $b->checkResponseElement('div#content_main','!/ '.$tag->getName().' /');
  }

  //get unapproved tags from DB
  $c = new Criteria();
  $c->addAscendingOrderByColumn(TagPeer::NAME);
  $c->add(TagPeer::APPROVED,0);
  $tags = TagPeer::doSelect($c);
  
    //test approval and so on for a few tags
  $count = 0;
  foreach ($tags as $tag)
  {
    if (++$count == 3)
      break;
    $b->get("/no/admin/tags/unapproved/page/ALL");
    $b->responseContains($tag->getName());
	/*
    TagPeer::approveTagByName($tag->getName(),1);
    $b->get("/no/admin/tags/unapproved/page/ALL");
    $b->checkResponseElement('body','!/ '.$tag->getName().' /');
	*/
    
  }
  $fileId = 3;
  $randomTag = "randomTag_".md5(time());
  $thisFile = new artworkFile($fileId);
  $b->get("/no/upload/edit/".$fileId);
  $b->checkResponseElement('body','!/'.$randomTag.'/');
  $thisFile->addTag($randomTag,true,true);
  $b->get("/no/upload/edit/".$fileId);
  $b->checkResponseElement('body','/'.$randomTag.'/');
  $b->get("/no/admin/tags/unapproved/page/ALL");
  $b->checkResponseElement('body','/'.$randomTag.'/');
  TagPeer::approveTagByName($randomTag,1);
  $b->get("/no/admin/tags/unapproved/page/ALL");
  $b->checkResponseElement('body','!/'.$randomTag.'/');
  
  $thisFile->removeTag($randomTag,true,true);
  $b->get("/no/upload/edit/".$fileId);
  $b->checkResponseElement('body','!/'.$randomTag.'/');
