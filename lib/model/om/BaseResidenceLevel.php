<?php


abstract class BaseResidenceLevel extends BaseObject  implements Persistent {


	
	protected static $peer;


	
	protected $id;


	
	protected $levelname;


	
	protected $listorder;

	
	protected $collResidenceLevelI18ns;

	
	protected $lastResidenceLevelI18nCriteria = null;

	
	protected $collResidences;

	
	protected $lastResidenceCriteria = null;

	
	protected $alreadyInSave = false;

	
	protected $alreadyInValidation = false;

  
  protected $culture;

	
	public function getId()
	{

		return $this->id;
	}

	
	public function getLevelname()
	{

		return $this->levelname;
	}

	
	public function getListorder()
	{

		return $this->listorder;
	}

	
	public function setId($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->id !== $v) {
			$this->id = $v;
			$this->modifiedColumns[] = ResidenceLevelPeer::ID;
		}

	} 
	
	public function setLevelname($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->levelname !== $v) {
			$this->levelname = $v;
			$this->modifiedColumns[] = ResidenceLevelPeer::LEVELNAME;
		}

	} 
	
	public function setListorder($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->listorder !== $v) {
			$this->listorder = $v;
			$this->modifiedColumns[] = ResidenceLevelPeer::LISTORDER;
		}

	} 
	
	public function hydrate(ResultSet $rs, $startcol = 1)
	{
		try {

			$this->id = $rs->getInt($startcol + 0);

			$this->levelname = $rs->getString($startcol + 1);

			$this->listorder = $rs->getInt($startcol + 2);

			$this->resetModified();

			$this->setNew(false);

						return $startcol + 3; 
		} catch (Exception $e) {
			throw new PropelException("Error populating ResidenceLevel object", $e);
		}
	}

	
	public function delete($con = null)
	{

    foreach (sfMixer::getCallables('BaseResidenceLevel:delete:pre') as $callable)
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
			$con = Propel::getConnection(ResidenceLevelPeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			ResidenceLevelPeer::doDelete($this, $con);
			$this->setDeleted(true);
			$con->commit();
		} catch (PropelException $e) {
			$con->rollback();
			throw $e;
		}
	

    foreach (sfMixer::getCallables('BaseResidenceLevel:delete:post') as $callable)
    {
      call_user_func($callable, $this, $con);
    }

  }
	
	public function save($con = null)
	{

    foreach (sfMixer::getCallables('BaseResidenceLevel:save:pre') as $callable)
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
			$con = Propel::getConnection(ResidenceLevelPeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			$affectedRows = $this->doSave($con);
			$con->commit();
    foreach (sfMixer::getCallables('BaseResidenceLevel:save:post') as $callable)
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
					$pk = ResidenceLevelPeer::doInsert($this, $con);
					$affectedRows += 1; 										 										 
					$this->setId($pk);  
					$this->setNew(false);
				} else {
					$affectedRows += ResidenceLevelPeer::doUpdate($this, $con);
				}
				$this->resetModified(); 			}

			if ($this->collResidenceLevelI18ns !== null) {
				foreach($this->collResidenceLevelI18ns as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collResidences !== null) {
				foreach($this->collResidences as $referrerFK) {
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


			if (($retval = ResidenceLevelPeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}


				if ($this->collResidenceLevelI18ns !== null) {
					foreach($this->collResidenceLevelI18ns as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collResidences !== null) {
					foreach($this->collResidences as $referrerFK) {
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
		$pos = ResidenceLevelPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->getByPosition($pos);
	}

	
	public function getByPosition($pos)
	{
		switch($pos) {
			case 0:
				return $this->getId();
				break;
			case 1:
				return $this->getLevelname();
				break;
			case 2:
				return $this->getListorder();
				break;
			default:
				return null;
				break;
		} 	}

	
	public function toArray($keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = ResidenceLevelPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getId(),
			$keys[1] => $this->getLevelname(),
			$keys[2] => $this->getListorder(),
		);
		return $result;
	}

	
	public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = ResidenceLevelPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->setByPosition($pos, $value);
	}

	
	public function setByPosition($pos, $value)
	{
		switch($pos) {
			case 0:
				$this->setId($value);
				break;
			case 1:
				$this->setLevelname($value);
				break;
			case 2:
				$this->setListorder($value);
				break;
		} 	}

	
	public function fromArray($arr, $keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = ResidenceLevelPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setLevelname($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setListorder($arr[$keys[2]]);
	}

	
	public function buildCriteria()
	{
		$criteria = new Criteria(ResidenceLevelPeer::DATABASE_NAME);

		if ($this->isColumnModified(ResidenceLevelPeer::ID)) $criteria->add(ResidenceLevelPeer::ID, $this->id);
		if ($this->isColumnModified(ResidenceLevelPeer::LEVELNAME)) $criteria->add(ResidenceLevelPeer::LEVELNAME, $this->levelname);
		if ($this->isColumnModified(ResidenceLevelPeer::LISTORDER)) $criteria->add(ResidenceLevelPeer::LISTORDER, $this->listorder);

		return $criteria;
	}

	
	public function buildPkeyCriteria()
	{
		$criteria = new Criteria(ResidenceLevelPeer::DATABASE_NAME);

		$criteria->add(ResidenceLevelPeer::ID, $this->id);

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

		$copyObj->setLevelname($this->levelname);

		$copyObj->setListorder($this->listorder);


		if ($deepCopy) {
									$copyObj->setNew(false);

			foreach($this->getResidenceLevelI18ns() as $relObj) {
				$copyObj->addResidenceLevelI18n($relObj->copy($deepCopy));
			}

			foreach($this->getResidences() as $relObj) {
				$copyObj->addResidence($relObj->copy($deepCopy));
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
			self::$peer = new ResidenceLevelPeer();
		}
		return self::$peer;
	}

	
	public function initResidenceLevelI18ns()
	{
		if ($this->collResidenceLevelI18ns === null) {
			$this->collResidenceLevelI18ns = array();
		}
	}

	
	public function getResidenceLevelI18ns($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseResidenceLevelI18nPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collResidenceLevelI18ns === null) {
			if ($this->isNew()) {
			   $this->collResidenceLevelI18ns = array();
			} else {

				$criteria->add(ResidenceLevelI18nPeer::ID, $this->getId());

				ResidenceLevelI18nPeer::addSelectColumns($criteria);
				$this->collResidenceLevelI18ns = ResidenceLevelI18nPeer::doSelect($criteria, $con);
			}
		} else {
						if (!$this->isNew()) {
												

				$criteria->add(ResidenceLevelI18nPeer::ID, $this->getId());

				ResidenceLevelI18nPeer::addSelectColumns($criteria);
				if (!isset($this->lastResidenceLevelI18nCriteria) || !$this->lastResidenceLevelI18nCriteria->equals($criteria)) {
					$this->collResidenceLevelI18ns = ResidenceLevelI18nPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastResidenceLevelI18nCriteria = $criteria;
		return $this->collResidenceLevelI18ns;
	}

	
	public function countResidenceLevelI18ns($criteria = null, $distinct = false, $con = null)
	{
				include_once 'lib/model/om/BaseResidenceLevelI18nPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(ResidenceLevelI18nPeer::ID, $this->getId());

		return ResidenceLevelI18nPeer::doCount($criteria, $distinct, $con);
	}

	
	public function addResidenceLevelI18n(ResidenceLevelI18n $l)
	{
		$this->collResidenceLevelI18ns[] = $l;
		$l->setResidenceLevel($this);
	}

	
	public function initResidences()
	{
		if ($this->collResidences === null) {
			$this->collResidences = array();
		}
	}

	
	public function getResidences($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseResidencePeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collResidences === null) {
			if ($this->isNew()) {
			   $this->collResidences = array();
			} else {

				$criteria->add(ResidencePeer::LEVEL, $this->getId());

				ResidencePeer::addSelectColumns($criteria);
				$this->collResidences = ResidencePeer::doSelect($criteria, $con);
			}
		} else {
						if (!$this->isNew()) {
												

				$criteria->add(ResidencePeer::LEVEL, $this->getId());

				ResidencePeer::addSelectColumns($criteria);
				if (!isset($this->lastResidenceCriteria) || !$this->lastResidenceCriteria->equals($criteria)) {
					$this->collResidences = ResidencePeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastResidenceCriteria = $criteria;
		return $this->collResidences;
	}

	
	public function countResidences($criteria = null, $distinct = false, $con = null)
	{
				include_once 'lib/model/om/BaseResidencePeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(ResidencePeer::LEVEL, $this->getId());

		return ResidencePeer::doCount($criteria, $distinct, $con);
	}

	
	public function addResidence(Residence $l)
	{
		$this->collResidences[] = $l;
		$l->setResidenceLevel($this);
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
    $obj = $this->getCurrentResidenceLevelI18n();

    return ($obj ? $obj->getName() : null);
  }

  public function setName($value)
  {
    $this->getCurrentResidenceLevelI18n()->setName($value);
  }

  protected $current_i18n = array();

  public function getCurrentResidenceLevelI18n()
  {
    if (!isset($this->current_i18n[$this->culture]))
    {
      $obj = ResidenceLevelI18nPeer::retrieveByPK($this->getId(), $this->culture);
      if ($obj)
      {
        $this->setResidenceLevelI18nForCulture($obj, $this->culture);
      }
      else
      {
        $this->setResidenceLevelI18nForCulture(new ResidenceLevelI18n(), $this->culture);
        $this->current_i18n[$this->culture]->setCulture($this->culture);
      }
    }

    return $this->current_i18n[$this->culture];
  }

  public function setResidenceLevelI18nForCulture($object, $culture)
  {
    $this->current_i18n[$culture] = $object;
    $this->addResidenceLevelI18n($object);
  }


  public function __call($method, $arguments)
  {
    if (!$callable = sfMixer::getCallable('BaseResidenceLevel:'.$method))
    {
      throw new sfException(sprintf('Call to undefined method BaseResidenceLevel::%s', $method));
    }

    array_unshift($arguments, $this);

    return call_user_func_array($callable, $arguments);
  }


} 