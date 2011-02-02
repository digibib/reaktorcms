<?php


abstract class BasesfGuardGroupPermission extends BaseObject  implements Persistent {


	
	protected static $peer;


	
	protected $group_id;


	
	protected $permission_id;

	
	protected $asfGuardGroup;

	
	protected $asfGuardPermission;

	
	protected $alreadyInSave = false;

	
	protected $alreadyInValidation = false;

	
	public function getGroupId()
	{

		return $this->group_id;
	}

	
	public function getPermissionId()
	{

		return $this->permission_id;
	}

	
	public function setGroupId($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->group_id !== $v) {
			$this->group_id = $v;
			$this->modifiedColumns[] = sfGuardGroupPermissionPeer::GROUP_ID;
		}

		if ($this->asfGuardGroup !== null && $this->asfGuardGroup->getId() !== $v) {
			$this->asfGuardGroup = null;
		}

	} 
	
	public function setPermissionId($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->permission_id !== $v) {
			$this->permission_id = $v;
			$this->modifiedColumns[] = sfGuardGroupPermissionPeer::PERMISSION_ID;
		}

		if ($this->asfGuardPermission !== null && $this->asfGuardPermission->getId() !== $v) {
			$this->asfGuardPermission = null;
		}

	} 
	
	public function hydrate(ResultSet $rs, $startcol = 1)
	{
		try {

			$this->group_id = $rs->getInt($startcol + 0);

			$this->permission_id = $rs->getInt($startcol + 1);

			$this->resetModified();

			$this->setNew(false);

						return $startcol + 2; 
		} catch (Exception $e) {
			throw new PropelException("Error populating sfGuardGroupPermission object", $e);
		}
	}

	
	public function delete($con = null)
	{

    foreach (sfMixer::getCallables('BasesfGuardGroupPermission:delete:pre') as $callable)
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
			$con = Propel::getConnection(sfGuardGroupPermissionPeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			sfGuardGroupPermissionPeer::doDelete($this, $con);
			$this->setDeleted(true);
			$con->commit();
		} catch (PropelException $e) {
			$con->rollback();
			throw $e;
		}
	

    foreach (sfMixer::getCallables('BasesfGuardGroupPermission:delete:post') as $callable)
    {
      call_user_func($callable, $this, $con);
    }

  }
	
	public function save($con = null)
	{

    foreach (sfMixer::getCallables('BasesfGuardGroupPermission:save:pre') as $callable)
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
			$con = Propel::getConnection(sfGuardGroupPermissionPeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			$affectedRows = $this->doSave($con);
			$con->commit();
    foreach (sfMixer::getCallables('BasesfGuardGroupPermission:save:post') as $callable)
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


												
			if ($this->asfGuardGroup !== null) {
				if ($this->asfGuardGroup->isModified()) {
					$affectedRows += $this->asfGuardGroup->save($con);
				}
				$this->setsfGuardGroup($this->asfGuardGroup);
			}

			if ($this->asfGuardPermission !== null) {
				if ($this->asfGuardPermission->isModified() || $this->asfGuardPermission->getCurrentsfGuardPermissionI18n()->isModified()) {
					$affectedRows += $this->asfGuardPermission->save($con);
				}
				$this->setsfGuardPermission($this->asfGuardPermission);
			}


						if ($this->isModified()) {
				if ($this->isNew()) {
					$pk = sfGuardGroupPermissionPeer::doInsert($this, $con);
					$affectedRows += 1; 										 										 
					$this->setNew(false);
				} else {
					$affectedRows += sfGuardGroupPermissionPeer::doUpdate($this, $con);
				}
				$this->resetModified(); 			}

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


												
			if ($this->asfGuardGroup !== null) {
				if (!$this->asfGuardGroup->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->asfGuardGroup->getValidationFailures());
				}
			}

			if ($this->asfGuardPermission !== null) {
				if (!$this->asfGuardPermission->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->asfGuardPermission->getValidationFailures());
				}
			}


			if (($retval = sfGuardGroupPermissionPeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}



			$this->alreadyInValidation = false;
		}

		return (!empty($failureMap) ? $failureMap : true);
	}

	
	public function getByName($name, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = sfGuardGroupPermissionPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->getByPosition($pos);
	}

	
	public function getByPosition($pos)
	{
		switch($pos) {
			case 0:
				return $this->getGroupId();
				break;
			case 1:
				return $this->getPermissionId();
				break;
			default:
				return null;
				break;
		} 	}

	
	public function toArray($keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = sfGuardGroupPermissionPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getGroupId(),
			$keys[1] => $this->getPermissionId(),
		);
		return $result;
	}

	
	public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = sfGuardGroupPermissionPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->setByPosition($pos, $value);
	}

	
	public function setByPosition($pos, $value)
	{
		switch($pos) {
			case 0:
				$this->setGroupId($value);
				break;
			case 1:
				$this->setPermissionId($value);
				break;
		} 	}

	
	public function fromArray($arr, $keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = sfGuardGroupPermissionPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setGroupId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setPermissionId($arr[$keys[1]]);
	}

	
	public function buildCriteria()
	{
		$criteria = new Criteria(sfGuardGroupPermissionPeer::DATABASE_NAME);

		if ($this->isColumnModified(sfGuardGroupPermissionPeer::GROUP_ID)) $criteria->add(sfGuardGroupPermissionPeer::GROUP_ID, $this->group_id);
		if ($this->isColumnModified(sfGuardGroupPermissionPeer::PERMISSION_ID)) $criteria->add(sfGuardGroupPermissionPeer::PERMISSION_ID, $this->permission_id);

		return $criteria;
	}

	
	public function buildPkeyCriteria()
	{
		$criteria = new Criteria(sfGuardGroupPermissionPeer::DATABASE_NAME);

		$criteria->add(sfGuardGroupPermissionPeer::GROUP_ID, $this->group_id);
		$criteria->add(sfGuardGroupPermissionPeer::PERMISSION_ID, $this->permission_id);

		return $criteria;
	}

	
	public function getPrimaryKey()
	{
		$pks = array();

		$pks[0] = $this->getGroupId();

		$pks[1] = $this->getPermissionId();

		return $pks;
	}

	
	public function setPrimaryKey($keys)
	{

		$this->setGroupId($keys[0]);

		$this->setPermissionId($keys[1]);

	}

	
	public function copyInto($copyObj, $deepCopy = false)
	{


		$copyObj->setNew(true);

		$copyObj->setGroupId(NULL); 
		$copyObj->setPermissionId(NULL); 
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
			self::$peer = new sfGuardGroupPermissionPeer();
		}
		return self::$peer;
	}

	
	public function setsfGuardGroup($v)
	{


		if ($v === null) {
			$this->setGroupId(NULL);
		} else {
			$this->setGroupId($v->getId());
		}


		$this->asfGuardGroup = $v;
	}


	
	public function getsfGuardGroup($con = null)
	{
		if ($this->asfGuardGroup === null && ($this->group_id !== null)) {
						include_once 'plugins/sfGuardPlugin/lib/model/om/BasesfGuardGroupPeer.php';

			$this->asfGuardGroup = sfGuardGroupPeer::retrieveByPK($this->group_id, $con);

			
		}
		return $this->asfGuardGroup;
	}

	
	public function setsfGuardPermission($v)
	{


		if ($v === null) {
			$this->setPermissionId(NULL);
		} else {
			$this->setPermissionId($v->getId());
		}


		$this->asfGuardPermission = $v;
	}


	
	public function getsfGuardPermission($con = null)
	{
		if ($this->asfGuardPermission === null && ($this->permission_id !== null)) {
						include_once 'plugins/sfGuardPlugin/lib/model/om/BasesfGuardPermissionPeer.php';

			$this->asfGuardPermission = sfGuardPermissionPeer::retrieveByPK($this->permission_id, $con);

			
		}
		return $this->asfGuardPermission;
	}


  public function __call($method, $arguments)
  {
    if (!$callable = sfMixer::getCallable('BasesfGuardGroupPermission:'.$method))
    {
      throw new sfException(sprintf('Call to undefined method BasesfGuardGroupPermission::%s', $method));
    }

    array_unshift($arguments, $this);

    return call_user_func_array($callable, $arguments);
  }


} 