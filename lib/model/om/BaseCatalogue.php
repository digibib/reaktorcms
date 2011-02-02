<?php


abstract class BaseCatalogue extends BaseObject  implements Persistent {


	
	protected static $peer;


	
	protected $cat_id;


	
	protected $name = '';


	
	protected $source_lang = '';


	
	protected $target_lang = '';


	
	protected $date_created = 0;


	
	protected $date_modified = 0;


	
	protected $author = '';


	
	protected $description = '';

	
	protected $collTransUnits;

	
	protected $lastTransUnitCriteria = null;

	
	protected $alreadyInSave = false;

	
	protected $alreadyInValidation = false;

	
	public function getCatId()
	{

		return $this->cat_id;
	}

	
	public function getName()
	{

		return $this->name;
	}

	
	public function getSourceLang()
	{

		return $this->source_lang;
	}

	
	public function getTargetLang()
	{

		return $this->target_lang;
	}

	
	public function getDateCreated()
	{

		return $this->date_created;
	}

	
	public function getDateModified()
	{

		return $this->date_modified;
	}

	
	public function getAuthor()
	{

		return $this->author;
	}

	
	public function getDescription()
	{

		return $this->description;
	}

	
	public function setCatId($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->cat_id !== $v) {
			$this->cat_id = $v;
			$this->modifiedColumns[] = CataloguePeer::CAT_ID;
		}

	} 
	
	public function setName($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->name !== $v || $v === '') {
			$this->name = $v;
			$this->modifiedColumns[] = CataloguePeer::NAME;
		}

	} 
	
	public function setSourceLang($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->source_lang !== $v || $v === '') {
			$this->source_lang = $v;
			$this->modifiedColumns[] = CataloguePeer::SOURCE_LANG;
		}

	} 
	
	public function setTargetLang($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->target_lang !== $v || $v === '') {
			$this->target_lang = $v;
			$this->modifiedColumns[] = CataloguePeer::TARGET_LANG;
		}

	} 
	
	public function setDateCreated($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->date_created !== $v || $v === 0) {
			$this->date_created = $v;
			$this->modifiedColumns[] = CataloguePeer::DATE_CREATED;
		}

	} 
	
	public function setDateModified($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->date_modified !== $v || $v === 0) {
			$this->date_modified = $v;
			$this->modifiedColumns[] = CataloguePeer::DATE_MODIFIED;
		}

	} 
	
	public function setAuthor($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->author !== $v || $v === '') {
			$this->author = $v;
			$this->modifiedColumns[] = CataloguePeer::AUTHOR;
		}

	} 
	
	public function setDescription($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->description !== $v || $v === '') {
			$this->description = $v;
			$this->modifiedColumns[] = CataloguePeer::DESCRIPTION;
		}

	} 
	
	public function hydrate(ResultSet $rs, $startcol = 1)
	{
		try {

			$this->cat_id = $rs->getInt($startcol + 0);

			$this->name = $rs->getString($startcol + 1);

			$this->source_lang = $rs->getString($startcol + 2);

			$this->target_lang = $rs->getString($startcol + 3);

			$this->date_created = $rs->getInt($startcol + 4);

			$this->date_modified = $rs->getInt($startcol + 5);

			$this->author = $rs->getString($startcol + 6);

			$this->description = $rs->getString($startcol + 7);

			$this->resetModified();

			$this->setNew(false);

						return $startcol + 8; 
		} catch (Exception $e) {
			throw new PropelException("Error populating Catalogue object", $e);
		}
	}

	
	public function delete($con = null)
	{

    foreach (sfMixer::getCallables('BaseCatalogue:delete:pre') as $callable)
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
			$con = Propel::getConnection(CataloguePeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			CataloguePeer::doDelete($this, $con);
			$this->setDeleted(true);
			$con->commit();
		} catch (PropelException $e) {
			$con->rollback();
			throw $e;
		}
	

    foreach (sfMixer::getCallables('BaseCatalogue:delete:post') as $callable)
    {
      call_user_func($callable, $this, $con);
    }

  }
	
	public function save($con = null)
	{

    foreach (sfMixer::getCallables('BaseCatalogue:save:pre') as $callable)
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
			$con = Propel::getConnection(CataloguePeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			$affectedRows = $this->doSave($con);
			$con->commit();
    foreach (sfMixer::getCallables('BaseCatalogue:save:post') as $callable)
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


						if ($this->isModified()) {
				if ($this->isNew()) {
					$pk = CataloguePeer::doInsert($this, $con);
					$affectedRows += 1; 										 										 
					$this->setCatId($pk);  
					$this->setNew(false);
				} else {
					$affectedRows += CataloguePeer::doUpdate($this, $con);
				}
				$this->resetModified(); 			}

			if ($this->collTransUnits !== null) {
				foreach($this->collTransUnits as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

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


			if (($retval = CataloguePeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}


				if ($this->collTransUnits !== null) {
					foreach($this->collTransUnits as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}


			$this->alreadyInValidation = false;
		}

		return (!empty($failureMap) ? $failureMap : true);
	}

	
	public function getByName($name, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = CataloguePeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->getByPosition($pos);
	}

	
	public function getByPosition($pos)
	{
		switch($pos) {
			case 0:
				return $this->getCatId();
				break;
			case 1:
				return $this->getName();
				break;
			case 2:
				return $this->getSourceLang();
				break;
			case 3:
				return $this->getTargetLang();
				break;
			case 4:
				return $this->getDateCreated();
				break;
			case 5:
				return $this->getDateModified();
				break;
			case 6:
				return $this->getAuthor();
				break;
			case 7:
				return $this->getDescription();
				break;
			default:
				return null;
				break;
		} 	}

	
	public function toArray($keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = CataloguePeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getCatId(),
			$keys[1] => $this->getName(),
			$keys[2] => $this->getSourceLang(),
			$keys[3] => $this->getTargetLang(),
			$keys[4] => $this->getDateCreated(),
			$keys[5] => $this->getDateModified(),
			$keys[6] => $this->getAuthor(),
			$keys[7] => $this->getDescription(),
		);
		return $result;
	}

	
	public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = CataloguePeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->setByPosition($pos, $value);
	}

	
	public function setByPosition($pos, $value)
	{
		switch($pos) {
			case 0:
				$this->setCatId($value);
				break;
			case 1:
				$this->setName($value);
				break;
			case 2:
				$this->setSourceLang($value);
				break;
			case 3:
				$this->setTargetLang($value);
				break;
			case 4:
				$this->setDateCreated($value);
				break;
			case 5:
				$this->setDateModified($value);
				break;
			case 6:
				$this->setAuthor($value);
				break;
			case 7:
				$this->setDescription($value);
				break;
		} 	}

	
	public function fromArray($arr, $keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = CataloguePeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setCatId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setName($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setSourceLang($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setTargetLang($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setDateCreated($arr[$keys[4]]);
		if (array_key_exists($keys[5], $arr)) $this->setDateModified($arr[$keys[5]]);
		if (array_key_exists($keys[6], $arr)) $this->setAuthor($arr[$keys[6]]);
		if (array_key_exists($keys[7], $arr)) $this->setDescription($arr[$keys[7]]);
	}

	
	public function buildCriteria()
	{
		$criteria = new Criteria(CataloguePeer::DATABASE_NAME);

		if ($this->isColumnModified(CataloguePeer::CAT_ID)) $criteria->add(CataloguePeer::CAT_ID, $this->cat_id);
		if ($this->isColumnModified(CataloguePeer::NAME)) $criteria->add(CataloguePeer::NAME, $this->name);
		if ($this->isColumnModified(CataloguePeer::SOURCE_LANG)) $criteria->add(CataloguePeer::SOURCE_LANG, $this->source_lang);
		if ($this->isColumnModified(CataloguePeer::TARGET_LANG)) $criteria->add(CataloguePeer::TARGET_LANG, $this->target_lang);
		if ($this->isColumnModified(CataloguePeer::DATE_CREATED)) $criteria->add(CataloguePeer::DATE_CREATED, $this->date_created);
		if ($this->isColumnModified(CataloguePeer::DATE_MODIFIED)) $criteria->add(CataloguePeer::DATE_MODIFIED, $this->date_modified);
		if ($this->isColumnModified(CataloguePeer::AUTHOR)) $criteria->add(CataloguePeer::AUTHOR, $this->author);
		if ($this->isColumnModified(CataloguePeer::DESCRIPTION)) $criteria->add(CataloguePeer::DESCRIPTION, $this->description);

		return $criteria;
	}

	
	public function buildPkeyCriteria()
	{
		$criteria = new Criteria(CataloguePeer::DATABASE_NAME);

		$criteria->add(CataloguePeer::CAT_ID, $this->cat_id);

		return $criteria;
	}

	
	public function getPrimaryKey()
	{
		return $this->getCatId();
	}

	
	public function setPrimaryKey($key)
	{
		$this->setCatId($key);
	}

	
	public function copyInto($copyObj, $deepCopy = false)
	{

		$copyObj->setName($this->name);

		$copyObj->setSourceLang($this->source_lang);

		$copyObj->setTargetLang($this->target_lang);

		$copyObj->setDateCreated($this->date_created);

		$copyObj->setDateModified($this->date_modified);

		$copyObj->setAuthor($this->author);

		$copyObj->setDescription($this->description);


		if ($deepCopy) {
									$copyObj->setNew(false);

			foreach($this->getTransUnits() as $relObj) {
				$copyObj->addTransUnit($relObj->copy($deepCopy));
			}

		} 

		$copyObj->setNew(true);

		$copyObj->setCatId(NULL); 
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
			self::$peer = new CataloguePeer();
		}
		return self::$peer;
	}

	
	public function initTransUnits()
	{
		if ($this->collTransUnits === null) {
			$this->collTransUnits = array();
		}
	}

	
	public function getTransUnits($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseTransUnitPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collTransUnits === null) {
			if ($this->isNew()) {
			   $this->collTransUnits = array();
			} else {

				$criteria->add(TransUnitPeer::CAT_ID, $this->getCatId());

				TransUnitPeer::addSelectColumns($criteria);
				$this->collTransUnits = TransUnitPeer::doSelect($criteria, $con);
			}
		} else {
						if (!$this->isNew()) {
												

				$criteria->add(TransUnitPeer::CAT_ID, $this->getCatId());

				TransUnitPeer::addSelectColumns($criteria);
				if (!isset($this->lastTransUnitCriteria) || !$this->lastTransUnitCriteria->equals($criteria)) {
					$this->collTransUnits = TransUnitPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastTransUnitCriteria = $criteria;
		return $this->collTransUnits;
	}

	
	public function countTransUnits($criteria = null, $distinct = false, $con = null)
	{
				include_once 'lib/model/om/BaseTransUnitPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(TransUnitPeer::CAT_ID, $this->getCatId());

		return TransUnitPeer::doCount($criteria, $distinct, $con);
	}

	
	public function addTransUnit(TransUnit $l)
	{
		$this->collTransUnits[] = $l;
		$l->setCatalogue($this);
	}


  public function __call($method, $arguments)
  {
    if (!$callable = sfMixer::getCallable('BaseCatalogue:'.$method))
    {
      throw new sfException(sprintf('Call to undefined method BaseCatalogue::%s', $method));
    }

    array_unshift($arguments, $this);

    return call_user_func_array($callable, $arguments);
  }


} 