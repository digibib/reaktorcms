<?php

include(dirname(__FILE__).'/../../bootstrap/functional.php');

// create a new test browser
$b = new sfTestBrowser();
$b->initialize();

$b->
  get('/upload')->
  isStatusCode(200)->
  isRequestParameter('module', 'upload')->
  isRequestParameter('action', 'upload')->
  checkResponseElement('body', '/You need to log in/');

$b->setField('password', 'admin');
$b->setField('username', 'admin');
$b->click('Sign in')->isRedirected()->followRedirect();
//$b->checkResponseElement('div#upload_wrapper div', '*Switch mediatype:*');
// FIXME: must update test so it works with inline editing
/*$b->click('Type a text artwork online'); //->isRedirected()->followRedirect();
$c = new Criteria();
$c->add(ReaktorFilePeer::IDENTIFIER,'text');
$textFiles = ReaktorFilePeer::doSelect($c);
$file = array_shift($textFiles);

$b->get('/upload/edit/'.$file->getId());
$b->responseContains("tinyMCE.init");

$c = new Criteria();
$c->add(ReaktorArtworkPeer::ARTWORKTYPE,'text');
$textArtworks = ReaktorArtworkPeer::doSelect($c);
$artwork = array_shift($textArtworks);

$b->get('/artwork/show/'.$artwork->getId().'/'.$artwork->getTitle());
$b->isStatusCode(200);
$b->click('Switch to edit mode');
$b->responseContains("tinyMCE.init");*/