<?php


abstract class BaseFileMimetype extends BaseObject  implements Persistent {


	
	protected static $peer;


	
	protected $id;


	
	protected $mimetype;


	
	protected $identifier;

	
	protected $collArticleFiles;

	
	protected $lastArticleFileCriteria = null;

	
	protected $alreadyInSave = false;

	
	protected $alreadyInValidation = false;

	
	public function getId()
	{

		return $this->id;
	}

	
	public function getMimetype()
	{

		return $this->mimetype;
	}

	
	public function getIdentifier()
	{

		return $this->identifier;
	}

	
	public function setId($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->id !== $v) {
			$this->id = $v;
			$this->modifiedColumns[] = FileMimetypePeer::ID;
		}

	} 
	
	public function setMimetype($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->mimetype !== $v) {
			$this->mimetype = $v;
			$this->modifiedColumns[] = FileMimetypePeer::MIMETYPE;
		}

	} 
	
	public function setIdentifier($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->identifier !== $v) {
			$this->identifier = $v;
			$this->modifiedColumns[] = FileMimetypePeer::IDENTIFIER;
		}

	} 
	
	public function hydrate(ResultSet $rs, $startcol = 1)
	{
		try {

			$this->id = $rs->getInt($startcol + 0);

			$this->mimetype = $rs->getString($startcol + 1);

			$this->identifier = $rs->getString($startcol + 2);

			$this->resetModified();

			$this->setNew(false);

						return $startcol + 3; 
		} catch (Exception $e) {
			throw new PropelException("Error populating FileMimetype object", $e);
		}
	}

	
	public function delete($con = null)
	{

    foreach (sfMixer::getCallables('BaseFileMimetype:delete:pre') as $callable)
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
			$con = Propel::getConnection(FileMimetypePeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			FileMimetypePeer::doDelete($this, $con);
			$this->setDeleted(true);
			$con->commit();
		} catch (PropelException $e) {
			$con->rollback();
			throw $e;
		}
	

    foreach (sfMixer::getCallables('BaseFileMimetype:delete:post') as $callable)
    {
      call_user_func($callable, $this, $con);
    }

  }
	
	public function save($con = null)
	{

    foreach (sfMixer::getCallables('BaseFileMimetype:save:pre') as $callable)
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
			$con = Propel::getConnection(FileMimetypePeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			$affectedRows = $this->doSave($con);
			$con->commit();
    foreach (sfMixer::getCallables('BaseFileMimetype:save:post') as $callable)
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
					$pk = FileMimetypePeer::doInsert($this, $con);
					$affectedRows += 1; 										 										 
					$this->setId($pk);  
					$this->setNew(false);
				} else {
					$affectedRows += FileMimetypePeer::doUpdate($this, $con);
				}
				$this->resetModified(); 			}

			if ($this->collArticleFiles !== null) {
				foreach($this->collArticleFiles as $referrerFK) {
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


			if (($retval = FileMimetypePeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}


				if ($this->collArticleFiles !== null) {
					foreach($this->collArticleFiles as $referrerFK) {
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
		$pos = FileMimetypePeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->getByPosition($pos);
	}

	
	public function getByPosition($pos)
	{
		switch($pos) {
			case 0:
				return $this->getId();
				break;
			case 1:
				return $this->getMimetype();
				break;
			case 2:
				return $this->getIdentifier();
				break;
			default:
				return null;
				break;
		} 	}

	
	public function toArray($keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = FileMimetypePeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getId(),
			$keys[1] => $this->getMimetype(),
			$keys[2] => $this->getIdentifier(),
		);
		return $result;
	}

	
	public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = FileMimetypePeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->setByPosition($pos, $value);
	}

	
	public function setByPosition($pos, $value)
	{
		switch($pos) {
			case 0:
				$this->setId($value);
				break;
			case 1:
				$this->setMimetype($value);
				break;
			case 2:
				$this->setIdentifier($value);
				break;
		} 	}

	
	public function fromArray($arr, $keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = FileMimetypePeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setMimetype($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setIdentifier($arr[$keys[2]]);
	}

	
	public function buildCriteria()
	{
		$criteria = new Criteria(FileMimetypePeer::DATABASE_NAME);

		if ($this->isColumnModified(FileMimetypePeer::ID)) $criteria->add(FileMimetypePeer::ID, $this->id);
		if ($this->isColumnModified(FileMimetypePeer::MIMETYPE)) $criteria->add(FileMimetypePeer::MIMETYPE, $this->mimetype);
		if ($this->isColumnModified(FileMimetypePeer::IDENTIFIER)) $criteria->add(FileMimetypePeer::IDENTIFIER, $this->identifier);

		return $criteria;
	}

	
	public function buildPkeyCriteria()
	{
		$criteria = new Criteria(FileMimetypePeer::DATABASE_NAME);

		$criteria->add(FileMimetypePeer::ID, $this->id);

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

		$copyObj->setMimetype($this->mimetype);

		$copyObj->setIdentifier($this->identifier);


		if ($deepCopy) {
									$copyObj->setNew(false);

			foreach($this->getArticleFiles() as $relObj) {
				$copyObj->addArticleFile($relObj->copy($deepCopy));
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
			self::$peer = new FileMimetypePeer();
		}
		return self::$peer;
	}

	
	public function initArticleFiles()
	{
		if ($this->collArticleFiles === null) {
			$this->collArticleFiles = array();
		}
	}

	
	public function getArticleFiles($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseArticleFilePeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collArticleFiles === null) {
			if ($this->isNew()) {
			   $this->collArticleFiles = array();
			} else {

				$criteria->add(ArticleFilePeer::FILE_MIMETYPE_ID, $this->getId());

				ArticleFilePeer::addSelectColumns($criteria);
				$this->collArticleFiles = ArticleFilePeer::doSelect($criteria, $con);
			}
		} else {
						if (!$this->isNew()) {
												

				$criteria->add(ArticleFilePeer::FILE_MIMETYPE_ID, $this->getId());

				ArticleFilePeer::addSelectColumns($criteria);
				if (!isset($this->lastArticleFileCriteria) || !$this->lastArticleFileCriteria->equals($criteria)) {
					$this->collArticleFiles = ArticleFilePeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastArticleFileCriteria = $criteria;
		return $this->collArticleFiles;
	}

	
	public function countArticleFiles($criteria = null, $distinct = false, $con = null)
	{
				include_once 'lib/model/om/BaseArticleFilePeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(ArticleFilePeer::FILE_MIMETYPE_ID, $this->getId());

		return ArticleFilePeer::doCount($criteria, $distinct, $con);
	}

	
	public function addArticleFile(ArticleFile $l)
	{
		$this->collArticleFiles[] = $l;
		$l->setFileMimetype($this);
	}


	
	public function getArticleFilesJoinsfGuardUser($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseArticleFilePeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collArticleFiles === null) {
			if ($this->isNew()) {
				$this->collArticleFiles = array();
			} else {

				$criteria->add(ArticleFilePeer::FILE_MIMETYPE_ID, $this->getId());

				$this->collArticleFiles = ArticleFilePeer::doSelectJoinsfGuardUser($criteria, $con);
			}
		} else {
									
			$criteria->add(ArticleFilePeer::FILE_MIMETYPE_ID, $this->getId());

			if (!isset($this->lastArticleFileCriteria) || !$this->lastArticleFileCriteria->equals($criteria)) {
				$this->collArticleFiles = ArticleFilePeer::doSelectJoinsfGuardUser($criteria, $con);
			}
		}
		$this->lastArticleFileCriteria = $criteria;

		return $this->collArticleFiles;
	}


  public function __call($method, $arguments)
  {
    if (!$callable = sfMixer::getCallable('BaseFileMimetype:'.$method))
    {
      throw new sfException(sprintf('Call to undefined method BaseFileMimetype::%s', $method));
    }

    array_unshift($arguments, $this);

    return call_user_func_array($callable, $arguments);
  }


} 