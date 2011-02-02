<?php

/**
 * Unit tests for the sfGuardUserPeer model
 * 
 * PHP version 5
 * 
 * @author    Kjell-Magne Oierud <kjellm@linpro.no>
 * @copyright 2008 Linpro AS
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 * @version   SVN: $Id: sfGuardUserPeerTest.php 764 2008-04-28 14:09:35Z dae $
 */

define('SF_APP', 'reaktor');
$base_dir = realpath(dirname(__FILE__).'/../..');
include($base_dir.'/plugins/sfModelTestPlugin/bootstrap/model-unit.php');

class sfGuardUserPeerTest extends sfPropelTest
{
  public function test_retrieveByEmail()
  {
    $u = sfGuardUserPeer::retrieveByEmail('userboy@linpro.no');

    $this->is($u->getName(), 'User Boy', "getName()");
    $this->is($u->getSex(), '1', "getSex()");

    $this->is(sfGuardUserPeer::retrieveByEmail('nonexistent'), null, "Nonexistent email");
  }
}

$test = new sfGuardUserPeerTest($base_dir.'/data/fixtures/fixtures.yml');
$test->execute();

