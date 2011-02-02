<?php


abstract class BaseResidence extends BaseObject  implements Persistent {


	
	protected static $peer;


	
	protected $id;


	
	protected $name;


	
	protected $level;


	
	protected $parent;

	
	protected $aResidenceLevel;

	
	protected $collsfGuardUsers;

	
	protected $lastsfGuardUserCriteria = null;

	
	protected $collLokalreaktorResidences;

	
	protected $lastLokalreaktorResidenceCriteria = null;

	
	protected $alreadyInSave = false;

	
	protected $alreadyInValidation = false;

	
	public function getId()
	{

		return $this->id;
	}

	
	public function getName()
	{

		return $this->name;
	}

	
	public function getLevel()
	{

		return $this->level;
	}

	
	public function getParent()
	{

		return $this->parent;
	}

	
	public function setId($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->id !== $v) {
			$this->id = $v;
			$this->modifiedColumns[] = ResidencePeer::ID;
		}

	} 
	
	public function setName($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->name !== $v) {
			$this->name = $v;
			$this->modifiedColumns[] = ResidencePeer::NAME;
		}

	} 
	
	public function setLevel($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->level !== $v) {
			$this->level = $v;
			$this->modifiedColumns[] = ResidencePeer::LEVEL;
		}

		if ($this->aResidenceLevel !== null && $this->aResidenceLevel->getId() !== $v) {
			$this->aResidenceLevel = null;
		}

	} 
	
	public function setParent($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->parent !== $v) {
			$this->parent = $v;
			$this->modifiedColumns[] = ResidencePeer::PARENT;
		}

	} 
	
	public function hydrate(ResultSet $rs, $startcol = 1)
	{
		try {

			$this->id = $rs->getInt($startcol + 0);

			$this->name = $rs->getString($startcol + 1);

			$this->level = $rs->getInt($startcol + 2);

			$this->parent = $rs->getInt($startcol + 3);

			$this->resetModified();

			$this->setNew(false);

						return $startcol + 4; 
		} catch (Exception $e) {
			throw new PropelException("Error populating Residence object", $e);
		}
	}

	
	public function delete($con = null)
	{

    foreach (sfMixer::getCallables('BaseResidence:delete:pre') as $callable)
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
			$con = Propel::getConnection(ResidencePeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			ResidencePeer::doDelete($this, $con);
			$this->setDeleted(true);
			$con->commit();
		} catch (PropelException $e) {
			$con->rollback();
			throw $e;
		}
	

    foreach (sfMixer::getCallables('BaseResidence:delete:post') as $callable)
    {
      call_user_func($callable, $this, $con);
    }

  }
	
	public function save($con = null)
	{

    foreach (sfMixer::getCallables('BaseResidence:save:pre') as $callable)
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
			$con = Propel::getConnection(ResidencePeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			$affectedRows = $this->doSave($con);
			$con->commit();
    foreach (sfMixer::getCallables('BaseResidence:save:post') as $callable)
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


												
			if ($this->aResidenceLevel !== null) {
				if ($this->aResidenceLevel->isModified() || $this->aResidenceLevel->getCurrentResidenceLevelI18n()->isModified()) {
					$affectedRows += $this->aResidenceLevel->save($con);
				}
				$this->setResidenceLevel($this->aResidenceLevel);
			}


						if ($this->isModified()) {
				if ($this->isNew()) {
					$pk = ResidencePeer::doInsert($this, $con);
					$affectedRows += 1; 										 										 
					$this->setId($pk);  
					$this->setNew(false);
				} else {
					$affectedRows += ResidencePeer::doUpdate($this, $con);
				}
				$this->resetModified(); 			}

			if ($this->collsfGuardUsers !== null) {
				foreach($this->collsfGuardUsers as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collLokalreaktorResidences !== null) {
				foreach($this->collLokalreaktorResidences as $referrerFK) {
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


												
			if ($this->aResidenceLevel !== null) {
				if (!$this->aResidenceLevel->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aResidenceLevel->getValidationFailures());
				}
			}


			if (($retval = ResidencePeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}


				if ($this->collsfGuardUsers !== null) {
					foreach($this->collsfGuardUsers as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collLokalreaktorResidences !== null) {
					foreach($this->collLokalreaktorResidences as $referrerFK) {
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
		$pos = ResidencePeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
			case 2:
				return $this->getLevel();
				break;
			case 3:
				return $this->getParent();
				break;
			default:
				return null;
				break;
		} 	}

	
	public function toArray($keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = ResidencePeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getId(),
			$keys[1] => $this->getName(),
			$keys[2] => $this->getLevel(),
			$keys[3] => $this->getParent(),
		);
		return $result;
	}

	
	public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = ResidencePeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
			case 2:
				$this->setLevel($value);
				break;
			case 3:
				$this->setParent($value);
				break;
		} 	}

	
	public function fromArray($arr, $keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = ResidencePeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setName($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setLevel($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setParent($arr[$keys[3]]);
	}

	
	public function buildCriteria()
	{
		$criteria = new Criteria(ResidencePeer::DATABASE_NAME);

		if ($this->isColumnModified(ResidencePeer::ID)) $criteria->add(ResidencePeer::ID, $this->id);
		if ($this->isColumnModified(ResidencePeer::NAME)) $criteria->add(ResidencePeer::NAME, $this->name);
		if ($this->isColumnModified(ResidencePeer::LEVEL)) $criteria->add(ResidencePeer::LEVEL, $this->level);
		if ($this->isColumnModified(ResidencePeer::PARENT)) $criteria->add(ResidencePeer::PARENT, $this->parent);

		return $criteria;
	}

	
	public function buildPkeyCriteria()
	{
		$criteria = new Criteria(ResidencePeer::DATABASE_NAME);

		$criteria->add(ResidencePeer::ID, $this->id);

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

		$copyObj->setLevel($this->level);

		$copyObj->setParent($this->parent);


		if ($deepCopy) {
									$copyObj->setNew(false);

			foreach($this->getsfGuardUsers() as $relObj) {
				$copyObj->addsfGuardUser($relObj->copy($deepCopy));
			}

			foreach($this->getLokalreaktorResidences() as $relObj) {
				$copyObj->addLokalreaktorResidence($relObj->copy($deepCopy));
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
			self::$peer = new ResidencePeer();
		}
		return self::$peer;
	}

	
	public function setResidenceLevel($v)
	{


		if ($v === null) {
			$this->setLevel(NULL);
		} else {
			$this->setLevel($v->getId());
		}


		$this->aResidenceLevel = $v;
	}


	
	public function getResidenceLevel($con = null)
	{
		if ($this->aResidenceLevel === null && ($this->level !== null)) {
						include_once 'lib/model/om/BaseResidenceLevelPeer.php';

			$this->aResidenceLevel = ResidenceLevelPeer::retrieveByPK($this->level, $con);

			
		}
		return $this->aResidenceLevel;
	}

	
	public function initsfGuardUsers()
	{
		if ($this->collsfGuardUsers === null) {
			$this->collsfGuardUsers = array();
		}
	}

	
	public function getsfGuardUsers($criteria = null, $con = null)
	{
				include_once 'plugins/sfGuardPlugin/lib/model/om/BasesfGuardUserPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collsfGuardUsers === null) {
			if ($this->isNew()) {
			   $this->collsfGuardUsers = array();
			} else {

				$criteria->add(sfGuardUserPeer::RESIDENCE_ID, $this->getId());

				sfGuardUserPeer::addSelectColumns($criteria);
				$this->collsfGuardUsers = sfGuardUserPeer::doSelect($criteria, $con);
			}
		} else {
						if (!$this->isNew()) {
												

				$criteria->add(sfGuardUserPeer::RESIDENCE_ID, $this->getId());

				sfGuardUserPeer::addSelectColumns($criteria);
				if (!isset($this->lastsfGuardUserCriteria) || !$this->lastsfGuardUserCriteria->equals($criteria)) {
					$this->collsfGuardUsers = sfGuardUserPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastsfGuardUserCriteria = $criteria;
		return $this->collsfGuardUsers;
	}

	
	public function countsfGuardUsers($criteria = null, $distinct = false, $con = null)
	{
				include_once 'plugins/sfGuardPlugin/lib/model/om/BasesfGuardUserPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(sfGuardUserPeer::RESIDENCE_ID, $this->getId());

		return sfGuardUserPeer::doCount($criteria, $distinct, $con);
	}

	
	public function addsfGuardUser(sfGuardUser $l)
	{
		$this->collsfGuardUsers[] = $l;
		$l->setResidence($this);
	}

	
	public function initLokalreaktorResidences()
	{
		if ($this->collLokalreaktorResidences === null) {
			$this->collLokalreaktorResidences = array();
		}
	}

	
	public function getLokalreaktorResidences($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseLokalreaktorResidencePeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collLokalreaktorResidences === null) {
			if ($this->isNew()) {
			   $this->collLokalreaktorResidences = array();
			} else {

				$criteria->add(LokalreaktorResidencePeer::RESIDENCE_ID, $this->getId());

				LokalreaktorResidencePeer::addSelectColumns($criteria);
				$this->collLokalreaktorResidences = LokalreaktorResidencePeer::doSelect($criteria, $con);
			}
		} else {
						if (!$this->isNew()) {
												

				$criteria->add(LokalreaktorResidencePeer::RESIDENCE_ID, $this->getId());

				LokalreaktorResidencePeer::addSelectColumns($criteria);
				if (!isset($this->lastLokalreaktorResidenceCriteria) || !$this->lastLokalreaktorResidenceCriteria->equals($criteria)) {
					$this->collLokalreaktorResidences = LokalreaktorResidencePeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastLokalreaktorResidenceCriteria = $criteria;
		return $this->collLokalreaktorResidences;
	}

	
	public function countLokalreaktorResidences($criteria = null, $distinct = false, $con = null)
	{
				include_once 'lib/model/om/BaseLokalreaktorResidencePeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(LokalreaktorResidencePeer::RESIDENCE_ID, $this->getId());

		return LokalreaktorResidencePeer::doCount($criteria, $distinct, $con);
	}

	
	public function addLokalreaktorResidence(LokalreaktorResidence $l)
	{
		$this->collLokalreaktorResidences[] = $l;
		$l->setResidence($this);
	}


	
	public function getLokalreaktorResidencesJoinSubreaktor($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseLokalreaktorResidencePeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collLokalreaktorResidences === null) {
			if ($this->isNew()) {
				$this->collLokalreaktorResidences = array();
			} else {

				$criteria->add(LokalreaktorResidencePeer::RESIDENCE_ID, $this->getId());

				$this->collLokalreaktorResidences = LokalreaktorResidencePeer::doSelectJoinSubreaktor($criteria, $con);
			}
		} else {
									
			$criteria->add(LokalreaktorResidencePeer::RESIDENCE_ID, $this->getId());

			if (!isset($this->lastLokalreaktorResidenceCriteria) || !$this->lastLokalreaktorResidenceCriteria->equals($criteria)) {
				$this->collLokalreaktorResidences = LokalreaktorResidencePeer::doSelectJoinSubreaktor($criteria, $con);
			}
		}
		$this->lastLokalreaktorResidenceCriteria = $criteria;

		return $this->collLokalreaktorResidences;
	}


  public function __call($method, $arguments)
  {
    if (!$callable = sfMixer::getCallable('BaseResidence:'.$method))
    {
      throw new sfException(sprintf('Call to undefined method BaseResidence::%s', $method));
    }

    array_unshift($arguments, $this);

    return call_user_func_array($callable, $arguments);
  }


} 