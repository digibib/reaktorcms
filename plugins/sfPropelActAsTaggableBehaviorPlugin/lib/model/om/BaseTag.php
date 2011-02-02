<?php


abstract class BaseTag extends BaseObject  implements Persistent {


	
	protected static $peer;


	
	protected $id;


	
	protected $name;


	
	protected $approved = 0;


	
	protected $approved_by;


	
	protected $approved_at;


	
	protected $width;

	
	protected $asfGuardUser;

	
	protected $collTaggings;

	
	protected $lastTaggingCriteria = null;

	
	protected $alreadyInSave = false;

	
	protected $alreadyInValidation = false;

	
	public function getID()
	{

		return $this->id;
	}

	
	public function getName()
	{

		return $this->name;
	}

	
	public function getApproved()
	{

		return $this->approved;
	}

	
	public function getApprovedBy()
	{

		return $this->approved_by;
	}

	
	public function getApprovedAt($format = 'Y-m-d H:i:s')
	{

		if ($this->approved_at === null || $this->approved_at === '') {
			return null;
		} elseif (!is_int($this->approved_at)) {
						$ts = strtotime($this->approved_at);
			if ($ts === -1 || $ts === false) { 				throw new PropelException("Unable to parse value of [approved_at] as date/time value: " . var_export($this->approved_at, true));
			}
		} else {
			$ts = $this->approved_at;
		}
		if ($format === null) {
			return $ts;
		} elseif (strpos($format, '%') !== false) {
			return strftime($format, $ts);
		} else {
			return date($format, $ts);
		}
	}

	
	public function getWidth()
	{

		return $this->width;
	}

	
	public function setID($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->id !== $v) {
			$this->id = $v;
			$this->modifiedColumns[] = TagPeer::ID;
		}

	} 
	
	public function setName($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->name !== $v) {
			$this->name = $v;
			$this->modifiedColumns[] = TagPeer::NAME;
		}

	} 
	
	public function setApproved($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->approved !== $v || $v === 0) {
			$this->approved = $v;
			$this->modifiedColumns[] = TagPeer::APPROVED;
		}

	} 
	
	public function setApprovedBy($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->approved_by !== $v) {
			$this->approved_by = $v;
			$this->modifiedColumns[] = TagPeer::APPROVED_BY;
		}

		if ($this->asfGuardUser !== null && $this->asfGuardUser->getId() !== $v) {
			$this->asfGuardUser = null;
		}

	} 
	
	public function setApprovedAt($v)
	{

		if ($v !== null && !is_int($v)) {
			$ts = strtotime($v);
			if ($ts === -1 || $ts === false) { 				throw new PropelException("Unable to parse date/time value for [approved_at] from input: " . var_export($v, true));
			}
		} else {
			$ts = $v;
		}
		if ($this->approved_at !== $ts) {
			$this->approved_at = $ts;
			$this->modifiedColumns[] = TagPeer::APPROVED_AT;
		}

	} 
	
	public function setWidth($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->width !== $v) {
			$this->width = $v;
			$this->modifiedColumns[] = TagPeer::WIDTH;
		}

	} 
	
	public function hydrate(ResultSet $rs, $startcol = 1)
	{
		try {

			$this->id = $rs->getInt($startcol + 0);

			$this->name = $rs->getString($startcol + 1);

			$this->approved = $rs->getInt($startcol + 2);

			$this->approved_by = $rs->getInt($startcol + 3);

			$this->approved_at = $rs->getTimestamp($startcol + 4, null);

			$this->width = $rs->getInt($startcol + 5);

			$this->resetModified();

			$this->setNew(false);

						return $startcol + 6; 
		} catch (Exception $e) {
			throw new PropelException("Error populating Tag object", $e);
		}
	}

	
	public function delete($con = null)
	{

    foreach (sfMixer::getCallables('BaseTag:delete:pre') as $callable)
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
			$con = Propel::getConnection(TagPeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			TagPeer::doDelete($this, $con);
			$this->setDeleted(true);
			$con->commit();
		} catch (PropelException $e) {
			$con->rollback();
			throw $e;
		}
	

    foreach (sfMixer::getCallables('BaseTag:delete:post') as $callable)
    {
      call_user_func($callable, $this, $con);
    }

  }
	
	public function save($con = null)
	{

    foreach (sfMixer::getCallables('BaseTag:save:pre') as $callable)
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
			$con = Propel::getConnection(TagPeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			$affectedRows = $this->doSave($con);
			$con->commit();
    foreach (sfMixer::getCallables('BaseTag:save:post') as $callable)
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


												
			if ($this->asfGuardUser !== null) {
				if ($this->asfGuardUser->isModified()) {
					$affectedRows += $this->asfGuardUser->save($con);
				}
				$this->setsfGuardUser($this->asfGuardUser);
			}


						if ($this->isModified()) {
				if ($this->isNew()) {
					$pk = TagPeer::doInsert($this, $con);
					$affectedRows += 1; 										 										 
					$this->setID($pk);  
					$this->setNew(false);
				} else {
					$affectedRows += TagPeer::doUpdate($this, $con);
				}
				$this->resetModified(); 			}

			if ($this->collTaggings !== null) {
				foreach($this->collTaggings as $referrerFK) {
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


												
			if ($this->asfGuardUser !== null) {
				if (!$this->asfGuardUser->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->asfGuardUser->getValidationFailures());
				}
			}


			if (($retval = TagPeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}


				if ($this->collTaggings !== null) {
					foreach($this->collTaggings as $referrerFK) {
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
		$pos = TagPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->getByPosition($pos);
	}

	
	public function getByPosition($pos)
	{
		switch($pos) {
			case 0:
				return $this->getID();
				break;
			case 1:
				return $this->getName();
				break;
			case 2:
				return $this->getApproved();
				break;
			case 3:
				return $this->getApprovedBy();
				break;
			case 4:
				return $this->getApprovedAt();
				break;
			case 5:
				return $this->getWidth();
				break;
			default:
				return null;
				break;
		} 	}

	
	public function toArray($keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = TagPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getID(),
			$keys[1] => $this->getName(),
			$keys[2] => $this->getApproved(),
			$keys[3] => $this->getApprovedBy(),
			$keys[4] => $this->getApprovedAt(),
			$keys[5] => $this->getWidth(),
		);
		return $result;
	}

	
	public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = TagPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->setByPosition($pos, $value);
	}

	
	public function setByPosition($pos, $value)
	{
		switch($pos) {
			case 0:
				$this->setID($value);
				break;
			case 1:
				$this->setName($value);
				break;
			case 2:
				$this->setApproved($value);
				break;
			case 3:
				$this->setApprovedBy($value);
				break;
			case 4:
				$this->setApprovedAt($value);
				break;
			case 5:
				$this->setWidth($value);
				break;
		} 	}

	
	public function fromArray($arr, $keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = TagPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setID($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setName($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setApproved($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setApprovedBy($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setApprovedAt($arr[$keys[4]]);
		if (array_key_exists($keys[5], $arr)) $this->setWidth($arr[$keys[5]]);
	}

	
	public function buildCriteria()
	{
		$criteria = new Criteria(TagPeer::DATABASE_NAME);

		if ($this->isColumnModified(TagPeer::ID)) $criteria->add(TagPeer::ID, $this->id);
		if ($this->isColumnModified(TagPeer::NAME)) $criteria->add(TagPeer::NAME, $this->name);
		if ($this->isColumnModified(TagPeer::APPROVED)) $criteria->add(TagPeer::APPROVED, $this->approved);
		if ($this->isColumnModified(TagPeer::APPROVED_BY)) $criteria->add(TagPeer::APPROVED_BY, $this->approved_by);
		if ($this->isColumnModified(TagPeer::APPROVED_AT)) $criteria->add(TagPeer::APPROVED_AT, $this->approved_at);
		if ($this->isColumnModified(TagPeer::WIDTH)) $criteria->add(TagPeer::WIDTH, $this->width);

		return $criteria;
	}

	
	public function buildPkeyCriteria()
	{
		$criteria = new Criteria(TagPeer::DATABASE_NAME);

		$criteria->add(TagPeer::ID, $this->id);

		return $criteria;
	}

	
	public function getPrimaryKey()
	{
		return $this->getID();
	}

	
	public function setPrimaryKey($key)
	{
		$this->setID($key);
	}

	
	public function copyInto($copyObj, $deepCopy = false)
	{

		$copyObj->setName($this->name);

		$copyObj->setApproved($this->approved);

		$copyObj->setApprovedBy($this->approved_by);

		$copyObj->setApprovedAt($this->approved_at);

		$copyObj->setWidth($this->width);


		if ($deepCopy) {
									$copyObj->setNew(false);

			foreach($this->getTaggings() as $relObj) {
				$copyObj->addTagging($relObj->copy($deepCopy));
			}

		} 

		$copyObj->setNew(true);

		$copyObj->setID(NULL); 
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
			self::$peer = new TagPeer();
		}
		return self::$peer;
	}

	
	public function setsfGuardUser($v)
	{


		if ($v === null) {
			$this->setApprovedBy(NULL);
		} else {
			$this->setApprovedBy($v->getId());
		}


		$this->asfGuardUser = $v;
	}


	
	public function getsfGuardUser($con = null)
	{
		if ($this->asfGuardUser === null && ($this->approved_by !== null)) {
						include_once 'plugins/sfGuardPlugin/lib/model/om/BasesfGuardUserPeer.php';

			$this->asfGuardUser = sfGuardUserPeer::retrieveByPK($this->approved_by, $con);

			
		}
		return $this->asfGuardUser;
	}

	
	public function initTaggings()
	{
		if ($this->collTaggings === null) {
			$this->collTaggings = array();
		}
	}

	
	public function getTaggings($criteria = null, $con = null)
	{
				include_once 'plugins/sfPropelActAsTaggableBehaviorPlugin/lib/model/om/BaseTaggingPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collTaggings === null) {
			if ($this->isNew()) {
			   $this->collTaggings = array();
			} else {

				$criteria->add(TaggingPeer::TAG_ID, $this->getID());

				TaggingPeer::addSelectColumns($criteria);
				$this->collTaggings = TaggingPeer::doSelect($criteria, $con);
			}
		} else {
						if (!$this->isNew()) {
												

				$criteria->add(TaggingPeer::TAG_ID, $this->getID());

				TaggingPeer::addSelectColumns($criteria);
				if (!isset($this->lastTaggingCriteria) || !$this->lastTaggingCriteria->equals($criteria)) {
					$this->collTaggings = TaggingPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastTaggingCriteria = $criteria;
		return $this->collTaggings;
	}

	
	public function countTaggings($criteria = null, $distinct = false, $con = null)
	{
				include_once 'plugins/sfPropelActAsTaggableBehaviorPlugin/lib/model/om/BaseTaggingPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(TaggingPeer::TAG_ID, $this->getID());

		return TaggingPeer::doCount($criteria, $distinct, $con);
	}

	
	public function addTagging(Tagging $l)
	{
		$this->collTaggings[] = $l;
		$l->setTag($this);
	}


	
	public function getTaggingsJoinsfGuardUser($criteria = null, $con = null)
	{
				include_once 'plugins/sfPropelActAsTaggableBehaviorPlugin/lib/model/om/BaseTaggingPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collTaggings === null) {
			if ($this->isNew()) {
				$this->collTaggings = array();
			} else {

				$criteria->add(TaggingPeer::TAG_ID, $this->getID());

				$this->collTaggings = TaggingPeer::doSelectJoinsfGuardUser($criteria, $con);
			}
		} else {
									
			$criteria->add(TaggingPeer::TAG_ID, $this->getID());

			if (!isset($this->lastTaggingCriteria) || !$this->lastTaggingCriteria->equals($criteria)) {
				$this->collTaggings = TaggingPeer::doSelectJoinsfGuardUser($criteria, $con);
			}
		}
		$this->lastTaggingCriteria = $criteria;

		return $this->collTaggings;
	}


  public function __call($method, $arguments)
  {
    if (!$callable = sfMixer::getCallable('BaseTag:'.$method))
    {
      throw new sfException(sprintf('Call to undefined method BaseTag::%s', $method));
    }

    array_unshift($arguments, $this);

    return call_user_func_array($callable, $arguments);
  }


} 