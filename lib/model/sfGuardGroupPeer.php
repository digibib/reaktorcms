<?php
/*
 * This file is part of the symfony package.
 * (c) 2004-2006 Fabien Potencier <fabien.potencier@symfony-project.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 *
 * @package    symfony
 * @subpackage plugin
 * @author     Fabien Potencier <fabien.potencier@symfony-project.com>
 * @version    SVN: $Id: sfGuardGroupPeer.php 5760 2007-10-30 07:51:16Z francois $
 */
class sfGuardGroupPeer extends PluginsfGuardGroupPeer
{  
  /**
   * Return editorial team groups based on a list or return all
   *
   * @param array $teams An array of teams (group names)
   */
  public static function getActiveEditorialTeams($teams = array())
  {
    return self::getEditorialTeams(true, $teams);
  }
  
  /**
   * Return a group object by name
   * 
   * @param string $name The group name
   * 
   * @return sfGuardGroup
   */
  public static function getGroupByName($name)
  {
    $c = new Criteria();
    $c->add(self::NAME, $name);
    
    return self::doSelectOne($c);
  }
  
  /**
   * Returns an array of sfGuardGroup which are editorial teams
   *
   * @param boolean $enabled   Whether to only return enabled teams, true by default
   * @param array   $teamNames An array of team names to filter on
   * 
   * @return array|sfGuardGroup
   */
  public static function getEditorialTeams($enabled = true, $teams = array())
  {
    $crit = new Criteria();
    if ($enabled)
    {
      $crit->add(sfGuardGroupPeer::IS_ENABLED, true);
    }
    $crit->add(sfGuardGroupPeer::IS_EDITORIAL_TEAM, true);
    
    if (!empty($teams))
    {
      $crit->add(self::NAME, $teams, Criteria::IN);
    }
    
    return SfGuardGroupPeer::doSelect($crit);
  }

  /**
   * Returns an array of sfGuardGroup s which are normal user groups
   *
   * @return array|sfGuardGroup
   */
  public static function getUserGroups()
  {
    $crit = new Criteria();
    $crit->add(sfGuardGroupPeer::IS_EDITORIAL_TEAM, false);
    return SfGuardGroupPeer::doSelect($crit);
  }  
  
  public static function getEditorialTeamsAsIndexedArray()
  {
  	$teams = self::getEditorialTeams();
  	$arr = array();
  	foreach ($teams as $team)
  	{
  		$arr[$team->getId()] = $team->getDescription();
  	}
  	return $arr;
  }
  
  public static function getOMClass()
  {
    return 'lib.model.sfGuardGroup';
  }
  

}
