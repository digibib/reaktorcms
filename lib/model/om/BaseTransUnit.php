<?php


abstract class BaseTransUnit extends BaseObject  implements Persistent {


	
	protected static $peer;


	
	protected $msg_id;


	
	protected $cat_id = 1;


	
	protected $id = '';


	
	protected $source;


	
	protected $target;


	
	protected $module = '';


	
	protected $filename = '';


	
	protected $comments;


	
	protected $date_added = 0;


	
	protected $date_modified = 0;


	
	protected $author = '';


	
	protected $translated = false;

	
	protected $aCatalogue;

	
	protected $alreadyInSave = false;

	
	protected $alreadyInValidation = false;

	
	public function getMsgId()
	{

		return $this->msg_id;
	}

	
	public function getCatId()
	{

		return $this->cat_id;
	}

	
	public function getId()
	{

		return $this->id;
	}

	
	public function getSource()
	{

		return $this->source;
	}

	
	public function getTarget()
	{

		return $this->target;
	}

	
	public function getModule()
	{

		return $this->module;
	}

	
	public function getFilename()
	{

		return $this->filename;
	}

	
	public function getComments()
	{

		return $this->comments;
	}

	
	public function getDateAdded()
	{

		return $this->date_added;
	}

	
	public function getDateModified()
	{

		return $this->date_modified;
	}

	
	public function getAuthor()
	{

		return $this->author;
	}

	
	public function getTranslated()
	{

		return $this->translated;
	}

	
	public function setMsgId($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->msg_id !== $v) {
			$this->msg_id = $v;
			$this->modifiedColumns[] = TransUnitPeer::MSG_ID;
		}

	} 
	
	public function setCatId($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->cat_id !== $v || $v === 1) {
			$this->cat_id = $v;
			$this->modifiedColumns[] = TransUnitPeer::CAT_ID;
		}

		if ($this->aCatalogue !== null && $this->aCatalogue->getCatId() !== $v) {
			$this->aCatalogue = null;
		}

	} 
	
	public function setId($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->id !== $v || $v === '') {
			$this->id = $v;
			$this->modifiedColumns[] = TransUnitPeer::ID;
		}

	} 
	
	public function setSource($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->source !== $v) {
			$this->source = $v;
			$this->modifiedColumns[] = TransUnitPeer::SOURCE;
		}

	} 
	
	public function setTarget($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->target !== $v) {
			$this->target = $v;
			$this->modifiedColumns[] = TransUnitPeer::TARGET;
		}

	} 
	
	public function setModule($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->module !== $v || $v === '') {
			$this->module = $v;
			$this->modifiedColumns[] = TransUnitPeer::MODULE;
		}

	} 
	
	public function setFilename($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->filename !== $v || $v === '') {
			$this->filename = $v;
			$this->modifiedColumns[] = TransUnitPeer::FILENAME;
		}

	} 
	
	public function setComments($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->comments !== $v) {
			$this->comments = $v;
			$this->modifiedColumns[] = TransUnitPeer::COMMENTS;
		}

	} 
	
	public function setDateAdded($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->date_added !== $v || $v === 0) {
			$this->date_added = $v;
			$this->modifiedColumns[] = TransUnitPeer::DATE_ADDED;
		}

	} 
	
	public function setDateModified($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->date_modified !== $v || $v === 0) {
			$this->date_modified = $v;
			$this->modifiedColumns[] = TransUnitPeer::DATE_MODIFIED;
		}

	} 
	
	public function setAuthor($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->author !== $v || $v === '') {
			$this->author = $v;
			$this->modifiedColumns[] = TransUnitPeer::AUTHOR;
		}

	} 
	
	public function setTranslated($v)
	{

		if ($this->translated !== $v || $v === false) {
			$this->translated = $v;
			$this->modifiedColumns[] = TransUnitPeer::TRANSLATED;
		}

	} 
	
	public function hydrate(ResultSet $rs, $startcol = 1)
	{
		try {

			$this->msg_id = $rs->getInt($startcol + 0);

			$this->cat_id = $rs->getInt($startcol + 1);

			$this->id = $rs->getString($startcol + 2);

			$this->source = $rs->getString($startcol + 3);

			$this->target = $rs->getString($startcol + 4);

			$this->module = $rs->getString($startcol + 5);

			$this->filename = $rs->getString($startcol + 6);

			$this->comments = $rs->getString($startcol + 7);

			$this->date_added = $rs->getInt($startcol + 8);

			$this->date_modified = $rs->getInt($startcol + 9);

			$this->author = $rs->getString($startcol + 10);

			$this->translated = $rs->getBoolean($startcol + 11);

			$this->resetModified();

			$this->setNew(false);

						return $startcol + 12; 
		} catch (Exception $e) {
			throw new PropelException("Error populating TransUnit object", $e);
		}
	}

	
	public function delete($con = null)
	{

    foreach (sfMixer::getCallables('BaseTransUnit:delete:pre') as $callable)
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
			$con = Propel::getConnection(TransUnitPeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			TransUnitPeer::doDelete($this, $con);
			$this->setDeleted(true);
			$con->commit();
		} catch (PropelException $e) {
			$con->rollback();
			throw $e;
		}
	

    foreach (sfMixer::getCallables('BaseTransUnit:delete:post') as $callable)
    {
      call_user_func($callable, $this, $con);
    }

  }
	
	public function save($con = null)
	{

    foreach (sfMixer::getCallables('BaseTransUnit:save:pre') as $callable)
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
			$con = Propel::getConnection(TransUnitPeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			$affectedRows = $this->doSave($con);
			$con->commit();
    foreach (sfMixer::getCallables('BaseTransUnit:save:post') as $callable)
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


												
			if ($this->aCatalogue !== null) {
				if ($this->aCatalogue->isModified()) {
					$affectedRows += $this->aCatalogue->save($con);
				}
				$this->setCatalogue($this->aCatalogue);
			}


						if ($this->isModified()) {
				if ($this->isNew()) {
					$pk = TransUnitPeer::doInsert($this, $con);
					$affectedRows += 1; 										 										 
					$this->setMsgId($pk);  
					$this->setNew(false);
				} else {
					$affectedRows += TransUnitPeer::doUpdate($this, $con);
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


												
			if ($this->aCatalogue !== null) {
				if (!$this->aCatalogue->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aCatalogue->getValidationFailures());
				}
			}


			if (($retval = TransUnitPeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}



			$this->alreadyInValidation = false;
		}

		return (!empty($failureMap) ? $failureMap : true);
	}

	
	public function getByName($name, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = TransUnitPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->getByPosition($pos);
	}

	
	public function getByPosition($pos)
	{
		switch($pos) {
			case 0:
				return $this->getMsgId();
				break;
			case 1:
				return $this->getCatId();
				break;
			case 2:
				return $this->getId();
				break;
			case 3:
				return $this->getSource();
				break;
			case 4:
				return $this->getTarget();
				break;
			case 5:
				return $this->getModule();
				break;
			case 6:
				return $this->getFilename();
				break;
			case 7:
				return $this->getComments();
				break;
			case 8:
				return $this->getDateAdded();
				break;
			case 9:
				return $this->getDateModified();
				break;
			case 10:
				return $this->getAuthor();
				break;
			case 11:
				return $this->getTranslated();
				break;
			default:
				return null;
				break;
		} 	}

	
	public function toArray($keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = TransUnitPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getMsgId(),
			$keys[1] => $this->getCatId(),
			$keys[2] => $this->getId(),
			$keys[3] => $this->getSource(),
			$keys[4] => $this->getTarget(),
			$keys[5] => $this->getModule(),
			$keys[6] => $this->getFilename(),
			$keys[7] => $this->getComments(),
			$keys[8] => $this->getDateAdded(),
			$keys[9] => $this->getDateModified(),
			$keys[10] => $this->getAuthor(),
			$keys[11] => $this->getTranslated(),
		);
		return $result;
	}

	
	public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = TransUnitPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->setByPosition($pos, $value);
	}

	
	public function setByPosition($pos, $value)
	{
		switch($pos) {
			case 0:
				$this->setMsgId($value);
				break;
			case 1:
				$this->setCatId($value);
				break;
			case 2:
				$this->setId($value);
				break;
			case 3:
				$this->setSource($value);
				break;
			case 4:
				$this->setTarget($value);
				break;
			case 5:
				$this->setModule($value);
				break;
			case 6:
				$this->setFilename($value);
				break;
			case 7:
				$this->setComments($value);
				break;
			case 8:
				$this->setDateAdded($value);
				break;
			case 9:
				$this->setDateModified($value);
				break;
			case 10:
				$this->setAuthor($value);
				break;
			case 11:
				$this->setTranslated($value);
				break;
		} 	}

	
	public function fromArray($arr, $keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = TransUnitPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setMsgId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setCatId($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setId($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setSource($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setTarget($arr[$keys[4]]);
		if (array_key_exists($keys[5], $arr)) $this->setModule($arr[$keys[5]]);
		if (array_key_exists($keys[6], $arr)) $this->setFilename($arr[$keys[6]]);
		if (array_key_exists($keys[7], $arr)) $this->setComments($arr[$keys[7]]);
		if (array_key_exists($keys[8], $arr)) $this->setDateAdded($arr[$keys[8]]);
		if (array_key_exists($keys[9], $arr)) $this->setDateModified($arr[$keys[9]]);
		if (array_key_exists($keys[10], $arr)) $this->setAuthor($arr[$keys[10]]);
		if (array_key_exists($keys[11], $arr)) $this->setTranslated($arr[$keys[11]]);
	}

	
	public function buildCriteria()
	{
		$criteria = new Criteria(TransUnitPeer::DATABASE_NAME);

		if ($this->isColumnModified(TransUnitPeer::MSG_ID)) $criteria->add(TransUnitPeer::MSG_ID, $this->msg_id);
		if ($this->isColumnModified(TransUnitPeer::CAT_ID)) $criteria->add(TransUnitPeer::CAT_ID, $this->cat_id);
		if ($this->isColumnModified(TransUnitPeer::ID)) $criteria->add(TransUnitPeer::ID, $this->id);
		if ($this->isColumnModified(TransUnitPeer::SOURCE)) $criteria->add(TransUnitPeer::SOURCE, $this->source);
		if ($this->isColumnModified(TransUnitPeer::TARGET)) $criteria->add(TransUnitPeer::TARGET, $this->target);
		if ($this->isColumnModified(TransUnitPeer::MODULE)) $criteria->add(TransUnitPeer::MODULE, $this->module);
		if ($this->isColumnModified(TransUnitPeer::FILENAME)) $criteria->add(TransUnitPeer::FILENAME, $this->filename);
		if ($this->isColumnModified(TransUnitPeer::COMMENTS)) $criteria->add(TransUnitPeer::COMMENTS, $this->comments);
		if ($this->isColumnModified(TransUnitPeer::DATE_ADDED)) $criteria->add(TransUnitPeer::DATE_ADDED, $this->date_added);
		if ($this->isColumnModified(TransUnitPeer::DATE_MODIFIED)) $criteria->add(TransUnitPeer::DATE_MODIFIED, $this->date_modified);
		if ($this->isColumnModified(TransUnitPeer::AUTHOR)) $criteria->add(TransUnitPeer::AUTHOR, $this->author);
		if ($this->isColumnModified(TransUnitPeer::TRANSLATED)) $criteria->add(TransUnitPeer::TRANSLATED, $this->translated);

		return $criteria;
	}

	
	public function buildPkeyCriteria()
	{
		$criteria = new Criteria(TransUnitPeer::DATABASE_NAME);

		$criteria->add(TransUnitPeer::MSG_ID, $this->msg_id);

		return $criteria;
	}

	
	public function getPrimaryKey()
	{
		return $this->getMsgId();
	}

	
	public function setPrimaryKey($key)
	{
		$this->setMsgId($key);
	}

	
	public function copyInto($copyObj, $deepCopy = false)
	{

		$copyObj->setCatId($this->cat_id);

		$copyObj->setId($this->id);

		$copyObj->setSource($this->source);

		$copyObj->setTarget($this->target);

		$copyObj->setModule($this->module);

		$copyObj->setFilename($this->filename);

		$copyObj->setComments($this->comments);

		$copyObj->setDateAdded($this->date_added);

		$copyObj->setDateModified($this->date_modified);

		$copyObj->setAuthor($this->author);

		$copyObj->setTranslated($this->translated);


		$copyObj->setNew(true);

		$copyObj->setMsgId(NULL); 
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
			self::$peer = new TransUnitPeer();
		}
		return self::$peer;
	}

	
	public function setCatalogue($v)
	{


		if ($v === null) {
			$this->setCatId('1');
		} else {
			$this->setCatId($v->getCatId());
		}


		$this->aCatalogue = $v;
	}


	
	public function getCatalogue($con = null)
	{
		if ($this->aCatalogue === null && ($this->cat_id !== null)) {
						include_once 'lib/model/om/BaseCataloguePeer.php';

			$this->aCatalogue = CataloguePeer::retrieveByPK($this->cat_id, $con);

			
		}
		return $this->aCatalogue;
	}


  public function __call($method, $arguments)
  {
    if (!$callable = sfMixer::getCallable('BaseTransUnit:'.$method))
    {
      throw new sfException(sprintf('Call to undefined method BaseTransUnit::%s', $method));
    }

    array_unshift($arguments, $this);

    return call_user_func_array($callable, $arguments);
  }


} 