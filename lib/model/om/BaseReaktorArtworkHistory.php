<?php


abstract class BaseReaktorArtworkHistory extends BaseObject  implements Persistent {


	
	protected static $peer;


	
	protected $id;


	
	protected $artwork_id;


	
	protected $file_id;


	
	protected $created_at;


	
	protected $modified_flag;


	
	protected $user_id;


	
	protected $status;


	
	protected $comment;

	
	protected $aReaktorArtworkRelatedByArtworkId;

	
	protected $aReaktorArtworkRelatedByFileId;

	
	protected $asfGuardUser;

	
	protected $aArtworkStatus;

	
	protected $alreadyInSave = false;

	
	protected $alreadyInValidation = false;

	
	public function getId()
	{

		return $this->id;
	}

	
	public function getArtworkId()
	{

		return $this->artwork_id;
	}

	
	public function getFileId()
	{

		return $this->file_id;
	}

	
	public function getCreatedAt($format = 'Y-m-d H:i:s')
	{

		if ($this->created_at === null || $this->created_at === '') {
			return null;
		} elseif (!is_int($this->created_at)) {
						$ts = strtotime($this->created_at);
			if ($ts === -1 || $ts === false) { 				throw new PropelException("Unable to parse value of [created_at] as date/time value: " . var_export($this->created_at, true));
			}
		} else {
			$ts = $this->created_at;
		}
		if ($format === null) {
			return $ts;
		} elseif (strpos($format, '%') !== false) {
			return strftime($format, $ts);
		} else {
			return date($format, $ts);
		}
	}

	
	public function getModifiedFlag($format = 'Y-m-d H:i:s')
	{

		if ($this->modified_flag === null || $this->modified_flag === '') {
			return null;
		} elseif (!is_int($this->modified_flag)) {
						$ts = strtotime($this->modified_flag);
			if ($ts === -1 || $ts === false) { 				throw new PropelException("Unable to parse value of [modified_flag] as date/time value: " . var_export($this->modified_flag, true));
			}
		} else {
			$ts = $this->modified_flag;
		}
		if ($format === null) {
			return $ts;
		} elseif (strpos($format, '%') !== false) {
			return strftime($format, $ts);
		} else {
			return date($format, $ts);
		}
	}

	
	public function getUserId()
	{

		return $this->user_id;
	}

	
	public function getStatus()
	{

		return $this->status;
	}

	
	public function getComment()
	{

		return $this->comment;
	}

	
	public function setId($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->id !== $v) {
			$this->id = $v;
			$this->modifiedColumns[] = ReaktorArtworkHistoryPeer::ID;
		}

	} 
	
	public function setArtworkId($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->artwork_id !== $v) {
			$this->artwork_id = $v;
			$this->modifiedColumns[] = ReaktorArtworkHistoryPeer::ARTWORK_ID;
		}

		if ($this->aReaktorArtworkRelatedByArtworkId !== null && $this->aReaktorArtworkRelatedByArtworkId->getId() !== $v) {
			$this->aReaktorArtworkRelatedByArtworkId = null;
		}

	} 
	
	public function setFileId($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->file_id !== $v) {
			$this->file_id = $v;
			$this->modifiedColumns[] = ReaktorArtworkHistoryPeer::FILE_ID;
		}

		if ($this->aReaktorArtworkRelatedByFileId !== null && $this->aReaktorArtworkRelatedByFileId->getId() !== $v) {
			$this->aReaktorArtworkRelatedByFileId = null;
		}

	} 
	
	public function setCreatedAt($v)
	{

		if ($v !== null && !is_int($v)) {
			$ts = strtotime($v);
			if ($ts === -1 || $ts === false) { 				throw new PropelException("Unable to parse date/time value for [created_at] from input: " . var_export($v, true));
			}
		} else {
			$ts = $v;
		}
		if ($this->created_at !== $ts) {
			$this->created_at = $ts;
			$this->modifiedColumns[] = ReaktorArtworkHistoryPeer::CREATED_AT;
		}

	} 
	
	public function setModifiedFlag($v)
	{

		if ($v !== null && !is_int($v)) {
			$ts = strtotime($v);
			if ($ts === -1 || $ts === false) { 				throw new PropelException("Unable to parse date/time value for [modified_flag] from input: " . var_export($v, true));
			}
		} else {
			$ts = $v;
		}
		if ($this->modified_flag !== $ts) {
			$this->modified_flag = $ts;
			$this->modifiedColumns[] = ReaktorArtworkHistoryPeer::MODIFIED_FLAG;
		}

	} 
	
	public function setUserId($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->user_id !== $v) {
			$this->user_id = $v;
			$this->modifiedColumns[] = ReaktorArtworkHistoryPeer::USER_ID;
		}

		if ($this->asfGuardUser !== null && $this->asfGuardUser->getId() !== $v) {
			$this->asfGuardUser = null;
		}

	} 
	
	public function setStatus($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->status !== $v) {
			$this->status = $v;
			$this->modifiedColumns[] = ReaktorArtworkHistoryPeer::STATUS;
		}

		if ($this->aArtworkStatus !== null && $this->aArtworkStatus->getId() !== $v) {
			$this->aArtworkStatus = null;
		}

	} 
	
	public function setComment($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->comment !== $v) {
			$this->comment = $v;
			$this->modifiedColumns[] = ReaktorArtworkHistoryPeer::COMMENT;
		}

	} 
	
	public function hydrate(ResultSet $rs, $startcol = 1)
	{
		try {

			$this->id = $rs->getInt($startcol + 0);

			$this->artwork_id = $rs->getInt($startcol + 1);

			$this->file_id = $rs->getInt($startcol + 2);

			$this->created_at = $rs->getTimestamp($startcol + 3, null);

			$this->modified_flag = $rs->getTimestamp($startcol + 4, null);

			$this->user_id = $rs->getInt($startcol + 5);

			$this->status = $rs->getInt($startcol + 6);

			$this->comment = $rs->getString($startcol + 7);

			$this->resetModified();

			$this->setNew(false);

						return $startcol + 8; 
		} catch (Exception $e) {
			throw new PropelException("Error populating ReaktorArtworkHistory object", $e);
		}
	}

	
	public function delete($con = null)
	{

    foreach (sfMixer::getCallables('BaseReaktorArtworkHistory:delete:pre') as $callable)
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
			$con = Propel::getConnection(ReaktorArtworkHistoryPeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			ReaktorArtworkHistoryPeer::doDelete($this, $con);
			$this->setDeleted(true);
			$con->commit();
		} catch (PropelException $e) {
			$con->rollback();
			throw $e;
		}
	

    foreach (sfMixer::getCallables('BaseReaktorArtworkHistory:delete:post') as $callable)
    {
      call_user_func($callable, $this, $con);
    }

  }
	
	public function save($con = null)
	{

    foreach (sfMixer::getCallables('BaseReaktorArtworkHistory:save:pre') as $callable)
    {
      $affectedRows = call_user_func($callable, $this, $con);
      if (is_int($affectedRows))
      {
        return $affectedRows;
      }
    }


    if ($this->isNew() && !$this->isColumnModified(ReaktorArtworkHistoryPeer::CREATED_AT))
    {
      $this->setCreatedAt(time());
    }

		if ($this->isDeleted()) {
			throw new PropelException("You cannot save an object that has been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(ReaktorArtworkHistoryPeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			$affectedRows = $this->doSave($con);
			$con->commit();
    foreach (sfMixer::getCallables('BaseReaktorArtworkHistory:save:post') as $callable)
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


												
			if ($this->aReaktorArtworkRelatedByArtworkId !== null) {
				if ($this->aReaktorArtworkRelatedByArtworkId->isModified()) {
					$affectedRows += $this->aReaktorArtworkRelatedByArtworkId->save($con);
				}
				$this->setReaktorArtworkRelatedByArtworkId($this->aReaktorArtworkRelatedByArtworkId);
			}

			if ($this->aReaktorArtworkRelatedByFileId !== null) {
				if ($this->aReaktorArtworkRelatedByFileId->isModified()) {
					$affectedRows += $this->aReaktorArtworkRelatedByFileId->save($con);
				}
				$this->setReaktorArtworkRelatedByFileId($this->aReaktorArtworkRelatedByFileId);
			}

			if ($this->asfGuardUser !== null) {
				if ($this->asfGuardUser->isModified()) {
					$affectedRows += $this->asfGuardUser->save($con);
				}
				$this->setsfGuardUser($this->asfGuardUser);
			}

			if ($this->aArtworkStatus !== null) {
				if ($this->aArtworkStatus->isModified() || $this->aArtworkStatus->getCurrentArtworkStatusI18n()->isModified()) {
					$affectedRows += $this->aArtworkStatus->save($con);
				}
				$this->setArtworkStatus($this->aArtworkStatus);
			}


						if ($this->isModified()) {
				if ($this->isNew()) {
					$pk = ReaktorArtworkHistoryPeer::doInsert($this, $con);
					$affectedRows += 1; 										 										 
					$this->setId($pk);  
					$this->setNew(false);
				} else {
					$affectedRows += ReaktorArtworkHistoryPeer::doUpdate($this, $con);
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


												
			if ($this->aReaktorArtworkRelatedByArtworkId !== null) {
				if (!$this->aReaktorArtworkRelatedByArtworkId->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aReaktorArtworkRelatedByArtworkId->getValidationFailures());
				}
			}

			if ($this->aReaktorArtworkRelatedByFileId !== null) {
				if (!$this->aReaktorArtworkRelatedByFileId->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aReaktorArtworkRelatedByFileId->getValidationFailures());
				}
			}

			if ($this->asfGuardUser !== null) {
				if (!$this->asfGuardUser->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->asfGuardUser->getValidationFailures());
				}
			}

			if ($this->aArtworkStatus !== null) {
				if (!$this->aArtworkStatus->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aArtworkStatus->getValidationFailures());
				}
			}


			if (($retval = ReaktorArtworkHistoryPeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}



			$this->alreadyInValidation = false;
		}

		return (!empty($failureMap) ? $failureMap : true);
	}

	
	public function getByName($name, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = ReaktorArtworkHistoryPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->getByPosition($pos);
	}

	
	public function getByPosition($pos)
	{
		switch($pos) {
			case 0:
				return $this->getId();
				break;
			case 1:
				return $this->getArtworkId();
				break;
			case 2:
				return $this->getFileId();
				break;
			case 3:
				return $this->getCreatedAt();
				break;
			case 4:
				return $this->getModifiedFlag();
				break;
			case 5:
				return $this->getUserId();
				break;
			case 6:
				return $this->getStatus();
				break;
			case 7:
				return $this->getComment();
				break;
			default:
				return null;
				break;
		} 	}

	
	public function toArray($keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = ReaktorArtworkHistoryPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getId(),
			$keys[1] => $this->getArtworkId(),
			$keys[2] => $this->getFileId(),
			$keys[3] => $this->getCreatedAt(),
			$keys[4] => $this->getModifiedFlag(),
			$keys[5] => $this->getUserId(),
			$keys[6] => $this->getStatus(),
			$keys[7] => $this->getComment(),
		);
		return $result;
	}

	
	public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = ReaktorArtworkHistoryPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->setByPosition($pos, $value);
	}

	
	public function setByPosition($pos, $value)
	{
		switch($pos) {
			case 0:
				$this->setId($value);
				break;
			case 1:
				$this->setArtworkId($value);
				break;
			case 2:
				$this->setFileId($value);
				break;
			case 3:
				$this->setCreatedAt($value);
				break;
			case 4:
				$this->setModifiedFlag($value);
				break;
			case 5:
				$this->setUserId($value);
				break;
			case 6:
				$this->setStatus($value);
				break;
			case 7:
				$this->setComment($value);
				break;
		} 	}

	
	public function fromArray($arr, $keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = ReaktorArtworkHistoryPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setArtworkId($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setFileId($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setCreatedAt($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setModifiedFlag($arr[$keys[4]]);
		if (array_key_exists($keys[5], $arr)) $this->setUserId($arr[$keys[5]]);
		if (array_key_exists($keys[6], $arr)) $this->setStatus($arr[$keys[6]]);
		if (array_key_exists($keys[7], $arr)) $this->setComment($arr[$keys[7]]);
	}

	
	public function buildCriteria()
	{
		$criteria = new Criteria(ReaktorArtworkHistoryPeer::DATABASE_NAME);

		if ($this->isColumnModified(ReaktorArtworkHistoryPeer::ID)) $criteria->add(ReaktorArtworkHistoryPeer::ID, $this->id);
		if ($this->isColumnModified(ReaktorArtworkHistoryPeer::ARTWORK_ID)) $criteria->add(ReaktorArtworkHistoryPeer::ARTWORK_ID, $this->artwork_id);
		if ($this->isColumnModified(ReaktorArtworkHistoryPeer::FILE_ID)) $criteria->add(ReaktorArtworkHistoryPeer::FILE_ID, $this->file_id);
		if ($this->isColumnModified(ReaktorArtworkHistoryPeer::CREATED_AT)) $criteria->add(ReaktorArtworkHistoryPeer::CREATED_AT, $this->created_at);
		if ($this->isColumnModified(ReaktorArtworkHistoryPeer::MODIFIED_FLAG)) $criteria->add(ReaktorArtworkHistoryPeer::MODIFIED_FLAG, $this->modified_flag);
		if ($this->isColumnModified(ReaktorArtworkHistoryPeer::USER_ID)) $criteria->add(ReaktorArtworkHistoryPeer::USER_ID, $this->user_id);
		if ($this->isColumnModified(ReaktorArtworkHistoryPeer::STATUS)) $criteria->add(ReaktorArtworkHistoryPeer::STATUS, $this->status);
		if ($this->isColumnModified(ReaktorArtworkHistoryPeer::COMMENT)) $criteria->add(ReaktorArtworkHistoryPeer::COMMENT, $this->comment);

		return $criteria;
	}

	
	public function buildPkeyCriteria()
	{
		$criteria = new Criteria(ReaktorArtworkHistoryPeer::DATABASE_NAME);

		$criteria->add(ReaktorArtworkHistoryPeer::ID, $this->id);

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

		$copyObj->setArtworkId($this->artwork_id);

		$copyObj->setFileId($this->file_id);

		$copyObj->setCreatedAt($this->created_at);

		$copyObj->setModifiedFlag($this->modified_flag);

		$copyObj->setUserId($this->user_id);

		$copyObj->setStatus($this->status);

		$copyObj->setComment($this->comment);


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
			self::$peer = new ReaktorArtworkHistoryPeer();
		}
		return self::$peer;
	}

	
	public function setReaktorArtworkRelatedByArtworkId($v)
	{


		if ($v === null) {
			$this->setArtworkId(NULL);
		} else {
			$this->setArtworkId($v->getId());
		}


		$this->aReaktorArtworkRelatedByArtworkId = $v;
	}


	
	public function getReaktorArtworkRelatedByArtworkId($con = null)
	{
		if ($this->aReaktorArtworkRelatedByArtworkId === null && ($this->artwork_id !== null)) {
						include_once 'lib/model/om/BaseReaktorArtworkPeer.php';

			$this->aReaktorArtworkRelatedByArtworkId = ReaktorArtworkPeer::retrieveByPK($this->artwork_id, $con);

			
		}
		return $this->aReaktorArtworkRelatedByArtworkId;
	}

	
	public function setReaktorArtworkRelatedByFileId($v)
	{


		if ($v === null) {
			$this->setFileId(NULL);
		} else {
			$this->setFileId($v->getId());
		}


		$this->aReaktorArtworkRelatedByFileId = $v;
	}


	
	public function getReaktorArtworkRelatedByFileId($con = null)
	{
		if ($this->aReaktorArtworkRelatedByFileId === null && ($this->file_id !== null)) {
						include_once 'lib/model/om/BaseReaktorArtworkPeer.php';

			$this->aReaktorArtworkRelatedByFileId = ReaktorArtworkPeer::retrieveByPK($this->file_id, $con);

			
		}
		return $this->aReaktorArtworkRelatedByFileId;
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

	
	public function setArtworkStatus($v)
	{


		if ($v === null) {
			$this->setStatus(NULL);
		} else {
			$this->setStatus($v->getId());
		}


		$this->aArtworkStatus = $v;
	}


	
	public function getArtworkStatus($con = null)
	{
		if ($this->aArtworkStatus === null && ($this->status !== null)) {
						include_once 'lib/model/om/BaseArtworkStatusPeer.php';

			$this->aArtworkStatus = ArtworkStatusPeer::retrieveByPK($this->status, $con);

			
		}
		return $this->aArtworkStatus;
	}


  public function __call($method, $arguments)
  {
    if (!$callable = sfMixer::getCallable('BaseReaktorArtworkHistory:'.$method))
    {
      throw new sfException(sprintf('Call to undefined method BaseReaktorArtworkHistory::%s', $method));
    }

    array_unshift($arguments, $this);

    return call_user_func_array($callable, $arguments);
  }


} 