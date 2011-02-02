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
 * @version    SVN: $Id: sfGuardUserGroupPeer.php 5760 2007-10-30 07:51:16Z francois $
 */
class sfGuardUserGroupPeer extends PluginsfGuardUserGroupPeer
{

	public static function getOMClass()
  {
    //return 'lib.model.sfGuardPlugin.sfGuardUser';
    return 'lib.model.sfGuardUserGroup';
  }
  
  /*public static function getEditorialTeams()
  {
  	$c = new Criteria();
  	$c->add(sfGuardGroupPeer::IS_EDITORIAL_TEAM, 1);
  	$c->addAscendingOrderByColumn(sfGuardUserGroupPeer::USER_ID);
  	return self::doSelectJoinAll($c);
  }*/
  
  public static function getMembersofEditorialTeam($team_id, $active = null)
  {
  	$c = new Criteria();
    $c->setDistinct();
  	$c->add(sfGuardUserGroupPeer::GROUP_ID, $team_id);
  	
  	if ($active === true)
  	{
  		$c->add(sfGuardUserPeer::IS_ACTIVE, 1);
  	} else if ($active === false)
  	{
  		$c->add(sfGuardUserPeer::IS_ACTIVE, 0);
  	}
  	
  	$res = self::doSelectJoinsfGuardUser($c);
  	
  	$users = array();
  	foreach ($res as $row)
  	{
  		if (sfGuardUserPeer::isUserStaffMember($row->getSfGuardUser()->getId()))
  		{
  			$users[$row->getSfGuardUser()->getId()] = $row->getSfGuardUser();
  		}
  	}
  	return $users;
  }
  
  public static function getMembersofEditorialTeams()
  {
    $c = new Criteria();
    $c->setDistinct();
    $c->add(sfGuardGroupPeer::IS_EDITORIAL_TEAM, 1);
    $res = self::doSelectJoinAll($c);
    
    $users = array();
    foreach ($res as $row)
    {
      $users[$row->getSfGuardUser()->getId()] = $row->getSfGuardUser()->getUsername();
    }
    return $users;
  }
  
}
