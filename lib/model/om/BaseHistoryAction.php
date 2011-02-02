<?php


abstract class BaseHistoryAction extends BaseObject  implements Persistent {


	
	protected static $peer;


	
	protected $id;


	
	protected $name;

	
	protected $collHistorys;

	
	protected $lastHistoryCriteria = null;

	
	protected $collHistoryActionI18ns;

	
	protected $lastHistoryActionI18nCriteria = null;

	
	protected $alreadyInSave = false;

	
	protected $alreadyInValidation = false;

  
  protected $culture;

	
	public function getId()
	{

		return $this->id;
	}

	
	public function getName()
	{

		return $this->name;
	}

	
	public function setId($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->id !== $v) {
			$this->id = $v;
			$this->modifiedColumns[] = HistoryActionPeer::ID;
		}

	} 
	
	public function setName($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->name !== $v) {
			$this->name = $v;
			$this->modifiedColumns[] = HistoryActionPeer::NAME;
		}

	} 
	
	public function hydrate(ResultSet $rs, $startcol = 1)
	{
		try {

			$this->id = $rs->getInt($startcol + 0);

			$this->name = $rs->getString($startcol + 1);

			$this->resetModified();

			$this->setNew(false);

						return $startcol + 2; 
		} catch (Exception $e) {
			throw new PropelException("Error populating HistoryAction object", $e);
		}
	}

	
	public function delete($con = null)
	{

    foreach (sfMixer::getCallables('BaseHistoryAction:delete:pre') as $callable)
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
			$con = Propel::getConnection(HistoryActionPeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			HistoryActionPeer::doDelete($this, $con);
			$this->setDeleted(true);
			$con->commit();
		} catch (PropelException $e) {
			$con->rollback();
			throw $e;
		}
	

    foreach (sfMixer::getCallables('BaseHistoryAction:delete:post') as $callable)
    {
      call_user_func($callable, $this, $con);
    }

  }
	
	public function save($con = null)
	{

    foreach (sfMixer::getCallables('BaseHistoryAction:save:pre') as $callable)
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
			$con = Propel::getConnection(HistoryActionPeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			$affectedRows = $this->doSave($con);
			$con->commit();
    foreach (sfMixer::getCallables('BaseHistoryAction:save:post') as $callable)
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
					$pk = HistoryActionPeer::doInsert($this, $con);
					$affectedRows += 1; 										 										 
					$this->setId($pk);  
					$this->setNew(false);
				} else {
					$affectedRows += HistoryActionPeer::doUpdate($this, $con);
				}
				$this->resetModified(); 			}

			if ($this->collHistorys !== null) {
				foreach($this->collHistorys as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collHistoryActionI18ns !== null) {
				foreach($this->collHistoryActionI18ns as $referrerFK) {
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


			if (($retval = HistoryActionPeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}


				if ($this->collHistorys !== null) {
					foreach($this->collHistorys as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collHistoryActionI18ns !== null) {
					foreach($this->collHistoryActionI18ns as $referrerFK) {
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
		$pos = HistoryActionPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->getByPosition($pos);
	}

	
	public function getByPosition($pos)
	{
		switch($pos) {
			case 0:
				return $this->getId();
				break;
			case 1:
				return $this->getName();
				break;
			default:
				return null;
				break;
		} 	}

	
	public function toArray($keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = HistoryActionPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getId(),
			$keys[1] => $this->getName(),
		);
		return $result;
	}

	
	public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = HistoryActionPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->setByPosition($pos, $value);
	}

	
	public function setByPosition($pos, $value)
	{
		switch($pos) {
			case 0:
				$this->setId($value);
				break;
			case 1:
				$this->setName($value);
				break;
		} 	}

	
	public function fromArray($arr, $keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = HistoryActionPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setName($arr[$keys[1]]);
	}

	
	public function buildCriteria()
	{
		$criteria = new Criteria(HistoryActionPeer::DATABASE_NAME);

		if ($this->isColumnModified(HistoryActionPeer::ID)) $criteria->add(HistoryActionPeer::ID, $this->id);
		if ($this->isColumnModified(HistoryActionPeer::NAME)) $criteria->add(HistoryActionPeer::NAME, $this->name);

		return $criteria;
	}

	
	public function buildPkeyCriteria()
	{
		$criteria = new Criteria(HistoryActionPeer::DATABASE_NAME);

		$criteria->add(HistoryActionPeer::ID, $this->id);

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

		$copyObj->setName($this->name);


		if ($deepCopy) {
									$copyObj->setNew(false);

			foreach($this->getHistorys() as $relObj) {
				$copyObj->addHistory($relObj->copy($deepCopy));
			}

			foreach($this->getHistoryActionI18ns() as $relObj) {
				$copyObj->addHistoryActionI18n($relObj->copy($deepCopy));
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
			self::$peer = new HistoryActionPeer();
		}
		return self::$peer;
	}

	
	public function initHistorys()
	{
		if ($this->collHistorys === null) {
			$this->collHistorys = array();
		}
	}

	
	public function getHistorys($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseHistoryPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collHistorys === null) {
			if ($this->isNew()) {
			   $this->collHistorys = array();
			} else {

				$criteria->add(HistoryPeer::ACTION_ID, $this->getId());

				HistoryPeer::addSelectColumns($criteria);
				$this->collHistorys = HistoryPeer::doSelect($criteria, $con);
			}
		} else {
						if (!$this->isNew()) {
												

				$criteria->add(HistoryPeer::ACTION_ID, $this->getId());

				HistoryPeer::addSelectColumns($criteria);
				if (!isset($this->lastHistoryCriteria) || !$this->lastHistoryCriteria->equals($criteria)) {
					$this->collHistorys = HistoryPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastHistoryCriteria = $criteria;
		return $this->collHistorys;
	}

	
	public function countHistorys($criteria = null, $distinct = false, $con = null)
	{
				include_once 'lib/model/om/BaseHistoryPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(HistoryPeer::ACTION_ID, $this->getId());

		return HistoryPeer::doCount($criteria, $distinct, $con);
	}

	
	public function addHistory(History $l)
	{
		$this->collHistorys[] = $l;
		$l->setHistoryAction($this);
	}


	
	public function getHistorysJoinsfGuardUser($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseHistoryPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collHistorys === null) {
			if ($this->isNew()) {
				$this->collHistorys = array();
			} else {

				$criteria->add(HistoryPeer::ACTION_ID, $this->getId());

				$this->collHistorys = HistoryPeer::doSelectJoinsfGuardUser($criteria, $con);
			}
		} else {
									
			$criteria->add(HistoryPeer::ACTION_ID, $this->getId());

			if (!isset($this->lastHistoryCriteria) || !$this->lastHistoryCriteria->equals($criteria)) {
				$this->collHistorys = HistoryPeer::doSelectJoinsfGuardUser($criteria, $con);
			}
		}
		$this->lastHistoryCriteria = $criteria;

		return $this->collHistorys;
	}

	
	public function initHistoryActionI18ns()
	{
		if ($this->collHistoryActionI18ns === null) {
			$this->collHistoryActionI18ns = array();
		}
	}

	
	public function getHistoryActionI18ns($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseHistoryActionI18nPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collHistoryActionI18ns === null) {
			if ($this->isNew()) {
			   $this->collHistoryActionI18ns = array();
			} else {

				$criteria->add(HistoryActionI18nPeer::ID, $this->getId());

				HistoryActionI18nPeer::addSelectColumns($criteria);
				$this->collHistoryActionI18ns = HistoryActionI18nPeer::doSelect($criteria, $con);
			}
		} else {
						if (!$this->isNew()) {
												

				$criteria->add(HistoryActionI18nPeer::ID, $this->getId());

				HistoryActionI18nPeer::addSelectColumns($criteria);
				if (!isset($this->lastHistoryActionI18nCriteria) || !$this->lastHistoryActionI18nCriteria->equals($criteria)) {
					$this->collHistoryActionI18ns = HistoryActionI18nPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastHistoryActionI18nCriteria = $criteria;
		return $this->collHistoryActionI18ns;
	}

	
	public function countHistoryActionI18ns($criteria = null, $distinct = false, $con = null)
	{
				include_once 'lib/model/om/BaseHistoryActionI18nPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(HistoryActionI18nPeer::ID, $this->getId());

		return HistoryActionI18nPeer::doCount($criteria, $distinct, $con);
	}

	
	public function addHistoryActionI18n(HistoryActionI18n $l)
	{
		$this->collHistoryActionI18ns[] = $l;
		$l->setHistoryAction($this);
	}

  public function getCulture()
  {
    return $this->culture;
  }

  public function setCulture($culture)
  {
    $this->culture = $culture;
  }

  public function getDescription()
  {
    $obj = $this->getCurrentHistoryActionI18n();

    return ($obj ? $obj->getDescription() : null);
  }

  public function setDescription($value)
  {
    $this->getCurrentHistoryActionI18n()->setDescription($value);
  }

  protected $current_i18n = array();

  public function getCurrentHistoryActionI18n()
  {
    if (!isset($this->current_i18n[$this->culture]))
    {
      $obj = HistoryActionI18nPeer::retrieveByPK($this->getId(), $this->culture);
      if ($obj)
      {
        $this->setHistoryActionI18nForCulture($obj, $this->culture);
      }
      else
      {
        $this->setHistoryActionI18nForCulture(new HistoryActionI18n(), $this->culture);
        $this->current_i18n[$this->culture]->setCulture($this->culture);
      }
    }

    return $this->current_i18n[$this->culture];
  }

  public function setHistoryActionI18nForCulture($object, $culture)
  {
    $this->current_i18n[$culture] = $object;
    $this->addHistoryActionI18n($object);
  }


  public function __call($method, $arguments)
  {
    if (!$callable = sfMixer::getCallable('BaseHistoryAction:'.$method))
    {
      throw new sfException(sprintf('Call to undefined method BaseHistoryAction::%s', $method));
    }

    array_unshift($arguments, $this);

    return call_user_func_array($callable, $arguments);
  }


} 