<?php


abstract class BasesfGuardUserPermission extends BaseObject  implements Persistent {


	
	protected static $peer;


	
	protected $user_id;


	
	protected $permission_id;


	
	protected $exclude = false;

	
	protected $asfGuardUser;

	
	protected $asfGuardPermission;

	
	protected $alreadyInSave = false;

	
	protected $alreadyInValidation = false;

	
	public function getUserId()
	{

		return $this->user_id;
	}

	
	public function getPermissionId()
	{

		return $this->permission_id;
	}

	
	public function getExclude()
	{

		return $this->exclude;
	}

	
	public function setUserId($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->user_id !== $v) {
			$this->user_id = $v;
			$this->modifiedColumns[] = sfGuardUserPermissionPeer::USER_ID;
		}

		if ($this->asfGuardUser !== null && $this->asfGuardUser->getId() !== $v) {
			$this->asfGuardUser = null;
		}

	} 
	
	public function setPermissionId($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->permission_id !== $v) {
			$this->permission_id = $v;
			$this->modifiedColumns[] = sfGuardUserPermissionPeer::PERMISSION_ID;
		}

		if ($this->asfGuardPermission !== null && $this->asfGuardPermission->getId() !== $v) {
			$this->asfGuardPermission = null;
		}

	} 
	
	public function setExclude($v)
	{

		if ($this->exclude !== $v || $v === false) {
			$this->exclude = $v;
			$this->modifiedColumns[] = sfGuardUserPermissionPeer::EXCLUDE;
		}

	} 
	
	public function hydrate(ResultSet $rs, $startcol = 1)
	{
		try {

			$this->user_id = $rs->getInt($startcol + 0);

			$this->permission_id = $rs->getInt($startcol + 1);

			$this->exclude = $rs->getBoolean($startcol + 2);

			$this->resetModified();

			$this->setNew(false);

						return $startcol + 3; 
		} catch (Exception $e) {
			throw new PropelException("Error populating sfGuardUserPermission object", $e);
		}
	}

	
	public function delete($con = null)
	{

    foreach (sfMixer::getCallables('BasesfGuardUserPermission:delete:pre') as $callable)
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
			$con = Propel::getConnection(sfGuardUserPermissionPeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			sfGuardUserPermissionPeer::doDelete($this, $con);
			$this->setDeleted(true);
			$con->commit();
		} catch (PropelException $e) {
			$con->rollback();
			throw $e;
		}
	

    foreach (sfMixer::getCallables('BasesfGuardUserPermission:delete:post') as $callable)
    {
      call_user_func($callable, $this, $con);
    }

  }
	
	public function save($con = null)
	{

    foreach (sfMixer::getCallables('BasesfGuardUserPermission:save:pre') as $callable)
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
			$con = Propel::getConnection(sfGuardUserPermissionPeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			$affectedRows = $this->doSave($con);
			$con->commit();
    foreach (sfMixer::getCallables('BasesfGuardUserPermission:save:post') as $callable)
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


												
			if ($this->asfGuardUser !== null) {
				if ($this->asfGuardUser->isModified()) {
					$affectedRows += $this->asfGuardUser->save($con);
				}
				$this->setsfGuardUser($this->asfGuardUser);
			}

			if ($this->asfGuardPermission !== null) {
				if ($this->asfGuardPermission->isModified() || $this->asfGuardPermission->getCurrentsfGuardPermissionI18n()->isModified()) {
					$affectedRows += $this->asfGuardPermission->save($con);
				}
				$this->setsfGuardPermission($this->asfGuardPermission);
			}


						if ($this->isModified()) {
				if ($this->isNew()) {
					$pk = sfGuardUserPermissionPeer::doInsert($this, $con);
					$affectedRows += 1; 										 										 
					$this->setNew(false);
				} else {
					$affectedRows += sfGuardUserPermissionPeer::doUpdate($this, $con);
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


												
			if ($this->asfGuardUser !== null) {
				if (!$this->asfGuardUser->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->asfGuardUser->getValidationFailures());
				}
			}

			if ($this->asfGuardPermission !== null) {
				if (!$this->asfGuardPermission->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->asfGuardPermission->getValidationFailures());
				}
			}


			if (($retval = sfGuardUserPermissionPeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}



			$this->alreadyInValidation = false;
		}

		return (!empty($failureMap) ? $failureMap : true);
	}

	
	public function getByName($name, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = sfGuardUserPermissionPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->getByPosition($pos);
	}

	
	public function getByPosition($pos)
	{
		switch($pos) {
			case 0:
				return $this->getUserId();
				break;
			case 1:
				return $this->getPermissionId();
				break;
			case 2:
				return $this->getExclude();
				break;
			default:
				return null;
				break;
		} 	}

	
	public function toArray($keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = sfGuardUserPermissionPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getUserId(),
			$keys[1] => $this->getPermissionId(),
			$keys[2] => $this->getExclude(),
		);
		return $result;
	}

	
	public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = sfGuardUserPermissionPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->setByPosition($pos, $value);
	}

	
	public function setByPosition($pos, $value)
	{
		switch($pos) {
			case 0:
				$this->setUserId($value);
				break;
			case 1:
				$this->setPermissionId($value);
				break;
			case 2:
				$this->setExclude($value);
				break;
		} 	}

	
	public function fromArray($arr, $keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = sfGuardUserPermissionPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setUserId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setPermissionId($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setExclude($arr[$keys[2]]);
	}

	
	public function buildCriteria()
	{
		$criteria = new Criteria(sfGuardUserPermissionPeer::DATABASE_NAME);

		if ($this->isColumnModified(sfGuardUserPermissionPeer::USER_ID)) $criteria->add(sfGuardUserPermissionPeer::USER_ID, $this->user_id);
		if ($this->isColumnModified(sfGuardUserPermissionPeer::PERMISSION_ID)) $criteria->add(sfGuardUserPermissionPeer::PERMISSION_ID, $this->permission_id);
		if ($this->isColumnModified(sfGuardUserPermissionPeer::EXCLUDE)) $criteria->add(sfGuardUserPermissionPeer::EXCLUDE, $this->exclude);

		return $criteria;
	}

	
	public function buildPkeyCriteria()
	{
		$criteria = new Criteria(sfGuardUserPermissionPeer::DATABASE_NAME);

		$criteria->add(sfGuardUserPermissionPeer::USER_ID, $this->user_id);
		$criteria->add(sfGuardUserPermissionPeer::PERMISSION_ID, $this->permission_id);

		return $criteria;
	}

	
	public function getPrimaryKey()
	{
		$pks = array();

		$pks[0] = $this->getUserId();

		$pks[1] = $this->getPermissionId();

		return $pks;
	}

	
	public function setPrimaryKey($keys)
	{

		$this->setUserId($keys[0]);

		$this->setPermissionId($keys[1]);

	}

	
	public function copyInto($copyObj, $deepCopy = false)
	{

		$copyObj->setExclude($this->exclude);


		$copyObj->setNew(true);

		$copyObj->setUserId(NULL); 
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
			self::$peer = new sfGuardUserPermissionPeer();
		}
		return self::$peer;
	}

	
	public function setsfGuardUser($v)
	{


		if ($v === null) {
			$this->setUserId(NULL);
		} else {
			$this->setUserId($v->getId());
		}


		$this->asfGuardUser = $v;
	}


	
	public function getsfGuardUser($con = null)
	{
		if ($this->asfGuardUser === null && ($this->user_id !== null)) {
						include_once 'plugins/sfGuardPlugin/lib/model/om/BasesfGuardUserPeer.php';

			$this->asfGuardUser = sfGuardUserPeer::retrieveByPK($this->user_id, $con);

			
		}
		return $this->asfGuardUser;
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
    if (!$callable = sfMixer::getCallable('BasesfGuardUserPermission:'.$method))
    {
      throw new sfException(sprintf('Call to undefined method BasesfGuardUserPermission::%s', $method));
    }

    array_unshift($arguments, $this);

    return call_user_func_array($callable, $arguments);
  }


} 