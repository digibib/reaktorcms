<?php

include(dirname(__FILE__).'/../../bootstrap/functional.php');

// create a new test browser
$browser = new reaktorTestBrowser();
$browser->initialize();


$browser->login("admin", "admin")->
  get('/no/admin/article/edit/1/');

