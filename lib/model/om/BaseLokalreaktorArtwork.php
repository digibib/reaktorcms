<?php


abstract class BaseLokalreaktorArtwork extends BaseObject  implements Persistent {


	
	protected static $peer;


	
	protected $id;


	
	protected $subreaktor_id;


	
	protected $artwork_id;

	
	protected $aSubreaktor;

	
	protected $aReaktorArtwork;

	
	protected $alreadyInSave = false;

	
	protected $alreadyInValidation = false;

	
	public function getId()
	{

		return $this->id;
	}

	
	public function getSubreaktorId()
	{

		return $this->subreaktor_id;
	}

	
	public function getArtworkId()
	{

		return $this->artwork_id;
	}

	
	public function setId($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->id !== $v) {
			$this->id = $v;
			$this->modifiedColumns[] = LokalreaktorArtworkPeer::ID;
		}

	} 
	
	public function setSubreaktorId($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->subreaktor_id !== $v) {
			$this->subreaktor_id = $v;
			$this->modifiedColumns[] = LokalreaktorArtworkPeer::SUBREAKTOR_ID;
		}

		if ($this->aSubreaktor !== null && $this->aSubreaktor->getId() !== $v) {
			$this->aSubreaktor = null;
		}

	} 
	
	public function setArtworkId($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->artwork_id !== $v) {
			$this->artwork_id = $v;
			$this->modifiedColumns[] = LokalreaktorArtworkPeer::ARTWORK_ID;
		}

		if ($this->aReaktorArtwork !== null && $this->aReaktorArtwork->getId() !== $v) {
			$this->aReaktorArtwork = null;
		}

	} 
	
	public function hydrate(ResultSet $rs, $startcol = 1)
	{
		try {

			$this->id = $rs->getInt($startcol + 0);

			$this->subreaktor_id = $rs->getInt($startcol + 1);

			$this->artwork_id = $rs->getInt($startcol + 2);

			$this->resetModified();

			$this->setNew(false);

						return $startcol + 3; 
		} catch (Exception $e) {
			throw new PropelException("Error populating LokalreaktorArtwork object", $e);
		}
	}

	
	public function delete($con = null)
	{

    foreach (sfMixer::getCallables('BaseLokalreaktorArtwork:delete:pre') as $callable)
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
			$con = Propel::getConnection(LokalreaktorArtworkPeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			LokalreaktorArtworkPeer::doDelete($this, $con);
			$this->setDeleted(true);
			$con->commit();
		} catch (PropelException $e) {
			$con->rollback();
			throw $e;
		}
	

    foreach (sfMixer::getCallables('BaseLokalreaktorArtwork:delete:post') as $callable)
    {
      call_user_func($callable, $this, $con);
    }

  }
	
	public function save($con = null)
	{

    foreach (sfMixer::getCallables('BaseLokalreaktorArtwork:save:pre') as $callable)
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
			$con = Propel::getConnection(LokalreaktorArtworkPeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			$affectedRows = $this->doSave($con);
			$con->commit();
    foreach (sfMixer::getCallables('BaseLokalreaktorArtwork:save:post') as $callable)
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

			if ($this->aReaktorArtwork !== null) {
				if ($this->aReaktorArtwork->isModified()) {
					$affectedRows += $this->aReaktorArtwork->save($con);
				}
				$this->setReaktorArtwork($this->aReaktorArtwork);
			}


						if ($this->isModified()) {
				if ($this->isNew()) {
					$pk = LokalreaktorArtworkPeer::doInsert($this, $con);
					$affectedRows += 1; 										 										 
					$this->setId($pk);  
					$this->setNew(false);
				} else {
					$affectedRows += LokalreaktorArtworkPeer::doUpdate($this, $con);
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

			if ($this->aReaktorArtwork !== null) {
				if (!$this->aReaktorArtwork->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aReaktorArtwork->getValidationFailures());
				}
			}


			if (($retval = LokalreaktorArtworkPeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}



			$this->alreadyInValidation = false;
		}

		return (!empty($failureMap) ? $failureMap : true);
	}

	
	public function getByName($name, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = LokalreaktorArtworkPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->getByPosition($pos);
	}

	
	public function getByPosition($pos)
	{
		switch($pos) {
			case 0:
				return $this->getId();
				break;
			case 1:
				return $this->getSubreaktorId();
				break;
			case 2:
				return $this->getArtworkId();
				break;
			default:
				return null;
				break;
		} 	}

	
	public function toArray($keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = LokalreaktorArtworkPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getId(),
			$keys[1] => $this->getSubreaktorId(),
			$keys[2] => $this->getArtworkId(),
		);
		return $result;
	}

	
	public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = LokalreaktorArtworkPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->setByPosition($pos, $value);
	}

	
	public function setByPosition($pos, $value)
	{
		switch($pos) {
			case 0:
				$this->setId($value);
				break;
			case 1:
				$this->setSubreaktorId($value);
				break;
			case 2:
				$this->setArtworkId($value);
				break;
		} 	}

	
	public function fromArray($arr, $keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = LokalreaktorArtworkPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setSubreaktorId($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setArtworkId($arr[$keys[2]]);
	}

	
	public function buildCriteria()
	{
		$criteria = new Criteria(LokalreaktorArtworkPeer::DATABASE_NAME);

		if ($this->isColumnModified(LokalreaktorArtworkPeer::ID)) $criteria->add(LokalreaktorArtworkPeer::ID, $this->id);
		if ($this->isColumnModified(LokalreaktorArtworkPeer::SUBREAKTOR_ID)) $criteria->add(LokalreaktorArtworkPeer::SUBREAKTOR_ID, $this->subreaktor_id);
		if ($this->isColumnModified(LokalreaktorArtworkPeer::ARTWORK_ID)) $criteria->add(LokalreaktorArtworkPeer::ARTWORK_ID, $this->artwork_id);

		return $criteria;
	}

	
	public function buildPkeyCriteria()
	{
		$criteria = new Criteria(LokalreaktorArtworkPeer::DATABASE_NAME);

		$criteria->add(LokalreaktorArtworkPeer::ID, $this->id);

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

		$copyObj->setSubreaktorId($this->subreaktor_id);

		$copyObj->setArtworkId($this->artwork_id);


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
			self::$peer = new LokalreaktorArtworkPeer();
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

	
	public function setReaktorArtwork($v)
	{


		if ($v === null) {
			$this->setArtworkId(NULL);
		} else {
			$this->setArtworkId($v->getId());
		}


		$this->aReaktorArtwork = $v;
	}


	
	public function getReaktorArtwork($con = null)
	{
		if ($this->aReaktorArtwork === null && ($this->artwork_id !== null)) {
						include_once 'lib/model/om/BaseReaktorArtworkPeer.php';

			$this->aReaktorArtwork = ReaktorArtworkPeer::retrieveByPK($this->artwork_id, $con);

			
		}
		return $this->aReaktorArtwork;
	}


  public function __call($method, $arguments)
  {
    if (!$callable = sfMixer::getCallable('BaseLokalreaktorArtwork:'.$method))
    {
      throw new sfException(sprintf('Call to undefined method BaseLokalreaktorArtwork::%s', $method));
    }

    array_unshift($arguments, $this);

    return call_user_func_array($callable, $arguments);
  }


} 