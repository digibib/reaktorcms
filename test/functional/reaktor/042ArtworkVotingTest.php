<?php
/**
 * Testing rejectedArtwork Reconsideration
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

//check that we can't vote when not logged in (looking for the html snippet that should show when not able to vote
$b->get('/no/artwork/show/2/The+fancy+gallery');
$b->responseContains('<ul class="star-rating-non-interactive"><li class="current-rating"><img src="/images/reaktor_full_blue.gif" alt="Reaktor_full_blue" />');
$b->responseContains("Please login to vote");

$b->get('/no');
//check that we can vote when logged in (it's ajax, so we're justlooking for a snipet of the java code
$b->setField('username', 'monkeyboy');
$b->setField('password','monkeyboy');
$b->click('Sign in');


$b->isRedirected()->followRedirect();

$b->checkResponseElement("div#user_summary .nickname", "monkeyboy");
$b->get('/no/artwork/show/2/The+fancy+gallery');
$b->responseContains('{asynchronous:true, evalScripts:true, onComplete:function(request, json){new Effect.Appear(\'rating_message_');

?>
