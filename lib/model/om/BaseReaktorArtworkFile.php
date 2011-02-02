<?php


abstract class BaseReaktorArtworkFile extends BaseObject  implements Persistent {


	
	protected static $peer;


	
	protected $artwork_id;


	
	protected $file_id;


	
	protected $file_order = 1;

	
	protected $aReaktorArtwork;

	
	protected $aReaktorFile;

	
	protected $alreadyInSave = false;

	
	protected $alreadyInValidation = false;

	
	public function getArtworkId()
	{

		return $this->artwork_id;
	}

	
	public function getFileId()
	{

		return $this->file_id;
	}

	
	public function getFileOrder()
	{

		return $this->file_order;
	}

	
	public function setArtworkId($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->artwork_id !== $v) {
			$this->artwork_id = $v;
			$this->modifiedColumns[] = ReaktorArtworkFilePeer::ARTWORK_ID;
		}

		if ($this->aReaktorArtwork !== null && $this->aReaktorArtwork->getId() !== $v) {
			$this->aReaktorArtwork = null;
		}

	} 
	
	public function setFileId($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->file_id !== $v) {
			$this->file_id = $v;
			$this->modifiedColumns[] = ReaktorArtworkFilePeer::FILE_ID;
		}

		if ($this->aReaktorFile !== null && $this->aReaktorFile->getId() !== $v) {
			$this->aReaktorFile = null;
		}

	} 
	
	public function setFileOrder($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->file_order !== $v || $v === 1) {
			$this->file_order = $v;
			$this->modifiedColumns[] = ReaktorArtworkFilePeer::FILE_ORDER;
		}

	} 
	
	public function hydrate(ResultSet $rs, $startcol = 1)
	{
		try {

			$this->artwork_id = $rs->getInt($startcol + 0);

			$this->file_id = $rs->getInt($startcol + 1);

			$this->file_order = $rs->getInt($startcol + 2);

			$this->resetModified();

			$this->setNew(false);

						return $startcol + 3; 
		} catch (Exception $e) {
			throw new PropelException("Error populating ReaktorArtworkFile object", $e);
		}
	}

	
	public function delete($con = null)
	{

    foreach (sfMixer::getCallables('BaseReaktorArtworkFile:delete:pre') as $callable)
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
			$con = Propel::getConnection(ReaktorArtworkFilePeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			ReaktorArtworkFilePeer::doDelete($this, $con);
			$this->setDeleted(true);
			$con->commit();
		} catch (PropelException $e) {
			$con->rollback();
			throw $e;
		}
	

    foreach (sfMixer::getCallables('BaseReaktorArtworkFile:delete:post') as $callable)
    {
      call_user_func($callable, $this, $con);
    }

  }
	
	public function save($con = null)
	{

    foreach (sfMixer::getCallables('BaseReaktorArtworkFile:save:pre') as $callable)
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
			$con = Propel::getConnection(ReaktorArtworkFilePeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			$affectedRows = $this->doSave($con);
			$con->commit();
    foreach (sfMixer::getCallables('BaseReaktorArtworkFile:save:post') as $callable)
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

			if ($this->aReaktorFile !== null) {
				if ($this->aReaktorFile->isModified()) {
					$affectedRows += $this->aReaktorFile->save($con);
				}
				$this->setReaktorFile($this->aReaktorFile);
			}


						if ($this->isModified()) {
				if ($this->isNew()) {
					$pk = ReaktorArtworkFilePeer::doInsert($this, $con);
					$affectedRows += 1; 										 										 
					$this->setNew(false);
				} else {
					$affectedRows += ReaktorArtworkFilePeer::doUpdate($this, $con);
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

			if ($this->aReaktorFile !== null) {
				if (!$this->aReaktorFile->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aReaktorFile->getValidationFailures());
				}
			}


			if (($retval = ReaktorArtworkFilePeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}



			$this->alreadyInValidation = false;
		}

		return (!empty($failureMap) ? $failureMap : true);
	}

	
	public function getByName($name, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = ReaktorArtworkFilePeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->getByPosition($pos);
	}

	
	public function getByPosition($pos)
	{
		switch($pos) {
			case 0:
				return $this->getArtworkId();
				break;
			case 1:
				return $this->getFileId();
				break;
			case 2:
				return $this->getFileOrder();
				break;
			default:
				return null;
				break;
		} 	}

	
	public function toArray($keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = ReaktorArtworkFilePeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getArtworkId(),
			$keys[1] => $this->getFileId(),
			$keys[2] => $this->getFileOrder(),
		);
		return $result;
	}

	
	public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = ReaktorArtworkFilePeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->setByPosition($pos, $value);
	}

	
	public function setByPosition($pos, $value)
	{
		switch($pos) {
			case 0:
				$this->setArtworkId($value);
				break;
			case 1:
				$this->setFileId($value);
				break;
			case 2:
				$this->setFileOrder($value);
				break;
		} 	}

	
	public function fromArray($arr, $keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = ReaktorArtworkFilePeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setArtworkId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setFileId($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setFileOrder($arr[$keys[2]]);
	}

	
	public function buildCriteria()
	{
		$criteria = new Criteria(ReaktorArtworkFilePeer::DATABASE_NAME);

		if ($this->isColumnModified(ReaktorArtworkFilePeer::ARTWORK_ID)) $criteria->add(ReaktorArtworkFilePeer::ARTWORK_ID, $this->artwork_id);
		if ($this->isColumnModified(ReaktorArtworkFilePeer::FILE_ID)) $criteria->add(ReaktorArtworkFilePeer::FILE_ID, $this->file_id);
		if ($this->isColumnModified(ReaktorArtworkFilePeer::FILE_ORDER)) $criteria->add(ReaktorArtworkFilePeer::FILE_ORDER, $this->file_order);

		return $criteria;
	}

	
	public function buildPkeyCriteria()
	{
		$criteria = new Criteria(ReaktorArtworkFilePeer::DATABASE_NAME);

		$criteria->add(ReaktorArtworkFilePeer::ARTWORK_ID, $this->artwork_id);
		$criteria->add(ReaktorArtworkFilePeer::FILE_ID, $this->file_id);

		return $criteria;
	}

	
	public function getPrimaryKey()
	{
		$pks = array();

		$pks[0] = $this->getArtworkId();

		$pks[1] = $this->getFileId();

		return $pks;
	}

	
	public function setPrimaryKey($keys)
	{

		$this->setArtworkId($keys[0]);

		$this->setFileId($keys[1]);

	}

	
	public function copyInto($copyObj, $deepCopy = false)
	{

		$copyObj->setFileOrder($this->file_order);


		$copyObj->setNew(true);

		$copyObj->setArtworkId(NULL); 
		$copyObj->setFileId(NULL); 
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
			self::$peer = new ReaktorArtworkFilePeer();
		}
		return self::$peer;
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

	
	public function setReaktorFile($v)
	{


		if ($v === null) {
			$this->setFileId(NULL);
		} else {
			$this->setFileId($v->getId());
		}


		$this->aReaktorFile = $v;
	}


	
	public function getReaktorFile($con = null)
	{
		if ($this->aReaktorFile === null && ($this->file_id !== null)) {
						include_once 'lib/model/om/BaseReaktorFilePeer.php';

			$this->aReaktorFile = ReaktorFilePeer::retrieveByPK($this->file_id, $con);

			
		}
		return $this->aReaktorFile;
	}


  public function __call($method, $arguments)
  {
    if (!$callable = sfMixer::getCallable('BaseReaktorArtworkFile:'.$method))
    {
      throw new sfException(sprintf('Call to undefined method BaseReaktorArtworkFile::%s', $method));
    }

    array_unshift($arguments, $this);

    return call_user_func_array($callable, $arguments);
  }


} 