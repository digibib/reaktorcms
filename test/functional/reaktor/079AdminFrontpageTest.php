<?php
/**
 * Test script for the admin frontpage
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

//first check that admin module is not viewable when not logged in
$b->get("/en/admin");

$b->isStatusCode(200);
$b->checkResponseElement('div#content_main' , '*You need to log in to view this page*');

$b->get("/en"); 
$b->setField('username', 'admin');
$b->setField('password', 'admin');

// Log in and check that we are redirected to admin page
$b->click('Sign in');
$b->isRedirected()->followRedirect();
$b->isRequestParameter('module', 'admin');
$b->isRequestParameter('action', 'index');
//check that admin logo is shown
$b->responseContains('logoAdmin.gif');

//get unapproved tags from DB and check the num in template
$c = new Criteria();
$c->addAscendingOrderByColumn(TagPeer::NAME);
$c->add(TagPeer::APPROVED, 0);
$tags = TagPeer::doSelect($c);
$num_tags = count($tags);

$b->checkResponseElement('div#content_main','*('.$num_tags.')*');

//count reported files and check if this is ok
$c = new Criteria();

$c->add(ReaktorFilePeer::REPORTED, 0, Criteria::GREATER_THAN); 
$c->add(ReaktorFilePeer::MARKED_UNSUITABLE, 0, Criteria::EQUAL);
$reported = ReaktorFilePeer::doSelect($c);
$num_reported = count($reported);

$b->checkResponseElement('div#content_main','*('.$num_reported.')*');

//count artworks under discussion
$discussion =  ReaktorArtworkPeer::getArtworksUnderDiscussion();
$num_discussion = count($discussion); 

$b->checkResponseElement('div#content_main','*('.$num_discussion.')*');

//get all comments marked as unsuitable
$c = new Criteria();
$c->add(sfCommentPeer::UNSUITABLE,2);
$comments = sfCommentPeer::doSelect($c);
$num_comments = count($comments);

$b->checkResponseElement('div#content_main','*('.$num_comments.')*');