<?php


abstract class BasesfGuardGroup extends BaseObject  implements Persistent {


	
	protected static $peer;


	
	protected $id;


	
	protected $name;


	
	protected $description;


	
	protected $is_editorial_team = false;


	
	protected $is_enabled = false;

	
	protected $collsfGuardGroupPermissions;

	
	protected $lastsfGuardGroupPermissionCriteria = null;

	
	protected $collsfGuardUserGroups;

	
	protected $lastsfGuardUserGroupCriteria = null;

	
	protected $collReaktorArtworks;

	
	protected $lastReaktorArtworkCriteria = null;

	
	protected $alreadyInSave = false;

	
	protected $alreadyInValidation = false;

	
	public function getId()
	{

		return $this->id;
	}

	
	public function getName()
	{

		return $this->name;
	}

	
	public function getDescription()
	{

		return $this->description;
	}

	
	public function getIsEditorialTeam()
	{

		return $this->is_editorial_team;
	}

	
	public function getIsEnabled()
	{

		return $this->is_enabled;
	}

	
	public function setId($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->id !== $v) {
			$this->id = $v;
			$this->modifiedColumns[] = sfGuardGroupPeer::ID;
		}

	} 
	
	public function setName($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->name !== $v) {
			$this->name = $v;
			$this->modifiedColumns[] = sfGuardGroupPeer::NAME;
		}

	} 
	
	public function setDescription($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->description !== $v) {
			$this->description = $v;
			$this->modifiedColumns[] = sfGuardGroupPeer::DESCRIPTION;
		}

	} 
	
	public function setIsEditorialTeam($v)
	{

		if ($this->is_editorial_team !== $v || $v === false) {
			$this->is_editorial_team = $v;
			$this->modifiedColumns[] = sfGuardGroupPeer::IS_EDITORIAL_TEAM;
		}

	} 
	
	public function setIsEnabled($v)
	{

		if ($this->is_enabled !== $v || $v === false) {
			$this->is_enabled = $v;
			$this->modifiedColumns[] = sfGuardGroupPeer::IS_ENABLED;
		}

	} 
	
	public function hydrate(ResultSet $rs, $startcol = 1)
	{
		try {

			$this->id = $rs->getInt($startcol + 0);

			$this->name = $rs->getString($startcol + 1);

			$this->description = $rs->getString($startcol + 2);

			$this->is_editorial_team = $rs->getBoolean($startcol + 3);

			$this->is_enabled = $rs->getBoolean($startcol + 4);

			$this->resetModified();

			$this->setNew(false);

						return $startcol + 5; 
		} catch (Exception $e) {
			throw new PropelException("Error populating sfGuardGroup object", $e);
		}
	}

	
	public function delete($con = null)
	{

    foreach (sfMixer::getCallables('BasesfGuardGroup:delete:pre') as $callable)
    {
      $ret = call_user_func($callable, $this, $con);
      if ($ret)
      {
        return;
      }
    }


		if ($this->isDeleted()) {
			throw new PropelException("This object has already been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(sfGuardGroupPeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			sfGuardGroupPeer::doDelete($this, $con);
			$this->setDeleted(true);
			$con->commit();
		} catch (PropelException $e) {
			$con->rollback();
			throw $e;
		}
	

    foreach (sfMixer::getCallables('BasesfGuardGroup:delete:post') as $callable)
    {
      call_user_func($callable, $this, $con);
    }

  }
	
	public function save($con = null)
	{

    foreach (sfMixer::getCallables('BasesfGuardGroup:save:pre') as $callable)
    {
      $affectedRows = call_user_func($callable, $this, $con);
      if (is_int($affectedRows))
      {
        return $affectedRows;
      }
    }


		if ($this->isDeleted()) {
			throw new PropelException("You cannot save an object that has been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(sfGuardGroupPeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			$affectedRows = $this->doSave($con);
			$con->commit();
    foreach (sfMixer::getCallables('BasesfGuardGroup:save:post') as $callable)
    {
      call_user_func($callable, $this, $con, $affectedRows);
    }

			return $affectedRows;
		} catch (PropelException $e) {
			$con->rollback();
			throw $e;
		}
	}

	
	protected function doSave($con)
	{
		$affectedRows = 0; 		if (!$this->alreadyInSave) {
			$this->alreadyInSave = true;


						if ($this->isModified()) {
				if ($this->isNew()) {
					$pk = sfGuardGroupPeer::doInsert($this, $con);
					$affectedRows += 1; 										 										 
					$this->setId($pk);  
					$this->setNew(false);
				} else {
					$affectedRows += sfGuardGroupPeer::doUpdate($this, $con);
				}
				$this->resetModified(); 			}

			if ($this->collsfGuardGroupPermissions !== null) {
				foreach($this->collsfGuardGroupPermissions as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collsfGuardUserGroups !== null) {
				foreach($this->collsfGuardUserGroups as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collReaktorArtworks !== null) {
				foreach($this->collReaktorArtworks as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			$this->alreadyInSave = false;
		}
		return $affectedRows;
	} 
	
	protected $validationFailures = array();

	
	public function getValidationFailures()
	{
		return $this->validationFailures;
	}

	
	public function validate($columns = null)
	{
		$res = $this->doValidate($columns);
		if ($res === true) {
			$this->validationFailures = array();
			return true;
		} else {
			$this->validationFailures = $res;
			return false;
		}
	}

	
	protected function doValidate($columns = null)
	{
		if (!$this->alreadyInValidation) {
			$this->alreadyInValidation = true;
			$retval = null;

			$failureMap = array();


			if (($retval = sfGuardGroupPeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}


				if ($this->collsfGuardGroupPermissions !== null) {
					foreach($this->collsfGuardGroupPermissions as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collsfGuardUserGroups !== null) {
					foreach($this->collsfGuardUserGroups as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collReaktorArtworks !== null) {
					foreach($this->collReaktorArtworks as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}


			$this->alreadyInValidation = false;
		}

		return (!empty($failureMap) ? $failureMap : true);
	}

	
	public function getByName($name, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = sfGuardGroupPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->getByPosition($pos);
	}

	
	public function getByPosition($pos)
	{
		switch($pos) {
			case 0:
				return $this->getId();
				break;
			case 1:
				return $this->getName();
				break;
			case 2:
				return $this->getDescription();
				break;
			case 3:
				return $this->getIsEditorialTeam();
				break;
			case 4:
				return $this->getIsEnabled();
				break;
			default:
				return null;
				break;
		} 	}

	
	public function toArray($keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = sfGuardGroupPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getId(),
			$keys[1] => $this->getName(),
			$keys[2] => $this->getDescription(),
			$keys[3] => $this->getIsEditorialTeam(),
			$keys[4] => $this->getIsEnabled(),
		);
		return $result;
	}

	
	public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = sfGuardGroupPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->setByPosition($pos, $value);
	}

	
	public function setByPosition($pos, $value)
	{
		switch($pos) {
			case 0:
				$this->setId($value);
				break;
			case 1:
				$this->setName($value);
				break;
			case 2:
				$this->setDescription($value);
				break;
			case 3:
				$this->setIsEditorialTeam($value);
				break;
			case 4:
				$this->setIsEnabled($value);
				break;
		} 	}

	
	public function fromArray($arr, $keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = sfGuardGroupPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setName($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setDescription($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setIsEditorialTeam($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setIsEnabled($arr[$keys[4]]);
	}

	
	public function buildCriteria()
	{
		$criteria = new Criteria(sfGuardGroupPeer::DATABASE_NAME);

		if ($this->isColumnModified(sfGuardGroupPeer::ID)) $criteria->add(sfGuardGroupPeer::ID, $this->id);
		if ($this->isColumnModified(sfGuardGroupPeer::NAME)) $criteria->add(sfGuardGroupPeer::NAME, $this->name);
		if ($this->isColumnModified(sfGuardGroupPeer::DESCRIPTION)) $criteria->add(sfGuardGroupPeer::DESCRIPTION, $this->description);
		if ($this->isColumnModified(sfGuardGroupPeer::IS_EDITORIAL_TEAM)) $criteria->add(sfGuardGroupPeer::IS_EDITORIAL_TEAM, $this->is_editorial_team);
		if ($this->isColumnModified(sfGuardGroupPeer::IS_ENABLED)) $criteria->add(sfGuardGroupPeer::IS_ENABLED, $this->is_enabled);

		return $criteria;
	}

	
	public function buildPkeyCriteria()
	{
		$criteria = new Criteria(sfGuardGroupPeer::DATABASE_NAME);

		$criteria->add(sfGuardGroupPeer::ID, $this->id);

		return $criteria;
	}

	
	public function getPrimaryKey()
	{
		return $this->getId();
	}

	
	public function setPrimaryKey($key)
	{
		$this->setId($key);
	}

	
	public function copyInto($copyObj, $deepCopy = false)
	{

		$copyObj->setName($this->name);

		$copyObj->setDescription($this->description);

		$copyObj->setIsEditorialTeam($this->is_editorial_team);

		$copyObj->setIsEnabled($this->is_enabled);


		if ($deepCopy) {
									$copyObj->setNew(false);

			foreach($this->getsfGuardGroupPermissions() as $relObj) {
				$copyObj->addsfGuardGroupPermission($relObj->copy($deepCopy));
			}

			foreach($this->getsfGuardUserGroups() as $relObj) {
				$copyObj->addsfGuardUserGroup($relObj->copy($deepCopy));
			}

			foreach($this->getReaktorArtworks() as $relObj) {
				$copyObj->addReaktorArtwork($relObj->copy($deepCopy));
			}

		} 

		$copyObj->setNew(true);

		$copyObj->setId(NULL); 
	}

	
	public function copy($deepCopy = false)
	{
				$clazz = get_class($this);
		$copyObj = new $clazz();
		$this->copyInto($copyObj, $deepCopy);
		return $copyObj;
	}

	
	public function getPeer()
	{
		if (self::$peer === null) {
			self::$peer = new sfGuardGroupPeer();
		}
		return self::$peer;
	}

	
	public function initsfGuardGroupPermissions()
	{
		if ($this->collsfGuardGroupPermissions === null) {
			$this->collsfGuardGroupPermissions = array();
		}
	}

	
	public function getsfGuardGroupPermissions($criteria = null, $con = null)
	{
				include_once 'plugins/sfGuardPlugin/lib/model/om/BasesfGuardGroupPermissionPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collsfGuardGroupPermissions === null) {
			if ($this->isNew()) {
			   $this->collsfGuardGroupPermissions = array();
			} else {

				$criteria->add(sfGuardGroupPermissionPeer::GROUP_ID, $this->getId());

				sfGuardGroupPermissionPeer::addSelectColumns($criteria);
				$this->collsfGuardGroupPermissions = sfGuardGroupPermissionPeer::doSelect($criteria, $con);
			}
		} else {
						if (!$this->isNew()) {
												

				$criteria->add(sfGuardGroupPermissionPeer::GROUP_ID, $this->getId());

				sfGuardGroupPermissionPeer::addSelectColumns($criteria);
				if (!isset($this->lastsfGuardGroupPermissionCriteria) || !$this->lastsfGuardGroupPermissionCriteria->equals($criteria)) {
					$this->collsfGuardGroupPermissions = sfGuardGroupPermissionPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastsfGuardGroupPermissionCriteria = $criteria;
		return $this->collsfGuardGroupPermissions;
	}

	
	public function countsfGuardGroupPermissions($criteria = null, $distinct = false, $con = null)
	{
				include_once 'plugins/sfGuardPlugin/lib/model/om/BasesfGuardGroupPermissionPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(sfGuardGroupPermissionPeer::GROUP_ID, $this->getId());

		return sfGuardGroupPermissionPeer::doCount($criteria, $distinct, $con);
	}

	
	public function addsfGuardGroupPermission(sfGuardGroupPermission $l)
	{
		$this->collsfGuardGroupPermissions[] = $l;
		$l->setsfGuardGroup($this);
	}


	
	public function getsfGuardGroupPermissionsJoinsfGuardPermission($criteria = null, $con = null)
	{
				include_once 'plugins/sfGuardPlugin/lib/model/om/BasesfGuardGroupPermissionPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collsfGuardGroupPermissions === null) {
			if ($this->isNew()) {
				$this->collsfGuardGroupPermissions = array();
			} else {

				$criteria->add(sfGuardGroupPermissionPeer::GROUP_ID, $this->getId());

				$this->collsfGuardGroupPermissions = sfGuardGroupPermissionPeer::doSelectJoinsfGuardPermission($criteria, $con);
			}
		} else {
									
			$criteria->add(sfGuardGroupPermissionPeer::GROUP_ID, $this->getId());

			if (!isset($this->lastsfGuardGroupPermissionCriteria) || !$this->lastsfGuardGroupPermissionCriteria->equals($criteria)) {
				$this->collsfGuardGroupPermissions = sfGuardGroupPermissionPeer::doSelectJoinsfGuardPermission($criteria, $con);
			}
		}
		$this->lastsfGuardGroupPermissionCriteria = $criteria;

		return $this->collsfGuardGroupPermissions;
	}

	
	public function initsfGuardUserGroups()
	{
		if ($this->collsfGuardUserGroups === null) {
			$this->collsfGuardUserGroups = array();
		}
	}

	
	public function getsfGuardUserGroups($criteria = null, $con = null)
	{
				include_once 'plugins/sfGuardPlugin/lib/model/om/BasesfGuardUserGroupPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collsfGuardUserGroups === null) {
			if ($this->isNew()) {
			   $this->collsfGuardUserGroups = array();
			} else {

				$criteria->add(sfGuardUserGroupPeer::GROUP_ID, $this->getId());

				sfGuardUserGroupPeer::addSelectColumns($criteria);
				$this->collsfGuardUserGroups = sfGuardUserGroupPeer::doSelect($criteria, $con);
			}
		} else {
						if (!$this->isNew()) {
												

				$criteria->add(sfGuardUserGroupPeer::GROUP_ID, $this->getId());

				sfGuardUserGroupPeer::addSelectColumns($criteria);
				if (!isset($this->lastsfGuardUserGroupCriteria) || !$this->lastsfGuardUserGroupCriteria->equals($criteria)) {
					$this->collsfGuardUserGroups = sfGuardUserGroupPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastsfGuardUserGroupCriteria = $criteria;
		return $this->collsfGuardUserGroups;
	}

	
	public function countsfGuardUserGroups($criteria = null, $distinct = false, $con = null)
	{
				include_once 'plugins/sfGuardPlugin/lib/model/om/BasesfGuardUserGroupPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(sfGuardUserGroupPeer::GROUP_ID, $this->getId());

		return sfGuardUserGroupPeer::doCount($criteria, $distinct, $con);
	}

	
	public function addsfGuardUserGroup(sfGuardUserGroup $l)
	{
		$this->collsfGuardUserGroups[] = $l;
		$l->setsfGuardGroup($this);
	}


	
	public function getsfGuardUserGroupsJoinsfGuardUser($criteria = null, $con = null)
	{
				include_once 'plugins/sfGuardPlugin/lib/model/om/BasesfGuardUserGroupPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collsfGuardUserGroups === null) {
			if ($this->isNew()) {
				$this->collsfGuardUserGroups = array();
			} else {

				$criteria->add(sfGuardUserGroupPeer::GROUP_ID, $this->getId());

				$this->collsfGuardUserGroups = sfGuardUserGroupPeer::doSelectJoinsfGuardUser($criteria, $con);
			}
		} else {
									
			$criteria->add(sfGuardUserGroupPeer::GROUP_ID, $this->getId());

			if (!isset($this->lastsfGuardUserGroupCriteria) || !$this->lastsfGuardUserGroupCriteria->equals($criteria)) {
				$this->collsfGuardUserGroups = sfGuardUserGroupPeer::doSelectJoinsfGuardUser($criteria, $con);
			}
		}
		$this->lastsfGuardUserGroupCriteria = $criteria;

		return $this->collsfGuardUserGroups;
	}

	
	public function initReaktorArtworks()
	{
		if ($this->collReaktorArtworks === null) {
			$this->collReaktorArtworks = array();
		}
	}

	
	public function getReaktorArtworks($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseReaktorArtworkPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collReaktorArtworks === null) {
			if ($this->isNew()) {
			   $this->collReaktorArtworks = array();
			} else {

				$criteria->add(ReaktorArtworkPeer::TEAM_ID, $this->getId());

				ReaktorArtworkPeer::addSelectColumns($criteria);
				$this->collReaktorArtworks = ReaktorArtworkPeer::doSelect($criteria, $con);
			}
		} else {
						if (!$this->isNew()) {
												

				$criteria->add(ReaktorArtworkPeer::TEAM_ID, $this->getId());

				ReaktorArtworkPeer::addSelectColumns($criteria);
				if (!isset($this->lastReaktorArtworkCriteria) || !$this->lastReaktorArtworkCriteria->equals($criteria)) {
					$this->collReaktorArtworks = ReaktorArtworkPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastReaktorArtworkCriteria = $criteria;
		return $this->collReaktorArtworks;
	}

	
	public function countReaktorArtworks($criteria = null, $distinct = false, $con = null)
	{
				include_once 'lib/model/om/BaseReaktorArtworkPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(ReaktorArtworkPeer::TEAM_ID, $this->getId());

		return ReaktorArtworkPeer::doCount($criteria, $distinct, $con);
	}

	
	public function addReaktorArtwork(ReaktorArtwork $l)
	{
		$this->collReaktorArtworks[] = $l;
		$l->setsfGuardGroup($this);
	}


	
	public function getReaktorArtworksJoinsfGuardUser($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseReaktorArtworkPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collReaktorArtworks === null) {
			if ($this->isNew()) {
				$this->collReaktorArtworks = array();
			} else {

				$criteria->add(ReaktorArtworkPeer::TEAM_ID, $this->getId());

				$this->collReaktorArtworks = ReaktorArtworkPeer::doSelectJoinsfGuardUser($criteria, $con);
			}
		} else {
									
			$criteria->add(ReaktorArtworkPeer::TEAM_ID, $this->getId());

			if (!isset($this->lastReaktorArtworkCriteria) || !$this->lastReaktorArtworkCriteria->equals($criteria)) {
				$this->collReaktorArtworks = ReaktorArtworkPeer::doSelectJoinsfGuardUser($criteria, $con);
			}
		}
		$this->lastReaktorArtworkCriteria = $criteria;

		return $this->collReaktorArtworks;
	}


	
	public function getReaktorArtworksJoinArtworkStatus($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseReaktorArtworkPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collReaktorArtworks === null) {
			if ($this->isNew()) {
				$this->collReaktorArtworks = array();
			} else {

				$criteria->add(ReaktorArtworkPeer::TEAM_ID, $this->getId());

				$this->collReaktorArtworks = ReaktorArtworkPeer::doSelectJoinArtworkStatus($criteria, $con);
			}
		} else {
									
			$criteria->add(ReaktorArtworkPeer::TEAM_ID, $this->getId());

			if (!isset($this->lastReaktorArtworkCriteria) || !$this->lastReaktorArtworkCriteria->equals($criteria)) {
				$this->collReaktorArtworks = ReaktorArtworkPeer::doSelectJoinArtworkStatus($criteria, $con);
			}
		}
		$this->lastReaktorArtworkCriteria = $criteria;

		return $this->collReaktorArtworks;
	}


	
	public function getReaktorArtworksJoinReaktorFile($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseReaktorArtworkPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collReaktorArtworks === null) {
			if ($this->isNew()) {
				$this->collReaktorArtworks = array();
			} else {

				$criteria->add(ReaktorArtworkPeer::TEAM_ID, $this->getId());

				$this->collReaktorArtworks = ReaktorArtworkPeer::doSelectJoinReaktorFile($criteria, $con);
			}
		} else {
									
			$criteria->add(ReaktorArtworkPeer::TEAM_ID, $this->getId());

			if (!isset($this->lastReaktorArtworkCriteria) || !$this->lastReaktorArtworkCriteria->equals($criteria)) {
				$this->collReaktorArtworks = ReaktorArtworkPeer::doSelectJoinReaktorFile($criteria, $con);
			}
		}
		$this->lastReaktorArtworkCriteria = $criteria;

		return $this->collReaktorArtworks;
	}


  public function __call($method, $arguments)
  {
    if (!$callable = sfMixer::getCallable('BasesfGuardGroup:'.$method))
    {
      throw new sfException(sprintf('Call to undefined method BasesfGuardGroup::%s', $method));
    }

    array_unshift($arguments, $this);

    return call_user_func_array($callable, $arguments);
  }


} 