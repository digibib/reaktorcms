<?php


abstract class BaseCategory extends BaseObject  implements Persistent {


	
	protected static $peer;


	
	protected $id;


	
	protected $basename;

	
	protected $collCategoryI18ns;

	
	protected $lastCategoryI18nCriteria = null;

	
	protected $collCategoryArtworks;

	
	protected $lastCategoryArtworkCriteria = null;

	
	protected $collCategorySubreaktors;

	
	protected $lastCategorySubreaktorCriteria = null;

	
	protected $collArticleCategorys;

	
	protected $lastArticleCategoryCriteria = null;

	
	protected $alreadyInSave = false;

	
	protected $alreadyInValidation = false;

  
  protected $culture;

	
	public function getId()
	{

		return $this->id;
	}

	
	public function getBasename()
	{

		return $this->basename;
	}

	
	public function setId($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->id !== $v) {
			$this->id = $v;
			$this->modifiedColumns[] = CategoryPeer::ID;
		}

	} 
	
	public function setBasename($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->basename !== $v) {
			$this->basename = $v;
			$this->modifiedColumns[] = CategoryPeer::BASENAME;
		}

	} 
	
	public function hydrate(ResultSet $rs, $startcol = 1)
	{
		try {

			$this->id = $rs->getInt($startcol + 0);

			$this->basename = $rs->getString($startcol + 1);

			$this->resetModified();

			$this->setNew(false);

						return $startcol + 2; 
		} catch (Exception $e) {
			throw new PropelException("Error populating Category object", $e);
		}
	}

	
	public function delete($con = null)
	{

    foreach (sfMixer::getCallables('BaseCategory:delete:pre') as $callable)
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
			$con = Propel::getConnection(CategoryPeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			CategoryPeer::doDelete($this, $con);
			$this->setDeleted(true);
			$con->commit();
		} catch (PropelException $e) {
			$con->rollback();
			throw $e;
		}
	

    foreach (sfMixer::getCallables('BaseCategory:delete:post') as $callable)
    {
      call_user_func($callable, $this, $con);
    }

  }
	
	public function save($con = null)
	{

    foreach (sfMixer::getCallables('BaseCategory:save:pre') as $callable)
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
			$con = Propel::getConnection(CategoryPeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			$affectedRows = $this->doSave($con);
			$con->commit();
    foreach (sfMixer::getCallables('BaseCategory:save:post') as $callable)
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
					$pk = CategoryPeer::doInsert($this, $con);
					$affectedRows += 1; 										 										 
					$this->setId($pk);  
					$this->setNew(false);
				} else {
					$affectedRows += CategoryPeer::doUpdate($this, $con);
				}
				$this->resetModified(); 			}

			if ($this->collCategoryI18ns !== null) {
				foreach($this->collCategoryI18ns as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collCategoryArtworks !== null) {
				foreach($this->collCategoryArtworks as $referrerFK) {
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

			if ($this->collArticleCategorys !== null) {
				foreach($this->collArticleCategorys as $referrerFK) {
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


			if (($retval = CategoryPeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}


				if ($this->collCategoryI18ns !== null) {
					foreach($this->collCategoryI18ns as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collCategoryArtworks !== null) {
					foreach($this->collCategoryArtworks as $referrerFK) {
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

				if ($this->collArticleCategorys !== null) {
					foreach($this->collArticleCategorys as $referrerFK) {
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
		$pos = CategoryPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->getByPosition($pos);
	}

	
	public function getByPosition($pos)
	{
		switch($pos) {
			case 0:
				return $this->getId();
				break;
			case 1:
				return $this->getBasename();
				break;
			default:
				return null;
				break;
		} 	}

	
	public function toArray($keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = CategoryPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getId(),
			$keys[1] => $this->getBasename(),
		);
		return $result;
	}

	
	public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = CategoryPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->setByPosition($pos, $value);
	}

	
	public function setByPosition($pos, $value)
	{
		switch($pos) {
			case 0:
				$this->setId($value);
				break;
			case 1:
				$this->setBasename($value);
				break;
		} 	}

	
	public function fromArray($arr, $keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = CategoryPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setBasename($arr[$keys[1]]);
	}

	
	public function buildCriteria()
	{
		$criteria = new Criteria(CategoryPeer::DATABASE_NAME);

		if ($this->isColumnModified(CategoryPeer::ID)) $criteria->add(CategoryPeer::ID, $this->id);
		if ($this->isColumnModified(CategoryPeer::BASENAME)) $criteria->add(CategoryPeer::BASENAME, $this->basename);

		return $criteria;
	}

	
	public function buildPkeyCriteria()
	{
		$criteria = new Criteria(CategoryPeer::DATABASE_NAME);

		$criteria->add(CategoryPeer::ID, $this->id);

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

		$copyObj->setBasename($this->basename);


		if ($deepCopy) {
									$copyObj->setNew(false);

			foreach($this->getCategoryI18ns() as $relObj) {
				$copyObj->addCategoryI18n($relObj->copy($deepCopy));
			}

			foreach($this->getCategoryArtworks() as $relObj) {
				$copyObj->addCategoryArtwork($relObj->copy($deepCopy));
			}

			foreach($this->getCategorySubreaktors() as $relObj) {
				$copyObj->addCategorySubreaktor($relObj->copy($deepCopy));
			}

			foreach($this->getArticleCategorys() as $relObj) {
				$copyObj->addArticleCategory($relObj->copy($deepCopy));
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
			self::$peer = new CategoryPeer();
		}
		return self::$peer;
	}

	
	public function initCategoryI18ns()
	{
		if ($this->collCategoryI18ns === null) {
			$this->collCategoryI18ns = array();
		}
	}

	
	public function getCategoryI18ns($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseCategoryI18nPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collCategoryI18ns === null) {
			if ($this->isNew()) {
			   $this->collCategoryI18ns = array();
			} else {

				$criteria->add(CategoryI18nPeer::ID, $this->getId());

				CategoryI18nPeer::addSelectColumns($criteria);
				$this->collCategoryI18ns = CategoryI18nPeer::doSelect($criteria, $con);
			}
		} else {
						if (!$this->isNew()) {
												

				$criteria->add(CategoryI18nPeer::ID, $this->getId());

				CategoryI18nPeer::addSelectColumns($criteria);
				if (!isset($this->lastCategoryI18nCriteria) || !$this->lastCategoryI18nCriteria->equals($criteria)) {
					$this->collCategoryI18ns = CategoryI18nPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastCategoryI18nCriteria = $criteria;
		return $this->collCategoryI18ns;
	}

	
	public function countCategoryI18ns($criteria = null, $distinct = false, $con = null)
	{
				include_once 'lib/model/om/BaseCategoryI18nPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(CategoryI18nPeer::ID, $this->getId());

		return CategoryI18nPeer::doCount($criteria, $distinct, $con);
	}

	
	public function addCategoryI18n(CategoryI18n $l)
	{
		$this->collCategoryI18ns[] = $l;
		$l->setCategory($this);
	}

	
	public function initCategoryArtworks()
	{
		if ($this->collCategoryArtworks === null) {
			$this->collCategoryArtworks = array();
		}
	}

	
	public function getCategoryArtworks($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseCategoryArtworkPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collCategoryArtworks === null) {
			if ($this->isNew()) {
			   $this->collCategoryArtworks = array();
			} else {

				$criteria->add(CategoryArtworkPeer::CATEGORY_ID, $this->getId());

				CategoryArtworkPeer::addSelectColumns($criteria);
				$this->collCategoryArtworks = CategoryArtworkPeer::doSelect($criteria, $con);
			}
		} else {
						if (!$this->isNew()) {
												

				$criteria->add(CategoryArtworkPeer::CATEGORY_ID, $this->getId());

				CategoryArtworkPeer::addSelectColumns($criteria);
				if (!isset($this->lastCategoryArtworkCriteria) || !$this->lastCategoryArtworkCriteria->equals($criteria)) {
					$this->collCategoryArtworks = CategoryArtworkPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastCategoryArtworkCriteria = $criteria;
		return $this->collCategoryArtworks;
	}

	
	public function countCategoryArtworks($criteria = null, $distinct = false, $con = null)
	{
				include_once 'lib/model/om/BaseCategoryArtworkPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(CategoryArtworkPeer::CATEGORY_ID, $this->getId());

		return CategoryArtworkPeer::doCount($criteria, $distinct, $con);
	}

	
	public function addCategoryArtwork(CategoryArtwork $l)
	{
		$this->collCategoryArtworks[] = $l;
		$l->setCategory($this);
	}


	
	public function getCategoryArtworksJoinReaktorArtwork($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseCategoryArtworkPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collCategoryArtworks === null) {
			if ($this->isNew()) {
				$this->collCategoryArtworks = array();
			} else {

				$criteria->add(CategoryArtworkPeer::CATEGORY_ID, $this->getId());

				$this->collCategoryArtworks = CategoryArtworkPeer::doSelectJoinReaktorArtwork($criteria, $con);
			}
		} else {
									
			$criteria->add(CategoryArtworkPeer::CATEGORY_ID, $this->getId());

			if (!isset($this->lastCategoryArtworkCriteria) || !$this->lastCategoryArtworkCriteria->equals($criteria)) {
				$this->collCategoryArtworks = CategoryArtworkPeer::doSelectJoinReaktorArtwork($criteria, $con);
			}
		}
		$this->lastCategoryArtworkCriteria = $criteria;

		return $this->collCategoryArtworks;
	}


	
	public function getCategoryArtworksJoinsfGuardUser($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseCategoryArtworkPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collCategoryArtworks === null) {
			if ($this->isNew()) {
				$this->collCategoryArtworks = array();
			} else {

				$criteria->add(CategoryArtworkPeer::CATEGORY_ID, $this->getId());

				$this->collCategoryArtworks = CategoryArtworkPeer::doSelectJoinsfGuardUser($criteria, $con);
			}
		} else {
									
			$criteria->add(CategoryArtworkPeer::CATEGORY_ID, $this->getId());

			if (!isset($this->lastCategoryArtworkCriteria) || !$this->lastCategoryArtworkCriteria->equals($criteria)) {
				$this->collCategoryArtworks = CategoryArtworkPeer::doSelectJoinsfGuardUser($criteria, $con);
			}
		}
		$this->lastCategoryArtworkCriteria = $criteria;

		return $this->collCategoryArtworks;
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

				$criteria->add(CategorySubreaktorPeer::CATEGORY_ID, $this->getId());

				CategorySubreaktorPeer::addSelectColumns($criteria);
				$this->collCategorySubreaktors = CategorySubreaktorPeer::doSelect($criteria, $con);
			}
		} else {
						if (!$this->isNew()) {
												

				$criteria->add(CategorySubreaktorPeer::CATEGORY_ID, $this->getId());

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

		$criteria->add(CategorySubreaktorPeer::CATEGORY_ID, $this->getId());

		return CategorySubreaktorPeer::doCount($criteria, $distinct, $con);
	}

	
	public function addCategorySubreaktor(CategorySubreaktor $l)
	{
		$this->collCategorySubreaktors[] = $l;
		$l->setCategory($this);
	}


	
	public function getCategorySubreaktorsJoinSubreaktor($criteria = null, $con = null)
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

				$criteria->add(CategorySubreaktorPeer::CATEGORY_ID, $this->getId());

				$this->collCategorySubreaktors = CategorySubreaktorPeer::doSelectJoinSubreaktor($criteria, $con);
			}
		} else {
									
			$criteria->add(CategorySubreaktorPeer::CATEGORY_ID, $this->getId());

			if (!isset($this->lastCategorySubreaktorCriteria) || !$this->lastCategorySubreaktorCriteria->equals($criteria)) {
				$this->collCategorySubreaktors = CategorySubreaktorPeer::doSelectJoinSubreaktor($criteria, $con);
			}
		}
		$this->lastCategorySubreaktorCriteria = $criteria;

		return $this->collCategorySubreaktors;
	}

	
	public function initArticleCategorys()
	{
		if ($this->collArticleCategorys === null) {
			$this->collArticleCategorys = array();
		}
	}

	
	public function getArticleCategorys($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseArticleCategoryPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collArticleCategorys === null) {
			if ($this->isNew()) {
			   $this->collArticleCategorys = array();
			} else {

				$criteria->add(ArticleCategoryPeer::CATEGORY_ID, $this->getId());

				ArticleCategoryPeer::addSelectColumns($criteria);
				$this->collArticleCategorys = ArticleCategoryPeer::doSelect($criteria, $con);
			}
		} else {
						if (!$this->isNew()) {
												

				$criteria->add(ArticleCategoryPeer::CATEGORY_ID, $this->getId());

				ArticleCategoryPeer::addSelectColumns($criteria);
				if (!isset($this->lastArticleCategoryCriteria) || !$this->lastArticleCategoryCriteria->equals($criteria)) {
					$this->collArticleCategorys = ArticleCategoryPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastArticleCategoryCriteria = $criteria;
		return $this->collArticleCategorys;
	}

	
	public function countArticleCategorys($criteria = null, $distinct = false, $con = null)
	{
				include_once 'lib/model/om/BaseArticleCategoryPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(ArticleCategoryPeer::CATEGORY_ID, $this->getId());

		return ArticleCategoryPeer::doCount($criteria, $distinct, $con);
	}

	
	public function addArticleCategory(ArticleCategory $l)
	{
		$this->collArticleCategorys[] = $l;
		$l->setCategory($this);
	}


	
	public function getArticleCategorysJoinArticle($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseArticleCategoryPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collArticleCategorys === null) {
			if ($this->isNew()) {
				$this->collArticleCategorys = array();
			} else {

				$criteria->add(ArticleCategoryPeer::CATEGORY_ID, $this->getId());

				$this->collArticleCategorys = ArticleCategoryPeer::doSelectJoinArticle($criteria, $con);
			}
		} else {
									
			$criteria->add(ArticleCategoryPeer::CATEGORY_ID, $this->getId());

			if (!isset($this->lastArticleCategoryCriteria) || !$this->lastArticleCategoryCriteria->equals($criteria)) {
				$this->collArticleCategorys = ArticleCategoryPeer::doSelectJoinArticle($criteria, $con);
			}
		}
		$this->lastArticleCategoryCriteria = $criteria;

		return $this->collArticleCategorys;
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
    $obj = $this->getCurrentCategoryI18n();

    return ($obj ? $obj->getName() : null);
  }

  public function setName($value)
  {
    $this->getCurrentCategoryI18n()->setName($value);
  }

  protected $current_i18n = array();

  public function getCurrentCategoryI18n()
  {
    if (!isset($this->current_i18n[$this->culture]))
    {
      $obj = CategoryI18nPeer::retrieveByPK($this->getId(), $this->culture);
      if ($obj)
      {
        $this->setCategoryI18nForCulture($obj, $this->culture);
      }
      else
      {
        $this->setCategoryI18nForCulture(new CategoryI18n(), $this->culture);
        $this->current_i18n[$this->culture]->setCulture($this->culture);
      }
    }

    return $this->current_i18n[$this->culture];
  }

  public function setCategoryI18nForCulture($object, $culture)
  {
    $this->current_i18n[$culture] = $object;
    $this->addCategoryI18n($object);
  }


  public function __call($method, $arguments)
  {
    if (!$callable = sfMixer::getCallable('BaseCategory:'.$method))
    {
      throw new sfException(sprintf('Call to undefined method BaseCategory::%s', $method));
    }

    array_unshift($arguments, $this);

    return call_user_func_array($callable, $arguments);
  }


} 