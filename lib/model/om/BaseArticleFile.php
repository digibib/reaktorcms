<?php


abstract class BaseArticleFile extends BaseObject  implements Persistent {


	
	protected static $peer;


	
	protected $id;


	
	protected $filename;


	
	protected $path;


	
	protected $uploaded_by;


	
	protected $uploaded_at;


	
	protected $description;


	
	protected $file_mimetype_id;

	
	protected $asfGuardUser;

	
	protected $aFileMimetype;

	
	protected $collArticles;

	
	protected $lastArticleCriteria = null;

	
	protected $collArticleAttachments;

	
	protected $lastArticleAttachmentCriteria = null;

	
	protected $alreadyInSave = false;

	
	protected $alreadyInValidation = false;

	
	public function getId()
	{

		return $this->id;
	}

	
	public function getFilename()
	{

		return $this->filename;
	}

	
	public function getPath()
	{

		return $this->path;
	}

	
	public function getUploadedBy()
	{

		return $this->uploaded_by;
	}

	
	public function getUploadedAt($format = 'Y-m-d H:i:s')
	{

		if ($this->uploaded_at === null || $this->uploaded_at === '') {
			return null;
		} elseif (!is_int($this->uploaded_at)) {
						$ts = strtotime($this->uploaded_at);
			if ($ts === -1 || $ts === false) { 				throw new PropelException("Unable to parse value of [uploaded_at] as date/time value: " . var_export($this->uploaded_at, true));
			}
		} else {
			$ts = $this->uploaded_at;
		}
		if ($format === null) {
			return $ts;
		} elseif (strpos($format, '%') !== false) {
			return strftime($format, $ts);
		} else {
			return date($format, $ts);
		}
	}

	
	public function getDescription()
	{

		return $this->description;
	}

	
	public function getFileMimetypeId()
	{

		return $this->file_mimetype_id;
	}

	
	public function setId($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->id !== $v) {
			$this->id = $v;
			$this->modifiedColumns[] = ArticleFilePeer::ID;
		}

	} 
	
	public function setFilename($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->filename !== $v) {
			$this->filename = $v;
			$this->modifiedColumns[] = ArticleFilePeer::FILENAME;
		}

	} 
	
	public function setPath($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->path !== $v) {
			$this->path = $v;
			$this->modifiedColumns[] = ArticleFilePeer::PATH;
		}

	} 
	
	public function setUploadedBy($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->uploaded_by !== $v) {
			$this->uploaded_by = $v;
			$this->modifiedColumns[] = ArticleFilePeer::UPLOADED_BY;
		}

		if ($this->asfGuardUser !== null && $this->asfGuardUser->getId() !== $v) {
			$this->asfGuardUser = null;
		}

	} 
	
	public function setUploadedAt($v)
	{

		if ($v !== null && !is_int($v)) {
			$ts = strtotime($v);
			if ($ts === -1 || $ts === false) { 				throw new PropelException("Unable to parse date/time value for [uploaded_at] from input: " . var_export($v, true));
			}
		} else {
			$ts = $v;
		}
		if ($this->uploaded_at !== $ts) {
			$this->uploaded_at = $ts;
			$this->modifiedColumns[] = ArticleFilePeer::UPLOADED_AT;
		}

	} 
	
	public function setDescription($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->description !== $v) {
			$this->description = $v;
			$this->modifiedColumns[] = ArticleFilePeer::DESCRIPTION;
		}

	} 
	
	public function setFileMimetypeId($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->file_mimetype_id !== $v) {
			$this->file_mimetype_id = $v;
			$this->modifiedColumns[] = ArticleFilePeer::FILE_MIMETYPE_ID;
		}

		if ($this->aFileMimetype !== null && $this->aFileMimetype->getId() !== $v) {
			$this->aFileMimetype = null;
		}

	} 
	
	public function hydrate(ResultSet $rs, $startcol = 1)
	{
		try {

			$this->id = $rs->getInt($startcol + 0);

			$this->filename = $rs->getString($startcol + 1);

			$this->path = $rs->getString($startcol + 2);

			$this->uploaded_by = $rs->getInt($startcol + 3);

			$this->uploaded_at = $rs->getTimestamp($startcol + 4, null);

			$this->description = $rs->getString($startcol + 5);

			$this->file_mimetype_id = $rs->getInt($startcol + 6);

			$this->resetModified();

			$this->setNew(false);

						return $startcol + 7; 
		} catch (Exception $e) {
			throw new PropelException("Error populating ArticleFile object", $e);
		}
	}

	
	public function delete($con = null)
	{

    foreach (sfMixer::getCallables('BaseArticleFile:delete:pre') as $callable)
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
			$con = Propel::getConnection(ArticleFilePeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			ArticleFilePeer::doDelete($this, $con);
			$this->setDeleted(true);
			$con->commit();
		} catch (PropelException $e) {
			$con->rollback();
			throw $e;
		}
	

    foreach (sfMixer::getCallables('BaseArticleFile:delete:post') as $callable)
    {
      call_user_func($callable, $this, $con);
    }

  }
	
	public function save($con = null)
	{

    foreach (sfMixer::getCallables('BaseArticleFile:save:pre') as $callable)
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
			$con = Propel::getConnection(ArticleFilePeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			$affectedRows = $this->doSave($con);
			$con->commit();
    foreach (sfMixer::getCallables('BaseArticleFile:save:post') as $callable)
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

			if ($this->aFileMimetype !== null) {
				if ($this->aFileMimetype->isModified()) {
					$affectedRows += $this->aFileMimetype->save($con);
				}
				$this->setFileMimetype($this->aFileMimetype);
			}


						if ($this->isModified()) {
				if ($this->isNew()) {
					$pk = ArticleFilePeer::doInsert($this, $con);
					$affectedRows += 1; 										 										 
					$this->setId($pk);  
					$this->setNew(false);
				} else {
					$affectedRows += ArticleFilePeer::doUpdate($this, $con);
				}
				$this->resetModified(); 			}

			if ($this->collArticles !== null) {
				foreach($this->collArticles as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collArticleAttachments !== null) {
				foreach($this->collArticleAttachments as $referrerFK) {
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

			if ($this->aFileMimetype !== null) {
				if (!$this->aFileMimetype->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aFileMimetype->getValidationFailures());
				}
			}


			if (($retval = ArticleFilePeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}


				if ($this->collArticles !== null) {
					foreach($this->collArticles as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collArticleAttachments !== null) {
					foreach($this->collArticleAttachments as $referrerFK) {
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
		$pos = ArticleFilePeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->getByPosition($pos);
	}

	
	public function getByPosition($pos)
	{
		switch($pos) {
			case 0:
				return $this->getId();
				break;
			case 1:
				return $this->getFilename();
				break;
			case 2:
				return $this->getPath();
				break;
			case 3:
				return $this->getUploadedBy();
				break;
			case 4:
				return $this->getUploadedAt();
				break;
			case 5:
				return $this->getDescription();
				break;
			case 6:
				return $this->getFileMimetypeId();
				break;
			default:
				return null;
				break;
		} 	}

	
	public function toArray($keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = ArticleFilePeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getId(),
			$keys[1] => $this->getFilename(),
			$keys[2] => $this->getPath(),
			$keys[3] => $this->getUploadedBy(),
			$keys[4] => $this->getUploadedAt(),
			$keys[5] => $this->getDescription(),
			$keys[6] => $this->getFileMimetypeId(),
		);
		return $result;
	}

	
	public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = ArticleFilePeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->setByPosition($pos, $value);
	}

	
	public function setByPosition($pos, $value)
	{
		switch($pos) {
			case 0:
				$this->setId($value);
				break;
			case 1:
				$this->setFilename($value);
				break;
			case 2:
				$this->setPath($value);
				break;
			case 3:
				$this->setUploadedBy($value);
				break;
			case 4:
				$this->setUploadedAt($value);
				break;
			case 5:
				$this->setDescription($value);
				break;
			case 6:
				$this->setFileMimetypeId($value);
				break;
		} 	}

	
	public function fromArray($arr, $keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = ArticleFilePeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setFilename($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setPath($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setUploadedBy($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setUploadedAt($arr[$keys[4]]);
		if (array_key_exists($keys[5], $arr)) $this->setDescription($arr[$keys[5]]);
		if (array_key_exists($keys[6], $arr)) $this->setFileMimetypeId($arr[$keys[6]]);
	}

	
	public function buildCriteria()
	{
		$criteria = new Criteria(ArticleFilePeer::DATABASE_NAME);

		if ($this->isColumnModified(ArticleFilePeer::ID)) $criteria->add(ArticleFilePeer::ID, $this->id);
		if ($this->isColumnModified(ArticleFilePeer::FILENAME)) $criteria->add(ArticleFilePeer::FILENAME, $this->filename);
		if ($this->isColumnModified(ArticleFilePeer::PATH)) $criteria->add(ArticleFilePeer::PATH, $this->path);
		if ($this->isColumnModified(ArticleFilePeer::UPLOADED_BY)) $criteria->add(ArticleFilePeer::UPLOADED_BY, $this->uploaded_by);
		if ($this->isColumnModified(ArticleFilePeer::UPLOADED_AT)) $criteria->add(ArticleFilePeer::UPLOADED_AT, $this->uploaded_at);
		if ($this->isColumnModified(ArticleFilePeer::DESCRIPTION)) $criteria->add(ArticleFilePeer::DESCRIPTION, $this->description);
		if ($this->isColumnModified(ArticleFilePeer::FILE_MIMETYPE_ID)) $criteria->add(ArticleFilePeer::FILE_MIMETYPE_ID, $this->file_mimetype_id);

		return $criteria;
	}

	
	public function buildPkeyCriteria()
	{
		$criteria = new Criteria(ArticleFilePeer::DATABASE_NAME);

		$criteria->add(ArticleFilePeer::ID, $this->id);

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

		$copyObj->setFilename($this->filename);

		$copyObj->setPath($this->path);

		$copyObj->setUploadedBy($this->uploaded_by);

		$copyObj->setUploadedAt($this->uploaded_at);

		$copyObj->setDescription($this->description);

		$copyObj->setFileMimetypeId($this->file_mimetype_id);


		if ($deepCopy) {
									$copyObj->setNew(false);

			foreach($this->getArticles() as $relObj) {
				$copyObj->addArticle($relObj->copy($deepCopy));
			}

			foreach($this->getArticleAttachments() as $relObj) {
				$copyObj->addArticleAttachment($relObj->copy($deepCopy));
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
			self::$peer = new ArticleFilePeer();
		}
		return self::$peer;
	}

	
	public function setsfGuardUser($v)
	{


		if ($v === null) {
			$this->setUploadedBy(NULL);
		} else {
			$this->setUploadedBy($v->getId());
		}


		$this->asfGuardUser = $v;
	}


	
	public function getsfGuardUser($con = null)
	{
		if ($this->asfGuardUser === null && ($this->uploaded_by !== null)) {
						include_once 'plugins/sfGuardPlugin/lib/model/om/BasesfGuardUserPeer.php';

			$this->asfGuardUser = sfGuardUserPeer::retrieveByPK($this->uploaded_by, $con);

			
		}
		return $this->asfGuardUser;
	}

	
	public function setFileMimetype($v)
	{


		if ($v === null) {
			$this->setFileMimetypeId(NULL);
		} else {
			$this->setFileMimetypeId($v->getId());
		}


		$this->aFileMimetype = $v;
	}


	
	public function getFileMimetype($con = null)
	{
		if ($this->aFileMimetype === null && ($this->file_mimetype_id !== null)) {
						include_once 'lib/model/om/BaseFileMimetypePeer.php';

			$this->aFileMimetype = FileMimetypePeer::retrieveByPK($this->file_mimetype_id, $con);

			
		}
		return $this->aFileMimetype;
	}

	
	public function initArticles()
	{
		if ($this->collArticles === null) {
			$this->collArticles = array();
		}
	}

	
	public function getArticles($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseArticlePeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collArticles === null) {
			if ($this->isNew()) {
			   $this->collArticles = array();
			} else {

				$criteria->add(ArticlePeer::BANNER_FILE_ID, $this->getId());

				ArticlePeer::addSelectColumns($criteria);
				$this->collArticles = ArticlePeer::doSelect($criteria, $con);
			}
		} else {
						if (!$this->isNew()) {
												

				$criteria->add(ArticlePeer::BANNER_FILE_ID, $this->getId());

				ArticlePeer::addSelectColumns($criteria);
				if (!isset($this->lastArticleCriteria) || !$this->lastArticleCriteria->equals($criteria)) {
					$this->collArticles = ArticlePeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastArticleCriteria = $criteria;
		return $this->collArticles;
	}

	
	public function countArticles($criteria = null, $distinct = false, $con = null)
	{
				include_once 'lib/model/om/BaseArticlePeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(ArticlePeer::BANNER_FILE_ID, $this->getId());

		return ArticlePeer::doCount($criteria, $distinct, $con);
	}

	
	public function addArticle(Article $l)
	{
		$this->collArticles[] = $l;
		$l->setArticleFile($this);
	}


	
	public function getArticlesJoinsfGuardUser($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseArticlePeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collArticles === null) {
			if ($this->isNew()) {
				$this->collArticles = array();
			} else {

				$criteria->add(ArticlePeer::BANNER_FILE_ID, $this->getId());

				$this->collArticles = ArticlePeer::doSelectJoinsfGuardUser($criteria, $con);
			}
		} else {
									
			$criteria->add(ArticlePeer::BANNER_FILE_ID, $this->getId());

			if (!isset($this->lastArticleCriteria) || !$this->lastArticleCriteria->equals($criteria)) {
				$this->collArticles = ArticlePeer::doSelectJoinsfGuardUser($criteria, $con);
			}
		}
		$this->lastArticleCriteria = $criteria;

		return $this->collArticles;
	}

	
	public function initArticleAttachments()
	{
		if ($this->collArticleAttachments === null) {
			$this->collArticleAttachments = array();
		}
	}

	
	public function getArticleAttachments($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseArticleAttachmentPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collArticleAttachments === null) {
			if ($this->isNew()) {
			   $this->collArticleAttachments = array();
			} else {

				$criteria->add(ArticleAttachmentPeer::FILE_ID, $this->getId());

				ArticleAttachmentPeer::addSelectColumns($criteria);
				$this->collArticleAttachments = ArticleAttachmentPeer::doSelect($criteria, $con);
			}
		} else {
						if (!$this->isNew()) {
												

				$criteria->add(ArticleAttachmentPeer::FILE_ID, $this->getId());

				ArticleAttachmentPeer::addSelectColumns($criteria);
				if (!isset($this->lastArticleAttachmentCriteria) || !$this->lastArticleAttachmentCriteria->equals($criteria)) {
					$this->collArticleAttachments = ArticleAttachmentPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastArticleAttachmentCriteria = $criteria;
		return $this->collArticleAttachments;
	}

	
	public function countArticleAttachments($criteria = null, $distinct = false, $con = null)
	{
				include_once 'lib/model/om/BaseArticleAttachmentPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(ArticleAttachmentPeer::FILE_ID, $this->getId());

		return ArticleAttachmentPeer::doCount($criteria, $distinct, $con);
	}

	
	public function addArticleAttachment(ArticleAttachment $l)
	{
		$this->collArticleAttachments[] = $l;
		$l->setArticleFile($this);
	}


	
	public function getArticleAttachmentsJoinArticle($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseArticleAttachmentPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collArticleAttachments === null) {
			if ($this->isNew()) {
				$this->collArticleAttachments = array();
			} else {

				$criteria->add(ArticleAttachmentPeer::FILE_ID, $this->getId());

				$this->collArticleAttachments = ArticleAttachmentPeer::doSelectJoinArticle($criteria, $con);
			}
		} else {
									
			$criteria->add(ArticleAttachmentPeer::FILE_ID, $this->getId());

			if (!isset($this->lastArticleAttachmentCriteria) || !$this->lastArticleAttachmentCriteria->equals($criteria)) {
				$this->collArticleAttachments = ArticleAttachmentPeer::doSelectJoinArticle($criteria, $con);
			}
		}
		$this->lastArticleAttachmentCriteria = $criteria;

		return $this->collArticleAttachments;
	}


  public function __call($method, $arguments)
  {
    if (!$callable = sfMixer::getCallable('BaseArticleFile:'.$method))
    {
      throw new sfException(sprintf('Call to undefined method BaseArticleFile::%s', $method));
    }

    array_unshift($arguments, $this);

    return call_user_func_array($callable, $arguments);
  }


} 