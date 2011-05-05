<?php


abstract class BaseSubreaktor extends BaseObject  implements Persistent {


	
	protected static $peer;


	
	protected $id;


	
	protected $reference;


	
	protected $lokalreaktor = false;


	
	protected $live = false;


	
	protected $subreaktor_order = 0;

	
	protected $collUserInterests;

	
	protected $lastUserInterestCriteria = null;

	
	protected $collRecommendedArtworksRelatedBySubreaktor;

	
	protected $lastRecommendedArtworkRelatedBySubreaktorCriteria = null;

	
	protected $collRecommendedArtworksRelatedByLocalsubreaktor;

	
	protected $lastRecommendedArtworkRelatedByLocalsubreaktorCriteria = null;

	
	protected $collArticleSubreaktors;

	
	protected $lastArticleSubreaktorCriteria = null;

	
	protected $collLokalreaktorArtworks;

	
	protected $lastLokalreaktorArtworkCriteria = null;

	
	protected $collLokalreaktorResidences;

	
	protected $lastLokalreaktorResidenceCriteria = null;

	
	protected $collSubreaktorIdentifiers;

	
	protected $lastSubreaktorIdentifierCriteria = null;

	
	protected $collCategorySubreaktors;

	
	protected $lastCategorySubreaktorCriteria = null;

	
	protected $collSubreaktorI18ns;

	
	protected $lastSubreaktorI18nCriteria = null;

	
	protected $collSubreaktorArtworks;

	
	protected $lastSubreaktorArtworkCriteria = null;

	
	protected $alreadyInSave = false;

	
	protected $alreadyInValidation = false;

  
  protected $culture;

	
	public function getId()
	{

		return $this->id;
	}

	
	public function getReference()
	{

		return $this->reference;
	}

	
	public function getLokalreaktor()
	{

		return $this->lokalreaktor;
	}

	
	public function getLive()
	{

		return $this->live;
	}

	
	public function getSubreaktorOrder()
	{

		return $this->subreaktor_order;
	}

	
	public function setId($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->id !== $v) {
			$this->id = $v;
			$this->modifiedColumns[] = SubreaktorPeer::ID;
		}

	} 
	
	public function setReference($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->reference !== $v) {
			$this->reference = $v;
			$this->modifiedColumns[] = SubreaktorPeer::REFERENCE;
		}

	} 
	
	public function setLokalreaktor($v)
	{

		if ($this->lokalreaktor !== $v || $v === false) {
			$this->lokalreaktor = $v;
			$this->modifiedColumns[] = SubreaktorPeer::LOKALREAKTOR;
		}

	} 
	
	public function setLive($v)
	{

		if ($this->live !== $v || $v === false) {
			$this->live = $v;
			$this->modifiedColumns[] = SubreaktorPeer::LIVE;
		}

	} 
	
	public function setSubreaktorOrder($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->subreaktor_order !== $v || $v === 0) {
			$this->subreaktor_order = $v;
			$this->modifiedColumns[] = SubreaktorPeer::SUBREAKTOR_ORDER;
		}

	} 
	
	public function hydrate(ResultSet $rs, $startcol = 1)
	{
		try {

			$this->id = $rs->getInt($startcol + 0);

			$this->reference = $rs->getString($startcol + 1);

			$this->lokalreaktor = $rs->getBoolean($startcol + 2);

			$this->live = $rs->getBoolean($startcol + 3);

			$this->subreaktor_order = $rs->getInt($startcol + 4);

			$this->resetModified();

			$this->setNew(false);

						return $startcol + 5; 
		} catch (Exception $e) {
			throw new PropelException("Error populating Subreaktor object", $e);
		}
	}

	
	public function delete($con = null)
	{

    foreach (sfMixer::getCallables('BaseSubreaktor:delete:pre') as $callable)
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
			$con = Propel::getConnection(SubreaktorPeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			SubreaktorPeer::doDelete($this, $con);
			$this->setDeleted(true);
			$con->commit();
		} catch (PropelException $e) {
			$con->rollback();
			throw $e;
		}
	

    foreach (sfMixer::getCallables('BaseSubreaktor:delete:post') as $callable)
    {
      call_user_func($callable, $this, $con);
    }

  }
	
	public function save($con = null)
	{

    foreach (sfMixer::getCallables('BaseSubreaktor:save:pre') as $callable)
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
			$con = Propel::getConnection(SubreaktorPeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			$affectedRows = $this->doSave($con);
			$con->commit();
    foreach (sfMixer::getCallables('BaseSubreaktor:save:post') as $callable)
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
					$pk = SubreaktorPeer::doInsert($this, $con);
					$affectedRows += 1; 										 										 
					$this->setId($pk);  
					$this->setNew(false);
				} else {
					$affectedRows += SubreaktorPeer::doUpdate($this, $con);
				}
				$this->resetModified(); 			}

			if ($this->collUserInterests !== null) {
				foreach($this->collUserInterests as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collRecommendedArtworksRelatedBySubreaktor !== null) {
				foreach($this->collRecommendedArtworksRelatedBySubreaktor as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collRecommendedArtworksRelatedByLocalsubreaktor !== null) {
				foreach($this->collRecommendedArtworksRelatedByLocalsubreaktor as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collArticleSubreaktors !== null) {
				foreach($this->collArticleSubreaktors as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collLokalreaktorArtworks !== null) {
				foreach($this->collLokalreaktorArtworks as $referrerFK) {
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

			if ($this->collSubreaktorIdentifiers !== null) {
				foreach($this->collSubreaktorIdentifiers as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collCategorySubreaktors !== null) {
				foreach($this->collCategorySubreaktors as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collSubreaktorI18ns !== null) {
				foreach($this->collSubreaktorI18ns as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collSubreaktorArtworks !== null) {
				foreach($this->collSubreaktorArtworks as $referrerFK) {
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


			if (($retval = SubreaktorPeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}


				if ($this->collUserInterests !== null) {
					foreach($this->collUserInterests as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collRecommendedArtworksRelatedBySubreaktor !== null) {
					foreach($this->collRecommendedArtworksRelatedBySubreaktor as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collRecommendedArtworksRelatedByLocalsubreaktor !== null) {
					foreach($this->collRecommendedArtworksRelatedByLocalsubreaktor as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collArticleSubreaktors !== null) {
					foreach($this->collArticleSubreaktors as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collLokalreaktorArtworks !== null) {
					foreach($this->collLokalreaktorArtworks as $referrerFK) {
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

				if ($this->collSubreaktorIdentifiers !== null) {
					foreach($this->collSubreaktorIdentifiers as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collCategorySubreaktors !== null) {
					foreach($this->collCategorySubreaktors as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collSubreaktorI18ns !== null) {
					foreach($this->collSubreaktorI18ns as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collSubreaktorArtworks !== null) {
					foreach($this->collSubreaktorArtworks as $referrerFK) {
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
		$pos = SubreaktorPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->getByPosition($pos);
	}

	
	public function getByPosition($pos)
	{
		switch($pos) {
			case 0:
				return $this->getId();
				break;
			case 1:
				return $this->getReference();
				break;
			case 2:
				return $this->getLokalreaktor();
				break;
			case 3:
				return $this->getLive();
				break;
			case 4:
				return $this->getSubreaktorOrder();
				break;
			default:
				return null;
				break;
		} 	}

	
	public function toArray($keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = SubreaktorPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getId(),
			$keys[1] => $this->getReference(),
			$keys[2] => $this->getLokalreaktor(),
			$keys[3] => $this->getLive(),
			$keys[4] => $this->getSubreaktorOrder(),
		);
		return $result;
	}

	
	public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = SubreaktorPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->setByPosition($pos, $value);
	}

	
	public function setByPosition($pos, $value)
	{
		switch($pos) {
			case 0:
				$this->setId($value);
				break;
			case 1:
				$this->setReference($value);
				break;
			case 2:
				$this->setLokalreaktor($value);
				break;
			case 3:
				$this->setLive($value);
				break;
			case 4:
				$this->setSubreaktorOrder($value);
				break;
		} 	}

	
	public function fromArray($arr, $keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = SubreaktorPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setReference($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setLokalreaktor($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setLive($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setSubreaktorOrder($arr[$keys[4]]);
	}

	
	public function buildCriteria()
	{
		$criteria = new Criteria(SubreaktorPeer::DATABASE_NAME);

		if ($this->isColumnModified(SubreaktorPeer::ID)) $criteria->add(SubreaktorPeer::ID, $this->id);
		if ($this->isColumnModified(SubreaktorPeer::REFERENCE)) $criteria->add(SubreaktorPeer::REFERENCE, $this->reference);
		if ($this->isColumnModified(SubreaktorPeer::LOKALREAKTOR)) $criteria->add(SubreaktorPeer::LOKALREAKTOR, $this->lokalreaktor);
		if ($this->isColumnModified(SubreaktorPeer::LIVE)) $criteria->add(SubreaktorPeer::LIVE, $this->live);
		if ($this->isColumnModified(SubreaktorPeer::SUBREAKTOR_ORDER)) $criteria->add(SubreaktorPeer::SUBREAKTOR_ORDER, $this->subreaktor_order);

		return $criteria;
	}

	
	public function buildPkeyCriteria()
	{
		$criteria = new Criteria(SubreaktorPeer::DATABASE_NAME);

		$criteria->add(SubreaktorPeer::ID, $this->id);

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

		$copyObj->setReference($this->reference);

		$copyObj->setLokalreaktor($this->lokalreaktor);

		$copyObj->setLive($this->live);

		$copyObj->setSubreaktorOrder($this->subreaktor_order);


		if ($deepCopy) {
									$copyObj->setNew(false);

			foreach($this->getUserInterests() as $relObj) {
				$copyObj->addUserInterest($relObj->copy($deepCopy));
			}

			foreach($this->getRecommendedArtworksRelatedBySubreaktor() as $relObj) {
				$copyObj->addRecommendedArtworkRelatedBySubreaktor($relObj->copy($deepCopy));
			}

			foreach($this->getRecommendedArtworksRelatedByLocalsubreaktor() as $relObj) {
				$copyObj->addRecommendedArtworkRelatedByLocalsubreaktor($relObj->copy($deepCopy));
			}

			foreach($this->getArticleSubreaktors() as $relObj) {
				$copyObj->addArticleSubreaktor($relObj->copy($deepCopy));
			}

			foreach($this->getLokalreaktorArtworks() as $relObj) {
				$copyObj->addLokalreaktorArtwork($relObj->copy($deepCopy));
			}

			foreach($this->getLokalreaktorResidences() as $relObj) {
				$copyObj->addLokalreaktorResidence($relObj->copy($deepCopy));
			}

			foreach($this->getSubreaktorIdentifiers() as $relObj) {
				$copyObj->addSubreaktorIdentifier($relObj->copy($deepCopy));
			}

			foreach($this->getCategorySubreaktors() as $relObj) {
				$copyObj->addCategorySubreaktor($relObj->copy($deepCopy));
			}

			foreach($this->getSubreaktorI18ns() as $relObj) {
				$copyObj->addSubreaktorI18n($relObj->copy($deepCopy));
			}

			foreach($this->getSubreaktorArtworks() as $relObj) {
				$copyObj->addSubreaktorArtwork($relObj->copy($deepCopy));
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
			self::$peer = new SubreaktorPeer();
		}
		return self::$peer;
	}

	
	public function initUserInterests()
	{
		if ($this->collUserInterests === null) {
			$this->collUserInterests = array();
		}
	}

	
	public function getUserInterests($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseUserInterestPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collUserInterests === null) {
			if ($this->isNew()) {
			   $this->collUserInterests = array();
			} else {

				$criteria->add(UserInterestPeer::SUBREAKTOR_ID, $this->getId());

				UserInterestPeer::addSelectColumns($criteria);
				$this->collUserInterests = UserInterestPeer::doSelect($criteria, $con);
			}
		} else {
						if (!$this->isNew()) {
												

				$criteria->add(UserInterestPeer::SUBREAKTOR_ID, $this->getId());

				UserInterestPeer::addSelectColumns($criteria);
				if (!isset($this->lastUserInterestCriteria) || !$this->lastUserInterestCriteria->equals($criteria)) {
					$this->collUserInterests = UserInterestPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastUserInterestCriteria = $criteria;
		return $this->collUserInterests;
	}

	
	public function countUserInterests($criteria = null, $distinct = false, $con = null)
	{
				include_once 'lib/model/om/BaseUserInterestPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(UserInterestPeer::SUBREAKTOR_ID, $this->getId());

		return UserInterestPeer::doCount($criteria, $distinct, $con);
	}

	
	public function addUserInterest(UserInterest $l)
	{
		$this->collUserInterests[] = $l;
		$l->setSubreaktor($this);
	}


	
	public function getUserInterestsJoinsfGuardUser($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseUserInterestPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collUserInterests === null) {
			if ($this->isNew()) {
				$this->collUserInterests = array();
			} else {

				$criteria->add(UserInterestPeer::SUBREAKTOR_ID, $this->getId());

				$this->collUserInterests = UserInterestPeer::doSelectJoinsfGuardUser($criteria, $con);
			}
		} else {
									
			$criteria->add(UserInterestPeer::SUBREAKTOR_ID, $this->getId());

			if (!isset($this->lastUserInterestCriteria) || !$this->lastUserInterestCriteria->equals($criteria)) {
				$this->collUserInterests = UserInterestPeer::doSelectJoinsfGuardUser($criteria, $con);
			}
		}
		$this->lastUserInterestCriteria = $criteria;

		return $this->collUserInterests;
	}

	
	public function initRecommendedArtworksRelatedBySubreaktor()
	{
		if ($this->collRecommendedArtworksRelatedBySubreaktor === null) {
			$this->collRecommendedArtworksRelatedBySubreaktor = array();
		}
	}

	
	public function getRecommendedArtworksRelatedBySubreaktor($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseRecommendedArtworkPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collRecommendedArtworksRelatedBySubreaktor === null) {
			if ($this->isNew()) {
			   $this->collRecommendedArtworksRelatedBySubreaktor = array();
			} else {

				$criteria->add(RecommendedArtworkPeer::SUBREAKTOR, $this->getId());

				RecommendedArtworkPeer::addSelectColumns($criteria);
				$this->collRecommendedArtworksRelatedBySubreaktor = RecommendedArtworkPeer::doSelect($criteria, $con);
			}
		} else {
						if (!$this->isNew()) {
												

				$criteria->add(RecommendedArtworkPeer::SUBREAKTOR, $this->getId());

				RecommendedArtworkPeer::addSelectColumns($criteria);
				if (!isset($this->lastRecommendedArtworkRelatedBySubreaktorCriteria) || !$this->lastRecommendedArtworkRelatedBySubreaktorCriteria->equals($criteria)) {
					$this->collRecommendedArtworksRelatedBySubreaktor = RecommendedArtworkPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastRecommendedArtworkRelatedBySubreaktorCriteria = $criteria;
		return $this->collRecommendedArtworksRelatedBySubreaktor;
	}

	
	public function countRecommendedArtworksRelatedBySubreaktor($criteria = null, $distinct = false, $con = null)
	{
				include_once 'lib/model/om/BaseRecommendedArtworkPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(RecommendedArtworkPeer::SUBREAKTOR, $this->getId());

		return RecommendedArtworkPeer::doCount($criteria, $distinct, $con);
	}

	
	public function addRecommendedArtworkRelatedBySubreaktor(RecommendedArtwork $l)
	{
		$this->collRecommendedArtworksRelatedBySubreaktor[] = $l;
		$l->setSubreaktorRelatedBySubreaktor($this);
	}


	
	public function getRecommendedArtworksRelatedBySubreaktorJoinReaktorArtwork($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseRecommendedArtworkPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collRecommendedArtworksRelatedBySubreaktor === null) {
			if ($this->isNew()) {
				$this->collRecommendedArtworksRelatedBySubreaktor = array();
			} else {

				$criteria->add(RecommendedArtworkPeer::SUBREAKTOR, $this->getId());

				$this->collRecommendedArtworksRelatedBySubreaktor = RecommendedArtworkPeer::doSelectJoinReaktorArtwork($criteria, $con);
			}
		} else {
									
			$criteria->add(RecommendedArtworkPeer::SUBREAKTOR, $this->getId());

			if (!isset($this->lastRecommendedArtworkRelatedBySubreaktorCriteria) || !$this->lastRecommendedArtworkRelatedBySubreaktorCriteria->equals($criteria)) {
				$this->collRecommendedArtworksRelatedBySubreaktor = RecommendedArtworkPeer::doSelectJoinReaktorArtwork($criteria, $con);
			}
		}
		$this->lastRecommendedArtworkRelatedBySubreaktorCriteria = $criteria;

		return $this->collRecommendedArtworksRelatedBySubreaktor;
	}


	
	public function getRecommendedArtworksRelatedBySubreaktorJoinsfGuardUser($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseRecommendedArtworkPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collRecommendedArtworksRelatedBySubreaktor === null) {
			if ($this->isNew()) {
				$this->collRecommendedArtworksRelatedBySubreaktor = array();
			} else {

				$criteria->add(RecommendedArtworkPeer::SUBREAKTOR, $this->getId());

				$this->collRecommendedArtworksRelatedBySubreaktor = RecommendedArtworkPeer::doSelectJoinsfGuardUser($criteria, $con);
			}
		} else {
									
			$criteria->add(RecommendedArtworkPeer::SUBREAKTOR, $this->getId());

			if (!isset($this->lastRecommendedArtworkRelatedBySubreaktorCriteria) || !$this->lastRecommendedArtworkRelatedBySubreaktorCriteria->equals($criteria)) {
				$this->collRecommendedArtworksRelatedBySubreaktor = RecommendedArtworkPeer::doSelectJoinsfGuardUser($criteria, $con);
			}
		}
		$this->lastRecommendedArtworkRelatedBySubreaktorCriteria = $criteria;

		return $this->collRecommendedArtworksRelatedBySubreaktor;
	}

	
	public function initRecommendedArtworksRelatedByLocalsubreaktor()
	{
		if ($this->collRecommendedArtworksRelatedByLocalsubreaktor === null) {
			$this->collRecommendedArtworksRelatedByLocalsubreaktor = array();
		}
	}

	
	public function getRecommendedArtworksRelatedByLocalsubreaktor($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseRecommendedArtworkPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collRecommendedArtworksRelatedByLocalsubreaktor === null) {
			if ($this->isNew()) {
			   $this->collRecommendedArtworksRelatedByLocalsubreaktor = array();
			} else {

				$criteria->add(RecommendedArtworkPeer::LOCALSUBREAKTOR, $this->getId());

				RecommendedArtworkPeer::addSelectColumns($criteria);
				$this->collRecommendedArtworksRelatedByLocalsubreaktor = RecommendedArtworkPeer::doSelect($criteria, $con);
			}
		} else {
						if (!$this->isNew()) {
												

				$criteria->add(RecommendedArtworkPeer::LOCALSUBREAKTOR, $this->getId());

				RecommendedArtworkPeer::addSelectColumns($criteria);
				if (!isset($this->lastRecommendedArtworkRelatedByLocalsubreaktorCriteria) || !$this->lastRecommendedArtworkRelatedByLocalsubreaktorCriteria->equals($criteria)) {
					$this->collRecommendedArtworksRelatedByLocalsubreaktor = RecommendedArtworkPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastRecommendedArtworkRelatedByLocalsubreaktorCriteria = $criteria;
		return $this->collRecommendedArtworksRelatedByLocalsubreaktor;
	}

	
	public function countRecommendedArtworksRelatedByLocalsubreaktor($criteria = null, $distinct = false, $con = null)
	{
				include_once 'lib/model/om/BaseRecommendedArtworkPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(RecommendedArtworkPeer::LOCALSUBREAKTOR, $this->getId());

		return RecommendedArtworkPeer::doCount($criteria, $distinct, $con);
	}

	
	public function addRecommendedArtworkRelatedByLocalsubreaktor(RecommendedArtwork $l)
	{
		$this->collRecommendedArtworksRelatedByLocalsubreaktor[] = $l;
		$l->setSubreaktorRelatedByLocalsubreaktor($this);
	}


	
	public function getRecommendedArtworksRelatedByLocalsubreaktorJoinReaktorArtwork($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseRecommendedArtworkPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collRecommendedArtworksRelatedByLocalsubreaktor === null) {
			if ($this->isNew()) {
				$this->collRecommendedArtworksRelatedByLocalsubreaktor = array();
			} else {

				$criteria->add(RecommendedArtworkPeer::LOCALSUBREAKTOR, $this->getId());

				$this->collRecommendedArtworksRelatedByLocalsubreaktor = RecommendedArtworkPeer::doSelectJoinReaktorArtwork($criteria, $con);
			}
		} else {
									
			$criteria->add(RecommendedArtworkPeer::LOCALSUBREAKTOR, $this->getId());

			if (!isset($this->lastRecommendedArtworkRelatedByLocalsubreaktorCriteria) || !$this->lastRecommendedArtworkRelatedByLocalsubreaktorCriteria->equals($criteria)) {
				$this->collRecommendedArtworksRelatedByLocalsubreaktor = RecommendedArtworkPeer::doSelectJoinReaktorArtwork($criteria, $con);
			}
		}
		$this->lastRecommendedArtworkRelatedByLocalsubreaktorCriteria = $criteria;

		return $this->collRecommendedArtworksRelatedByLocalsubreaktor;
	}


	
	public function getRecommendedArtworksRelatedByLocalsubreaktorJoinsfGuardUser($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseRecommendedArtworkPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collRecommendedArtworksRelatedByLocalsubreaktor === null) {
			if ($this->isNew()) {
				$this->collRecommendedArtworksRelatedByLocalsubreaktor = array();
			} else {

				$criteria->add(RecommendedArtworkPeer::LOCALSUBREAKTOR, $this->getId());

				$this->collRecommendedArtworksRelatedByLocalsubreaktor = RecommendedArtworkPeer::doSelectJoinsfGuardUser($criteria, $con);
			}
		} else {
									
			$criteria->add(RecommendedArtworkPeer::LOCALSUBREAKTOR, $this->getId());

			if (!isset($this->lastRecommendedArtworkRelatedByLocalsubreaktorCriteria) || !$this->lastRecommendedArtworkRelatedByLocalsubreaktorCriteria->equals($criteria)) {
				$this->collRecommendedArtworksRelatedByLocalsubreaktor = RecommendedArtworkPeer::doSelectJoinsfGuardUser($criteria, $con);
			}
		}
		$this->lastRecommendedArtworkRelatedByLocalsubreaktorCriteria = $criteria;

		return $this->collRecommendedArtworksRelatedByLocalsubreaktor;
	}

	
	public function initArticleSubreaktors()
	{
		if ($this->collArticleSubreaktors === null) {
			$this->collArticleSubreaktors = array();
		}
	}

	
	public function getArticleSubreaktors($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseArticleSubreaktorPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collArticleSubreaktors === null) {
			if ($this->isNew()) {
			   $this->collArticleSubreaktors = array();
			} else {

				$criteria->add(ArticleSubreaktorPeer::SUBREAKTOR_ID, $this->getId());

				ArticleSubreaktorPeer::addSelectColumns($criteria);
				$this->collArticleSubreaktors = ArticleSubreaktorPeer::doSelect($criteria, $con);
			}
		} else {
						if (!$this->isNew()) {
												

				$criteria->add(ArticleSubreaktorPeer::SUBREAKTOR_ID, $this->getId());

				ArticleSubreaktorPeer::addSelectColumns($criteria);
				if (!isset($this->lastArticleSubreaktorCriteria) || !$this->lastArticleSubreaktorCriteria->equals($criteria)) {
					$this->collArticleSubreaktors = ArticleSubreaktorPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastArticleSubreaktorCriteria = $criteria;
		return $this->collArticleSubreaktors;
	}

	
	public function countArticleSubreaktors($criteria = null, $distinct = false, $con = null)
	{
				include_once 'lib/model/om/BaseArticleSubreaktorPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(ArticleSubreaktorPeer::SUBREAKTOR_ID, $this->getId());

		return ArticleSubreaktorPeer::doCount($criteria, $distinct, $con);
	}

	
	public function addArticleSubreaktor(ArticleSubreaktor $l)
	{
		$this->collArticleSubreaktors[] = $l;
		$l->setSubreaktor($this);
	}


	
	public function getArticleSubreaktorsJoinArticle($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseArticleSubreaktorPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collArticleSubreaktors === null) {
			if ($this->isNew()) {
				$this->collArticleSubreaktors = array();
			} else {

				$criteria->add(ArticleSubreaktorPeer::SUBREAKTOR_ID, $this->getId());

				$this->collArticleSubreaktors = ArticleSubreaktorPeer::doSelectJoinArticle($criteria, $con);
			}
		} else {
									
			$criteria->add(ArticleSubreaktorPeer::SUBREAKTOR_ID, $this->getId());

			if (!isset($this->lastArticleSubreaktorCriteria) || !$this->lastArticleSubreaktorCriteria->equals($criteria)) {
				$this->collArticleSubreaktors = ArticleSubreaktorPeer::doSelectJoinArticle($criteria, $con);
			}
		}
		$this->lastArticleSubreaktorCriteria = $criteria;

		return $this->collArticleSubreaktors;
	}

	
	public function initLokalreaktorArtworks()
	{
		if ($this->collLokalreaktorArtworks === null) {
			$this->collLokalreaktorArtworks = array();
		}
	}

	
	public function getLokalreaktorArtworks($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseLokalreaktorArtworkPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collLokalreaktorArtworks === null) {
			if ($this->isNew()) {
			   $this->collLokalreaktorArtworks = array();
			} else {

				$criteria->add(LokalreaktorArtworkPeer::SUBREAKTOR_ID, $this->getId());

				LokalreaktorArtworkPeer::addSelectColumns($criteria);
				$this->collLokalreaktorArtworks = LokalreaktorArtworkPeer::doSelect($criteria, $con);
			}
		} else {
						if (!$this->isNew()) {
												

				$criteria->add(LokalreaktorArtworkPeer::SUBREAKTOR_ID, $this->getId());

				LokalreaktorArtworkPeer::addSelectColumns($criteria);
				if (!isset($this->lastLokalreaktorArtworkCriteria) || !$this->lastLokalreaktorArtworkCriteria->equals($criteria)) {
					$this->collLokalreaktorArtworks = LokalreaktorArtworkPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastLokalreaktorArtworkCriteria = $criteria;
		return $this->collLokalreaktorArtworks;
	}

	
	public function countLokalreaktorArtworks($criteria = null, $distinct = false, $con = null)
	{
				include_once 'lib/model/om/BaseLokalreaktorArtworkPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(LokalreaktorArtworkPeer::SUBREAKTOR_ID, $this->getId());

		return LokalreaktorArtworkPeer::doCount($criteria, $distinct, $con);
	}

	
	public function addLokalreaktorArtwork(LokalreaktorArtwork $l)
	{
		$this->collLokalreaktorArtworks[] = $l;
		$l->setSubreaktor($this);
	}


	
	public function getLokalreaktorArtworksJoinReaktorArtwork($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseLokalreaktorArtworkPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collLokalreaktorArtworks === null) {
			if ($this->isNew()) {
				$this->collLokalreaktorArtworks = array();
			} else {

				$criteria->add(LokalreaktorArtworkPeer::SUBREAKTOR_ID, $this->getId());

				$this->collLokalreaktorArtworks = LokalreaktorArtworkPeer::doSelectJoinReaktorArtwork($criteria, $con);
			}
		} else {
									
			$criteria->add(LokalreaktorArtworkPeer::SUBREAKTOR_ID, $this->getId());

			if (!isset($this->lastLokalreaktorArtworkCriteria) || !$this->lastLokalreaktorArtworkCriteria->equals($criteria)) {
				$this->collLokalreaktorArtworks = LokalreaktorArtworkPeer::doSelectJoinReaktorArtwork($criteria, $con);
			}
		}
		$this->lastLokalreaktorArtworkCriteria = $criteria;

		return $this->collLokalreaktorArtworks;
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

				$criteria->add(LokalreaktorResidencePeer::SUBREAKTOR_ID, $this->getId());

				LokalreaktorResidencePeer::addSelectColumns($criteria);
				$this->collLokalreaktorResidences = LokalreaktorResidencePeer::doSelect($criteria, $con);
			}
		} else {
						if (!$this->isNew()) {
												

				$criteria->add(LokalreaktorResidencePeer::SUBREAKTOR_ID, $this->getId());

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

		$criteria->add(LokalreaktorResidencePeer::SUBREAKTOR_ID, $this->getId());

		return LokalreaktorResidencePeer::doCount($criteria, $distinct, $con);
	}

	
	public function addLokalreaktorResidence(LokalreaktorResidence $l)
	{
		$this->collLokalreaktorResidences[] = $l;
		$l->setSubreaktor($this);
	}


	
	public function getLokalreaktorResidencesJoinResidence($criteria = null, $con = null)
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

				$criteria->add(LokalreaktorResidencePeer::SUBREAKTOR_ID, $this->getId());

				$this->collLokalreaktorResidences = LokalreaktorResidencePeer::doSelectJoinResidence($criteria, $con);
			}
		} else {
									
			$criteria->add(LokalreaktorResidencePeer::SUBREAKTOR_ID, $this->getId());

			if (!isset($this->lastLokalreaktorResidenceCriteria) || !$this->lastLokalreaktorResidenceCriteria->equals($criteria)) {
				$this->collLokalreaktorResidences = LokalreaktorResidencePeer::doSelectJoinResidence($criteria, $con);
			}
		}
		$this->lastLokalreaktorResidenceCriteria = $criteria;

		return $this->collLokalreaktorResidences;
	}

	
	public function initSubreaktorIdentifiers()
	{
		if ($this->collSubreaktorIdentifiers === null) {
			$this->collSubreaktorIdentifiers = array();
		}
	}

	
	public function getSubreaktorIdentifiers($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseSubreaktorIdentifierPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collSubreaktorIdentifiers === null) {
			if ($this->isNew()) {
			   $this->collSubreaktorIdentifiers = array();
			} else {

				$criteria->add(SubreaktorIdentifierPeer::SUBREAKTOR_ID, $this->getId());

				SubreaktorIdentifierPeer::addSelectColumns($criteria);
				$this->collSubreaktorIdentifiers = SubreaktorIdentifierPeer::doSelect($criteria, $con);
			}
		} else {
						if (!$this->isNew()) {
												

				$criteria->add(SubreaktorIdentifierPeer::SUBREAKTOR_ID, $this->getId());

				SubreaktorIdentifierPeer::addSelectColumns($criteria);
				if (!isset($this->lastSubreaktorIdentifierCriteria) || !$this->lastSubreaktorIdentifierCriteria->equals($criteria)) {
					$this->collSubreaktorIdentifiers = SubreaktorIdentifierPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastSubreaktorIdentifierCriteria = $criteria;
		return $this->collSubreaktorIdentifiers;
	}

	
	public function countSubreaktorIdentifiers($criteria = null, $distinct = false, $con = null)
	{
				include_once 'lib/model/om/BaseSubreaktorIdentifierPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(SubreaktorIdentifierPeer::SUBREAKTOR_ID, $this->getId());

		return SubreaktorIdentifierPeer::doCount($criteria, $distinct, $con);
	}

	
	public function addSubreaktorIdentifier(SubreaktorIdentifier $l)
	{
		$this->collSubreaktorIdentifiers[] = $l;
		$l->setSubreaktor($this);
	}

	
	public function initCategorySubreaktors()
	{
		if ($this->collCategorySubreaktors === null) {
			$this->collCategorySubreaktors = array();
		}
	}

	
	public function getCategorySubreaktors($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseCategorySubreaktorPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collCategorySubreaktors === null) {
			if ($this->isNew()) {
			   $this->collCategorySubreaktors = array();
			} else {

				$criteria->add(CategorySubreaktorPeer::SUBREAKTOR_ID, $this->getId());

				CategorySubreaktorPeer::addSelectColumns($criteria);
				$this->collCategorySubreaktors = CategorySubreaktorPeer::doSelect($criteria, $con);
			}
		} else {
						if (!$this->isNew()) {
												

				$criteria->add(CategorySubreaktorPeer::SUBREAKTOR_ID, $this->getId());

				CategorySubreaktorPeer::addSelectColumns($criteria);
				if (!isset($this->lastCategorySubreaktorCriteria) || !$this->lastCategorySubreaktorCriteria->equals($criteria)) {
					$this->collCategorySubreaktors = CategorySubreaktorPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastCategorySubreaktorCriteria = $criteria;
		return $this->collCategorySubreaktors;
	}

	
	public function countCategorySubreaktors($criteria = null, $distinct = false, $con = null)
	{
				include_once 'lib/model/om/BaseCategorySubreaktorPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(CategorySubreaktorPeer::SUBREAKTOR_ID, $this->getId());

		return CategorySubreaktorPeer::doCount($criteria, $distinct, $con);
	}

	
	public function addCategorySubreaktor(CategorySubreaktor $l)
	{
		$this->collCategorySubreaktors[] = $l;
		$l->setSubreaktor($this);
	}


	
	public function getCategorySubreaktorsJoinCategory($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseCategorySubreaktorPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collCategorySubreaktors === null) {
			if ($this->isNew()) {
				$this->collCategorySubreaktors = array();
			} else {

				$criteria->add(CategorySubreaktorPeer::SUBREAKTOR_ID, $this->getId());

				$this->collCategorySubreaktors = CategorySubreaktorPeer::doSelectJoinCategory($criteria, $con);
			}
		} else {
									
			$criteria->add(CategorySubreaktorPeer::SUBREAKTOR_ID, $this->getId());

			if (!isset($this->lastCategorySubreaktorCriteria) || !$this->lastCategorySubreaktorCriteria->equals($criteria)) {
				$this->collCategorySubreaktors = CategorySubreaktorPeer::doSelectJoinCategory($criteria, $con);
			}
		}
		$this->lastCategorySubreaktorCriteria = $criteria;

		return $this->collCategorySubreaktors;
	}

	
	public function initSubreaktorI18ns()
	{
		if ($this->collSubreaktorI18ns === null) {
			$this->collSubreaktorI18ns = array();
		}
	}

	
	public function getSubreaktorI18ns($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseSubreaktorI18nPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collSubreaktorI18ns === null) {
			if ($this->isNew()) {
			   $this->collSubreaktorI18ns = array();
			} else {

				$criteria->add(SubreaktorI18nPeer::ID, $this->getId());

				SubreaktorI18nPeer::addSelectColumns($criteria);
				$this->collSubreaktorI18ns = SubreaktorI18nPeer::doSelect($criteria, $con);
			}
		} else {
						if (!$this->isNew()) {
												

				$criteria->add(SubreaktorI18nPeer::ID, $this->getId());

				SubreaktorI18nPeer::addSelectColumns($criteria);
				if (!isset($this->lastSubreaktorI18nCriteria) || !$this->lastSubreaktorI18nCriteria->equals($criteria)) {
					$this->collSubreaktorI18ns = SubreaktorI18nPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastSubreaktorI18nCriteria = $criteria;
		return $this->collSubreaktorI18ns;
	}

	
	public function countSubreaktorI18ns($criteria = null, $distinct = false, $con = null)
	{
				include_once 'lib/model/om/BaseSubreaktorI18nPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(SubreaktorI18nPeer::ID, $this->getId());

		return SubreaktorI18nPeer::doCount($criteria, $distinct, $con);
	}

	
	public function addSubreaktorI18n(SubreaktorI18n $l)
	{
		$this->collSubreaktorI18ns[] = $l;
		$l->setSubreaktor($this);
	}

	
	public function initSubreaktorArtworks()
	{
		if ($this->collSubreaktorArtworks === null) {
			$this->collSubreaktorArtworks = array();
		}
	}

	
	public function getSubreaktorArtworks($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseSubreaktorArtworkPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collSubreaktorArtworks === null) {
			if ($this->isNew()) {
			   $this->collSubreaktorArtworks = array();
			} else {

				$criteria->add(SubreaktorArtworkPeer::SUBREAKTOR_ID, $this->getId());

				SubreaktorArtworkPeer::addSelectColumns($criteria);
				$this->collSubreaktorArtworks = SubreaktorArtworkPeer::doSelect($criteria, $con);
			}
		} else {
						if (!$this->isNew()) {
												

				$criteria->add(SubreaktorArtworkPeer::SUBREAKTOR_ID, $this->getId());

				SubreaktorArtworkPeer::addSelectColumns($criteria);
				if (!isset($this->lastSubreaktorArtworkCriteria) || !$this->lastSubreaktorArtworkCriteria->equals($criteria)) {
					$this->collSubreaktorArtworks = SubreaktorArtworkPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastSubreaktorArtworkCriteria = $criteria;
		return $this->collSubreaktorArtworks;
	}

	
	public function countSubreaktorArtworks($criteria = null, $distinct = false, $con = null)
	{
				include_once 'lib/model/om/BaseSubreaktorArtworkPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(SubreaktorArtworkPeer::SUBREAKTOR_ID, $this->getId());

		return SubreaktorArtworkPeer::doCount($criteria, $distinct, $con);
	}

	
	public function addSubreaktorArtwork(SubreaktorArtwork $l)
	{
		$this->collSubreaktorArtworks[] = $l;
		$l->setSubreaktor($this);
	}


	
	public function getSubreaktorArtworksJoinReaktorArtwork($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseSubreaktorArtworkPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collSubreaktorArtworks === null) {
			if ($this->isNew()) {
				$this->collSubreaktorArtworks = array();
			} else {

				$criteria->add(SubreaktorArtworkPeer::SUBREAKTOR_ID, $this->getId());

				$this->collSubreaktorArtworks = SubreaktorArtworkPeer::doSelectJoinReaktorArtwork($criteria, $con);
			}
		} else {
									
			$criteria->add(SubreaktorArtworkPeer::SUBREAKTOR_ID, $this->getId());

			if (!isset($this->lastSubreaktorArtworkCriteria) || !$this->lastSubreaktorArtworkCriteria->equals($criteria)) {
				$this->collSubreaktorArtworks = SubreaktorArtworkPeer::doSelectJoinReaktorArtwork($criteria, $con);
			}
		}
		$this->lastSubreaktorArtworkCriteria = $criteria;

		return $this->collSubreaktorArtworks;
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
    $obj = $this->getCurrentSubreaktorI18n();

    return ($obj ? $obj->getName() : null);
  }

  public function setName($value)
  {
    $this->getCurrentSubreaktorI18n()->setName($value);
  }

  protected $current_i18n = array();

  public function getCurrentSubreaktorI18n()
  {
    if (!isset($this->current_i18n[$this->culture]))
    {
      $obj = SubreaktorI18nPeer::retrieveByPK($this->getId(), $this->culture);
      if ($obj)
      {
        $this->setSubreaktorI18nForCulture($obj, $this->culture);
      }
      else
      {
        $this->setSubreaktorI18nForCulture(new SubreaktorI18n(), $this->culture);
        $this->current_i18n[$this->culture]->setCulture($this->culture);
      }
    }

    return $this->current_i18n[$this->culture];
  }

  public function setSubreaktorI18nForCulture($object, $culture)
  {
    $this->current_i18n[$culture] = $object;
    $this->addSubreaktorI18n($object);
  }


  public function __call($method, $arguments)
  {
    if (!$callable = sfMixer::getCallable('BaseSubreaktor:'.$method))
    {
      throw new sfException(sprintf('Call to undefined method BaseSubreaktor::%s', $method));
    }

    array_unshift($arguments, $this);

    return call_user_func_array($callable, $arguments);
  }


} 