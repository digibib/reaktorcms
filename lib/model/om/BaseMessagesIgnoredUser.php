<?php


abstract class BaseMessagesIgnoredUser extends BaseObject  implements Persistent {


	
	protected static $peer;


	
	protected $id;


	
	protected $user_id;


	
	protected $ignores_user_id;

	
	protected $asfGuardUserRelatedByUserId;

	
	protected $asfGuardUserRelatedByIgnoresUserId;

	
	protected $alreadyInSave = false;

	
	protected $alreadyInValidation = false;

	
	public function getId()
	{

		return $this->id;
	}

	
	public function getUserId()
	{

		return $this->user_id;
	}

	
	public function getIgnoresUserId()
	{

		return $this->ignores_user_id;
	}

	
	public function setId($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->id !== $v) {
			$this->id = $v;
			$this->modifiedColumns[] = MessagesIgnoredUserPeer::ID;
		}

	} 
	
	public function setUserId($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->user_id !== $v) {
			$this->user_id = $v;
			$this->modifiedColumns[] = MessagesIgnoredUserPeer::USER_ID;
		}

		if ($this->asfGuardUserRelatedByUserId !== null && $this->asfGuardUserRelatedByUserId->getId() !== $v) {
			$this->asfGuardUserRelatedByUserId = null;
		}

	} 
	
	public function setIgnoresUserId($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->ignores_user_id !== $v) {
			$this->ignores_user_id = $v;
			$this->modifiedColumns[] = MessagesIgnoredUserPeer::IGNORES_USER_ID;
		}

		if ($this->asfGuardUserRelatedByIgnoresUserId !== null && $this->asfGuardUserRelatedByIgnoresUserId->getId() !== $v) {
			$this->asfGuardUserRelatedByIgnoresUserId = null;
		}

	} 
	
	public function hydrate(ResultSet $rs, $startcol = 1)
	{
		try {

			$this->id = $rs->getInt($startcol + 0);

			$this->user_id = $rs->getInt($startcol + 1);

			$this->ignores_user_id = $rs->getInt($startcol + 2);

			$this->resetModified();

			$this->setNew(false);

						return $startcol + 3; 
		} catch (Exception $e) {
			throw new PropelException("Error populating MessagesIgnoredUser object", $e);
		}
	}

	
	public function delete($con = null)
	{

    foreach (sfMixer::getCallables('BaseMessagesIgnoredUser:delete:pre') as $callable)
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
			$con = Propel::getConnection(MessagesIgnoredUserPeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			MessagesIgnoredUserPeer::doDelete($this, $con);
			$this->setDeleted(true);
			$con->commit();
		} catch (PropelException $e) {
			$con->rollback();
			throw $e;
		}
	

    foreach (sfMixer::getCallables('BaseMessagesIgnoredUser:delete:post') as $callable)
    {
      call_user_func($callable, $this, $con);
    }

  }
	
	public function save($con = null)
	{

    foreach (sfMixer::getCallables('BaseMessagesIgnoredUser:save:pre') as $callable)
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
			$con = Propel::getConnection(MessagesIgnoredUserPeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			$affectedRows = $this->doSave($con);
			$con->commit();
    foreach (sfMixer::getCallables('BaseMessagesIgnoredUser:save:post') as $callable)
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


												
			if ($this->asfGuardUserRelatedByUserId !== null) {
				if ($this->asfGuardUserRelatedByUserId->isModified()) {
					$affectedRows += $this->asfGuardUserRelatedByUserId->save($con);
				}
				$this->setsfGuardUserRelatedByUserId($this->asfGuardUserRelatedByUserId);
			}

			if ($this->asfGuardUserRelatedByIgnoresUserId !== null) {
				if ($this->asfGuardUserRelatedByIgnoresUserId->isModified()) {
					$affectedRows += $this->asfGuardUserRelatedByIgnoresUserId->save($con);
				}
				$this->setsfGuardUserRelatedByIgnoresUserId($this->asfGuardUserRelatedByIgnoresUserId);
			}


						if ($this->isModified()) {
				if ($this->isNew()) {
					$pk = MessagesIgnoredUserPeer::doInsert($this, $con);
					$affectedRows += 1; 										 										 
					$this->setId($pk);  
					$this->setNew(false);
				} else {
					$affectedRows += MessagesIgnoredUserPeer::doUpdate($this, $con);
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


												
			if ($this->asfGuardUserRelatedByUserId !== null) {
				if (!$this->asfGuardUserRelatedByUserId->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->asfGuardUserRelatedByUserId->getValidationFailures());
				}
			}

			if ($this->asfGuardUserRelatedByIgnoresUserId !== null) {
				if (!$this->asfGuardUserRelatedByIgnoresUserId->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->asfGuardUserRelatedByIgnoresUserId->getValidationFailures());
				}
			}


			if (($retval = MessagesIgnoredUserPeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}



			$this->alreadyInValidation = false;
		}

		return (!empty($failureMap) ? $failureMap : true);
	}

	
	public function getByName($name, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = MessagesIgnoredUserPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->getByPosition($pos);
	}

	
	public function getByPosition($pos)
	{
		switch($pos) {
			case 0:
				return $this->getId();
				break;
			case 1:
				return $this->getUserId();
				break;
			case 2:
				return $this->getIgnoresUserId();
				break;
			default:
				return null;
				break;
		} 	}

	
	public function toArray($keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = MessagesIgnoredUserPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getId(),
			$keys[1] => $this->getUserId(),
			$keys[2] => $this->getIgnoresUserId(),
		);
		return $result;
	}

	
	public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = MessagesIgnoredUserPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->setByPosition($pos, $value);
	}

	
	public function setByPosition($pos, $value)
	{
		switch($pos) {
			case 0:
				$this->setId($value);
				break;
			case 1:
				$this->setUserId($value);
				break;
			case 2:
				$this->setIgnoresUserId($value);
				break;
		} 	}

	
	public function fromArray($arr, $keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = MessagesIgnoredUserPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setUserId($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setIgnoresUserId($arr[$keys[2]]);
	}

	
	public function buildCriteria()
	{
		$criteria = new Criteria(MessagesIgnoredUserPeer::DATABASE_NAME);

		if ($this->isColumnModified(MessagesIgnoredUserPeer::ID)) $criteria->add(MessagesIgnoredUserPeer::ID, $this->id);
		if ($this->isColumnModified(MessagesIgnoredUserPeer::USER_ID)) $criteria->add(MessagesIgnoredUserPeer::USER_ID, $this->user_id);
		if ($this->isColumnModified(MessagesIgnoredUserPeer::IGNORES_USER_ID)) $criteria->add(MessagesIgnoredUserPeer::IGNORES_USER_ID, $this->ignores_user_id);

		return $criteria;
	}

	
	public function buildPkeyCriteria()
	{
		$criteria = new Criteria(MessagesIgnoredUserPeer::DATABASE_NAME);

		$criteria->add(MessagesIgnoredUserPeer::ID, $this->id);

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

		$copyObj->setUserId($this->user_id);

		$copyObj->setIgnoresUserId($this->ignores_user_id);


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
			self::$peer = new MessagesIgnoredUserPeer();
		}
		return self::$peer;
	}

	
	public function setsfGuardUserRelatedByUserId($v)
	{


		if ($v === null) {
			$this->setUserId(NULL);
		} else {
			$this->setUserId($v->getId());
		}


		$this->asfGuardUserRelatedByUserId = $v;
	}


	
	public function getsfGuardUserRelatedByUserId($con = null)
	{
		if ($this->asfGuardUserRelatedByUserId === null && ($this->user_id !== null)) {
						include_once 'plugins/sfGuardPlugin/lib/model/om/BasesfGuardUserPeer.php';

			$this->asfGuardUserRelatedByUserId = sfGuardUserPeer::retrieveByPK($this->user_id, $con);

			
		}
		return $this->asfGuardUserRelatedByUserId;
	}

	
	public function setsfGuardUserRelatedByIgnoresUserId($v)
	{


		if ($v === null) {
			$this->setIgnoresUserId(NULL);
		} else {
			$this->setIgnoresUserId($v->getId());
		}


		$this->asfGuardUserRelatedByIgnoresUserId = $v;
	}


	
	public function getsfGuardUserRelatedByIgnoresUserId($con = null)
	{
		if ($this->asfGuardUserRelatedByIgnoresUserId === null && ($this->ignores_user_id !== null)) {
						include_once 'plugins/sfGuardPlugin/lib/model/om/BasesfGuardUserPeer.php';

			$this->asfGuardUserRelatedByIgnoresUserId = sfGuardUserPeer::retrieveByPK($this->ignores_user_id, $con);

			
		}
		return $this->asfGuardUserRelatedByIgnoresUserId;
	}


  public function __call($method, $arguments)
  {
    if (!$callable = sfMixer::getCallable('BaseMessagesIgnoredUser:'.$method))
    {
      throw new sfException(sprintf('Call to undefined method BaseMessagesIgnoredUser::%s', $method));
    }

    array_unshift($arguments, $this);

    return call_user_func_array($callable, $arguments);
  }


} 