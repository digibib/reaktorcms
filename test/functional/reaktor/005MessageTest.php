<?php
/**
 * Functional test for testing message sending
 * 
 * PHP Version 5
 *
 * @author    Olepw <olepw@linpro.no>
 * 
 * @copyright 2008 Linpro AS
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 *
 */

include(dirname(__FILE__).'/../../bootstrap/functional.php');

$nick1 = "monkeyboy";
$nick2 = "userboy";
$user1 = sfGuardUserPeer::getByUsername($nick1);
$user2 = sfGuardUserPeer::getByUsername($nick2);

$b = new sfTestBrowser();
$b->initialize();

// Try to be here without being logged in
$b->get("/");
$b->checkResponseElement('div#sidebar', '!/Messages:/');

//log in and check that messages box appears
$b->setField('password', $nick1);
$b->setField('username', $nick1);
$b->click('Sign in');
$b->isRedirected()->followRedirect();

$b->checkResponseElement('div#sidebar', '/Messages:/');

//send messages and check that they are received

MessagesPeer::sendMessage($user1->getId(),$user2->getId(),"","Hello monkeyWorld!",0);

$b->reload();
$b->checkResponseElement('div#sidebar', '/Messages:/');
$b->checkResponseElement('div#message_subject_holder', '*Hello monkeyWorld*');
$b->checkResponseElement('div#message_summary', '*1 new*');

MessagesPeer::sendMessage($user2->getId(),$user1->getId(),"","Hello monkeyWorld boy!",0);

$b->click('Log out');
$b->isRedirected()->followRedirect();

$b->setField('password', $nick2);
$b->setField('username', $nick2);
$b->click('Sign in');
$b->isRedirected()->followRedirect();

$b->checkResponseElement('div#message_subject_holder', '*Hello monkeyWorld boy*');
$b->checkResponseElement('div#message_summary', '*1 new*');

//Mark message as read and check that it appears right

$messages = MessagesPeer::doselect(new Criteria());

foreach ($messages as $message)
{
    $message->setIsRead(1);
    $message->save();
}

$b->reload();

$b->checkResponseElement('div#message_subject_holder', '!/Hello monkeyWorld boy/');
$b->checkResponseElement('div#message_subject_holder_read', '*Hello monkeyWorld boy*');

//check that deleted message is deleted

foreach ($messages as $message)
{
    $message->markAsDeletedByTo();
    $message->markAsDeletedByFrom();
    $message->save();
}

$b->reload();
$b->checkResponseElement('div#message_subject_holder', '!/Hello monkeyWorld boy/');
$b->checkResponseElement('div#message_subject_holder_read', '!/Hello monkeyWorld boy/');

