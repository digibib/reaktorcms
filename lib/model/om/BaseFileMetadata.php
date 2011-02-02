<?php


abstract class BaseFileMetadata extends BaseObject  implements Persistent {


	
	protected static $peer;


	
	protected $id;


	
	protected $file;


	
	protected $meta_element;


	
	protected $meta_qualifier;


	
	protected $meta_value;

	
	protected $aReaktorFile;

	
	protected $alreadyInSave = false;

	
	protected $alreadyInValidation = false;

	
	public function getId()
	{

		return $this->id;
	}

	
	public function getFile()
	{

		return $this->file;
	}

	
	public function getMetaElement()
	{

		return $this->meta_element;
	}

	
	public function getMetaQualifier()
	{

		return $this->meta_qualifier;
	}

	
	public function getMetaValue()
	{

		return $this->meta_value;
	}

	
	public function setId($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->id !== $v) {
			$this->id = $v;
			$this->modifiedColumns[] = FileMetadataPeer::ID;
		}

	} 
	
	public function setFile($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->file !== $v) {
			$this->file = $v;
			$this->modifiedColumns[] = FileMetadataPeer::FILE;
		}

		if ($this->aReaktorFile !== null && $this->aReaktorFile->getId() !== $v) {
			$this->aReaktorFile = null;
		}

	} 
	
	public function setMetaElement($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->meta_element !== $v) {
			$this->meta_element = $v;
			$this->modifiedColumns[] = FileMetadataPeer::META_ELEMENT;
		}

	} 
	
	public function setMetaQualifier($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->meta_qualifier !== $v) {
			$this->meta_qualifier = $v;
			$this->modifiedColumns[] = FileMetadataPeer::META_QUALIFIER;
		}

	} 
	
	public function setMetaValue($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->meta_value !== $v) {
			$this->meta_value = $v;
			$this->modifiedColumns[] = FileMetadataPeer::META_VALUE;
		}

	} 
	
	public function hydrate(ResultSet $rs, $startcol = 1)
	{
		try {

			$this->id = $rs->getInt($startcol + 0);

			$this->file = $rs->getInt($startcol + 1);

			$this->meta_element = $rs->getString($startcol + 2);

			$this->meta_qualifier = $rs->getString($startcol + 3);

			$this->meta_value = $rs->getString($startcol + 4);

			$this->resetModified();

			$this->setNew(false);

						return $startcol + 5; 
		} catch (Exception $e) {
			throw new PropelException("Error populating FileMetadata object", $e);
		}
	}

	
	public function delete($con = null)
	{

    foreach (sfMixer::getCallables('BaseFileMetadata:delete:pre') as $callable)
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
			$con = Propel::getConnection(FileMetadataPeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			FileMetadataPeer::doDelete($this, $con);
			$this->setDeleted(true);
			$con->commit();
		} catch (PropelException $e) {
			$con->rollback();
			throw $e;
		}
	

    foreach (sfMixer::getCallables('BaseFileMetadata:delete:post') as $callable)
    {
      call_user_func($callable, $this, $con);
    }

  }
	
	public function save($con = null)
	{

    foreach (sfMixer::getCallables('BaseFileMetadata:save:pre') as $callable)
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
			$con = Propel::getConnection(FileMetadataPeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			$affectedRows = $this->doSave($con);
			$con->commit();
    foreach (sfMixer::getCallables('BaseFileMetadata:save:post') as $callable)
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


												
			if ($this->aReaktorFile !== null) {
				if ($this->aReaktorFile->isModified()) {
					$affectedRows += $this->aReaktorFile->save($con);
				}
				$this->setReaktorFile($this->aReaktorFile);
			}


						if ($this->isModified()) {
				if ($this->isNew()) {
					$pk = FileMetadataPeer::doInsert($this, $con);
					$affectedRows += 1; 										 										 
					$this->setId($pk);  
					$this->setNew(false);
				} else {
					$affectedRows += FileMetadataPeer::doUpdate($this, $con);
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


												
			if ($this->aReaktorFile !== null) {
				if (!$this->aReaktorFile->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aReaktorFile->getValidationFailures());
				}
			}


			if (($retval = FileMetadataPeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}



			$this->alreadyInValidation = false;
		}

		return (!empty($failureMap) ? $failureMap : true);
	}

	
	public function getByName($name, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = FileMetadataPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->getByPosition($pos);
	}

	
	public function getByPosition($pos)
	{
		switch($pos) {
			case 0:
				return $this->getId();
				break;
			case 1:
				return $this->getFile();
				break;
			case 2:
				return $this->getMetaElement();
				break;
			case 3:
				return $this->getMetaQualifier();
				break;
			case 4:
				return $this->getMetaValue();
				break;
			default:
				return null;
				break;
		} 	}

	
	public function toArray($keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = FileMetadataPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getId(),
			$keys[1] => $this->getFile(),
			$keys[2] => $this->getMetaElement(),
			$keys[3] => $this->getMetaQualifier(),
			$keys[4] => $this->getMetaValue(),
		);
		return $result;
	}

	
	public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = FileMetadataPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->setByPosition($pos, $value);
	}

	
	public function setByPosition($pos, $value)
	{
		switch($pos) {
			case 0:
				$this->setId($value);
				break;
			case 1:
				$this->setFile($value);
				break;
			case 2:
				$this->setMetaElement($value);
				break;
			case 3:
				$this->setMetaQualifier($value);
				break;
			case 4:
				$this->setMetaValue($value);
				break;
		} 	}

	
	public function fromArray($arr, $keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = FileMetadataPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setFile($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setMetaElement($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setMetaQualifier($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setMetaValue($arr[$keys[4]]);
	}

	
	public function buildCriteria()
	{
		$criteria = new Criteria(FileMetadataPeer::DATABASE_NAME);

		if ($this->isColumnModified(FileMetadataPeer::ID)) $criteria->add(FileMetadataPeer::ID, $this->id);
		if ($this->isColumnModified(FileMetadataPeer::FILE)) $criteria->add(FileMetadataPeer::FILE, $this->file);
		if ($this->isColumnModified(FileMetadataPeer::META_ELEMENT)) $criteria->add(FileMetadataPeer::META_ELEMENT, $this->meta_element);
		if ($this->isColumnModified(FileMetadataPeer::META_QUALIFIER)) $criteria->add(FileMetadataPeer::META_QUALIFIER, $this->meta_qualifier);
		if ($this->isColumnModified(FileMetadataPeer::META_VALUE)) $criteria->add(FileMetadataPeer::META_VALUE, $this->meta_value);

		return $criteria;
	}

	
	public function buildPkeyCriteria()
	{
		$criteria = new Criteria(FileMetadataPeer::DATABASE_NAME);

		$criteria->add(FileMetadataPeer::ID, $this->id);

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

		$copyObj->setFile($this->file);

		$copyObj->setMetaElement($this->meta_element);

		$copyObj->setMetaQualifier($this->meta_qualifier);

		$copyObj->setMetaValue($this->meta_value);


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
			self::$peer = new FileMetadataPeer();
		}
		return self::$peer;
	}

	
	public function setReaktorFile($v)
	{


		if ($v === null) {
			$this->setFile(NULL);
		} else {
			$this->setFile($v->getId());
		}


		$this->aReaktorFile = $v;
	}


	
	public function getReaktorFile($con = null)
	{
		if ($this->aReaktorFile === null && ($this->file !== null)) {
						include_once 'lib/model/om/BaseReaktorFilePeer.php';

			$this->aReaktorFile = ReaktorFilePeer::retrieveByPK($this->file, $con);

			
		}
		return $this->aReaktorFile;
	}


  public function __call($method, $arguments)
  {
    if (!$callable = sfMixer::getCallable('BaseFileMetadata:'.$method))
    {
      throw new sfException(sprintf('Call to undefined method BaseFileMetadata::%s', $method));
    }

    array_unshift($arguments, $this);

    return call_user_func_array($callable, $arguments);
  }


} 