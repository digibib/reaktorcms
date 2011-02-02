<?php


abstract class BaseMessages extends BaseObject  implements Persistent {


	
	protected static $peer;


	
	protected $id;


	
	protected $to_user_id;


	
	protected $from_user_id;


	
	protected $subject;


	
	protected $message;


	
	protected $timestamp;


	
	protected $deleted_by_from = 0;


	
	protected $deleted_by_to = 0;


	
	protected $is_read = false;


	
	protected $is_ignored = false;


	
	protected $is_archived = false;


	
	protected $reply_to = 0;

	
	protected $asfGuardUserRelatedByToUserId;

	
	protected $asfGuardUserRelatedByFromUserId;

	
	protected $alreadyInSave = false;

	
	protected $alreadyInValidation = false;

	
	public function getId()
	{

		return $this->id;
	}

	
	public function getToUserId()
	{

		return $this->to_user_id;
	}

	
	public function getFromUserId()
	{

		return $this->from_user_id;
	}

	
	public function getSubject()
	{

		return $this->subject;
	}

	
	public function getMessage()
	{

		return $this->message;
	}

	
	public function getTimestamp($format = 'Y-m-d H:i:s')
	{

		if ($this->timestamp === null || $this->timestamp === '') {
			return null;
		} elseif (!is_int($this->timestamp)) {
						$ts = strtotime($this->timestamp);
			if ($ts === -1 || $ts === false) { 				throw new PropelException("Unable to parse value of [timestamp] as date/time value: " . var_export($this->timestamp, true));
			}
		} else {
			$ts = $this->timestamp;
		}
		if ($format === null) {
			return $ts;
		} elseif (strpos($format, '%') !== false) {
			return strftime($format, $ts);
		} else {
			return date($format, $ts);
		}
	}

	
	public function getDeletedByFrom()
	{

		return $this->deleted_by_from;
	}

	
	public function getDeletedByTo()
	{

		return $this->deleted_by_to;
	}

	
	public function getIsRead()
	{

		return $this->is_read;
	}

	
	public function getIsIgnored()
	{

		return $this->is_ignored;
	}

	
	public function getIsArchived()
	{

		return $this->is_archived;
	}

	
	public function getReplyTo()
	{

		return $this->reply_to;
	}

	
	public function setId($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->id !== $v) {
			$this->id = $v;
			$this->modifiedColumns[] = MessagesPeer::ID;
		}

	} 
	
	public function setToUserId($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->to_user_id !== $v) {
			$this->to_user_id = $v;
			$this->modifiedColumns[] = MessagesPeer::TO_USER_ID;
		}

		if ($this->asfGuardUserRelatedByToUserId !== null && $this->asfGuardUserRelatedByToUserId->getId() !== $v) {
			$this->asfGuardUserRelatedByToUserId = null;
		}

	} 
	
	public function setFromUserId($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->from_user_id !== $v) {
			$this->from_user_id = $v;
			$this->modifiedColumns[] = MessagesPeer::FROM_USER_ID;
		}

		if ($this->asfGuardUserRelatedByFromUserId !== null && $this->asfGuardUserRelatedByFromUserId->getId() !== $v) {
			$this->asfGuardUserRelatedByFromUserId = null;
		}

	} 
	
	public function setSubject($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->subject !== $v) {
			$this->subject = $v;
			$this->modifiedColumns[] = MessagesPeer::SUBJECT;
		}

	} 
	
	public function setMessage($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->message !== $v) {
			$this->message = $v;
			$this->modifiedColumns[] = MessagesPeer::MESSAGE;
		}

	} 
	
	public function setTimestamp($v)
	{

		if ($v !== null && !is_int($v)) {
			$ts = strtotime($v);
			if ($ts === -1 || $ts === false) { 				throw new PropelException("Unable to parse date/time value for [timestamp] from input: " . var_export($v, true));
			}
		} else {
			$ts = $v;
		}
		if ($this->timestamp !== $ts) {
			$this->timestamp = $ts;
			$this->modifiedColumns[] = MessagesPeer::TIMESTAMP;
		}

	} 
	
	public function setDeletedByFrom($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->deleted_by_from !== $v || $v === 0) {
			$this->deleted_by_from = $v;
			$this->modifiedColumns[] = MessagesPeer::DELETED_BY_FROM;
		}

	} 
	
	public function setDeletedByTo($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->deleted_by_to !== $v || $v === 0) {
			$this->deleted_by_to = $v;
			$this->modifiedColumns[] = MessagesPeer::DELETED_BY_TO;
		}

	} 
	
	public function setIsRead($v)
	{

		if ($this->is_read !== $v || $v === false) {
			$this->is_read = $v;
			$this->modifiedColumns[] = MessagesPeer::IS_READ;
		}

	} 
	
	public function setIsIgnored($v)
	{

		if ($this->is_ignored !== $v || $v === false) {
			$this->is_ignored = $v;
			$this->modifiedColumns[] = MessagesPeer::IS_IGNORED;
		}

	} 
	
	public function setIsArchived($v)
	{

		if ($this->is_archived !== $v || $v === false) {
			$this->is_archived = $v;
			$this->modifiedColumns[] = MessagesPeer::IS_ARCHIVED;
		}

	} 
	
	public function setReplyTo($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->reply_to !== $v || $v === 0) {
			$this->reply_to = $v;
			$this->modifiedColumns[] = MessagesPeer::REPLY_TO;
		}

	} 
	
	public function hydrate(ResultSet $rs, $startcol = 1)
	{
		try {

			$this->id = $rs->getInt($startcol + 0);

			$this->to_user_id = $rs->getInt($startcol + 1);

			$this->from_user_id = $rs->getInt($startcol + 2);

			$this->subject = $rs->getString($startcol + 3);

			$this->message = $rs->getString($startcol + 4);

			$this->timestamp = $rs->getTimestamp($startcol + 5, null);

			$this->deleted_by_from = $rs->getInt($startcol + 6);

			$this->deleted_by_to = $rs->getInt($startcol + 7);

			$this->is_read = $rs->getBoolean($startcol + 8);

			$this->is_ignored = $rs->getBoolean($startcol + 9);

			$this->is_archived = $rs->getBoolean($startcol + 10);

			$this->reply_to = $rs->getInt($startcol + 11);

			$this->resetModified();

			$this->setNew(false);

						return $startcol + 12; 
		} catch (Exception $e) {
			throw new PropelException("Error populating Messages object", $e);
		}
	}

	
	public function delete($con = null)
	{

    foreach (sfMixer::getCallables('BaseMessages:delete:pre') as $callable)
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
			$con = Propel::getConnection(MessagesPeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			MessagesPeer::doDelete($this, $con);
			$this->setDeleted(true);
			$con->commit();
		} catch (PropelException $e) {
			$con->rollback();
			throw $e;
		}
	

    foreach (sfMixer::getCallables('BaseMessages:delete:post') as $callable)
    {
      call_user_func($callable, $this, $con);
    }

  }
	
	public function save($con = null)
	{

    foreach (sfMixer::getCallables('BaseMessages:save:pre') as $callable)
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
			$con = Propel::getConnection(MessagesPeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			$affectedRows = $this->doSave($con);
			$con->commit();
    foreach (sfMixer::getCallables('BaseMessages:save:post') as $callable)
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


												
			if ($this->asfGuardUserRelatedByToUserId !== null) {
				if ($this->asfGuardUserRelatedByToUserId->isModified()) {
					$affectedRows += $this->asfGuardUserRelatedByToUserId->save($con);
				}
				$this->setsfGuardUserRelatedByToUserId($this->asfGuardUserRelatedByToUserId);
			}

			if ($this->asfGuardUserRelatedByFromUserId !== null) {
				if ($this->asfGuardUserRelatedByFromUserId->isModified()) {
					$affectedRows += $this->asfGuardUserRelatedByFromUserId->save($con);
				}
				$this->setsfGuardUserRelatedByFromUserId($this->asfGuardUserRelatedByFromUserId);
			}


						if ($this->isModified()) {
				if ($this->isNew()) {
					$pk = MessagesPeer::doInsert($this, $con);
					$affectedRows += 1; 										 										 
					$this->setId($pk);  
					$this->setNew(false);
				} else {
					$affectedRows += MessagesPeer::doUpdate($this, $con);
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


												
			if ($this->asfGuardUserRelatedByToUserId !== null) {
				if (!$this->asfGuardUserRelatedByToUserId->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->asfGuardUserRelatedByToUserId->getValidationFailures());
				}
			}

			if ($this->asfGuardUserRelatedByFromUserId !== null) {
				if (!$this->asfGuardUserRelatedByFromUserId->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->asfGuardUserRelatedByFromUserId->getValidationFailures());
				}
			}


			if (($retval = MessagesPeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}



			$this->alreadyInValidation = false;
		}

		return (!empty($failureMap) ? $failureMap : true);
	}

	
	public function getByName($name, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = MessagesPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->getByPosition($pos);
	}

	
	public function getByPosition($pos)
	{
		switch($pos) {
			case 0:
				return $this->getId();
				break;
			case 1:
				return $this->getToUserId();
				break;
			case 2:
				return $this->getFromUserId();
				break;
			case 3:
				return $this->getSubject();
				break;
			case 4:
				return $this->getMessage();
				break;
			case 5:
				return $this->getTimestamp();
				break;
			case 6:
				return $this->getDeletedByFrom();
				break;
			case 7:
				return $this->getDeletedByTo();
				break;
			case 8:
				return $this->getIsRead();
				break;
			case 9:
				return $this->getIsIgnored();
				break;
			case 10:
				return $this->getIsArchived();
				break;
			case 11:
				return $this->getReplyTo();
				break;
			default:
				return null;
				break;
		} 	}

	
	public function toArray($keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = MessagesPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getId(),
			$keys[1] => $this->getToUserId(),
			$keys[2] => $this->getFromUserId(),
			$keys[3] => $this->getSubject(),
			$keys[4] => $this->getMessage(),
			$keys[5] => $this->getTimestamp(),
			$keys[6] => $this->getDeletedByFrom(),
			$keys[7] => $this->getDeletedByTo(),
			$keys[8] => $this->getIsRead(),
			$keys[9] => $this->getIsIgnored(),
			$keys[10] => $this->getIsArchived(),
			$keys[11] => $this->getReplyTo(),
		);
		return $result;
	}

	
	public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = MessagesPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->setByPosition($pos, $value);
	}

	
	public function setByPosition($pos, $value)
	{
		switch($pos) {
			case 0:
				$this->setId($value);
				break;
			case 1:
				$this->setToUserId($value);
				break;
			case 2:
				$this->setFromUserId($value);
				break;
			case 3:
				$this->setSubject($value);
				break;
			case 4:
				$this->setMessage($value);
				break;
			case 5:
				$this->setTimestamp($value);
				break;
			case 6:
				$this->setDeletedByFrom($value);
				break;
			case 7:
				$this->setDeletedByTo($value);
				break;
			case 8:
				$this->setIsRead($value);
				break;
			case 9:
				$this->setIsIgnored($value);
				break;
			case 10:
				$this->setIsArchived($value);
				break;
			case 11:
				$this->setReplyTo($value);
				break;
		} 	}

	
	public function fromArray($arr, $keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = MessagesPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setToUserId($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setFromUserId($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setSubject($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setMessage($arr[$keys[4]]);
		if (array_key_exists($keys[5], $arr)) $this->setTimestamp($arr[$keys[5]]);
		if (array_key_exists($keys[6], $arr)) $this->setDeletedByFrom($arr[$keys[6]]);
		if (array_key_exists($keys[7], $arr)) $this->setDeletedByTo($arr[$keys[7]]);
		if (array_key_exists($keys[8], $arr)) $this->setIsRead($arr[$keys[8]]);
		if (array_key_exists($keys[9], $arr)) $this->setIsIgnored($arr[$keys[9]]);
		if (array_key_exists($keys[10], $arr)) $this->setIsArchived($arr[$keys[10]]);
		if (array_key_exists($keys[11], $arr)) $this->setReplyTo($arr[$keys[11]]);
	}

	
	public function buildCriteria()
	{
		$criteria = new Criteria(MessagesPeer::DATABASE_NAME);

		if ($this->isColumnModified(MessagesPeer::ID)) $criteria->add(MessagesPeer::ID, $this->id);
		if ($this->isColumnModified(MessagesPeer::TO_USER_ID)) $criteria->add(MessagesPeer::TO_USER_ID, $this->to_user_id);
		if ($this->isColumnModified(MessagesPeer::FROM_USER_ID)) $criteria->add(MessagesPeer::FROM_USER_ID, $this->from_user_id);
		if ($this->isColumnModified(MessagesPeer::SUBJECT)) $criteria->add(MessagesPeer::SUBJECT, $this->subject);
		if ($this->isColumnModified(MessagesPeer::MESSAGE)) $criteria->add(MessagesPeer::MESSAGE, $this->message);
		if ($this->isColumnModified(MessagesPeer::TIMESTAMP)) $criteria->add(MessagesPeer::TIMESTAMP, $this->timestamp);
		if ($this->isColumnModified(MessagesPeer::DELETED_BY_FROM)) $criteria->add(MessagesPeer::DELETED_BY_FROM, $this->deleted_by_from);
		if ($this->isColumnModified(MessagesPeer::DELETED_BY_TO)) $criteria->add(MessagesPeer::DELETED_BY_TO, $this->deleted_by_to);
		if ($this->isColumnModified(MessagesPeer::IS_READ)) $criteria->add(MessagesPeer::IS_READ, $this->is_read);
		if ($this->isColumnModified(MessagesPeer::IS_IGNORED)) $criteria->add(MessagesPeer::IS_IGNORED, $this->is_ignored);
		if ($this->isColumnModified(MessagesPeer::IS_ARCHIVED)) $criteria->add(MessagesPeer::IS_ARCHIVED, $this->is_archived);
		if ($this->isColumnModified(MessagesPeer::REPLY_TO)) $criteria->add(MessagesPeer::REPLY_TO, $this->reply_to);

		return $criteria;
	}

	
	public function buildPkeyCriteria()
	{
		$criteria = new Criteria(MessagesPeer::DATABASE_NAME);

		$criteria->add(MessagesPeer::ID, $this->id);

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

		$copyObj->setToUserId($this->to_user_id);

		$copyObj->setFromUserId($this->from_user_id);

		$copyObj->setSubject($this->subject);

		$copyObj->setMessage($this->message);

		$copyObj->setTimestamp($this->timestamp);

		$copyObj->setDeletedByFrom($this->deleted_by_from);

		$copyObj->setDeletedByTo($this->deleted_by_to);

		$copyObj->setIsRead($this->is_read);

		$copyObj->setIsIgnored($this->is_ignored);

		$copyObj->setIsArchived($this->is_archived);

		$copyObj->setReplyTo($this->reply_to);


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
			self::$peer = new MessagesPeer();
		}
		return self::$peer;
	}

	
	public function setsfGuardUserRelatedByToUserId($v)
	{


		if ($v === null) {
			$this->setToUserId(NULL);
		} else {
			$this->setToUserId($v->getId());
		}


		$this->asfGuardUserRelatedByToUserId = $v;
	}


	
	public function getsfGuardUserRelatedByToUserId($con = null)
	{
		if ($this->asfGuardUserRelatedByToUserId === null && ($this->to_user_id !== null)) {
						include_once 'plugins/sfGuardPlugin/lib/model/om/BasesfGuardUserPeer.php';

			$this->asfGuardUserRelatedByToUserId = sfGuardUserPeer::retrieveByPK($this->to_user_id, $con);

			
		}
		return $this->asfGuardUserRelatedByToUserId;
	}

	
	public function setsfGuardUserRelatedByFromUserId($v)
	{


		if ($v === null) {
			$this->setFromUserId(NULL);
		} else {
			$this->setFromUserId($v->getId());
		}


		$this->asfGuardUserRelatedByFromUserId = $v;
	}


	
	public function getsfGuardUserRelatedByFromUserId($con = null)
	{
		if ($this->asfGuardUserRelatedByFromUserId === null && ($this->from_user_id !== null)) {
						include_once 'plugins/sfGuardPlugin/lib/model/om/BasesfGuardUserPeer.php';

			$this->asfGuardUserRelatedByFromUserId = sfGuardUserPeer::retrieveByPK($this->from_user_id, $con);

			
		}
		return $this->asfGuardUserRelatedByFromUserId;
	}


  public function __call($method, $arguments)
  {
    if (!$callable = sfMixer::getCallable('BaseMessages:'.$method))
    {
      throw new sfException(sprintf('Call to undefined method BaseMessages::%s', $method));
    }

    array_unshift($arguments, $this);

    return call_user_func_array($callable, $arguments);
  }


} 