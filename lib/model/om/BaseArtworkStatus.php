<?php


abstract class BaseArtworkStatus extends BaseObject  implements Persistent {


	
	protected static $peer;


	
	protected $id;


	
	protected $name;

	
	protected $collReaktorArtworks;

	
	protected $lastReaktorArtworkCriteria = null;

	
	protected $collArtworkStatusI18ns;

	
	protected $lastArtworkStatusI18nCriteria = null;

	
	protected $collReaktorArtworkHistorys;

	
	protected $lastReaktorArtworkHistoryCriteria = null;

	
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
			$this->modifiedColumns[] = ArtworkStatusPeer::ID;
		}

	} 
	
	public function setName($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->name !== $v) {
			$this->name = $v;
			$this->modifiedColumns[] = ArtworkStatusPeer::NAME;
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
			throw new PropelException("Error populating ArtworkStatus object", $e);
		}
	}

	
	public function delete($con = null)
	{

    foreach (sfMixer::getCallables('BaseArtworkStatus:delete:pre') as $callable)
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
			$con = Propel::getConnection(ArtworkStatusPeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			ArtworkStatusPeer::doDelete($this, $con);
			$this->setDeleted(true);
			$con->commit();
		} catch (PropelException $e) {
			$con->rollback();
			throw $e;
		}
	

    foreach (sfMixer::getCallables('BaseArtworkStatus:delete:post') as $callable)
    {
      call_user_func($callable, $this, $con);
    }

  }
	
	public function save($con = null)
	{

    foreach (sfMixer::getCallables('BaseArtworkStatus:save:pre') as $callable)
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
			$con = Propel::getConnection(ArtworkStatusPeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			$affectedRows = $this->doSave($con);
			$con->commit();
    foreach (sfMixer::getCallables('BaseArtworkStatus:save:post') as $callable)
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
					$pk = ArtworkStatusPeer::doInsert($this, $con);
					$affectedRows += 1; 										 										 
					$this->setId($pk);  
					$this->setNew(false);
				} else {
					$affectedRows += ArtworkStatusPeer::doUpdate($this, $con);
				}
				$this->resetModified(); 			}

			if ($this->collReaktorArtworks !== null) {
				foreach($this->collReaktorArtworks as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collArtworkStatusI18ns !== null) {
				foreach($this->collArtworkStatusI18ns as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collReaktorArtworkHistorys !== null) {
				foreach($this->collReaktorArtworkHistorys as $referrerFK) {
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


			if (($retval = ArtworkStatusPeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}


				if ($this->collReaktorArtworks !== null) {
					foreach($this->collReaktorArtworks as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collArtworkStatusI18ns !== null) {
					foreach($this->collArtworkStatusI18ns as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collReaktorArtworkHistorys !== null) {
					foreach($this->collReaktorArtworkHistorys as $referrerFK) {
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
		$pos = ArtworkStatusPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
		$keys = ArtworkStatusPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getId(),
			$keys[1] => $this->getName(),
		);
		return $result;
	}

	
	public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = ArtworkStatusPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
		$keys = ArtworkStatusPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setName($arr[$keys[1]]);
	}

	
	public function buildCriteria()
	{
		$criteria = new Criteria(ArtworkStatusPeer::DATABASE_NAME);

		if ($this->isColumnModified(ArtworkStatusPeer::ID)) $criteria->add(ArtworkStatusPeer::ID, $this->id);
		if ($this->isColumnModified(ArtworkStatusPeer::NAME)) $criteria->add(ArtworkStatusPeer::NAME, $this->name);

		return $criteria;
	}

	
	public function buildPkeyCriteria()
	{
		$criteria = new Criteria(ArtworkStatusPeer::DATABASE_NAME);

		$criteria->add(ArtworkStatusPeer::ID, $this->id);

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

			foreach($this->getReaktorArtworks() as $relObj) {
				$copyObj->addReaktorArtwork($relObj->copy($deepCopy));
			}

			foreach($this->getArtworkStatusI18ns() as $relObj) {
				$copyObj->addArtworkStatusI18n($relObj->copy($deepCopy));
			}

			foreach($this->getReaktorArtworkHistorys() as $relObj) {
				$copyObj->addReaktorArtworkHistory($relObj->copy($deepCopy));
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
			self::$peer = new ArtworkStatusPeer();
		}
		return self::$peer;
	}

	
	public function initReaktorArtworks()
	{
		if ($this->collReaktorArtworks === null) {
			$this->collReaktorArtworks = array();
		}
	}

	
	public function getReaktorArtworks($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseReaktorArtworkPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collReaktorArtworks === null) {
			if ($this->isNew()) {
			   $this->collReaktorArtworks = array();
			} else {

				$criteria->add(ReaktorArtworkPeer::STATUS, $this->getId());

				ReaktorArtworkPeer::addSelectColumns($criteria);
				$this->collReaktorArtworks = ReaktorArtworkPeer::doSelect($criteria, $con);
			}
		} else {
						if (!$this->isNew()) {
												

				$criteria->add(ReaktorArtworkPeer::STATUS, $this->getId());

				ReaktorArtworkPeer::addSelectColumns($criteria);
				if (!isset($this->lastReaktorArtworkCriteria) || !$this->lastReaktorArtworkCriteria->equals($criteria)) {
					$this->collReaktorArtworks = ReaktorArtworkPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastReaktorArtworkCriteria = $criteria;
		return $this->collReaktorArtworks;
	}

	
	public function countReaktorArtworks($criteria = null, $distinct = false, $con = null)
	{
				include_once 'lib/model/om/BaseReaktorArtworkPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(ReaktorArtworkPeer::STATUS, $this->getId());

		return ReaktorArtworkPeer::doCount($criteria, $distinct, $con);
	}

	
	public function addReaktorArtwork(ReaktorArtwork $l)
	{
		$this->collReaktorArtworks[] = $l;
		$l->setArtworkStatus($this);
	}


	
	public function getReaktorArtworksJoinsfGuardUser($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseReaktorArtworkPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collReaktorArtworks === null) {
			if ($this->isNew()) {
				$this->collReaktorArtworks = array();
			} else {

				$criteria->add(ReaktorArtworkPeer::STATUS, $this->getId());

				$this->collReaktorArtworks = ReaktorArtworkPeer::doSelectJoinsfGuardUser($criteria, $con);
			}
		} else {
									
			$criteria->add(ReaktorArtworkPeer::STATUS, $this->getId());

			if (!isset($this->lastReaktorArtworkCriteria) || !$this->lastReaktorArtworkCriteria->equals($criteria)) {
				$this->collReaktorArtworks = ReaktorArtworkPeer::doSelectJoinsfGuardUser($criteria, $con);
			}
		}
		$this->lastReaktorArtworkCriteria = $criteria;

		return $this->collReaktorArtworks;
	}


	
	public function getReaktorArtworksJoinsfGuardGroup($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseReaktorArtworkPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collReaktorArtworks === null) {
			if ($this->isNew()) {
				$this->collReaktorArtworks = array();
			} else {

				$criteria->add(ReaktorArtworkPeer::STATUS, $this->getId());

				$this->collReaktorArtworks = ReaktorArtworkPeer::doSelectJoinsfGuardGroup($criteria, $con);
			}
		} else {
									
			$criteria->add(ReaktorArtworkPeer::STATUS, $this->getId());

			if (!isset($this->lastReaktorArtworkCriteria) || !$this->lastReaktorArtworkCriteria->equals($criteria)) {
				$this->collReaktorArtworks = ReaktorArtworkPeer::doSelectJoinsfGuardGroup($criteria, $con);
			}
		}
		$this->lastReaktorArtworkCriteria = $criteria;

		return $this->collReaktorArtworks;
	}


	
	public function getReaktorArtworksJoinReaktorFile($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseReaktorArtworkPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collReaktorArtworks === null) {
			if ($this->isNew()) {
				$this->collReaktorArtworks = array();
			} else {

				$criteria->add(ReaktorArtworkPeer::STATUS, $this->getId());

				$this->collReaktorArtworks = ReaktorArtworkPeer::doSelectJoinReaktorFile($criteria, $con);
			}
		} else {
									
			$criteria->add(ReaktorArtworkPeer::STATUS, $this->getId());

			if (!isset($this->lastReaktorArtworkCriteria) || !$this->lastReaktorArtworkCriteria->equals($criteria)) {
				$this->collReaktorArtworks = ReaktorArtworkPeer::doSelectJoinReaktorFile($criteria, $con);
			}
		}
		$this->lastReaktorArtworkCriteria = $criteria;

		return $this->collReaktorArtworks;
	}

	
	public function initArtworkStatusI18ns()
	{
		if ($this->collArtworkStatusI18ns === null) {
			$this->collArtworkStatusI18ns = array();
		}
	}

	
	public function getArtworkStatusI18ns($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseArtworkStatusI18nPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collArtworkStatusI18ns === null) {
			if ($this->isNew()) {
			   $this->collArtworkStatusI18ns = array();
			} else {

				$criteria->add(ArtworkStatusI18nPeer::ID, $this->getId());

				ArtworkStatusI18nPeer::addSelectColumns($criteria);
				$this->collArtworkStatusI18ns = ArtworkStatusI18nPeer::doSelect($criteria, $con);
			}
		} else {
						if (!$this->isNew()) {
												

				$criteria->add(ArtworkStatusI18nPeer::ID, $this->getId());

				ArtworkStatusI18nPeer::addSelectColumns($criteria);
				if (!isset($this->lastArtworkStatusI18nCriteria) || !$this->lastArtworkStatusI18nCriteria->equals($criteria)) {
					$this->collArtworkStatusI18ns = ArtworkStatusI18nPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastArtworkStatusI18nCriteria = $criteria;
		return $this->collArtworkStatusI18ns;
	}

	
	public function countArtworkStatusI18ns($criteria = null, $distinct = false, $con = null)
	{
				include_once 'lib/model/om/BaseArtworkStatusI18nPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(ArtworkStatusI18nPeer::ID, $this->getId());

		return ArtworkStatusI18nPeer::doCount($criteria, $distinct, $con);
	}

	
	public function addArtworkStatusI18n(ArtworkStatusI18n $l)
	{
		$this->collArtworkStatusI18ns[] = $l;
		$l->setArtworkStatus($this);
	}

	
	public function initReaktorArtworkHistorys()
	{
		if ($this->collReaktorArtworkHistorys === null) {
			$this->collReaktorArtworkHistorys = array();
		}
	}

	
	public function getReaktorArtworkHistorys($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseReaktorArtworkHistoryPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collReaktorArtworkHistorys === null) {
			if ($this->isNew()) {
			   $this->collReaktorArtworkHistorys = array();
			} else {

				$criteria->add(ReaktorArtworkHistoryPeer::STATUS, $this->getId());

				ReaktorArtworkHistoryPeer::addSelectColumns($criteria);
				$this->collReaktorArtworkHistorys = ReaktorArtworkHistoryPeer::doSelect($criteria, $con);
			}
		} else {
						if (!$this->isNew()) {
												

				$criteria->add(ReaktorArtworkHistoryPeer::STATUS, $this->getId());

				ReaktorArtworkHistoryPeer::addSelectColumns($criteria);
				if (!isset($this->lastReaktorArtworkHistoryCriteria) || !$this->lastReaktorArtworkHistoryCriteria->equals($criteria)) {
					$this->collReaktorArtworkHistorys = ReaktorArtworkHistoryPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastReaktorArtworkHistoryCriteria = $criteria;
		return $this->collReaktorArtworkHistorys;
	}

	
	public function countReaktorArtworkHistorys($criteria = null, $distinct = false, $con = null)
	{
				include_once 'lib/model/om/BaseReaktorArtworkHistoryPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(ReaktorArtworkHistoryPeer::STATUS, $this->getId());

		return ReaktorArtworkHistoryPeer::doCount($criteria, $distinct, $con);
	}

	
	public function addReaktorArtworkHistory(ReaktorArtworkHistory $l)
	{
		$this->collReaktorArtworkHistorys[] = $l;
		$l->setArtworkStatus($this);
	}


	
	public function getReaktorArtworkHistorysJoinReaktorArtworkRelatedByArtworkId($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseReaktorArtworkHistoryPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collReaktorArtworkHistorys === null) {
			if ($this->isNew()) {
				$this->collReaktorArtworkHistorys = array();
			} else {

				$criteria->add(ReaktorArtworkHistoryPeer::STATUS, $this->getId());

				$this->collReaktorArtworkHistorys = ReaktorArtworkHistoryPeer::doSelectJoinReaktorArtworkRelatedByArtworkId($criteria, $con);
			}
		} else {
									
			$criteria->add(ReaktorArtworkHistoryPeer::STATUS, $this->getId());

			if (!isset($this->lastReaktorArtworkHistoryCriteria) || !$this->lastReaktorArtworkHistoryCriteria->equals($criteria)) {
				$this->collReaktorArtworkHistorys = ReaktorArtworkHistoryPeer::doSelectJoinReaktorArtworkRelatedByArtworkId($criteria, $con);
			}
		}
		$this->lastReaktorArtworkHistoryCriteria = $criteria;

		return $this->collReaktorArtworkHistorys;
	}


	
	public function getReaktorArtworkHistorysJoinReaktorArtworkRelatedByFileId($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseReaktorArtworkHistoryPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collReaktorArtworkHistorys === null) {
			if ($this->isNew()) {
				$this->collReaktorArtworkHistorys = array();
			} else {

				$criteria->add(ReaktorArtworkHistoryPeer::STATUS, $this->getId());

				$this->collReaktorArtworkHistorys = ReaktorArtworkHistoryPeer::doSelectJoinReaktorArtworkRelatedByFileId($criteria, $con);
			}
		} else {
									
			$criteria->add(ReaktorArtworkHistoryPeer::STATUS, $this->getId());

			if (!isset($this->lastReaktorArtworkHistoryCriteria) || !$this->lastReaktorArtworkHistoryCriteria->equals($criteria)) {
				$this->collReaktorArtworkHistorys = ReaktorArtworkHistoryPeer::doSelectJoinReaktorArtworkRelatedByFileId($criteria, $con);
			}
		}
		$this->lastReaktorArtworkHistoryCriteria = $criteria;

		return $this->collReaktorArtworkHistorys;
	}


	
	public function getReaktorArtworkHistorysJoinsfGuardUser($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseReaktorArtworkHistoryPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collReaktorArtworkHistorys === null) {
			if ($this->isNew()) {
				$this->collReaktorArtworkHistorys = array();
			} else {

				$criteria->add(ReaktorArtworkHistoryPeer::STATUS, $this->getId());

				$this->collReaktorArtworkHistorys = ReaktorArtworkHistoryPeer::doSelectJoinsfGuardUser($criteria, $con);
			}
		} else {
									
			$criteria->add(ReaktorArtworkHistoryPeer::STATUS, $this->getId());

			if (!isset($this->lastReaktorArtworkHistoryCriteria) || !$this->lastReaktorArtworkHistoryCriteria->equals($criteria)) {
				$this->collReaktorArtworkHistorys = ReaktorArtworkHistoryPeer::doSelectJoinsfGuardUser($criteria, $con);
			}
		}
		$this->lastReaktorArtworkHistoryCriteria = $criteria;

		return $this->collReaktorArtworkHistorys;
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
    $obj = $this->getCurrentArtworkStatusI18n();

    return ($obj ? $obj->getDescription() : null);
  }

  public function setDescription($value)
  {
    $this->getCurrentArtworkStatusI18n()->setDescription($value);
  }

  protected $current_i18n = array();

  public function getCurrentArtworkStatusI18n()
  {
    if (!isset($this->current_i18n[$this->culture]))
    {
      $obj = ArtworkStatusI18nPeer::retrieveByPK($this->getId(), $this->culture);
      if ($obj)
      {
        $this->setArtworkStatusI18nForCulture($obj, $this->culture);
      }
      else
      {
        $this->setArtworkStatusI18nForCulture(new ArtworkStatusI18n(), $this->culture);
        $this->current_i18n[$this->culture]->setCulture($this->culture);
      }
    }

    return $this->current_i18n[$this->culture];
  }

  public function setArtworkStatusI18nForCulture($object, $culture)
  {
    $this->current_i18n[$culture] = $object;
    $this->addArtworkStatusI18n($object);
  }


  public function __call($method, $arguments)
  {
    if (!$callable = sfMixer::getCallable('BaseArtworkStatus:'.$method))
    {
      throw new sfException(sprintf('Call to undefined method BaseArtworkStatus::%s', $method));
    }

    array_unshift($arguments, $this);

    return call_user_func_array($callable, $arguments);
  }


} 