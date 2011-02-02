<?php

include(dirname(__FILE__).'/../../bootstrap/functional.php');

// create a new test browser
$browser = new reaktorTestBrowser();
$browser->initialize();

// Insert bunch of bogus artworks to make the latest random artwork list happy
for ($i = 0; $i< 10; $i++) {
  $artwork = new genericArtwork();
  $artwork->setUserId(2);
  $artwork->changeStatus(1, 3);
  $artwork->save();

  $artworkFile = new artworkFile;
  $artworkFile->setUserId(3);
  $artworkFile->save();

  $artwork->addFile($artworkFile);
  $artwork->save();
}

$browser->
  get('/en')->
  isStatusCode(200)->
  isRequestParameter('module', 'home')->
  isRequestParameter('action', 'index')->
  checkResponseElement('div#recommend_block h1', '*We recommend*')->
  checkResponseElement('ul.my_page_image_list', true);

