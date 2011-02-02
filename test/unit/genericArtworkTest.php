<?php

/**
 * Unit tests for the genericArtwork class
 * 
 * PHP version 5
 * 
 * @author    Daniel Andre Eikeland <dae@linpro.no>
 * @copyright 2008 Linpro AS
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 * @version   SVN: $Id: UserInterestPeerTest.php 524 2008-03-28 00:58:49Z kjellm $
 */

define('SF_APP', 'reaktor');
$base_dir = realpath(dirname(__FILE__).'/../..');
include(dirname(__FILE__).'/../bootstrap/unit.php');

include(dirname(__FILE__).'/../../apps/reaktor/lib/genericArtwork.class.php');

class genericArtworkTest extends genericArtwork
{

	/**
	 * constructs a genericArtwork object
	 *
	 * @param integer $id
	 * 
	 * @return genericArtworkTest
	 */
	function __construct($id)
	{
		parent::__construct($id);
	}
	
  /**
   * Test the getEditorialTeam function
   *
   * @param newLimeTest $test
   * 
   * @return sfGuardGroup
   */
	function testGetEditorialTeam($test)
	{
		$test->diag('Testing genericArtwork::getEditorialTeam()');
		$test->ok($retval = parent::getEditorialTeam(), 'Getting editorial team');
    $test->ok($retval instanceof sfGuardGroup && $retval->getIsEditorialTeam(), 'New editorial team is a group and is an editorial team');
    return $retval;
	}

  /**
   * Test the setEditorialTeam function
   *
   * @param integer     $val
   * @param newLimeTest $test
   */
	function testSetEditorialTeam($val, $test)
	{
    $test->diag('Testing genericArtwork::setEditorialTeam()');
		$test->ok(parent::setEditorialTeam($val), 'Setting editorial team to ' . $val);
		$test->diag('New editorial team set');
	}
	
	/**
	 * Test the reset editorial team function
	 *
	 * @param newLimeTest $test
	 */
	function testResetEditorialTeam($test)
	{
		$test->diag('Testing genericArtwork::resetEditorialTeam()');
		$test->ok(parent::resetEditorialTeam() instanceof sfGuardGroup, 'Resetting editorial team');
		$test->diag('New editorial team saved');
	}
	
}

$test = new newLimeTest($base_dir.'/data/fixtures/');

$c = new Criteria();
$c->add(ReaktorArtworkPeer::TEAM_ID, 0, Criteria::GREATER_THAN);
//$c->setLimit(1);

$artworks = ReaktorArtworkPeer::doSelect($c); 

foreach ($artworks as $artwork)
{
	try
	{
	  $artwork = new genericArtworkTest($artwork->getId());
	  $test->ok($artwork instanceof genericArtwork, 'Instantiated genericArtwork object with id ' . $artwork->getId());
	}
	catch (Exception $e)
	{
		$test->fail('genericArtwork did not instantiate properly: ' . $e->getMessage());
		break;
	}
	
	$prev_id = $artwork->getEditorialTeam()->getId();
  $artwork->testSetEditorialTeam(0, $test);
	$artwork->testResetEditorialTeam($test);
  $artwork->testGetEditorialTeam($test);
  $test->ok($prev_id == $artwork->getEditorialTeam()->getId(), 'New editorial team ' . $artwork->getEditorialTeam()->getName() . '(' . $artwork->getEditorialTeam()->getId() . ') is correct for artwork with id ' . $artwork->getTitle());
}