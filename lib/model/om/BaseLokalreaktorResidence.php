<?php


abstract class BaseLokalreaktorResidence extends BaseObject  implements Persistent {


	
	protected static $peer;


	
	protected $id;


	
	protected $created_at;


	
	protected $subreaktor_id;


	
	protected $residence_id;

	
	protected $aSubreaktor;

	
	protected $aResidence;

	
	protected $alreadyInSave = false;

	
	protected $alreadyInValidation = false;

	
	public function getId()
	{

		return $this->id;
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

	
	public function getSubreaktorId()
	{

		return $this->subreaktor_id;
	}

	
	public function getResidenceId()
	{

		return $this->residence_id;
	}

	
	public function setId($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->id !== $v) {
			$this->id = $v;
			$this->modifiedColumns[] = LokalreaktorResidencePeer::ID;
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
			$this->modifiedColumns[] = LokalreaktorResidencePeer::CREATED_AT;
		}

	} 
	
	public function setSubreaktorId($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->subreaktor_id !== $v) {
			$this->subreaktor_id = $v;
			$this->modifiedColumns[] = LokalreaktorResidencePeer::SUBREAKTOR_ID;
		}

		if ($this->aSubreaktor !== null && $this->aSubreaktor->getId() !== $v) {
			$this->aSubreaktor = null;
		}

	} 
	
	public function setResidenceId($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->residence_id !== $v) {
			$this->residence_id = $v;
			$this->modifiedColumns[] = LokalreaktorResidencePeer::RESIDENCE_ID;
		}

		if ($this->aResidence !== null && $this->aResidence->getId() !== $v) {
			$this->aResidence = null;
		}

	} 
	
	public function hydrate(ResultSet $rs, $startcol = 1)
	{
		try {

			$this->id = $rs->getInt($startcol + 0);

			$this->created_at = $rs->getTimestamp($startcol + 1, null);

			$this->subreaktor_id = $rs->getInt($startcol + 2);

			$this->residence_id = $rs->getInt($startcol + 3);

			$this->resetModified();

			$this->setNew(false);

						return $startcol + 4; 
		} catch (Exception $e) {
			throw new PropelException("Error populating LokalreaktorResidence object", $e);
		}
	}

	
	public function delete($con = null)
	{

    foreach (sfMixer::getCallables('BaseLokalreaktorResidence:delete:pre') as $callable)
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
			$con = Propel::getConnection(LokalreaktorResidencePeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			LokalreaktorResidencePeer::doDelete($this, $con);
			$this->setDeleted(true);
			$con->commit();
		} catch (PropelException $e) {
			$con->rollback();
			throw $e;
		}
	

    foreach (sfMixer::getCallables('BaseLokalreaktorResidence:delete:post') as $callable)
    {
      call_user_func($callable, $this, $con);
    }

  }
	
	public function save($con = null)
	{

    foreach (sfMixer::getCallables('BaseLokalreaktorResidence:save:pre') as $callable)
    {
      $affectedRows = call_user_func($callable, $this, $con);
      if (is_int($affectedRows))
      {
        return $affectedRows;
      }
    }


    if ($this->isNew() && !$this->isColumnModified(LokalreaktorResidencePeer::CREATED_AT))
    {
      $this->setCreatedAt(time());
    }

		if ($this->isDeleted()) {
			throw new PropelException("You cannot save an object that has been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(LokalreaktorResidencePeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			$affectedRows = $this->doSave($con);
			$con->commit();
    foreach (sfMixer::getCallables('BaseLokalreaktorResidence:save:post') as $callable)
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


												
			if ($this->aSubreaktor !== null) {
				if ($this->aSubreaktor->isModified() || $this->aSubreaktor->getCurrentSubreaktorI18n()->isModified()) {
					$affectedRows += $this->aSubreaktor->save($con);
				}
				$this->setSubreaktor($this->aSubreaktor);
			}

			if ($this->aResidence !== null) {
				if ($this->aResidence->isModified()) {
					$affectedRows += $this->aResidence->save($con);
				}
				$this->setResidence($this->aResidence);
			}


						if ($this->isModified()) {
				if ($this->isNew()) {
					$pk = LokalreaktorResidencePeer::doInsert($this, $con);
					$affectedRows += 1; 										 										 
					$this->setId($pk);  
					$this->setNew(false);
				} else {
					$affectedRows += LokalreaktorResidencePeer::doUpdate($this, $con);
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


												
			if ($this->aSubreaktor !== null) {
				if (!$this->aSubreaktor->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aSubreaktor->getValidationFailures());
				}
			}

			if ($this->aResidence !== null) {
				if (!$this->aResidence->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aResidence->getValidationFailures());
				}
			}


			if (($retval = LokalreaktorResidencePeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}



			$this->alreadyInValidation = false;
		}

		return (!empty($failureMap) ? $failureMap : true);
	}

	
	public function getByName($name, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = LokalreaktorResidencePeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->getByPosition($pos);
	}

	
	public function getByPosition($pos)
	{
		switch($pos) {
			case 0:
				return $this->getId();
				break;
			case 1:
				return $this->getCreatedAt();
				break;
			case 2:
				return $this->getSubreaktorId();
				break;
			case 3:
				return $this->getResidenceId();
				break;
			default:
				return null;
				break;
		} 	}

	
	public function toArray($keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = LokalreaktorResidencePeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getId(),
			$keys[1] => $this->getCreatedAt(),
			$keys[2] => $this->getSubreaktorId(),
			$keys[3] => $this->getResidenceId(),
		);
		return $result;
	}

	
	public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = LokalreaktorResidencePeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->setByPosition($pos, $value);
	}

	
	public function setByPosition($pos, $value)
	{
		switch($pos) {
			case 0:
				$this->setId($value);
				break;
			case 1:
				$this->setCreatedAt($value);
				break;
			case 2:
				$this->setSubreaktorId($value);
				break;
			case 3:
				$this->setResidenceId($value);
				break;
		} 	}

	
	public function fromArray($arr, $keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = LokalreaktorResidencePeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setCreatedAt($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setSubreaktorId($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setResidenceId($arr[$keys[3]]);
	}

	
	public function buildCriteria()
	{
		$criteria = new Criteria(LokalreaktorResidencePeer::DATABASE_NAME);

		if ($this->isColumnModified(LokalreaktorResidencePeer::ID)) $criteria->add(LokalreaktorResidencePeer::ID, $this->id);
		if ($this->isColumnModified(LokalreaktorResidencePeer::CREATED_AT)) $criteria->add(LokalreaktorResidencePeer::CREATED_AT, $this->created_at);
		if ($this->isColumnModified(LokalreaktorResidencePeer::SUBREAKTOR_ID)) $criteria->add(LokalreaktorResidencePeer::SUBREAKTOR_ID, $this->subreaktor_id);
		if ($this->isColumnModified(LokalreaktorResidencePeer::RESIDENCE_ID)) $criteria->add(LokalreaktorResidencePeer::RESIDENCE_ID, $this->residence_id);

		return $criteria;
	}

	
	public function buildPkeyCriteria()
	{
		$criteria = new Criteria(LokalreaktorResidencePeer::DATABASE_NAME);

		$criteria->add(LokalreaktorResidencePeer::ID, $this->id);

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

		$copyObj->setCreatedAt($this->created_at);

		$copyObj->setSubreaktorId($this->subreaktor_id);

		$copyObj->setResidenceId($this->residence_id);


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
			self::$peer = new LokalreaktorResidencePeer();
		}
		return self::$peer;
	}

	
	public function setSubreaktor($v)
	{


		if ($v === null) {
			$this->setSubreaktorId(NULL);
		} else {
			$this->setSubreaktorId($v->getId());
		}


		$this->aSubreaktor = $v;
	}


	
	public function getSubreaktor($con = null)
	{
		if ($this->aSubreaktor === null && ($this->subreaktor_id !== null)) {
						include_once 'lib/model/om/BaseSubreaktorPeer.php';

			$this->aSubreaktor = SubreaktorPeer::retrieveByPK($this->subreaktor_id, $con);

			
		}
		return $this->aSubreaktor;
	}

	
	public function setResidence($v)
	{


		if ($v === null) {
			$this->setResidenceId(NULL);
		} else {
			$this->setResidenceId($v->getId());
		}


		$this->aResidence = $v;
	}


	
	public function getResidence($con = null)
	{
		if ($this->aResidence === null && ($this->residence_id !== null)) {
						include_once 'lib/model/om/BaseResidencePeer.php';

			$this->aResidence = ResidencePeer::retrieveByPK($this->residence_id, $con);

			
		}
		return $this->aResidence;
	}


  public function __call($method, $arguments)
  {
    if (!$callable = sfMixer::getCallable('BaseLokalreaktorResidence:'.$method))
    {
      throw new sfException(sprintf('Call to undefined method BaseLokalreaktorResidence::%s', $method));
    }

    array_unshift($arguments, $this);

    return call_user_func_array($callable, $arguments);
  }


} 