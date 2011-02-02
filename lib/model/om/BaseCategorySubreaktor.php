<?php


abstract class BaseCategorySubreaktor extends BaseObject  implements Persistent {


	
	protected static $peer;


	
	protected $id;


	
	protected $category_id;


	
	protected $subreaktor_id;

	
	protected $aCategory;

	
	protected $aSubreaktor;

	
	protected $alreadyInSave = false;

	
	protected $alreadyInValidation = false;

	
	public function getId()
	{

		return $this->id;
	}

	
	public function getCategoryId()
	{

		return $this->category_id;
	}

	
	public function getSubreaktorId()
	{

		return $this->subreaktor_id;
	}

	
	public function setId($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->id !== $v) {
			$this->id = $v;
			$this->modifiedColumns[] = CategorySubreaktorPeer::ID;
		}

	} 
	
	public function setCategoryId($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->category_id !== $v) {
			$this->category_id = $v;
			$this->modifiedColumns[] = CategorySubreaktorPeer::CATEGORY_ID;
		}

		if ($this->aCategory !== null && $this->aCategory->getId() !== $v) {
			$this->aCategory = null;
		}

	} 
	
	public function setSubreaktorId($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->subreaktor_id !== $v) {
			$this->subreaktor_id = $v;
			$this->modifiedColumns[] = CategorySubreaktorPeer::SUBREAKTOR_ID;
		}

		if ($this->aSubreaktor !== null && $this->aSubreaktor->getId() !== $v) {
			$this->aSubreaktor = null;
		}

	} 
	
	public function hydrate(ResultSet $rs, $startcol = 1)
	{
		try {

			$this->id = $rs->getInt($startcol + 0);

			$this->category_id = $rs->getInt($startcol + 1);

			$this->subreaktor_id = $rs->getInt($startcol + 2);

			$this->resetModified();

			$this->setNew(false);

						return $startcol + 3; 
		} catch (Exception $e) {
			throw new PropelException("Error populating CategorySubreaktor object", $e);
		}
	}

	
	public function delete($con = null)
	{

    foreach (sfMixer::getCallables('BaseCategorySubreaktor:delete:pre') as $callable)
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
			$con = Propel::getConnection(CategorySubreaktorPeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			CategorySubreaktorPeer::doDelete($this, $con);
			$this->setDeleted(true);
			$con->commit();
		} catch (PropelException $e) {
			$con->rollback();
			throw $e;
		}
	

    foreach (sfMixer::getCallables('BaseCategorySubreaktor:delete:post') as $callable)
    {
      call_user_func($callable, $this, $con);
    }

  }
	
	public function save($con = null)
	{

    foreach (sfMixer::getCallables('BaseCategorySubreaktor:save:pre') as $callable)
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
			$con = Propel::getConnection(CategorySubreaktorPeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			$affectedRows = $this->doSave($con);
			$con->commit();
    foreach (sfMixer::getCallables('BaseCategorySubreaktor:save:post') as $callable)
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


												
			if ($this->aCategory !== null) {
				if ($this->aCategory->isModified() || $this->aCategory->getCurrentCategoryI18n()->isModified()) {
					$affectedRows += $this->aCategory->save($con);
				}
				$this->setCategory($this->aCategory);
			}

			if ($this->aSubreaktor !== null) {
				if ($this->aSubreaktor->isModified() || $this->aSubreaktor->getCurrentSubreaktorI18n()->isModified()) {
					$affectedRows += $this->aSubreaktor->save($con);
				}
				$this->setSubreaktor($this->aSubreaktor);
			}


						if ($this->isModified()) {
				if ($this->isNew()) {
					$pk = CategorySubreaktorPeer::doInsert($this, $con);
					$affectedRows += 1; 										 										 
					$this->setId($pk);  
					$this->setNew(false);
				} else {
					$affectedRows += CategorySubreaktorPeer::doUpdate($this, $con);
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


												
			if ($this->aCategory !== null) {
				if (!$this->aCategory->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aCategory->getValidationFailures());
				}
			}

			if ($this->aSubreaktor !== null) {
				if (!$this->aSubreaktor->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aSubreaktor->getValidationFailures());
				}
			}


			if (($retval = CategorySubreaktorPeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}



			$this->alreadyInValidation = false;
		}

		return (!empty($failureMap) ? $failureMap : true);
	}

	
	public function getByName($name, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = CategorySubreaktorPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->getByPosition($pos);
	}

	
	public function getByPosition($pos)
	{
		switch($pos) {
			case 0:
				return $this->getId();
				break;
			case 1:
				return $this->getCategoryId();
				break;
			case 2:
				return $this->getSubreaktorId();
				break;
			default:
				return null;
				break;
		} 	}

	
	public function toArray($keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = CategorySubreaktorPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getId(),
			$keys[1] => $this->getCategoryId(),
			$keys[2] => $this->getSubreaktorId(),
		);
		return $result;
	}

	
	public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = CategorySubreaktorPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->setByPosition($pos, $value);
	}

	
	public function setByPosition($pos, $value)
	{
		switch($pos) {
			case 0:
				$this->setId($value);
				break;
			case 1:
				$this->setCategoryId($value);
				break;
			case 2:
				$this->setSubreaktorId($value);
				break;
		} 	}

	
	public function fromArray($arr, $keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = CategorySubreaktorPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setCategoryId($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setSubreaktorId($arr[$keys[2]]);
	}

	
	public function buildCriteria()
	{
		$criteria = new Criteria(CategorySubreaktorPeer::DATABASE_NAME);

		if ($this->isColumnModified(CategorySubreaktorPeer::ID)) $criteria->add(CategorySubreaktorPeer::ID, $this->id);
		if ($this->isColumnModified(CategorySubreaktorPeer::CATEGORY_ID)) $criteria->add(CategorySubreaktorPeer::CATEGORY_ID, $this->category_id);
		if ($this->isColumnModified(CategorySubreaktorPeer::SUBREAKTOR_ID)) $criteria->add(CategorySubreaktorPeer::SUBREAKTOR_ID, $this->subreaktor_id);

		return $criteria;
	}

	
	public function buildPkeyCriteria()
	{
		$criteria = new Criteria(CategorySubreaktorPeer::DATABASE_NAME);

		$criteria->add(CategorySubreaktorPeer::ID, $this->id);

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

		$copyObj->setCategoryId($this->category_id);

		$copyObj->setSubreaktorId($this->subreaktor_id);


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
			self::$peer = new CategorySubreaktorPeer();
		}
		return self::$peer;
	}

	
	public function setCategory($v)
	{


		if ($v === null) {
			$this->setCategoryId(NULL);
		} else {
			$this->setCategoryId($v->getId());
		}


		$this->aCategory = $v;
	}


	
	public function getCategory($con = null)
	{
		if ($this->aCategory === null && ($this->category_id !== null)) {
						include_once 'lib/model/om/BaseCategoryPeer.php';

			$this->aCategory = CategoryPeer::retrieveByPK($this->category_id, $con);

			
		}
		return $this->aCategory;
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


  public function __call($method, $arguments)
  {
    if (!$callable = sfMixer::getCallable('BaseCategorySubreaktor:'.$method))
    {
      throw new sfException(sprintf('Call to undefined method BaseCategorySubreaktor::%s', $method));
    }

    array_unshift($arguments, $this);

    return call_user_func_array($callable, $arguments);
  }


} 