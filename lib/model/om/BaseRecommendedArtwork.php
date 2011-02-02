<?php


abstract class BaseRecommendedArtwork extends BaseObject  implements Persistent {


	
	protected static $peer;


	
	protected $id;


	
	protected $artwork;


	
	protected $subreaktor;


	
	protected $localsubreaktor;


	
	protected $updated_by;


	
	protected $updated_at;

	
	protected $aReaktorArtwork;

	
	protected $aSubreaktorRelatedBySubreaktor;

	
	protected $aSubreaktorRelatedByLocalsubreaktor;

	
	protected $asfGuardUser;

	
	protected $alreadyInSave = false;

	
	protected $alreadyInValidation = false;

	
	public function getId()
	{

		return $this->id;
	}

	
	public function getArtwork()
	{

		return $this->artwork;
	}

	
	public function getSubreaktor()
	{

		return $this->subreaktor;
	}

	
	public function getLocalsubreaktor()
	{

		return $this->localsubreaktor;
	}

	
	public function getUpdatedBy()
	{

		return $this->updated_by;
	}

	
	public function getUpdatedAt($format = 'Y-m-d H:i:s')
	{

		if ($this->updated_at === null || $this->updated_at === '') {
			return null;
		} elseif (!is_int($this->updated_at)) {
						$ts = strtotime($this->updated_at);
			if ($ts === -1 || $ts === false) { 				throw new PropelException("Unable to parse value of [updated_at] as date/time value: " . var_export($this->updated_at, true));
			}
		} else {
			$ts = $this->updated_at;
		}
		if ($format === null) {
			return $ts;
		} elseif (strpos($format, '%') !== false) {
			return strftime($format, $ts);
		} else {
			return date($format, $ts);
		}
	}

	
	public function setId($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->id !== $v) {
			$this->id = $v;
			$this->modifiedColumns[] = RecommendedArtworkPeer::ID;
		}

	} 
	
	public function setArtwork($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->artwork !== $v) {
			$this->artwork = $v;
			$this->modifiedColumns[] = RecommendedArtworkPeer::ARTWORK;
		}

		if ($this->aReaktorArtwork !== null && $this->aReaktorArtwork->getId() !== $v) {
			$this->aReaktorArtwork = null;
		}

	} 
	
	public function setSubreaktor($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->subreaktor !== $v) {
			$this->subreaktor = $v;
			$this->modifiedColumns[] = RecommendedArtworkPeer::SUBREAKTOR;
		}

		if ($this->aSubreaktorRelatedBySubreaktor !== null && $this->aSubreaktorRelatedBySubreaktor->getId() !== $v) {
			$this->aSubreaktorRelatedBySubreaktor = null;
		}

	} 
	
	public function setLocalsubreaktor($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->localsubreaktor !== $v) {
			$this->localsubreaktor = $v;
			$this->modifiedColumns[] = RecommendedArtworkPeer::LOCALSUBREAKTOR;
		}

		if ($this->aSubreaktorRelatedByLocalsubreaktor !== null && $this->aSubreaktorRelatedByLocalsubreaktor->getId() !== $v) {
			$this->aSubreaktorRelatedByLocalsubreaktor = null;
		}

	} 
	
	public function setUpdatedBy($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->updated_by !== $v) {
			$this->updated_by = $v;
			$this->modifiedColumns[] = RecommendedArtworkPeer::UPDATED_BY;
		}

		if ($this->asfGuardUser !== null && $this->asfGuardUser->getId() !== $v) {
			$this->asfGuardUser = null;
		}

	} 
	
	public function setUpdatedAt($v)
	{

		if ($v !== null && !is_int($v)) {
			$ts = strtotime($v);
			if ($ts === -1 || $ts === false) { 				throw new PropelException("Unable to parse date/time value for [updated_at] from input: " . var_export($v, true));
			}
		} else {
			$ts = $v;
		}
		if ($this->updated_at !== $ts) {
			$this->updated_at = $ts;
			$this->modifiedColumns[] = RecommendedArtworkPeer::UPDATED_AT;
		}

	} 
	
	public function hydrate(ResultSet $rs, $startcol = 1)
	{
		try {

			$this->id = $rs->getInt($startcol + 0);

			$this->artwork = $rs->getInt($startcol + 1);

			$this->subreaktor = $rs->getInt($startcol + 2);

			$this->localsubreaktor = $rs->getInt($startcol + 3);

			$this->updated_by = $rs->getInt($startcol + 4);

			$this->updated_at = $rs->getTimestamp($startcol + 5, null);

			$this->resetModified();

			$this->setNew(false);

						return $startcol + 6; 
		} catch (Exception $e) {
			throw new PropelException("Error populating RecommendedArtwork object", $e);
		}
	}

	
	public function delete($con = null)
	{

    foreach (sfMixer::getCallables('BaseRecommendedArtwork:delete:pre') as $callable)
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
			$con = Propel::getConnection(RecommendedArtworkPeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			RecommendedArtworkPeer::doDelete($this, $con);
			$this->setDeleted(true);
			$con->commit();
		} catch (PropelException $e) {
			$con->rollback();
			throw $e;
		}
	

    foreach (sfMixer::getCallables('BaseRecommendedArtwork:delete:post') as $callable)
    {
      call_user_func($callable, $this, $con);
    }

  }
	
	public function save($con = null)
	{

    foreach (sfMixer::getCallables('BaseRecommendedArtwork:save:pre') as $callable)
    {
      $affectedRows = call_user_func($callable, $this, $con);
      if (is_int($affectedRows))
      {
        return $affectedRows;
      }
    }


    if ($this->isModified() && !$this->isColumnModified(RecommendedArtworkPeer::UPDATED_AT))
    {
      $this->setUpdatedAt(time());
    }

		if ($this->isDeleted()) {
			throw new PropelException("You cannot save an object that has been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(RecommendedArtworkPeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			$affectedRows = $this->doSave($con);
			$con->commit();
    foreach (sfMixer::getCallables('BaseRecommendedArtwork:save:post') as $callable)
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


												
			if ($this->aReaktorArtwork !== null) {
				if ($this->aReaktorArtwork->isModified()) {
					$affectedRows += $this->aReaktorArtwork->save($con);
				}
				$this->setReaktorArtwork($this->aReaktorArtwork);
			}

			if ($this->aSubreaktorRelatedBySubreaktor !== null) {
				if ($this->aSubreaktorRelatedBySubreaktor->isModified() || $this->aSubreaktorRelatedBySubreaktor->getCurrentSubreaktorI18n()->isModified()) {
					$affectedRows += $this->aSubreaktorRelatedBySubreaktor->save($con);
				}
				$this->setSubreaktorRelatedBySubreaktor($this->aSubreaktorRelatedBySubreaktor);
			}

			if ($this->aSubreaktorRelatedByLocalsubreaktor !== null) {
				if ($this->aSubreaktorRelatedByLocalsubreaktor->isModified() || $this->aSubreaktorRelatedByLocalsubreaktor->getCurrentSubreaktorI18n()->isModified()) {
					$affectedRows += $this->aSubreaktorRelatedByLocalsubreaktor->save($con);
				}
				$this->setSubreaktorRelatedByLocalsubreaktor($this->aSubreaktorRelatedByLocalsubreaktor);
			}

			if ($this->asfGuardUser !== null) {
				if ($this->asfGuardUser->isModified()) {
					$affectedRows += $this->asfGuardUser->save($con);
				}
				$this->setsfGuardUser($this->asfGuardUser);
			}


						if ($this->isModified()) {
				if ($this->isNew()) {
					$pk = RecommendedArtworkPeer::doInsert($this, $con);
					$affectedRows += 1; 										 										 
					$this->setId($pk);  
					$this->setNew(false);
				} else {
					$affectedRows += RecommendedArtworkPeer::doUpdate($this, $con);
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


												
			if ($this->aReaktorArtwork !== null) {
				if (!$this->aReaktorArtwork->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aReaktorArtwork->getValidationFailures());
				}
			}

			if ($this->aSubreaktorRelatedBySubreaktor !== null) {
				if (!$this->aSubreaktorRelatedBySubreaktor->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aSubreaktorRelatedBySubreaktor->getValidationFailures());
				}
			}

			if ($this->aSubreaktorRelatedByLocalsubreaktor !== null) {
				if (!$this->aSubreaktorRelatedByLocalsubreaktor->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aSubreaktorRelatedByLocalsubreaktor->getValidationFailures());
				}
			}

			if ($this->asfGuardUser !== null) {
				if (!$this->asfGuardUser->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->asfGuardUser->getValidationFailures());
				}
			}


			if (($retval = RecommendedArtworkPeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}



			$this->alreadyInValidation = false;
		}

		return (!empty($failureMap) ? $failureMap : true);
	}

	
	public function getByName($name, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = RecommendedArtworkPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->getByPosition($pos);
	}

	
	public function getByPosition($pos)
	{
		switch($pos) {
			case 0:
				return $this->getId();
				break;
			case 1:
				return $this->getArtwork();
				break;
			case 2:
				return $this->getSubreaktor();
				break;
			case 3:
				return $this->getLocalsubreaktor();
				break;
			case 4:
				return $this->getUpdatedBy();
				break;
			case 5:
				return $this->getUpdatedAt();
				break;
			default:
				return null;
				break;
		} 	}

	
	public function toArray($keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = RecommendedArtworkPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getId(),
			$keys[1] => $this->getArtwork(),
			$keys[2] => $this->getSubreaktor(),
			$keys[3] => $this->getLocalsubreaktor(),
			$keys[4] => $this->getUpdatedBy(),
			$keys[5] => $this->getUpdatedAt(),
		);
		return $result;
	}

	
	public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = RecommendedArtworkPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->setByPosition($pos, $value);
	}

	
	public function setByPosition($pos, $value)
	{
		switch($pos) {
			case 0:
				$this->setId($value);
				break;
			case 1:
				$this->setArtwork($value);
				break;
			case 2:
				$this->setSubreaktor($value);
				break;
			case 3:
				$this->setLocalsubreaktor($value);
				break;
			case 4:
				$this->setUpdatedBy($value);
				break;
			case 5:
				$this->setUpdatedAt($value);
				break;
		} 	}

	
	public function fromArray($arr, $keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = RecommendedArtworkPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setArtwork($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setSubreaktor($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setLocalsubreaktor($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setUpdatedBy($arr[$keys[4]]);
		if (array_key_exists($keys[5], $arr)) $this->setUpdatedAt($arr[$keys[5]]);
	}

	
	public function buildCriteria()
	{
		$criteria = new Criteria(RecommendedArtworkPeer::DATABASE_NAME);

		if ($this->isColumnModified(RecommendedArtworkPeer::ID)) $criteria->add(RecommendedArtworkPeer::ID, $this->id);
		if ($this->isColumnModified(RecommendedArtworkPeer::ARTWORK)) $criteria->add(RecommendedArtworkPeer::ARTWORK, $this->artwork);
		if ($this->isColumnModified(RecommendedArtworkPeer::SUBREAKTOR)) $criteria->add(RecommendedArtworkPeer::SUBREAKTOR, $this->subreaktor);
		if ($this->isColumnModified(RecommendedArtworkPeer::LOCALSUBREAKTOR)) $criteria->add(RecommendedArtworkPeer::LOCALSUBREAKTOR, $this->localsubreaktor);
		if ($this->isColumnModified(RecommendedArtworkPeer::UPDATED_BY)) $criteria->add(RecommendedArtworkPeer::UPDATED_BY, $this->updated_by);
		if ($this->isColumnModified(RecommendedArtworkPeer::UPDATED_AT)) $criteria->add(RecommendedArtworkPeer::UPDATED_AT, $this->updated_at);

		return $criteria;
	}

	
	public function buildPkeyCriteria()
	{
		$criteria = new Criteria(RecommendedArtworkPeer::DATABASE_NAME);

		$criteria->add(RecommendedArtworkPeer::ID, $this->id);

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

		$copyObj->setArtwork($this->artwork);

		$copyObj->setSubreaktor($this->subreaktor);

		$copyObj->setLocalsubreaktor($this->localsubreaktor);

		$copyObj->setUpdatedBy($this->updated_by);

		$copyObj->setUpdatedAt($this->updated_at);


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
			self::$peer = new RecommendedArtworkPeer();
		}
		return self::$peer;
	}

	
	public function setReaktorArtwork($v)
	{


		if ($v === null) {
			$this->setArtwork(NULL);
		} else {
			$this->setArtwork($v->getId());
		}


		$this->aReaktorArtwork = $v;
	}


	
	public function getReaktorArtwork($con = null)
	{
		if ($this->aReaktorArtwork === null && ($this->artwork !== null)) {
						include_once 'lib/model/om/BaseReaktorArtworkPeer.php';

			$this->aReaktorArtwork = ReaktorArtworkPeer::retrieveByPK($this->artwork, $con);

			
		}
		return $this->aReaktorArtwork;
	}

	
	public function setSubreaktorRelatedBySubreaktor($v)
	{


		if ($v === null) {
			$this->setSubreaktor(NULL);
		} else {
			$this->setSubreaktor($v->getId());
		}


		$this->aSubreaktorRelatedBySubreaktor = $v;
	}


	
	public function getSubreaktorRelatedBySubreaktor($con = null)
	{
		if ($this->aSubreaktorRelatedBySubreaktor === null && ($this->subreaktor !== null)) {
						include_once 'lib/model/om/BaseSubreaktorPeer.php';

			$this->aSubreaktorRelatedBySubreaktor = SubreaktorPeer::retrieveByPK($this->subreaktor, $con);

			
		}
		return $this->aSubreaktorRelatedBySubreaktor;
	}

	
	public function setSubreaktorRelatedByLocalsubreaktor($v)
	{


		if ($v === null) {
			$this->setLocalsubreaktor(NULL);
		} else {
			$this->setLocalsubreaktor($v->getId());
		}


		$this->aSubreaktorRelatedByLocalsubreaktor = $v;
	}


	
	public function getSubreaktorRelatedByLocalsubreaktor($con = null)
	{
		if ($this->aSubreaktorRelatedByLocalsubreaktor === null && ($this->localsubreaktor !== null)) {
						include_once 'lib/model/om/BaseSubreaktorPeer.php';

			$this->aSubreaktorRelatedByLocalsubreaktor = SubreaktorPeer::retrieveByPK($this->localsubreaktor, $con);

			
		}
		return $this->aSubreaktorRelatedByLocalsubreaktor;
	}

	
	public function setsfGuardUser($v)
	{


		if ($v === null) {
			$this->setUpdatedBy(NULL);
		} else {
			$this->setUpdatedBy($v->getId());
		}


		$this->asfGuardUser = $v;
	}


	
	public function getsfGuardUser($con = null)
	{
		if ($this->asfGuardUser === null && ($this->updated_by !== null)) {
						include_once 'plugins/sfGuardPlugin/lib/model/om/BasesfGuardUserPeer.php';

			$this->asfGuardUser = sfGuardUserPeer::retrieveByPK($this->updated_by, $con);

			
		}
		return $this->asfGuardUser;
	}


  public function __call($method, $arguments)
  {
    if (!$callable = sfMixer::getCallable('BaseRecommendedArtwork:'.$method))
    {
      throw new sfException(sprintf('Call to undefined method BaseRecommendedArtwork::%s', $method));
    }

    array_unshift($arguments, $this);

    return call_user_func_array($callable, $arguments);
  }


} 