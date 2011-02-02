<?php


abstract class BaseRelatedArtwork extends BaseObject  implements Persistent {


	
	protected static $peer;


	
	protected $id;


	
	protected $first_artwork;


	
	protected $second_artwork;


	
	protected $created_at;


	
	protected $created_by;


	
	protected $order_by = 0;

	
	protected $aReaktorArtworkRelatedByFirstArtwork;

	
	protected $aReaktorArtworkRelatedBySecondArtwork;

	
	protected $asfGuardUser;

	
	protected $alreadyInSave = false;

	
	protected $alreadyInValidation = false;

	
	public function getId()
	{

		return $this->id;
	}

	
	public function getFirstArtwork()
	{

		return $this->first_artwork;
	}

	
	public function getSecondArtwork()
	{

		return $this->second_artwork;
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

	
	public function getCreatedBy()
	{

		return $this->created_by;
	}

	
	public function getOrderBy()
	{

		return $this->order_by;
	}

	
	public function setId($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->id !== $v) {
			$this->id = $v;
			$this->modifiedColumns[] = RelatedArtworkPeer::ID;
		}

	} 
	
	public function setFirstArtwork($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->first_artwork !== $v) {
			$this->first_artwork = $v;
			$this->modifiedColumns[] = RelatedArtworkPeer::FIRST_ARTWORK;
		}

		if ($this->aReaktorArtworkRelatedByFirstArtwork !== null && $this->aReaktorArtworkRelatedByFirstArtwork->getId() !== $v) {
			$this->aReaktorArtworkRelatedByFirstArtwork = null;
		}

	} 
	
	public function setSecondArtwork($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->second_artwork !== $v) {
			$this->second_artwork = $v;
			$this->modifiedColumns[] = RelatedArtworkPeer::SECOND_ARTWORK;
		}

		if ($this->aReaktorArtworkRelatedBySecondArtwork !== null && $this->aReaktorArtworkRelatedBySecondArtwork->getId() !== $v) {
			$this->aReaktorArtworkRelatedBySecondArtwork = null;
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
			$this->modifiedColumns[] = RelatedArtworkPeer::CREATED_AT;
		}

	} 
	
	public function setCreatedBy($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->created_by !== $v) {
			$this->created_by = $v;
			$this->modifiedColumns[] = RelatedArtworkPeer::CREATED_BY;
		}

		if ($this->asfGuardUser !== null && $this->asfGuardUser->getId() !== $v) {
			$this->asfGuardUser = null;
		}

	} 
	
	public function setOrderBy($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->order_by !== $v || $v === 0) {
			$this->order_by = $v;
			$this->modifiedColumns[] = RelatedArtworkPeer::ORDER_BY;
		}

	} 
	
	public function hydrate(ResultSet $rs, $startcol = 1)
	{
		try {

			$this->id = $rs->getInt($startcol + 0);

			$this->first_artwork = $rs->getInt($startcol + 1);

			$this->second_artwork = $rs->getInt($startcol + 2);

			$this->created_at = $rs->getTimestamp($startcol + 3, null);

			$this->created_by = $rs->getInt($startcol + 4);

			$this->order_by = $rs->getInt($startcol + 5);

			$this->resetModified();

			$this->setNew(false);

						return $startcol + 6; 
		} catch (Exception $e) {
			throw new PropelException("Error populating RelatedArtwork object", $e);
		}
	}

	
	public function delete($con = null)
	{

    foreach (sfMixer::getCallables('BaseRelatedArtwork:delete:pre') as $callable)
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
			$con = Propel::getConnection(RelatedArtworkPeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			RelatedArtworkPeer::doDelete($this, $con);
			$this->setDeleted(true);
			$con->commit();
		} catch (PropelException $e) {
			$con->rollback();
			throw $e;
		}
	

    foreach (sfMixer::getCallables('BaseRelatedArtwork:delete:post') as $callable)
    {
      call_user_func($callable, $this, $con);
    }

  }
	
	public function save($con = null)
	{

    foreach (sfMixer::getCallables('BaseRelatedArtwork:save:pre') as $callable)
    {
      $affectedRows = call_user_func($callable, $this, $con);
      if (is_int($affectedRows))
      {
        return $affectedRows;
      }
    }


    if ($this->isNew() && !$this->isColumnModified(RelatedArtworkPeer::CREATED_AT))
    {
      $this->setCreatedAt(time());
    }

		if ($this->isDeleted()) {
			throw new PropelException("You cannot save an object that has been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(RelatedArtworkPeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			$affectedRows = $this->doSave($con);
			$con->commit();
    foreach (sfMixer::getCallables('BaseRelatedArtwork:save:post') as $callable)
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


												
			if ($this->aReaktorArtworkRelatedByFirstArtwork !== null) {
				if ($this->aReaktorArtworkRelatedByFirstArtwork->isModified()) {
					$affectedRows += $this->aReaktorArtworkRelatedByFirstArtwork->save($con);
				}
				$this->setReaktorArtworkRelatedByFirstArtwork($this->aReaktorArtworkRelatedByFirstArtwork);
			}

			if ($this->aReaktorArtworkRelatedBySecondArtwork !== null) {
				if ($this->aReaktorArtworkRelatedBySecondArtwork->isModified()) {
					$affectedRows += $this->aReaktorArtworkRelatedBySecondArtwork->save($con);
				}
				$this->setReaktorArtworkRelatedBySecondArtwork($this->aReaktorArtworkRelatedBySecondArtwork);
			}

			if ($this->asfGuardUser !== null) {
				if ($this->asfGuardUser->isModified()) {
					$affectedRows += $this->asfGuardUser->save($con);
				}
				$this->setsfGuardUser($this->asfGuardUser);
			}


						if ($this->isModified()) {
				if ($this->isNew()) {
					$pk = RelatedArtworkPeer::doInsert($this, $con);
					$affectedRows += 1; 										 										 
					$this->setId($pk);  
					$this->setNew(false);
				} else {
					$affectedRows += RelatedArtworkPeer::doUpdate($this, $con);
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


												
			if ($this->aReaktorArtworkRelatedByFirstArtwork !== null) {
				if (!$this->aReaktorArtworkRelatedByFirstArtwork->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aReaktorArtworkRelatedByFirstArtwork->getValidationFailures());
				}
			}

			if ($this->aReaktorArtworkRelatedBySecondArtwork !== null) {
				if (!$this->aReaktorArtworkRelatedBySecondArtwork->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aReaktorArtworkRelatedBySecondArtwork->getValidationFailures());
				}
			}

			if ($this->asfGuardUser !== null) {
				if (!$this->asfGuardUser->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->asfGuardUser->getValidationFailures());
				}
			}


			if (($retval = RelatedArtworkPeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}



			$this->alreadyInValidation = false;
		}

		return (!empty($failureMap) ? $failureMap : true);
	}

	
	public function getByName($name, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = RelatedArtworkPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->getByPosition($pos);
	}

	
	public function getByPosition($pos)
	{
		switch($pos) {
			case 0:
				return $this->getId();
				break;
			case 1:
				return $this->getFirstArtwork();
				break;
			case 2:
				return $this->getSecondArtwork();
				break;
			case 3:
				return $this->getCreatedAt();
				break;
			case 4:
				return $this->getCreatedBy();
				break;
			case 5:
				return $this->getOrderBy();
				break;
			default:
				return null;
				break;
		} 	}

	
	public function toArray($keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = RelatedArtworkPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getId(),
			$keys[1] => $this->getFirstArtwork(),
			$keys[2] => $this->getSecondArtwork(),
			$keys[3] => $this->getCreatedAt(),
			$keys[4] => $this->getCreatedBy(),
			$keys[5] => $this->getOrderBy(),
		);
		return $result;
	}

	
	public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = RelatedArtworkPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->setByPosition($pos, $value);
	}

	
	public function setByPosition($pos, $value)
	{
		switch($pos) {
			case 0:
				$this->setId($value);
				break;
			case 1:
				$this->setFirstArtwork($value);
				break;
			case 2:
				$this->setSecondArtwork($value);
				break;
			case 3:
				$this->setCreatedAt($value);
				break;
			case 4:
				$this->setCreatedBy($value);
				break;
			case 5:
				$this->setOrderBy($value);
				break;
		} 	}

	
	public function fromArray($arr, $keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = RelatedArtworkPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setFirstArtwork($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setSecondArtwork($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setCreatedAt($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setCreatedBy($arr[$keys[4]]);
		if (array_key_exists($keys[5], $arr)) $this->setOrderBy($arr[$keys[5]]);
	}

	
	public function buildCriteria()
	{
		$criteria = new Criteria(RelatedArtworkPeer::DATABASE_NAME);

		if ($this->isColumnModified(RelatedArtworkPeer::ID)) $criteria->add(RelatedArtworkPeer::ID, $this->id);
		if ($this->isColumnModified(RelatedArtworkPeer::FIRST_ARTWORK)) $criteria->add(RelatedArtworkPeer::FIRST_ARTWORK, $this->first_artwork);
		if ($this->isColumnModified(RelatedArtworkPeer::SECOND_ARTWORK)) $criteria->add(RelatedArtworkPeer::SECOND_ARTWORK, $this->second_artwork);
		if ($this->isColumnModified(RelatedArtworkPeer::CREATED_AT)) $criteria->add(RelatedArtworkPeer::CREATED_AT, $this->created_at);
		if ($this->isColumnModified(RelatedArtworkPeer::CREATED_BY)) $criteria->add(RelatedArtworkPeer::CREATED_BY, $this->created_by);
		if ($this->isColumnModified(RelatedArtworkPeer::ORDER_BY)) $criteria->add(RelatedArtworkPeer::ORDER_BY, $this->order_by);

		return $criteria;
	}

	
	public function buildPkeyCriteria()
	{
		$criteria = new Criteria(RelatedArtworkPeer::DATABASE_NAME);

		$criteria->add(RelatedArtworkPeer::ID, $this->id);

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

		$copyObj->setFirstArtwork($this->first_artwork);

		$copyObj->setSecondArtwork($this->second_artwork);

		$copyObj->setCreatedAt($this->created_at);

		$copyObj->setCreatedBy($this->created_by);

		$copyObj->setOrderBy($this->order_by);


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
			self::$peer = new RelatedArtworkPeer();
		}
		return self::$peer;
	}

	
	public function setReaktorArtworkRelatedByFirstArtwork($v)
	{


		if ($v === null) {
			$this->setFirstArtwork(NULL);
		} else {
			$this->setFirstArtwork($v->getId());
		}


		$this->aReaktorArtworkRelatedByFirstArtwork = $v;
	}


	
	public function getReaktorArtworkRelatedByFirstArtwork($con = null)
	{
		if ($this->aReaktorArtworkRelatedByFirstArtwork === null && ($this->first_artwork !== null)) {
						include_once 'lib/model/om/BaseReaktorArtworkPeer.php';

			$this->aReaktorArtworkRelatedByFirstArtwork = ReaktorArtworkPeer::retrieveByPK($this->first_artwork, $con);

			
		}
		return $this->aReaktorArtworkRelatedByFirstArtwork;
	}

	
	public function setReaktorArtworkRelatedBySecondArtwork($v)
	{


		if ($v === null) {
			$this->setSecondArtwork(NULL);
		} else {
			$this->setSecondArtwork($v->getId());
		}


		$this->aReaktorArtworkRelatedBySecondArtwork = $v;
	}


	
	public function getReaktorArtworkRelatedBySecondArtwork($con = null)
	{
		if ($this->aReaktorArtworkRelatedBySecondArtwork === null && ($this->second_artwork !== null)) {
						include_once 'lib/model/om/BaseReaktorArtworkPeer.php';

			$this->aReaktorArtworkRelatedBySecondArtwork = ReaktorArtworkPeer::retrieveByPK($this->second_artwork, $con);

			
		}
		return $this->aReaktorArtworkRelatedBySecondArtwork;
	}

	
	public function setsfGuardUser($v)
	{


		if ($v === null) {
			$this->setCreatedBy(NULL);
		} else {
			$this->setCreatedBy($v->getId());
		}


		$this->asfGuardUser = $v;
	}


	
	public function getsfGuardUser($con = null)
	{
		if ($this->asfGuardUser === null && ($this->created_by !== null)) {
						include_once 'plugins/sfGuardPlugin/lib/model/om/BasesfGuardUserPeer.php';

			$this->asfGuardUser = sfGuardUserPeer::retrieveByPK($this->created_by, $con);

			
		}
		return $this->asfGuardUser;
	}


  public function __call($method, $arguments)
  {
    if (!$callable = sfMixer::getCallable('BaseRelatedArtwork:'.$method))
    {
      throw new sfException(sprintf('Call to undefined method BaseRelatedArtwork::%s', $method));
    }

    array_unshift($arguments, $this);

    return call_user_func_array($callable, $arguments);
  }


} 