<?php


abstract class BaseRejectionType extends BaseObject  implements Persistent {


	
	protected static $peer;


	
	protected $id;


	
	protected $basename;

	
	protected $collRejectionTypeI18ns;

	
	protected $lastRejectionTypeI18nCriteria = null;

	
	protected $alreadyInSave = false;

	
	protected $alreadyInValidation = false;

  
  protected $culture;

	
	public function getId()
	{

		return $this->id;
	}

	
	public function getBasename()
	{

		return $this->basename;
	}

	
	public function setId($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->id !== $v) {
			$this->id = $v;
			$this->modifiedColumns[] = RejectionTypePeer::ID;
		}

	} 
	
	public function setBasename($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->basename !== $v) {
			$this->basename = $v;
			$this->modifiedColumns[] = RejectionTypePeer::BASENAME;
		}

	} 
	
	public function hydrate(ResultSet $rs, $startcol = 1)
	{
		try {

			$this->id = $rs->getInt($startcol + 0);

			$this->basename = $rs->getString($startcol + 1);

			$this->resetModified();

			$this->setNew(false);

						return $startcol + 2; 
		} catch (Exception $e) {
			throw new PropelException("Error populating RejectionType object", $e);
		}
	}

	
	public function delete($con = null)
	{

    foreach (sfMixer::getCallables('BaseRejectionType:delete:pre') as $callable)
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
			$con = Propel::getConnection(RejectionTypePeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			RejectionTypePeer::doDelete($this, $con);
			$this->setDeleted(true);
			$con->commit();
		} catch (PropelException $e) {
			$con->rollback();
			throw $e;
		}
	

    foreach (sfMixer::getCallables('BaseRejectionType:delete:post') as $callable)
    {
      call_user_func($callable, $this, $con);
    }

  }
	
	public function save($con = null)
	{

    foreach (sfMixer::getCallables('BaseRejectionType:save:pre') as $callable)
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
			$con = Propel::getConnection(RejectionTypePeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			$affectedRows = $this->doSave($con);
			$con->commit();
    foreach (sfMixer::getCallables('BaseRejectionType:save:post') as $callable)
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
					$pk = RejectionTypePeer::doInsert($this, $con);
					$affectedRows += 1; 										 										 
					$this->setId($pk);  
					$this->setNew(false);
				} else {
					$affectedRows += RejectionTypePeer::doUpdate($this, $con);
				}
				$this->resetModified(); 			}

			if ($this->collRejectionTypeI18ns !== null) {
				foreach($this->collRejectionTypeI18ns as $referrerFK) {
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


			if (($retval = RejectionTypePeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}


				if ($this->collRejectionTypeI18ns !== null) {
					foreach($this->collRejectionTypeI18ns as $referrerFK) {
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
		$pos = RejectionTypePeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->getByPosition($pos);
	}

	
	public function getByPosition($pos)
	{
		switch($pos) {
			case 0:
				return $this->getId();
				break;
			case 1:
				return $this->getBasename();
				break;
			default:
				return null;
				break;
		} 	}

	
	public function toArray($keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = RejectionTypePeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getId(),
			$keys[1] => $this->getBasename(),
		);
		return $result;
	}

	
	public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = RejectionTypePeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->setByPosition($pos, $value);
	}

	
	public function setByPosition($pos, $value)
	{
		switch($pos) {
			case 0:
				$this->setId($value);
				break;
			case 1:
				$this->setBasename($value);
				break;
		} 	}

	
	public function fromArray($arr, $keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = RejectionTypePeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setBasename($arr[$keys[1]]);
	}

	
	public function buildCriteria()
	{
		$criteria = new Criteria(RejectionTypePeer::DATABASE_NAME);

		if ($this->isColumnModified(RejectionTypePeer::ID)) $criteria->add(RejectionTypePeer::ID, $this->id);
		if ($this->isColumnModified(RejectionTypePeer::BASENAME)) $criteria->add(RejectionTypePeer::BASENAME, $this->basename);

		return $criteria;
	}

	
	public function buildPkeyCriteria()
	{
		$criteria = new Criteria(RejectionTypePeer::DATABASE_NAME);

		$criteria->add(RejectionTypePeer::ID, $this->id);

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

		$copyObj->setBasename($this->basename);


		if ($deepCopy) {
									$copyObj->setNew(false);

			foreach($this->getRejectionTypeI18ns() as $relObj) {
				$copyObj->addRejectionTypeI18n($relObj->copy($deepCopy));
			}

		} 

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
			self::$peer = new RejectionTypePeer();
		}
		return self::$peer;
	}

	
	public function initRejectionTypeI18ns()
	{
		if ($this->collRejectionTypeI18ns === null) {
			$this->collRejectionTypeI18ns = array();
		}
	}

	
	public function getRejectionTypeI18ns($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseRejectionTypeI18nPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collRejectionTypeI18ns === null) {
			if ($this->isNew()) {
			   $this->collRejectionTypeI18ns = array();
			} else {

				$criteria->add(RejectionTypeI18nPeer::ID, $this->getId());

				RejectionTypeI18nPeer::addSelectColumns($criteria);
				$this->collRejectionTypeI18ns = RejectionTypeI18nPeer::doSelect($criteria, $con);
			}
		} else {
						if (!$this->isNew()) {
												

				$criteria->add(RejectionTypeI18nPeer::ID, $this->getId());

				RejectionTypeI18nPeer::addSelectColumns($criteria);
				if (!isset($this->lastRejectionTypeI18nCriteria) || !$this->lastRejectionTypeI18nCriteria->equals($criteria)) {
					$this->collRejectionTypeI18ns = RejectionTypeI18nPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastRejectionTypeI18nCriteria = $criteria;
		return $this->collRejectionTypeI18ns;
	}

	
	public function countRejectionTypeI18ns($criteria = null, $distinct = false, $con = null)
	{
				include_once 'lib/model/om/BaseRejectionTypeI18nPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(RejectionTypeI18nPeer::ID, $this->getId());

		return RejectionTypeI18nPeer::doCount($criteria, $distinct, $con);
	}

	
	public function addRejectionTypeI18n(RejectionTypeI18n $l)
	{
		$this->collRejectionTypeI18ns[] = $l;
		$l->setRejectionType($this);
	}

  public function getCulture()
  {
    return $this->culture;
  }

  public function setCulture($culture)
  {
    $this->culture = $culture;
  }

  public function getName()
  {
    $obj = $this->getCurrentRejectionTypeI18n();

    return ($obj ? $obj->getName() : null);
  }

  public function setName($value)
  {
    $this->getCurrentRejectionTypeI18n()->setName($value);
  }

  public function getDescription()
  {
    $obj = $this->getCurrentRejectionTypeI18n();

    return ($obj ? $obj->getDescription() : null);
  }

  public function setDescription($value)
  {
    $this->getCurrentRejectionTypeI18n()->setDescription($value);
  }

  protected $current_i18n = array();

  public function getCurrentRejectionTypeI18n()
  {
    if (!isset($this->current_i18n[$this->culture]))
    {
      $obj = RejectionTypeI18nPeer::retrieveByPK($this->getId(), $this->culture);
      if ($obj)
      {
        $this->setRejectionTypeI18nForCulture($obj, $this->culture);
      }
      else
      {
        $this->setRejectionTypeI18nForCulture(new RejectionTypeI18n(), $this->culture);
        $this->current_i18n[$this->culture]->setCulture($this->culture);
      }
    }

    return $this->current_i18n[$this->culture];
  }

  public function setRejectionTypeI18nForCulture($object, $culture)
  {
    $this->current_i18n[$culture] = $object;
    $this->addRejectionTypeI18n($object);
  }


  public function __call($method, $arguments)
  {
    if (!$callable = sfMixer::getCallable('BaseRejectionType:'.$method))
    {
      throw new sfException(sprintf('Call to undefined method BaseRejectionType::%s', $method));
    }

    array_unshift($arguments, $this);

    return call_user_func_array($callable, $arguments);
  }


} 