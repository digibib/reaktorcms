<?php


abstract class BaseArticle extends BaseObject  implements Persistent {


	
	protected static $peer;


	
	protected $id;


	
	protected $created_at;


	
	protected $author_id;


	
	protected $base_title;


	
	protected $permalink;


	
	protected $ingress;


	
	protected $content;


	
	protected $updated_at;


	
	protected $updated_by = 0;


	
	protected $article_type;


	
	protected $article_order;


	
	protected $expires_at;


	
	protected $status;


	
	protected $published_at;


	
	protected $banner_file_id = 0;


	
	protected $is_sticky = false;


	
	protected $frontpage = 0;

	
	protected $asfGuardUser;

	
	protected $aArticleFile;

	
	protected $collArticleI18ns;

	
	protected $lastArticleI18nCriteria = null;

	
	protected $collArticleArticleRelationsRelatedByFirstArticle;

	
	protected $lastArticleArticleRelationRelatedByFirstArticleCriteria = null;

	
	protected $collArticleArticleRelationsRelatedBySecondArticle;

	
	protected $lastArticleArticleRelationRelatedBySecondArticleCriteria = null;

	
	protected $collArticleArtworkRelations;

	
	protected $lastArticleArtworkRelationCriteria = null;

	
	protected $collArticleCategorys;

	
	protected $lastArticleCategoryCriteria = null;

	
	protected $collArticleSubreaktors;

	
	protected $lastArticleSubreaktorCriteria = null;

	
	protected $collArticleAttachments;

	
	protected $lastArticleAttachmentCriteria = null;

	
	protected $collFavourites;

	
	protected $lastFavouriteCriteria = null;

	
	protected $alreadyInSave = false;

	
	protected $alreadyInValidation = false;

  
  protected $culture;

	
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

	
	public function getAuthorId()
	{

		return $this->author_id;
	}

	
	public function getBaseTitle()
	{

		return $this->base_title;
	}

	
	public function getPermalink()
	{

		return $this->permalink;
	}

	
	public function getIngress()
	{

		return $this->ingress;
	}

	
	public function getContent()
	{

		return $this->content;
	}

	
	public function getUpdatedAt($format = 'Y-m-d H:i:s')
	{

		if ($this->updated_at === null || $this->updated_at === '') {
			return null;
		} elseif (!is_int($this->updated_at)) {
						$ts = strtotime($this->updated_at);
			if ($ts === -1 || $ts === false) { 				throw new PropelException("Unable to parse value of [updated_at] as date/time value: " . var_export($this->updated_at, true));
			}
		} else {
			$ts = $this->updated_at;
		}
		if ($format === null) {
			return $ts;
		} elseif (strpos($format, '%') !== false) {
			return strftime($format, $ts);
		} else {
			return date($format, $ts);
		}
	}

	
	public function getUpdatedBy()
	{

		return $this->updated_by;
	}

	
	public function getArticleType()
	{

		return $this->article_type;
	}

	
	public function getArticleOrder()
	{

		return $this->article_order;
	}

	
	public function getExpiresAt($format = 'Y-m-d H:i:s')
	{

		if ($this->expires_at === null || $this->expires_at === '') {
			return null;
		} elseif (!is_int($this->expires_at)) {
						$ts = strtotime($this->expires_at);
			if ($ts === -1 || $ts === false) { 				throw new PropelException("Unable to parse value of [expires_at] as date/time value: " . var_export($this->expires_at, true));
			}
		} else {
			$ts = $this->expires_at;
		}
		if ($format === null) {
			return $ts;
		} elseif (strpos($format, '%') !== false) {
			return strftime($format, $ts);
		} else {
			return date($format, $ts);
		}
	}

	
	public function getStatus()
	{

		return $this->status;
	}

	
	public function getPublishedAt($format = 'Y-m-d H:i:s')
	{

		if ($this->published_at === null || $this->published_at === '') {
			return null;
		} elseif (!is_int($this->published_at)) {
						$ts = strtotime($this->published_at);
			if ($ts === -1 || $ts === false) { 				throw new PropelException("Unable to parse value of [published_at] as date/time value: " . var_export($this->published_at, true));
			}
		} else {
			$ts = $this->published_at;
		}
		if ($format === null) {
			return $ts;
		} elseif (strpos($format, '%') !== false) {
			return strftime($format, $ts);
		} else {
			return date($format, $ts);
		}
	}

	
	public function getBannerFileId()
	{

		return $this->banner_file_id;
	}

	
	public function getIsSticky()
	{

		return $this->is_sticky;
	}

	
	public function getFrontpage()
	{

		return $this->frontpage;
	}

	
	public function setId($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->id !== $v) {
			$this->id = $v;
			$this->modifiedColumns[] = ArticlePeer::ID;
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
			$this->modifiedColumns[] = ArticlePeer::CREATED_AT;
		}

	} 
	
	public function setAuthorId($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->author_id !== $v) {
			$this->author_id = $v;
			$this->modifiedColumns[] = ArticlePeer::AUTHOR_ID;
		}

		if ($this->asfGuardUser !== null && $this->asfGuardUser->getId() !== $v) {
			$this->asfGuardUser = null;
		}

	} 
	
	public function setBaseTitle($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->base_title !== $v) {
			$this->base_title = $v;
			$this->modifiedColumns[] = ArticlePeer::BASE_TITLE;
		}

	} 
	
	public function setPermalink($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->permalink !== $v) {
			$this->permalink = $v;
			$this->modifiedColumns[] = ArticlePeer::PERMALINK;
		}

	} 
	
	public function setIngress($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->ingress !== $v) {
			$this->ingress = $v;
			$this->modifiedColumns[] = ArticlePeer::INGRESS;
		}

	} 
	
	public function setContent($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->content !== $v) {
			$this->content = $v;
			$this->modifiedColumns[] = ArticlePeer::CONTENT;
		}

	} 
	
	public function setUpdatedAt($v)
	{

		if ($v !== null && !is_int($v)) {
			$ts = strtotime($v);
			if ($ts === -1 || $ts === false) { 				throw new PropelException("Unable to parse date/time value for [updated_at] from input: " . var_export($v, true));
			}
		} else {
			$ts = $v;
		}
		if ($this->updated_at !== $ts) {
			$this->updated_at = $ts;
			$this->modifiedColumns[] = ArticlePeer::UPDATED_AT;
		}

	} 
	
	public function setUpdatedBy($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->updated_by !== $v || $v === 0) {
			$this->updated_by = $v;
			$this->modifiedColumns[] = ArticlePeer::UPDATED_BY;
		}

	} 
	
	public function setArticleType($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->article_type !== $v) {
			$this->article_type = $v;
			$this->modifiedColumns[] = ArticlePeer::ARTICLE_TYPE;
		}

	} 
	
	public function setArticleOrder($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->article_order !== $v) {
			$this->article_order = $v;
			$this->modifiedColumns[] = ArticlePeer::ARTICLE_ORDER;
		}

	} 
	
	public function setExpiresAt($v)
	{

		if ($v !== null && !is_int($v)) {
			$ts = strtotime($v);
			if ($ts === -1 || $ts === false) { 				throw new PropelException("Unable to parse date/time value for [expires_at] from input: " . var_export($v, true));
			}
		} else {
			$ts = $v;
		}
		if ($this->expires_at !== $ts) {
			$this->expires_at = $ts;
			$this->modifiedColumns[] = ArticlePeer::EXPIRES_AT;
		}

	} 
	
	public function setStatus($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->status !== $v) {
			$this->status = $v;
			$this->modifiedColumns[] = ArticlePeer::STATUS;
		}

	} 
	
	public function setPublishedAt($v)
	{

		if ($v !== null && !is_int($v)) {
			$ts = strtotime($v);
			if ($ts === -1 || $ts === false) { 				throw new PropelException("Unable to parse date/time value for [published_at] from input: " . var_export($v, true));
			}
		} else {
			$ts = $v;
		}
		if ($this->published_at !== $ts) {
			$this->published_at = $ts;
			$this->modifiedColumns[] = ArticlePeer::PUBLISHED_AT;
		}

	} 
	
	public function setBannerFileId($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->banner_file_id !== $v || $v === 0) {
			$this->banner_file_id = $v;
			$this->modifiedColumns[] = ArticlePeer::BANNER_FILE_ID;
		}

		if ($this->aArticleFile !== null && $this->aArticleFile->getId() !== $v) {
			$this->aArticleFile = null;
		}

	} 
	
	public function setIsSticky($v)
	{

		if ($this->is_sticky !== $v || $v === false) {
			$this->is_sticky = $v;
			$this->modifiedColumns[] = ArticlePeer::IS_STICKY;
		}

	} 
	
	public function setFrontpage($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->frontpage !== $v || $v === 0) {
			$this->frontpage = $v;
			$this->modifiedColumns[] = ArticlePeer::FRONTPAGE;
		}

	} 
	
	public function hydrate(ResultSet $rs, $startcol = 1)
	{
		try {

			$this->id = $rs->getInt($startcol + 0);

			$this->created_at = $rs->getTimestamp($startcol + 1, null);

			$this->author_id = $rs->getInt($startcol + 2);

			$this->base_title = $rs->getString($startcol + 3);

			$this->permalink = $rs->getString($startcol + 4);

			$this->ingress = $rs->getString($startcol + 5);

			$this->content = $rs->getString($startcol + 6);

			$this->updated_at = $rs->getTimestamp($startcol + 7, null);

			$this->updated_by = $rs->getInt($startcol + 8);

			$this->article_type = $rs->getInt($startcol + 9);

			$this->article_order = $rs->getInt($startcol + 10);

			$this->expires_at = $rs->getTimestamp($startcol + 11, null);

			$this->status = $rs->getInt($startcol + 12);

			$this->published_at = $rs->getTimestamp($startcol + 13, null);

			$this->banner_file_id = $rs->getInt($startcol + 14);

			$this->is_sticky = $rs->getBoolean($startcol + 15);

			$this->frontpage = $rs->getInt($startcol + 16);

			$this->resetModified();

			$this->setNew(false);

						return $startcol + 17; 
		} catch (Exception $e) {
			throw new PropelException("Error populating Article object", $e);
		}
	}

	
	public function delete($con = null)
	{

    foreach (sfMixer::getCallables('BaseArticle:delete:pre') as $callable)
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
			$con = Propel::getConnection(ArticlePeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			ArticlePeer::doDelete($this, $con);
			$this->setDeleted(true);
			$con->commit();
		} catch (PropelException $e) {
			$con->rollback();
			throw $e;
		}
	

    foreach (sfMixer::getCallables('BaseArticle:delete:post') as $callable)
    {
      call_user_func($callable, $this, $con);
    }

  }
	
	public function save($con = null)
	{

    foreach (sfMixer::getCallables('BaseArticle:save:pre') as $callable)
    {
      $affectedRows = call_user_func($callable, $this, $con);
      if (is_int($affectedRows))
      {
        return $affectedRows;
      }
    }


    if ($this->isNew() && !$this->isColumnModified(ArticlePeer::CREATED_AT))
    {
      $this->setCreatedAt(time());
    }

    if ($this->isModified() && !$this->isColumnModified(ArticlePeer::UPDATED_AT))
    {
      $this->setUpdatedAt(time());
    }

		if ($this->isDeleted()) {
			throw new PropelException("You cannot save an object that has been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(ArticlePeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			$affectedRows = $this->doSave($con);
			$con->commit();
    foreach (sfMixer::getCallables('BaseArticle:save:post') as $callable)
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

			if ($this->aArticleFile !== null) {
				if ($this->aArticleFile->isModified()) {
					$affectedRows += $this->aArticleFile->save($con);
				}
				$this->setArticleFile($this->aArticleFile);
			}


						if ($this->isModified()) {
				if ($this->isNew()) {
					$pk = ArticlePeer::doInsert($this, $con);
					$affectedRows += 1; 										 										 
					$this->setId($pk);  
					$this->setNew(false);
				} else {
					$affectedRows += ArticlePeer::doUpdate($this, $con);
				}
				$this->resetModified(); 			}

			if ($this->collArticleI18ns !== null) {
				foreach($this->collArticleI18ns as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collArticleArticleRelationsRelatedByFirstArticle !== null) {
				foreach($this->collArticleArticleRelationsRelatedByFirstArticle as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collArticleArticleRelationsRelatedBySecondArticle !== null) {
				foreach($this->collArticleArticleRelationsRelatedBySecondArticle as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collArticleArtworkRelations !== null) {
				foreach($this->collArticleArtworkRelations as $referrerFK) {
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

			if ($this->collArticleSubreaktors !== null) {
				foreach($this->collArticleSubreaktors as $referrerFK) {
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

			if ($this->collFavourites !== null) {
				foreach($this->collFavourites as $referrerFK) {
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

			if ($this->aArticleFile !== null) {
				if (!$this->aArticleFile->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aArticleFile->getValidationFailures());
				}
			}


			if (($retval = ArticlePeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}


				if ($this->collArticleI18ns !== null) {
					foreach($this->collArticleI18ns as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collArticleArticleRelationsRelatedByFirstArticle !== null) {
					foreach($this->collArticleArticleRelationsRelatedByFirstArticle as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collArticleArticleRelationsRelatedBySecondArticle !== null) {
					foreach($this->collArticleArticleRelationsRelatedBySecondArticle as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collArticleArtworkRelations !== null) {
					foreach($this->collArticleArtworkRelations as $referrerFK) {
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

				if ($this->collArticleSubreaktors !== null) {
					foreach($this->collArticleSubreaktors as $referrerFK) {
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

				if ($this->collFavourites !== null) {
					foreach($this->collFavourites as $referrerFK) {
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
		$pos = ArticlePeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				return $this->getAuthorId();
				break;
			case 3:
				return $this->getBaseTitle();
				break;
			case 4:
				return $this->getPermalink();
				break;
			case 5:
				return $this->getIngress();
				break;
			case 6:
				return $this->getContent();
				break;
			case 7:
				return $this->getUpdatedAt();
				break;
			case 8:
				return $this->getUpdatedBy();
				break;
			case 9:
				return $this->getArticleType();
				break;
			case 10:
				return $this->getArticleOrder();
				break;
			case 11:
				return $this->getExpiresAt();
				break;
			case 12:
				return $this->getStatus();
				break;
			case 13:
				return $this->getPublishedAt();
				break;
			case 14:
				return $this->getBannerFileId();
				break;
			case 15:
				return $this->getIsSticky();
				break;
			case 16:
				return $this->getFrontpage();
				break;
			default:
				return null;
				break;
		} 	}

	
	public function toArray($keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = ArticlePeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getId(),
			$keys[1] => $this->getCreatedAt(),
			$keys[2] => $this->getAuthorId(),
			$keys[3] => $this->getBaseTitle(),
			$keys[4] => $this->getPermalink(),
			$keys[5] => $this->getIngress(),
			$keys[6] => $this->getContent(),
			$keys[7] => $this->getUpdatedAt(),
			$keys[8] => $this->getUpdatedBy(),
			$keys[9] => $this->getArticleType(),
			$keys[10] => $this->getArticleOrder(),
			$keys[11] => $this->getExpiresAt(),
			$keys[12] => $this->getStatus(),
			$keys[13] => $this->getPublishedAt(),
			$keys[14] => $this->getBannerFileId(),
			$keys[15] => $this->getIsSticky(),
			$keys[16] => $this->getFrontpage(),
		);
		return $result;
	}

	
	public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = ArticlePeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				$this->setAuthorId($value);
				break;
			case 3:
				$this->setBaseTitle($value);
				break;
			case 4:
				$this->setPermalink($value);
				break;
			case 5:
				$this->setIngress($value);
				break;
			case 6:
				$this->setContent($value);
				break;
			case 7:
				$this->setUpdatedAt($value);
				break;
			case 8:
				$this->setUpdatedBy($value);
				break;
			case 9:
				$this->setArticleType($value);
				break;
			case 10:
				$this->setArticleOrder($value);
				break;
			case 11:
				$this->setExpiresAt($value);
				break;
			case 12:
				$this->setStatus($value);
				break;
			case 13:
				$this->setPublishedAt($value);
				break;
			case 14:
				$this->setBannerFileId($value);
				break;
			case 15:
				$this->setIsSticky($value);
				break;
			case 16:
				$this->setFrontpage($value);
				break;
		} 	}

	
	public function fromArray($arr, $keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = ArticlePeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setCreatedAt($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setAuthorId($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setBaseTitle($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setPermalink($arr[$keys[4]]);
		if (array_key_exists($keys[5], $arr)) $this->setIngress($arr[$keys[5]]);
		if (array_key_exists($keys[6], $arr)) $this->setContent($arr[$keys[6]]);
		if (array_key_exists($keys[7], $arr)) $this->setUpdatedAt($arr[$keys[7]]);
		if (array_key_exists($keys[8], $arr)) $this->setUpdatedBy($arr[$keys[8]]);
		if (array_key_exists($keys[9], $arr)) $this->setArticleType($arr[$keys[9]]);
		if (array_key_exists($keys[10], $arr)) $this->setArticleOrder($arr[$keys[10]]);
		if (array_key_exists($keys[11], $arr)) $this->setExpiresAt($arr[$keys[11]]);
		if (array_key_exists($keys[12], $arr)) $this->setStatus($arr[$keys[12]]);
		if (array_key_exists($keys[13], $arr)) $this->setPublishedAt($arr[$keys[13]]);
		if (array_key_exists($keys[14], $arr)) $this->setBannerFileId($arr[$keys[14]]);
		if (array_key_exists($keys[15], $arr)) $this->setIsSticky($arr[$keys[15]]);
		if (array_key_exists($keys[16], $arr)) $this->setFrontpage($arr[$keys[16]]);
	}

	
	public function buildCriteria()
	{
		$criteria = new Criteria(ArticlePeer::DATABASE_NAME);

		if ($this->isColumnModified(ArticlePeer::ID)) $criteria->add(ArticlePeer::ID, $this->id);
		if ($this->isColumnModified(ArticlePeer::CREATED_AT)) $criteria->add(ArticlePeer::CREATED_AT, $this->created_at);
		if ($this->isColumnModified(ArticlePeer::AUTHOR_ID)) $criteria->add(ArticlePeer::AUTHOR_ID, $this->author_id);
		if ($this->isColumnModified(ArticlePeer::BASE_TITLE)) $criteria->add(ArticlePeer::BASE_TITLE, $this->base_title);
		if ($this->isColumnModified(ArticlePeer::PERMALINK)) $criteria->add(ArticlePeer::PERMALINK, $this->permalink);
		if ($this->isColumnModified(ArticlePeer::INGRESS)) $criteria->add(ArticlePeer::INGRESS, $this->ingress);
		if ($this->isColumnModified(ArticlePeer::CONTENT)) $criteria->add(ArticlePeer::CONTENT, $this->content);
		if ($this->isColumnModified(ArticlePeer::UPDATED_AT)) $criteria->add(ArticlePeer::UPDATED_AT, $this->updated_at);
		if ($this->isColumnModified(ArticlePeer::UPDATED_BY)) $criteria->add(ArticlePeer::UPDATED_BY, $this->updated_by);
		if ($this->isColumnModified(ArticlePeer::ARTICLE_TYPE)) $criteria->add(ArticlePeer::ARTICLE_TYPE, $this->article_type);
		if ($this->isColumnModified(ArticlePeer::ARTICLE_ORDER)) $criteria->add(ArticlePeer::ARTICLE_ORDER, $this->article_order);
		if ($this->isColumnModified(ArticlePeer::EXPIRES_AT)) $criteria->add(ArticlePeer::EXPIRES_AT, $this->expires_at);
		if ($this->isColumnModified(ArticlePeer::STATUS)) $criteria->add(ArticlePeer::STATUS, $this->status);
		if ($this->isColumnModified(ArticlePeer::PUBLISHED_AT)) $criteria->add(ArticlePeer::PUBLISHED_AT, $this->published_at);
		if ($this->isColumnModified(ArticlePeer::BANNER_FILE_ID)) $criteria->add(ArticlePeer::BANNER_FILE_ID, $this->banner_file_id);
		if ($this->isColumnModified(ArticlePeer::IS_STICKY)) $criteria->add(ArticlePeer::IS_STICKY, $this->is_sticky);
		if ($this->isColumnModified(ArticlePeer::FRONTPAGE)) $criteria->add(ArticlePeer::FRONTPAGE, $this->frontpage);

		return $criteria;
	}

	
	public function buildPkeyCriteria()
	{
		$criteria = new Criteria(ArticlePeer::DATABASE_NAME);

		$criteria->add(ArticlePeer::ID, $this->id);

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

		$copyObj->setAuthorId($this->author_id);

		$copyObj->setBaseTitle($this->base_title);

		$copyObj->setPermalink($this->permalink);

		$copyObj->setIngress($this->ingress);

		$copyObj->setContent($this->content);

		$copyObj->setUpdatedAt($this->updated_at);

		$copyObj->setUpdatedBy($this->updated_by);

		$copyObj->setArticleType($this->article_type);

		$copyObj->setArticleOrder($this->article_order);

		$copyObj->setExpiresAt($this->expires_at);

		$copyObj->setStatus($this->status);

		$copyObj->setPublishedAt($this->published_at);

		$copyObj->setBannerFileId($this->banner_file_id);

		$copyObj->setIsSticky($this->is_sticky);

		$copyObj->setFrontpage($this->frontpage);


		if ($deepCopy) {
									$copyObj->setNew(false);

			foreach($this->getArticleI18ns() as $relObj) {
				$copyObj->addArticleI18n($relObj->copy($deepCopy));
			}

			foreach($this->getArticleArticleRelationsRelatedByFirstArticle() as $relObj) {
				$copyObj->addArticleArticleRelationRelatedByFirstArticle($relObj->copy($deepCopy));
			}

			foreach($this->getArticleArticleRelationsRelatedBySecondArticle() as $relObj) {
				$copyObj->addArticleArticleRelationRelatedBySecondArticle($relObj->copy($deepCopy));
			}

			foreach($this->getArticleArtworkRelations() as $relObj) {
				$copyObj->addArticleArtworkRelation($relObj->copy($deepCopy));
			}

			foreach($this->getArticleCategorys() as $relObj) {
				$copyObj->addArticleCategory($relObj->copy($deepCopy));
			}

			foreach($this->getArticleSubreaktors() as $relObj) {
				$copyObj->addArticleSubreaktor($relObj->copy($deepCopy));
			}

			foreach($this->getArticleAttachments() as $relObj) {
				$copyObj->addArticleAttachment($relObj->copy($deepCopy));
			}

			foreach($this->getFavourites() as $relObj) {
				$copyObj->addFavourite($relObj->copy($deepCopy));
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
			self::$peer = new ArticlePeer();
		}
		return self::$peer;
	}

	
	public function setsfGuardUser($v)
	{


		if ($v === null) {
			$this->setAuthorId(NULL);
		} else {
			$this->setAuthorId($v->getId());
		}


		$this->asfGuardUser = $v;
	}


	
	public function getsfGuardUser($con = null)
	{
		if ($this->asfGuardUser === null && ($this->author_id !== null)) {
						include_once 'plugins/sfGuardPlugin/lib/model/om/BasesfGuardUserPeer.php';

			$this->asfGuardUser = sfGuardUserPeer::retrieveByPK($this->author_id, $con);

			
		}
		return $this->asfGuardUser;
	}

	
	public function setArticleFile($v)
	{


		if ($v === null) {
			$this->setBannerFileId('0');
		} else {
			$this->setBannerFileId($v->getId());
		}


		$this->aArticleFile = $v;
	}


	
	public function getArticleFile($con = null)
	{
		if ($this->aArticleFile === null && ($this->banner_file_id !== null)) {
						include_once 'lib/model/om/BaseArticleFilePeer.php';

			$this->aArticleFile = ArticleFilePeer::retrieveByPK($this->banner_file_id, $con);

			
		}
		return $this->aArticleFile;
	}

	
	public function initArticleI18ns()
	{
		if ($this->collArticleI18ns === null) {
			$this->collArticleI18ns = array();
		}
	}

	
	public function getArticleI18ns($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseArticleI18nPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collArticleI18ns === null) {
			if ($this->isNew()) {
			   $this->collArticleI18ns = array();
			} else {

				$criteria->add(ArticleI18nPeer::ID, $this->getId());

				ArticleI18nPeer::addSelectColumns($criteria);
				$this->collArticleI18ns = ArticleI18nPeer::doSelect($criteria, $con);
			}
		} else {
						if (!$this->isNew()) {
												

				$criteria->add(ArticleI18nPeer::ID, $this->getId());

				ArticleI18nPeer::addSelectColumns($criteria);
				if (!isset($this->lastArticleI18nCriteria) || !$this->lastArticleI18nCriteria->equals($criteria)) {
					$this->collArticleI18ns = ArticleI18nPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastArticleI18nCriteria = $criteria;
		return $this->collArticleI18ns;
	}

	
	public function countArticleI18ns($criteria = null, $distinct = false, $con = null)
	{
				include_once 'lib/model/om/BaseArticleI18nPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(ArticleI18nPeer::ID, $this->getId());

		return ArticleI18nPeer::doCount($criteria, $distinct, $con);
	}

	
	public function addArticleI18n(ArticleI18n $l)
	{
		$this->collArticleI18ns[] = $l;
		$l->setArticle($this);
	}

	
	public function initArticleArticleRelationsRelatedByFirstArticle()
	{
		if ($this->collArticleArticleRelationsRelatedByFirstArticle === null) {
			$this->collArticleArticleRelationsRelatedByFirstArticle = array();
		}
	}

	
	public function getArticleArticleRelationsRelatedByFirstArticle($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseArticleArticleRelationPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collArticleArticleRelationsRelatedByFirstArticle === null) {
			if ($this->isNew()) {
			   $this->collArticleArticleRelationsRelatedByFirstArticle = array();
			} else {

				$criteria->add(ArticleArticleRelationPeer::FIRST_ARTICLE, $this->getId());

				ArticleArticleRelationPeer::addSelectColumns($criteria);
				$this->collArticleArticleRelationsRelatedByFirstArticle = ArticleArticleRelationPeer::doSelect($criteria, $con);
			}
		} else {
						if (!$this->isNew()) {
												

				$criteria->add(ArticleArticleRelationPeer::FIRST_ARTICLE, $this->getId());

				ArticleArticleRelationPeer::addSelectColumns($criteria);
				if (!isset($this->lastArticleArticleRelationRelatedByFirstArticleCriteria) || !$this->lastArticleArticleRelationRelatedByFirstArticleCriteria->equals($criteria)) {
					$this->collArticleArticleRelationsRelatedByFirstArticle = ArticleArticleRelationPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastArticleArticleRelationRelatedByFirstArticleCriteria = $criteria;
		return $this->collArticleArticleRelationsRelatedByFirstArticle;
	}

	
	public function countArticleArticleRelationsRelatedByFirstArticle($criteria = null, $distinct = false, $con = null)
	{
				include_once 'lib/model/om/BaseArticleArticleRelationPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(ArticleArticleRelationPeer::FIRST_ARTICLE, $this->getId());

		return ArticleArticleRelationPeer::doCount($criteria, $distinct, $con);
	}

	
	public function addArticleArticleRelationRelatedByFirstArticle(ArticleArticleRelation $l)
	{
		$this->collArticleArticleRelationsRelatedByFirstArticle[] = $l;
		$l->setArticleRelatedByFirstArticle($this);
	}


	
	public function getArticleArticleRelationsRelatedByFirstArticleJoinsfGuardUser($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseArticleArticleRelationPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collArticleArticleRelationsRelatedByFirstArticle === null) {
			if ($this->isNew()) {
				$this->collArticleArticleRelationsRelatedByFirstArticle = array();
			} else {

				$criteria->add(ArticleArticleRelationPeer::FIRST_ARTICLE, $this->getId());

				$this->collArticleArticleRelationsRelatedByFirstArticle = ArticleArticleRelationPeer::doSelectJoinsfGuardUser($criteria, $con);
			}
		} else {
									
			$criteria->add(ArticleArticleRelationPeer::FIRST_ARTICLE, $this->getId());

			if (!isset($this->lastArticleArticleRelationRelatedByFirstArticleCriteria) || !$this->lastArticleArticleRelationRelatedByFirstArticleCriteria->equals($criteria)) {
				$this->collArticleArticleRelationsRelatedByFirstArticle = ArticleArticleRelationPeer::doSelectJoinsfGuardUser($criteria, $con);
			}
		}
		$this->lastArticleArticleRelationRelatedByFirstArticleCriteria = $criteria;

		return $this->collArticleArticleRelationsRelatedByFirstArticle;
	}

	
	public function initArticleArticleRelationsRelatedBySecondArticle()
	{
		if ($this->collArticleArticleRelationsRelatedBySecondArticle === null) {
			$this->collArticleArticleRelationsRelatedBySecondArticle = array();
		}
	}

	
	public function getArticleArticleRelationsRelatedBySecondArticle($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseArticleArticleRelationPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collArticleArticleRelationsRelatedBySecondArticle === null) {
			if ($this->isNew()) {
			   $this->collArticleArticleRelationsRelatedBySecondArticle = array();
			} else {

				$criteria->add(ArticleArticleRelationPeer::SECOND_ARTICLE, $this->getId());

				ArticleArticleRelationPeer::addSelectColumns($criteria);
				$this->collArticleArticleRelationsRelatedBySecondArticle = ArticleArticleRelationPeer::doSelect($criteria, $con);
			}
		} else {
						if (!$this->isNew()) {
												

				$criteria->add(ArticleArticleRelationPeer::SECOND_ARTICLE, $this->getId());

				ArticleArticleRelationPeer::addSelectColumns($criteria);
				if (!isset($this->lastArticleArticleRelationRelatedBySecondArticleCriteria) || !$this->lastArticleArticleRelationRelatedBySecondArticleCriteria->equals($criteria)) {
					$this->collArticleArticleRelationsRelatedBySecondArticle = ArticleArticleRelationPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastArticleArticleRelationRelatedBySecondArticleCriteria = $criteria;
		return $this->collArticleArticleRelationsRelatedBySecondArticle;
	}

	
	public function countArticleArticleRelationsRelatedBySecondArticle($criteria = null, $distinct = false, $con = null)
	{
				include_once 'lib/model/om/BaseArticleArticleRelationPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(ArticleArticleRelationPeer::SECOND_ARTICLE, $this->getId());

		return ArticleArticleRelationPeer::doCount($criteria, $distinct, $con);
	}

	
	public function addArticleArticleRelationRelatedBySecondArticle(ArticleArticleRelation $l)
	{
		$this->collArticleArticleRelationsRelatedBySecondArticle[] = $l;
		$l->setArticleRelatedBySecondArticle($this);
	}


	
	public function getArticleArticleRelationsRelatedBySecondArticleJoinsfGuardUser($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseArticleArticleRelationPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collArticleArticleRelationsRelatedBySecondArticle === null) {
			if ($this->isNew()) {
				$this->collArticleArticleRelationsRelatedBySecondArticle = array();
			} else {

				$criteria->add(ArticleArticleRelationPeer::SECOND_ARTICLE, $this->getId());

				$this->collArticleArticleRelationsRelatedBySecondArticle = ArticleArticleRelationPeer::doSelectJoinsfGuardUser($criteria, $con);
			}
		} else {
									
			$criteria->add(ArticleArticleRelationPeer::SECOND_ARTICLE, $this->getId());

			if (!isset($this->lastArticleArticleRelationRelatedBySecondArticleCriteria) || !$this->lastArticleArticleRelationRelatedBySecondArticleCriteria->equals($criteria)) {
				$this->collArticleArticleRelationsRelatedBySecondArticle = ArticleArticleRelationPeer::doSelectJoinsfGuardUser($criteria, $con);
			}
		}
		$this->lastArticleArticleRelationRelatedBySecondArticleCriteria = $criteria;

		return $this->collArticleArticleRelationsRelatedBySecondArticle;
	}

	
	public function initArticleArtworkRelations()
	{
		if ($this->collArticleArtworkRelations === null) {
			$this->collArticleArtworkRelations = array();
		}
	}

	
	public function getArticleArtworkRelations($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseArticleArtworkRelationPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collArticleArtworkRelations === null) {
			if ($this->isNew()) {
			   $this->collArticleArtworkRelations = array();
			} else {

				$criteria->add(ArticleArtworkRelationPeer::ARTICLE_ID, $this->getId());

				ArticleArtworkRelationPeer::addSelectColumns($criteria);
				$this->collArticleArtworkRelations = ArticleArtworkRelationPeer::doSelect($criteria, $con);
			}
		} else {
						if (!$this->isNew()) {
												

				$criteria->add(ArticleArtworkRelationPeer::ARTICLE_ID, $this->getId());

				ArticleArtworkRelationPeer::addSelectColumns($criteria);
				if (!isset($this->lastArticleArtworkRelationCriteria) || !$this->lastArticleArtworkRelationCriteria->equals($criteria)) {
					$this->collArticleArtworkRelations = ArticleArtworkRelationPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastArticleArtworkRelationCriteria = $criteria;
		return $this->collArticleArtworkRelations;
	}

	
	public function countArticleArtworkRelations($criteria = null, $distinct = false, $con = null)
	{
				include_once 'lib/model/om/BaseArticleArtworkRelationPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(ArticleArtworkRelationPeer::ARTICLE_ID, $this->getId());

		return ArticleArtworkRelationPeer::doCount($criteria, $distinct, $con);
	}

	
	public function addArticleArtworkRelation(ArticleArtworkRelation $l)
	{
		$this->collArticleArtworkRelations[] = $l;
		$l->setArticle($this);
	}


	
	public function getArticleArtworkRelationsJoinReaktorArtwork($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseArticleArtworkRelationPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collArticleArtworkRelations === null) {
			if ($this->isNew()) {
				$this->collArticleArtworkRelations = array();
			} else {

				$criteria->add(ArticleArtworkRelationPeer::ARTICLE_ID, $this->getId());

				$this->collArticleArtworkRelations = ArticleArtworkRelationPeer::doSelectJoinReaktorArtwork($criteria, $con);
			}
		} else {
									
			$criteria->add(ArticleArtworkRelationPeer::ARTICLE_ID, $this->getId());

			if (!isset($this->lastArticleArtworkRelationCriteria) || !$this->lastArticleArtworkRelationCriteria->equals($criteria)) {
				$this->collArticleArtworkRelations = ArticleArtworkRelationPeer::doSelectJoinReaktorArtwork($criteria, $con);
			}
		}
		$this->lastArticleArtworkRelationCriteria = $criteria;

		return $this->collArticleArtworkRelations;
	}


	
	public function getArticleArtworkRelationsJoinsfGuardUser($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseArticleArtworkRelationPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collArticleArtworkRelations === null) {
			if ($this->isNew()) {
				$this->collArticleArtworkRelations = array();
			} else {

				$criteria->add(ArticleArtworkRelationPeer::ARTICLE_ID, $this->getId());

				$this->collArticleArtworkRelations = ArticleArtworkRelationPeer::doSelectJoinsfGuardUser($criteria, $con);
			}
		} else {
									
			$criteria->add(ArticleArtworkRelationPeer::ARTICLE_ID, $this->getId());

			if (!isset($this->lastArticleArtworkRelationCriteria) || !$this->lastArticleArtworkRelationCriteria->equals($criteria)) {
				$this->collArticleArtworkRelations = ArticleArtworkRelationPeer::doSelectJoinsfGuardUser($criteria, $con);
			}
		}
		$this->lastArticleArtworkRelationCriteria = $criteria;

		return $this->collArticleArtworkRelations;
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

				$criteria->add(ArticleCategoryPeer::ARTICLE_ID, $this->getId());

				ArticleCategoryPeer::addSelectColumns($criteria);
				$this->collArticleCategorys = ArticleCategoryPeer::doSelect($criteria, $con);
			}
		} else {
						if (!$this->isNew()) {
												

				$criteria->add(ArticleCategoryPeer::ARTICLE_ID, $this->getId());

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

		$criteria->add(ArticleCategoryPeer::ARTICLE_ID, $this->getId());

		return ArticleCategoryPeer::doCount($criteria, $distinct, $con);
	}

	
	public function addArticleCategory(ArticleCategory $l)
	{
		$this->collArticleCategorys[] = $l;
		$l->setArticle($this);
	}


	
	public function getArticleCategorysJoinCategory($criteria = null, $con = null)
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

				$criteria->add(ArticleCategoryPeer::ARTICLE_ID, $this->getId());

				$this->collArticleCategorys = ArticleCategoryPeer::doSelectJoinCategory($criteria, $con);
			}
		} else {
									
			$criteria->add(ArticleCategoryPeer::ARTICLE_ID, $this->getId());

			if (!isset($this->lastArticleCategoryCriteria) || !$this->lastArticleCategoryCriteria->equals($criteria)) {
				$this->collArticleCategorys = ArticleCategoryPeer::doSelectJoinCategory($criteria, $con);
			}
		}
		$this->lastArticleCategoryCriteria = $criteria;

		return $this->collArticleCategorys;
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

				$criteria->add(ArticleSubreaktorPeer::ARTICLE_ID, $this->getId());

				ArticleSubreaktorPeer::addSelectColumns($criteria);
				$this->collArticleSubreaktors = ArticleSubreaktorPeer::doSelect($criteria, $con);
			}
		} else {
						if (!$this->isNew()) {
												

				$criteria->add(ArticleSubreaktorPeer::ARTICLE_ID, $this->getId());

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

		$criteria->add(ArticleSubreaktorPeer::ARTICLE_ID, $this->getId());

		return ArticleSubreaktorPeer::doCount($criteria, $distinct, $con);
	}

	
	public function addArticleSubreaktor(ArticleSubreaktor $l)
	{
		$this->collArticleSubreaktors[] = $l;
		$l->setArticle($this);
	}


	
	public function getArticleSubreaktorsJoinSubreaktor($criteria = null, $con = null)
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

				$criteria->add(ArticleSubreaktorPeer::ARTICLE_ID, $this->getId());

				$this->collArticleSubreaktors = ArticleSubreaktorPeer::doSelectJoinSubreaktor($criteria, $con);
			}
		} else {
									
			$criteria->add(ArticleSubreaktorPeer::ARTICLE_ID, $this->getId());

			if (!isset($this->lastArticleSubreaktorCriteria) || !$this->lastArticleSubreaktorCriteria->equals($criteria)) {
				$this->collArticleSubreaktors = ArticleSubreaktorPeer::doSelectJoinSubreaktor($criteria, $con);
			}
		}
		$this->lastArticleSubreaktorCriteria = $criteria;

		return $this->collArticleSubreaktors;
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

				$criteria->add(ArticleAttachmentPeer::ARTICLE_ID, $this->getId());

				ArticleAttachmentPeer::addSelectColumns($criteria);
				$this->collArticleAttachments = ArticleAttachmentPeer::doSelect($criteria, $con);
			}
		} else {
						if (!$this->isNew()) {
												

				$criteria->add(ArticleAttachmentPeer::ARTICLE_ID, $this->getId());

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

		$criteria->add(ArticleAttachmentPeer::ARTICLE_ID, $this->getId());

		return ArticleAttachmentPeer::doCount($criteria, $distinct, $con);
	}

	
	public function addArticleAttachment(ArticleAttachment $l)
	{
		$this->collArticleAttachments[] = $l;
		$l->setArticle($this);
	}


	
	public function getArticleAttachmentsJoinArticleFile($criteria = null, $con = null)
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

				$criteria->add(ArticleAttachmentPeer::ARTICLE_ID, $this->getId());

				$this->collArticleAttachments = ArticleAttachmentPeer::doSelectJoinArticleFile($criteria, $con);
			}
		} else {
									
			$criteria->add(ArticleAttachmentPeer::ARTICLE_ID, $this->getId());

			if (!isset($this->lastArticleAttachmentCriteria) || !$this->lastArticleAttachmentCriteria->equals($criteria)) {
				$this->collArticleAttachments = ArticleAttachmentPeer::doSelectJoinArticleFile($criteria, $con);
			}
		}
		$this->lastArticleAttachmentCriteria = $criteria;

		return $this->collArticleAttachments;
	}

	
	public function initFavourites()
	{
		if ($this->collFavourites === null) {
			$this->collFavourites = array();
		}
	}

	
	public function getFavourites($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseFavouritePeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collFavourites === null) {
			if ($this->isNew()) {
			   $this->collFavourites = array();
			} else {

				$criteria->add(FavouritePeer::ARTICLE_ID, $this->getId());

				FavouritePeer::addSelectColumns($criteria);
				$this->collFavourites = FavouritePeer::doSelect($criteria, $con);
			}
		} else {
						if (!$this->isNew()) {
												

				$criteria->add(FavouritePeer::ARTICLE_ID, $this->getId());

				FavouritePeer::addSelectColumns($criteria);
				if (!isset($this->lastFavouriteCriteria) || !$this->lastFavouriteCriteria->equals($criteria)) {
					$this->collFavourites = FavouritePeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastFavouriteCriteria = $criteria;
		return $this->collFavourites;
	}

	
	public function countFavourites($criteria = null, $distinct = false, $con = null)
	{
				include_once 'lib/model/om/BaseFavouritePeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(FavouritePeer::ARTICLE_ID, $this->getId());

		return FavouritePeer::doCount($criteria, $distinct, $con);
	}

	
	public function addFavourite(Favourite $l)
	{
		$this->collFavourites[] = $l;
		$l->setArticle($this);
	}


	
	public function getFavouritesJoinsfGuardUserRelatedByUserId($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseFavouritePeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collFavourites === null) {
			if ($this->isNew()) {
				$this->collFavourites = array();
			} else {

				$criteria->add(FavouritePeer::ARTICLE_ID, $this->getId());

				$this->collFavourites = FavouritePeer::doSelectJoinsfGuardUserRelatedByUserId($criteria, $con);
			}
		} else {
									
			$criteria->add(FavouritePeer::ARTICLE_ID, $this->getId());

			if (!isset($this->lastFavouriteCriteria) || !$this->lastFavouriteCriteria->equals($criteria)) {
				$this->collFavourites = FavouritePeer::doSelectJoinsfGuardUserRelatedByUserId($criteria, $con);
			}
		}
		$this->lastFavouriteCriteria = $criteria;

		return $this->collFavourites;
	}


	
	public function getFavouritesJoinReaktorArtwork($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseFavouritePeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collFavourites === null) {
			if ($this->isNew()) {
				$this->collFavourites = array();
			} else {

				$criteria->add(FavouritePeer::ARTICLE_ID, $this->getId());

				$this->collFavourites = FavouritePeer::doSelectJoinReaktorArtwork($criteria, $con);
			}
		} else {
									
			$criteria->add(FavouritePeer::ARTICLE_ID, $this->getId());

			if (!isset($this->lastFavouriteCriteria) || !$this->lastFavouriteCriteria->equals($criteria)) {
				$this->collFavourites = FavouritePeer::doSelectJoinReaktorArtwork($criteria, $con);
			}
		}
		$this->lastFavouriteCriteria = $criteria;

		return $this->collFavourites;
	}


	
	public function getFavouritesJoinsfGuardUserRelatedByFriendId($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseFavouritePeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collFavourites === null) {
			if ($this->isNew()) {
				$this->collFavourites = array();
			} else {

				$criteria->add(FavouritePeer::ARTICLE_ID, $this->getId());

				$this->collFavourites = FavouritePeer::doSelectJoinsfGuardUserRelatedByFriendId($criteria, $con);
			}
		} else {
									
			$criteria->add(FavouritePeer::ARTICLE_ID, $this->getId());

			if (!isset($this->lastFavouriteCriteria) || !$this->lastFavouriteCriteria->equals($criteria)) {
				$this->collFavourites = FavouritePeer::doSelectJoinsfGuardUserRelatedByFriendId($criteria, $con);
			}
		}
		$this->lastFavouriteCriteria = $criteria;

		return $this->collFavourites;
	}

  public function getCulture()
  {
    return $this->culture;
  }

  public function setCulture($culture)
  {
    $this->culture = $culture;
  }

  public function getTitle()
  {
    $obj = $this->getCurrentArticleI18n();

    return ($obj ? $obj->getTitle() : null);
  }

  public function setTitle($value)
  {
    $this->getCurrentArticleI18n()->setTitle($value);
  }

  protected $current_i18n = array();

  public function getCurrentArticleI18n()
  {
    if (!isset($this->current_i18n[$this->culture]))
    {
      $obj = ArticleI18nPeer::retrieveByPK($this->getId(), $this->culture);
      if ($obj)
      {
        $this->setArticleI18nForCulture($obj, $this->culture);
      }
      else
      {
        $this->setArticleI18nForCulture(new ArticleI18n(), $this->culture);
        $this->current_i18n[$this->culture]->setCulture($this->culture);
      }
    }

    return $this->current_i18n[$this->culture];
  }

  public function setArticleI18nForCulture($object, $culture)
  {
    $this->current_i18n[$culture] = $object;
    $this->addArticleI18n($object);
  }


  public function __call($method, $arguments)
  {
    if (!$callable = sfMixer::getCallable('BaseArticle:'.$method))
    {
      throw new sfException(sprintf('Call to undefined method BaseArticle::%s', $method));
    }

    array_unshift($arguments, $this);

    return call_user_func_array($callable, $arguments);
  }


} 