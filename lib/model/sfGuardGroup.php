<?php

/**
 *
 * @package    symfony
 * @subpackage plugin
 * @author     Fabien Potencier <fabien.potencier@symfony-project.com>
 * @version    SVN: $Id: sfGuardGroup.php 5760 2007-10-30 07:51:16Z francois $
 */
class sfGuardGroup extends PluginsfGuardGroup
{
	
	public function __toString()
	{
		return $this->getDescription();
	}
	
	public function getMembers($numUnapproved = 0)
	{
		
		$groups = $this->getsfGuardUserGroups();
		$group = array_shift($groups);
		if (!$group)
			return array();
			$c = new Criteria();
		$c->add(sfGuardUserGroupPeer::GROUP_ID,$group->getGroupId());
		$c->add(sfGuardUserPeer::EDITORIAL_NOTIFICATION,$numUnapproved,Criteria::GREATER_THAN);
		$c->addOr(sfGuardUserPeer::EDITORIAL_NOTIFICATION,2);
		$users = sfGuardUserGroupPeer::doSelectJoinsfGuardUser($c);
		
		return $users;
	}	
	
	/**
	 * Return whether a group is enabled or not
	 *
	 * @return boolean
	 */
	public function isEnabled()
	{
	  return (bool) $this->getIsEnabled();
	}
}
