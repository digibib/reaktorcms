<?php

/**
 * Unit tests for the ReaktorArtworkPeer model
 * 
 * PHP version 5
 * 
 * @author    Kjell-Magne Oierud <kjellm@linpro.no>
 * @copyright 2008 Linpro AS
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 * @version   SVN: $Id: ReaktorArtworkPeerTest.php 1138 2008-05-29 10:24:17Z dae $
 */

define('SF_APP', 'reaktor');
$base_dir = realpath(dirname(__FILE__).'/../..');
include($base_dir.'/plugins/sfModelTestPlugin/bootstrap/model-unit.php');

class ReaktorArtworkPeerTest extends sfPropelTest
{
  public function test_getArtworkByStatus()
  {
    $stat = array('Draft'              => 0,
                  'Ready for approval' => 2,
                  'Approved'           => 3,
                  'Rejected'           => 0,
                  'Discussion'         => 1,
                   );
    foreach ($stat as $s => $c)
    {
      $this->is(count(ReaktorArtworkPeer::getArtworkByStatus($c)),
                $c,
                "Counting status for: $s");
    }
  }

  public function test_getUnapprovedArtworks()
  {
    $this->pass('Dummy test');

  }

  public function test_getStatusIdByDescription()
  {
    $as = ArtworkStatusPeer::doSelect(new Criteria());
    $this->diag("getStatusIdByDescription()");
    foreach ($as as $i) 
    {
      $this->is(ReaktorArtworkPeer::getStatusIdByDescription($i->getDescription()), 
                $i->getId(),
                "Checking description: ". $i->getDescription());
    }
    
    // FIX isn't it bether to throw an exception instead of returning 0?
    $this->is(ReaktorArtworkPeer::getStatusIdByDescription('This would probably not exist ...'),
              0,
              "Nonexistent description");
  }

}

$test = new ReaktorArtworkPeerTest($base_dir.'/data/fixtures/fixtures.yml');
$test->execute();

