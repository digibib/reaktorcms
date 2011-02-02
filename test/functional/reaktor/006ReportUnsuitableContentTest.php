<?php 
/**
 * Test for rejecting unsuitable content
 *
 * PHP version 5
 *
 * @author    June Henriksen <juneih@linpro.no>
 * @copyright 2008 Linpro
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 */


include(dirname(__FILE__).'/../../bootstrap/functional.php');

// create a new test browser
$b = new reaktorTestBrowser();
$b->initialize();

//First we check that the security is up for viewing list of artworks under discussion
$b->
  get("/en/admin/list/file/reported")->  
  isStatusCode(404)->
  isRequestParameter('module', 'artwork')->
  isRequestParameter('action', 'listReportedContent');
  
//Lets log in as a non admin user - this user should always exist in test db, page should generate 404 error
$user = sfGuardUserPeer::getByUsername('userboy');
$b->
  setField('password', 'userboy')->
  setField('username', 'userboy')->
  click('Sign in')->  
  isRedirected()->
  followRedirect()->
  isStatusCode(404);
  
//Lets report a file in an artwork as unsuitable

// Get an artwork from the database, that doesn't belong to userboy, and only has one file
$c = new Criteria();
$c->addSelectColumn(ReaktorArtworkFilePeer::ARTWORK_ID);
$c->addSelectColumn('count('.ReaktorArtworkFilePeer::ARTWORK_ID.') as countfiles');
$c->addJoin(ReaktorArtworkPeer::ID, ReaktorArtworkFilePeer::ARTWORK_ID, Criteria::LEFT_JOIN);
$c->add(ReaktorArtworkPeer::STATUS, 3);
$c->add(ReaktorArtworkPeer::USER_ID, $user->getId(), Criteria::NOT_EQUAL);
$c->addGroupByColumn(ReaktorArtworkFilePeer::ARTWORK_ID);
$c->setLimit(1);

$c->addAscendingOrderByColumn(ReaktorArtworkPeer::ACTIONED_AT);
$rs = ReaktorArtworkPeer::doSelectRS($c);

if($rs->next()&&$rs->getInt(2)==1)
{
  $artwork = ReaktorArtworkPeer::retrieveByPK($rs->getInt(1));
  $generic_artwork = new genericArtwork($artwork);
}
else
{
  echo 'There are no artworks with only one file, many of the following tests will fail';
} 


if(!$artwork)
{
  echo "Nothing to test! Following tests will fail. Check fixtures for at least one approved artwork";
}

//Check report unsuitable link is there
$b->
  get(url_for($artwork->getLink()))->
  checkResponseElement('div#unsuitable_content_msg', '*Report unsuitable content*');
//Cheat by reporting file as unsuitable directly in the database (it's ajax), and updating cookie manually
//TODO: the cookies doesn't work.. 

$file            = $generic_artwork->getFirstFile();
$file->reportAsUnsuitable($user);
/* FIXME: The cookie
$b->getResponse()->setCookie('reported_file_'.$file->getId(), 1, time()+60*60*24*10);
$cookies = $b->getResponse()->getCookies();
$b->test()->is($cookies['reported_file_'.$file->getId()]['value'], "1");
*/


$b-> 
  reload()->
#checkResponseElement('span.admin_message', '*You have reported this file*')->
  click('Log out');

//We log in as an admin - this user should also always exist in the test db
//Test that admin has it's own message on the artwork page and that that file is in the
//files reported list
$b->
  get(url_for($artwork->getLink()))->
  setField('password', 'admin')->
  setField('username', 'admin')->
  click('Sign in')->
  isRedirected()->
  followRedirect()->
  isRequestParameter('module', 'artwork')->
  isRequestParameter('action', 'show')->
  checkResponseElement('div.admin_message', '/This content was reported by/')->
  checkResponseElement('div.moderator_block', '*Reject artwork*')->
  get("/en/admin/list/file/reported")->
  isStatusCode(200)->  
  isRequestParameter('module', 'artwork')->
  isRequestParameter('action', 'listReportedContent')->
  checkResponseElement('h4.artwork_list_header', '*'.$file->getTitle().'*');
  
//Report file as OK, check it's removed from from the reported content list
$file->reportAsSuitable($user);

$b->
  reload()->
  isRequestParameter('module', 'artwork')->
  isRequestParameter('action', 'listReportedContent')->  
  checkResponseElement('h4.artwork_list_header', '!/'.$file->getTitle().'/')->
  get(url_for($artwork->getLink()))->
  checkResponseElement('div.admin_message', '*This content has not been reported*')->
  checkResponseElement('div.moderator_block', '*Reject artwork*');
  
//Report file again
$file->reportAsUnsuitable($user);

//Report a file from an artwork with more than one file
$c2 = new Criteria();
$c2->addSelectColumn(ReaktorArtworkFilePeer::ARTWORK_ID);
$c2->addSelectColumn('count('.ReaktorArtworkFilePeer::ARTWORK_ID.') as countfiles');
$c2->addJoin(ReaktorArtworkPeer::ID, ReaktorArtworkFilePeer::ARTWORK_ID, Criteria::LEFT_JOIN);
$c2->add(ReaktorArtworkPeer::STATUS, 3);
$c2->addGroupByColumn(ReaktorArtworkFilePeer::ARTWORK_ID);
$c2->setLimit(1);

$c2->addDescendingOrderByColumn('countfiles');
$rs = ReaktorArtworkPeer::doSelectRS($c2);
if($rs->next()&&$rs->getInt(2)>1)
{
  $m_artwork = ReaktorArtworkPeer::retrieveByPK($rs->getInt(1));
  $m_generic_artwork = new genericArtwork($m_artwork);
}
else
{
  echo 'There are no approved artworks with more than one file, many of the following tests will fail';
} 

$m_file = $m_generic_artwork->getFirstFile();
$m_file->reportAsUnsuitable($user);

//Clicking a button element is as of yet not supported by sftestbrowser, but we can check they're there..
$b->
 get("/en/admin/list/file/reported")->
 checkResponseElement('div#admin_buttons_'.$m_file->getId(), '*Remove from artwork*')->
 responseContains('artwork/removefilemessage/'.$m_file->getId());
 
//Reject artwork with one file, this is thorougly tested with 040ArtworkRejectionTest,
//but we still check that it is removed from the reported files list after being rejected
$b->
  get('/en/artwork/reject/'.$generic_artwork->getId())->
  checkResponseElement('div#content_main h1' ,'/Reject artwork/')->
  checkResponseElement('div.warning' , '/Note! You are about to reject an artwork/')->
  setField('rejectionmsg','This artwork is not appropriate')->
  setField('rejectiontype','2')->
  click('Reject')->
  checkResponseElement('div#error_for_rejectionmsg',false)-> 
  isRedirected()->
  followRedirect();
$artwork = ReaktorArtworkPeer::retrieveByPK($generic_artwork->getId());

$b->
  checkResponseElement('div#error_for_rejectionmsg',false)->
  responseContains('Show rejection message')->
  responseContains('This artwork is not appropriate')->
  checkResponseElement('div#content_main', '*Rejected on '.date("d/m/Y", strtotime($artwork->getActionedAt())).' at ' .date("H:i", strtotime($artwork->getActionedAt())).' by admin*')->
  get("/en/admin/list/file/reported");
  
//Remove file from artwork
$b->
  get('/en/admin/artwork/removefilemessage/'.$m_file->getId())->
  checkResponseElement('div#content_main h1' ,'/Remove file/')->
  checkResponseElement('div.warning' , '/Note! You are about to remove this file from the artwork and send an e-mail to/')->
  click('Remove')->
  responseContains('Please choose why this file is being removed')->
  responseContains('Please enter a rejection message')->
  setField('rejectionmsg','This file is not appropriate')->
  setField('rejectiontype','2')->
  click('Remove')->
  checkResponseElement('div#rejection_form','!/Please choose why this file is being removed/')->
  checkResponseElement('div#rejection_form','!/Please enter a rejection message/')->
  isRedirected()->
  followRedirect()->
  checkResponseElement('li#artwork_list_container_'.$m_file->getId().' h4', '/'.$m_file->getTitle().'/')->
  get("/en/admin/list/file/reported")->
  checkResponseElement('div#admin_buttons_'.$m_file->getId(), false);
