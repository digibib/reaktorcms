<?php

include(dirname(__FILE__).'/../../bootstrap/functional.php');

$browser = new sfTestBrowser();
$browser->initialize();

$browser->
  get('/artwork/show/6/Dolor+Sit')->
  isStatusCode(200)->
  isRequestParameter('module', 'artwork')->
  isRequestParameter('action', 'show')->
  checkResponseElement('body', '!/This is a temporary page/')
;

