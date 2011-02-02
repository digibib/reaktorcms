<?php

/**
 * Unit tests for the UserInterestPeer model
 * 
 * PHP version 5
 * 
 * @author    Kjell-Magne Oierud <kjellm@linpro.no>
 * @copyright 2008 Linpro AS
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 * @version   SVN: $Id: UserInterestPeerTest.php 1148 2008-05-29 16:09:28Z dae $
 */

define('SF_APP', 'reaktor');
$base_dir = realpath(dirname(__FILE__).'/../..');
//include($base_dir.'/plugins/sfModelTestPlugin/bootstrap/model-unit.php');
include(dirname(__FILE__).'/../bootstrap/unit.php');

class UserInterestPeerTest extends sfPropelTest
{
  public function test_retrieveByUser()
  {
    $c = new Criteria();
    $c->add(sfGuardUserPeer::USERNAME, 'userboy');
    $user = sfGuardUserPeer::doSelectOne($c);
    
    $this->is(count(UserInterestPeer::retrieveByUser($user->getId())),
              3,
              'Userboy has three interests');
    
    
    $c = new Criteria();
    $c->add(sfGuardUserPeer::USERNAME, 'monkeyboy');
    $user = sfGuardUserPeer::doSelectOne($c);
    $this->is(count(UserInterestPeer::retrieveByUser($user->getId())),
              1,
              'Monkeyboy has one interest');
  }


  public function test_deleteByUser()
  {
    $c = new Criteria();
    $c->add(sfGuardUserPeer::USERNAME, 'monkeyboy');
    $user = sfGuardUserPeer::doSelectOne($c);
    UserInterestPeer::deleteByUser($user->getId());
    $this->is(UserInterestPeer::retrieveByUser($user->getId()),
              null,
              'Deleted monkeyboys interests');
  }
}

$test = new UserInterestPeerTest($base_dir.'/data/fixtures/');
$test->execute();

