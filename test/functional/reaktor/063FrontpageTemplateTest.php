<?php
/**
 * This story is mostly styling, which is easier to check visually. The
 * javascript changing of text can be done with selenium, but is probably not
 * worth it, not at this stage.
 * 
 * This functional test covers:
 * Checking that the page exist
 * That it shows the main headers correctly
 *
 *  
 *
 * PHP version 5
 *
 * @author juneih <juneih@linpro.no>
 * @copyright 2008 Linpro
 * @license http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 */
include(dirname(__FILE__).'/../../bootstrap/functional.php');


// create a new test browser
$browser = new reaktorTestBrowser();
$browser->initialize();

//Check page exist and that the headers are correct
$browser->
  get('/en')->
  isStatusCode(200)->
  isRequestParameter('module', 'home')->
  isRequestParameter('action', 'index')->
  checkResponseElement('h1#recommend', '/We recommend/')->
  checkResponseElement('h1#toprated', '/Most popular/')->
  checkResponseElement('h1#latest', '/Latest/')
  
;
 
