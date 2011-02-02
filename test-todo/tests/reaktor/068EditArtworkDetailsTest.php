<?php
/**
 * Editing artwork mostly uses ajax, which is why we can mostly test 
 * functionally for content of the page:
 * 
 *
 * PHP version 5
 *
 * @author juneih <juneih@linpro.no>
 * @copyright 2008 Linpro
 * @license http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 */
/**
 * ZOID: When trying to view edit page when not logged in, should be redirected to a 
 * page saying you have to log in to view it, and not the show page. This means the action
 * has to be rewritten somewhat. 
 */
include(dirname(__FILE__).'/../../bootstrap/functional.php');

// create a new test browser
$b = new sfTestBrowser();
$b->initialize();

//Start browser, and load helpers by getting front page
$b->get('/');

//check that link and action is not available when not logged in
//let's use an image artwork added by a normal user: userboy, with 
//more than one file
$c = new Criteria();

$c->add(sfGuardUserPeer::USERNAME, "userboy");
$c->add(ReaktorArtworkPeer::ARTWORKTYPE, "image");
$genericArtwork = null;
$i=0;
foreach(ReaktorArtworkPeer::doSelectJoinsfGuardUser($c) as $reaktorArtwork)
{
	$i++;
  $genericArtwork = new genericArtwork($reaktorArtwork->getId());
  if(count($genericArtwork->getFiles())>1)
  {
  	break;
  }
}
if(!$genericArtwork)
{
  echo 'userboy has no artworks, most tests after this will fail.';
}

//Navigate to the correct edit page
$b->get(url_for($genericArtwork->getLink('show')))->
    isRequestParameter('module', 'artwork')->
    isRequestParameter('action', 'show')->
    checkResponseElement('a', '!/Switch to edit mode/')->
    get(url_for($genericArtwork->getLink('edit')))->
    checkResponseElement('.editmode', '!/Switch to normal mode/');
    
//verify that editing artwork cannot be accessed if logged in but not owner of artwork
$b->get('/')->
    setField('username', 'monkeyboy')->
    setField('password','monkeyboy')->
    click('Sign in')->
    isRedirected()->
    followRedirect()-> 
    isStatusCode()->
    get(url_for($genericArtwork->getLink('edit')))->   
    checkResponseElement('.editmode', '!/Switch to normal mode/')->
    click('Log out');

//check for correct elements when logged in as owner of artwork
$file = $genericArtwork->getFirstFile();
$b->get('/')->
    setField('username', 'userboy')->
    setField('password','userboy')->
    click('Sign in')->
    isRedirected()->    
    followRedirect()->
    isStatusCode()->
    responseContains('Welcome,<br />userboy!')->
    get(url_for($genericArtwork->getLink('edit')))->  
    isStatusCode()->
    isRequestParameter('module', 'artwork')-> 
    isRequestParameter('action', 'edit')->
    checkResponseElement('.editmode', 'Switch to normal mode')->
    responseContains('add more files to this artwork')->
    responseContains('Remove/unlink from artwork')->    
    checkResponseElement('script[type*="text/javascript"]')->
    checkResponseElement('h2#file_in_focus', $file->getTitle());

   
//Lets remove an image from artwork and add it back again
$b->get(url_for($genericArtwork->getLink('edit', $file->getId())))->
    click('Remove/unlink from artwork')->
    click('Just remove for now (will be available on your uploaded files page)')->
    followRedirect()->
    checkResponseElement('h2#file_in_focus', '!/'.$file->getTitle().'/')->
    get('upload/edit/'.$file->getId()); /*->
    setField("artwork_select", $i)->
    click('Link to selected artwork')->
    isRedirected()->
    followRedirect()->
    responseContains($file->getTitle());*/
    // ZOID: dae says: Fix above, must be updated when subreaktor <-> artwork functionality is back
    
//Lets check if the add link works
$b->get(url_for($genericArtwork->getLink()))->
    click('add more files to this artwork')->
    isStatusCode()->
    isRequestParameter('module', 'upload')->
    isRequestParameter('action', 'upload')->
    checkResponseElement('h1', '/(.*)Add content to "'.$genericArtwork->getTitle().'"/');
    //echo $genericArtwork->getTitle();
    


?>