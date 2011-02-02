<?php


abstract class BaseArticleArticleRelation extends BaseObject  implements Persistent {


	
	protected static $peer;


	
	protected $id;


	
	protected $created_at;


	
	protected $first_article;


	
	protected $second_article;


	
	protected $created_by;

	
	protected $aArticleRelatedByFirstArticle;

	
	protected $aArticleRelatedBySecondArticle;

	
	protected $asfGuardUser;

	
	protected $alreadyInSave = false;

	
	protected $alreadyInValidation = false;

	
	public function getId()
	{

		return $this->id;
	}

	
	public function getCreatedAt($format = 'Y-m-d H:i:s')
	{

		if ($this->created_at === null || $this->created_at === '') {
			return null;
		} elseif (!is_int($this->created_at)) {
						$ts = strtotime($this->created_at);
			if ($ts === -1 || $ts === false) { 				throw new PropelException("Unable to parse value of [created_at] as date/time value: " . var_export($this->created_at, true));
			}
		} else {
			$ts = $this->created_at;
		}
		if ($format === null) {
			return $ts;
		} elseif (strpos($format, '%') !== false) {
			return strftime($format, $ts);
		} else {
			return date($format, $ts);
		}
	}

	
	public function getFirstArticle()
	{

		return $this->first_article;
	}

	
	public function getSecondArticle()
	{

		return $this->second_article;
	}

	
	public function getCreatedBy()
	{

		return $this->created_by;
	}

	
	public function setId($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->id !== $v) {
			$this->id = $v;
			$this->modifiedColumns[] = ArticleArticleRelationPeer::ID;
		}

	} 
	
	public function setCreatedAt($v)
	{

		if ($v !== null && !is_int($v)) {
			$ts = strtotime($v);
			if ($ts === -1 || $ts === false) { 				throw new PropelException("Unable to parse date/time value for [created_at] from input: " . var_export($v, true));
			}
		} else {
			$ts = $v;
		}
		if ($this->created_at !== $ts) {
			$this->created_at = $ts;
			$this->modifiedColumns[] = ArticleArticleRelationPeer::CREATED_AT;
		}

	} 
	
	public function setFirstArticle($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->first_article !== $v) {
			$this->first_article = $v;
			$this->modifiedColumns[] = ArticleArticleRelationPeer::FIRST_ARTICLE;
		}

		if ($this->aArticleRelatedByFirstArticle !== null && $this->aArticleRelatedByFirstArticle->getId() !== $v) {
			$this->aArticleRelatedByFirstArticle = null;
		}

	} 
	
	public function setSecondArticle($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->second_article !== $v) {
			$this->second_article = $v;
			$this->modifiedColumns[] = ArticleArticleRelationPeer::SECOND_ARTICLE;
		}

		if ($this->aArticleRelatedBySecondArticle !== null && $this->aArticleRelatedBySecondArticle->getId() !== $v) {
			$this->aArticleRelatedBySecondArticle = null;
		}

	} 
	
	public function setCreatedBy($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->created_by !== $v) {
			$this->created_by = $v;
			$this->modifiedColumns[] = ArticleArticleRelationPeer::CREATED_BY;
		}

		if ($this->asfGuardUser !== null && $this->asfGuardUser->getId() !== $v) {
			$this->asfGuardUser = null;
		}

	} 
	
	public function hydrate(ResultSet $rs, $startcol = 1)
	{
		try {

			$this->id = $rs->getInt($startcol + 0);

			$this->created_at = $rs->getTimestamp($startcol + 1, null);

			$this->first_article = $rs->getInt($startcol + 2);

			$this->second_article = $rs->getInt($startcol + 3);

			$this->created_by = $rs->getInt($startcol + 4);

			$this->resetModified();

			$this->setNew(false);

						return $startcol + 5; 
		} catch (Exception $e) {
			throw new PropelException("Error populating ArticleArticleRelation object", $e);
		}
	}

	
	public function delete($con = null)
	{

    foreach (sfMixer::getCallables('BaseArticleArticleRelation:delete:pre') as $callable)
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
			$con = Propel::getConnection(ArticleArticleRelationPeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			ArticleArticleRelationPeer::doDelete($this, $con);
			$this->setDeleted(true);
			$con->commit();
		} catch (PropelException $e) {
			$con->rollback();
			throw $e;
		}
	

    foreach (sfMixer::getCallables('BaseArticleArticleRelation:delete:post') as $callable)
    {
      call_user_func($callable, $this, $con);
    }

  }
	
	public function save($con = null)
	{

    foreach (sfMixer::getCallables('BaseArticleArticleRelation:save:pre') as $callable)
    {
      $affectedRows = call_user_func($callable, $this, $con);
      if (is_int($affectedRows))
      {
        return $affectedRows;
      }
    }


    if ($this->isNew() && !$this->isColumnModified(ArticleArticleRelationPeer::CREATED_AT))
    {
      $this->setCreatedAt(time());
    }

		if ($this->isDeleted()) {
			throw new PropelException("You cannot save an object that has been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(ArticleArticleRelationPeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			$affectedRows = $this->doSave($con);
			$con->commit();
    foreach (sfMixer::getCallables('BaseArticleArticleRelation:save:post') as $callable)
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


												
			if ($this->aArticleRelatedByFirstArticle !== null) {
				if ($this->aArticleRelatedByFirstArticle->isModified() || $this->aArticleRelatedByFirstArticle->getCurrentArticleI18n()->isModified()) {
					$affectedRows += $this->aArticleRelatedByFirstArticle->save($con);
				}
				$this->setArticleRelatedByFirstArticle($this->aArticleRelatedByFirstArticle);
			}

			if ($this->aArticleRelatedBySecondArticle !== null) {
				if ($this->aArticleRelatedBySecondArticle->isModified() || $this->aArticleRelatedBySecondArticle->getCurrentArticleI18n()->isModified()) {
					$affectedRows += $this->aArticleRelatedBySecondArticle->save($con);
				}
				$this->setArticleRelatedBySecondArticle($this->aArticleRelatedBySecondArticle);
			}

			if ($this->asfGuardUser !== null) {
				if ($this->asfGuardUser->isModified()) {
					$affectedRows += $this->asfGuardUser->save($con);
				}
				$this->setsfGuardUser($this->asfGuardUser);
			}


						if ($this->isModified()) {
				if ($this->isNew()) {
					$pk = ArticleArticleRelationPeer::doInsert($this, $con);
					$affectedRows += 1; 										 										 
					$this->setId($pk);  
					$this->setNew(false);
				} else {
					$affectedRows += ArticleArticleRelationPeer::doUpdate($this, $con);
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


												
			if ($this->aArticleRelatedByFirstArticle !== null) {
				if (!$this->aArticleRelatedByFirstArticle->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aArticleRelatedByFirstArticle->getValidationFailures());
				}
			}

			if ($this->aArticleRelatedBySecondArticle !== null) {
				if (!$this->aArticleRelatedBySecondArticle->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aArticleRelatedBySecondArticle->getValidationFailures());
				}
			}

			if ($this->asfGuardUser !== null) {
				if (!$this->asfGuardUser->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->asfGuardUser->getValidationFailures());
				}
			}


			if (($retval = ArticleArticleRelationPeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}



			$this->alreadyInValidation = false;
		}

		return (!empty($failureMap) ? $failureMap : true);
	}

	
	public function getByName($name, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = ArticleArticleRelationPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->getByPosition($pos);
	}

	
	public function getByPosition($pos)
	{
		switch($pos) {
			case 0:
				return $this->getId();
				break;
			case 1:
				return $this->getCreatedAt();
				break;
			case 2:
				return $this->getFirstArticle();
				break;
			case 3:
				return $this->getSecondArticle();
				break;
			case 4:
				return $this->getCreatedBy();
				break;
			default:
				return null;
				break;
		} 	}

	
	public function toArray($keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = ArticleArticleRelationPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getId(),
			$keys[1] => $this->getCreatedAt(),
			$keys[2] => $this->getFirstArticle(),
			$keys[3] => $this->getSecondArticle(),
			$keys[4] => $this->getCreatedBy(),
		);
		return $result;
	}

	
	public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = ArticleArticleRelationPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->setByPosition($pos, $value);
	}

	
	public function setByPosition($pos, $value)
	{
		switch($pos) {
			case 0:
				$this->setId($value);
				break;
			case 1:
				$this->setCreatedAt($value);
				break;
			case 2:
				$this->setFirstArticle($value);
				break;
			case 3:
				$this->setSecondArticle($value);
				break;
			case 4:
				$this->setCreatedBy($value);
				break;
		} 	}

	
	public function fromArray($arr, $keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = ArticleArticleRelationPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setCreatedAt($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setFirstArticle($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setSecondArticle($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setCreatedBy($arr[$keys[4]]);
	}

	
	public function buildCriteria()
	{
		$criteria = new Criteria(ArticleArticleRelationPeer::DATABASE_NAME);

		if ($this->isColumnModified(ArticleArticleRelationPeer::ID)) $criteria->add(ArticleArticleRelationPeer::ID, $this->id);
		if ($this->isColumnModified(ArticleArticleRelationPeer::CREATED_AT)) $criteria->add(ArticleArticleRelationPeer::CREATED_AT, $this->created_at);
		if ($this->isColumnModified(ArticleArticleRelationPeer::FIRST_ARTICLE)) $criteria->add(ArticleArticleRelationPeer::FIRST_ARTICLE, $this->first_article);
		if ($this->isColumnModified(ArticleArticleRelationPeer::SECOND_ARTICLE)) $criteria->add(ArticleArticleRelationPeer::SECOND_ARTICLE, $this->second_article);
		if ($this->isColumnModified(ArticleArticleRelationPeer::CREATED_BY)) $criteria->add(ArticleArticleRelationPeer::CREATED_BY, $this->created_by);

		return $criteria;
	}

	
	public function buildPkeyCriteria()
	{
		$criteria = new Criteria(ArticleArticleRelationPeer::DATABASE_NAME);

		$criteria->add(ArticleArticleRelationPeer::ID, $this->id);

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

		$copyObj->setCreatedAt($this->created_at);

		$copyObj->setFirstArticle($this->first_article);

		$copyObj->setSecondArticle($this->second_article);

		$copyObj->setCreatedBy($this->created_by);


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
			self::$peer = new ArticleArticleRelationPeer();
		}
		return self::$peer;
	}

	
	public function setArticleRelatedByFirstArticle($v)
	{


		if ($v === null) {
			$this->setFirstArticle(NULL);
		} else {
			$this->setFirstArticle($v->getId());
		}


		$this->aArticleRelatedByFirstArticle = $v;
	}


	
	public function getArticleRelatedByFirstArticle($con = null)
	{
		if ($this->aArticleRelatedByFirstArticle === null && ($this->first_article !== null)) {
						include_once 'lib/model/om/BaseArticlePeer.php';

			$this->aArticleRelatedByFirstArticle = ArticlePeer::retrieveByPK($this->first_article, $con);

			
		}
		return $this->aArticleRelatedByFirstArticle;
	}

	
	public function setArticleRelatedBySecondArticle($v)
	{


		if ($v === null) {
			$this->setSecondArticle(NULL);
		} else {
			$this->setSecondArticle($v->getId());
		}


		$this->aArticleRelatedBySecondArticle = $v;
	}


	
	public function getArticleRelatedBySecondArticle($con = null)
	{
		if ($this->aArticleRelatedBySecondArticle === null && ($this->second_article !== null)) {
						include_once 'lib/model/om/BaseArticlePeer.php';

			$this->aArticleRelatedBySecondArticle = ArticlePeer::retrieveByPK($this->second_article, $con);

			
		}
		return $this->aArticleRelatedBySecondArticle;
	}

	
	public function setsfGuardUser($v)
	{


		if ($v === null) {
			$this->setCreatedBy(NULL);
		} else {
			$this->setCreatedBy($v->getId());
		}


		$this->asfGuardUser = $v;
	}


	
	public function getsfGuardUser($con = null)
	{
		if ($this->asfGuardUser === null && ($this->created_by !== null)) {
						include_once 'plugins/sfGuardPlugin/lib/model/om/BasesfGuardUserPeer.php';

			$this->asfGuardUser = sfGuardUserPeer::retrieveByPK($this->created_by, $con);

			
		}
		return $this->asfGuardUser;
	}


  public function __call($method, $arguments)
  {
    if (!$callable = sfMixer::getCallable('BaseArticleArticleRelation:'.$method))
    {
      throw new sfException(sprintf('Call to undefined method BaseArticleArticleRelation::%s', $method));
    }

    array_unshift($arguments, $this);

    return call_user_func_array($callable, $arguments);
  }


} 