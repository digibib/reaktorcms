<?php


abstract class BaseReaktorArtwork extends BaseObject  implements Persistent {


	
	protected static $peer;


	
	protected $id;


	
	protected $user_id;


	
	protected $artwork_identifier;


	
	protected $created_at;


	
	protected $submitted_at;


	
	protected $actioned_at;


	
	protected $modified_flag;


	
	protected $title;


	
	protected $actioned_by;


	
	protected $status;


	
	protected $description;


	
	protected $modified_note;


	
	protected $artwork_order = 0;


	
	protected $average_rating = 0;


	
	protected $team_id;


	
	protected $under_discussion = 0;


	
	protected $multi_user = 0;


	
	protected $first_file_id;


	
	protected $deleted = 0;

	
	protected $asfGuardUser;

	
	protected $aArtworkStatus;

	
	protected $asfGuardGroup;

	
	protected $aReaktorFile;

	
	protected $collRecommendedArtworks;

	
	protected $lastRecommendedArtworkCriteria = null;

	
	protected $collRelatedArtworksRelatedByFirstArtwork;

	
	protected $lastRelatedArtworkRelatedByFirstArtworkCriteria = null;

	
	protected $collRelatedArtworksRelatedBySecondArtwork;

	
	protected $lastRelatedArtworkRelatedBySecondArtworkCriteria = null;

	
	protected $collArticleArtworkRelations;

	
	protected $lastArticleArtworkRelationCriteria = null;

	
	protected $collReaktorArtworkFiles;

	
	protected $lastReaktorArtworkFileCriteria = null;

	
	protected $collFavourites;

	
	protected $lastFavouriteCriteria = null;

	
	protected $collLokalreaktorArtworks;

	
	protected $lastLokalreaktorArtworkCriteria = null;

	
	protected $collCategoryArtworks;

	
	protected $lastCategoryArtworkCriteria = null;

	
	protected $collReaktorArtworkHistorysRelatedByArtworkId;

	
	protected $lastReaktorArtworkHistoryRelatedByArtworkIdCriteria = null;

	
	protected $collReaktorArtworkHistorysRelatedByFileId;

	
	protected $lastReaktorArtworkHistoryRelatedByFileIdCriteria = null;

	
	protected $collSubreaktorArtworks;

	
	protected $lastSubreaktorArtworkCriteria = null;

	
	protected $alreadyInSave = false;

	
	protected $alreadyInValidation = false;

	
	public function getId()
	{

		return $this->id;
	}

	
	public function getUserId()
	{

		return $this->user_id;
	}

	
	public function getArtworkIdentifier()
	{

		return $this->artwork_identifier;
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

	
	public function getSubmittedAt($format = 'Y-m-d H:i:s')
	{

		if ($this->submitted_at === null || $this->submitted_at === '') {
			return null;
		} elseif (!is_int($this->submitted_at)) {
						$ts = strtotime($this->submitted_at);
			if ($ts === -1 || $ts === false) { 				throw new PropelException("Unable to parse value of [submitted_at] as date/time value: " . var_export($this->submitted_at, true));
			}
		} else {
			$ts = $this->submitted_at;
		}
		if ($format === null) {
			return $ts;
		} elseif (strpos($format, '%') !== false) {
			return strftime($format, $ts);
		} else {
			return date($format, $ts);
		}
	}

	
	public function getActionedAt($format = 'Y-m-d H:i:s')
	{

		if ($this->actioned_at === null || $this->actioned_at === '') {
			return null;
		} elseif (!is_int($this->actioned_at)) {
						$ts = strtotime($this->actioned_at);
			if ($ts === -1 || $ts === false) { 				throw new PropelException("Unable to parse value of [actioned_at] as date/time value: " . var_export($this->actioned_at, true));
			}
		} else {
			$ts = $this->actioned_at;
		}
		if ($format === null) {
			return $ts;
		} elseif (strpos($format, '%') !== false) {
			return strftime($format, $ts);
		} else {
			return date($format, $ts);
		}
	}

	
	public function getModifiedFlag($format = 'Y-m-d H:i:s')
	{

		if ($this->modified_flag === null || $this->modified_flag === '') {
			return null;
		} elseif (!is_int($this->modified_flag)) {
						$ts = strtotime($this->modified_flag);
			if ($ts === -1 || $ts === false) { 				throw new PropelException("Unable to parse value of [modified_flag] as date/time value: " . var_export($this->modified_flag, true));
			}
		} else {
			$ts = $this->modified_flag;
		}
		if ($format === null) {
			return $ts;
		} elseif (strpos($format, '%') !== false) {
			return strftime($format, $ts);
		} else {
			return date($format, $ts);
		}
	}

	
	public function getTitle()
	{

		return $this->title;
	}

	
	public function getActionedBy()
	{

		return $this->actioned_by;
	}

	
	public function getStatus()
	{

		return $this->status;
	}

	
	public function getDescription()
	{

		return $this->description;
	}

	
	public function getModifiedNote()
	{

		return $this->modified_note;
	}

	
	public function getArtworkOrder()
	{

		return $this->artwork_order;
	}

	
	public function getAverageRating()
	{

		return $this->average_rating;
	}

	
	public function getTeamId()
	{

		return $this->team_id;
	}

	
	public function getUnderDiscussion()
	{

		return $this->under_discussion;
	}

	
	public function getMultiUser()
	{

		return $this->multi_user;
	}

	
	public function getFirstFileId()
	{

		return $this->first_file_id;
	}

	
	public function getDeleted()
	{

		return $this->deleted;
	}

	
	public function setId($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->id !== $v) {
			$this->id = $v;
			$this->modifiedColumns[] = ReaktorArtworkPeer::ID;
		}

	} 
	
	public function setUserId($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->user_id !== $v) {
			$this->user_id = $v;
			$this->modifiedColumns[] = ReaktorArtworkPeer::USER_ID;
		}

		if ($this->asfGuardUser !== null && $this->asfGuardUser->getId() !== $v) {
			$this->asfGuardUser = null;
		}

	} 
	
	public function setArtworkIdentifier($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->artwork_identifier !== $v) {
			$this->artwork_identifier = $v;
			$this->modifiedColumns[] = ReaktorArtworkPeer::ARTWORK_IDENTIFIER;
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
			$this->modifiedColumns[] = ReaktorArtworkPeer::CREATED_AT;
		}

	} 
	
	public function setSubmittedAt($v)
	{

		if ($v !== null && !is_int($v)) {
			$ts = strtotime($v);
			if ($ts === -1 || $ts === false) { 				throw new PropelException("Unable to parse date/time value for [submitted_at] from input: " . var_export($v, true));
			}
		} else {
			$ts = $v;
		}
		if ($this->submitted_at !== $ts) {
			$this->submitted_at = $ts;
			$this->modifiedColumns[] = ReaktorArtworkPeer::SUBMITTED_AT;
		}

	} 
	
	public function setActionedAt($v)
	{

		if ($v !== null && !is_int($v)) {
			$ts = strtotime($v);
			if ($ts === -1 || $ts === false) { 				throw new PropelException("Unable to parse date/time value for [actioned_at] from input: " . var_export($v, true));
			}
		} else {
			$ts = $v;
		}
		if ($this->actioned_at !== $ts) {
			$this->actioned_at = $ts;
			$this->modifiedColumns[] = ReaktorArtworkPeer::ACTIONED_AT;
		}

	} 
	
	public function setModifiedFlag($v)
	{

		if ($v !== null && !is_int($v)) {
			$ts = strtotime($v);
			if ($ts === -1 || $ts === false) { 				throw new PropelException("Unable to parse date/time value for [modified_flag] from input: " . var_export($v, true));
			}
		} else {
			$ts = $v;
		}
		if ($this->modified_flag !== $ts) {
			$this->modified_flag = $ts;
			$this->modifiedColumns[] = ReaktorArtworkPeer::MODIFIED_FLAG;
		}

	} 
	
	public function setTitle($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->title !== $v) {
			$this->title = $v;
			$this->modifiedColumns[] = ReaktorArtworkPeer::TITLE;
		}

	} 
	
	public function setActionedBy($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->actioned_by !== $v) {
			$this->actioned_by = $v;
			$this->modifiedColumns[] = ReaktorArtworkPeer::ACTIONED_BY;
		}

	} 
	
	public function setStatus($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->status !== $v) {
			$this->status = $v;
			$this->modifiedColumns[] = ReaktorArtworkPeer::STATUS;
		}

		if ($this->aArtworkStatus !== null && $this->aArtworkStatus->getId() !== $v) {
			$this->aArtworkStatus = null;
		}

	} 
	
	public function setDescription($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->description !== $v) {
			$this->description = $v;
			$this->modifiedColumns[] = ReaktorArtworkPeer::DESCRIPTION;
		}

	} 
	
	public function setModifiedNote($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->modified_note !== $v) {
			$this->modified_note = $v;
			$this->modifiedColumns[] = ReaktorArtworkPeer::MODIFIED_NOTE;
		}

	} 
	
	public function setArtworkOrder($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->artwork_order !== $v || $v === 0) {
			$this->artwork_order = $v;
			$this->modifiedColumns[] = ReaktorArtworkPeer::ARTWORK_ORDER;
		}

	} 
	
	public function setAverageRating($v)
	{

		if ($this->average_rating !== $v || $v === 0) {
			$this->average_rating = $v;
			$this->modifiedColumns[] = ReaktorArtworkPeer::AVERAGE_RATING;
		}

	} 
	
	public function setTeamId($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->team_id !== $v) {
			$this->team_id = $v;
			$this->modifiedColumns[] = ReaktorArtworkPeer::TEAM_ID;
		}

		if ($this->asfGuardGroup !== null && $this->asfGuardGroup->getId() !== $v) {
			$this->asfGuardGroup = null;
		}

	} 
	
	public function setUnderDiscussion($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->under_discussion !== $v || $v === 0) {
			$this->under_discussion = $v;
			$this->modifiedColumns[] = ReaktorArtworkPeer::UNDER_DISCUSSION;
		}

	} 
	
	public function setMultiUser($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->multi_user !== $v || $v === 0) {
			$this->multi_user = $v;
			$this->modifiedColumns[] = ReaktorArtworkPeer::MULTI_USER;
		}

	} 
	
	public function setFirstFileId($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->first_file_id !== $v) {
			$this->first_file_id = $v;
			$this->modifiedColumns[] = ReaktorArtworkPeer::FIRST_FILE_ID;
		}

		if ($this->aReaktorFile !== null && $this->aReaktorFile->getId() !== $v) {
			$this->aReaktorFile = null;
		}

	} 
	
	public function setDeleted($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->deleted !== $v || $v === 0) {
			$this->deleted = $v;
			$this->modifiedColumns[] = ReaktorArtworkPeer::DELETED;
		}

	} 
	
	public function hydrate(ResultSet $rs, $startcol = 1)
	{
		try {

			$this->id = $rs->getInt($startcol + 0);

			$this->user_id = $rs->getInt($startcol + 1);

			$this->artwork_identifier = $rs->getString($startcol + 2);

			$this->created_at = $rs->getTimestamp($startcol + 3, null);

			$this->submitted_at = $rs->getTimestamp($startcol + 4, null);

			$this->actioned_at = $rs->getTimestamp($startcol + 5, null);

			$this->modified_flag = $rs->getTimestamp($startcol + 6, null);

			$this->title = $rs->getString($startcol + 7);

			$this->actioned_by = $rs->getInt($startcol + 8);

			$this->status = $rs->getInt($startcol + 9);

			$this->description = $rs->getString($startcol + 10);

			$this->modified_note = $rs->getString($startcol + 11);

			$this->artwork_order = $rs->getInt($startcol + 12);

			$this->average_rating = $rs->getFloat($startcol + 13);

			$this->team_id = $rs->getInt($startcol + 14);

			$this->under_discussion = $rs->getInt($startcol + 15);

			$this->multi_user = $rs->getInt($startcol + 16);

			$this->first_file_id = $rs->getInt($startcol + 17);

			$this->deleted = $rs->getInt($startcol + 18);

			$this->resetModified();

			$this->setNew(false);

						return $startcol + 19; 
		} catch (Exception $e) {
			throw new PropelException("Error populating ReaktorArtwork object", $e);
		}
	}

	
	public function delete($con = null)
	{

    foreach (sfMixer::getCallables('BaseReaktorArtwork:delete:pre') as $callable)
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
			$con = Propel::getConnection(ReaktorArtworkPeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			ReaktorArtworkPeer::doDelete($this, $con);
			$this->setDeleted(true);
			$con->commit();
		} catch (PropelException $e) {
			$con->rollback();
			throw $e;
		}
	

    foreach (sfMixer::getCallables('BaseReaktorArtwork:delete:post') as $callable)
    {
      call_user_func($callable, $this, $con);
    }

  }
	
	public function save($con = null)
	{

    foreach (sfMixer::getCallables('BaseReaktorArtwork:save:pre') as $callable)
    {
      $affectedRows = call_user_func($callable, $this, $con);
      if (is_int($affectedRows))
      {
        return $affectedRows;
      }
    }


    if ($this->isNew() && !$this->isColumnModified(ReaktorArtworkPeer::CREATED_AT))
    {
      $this->setCreatedAt(time());
    }

		if ($this->isDeleted()) {
			throw new PropelException("You cannot save an object that has been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(ReaktorArtworkPeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			$affectedRows = $this->doSave($con);
			$con->commit();
    foreach (sfMixer::getCallables('BaseReaktorArtwork:save:post') as $callable)
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

			if ($this->aArtworkStatus !== null) {
				if ($this->aArtworkStatus->isModified() || $this->aArtworkStatus->getCurrentArtworkStatusI18n()->isModified()) {
					$affectedRows += $this->aArtworkStatus->save($con);
				}
				$this->setArtworkStatus($this->aArtworkStatus);
			}

			if ($this->asfGuardGroup !== null) {
				if ($this->asfGuardGroup->isModified()) {
					$affectedRows += $this->asfGuardGroup->save($con);
				}
				$this->setsfGuardGroup($this->asfGuardGroup);
			}

			if ($this->aReaktorFile !== null) {
				if ($this->aReaktorFile->isModified()) {
					$affectedRows += $this->aReaktorFile->save($con);
				}
				$this->setReaktorFile($this->aReaktorFile);
			}


						if ($this->isModified()) {
				if ($this->isNew()) {
					$pk = ReaktorArtworkPeer::doInsert($this, $con);
					$affectedRows += 1; 										 										 
					$this->setId($pk);  
					$this->setNew(false);
				} else {
					$affectedRows += ReaktorArtworkPeer::doUpdate($this, $con);
				}
				$this->resetModified(); 			}

			if ($this->collRecommendedArtworks !== null) {
				foreach($this->collRecommendedArtworks as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collRelatedArtworksRelatedByFirstArtwork !== null) {
				foreach($this->collRelatedArtworksRelatedByFirstArtwork as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collRelatedArtworksRelatedBySecondArtwork !== null) {
				foreach($this->collRelatedArtworksRelatedBySecondArtwork as $referrerFK) {
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

			if ($this->collReaktorArtworkFiles !== null) {
				foreach($this->collReaktorArtworkFiles as $referrerFK) {
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

			if ($this->collLokalreaktorArtworks !== null) {
				foreach($this->collLokalreaktorArtworks as $referrerFK) {
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

			if ($this->collReaktorArtworkHistorysRelatedByArtworkId !== null) {
				foreach($this->collReaktorArtworkHistorysRelatedByArtworkId as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collReaktorArtworkHistorysRelatedByFileId !== null) {
				foreach($this->collReaktorArtworkHistorysRelatedByFileId as $referrerFK) {
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


												
			if ($this->asfGuardUser !== null) {
				if (!$this->asfGuardUser->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->asfGuardUser->getValidationFailures());
				}
			}

			if ($this->aArtworkStatus !== null) {
				if (!$this->aArtworkStatus->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aArtworkStatus->getValidationFailures());
				}
			}

			if ($this->asfGuardGroup !== null) {
				if (!$this->asfGuardGroup->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->asfGuardGroup->getValidationFailures());
				}
			}

			if ($this->aReaktorFile !== null) {
				if (!$this->aReaktorFile->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aReaktorFile->getValidationFailures());
				}
			}


			if (($retval = ReaktorArtworkPeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}


				if ($this->collRecommendedArtworks !== null) {
					foreach($this->collRecommendedArtworks as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collRelatedArtworksRelatedByFirstArtwork !== null) {
					foreach($this->collRelatedArtworksRelatedByFirstArtwork as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collRelatedArtworksRelatedBySecondArtwork !== null) {
					foreach($this->collRelatedArtworksRelatedBySecondArtwork as $referrerFK) {
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

				if ($this->collReaktorArtworkFiles !== null) {
					foreach($this->collReaktorArtworkFiles as $referrerFK) {
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

				if ($this->collLokalreaktorArtworks !== null) {
					foreach($this->collLokalreaktorArtworks as $referrerFK) {
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

				if ($this->collReaktorArtworkHistorysRelatedByArtworkId !== null) {
					foreach($this->collReaktorArtworkHistorysRelatedByArtworkId as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collReaktorArtworkHistorysRelatedByFileId !== null) {
					foreach($this->collReaktorArtworkHistorysRelatedByFileId as $referrerFK) {
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
		$pos = ReaktorArtworkPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->getByPosition($pos);
	}

	
	public function getByPosition($pos)
	{
		switch($pos) {
			case 0:
				return $this->getId();
				break;
			case 1:
				return $this->getUserId();
				break;
			case 2:
				return $this->getArtworkIdentifier();
				break;
			case 3:
				return $this->getCreatedAt();
				break;
			case 4:
				return $this->getSubmittedAt();
				break;
			case 5:
				return $this->getActionedAt();
				break;
			case 6:
				return $this->getModifiedFlag();
				break;
			case 7:
				return $this->getTitle();
				break;
			case 8:
				return $this->getActionedBy();
				break;
			case 9:
				return $this->getStatus();
				break;
			case 10:
				return $this->getDescription();
				break;
			case 11:
				return $this->getModifiedNote();
				break;
			case 12:
				return $this->getArtworkOrder();
				break;
			case 13:
				return $this->getAverageRating();
				break;
			case 14:
				return $this->getTeamId();
				break;
			case 15:
				return $this->getUnderDiscussion();
				break;
			case 16:
				return $this->getMultiUser();
				break;
			case 17:
				return $this->getFirstFileId();
				break;
			case 18:
				return $this->getDeleted();
				break;
			default:
				return null;
				break;
		} 	}

	
	public function toArray($keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = ReaktorArtworkPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getId(),
			$keys[1] => $this->getUserId(),
			$keys[2] => $this->getArtworkIdentifier(),
			$keys[3] => $this->getCreatedAt(),
			$keys[4] => $this->getSubmittedAt(),
			$keys[5] => $this->getActionedAt(),
			$keys[6] => $this->getModifiedFlag(),
			$keys[7] => $this->getTitle(),
			$keys[8] => $this->getActionedBy(),
			$keys[9] => $this->getStatus(),
			$keys[10] => $this->getDescription(),
			$keys[11] => $this->getModifiedNote(),
			$keys[12] => $this->getArtworkOrder(),
			$keys[13] => $this->getAverageRating(),
			$keys[14] => $this->getTeamId(),
			$keys[15] => $this->getUnderDiscussion(),
			$keys[16] => $this->getMultiUser(),
			$keys[17] => $this->getFirstFileId(),
			$keys[18] => $this->getDeleted(),
		);
		return $result;
	}

	
	public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = ReaktorArtworkPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->setByPosition($pos, $value);
	}

	
	public function setByPosition($pos, $value)
	{
		switch($pos) {
			case 0:
				$this->setId($value);
				break;
			case 1:
				$this->setUserId($value);
				break;
			case 2:
				$this->setArtworkIdentifier($value);
				break;
			case 3:
				$this->setCreatedAt($value);
				break;
			case 4:
				$this->setSubmittedAt($value);
				break;
			case 5:
				$this->setActionedAt($value);
				break;
			case 6:
				$this->setModifiedFlag($value);
				break;
			case 7:
				$this->setTitle($value);
				break;
			case 8:
				$this->setActionedBy($value);
				break;
			case 9:
				$this->setStatus($value);
				break;
			case 10:
				$this->setDescription($value);
				break;
			case 11:
				$this->setModifiedNote($value);
				break;
			case 12:
				$this->setArtworkOrder($value);
				break;
			case 13:
				$this->setAverageRating($value);
				break;
			case 14:
				$this->setTeamId($value);
				break;
			case 15:
				$this->setUnderDiscussion($value);
				break;
			case 16:
				$this->setMultiUser($value);
				break;
			case 17:
				$this->setFirstFileId($value);
				break;
			case 18:
				$this->setDeleted($value);
				break;
		} 	}

	
	public function fromArray($arr, $keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = ReaktorArtworkPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setUserId($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setArtworkIdentifier($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setCreatedAt($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setSubmittedAt($arr[$keys[4]]);
		if (array_key_exists($keys[5], $arr)) $this->setActionedAt($arr[$keys[5]]);
		if (array_key_exists($keys[6], $arr)) $this->setModifiedFlag($arr[$keys[6]]);
		if (array_key_exists($keys[7], $arr)) $this->setTitle($arr[$keys[7]]);
		if (array_key_exists($keys[8], $arr)) $this->setActionedBy($arr[$keys[8]]);
		if (array_key_exists($keys[9], $arr)) $this->setStatus($arr[$keys[9]]);
		if (array_key_exists($keys[10], $arr)) $this->setDescription($arr[$keys[10]]);
		if (array_key_exists($keys[11], $arr)) $this->setModifiedNote($arr[$keys[11]]);
		if (array_key_exists($keys[12], $arr)) $this->setArtworkOrder($arr[$keys[12]]);
		if (array_key_exists($keys[13], $arr)) $this->setAverageRating($arr[$keys[13]]);
		if (array_key_exists($keys[14], $arr)) $this->setTeamId($arr[$keys[14]]);
		if (array_key_exists($keys[15], $arr)) $this->setUnderDiscussion($arr[$keys[15]]);
		if (array_key_exists($keys[16], $arr)) $this->setMultiUser($arr[$keys[16]]);
		if (array_key_exists($keys[17], $arr)) $this->setFirstFileId($arr[$keys[17]]);
		if (array_key_exists($keys[18], $arr)) $this->setDeleted($arr[$keys[18]]);
	}

	
	public function buildCriteria()
	{
		$criteria = new Criteria(ReaktorArtworkPeer::DATABASE_NAME);

		if ($this->isColumnModified(ReaktorArtworkPeer::ID)) $criteria->add(ReaktorArtworkPeer::ID, $this->id);
		if ($this->isColumnModified(ReaktorArtworkPeer::USER_ID)) $criteria->add(ReaktorArtworkPeer::USER_ID, $this->user_id);
		if ($this->isColumnModified(ReaktorArtworkPeer::ARTWORK_IDENTIFIER)) $criteria->add(ReaktorArtworkPeer::ARTWORK_IDENTIFIER, $this->artwork_identifier);
		if ($this->isColumnModified(ReaktorArtworkPeer::CREATED_AT)) $criteria->add(ReaktorArtworkPeer::CREATED_AT, $this->created_at);
		if ($this->isColumnModified(ReaktorArtworkPeer::SUBMITTED_AT)) $criteria->add(ReaktorArtworkPeer::SUBMITTED_AT, $this->submitted_at);
		if ($this->isColumnModified(ReaktorArtworkPeer::ACTIONED_AT)) $criteria->add(ReaktorArtworkPeer::ACTIONED_AT, $this->actioned_at);
		if ($this->isColumnModified(ReaktorArtworkPeer::MODIFIED_FLAG)) $criteria->add(ReaktorArtworkPeer::MODIFIED_FLAG, $this->modified_flag);
		if ($this->isColumnModified(ReaktorArtworkPeer::TITLE)) $criteria->add(ReaktorArtworkPeer::TITLE, $this->title);
		if ($this->isColumnModified(ReaktorArtworkPeer::ACTIONED_BY)) $criteria->add(ReaktorArtworkPeer::ACTIONED_BY, $this->actioned_by);
		if ($this->isColumnModified(ReaktorArtworkPeer::STATUS)) $criteria->add(ReaktorArtworkPeer::STATUS, $this->status);
		if ($this->isColumnModified(ReaktorArtworkPeer::DESCRIPTION)) $criteria->add(ReaktorArtworkPeer::DESCRIPTION, $this->description);
		if ($this->isColumnModified(ReaktorArtworkPeer::MODIFIED_NOTE)) $criteria->add(ReaktorArtworkPeer::MODIFIED_NOTE, $this->modified_note);
		if ($this->isColumnModified(ReaktorArtworkPeer::ARTWORK_ORDER)) $criteria->add(ReaktorArtworkPeer::ARTWORK_ORDER, $this->artwork_order);
		if ($this->isColumnModified(ReaktorArtworkPeer::AVERAGE_RATING)) $criteria->add(ReaktorArtworkPeer::AVERAGE_RATING, $this->average_rating);
		if ($this->isColumnModified(ReaktorArtworkPeer::TEAM_ID)) $criteria->add(ReaktorArtworkPeer::TEAM_ID, $this->team_id);
		if ($this->isColumnModified(ReaktorArtworkPeer::UNDER_DISCUSSION)) $criteria->add(ReaktorArtworkPeer::UNDER_DISCUSSION, $this->under_discussion);
		if ($this->isColumnModified(ReaktorArtworkPeer::MULTI_USER)) $criteria->add(ReaktorArtworkPeer::MULTI_USER, $this->multi_user);
		if ($this->isColumnModified(ReaktorArtworkPeer::FIRST_FILE_ID)) $criteria->add(ReaktorArtworkPeer::FIRST_FILE_ID, $this->first_file_id);
		if ($this->isColumnModified(ReaktorArtworkPeer::DELETED)) $criteria->add(ReaktorArtworkPeer::DELETED, $this->deleted);

		return $criteria;
	}

	
	public function buildPkeyCriteria()
	{
		$criteria = new Criteria(ReaktorArtworkPeer::DATABASE_NAME);

		$criteria->add(ReaktorArtworkPeer::ID, $this->id);

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

		$copyObj->setUserId($this->user_id);

		$copyObj->setArtworkIdentifier($this->artwork_identifier);

		$copyObj->setCreatedAt($this->created_at);

		$copyObj->setSubmittedAt($this->submitted_at);

		$copyObj->setActionedAt($this->actioned_at);

		$copyObj->setModifiedFlag($this->modified_flag);

		$copyObj->setTitle($this->title);

		$copyObj->setActionedBy($this->actioned_by);

		$copyObj->setStatus($this->status);

		$copyObj->setDescription($this->description);

		$copyObj->setModifiedNote($this->modified_note);

		$copyObj->setArtworkOrder($this->artwork_order);

		$copyObj->setAverageRating($this->average_rating);

		$copyObj->setTeamId($this->team_id);

		$copyObj->setUnderDiscussion($this->under_discussion);

		$copyObj->setMultiUser($this->multi_user);

		$copyObj->setFirstFileId($this->first_file_id);

		$copyObj->setDeleted($this->deleted);


		if ($deepCopy) {
									$copyObj->setNew(false);

			foreach($this->getRecommendedArtworks() as $relObj) {
				$copyObj->addRecommendedArtwork($relObj->copy($deepCopy));
			}

			foreach($this->getRelatedArtworksRelatedByFirstArtwork() as $relObj) {
				$copyObj->addRelatedArtworkRelatedByFirstArtwork($relObj->copy($deepCopy));
			}

			foreach($this->getRelatedArtworksRelatedBySecondArtwork() as $relObj) {
				$copyObj->addRelatedArtworkRelatedBySecondArtwork($relObj->copy($deepCopy));
			}

			foreach($this->getArticleArtworkRelations() as $relObj) {
				$copyObj->addArticleArtworkRelation($relObj->copy($deepCopy));
			}

			foreach($this->getReaktorArtworkFiles() as $relObj) {
				$copyObj->addReaktorArtworkFile($relObj->copy($deepCopy));
			}

			foreach($this->getFavourites() as $relObj) {
				$copyObj->addFavourite($relObj->copy($deepCopy));
			}

			foreach($this->getLokalreaktorArtworks() as $relObj) {
				$copyObj->addLokalreaktorArtwork($relObj->copy($deepCopy));
			}

			foreach($this->getCategoryArtworks() as $relObj) {
				$copyObj->addCategoryArtwork($relObj->copy($deepCopy));
			}

			foreach($this->getReaktorArtworkHistorysRelatedByArtworkId() as $relObj) {
				$copyObj->addReaktorArtworkHistoryRelatedByArtworkId($relObj->copy($deepCopy));
			}

			foreach($this->getReaktorArtworkHistorysRelatedByFileId() as $relObj) {
				$copyObj->addReaktorArtworkHistoryRelatedByFileId($relObj->copy($deepCopy));
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
			self::$peer = new ReaktorArtworkPeer();
		}
		return self::$peer;
	}

	
	public function setsfGuardUser($v)
	{


		if ($v === null) {
			$this->setUserId(NULL);
		} else {
			$this->setUserId($v->getId());
		}


		$this->asfGuardUser = $v;
	}


	
	public function getsfGuardUser($con = null)
	{
		if ($this->asfGuardUser === null && ($this->user_id !== null)) {
						include_once 'plugins/sfGuardPlugin/lib/model/om/BasesfGuardUserPeer.php';

			$this->asfGuardUser = sfGuardUserPeer::retrieveByPK($this->user_id, $con);

			
		}
		return $this->asfGuardUser;
	}

	
	public function setArtworkStatus($v)
	{


		if ($v === null) {
			$this->setStatus(NULL);
		} else {
			$this->setStatus($v->getId());
		}


		$this->aArtworkStatus = $v;
	}


	
	public function getArtworkStatus($con = null)
	{
		if ($this->aArtworkStatus === null && ($this->status !== null)) {
						include_once 'lib/model/om/BaseArtworkStatusPeer.php';

			$this->aArtworkStatus = ArtworkStatusPeer::retrieveByPK($this->status, $con);

			
		}
		return $this->aArtworkStatus;
	}

	
	public function setsfGuardGroup($v)
	{


		if ($v === null) {
			$this->setTeamId(NULL);
		} else {
			$this->setTeamId($v->getId());
		}


		$this->asfGuardGroup = $v;
	}


	
	public function getsfGuardGroup($con = null)
	{
		if ($this->asfGuardGroup === null && ($this->team_id !== null)) {
						include_once 'plugins/sfGuardPlugin/lib/model/om/BasesfGuardGroupPeer.php';

			$this->asfGuardGroup = sfGuardGroupPeer::retrieveByPK($this->team_id, $con);

			
		}
		return $this->asfGuardGroup;
	}

	
	public function setReaktorFile($v)
	{


		if ($v === null) {
			$this->setFirstFileId(NULL);
		} else {
			$this->setFirstFileId($v->getId());
		}


		$this->aReaktorFile = $v;
	}


	
	public function getReaktorFile($con = null)
	{
		if ($this->aReaktorFile === null && ($this->first_file_id !== null)) {
						include_once 'lib/model/om/BaseReaktorFilePeer.php';

			$this->aReaktorFile = ReaktorFilePeer::retrieveByPK($this->first_file_id, $con);

			
		}
		return $this->aReaktorFile;
	}

	
	public function initRecommendedArtworks()
	{
		if ($this->collRecommendedArtworks === null) {
			$this->collRecommendedArtworks = array();
		}
	}

	
	public function getRecommendedArtworks($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseRecommendedArtworkPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collRecommendedArtworks === null) {
			if ($this->isNew()) {
			   $this->collRecommendedArtworks = array();
			} else {

				$criteria->add(RecommendedArtworkPeer::ARTWORK, $this->getId());

				RecommendedArtworkPeer::addSelectColumns($criteria);
				$this->collRecommendedArtworks = RecommendedArtworkPeer::doSelect($criteria, $con);
			}
		} else {
						if (!$this->isNew()) {
												

				$criteria->add(RecommendedArtworkPeer::ARTWORK, $this->getId());

				RecommendedArtworkPeer::addSelectColumns($criteria);
				if (!isset($this->lastRecommendedArtworkCriteria) || !$this->lastRecommendedArtworkCriteria->equals($criteria)) {
					$this->collRecommendedArtworks = RecommendedArtworkPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastRecommendedArtworkCriteria = $criteria;
		return $this->collRecommendedArtworks;
	}

	
	public function countRecommendedArtworks($criteria = null, $distinct = false, $con = null)
	{
				include_once 'lib/model/om/BaseRecommendedArtworkPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(RecommendedArtworkPeer::ARTWORK, $this->getId());

		return RecommendedArtworkPeer::doCount($criteria, $distinct, $con);
	}

	
	public function addRecommendedArtwork(RecommendedArtwork $l)
	{
		$this->collRecommendedArtworks[] = $l;
		$l->setReaktorArtwork($this);
	}


	
	public function getRecommendedArtworksJoinSubreaktorRelatedBySubreaktor($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseRecommendedArtworkPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collRecommendedArtworks === null) {
			if ($this->isNew()) {
				$this->collRecommendedArtworks = array();
			} else {

				$criteria->add(RecommendedArtworkPeer::ARTWORK, $this->getId());

				$this->collRecommendedArtworks = RecommendedArtworkPeer::doSelectJoinSubreaktorRelatedBySubreaktor($criteria, $con);
			}
		} else {
									
			$criteria->add(RecommendedArtworkPeer::ARTWORK, $this->getId());

			if (!isset($this->lastRecommendedArtworkCriteria) || !$this->lastRecommendedArtworkCriteria->equals($criteria)) {
				$this->collRecommendedArtworks = RecommendedArtworkPeer::doSelectJoinSubreaktorRelatedBySubreaktor($criteria, $con);
			}
		}
		$this->lastRecommendedArtworkCriteria = $criteria;

		return $this->collRecommendedArtworks;
	}


	
	public function getRecommendedArtworksJoinSubreaktorRelatedByLocalsubreaktor($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseRecommendedArtworkPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collRecommendedArtworks === null) {
			if ($this->isNew()) {
				$this->collRecommendedArtworks = array();
			} else {

				$criteria->add(RecommendedArtworkPeer::ARTWORK, $this->getId());

				$this->collRecommendedArtworks = RecommendedArtworkPeer::doSelectJoinSubreaktorRelatedByLocalsubreaktor($criteria, $con);
			}
		} else {
									
			$criteria->add(RecommendedArtworkPeer::ARTWORK, $this->getId());

			if (!isset($this->lastRecommendedArtworkCriteria) || !$this->lastRecommendedArtworkCriteria->equals($criteria)) {
				$this->collRecommendedArtworks = RecommendedArtworkPeer::doSelectJoinSubreaktorRelatedByLocalsubreaktor($criteria, $con);
			}
		}
		$this->lastRecommendedArtworkCriteria = $criteria;

		return $this->collRecommendedArtworks;
	}


	
	public function getRecommendedArtworksJoinsfGuardUser($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseRecommendedArtworkPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collRecommendedArtworks === null) {
			if ($this->isNew()) {
				$this->collRecommendedArtworks = array();
			} else {

				$criteria->add(RecommendedArtworkPeer::ARTWORK, $this->getId());

				$this->collRecommendedArtworks = RecommendedArtworkPeer::doSelectJoinsfGuardUser($criteria, $con);
			}
		} else {
									
			$criteria->add(RecommendedArtworkPeer::ARTWORK, $this->getId());

			if (!isset($this->lastRecommendedArtworkCriteria) || !$this->lastRecommendedArtworkCriteria->equals($criteria)) {
				$this->collRecommendedArtworks = RecommendedArtworkPeer::doSelectJoinsfGuardUser($criteria, $con);
			}
		}
		$this->lastRecommendedArtworkCriteria = $criteria;

		return $this->collRecommendedArtworks;
	}

	
	public function initRelatedArtworksRelatedByFirstArtwork()
	{
		if ($this->collRelatedArtworksRelatedByFirstArtwork === null) {
			$this->collRelatedArtworksRelatedByFirstArtwork = array();
		}
	}

	
	public function getRelatedArtworksRelatedByFirstArtwork($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseRelatedArtworkPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collRelatedArtworksRelatedByFirstArtwork === null) {
			if ($this->isNew()) {
			   $this->collRelatedArtworksRelatedByFirstArtwork = array();
			} else {

				$criteria->add(RelatedArtworkPeer::FIRST_ARTWORK, $this->getId());

				RelatedArtworkPeer::addSelectColumns($criteria);
				$this->collRelatedArtworksRelatedByFirstArtwork = RelatedArtworkPeer::doSelect($criteria, $con);
			}
		} else {
						if (!$this->isNew()) {
												

				$criteria->add(RelatedArtworkPeer::FIRST_ARTWORK, $this->getId());

				RelatedArtworkPeer::addSelectColumns($criteria);
				if (!isset($this->lastRelatedArtworkRelatedByFirstArtworkCriteria) || !$this->lastRelatedArtworkRelatedByFirstArtworkCriteria->equals($criteria)) {
					$this->collRelatedArtworksRelatedByFirstArtwork = RelatedArtworkPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastRelatedArtworkRelatedByFirstArtworkCriteria = $criteria;
		return $this->collRelatedArtworksRelatedByFirstArtwork;
	}

	
	public function countRelatedArtworksRelatedByFirstArtwork($criteria = null, $distinct = false, $con = null)
	{
				include_once 'lib/model/om/BaseRelatedArtworkPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(RelatedArtworkPeer::FIRST_ARTWORK, $this->getId());

		return RelatedArtworkPeer::doCount($criteria, $distinct, $con);
	}

	
	public function addRelatedArtworkRelatedByFirstArtwork(RelatedArtwork $l)
	{
		$this->collRelatedArtworksRelatedByFirstArtwork[] = $l;
		$l->setReaktorArtworkRelatedByFirstArtwork($this);
	}


	
	public function getRelatedArtworksRelatedByFirstArtworkJoinsfGuardUser($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseRelatedArtworkPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collRelatedArtworksRelatedByFirstArtwork === null) {
			if ($this->isNew()) {
				$this->collRelatedArtworksRelatedByFirstArtwork = array();
			} else {

				$criteria->add(RelatedArtworkPeer::FIRST_ARTWORK, $this->getId());

				$this->collRelatedArtworksRelatedByFirstArtwork = RelatedArtworkPeer::doSelectJoinsfGuardUser($criteria, $con);
			}
		} else {
									
			$criteria->add(RelatedArtworkPeer::FIRST_ARTWORK, $this->getId());

			if (!isset($this->lastRelatedArtworkRelatedByFirstArtworkCriteria) || !$this->lastRelatedArtworkRelatedByFirstArtworkCriteria->equals($criteria)) {
				$this->collRelatedArtworksRelatedByFirstArtwork = RelatedArtworkPeer::doSelectJoinsfGuardUser($criteria, $con);
			}
		}
		$this->lastRelatedArtworkRelatedByFirstArtworkCriteria = $criteria;

		return $this->collRelatedArtworksRelatedByFirstArtwork;
	}

	
	public function initRelatedArtworksRelatedBySecondArtwork()
	{
		if ($this->collRelatedArtworksRelatedBySecondArtwork === null) {
			$this->collRelatedArtworksRelatedBySecondArtwork = array();
		}
	}

	
	public function getRelatedArtworksRelatedBySecondArtwork($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseRelatedArtworkPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collRelatedArtworksRelatedBySecondArtwork === null) {
			if ($this->isNew()) {
			   $this->collRelatedArtworksRelatedBySecondArtwork = array();
			} else {

				$criteria->add(RelatedArtworkPeer::SECOND_ARTWORK, $this->getId());

				RelatedArtworkPeer::addSelectColumns($criteria);
				$this->collRelatedArtworksRelatedBySecondArtwork = RelatedArtworkPeer::doSelect($criteria, $con);
			}
		} else {
						if (!$this->isNew()) {
												

				$criteria->add(RelatedArtworkPeer::SECOND_ARTWORK, $this->getId());

				RelatedArtworkPeer::addSelectColumns($criteria);
				if (!isset($this->lastRelatedArtworkRelatedBySecondArtworkCriteria) || !$this->lastRelatedArtworkRelatedBySecondArtworkCriteria->equals($criteria)) {
					$this->collRelatedArtworksRelatedBySecondArtwork = RelatedArtworkPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastRelatedArtworkRelatedBySecondArtworkCriteria = $criteria;
		return $this->collRelatedArtworksRelatedBySecondArtwork;
	}

	
	public function countRelatedArtworksRelatedBySecondArtwork($criteria = null, $distinct = false, $con = null)
	{
				include_once 'lib/model/om/BaseRelatedArtworkPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(RelatedArtworkPeer::SECOND_ARTWORK, $this->getId());

		return RelatedArtworkPeer::doCount($criteria, $distinct, $con);
	}

	
	public function addRelatedArtworkRelatedBySecondArtwork(RelatedArtwork $l)
	{
		$this->collRelatedArtworksRelatedBySecondArtwork[] = $l;
		$l->setReaktorArtworkRelatedBySecondArtwork($this);
	}


	
	public function getRelatedArtworksRelatedBySecondArtworkJoinsfGuardUser($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseRelatedArtworkPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collRelatedArtworksRelatedBySecondArtwork === null) {
			if ($this->isNew()) {
				$this->collRelatedArtworksRelatedBySecondArtwork = array();
			} else {

				$criteria->add(RelatedArtworkPeer::SECOND_ARTWORK, $this->getId());

				$this->collRelatedArtworksRelatedBySecondArtwork = RelatedArtworkPeer::doSelectJoinsfGuardUser($criteria, $con);
			}
		} else {
									
			$criteria->add(RelatedArtworkPeer::SECOND_ARTWORK, $this->getId());

			if (!isset($this->lastRelatedArtworkRelatedBySecondArtworkCriteria) || !$this->lastRelatedArtworkRelatedBySecondArtworkCriteria->equals($criteria)) {
				$this->collRelatedArtworksRelatedBySecondArtwork = RelatedArtworkPeer::doSelectJoinsfGuardUser($criteria, $con);
			}
		}
		$this->lastRelatedArtworkRelatedBySecondArtworkCriteria = $criteria;

		return $this->collRelatedArtworksRelatedBySecondArtwork;
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

				$criteria->add(ArticleArtworkRelationPeer::ARTWORK_ID, $this->getId());

				ArticleArtworkRelationPeer::addSelectColumns($criteria);
				$this->collArticleArtworkRelations = ArticleArtworkRelationPeer::doSelect($criteria, $con);
			}
		} else {
						if (!$this->isNew()) {
												

				$criteria->add(ArticleArtworkRelationPeer::ARTWORK_ID, $this->getId());

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

		$criteria->add(ArticleArtworkRelationPeer::ARTWORK_ID, $this->getId());

		return ArticleArtworkRelationPeer::doCount($criteria, $distinct, $con);
	}

	
	public function addArticleArtworkRelation(ArticleArtworkRelation $l)
	{
		$this->collArticleArtworkRelations[] = $l;
		$l->setReaktorArtwork($this);
	}


	
	public function getArticleArtworkRelationsJoinArticle($criteria = null, $con = null)
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

				$criteria->add(ArticleArtworkRelationPeer::ARTWORK_ID, $this->getId());

				$this->collArticleArtworkRelations = ArticleArtworkRelationPeer::doSelectJoinArticle($criteria, $con);
			}
		} else {
									
			$criteria->add(ArticleArtworkRelationPeer::ARTWORK_ID, $this->getId());

			if (!isset($this->lastArticleArtworkRelationCriteria) || !$this->lastArticleArtworkRelationCriteria->equals($criteria)) {
				$this->collArticleArtworkRelations = ArticleArtworkRelationPeer::doSelectJoinArticle($criteria, $con);
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

				$criteria->add(ArticleArtworkRelationPeer::ARTWORK_ID, $this->getId());

				$this->collArticleArtworkRelations = ArticleArtworkRelationPeer::doSelectJoinsfGuardUser($criteria, $con);
			}
		} else {
									
			$criteria->add(ArticleArtworkRelationPeer::ARTWORK_ID, $this->getId());

			if (!isset($this->lastArticleArtworkRelationCriteria) || !$this->lastArticleArtworkRelationCriteria->equals($criteria)) {
				$this->collArticleArtworkRelations = ArticleArtworkRelationPeer::doSelectJoinsfGuardUser($criteria, $con);
			}
		}
		$this->lastArticleArtworkRelationCriteria = $criteria;

		return $this->collArticleArtworkRelations;
	}

	
	public function initReaktorArtworkFiles()
	{
		if ($this->collReaktorArtworkFiles === null) {
			$this->collReaktorArtworkFiles = array();
		}
	}

	
	public function getReaktorArtworkFiles($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseReaktorArtworkFilePeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collReaktorArtworkFiles === null) {
			if ($this->isNew()) {
			   $this->collReaktorArtworkFiles = array();
			} else {

				$criteria->add(ReaktorArtworkFilePeer::ARTWORK_ID, $this->getId());

				ReaktorArtworkFilePeer::addSelectColumns($criteria);
				$this->collReaktorArtworkFiles = ReaktorArtworkFilePeer::doSelect($criteria, $con);
			}
		} else {
						if (!$this->isNew()) {
												

				$criteria->add(ReaktorArtworkFilePeer::ARTWORK_ID, $this->getId());

				ReaktorArtworkFilePeer::addSelectColumns($criteria);
				if (!isset($this->lastReaktorArtworkFileCriteria) || !$this->lastReaktorArtworkFileCriteria->equals($criteria)) {
					$this->collReaktorArtworkFiles = ReaktorArtworkFilePeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastReaktorArtworkFileCriteria = $criteria;
		return $this->collReaktorArtworkFiles;
	}

	
	public function countReaktorArtworkFiles($criteria = null, $distinct = false, $con = null)
	{
				include_once 'lib/model/om/BaseReaktorArtworkFilePeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(ReaktorArtworkFilePeer::ARTWORK_ID, $this->getId());

		return ReaktorArtworkFilePeer::doCount($criteria, $distinct, $con);
	}

	
	public function addReaktorArtworkFile(ReaktorArtworkFile $l)
	{
		$this->collReaktorArtworkFiles[] = $l;
		$l->setReaktorArtwork($this);
	}


	
	public function getReaktorArtworkFilesJoinReaktorFile($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseReaktorArtworkFilePeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collReaktorArtworkFiles === null) {
			if ($this->isNew()) {
				$this->collReaktorArtworkFiles = array();
			} else {

				$criteria->add(ReaktorArtworkFilePeer::ARTWORK_ID, $this->getId());

				$this->collReaktorArtworkFiles = ReaktorArtworkFilePeer::doSelectJoinReaktorFile($criteria, $con);
			}
		} else {
									
			$criteria->add(ReaktorArtworkFilePeer::ARTWORK_ID, $this->getId());

			if (!isset($this->lastReaktorArtworkFileCriteria) || !$this->lastReaktorArtworkFileCriteria->equals($criteria)) {
				$this->collReaktorArtworkFiles = ReaktorArtworkFilePeer::doSelectJoinReaktorFile($criteria, $con);
			}
		}
		$this->lastReaktorArtworkFileCriteria = $criteria;

		return $this->collReaktorArtworkFiles;
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

				$criteria->add(FavouritePeer::ARTWORK_ID, $this->getId());

				FavouritePeer::addSelectColumns($criteria);
				$this->collFavourites = FavouritePeer::doSelect($criteria, $con);
			}
		} else {
						if (!$this->isNew()) {
												

				$criteria->add(FavouritePeer::ARTWORK_ID, $this->getId());

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

		$criteria->add(FavouritePeer::ARTWORK_ID, $this->getId());

		return FavouritePeer::doCount($criteria, $distinct, $con);
	}

	
	public function addFavourite(Favourite $l)
	{
		$this->collFavourites[] = $l;
		$l->setReaktorArtwork($this);
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

				$criteria->add(FavouritePeer::ARTWORK_ID, $this->getId());

				$this->collFavourites = FavouritePeer::doSelectJoinsfGuardUserRelatedByUserId($criteria, $con);
			}
		} else {
									
			$criteria->add(FavouritePeer::ARTWORK_ID, $this->getId());

			if (!isset($this->lastFavouriteCriteria) || !$this->lastFavouriteCriteria->equals($criteria)) {
				$this->collFavourites = FavouritePeer::doSelectJoinsfGuardUserRelatedByUserId($criteria, $con);
			}
		}
		$this->lastFavouriteCriteria = $criteria;

		return $this->collFavourites;
	}


	
	public function getFavouritesJoinArticle($criteria = null, $con = null)
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

				$criteria->add(FavouritePeer::ARTWORK_ID, $this->getId());

				$this->collFavourites = FavouritePeer::doSelectJoinArticle($criteria, $con);
			}
		} else {
									
			$criteria->add(FavouritePeer::ARTWORK_ID, $this->getId());

			if (!isset($this->lastFavouriteCriteria) || !$this->lastFavouriteCriteria->equals($criteria)) {
				$this->collFavourites = FavouritePeer::doSelectJoinArticle($criteria, $con);
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

				$criteria->add(FavouritePeer::ARTWORK_ID, $this->getId());

				$this->collFavourites = FavouritePeer::doSelectJoinsfGuardUserRelatedByFriendId($criteria, $con);
			}
		} else {
									
			$criteria->add(FavouritePeer::ARTWORK_ID, $this->getId());

			if (!isset($this->lastFavouriteCriteria) || !$this->lastFavouriteCriteria->equals($criteria)) {
				$this->collFavourites = FavouritePeer::doSelectJoinsfGuardUserRelatedByFriendId($criteria, $con);
			}
		}
		$this->lastFavouriteCriteria = $criteria;

		return $this->collFavourites;
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

				$criteria->add(LokalreaktorArtworkPeer::ARTWORK_ID, $this->getId());

				LokalreaktorArtworkPeer::addSelectColumns($criteria);
				$this->collLokalreaktorArtworks = LokalreaktorArtworkPeer::doSelect($criteria, $con);
			}
		} else {
						if (!$this->isNew()) {
												

				$criteria->add(LokalreaktorArtworkPeer::ARTWORK_ID, $this->getId());

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

		$criteria->add(LokalreaktorArtworkPeer::ARTWORK_ID, $this->getId());

		return LokalreaktorArtworkPeer::doCount($criteria, $distinct, $con);
	}

	
	public function addLokalreaktorArtwork(LokalreaktorArtwork $l)
	{
		$this->collLokalreaktorArtworks[] = $l;
		$l->setReaktorArtwork($this);
	}


	
	public function getLokalreaktorArtworksJoinSubreaktor($criteria = null, $con = null)
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

				$criteria->add(LokalreaktorArtworkPeer::ARTWORK_ID, $this->getId());

				$this->collLokalreaktorArtworks = LokalreaktorArtworkPeer::doSelectJoinSubreaktor($criteria, $con);
			}
		} else {
									
			$criteria->add(LokalreaktorArtworkPeer::ARTWORK_ID, $this->getId());

			if (!isset($this->lastLokalreaktorArtworkCriteria) || !$this->lastLokalreaktorArtworkCriteria->equals($criteria)) {
				$this->collLokalreaktorArtworks = LokalreaktorArtworkPeer::doSelectJoinSubreaktor($criteria, $con);
			}
		}
		$this->lastLokalreaktorArtworkCriteria = $criteria;

		return $this->collLokalreaktorArtworks;
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

				$criteria->add(CategoryArtworkPeer::ARTWORK_ID, $this->getId());

				CategoryArtworkPeer::addSelectColumns($criteria);
				$this->collCategoryArtworks = CategoryArtworkPeer::doSelect($criteria, $con);
			}
		} else {
						if (!$this->isNew()) {
												

				$criteria->add(CategoryArtworkPeer::ARTWORK_ID, $this->getId());

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

		$criteria->add(CategoryArtworkPeer::ARTWORK_ID, $this->getId());

		return CategoryArtworkPeer::doCount($criteria, $distinct, $con);
	}

	
	public function addCategoryArtwork(CategoryArtwork $l)
	{
		$this->collCategoryArtworks[] = $l;
		$l->setReaktorArtwork($this);
	}


	
	public function getCategoryArtworksJoinCategory($criteria = null, $con = null)
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

				$criteria->add(CategoryArtworkPeer::ARTWORK_ID, $this->getId());

				$this->collCategoryArtworks = CategoryArtworkPeer::doSelectJoinCategory($criteria, $con);
			}
		} else {
									
			$criteria->add(CategoryArtworkPeer::ARTWORK_ID, $this->getId());

			if (!isset($this->lastCategoryArtworkCriteria) || !$this->lastCategoryArtworkCriteria->equals($criteria)) {
				$this->collCategoryArtworks = CategoryArtworkPeer::doSelectJoinCategory($criteria, $con);
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

				$criteria->add(CategoryArtworkPeer::ARTWORK_ID, $this->getId());

				$this->collCategoryArtworks = CategoryArtworkPeer::doSelectJoinsfGuardUser($criteria, $con);
			}
		} else {
									
			$criteria->add(CategoryArtworkPeer::ARTWORK_ID, $this->getId());

			if (!isset($this->lastCategoryArtworkCriteria) || !$this->lastCategoryArtworkCriteria->equals($criteria)) {
				$this->collCategoryArtworks = CategoryArtworkPeer::doSelectJoinsfGuardUser($criteria, $con);
			}
		}
		$this->lastCategoryArtworkCriteria = $criteria;

		return $this->collCategoryArtworks;
	}

	
	public function initReaktorArtworkHistorysRelatedByArtworkId()
	{
		if ($this->collReaktorArtworkHistorysRelatedByArtworkId === null) {
			$this->collReaktorArtworkHistorysRelatedByArtworkId = array();
		}
	}

	
	public function getReaktorArtworkHistorysRelatedByArtworkId($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseReaktorArtworkHistoryPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collReaktorArtworkHistorysRelatedByArtworkId === null) {
			if ($this->isNew()) {
			   $this->collReaktorArtworkHistorysRelatedByArtworkId = array();
			} else {

				$criteria->add(ReaktorArtworkHistoryPeer::ARTWORK_ID, $this->getId());

				ReaktorArtworkHistoryPeer::addSelectColumns($criteria);
				$this->collReaktorArtworkHistorysRelatedByArtworkId = ReaktorArtworkHistoryPeer::doSelect($criteria, $con);
			}
		} else {
						if (!$this->isNew()) {
												

				$criteria->add(ReaktorArtworkHistoryPeer::ARTWORK_ID, $this->getId());

				ReaktorArtworkHistoryPeer::addSelectColumns($criteria);
				if (!isset($this->lastReaktorArtworkHistoryRelatedByArtworkIdCriteria) || !$this->lastReaktorArtworkHistoryRelatedByArtworkIdCriteria->equals($criteria)) {
					$this->collReaktorArtworkHistorysRelatedByArtworkId = ReaktorArtworkHistoryPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastReaktorArtworkHistoryRelatedByArtworkIdCriteria = $criteria;
		return $this->collReaktorArtworkHistorysRelatedByArtworkId;
	}

	
	public function countReaktorArtworkHistorysRelatedByArtworkId($criteria = null, $distinct = false, $con = null)
	{
				include_once 'lib/model/om/BaseReaktorArtworkHistoryPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(ReaktorArtworkHistoryPeer::ARTWORK_ID, $this->getId());

		return ReaktorArtworkHistoryPeer::doCount($criteria, $distinct, $con);
	}

	
	public function addReaktorArtworkHistoryRelatedByArtworkId(ReaktorArtworkHistory $l)
	{
		$this->collReaktorArtworkHistorysRelatedByArtworkId[] = $l;
		$l->setReaktorArtworkRelatedByArtworkId($this);
	}


	
	public function getReaktorArtworkHistorysRelatedByArtworkIdJoinsfGuardUser($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseReaktorArtworkHistoryPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collReaktorArtworkHistorysRelatedByArtworkId === null) {
			if ($this->isNew()) {
				$this->collReaktorArtworkHistorysRelatedByArtworkId = array();
			} else {

				$criteria->add(ReaktorArtworkHistoryPeer::ARTWORK_ID, $this->getId());

				$this->collReaktorArtworkHistorysRelatedByArtworkId = ReaktorArtworkHistoryPeer::doSelectJoinsfGuardUser($criteria, $con);
			}
		} else {
									
			$criteria->add(ReaktorArtworkHistoryPeer::ARTWORK_ID, $this->getId());

			if (!isset($this->lastReaktorArtworkHistoryRelatedByArtworkIdCriteria) || !$this->lastReaktorArtworkHistoryRelatedByArtworkIdCriteria->equals($criteria)) {
				$this->collReaktorArtworkHistorysRelatedByArtworkId = ReaktorArtworkHistoryPeer::doSelectJoinsfGuardUser($criteria, $con);
			}
		}
		$this->lastReaktorArtworkHistoryRelatedByArtworkIdCriteria = $criteria;

		return $this->collReaktorArtworkHistorysRelatedByArtworkId;
	}


	
	public function getReaktorArtworkHistorysRelatedByArtworkIdJoinArtworkStatus($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseReaktorArtworkHistoryPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collReaktorArtworkHistorysRelatedByArtworkId === null) {
			if ($this->isNew()) {
				$this->collReaktorArtworkHistorysRelatedByArtworkId = array();
			} else {

				$criteria->add(ReaktorArtworkHistoryPeer::ARTWORK_ID, $this->getId());

				$this->collReaktorArtworkHistorysRelatedByArtworkId = ReaktorArtworkHistoryPeer::doSelectJoinArtworkStatus($criteria, $con);
			}
		} else {
									
			$criteria->add(ReaktorArtworkHistoryPeer::ARTWORK_ID, $this->getId());

			if (!isset($this->lastReaktorArtworkHistoryRelatedByArtworkIdCriteria) || !$this->lastReaktorArtworkHistoryRelatedByArtworkIdCriteria->equals($criteria)) {
				$this->collReaktorArtworkHistorysRelatedByArtworkId = ReaktorArtworkHistoryPeer::doSelectJoinArtworkStatus($criteria, $con);
			}
		}
		$this->lastReaktorArtworkHistoryRelatedByArtworkIdCriteria = $criteria;

		return $this->collReaktorArtworkHistorysRelatedByArtworkId;
	}

	
	public function initReaktorArtworkHistorysRelatedByFileId()
	{
		if ($this->collReaktorArtworkHistorysRelatedByFileId === null) {
			$this->collReaktorArtworkHistorysRelatedByFileId = array();
		}
	}

	
	public function getReaktorArtworkHistorysRelatedByFileId($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseReaktorArtworkHistoryPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collReaktorArtworkHistorysRelatedByFileId === null) {
			if ($this->isNew()) {
			   $this->collReaktorArtworkHistorysRelatedByFileId = array();
			} else {

				$criteria->add(ReaktorArtworkHistoryPeer::FILE_ID, $this->getId());

				ReaktorArtworkHistoryPeer::addSelectColumns($criteria);
				$this->collReaktorArtworkHistorysRelatedByFileId = ReaktorArtworkHistoryPeer::doSelect($criteria, $con);
			}
		} else {
						if (!$this->isNew()) {
												

				$criteria->add(ReaktorArtworkHistoryPeer::FILE_ID, $this->getId());

				ReaktorArtworkHistoryPeer::addSelectColumns($criteria);
				if (!isset($this->lastReaktorArtworkHistoryRelatedByFileIdCriteria) || !$this->lastReaktorArtworkHistoryRelatedByFileIdCriteria->equals($criteria)) {
					$this->collReaktorArtworkHistorysRelatedByFileId = ReaktorArtworkHistoryPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastReaktorArtworkHistoryRelatedByFileIdCriteria = $criteria;
		return $this->collReaktorArtworkHistorysRelatedByFileId;
	}

	
	public function countReaktorArtworkHistorysRelatedByFileId($criteria = null, $distinct = false, $con = null)
	{
				include_once 'lib/model/om/BaseReaktorArtworkHistoryPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(ReaktorArtworkHistoryPeer::FILE_ID, $this->getId());

		return ReaktorArtworkHistoryPeer::doCount($criteria, $distinct, $con);
	}

	
	public function addReaktorArtworkHistoryRelatedByFileId(ReaktorArtworkHistory $l)
	{
		$this->collReaktorArtworkHistorysRelatedByFileId[] = $l;
		$l->setReaktorArtworkRelatedByFileId($this);
	}


	
	public function getReaktorArtworkHistorysRelatedByFileIdJoinsfGuardUser($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseReaktorArtworkHistoryPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collReaktorArtworkHistorysRelatedByFileId === null) {
			if ($this->isNew()) {
				$this->collReaktorArtworkHistorysRelatedByFileId = array();
			} else {

				$criteria->add(ReaktorArtworkHistoryPeer::FILE_ID, $this->getId());

				$this->collReaktorArtworkHistorysRelatedByFileId = ReaktorArtworkHistoryPeer::doSelectJoinsfGuardUser($criteria, $con);
			}
		} else {
									
			$criteria->add(ReaktorArtworkHistoryPeer::FILE_ID, $this->getId());

			if (!isset($this->lastReaktorArtworkHistoryRelatedByFileIdCriteria) || !$this->lastReaktorArtworkHistoryRelatedByFileIdCriteria->equals($criteria)) {
				$this->collReaktorArtworkHistorysRelatedByFileId = ReaktorArtworkHistoryPeer::doSelectJoinsfGuardUser($criteria, $con);
			}
		}
		$this->lastReaktorArtworkHistoryRelatedByFileIdCriteria = $criteria;

		return $this->collReaktorArtworkHistorysRelatedByFileId;
	}


	
	public function getReaktorArtworkHistorysRelatedByFileIdJoinArtworkStatus($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseReaktorArtworkHistoryPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collReaktorArtworkHistorysRelatedByFileId === null) {
			if ($this->isNew()) {
				$this->collReaktorArtworkHistorysRelatedByFileId = array();
			} else {

				$criteria->add(ReaktorArtworkHistoryPeer::FILE_ID, $this->getId());

				$this->collReaktorArtworkHistorysRelatedByFileId = ReaktorArtworkHistoryPeer::doSelectJoinArtworkStatus($criteria, $con);
			}
		} else {
									
			$criteria->add(ReaktorArtworkHistoryPeer::FILE_ID, $this->getId());

			if (!isset($this->lastReaktorArtworkHistoryRelatedByFileIdCriteria) || !$this->lastReaktorArtworkHistoryRelatedByFileIdCriteria->equals($criteria)) {
				$this->collReaktorArtworkHistorysRelatedByFileId = ReaktorArtworkHistoryPeer::doSelectJoinArtworkStatus($criteria, $con);
			}
		}
		$this->lastReaktorArtworkHistoryRelatedByFileIdCriteria = $criteria;

		return $this->collReaktorArtworkHistorysRelatedByFileId;
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

				$criteria->add(SubreaktorArtworkPeer::ARTWORK_ID, $this->getId());

				SubreaktorArtworkPeer::addSelectColumns($criteria);
				$this->collSubreaktorArtworks = SubreaktorArtworkPeer::doSelect($criteria, $con);
			}
		} else {
						if (!$this->isNew()) {
												

				$criteria->add(SubreaktorArtworkPeer::ARTWORK_ID, $this->getId());

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

		$criteria->add(SubreaktorArtworkPeer::ARTWORK_ID, $this->getId());

		return SubreaktorArtworkPeer::doCount($criteria, $distinct, $con);
	}

	
	public function addSubreaktorArtwork(SubreaktorArtwork $l)
	{
		$this->collSubreaktorArtworks[] = $l;
		$l->setReaktorArtwork($this);
	}


	
	public function getSubreaktorArtworksJoinSubreaktor($criteria = null, $con = null)
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

				$criteria->add(SubreaktorArtworkPeer::ARTWORK_ID, $this->getId());

				$this->collSubreaktorArtworks = SubreaktorArtworkPeer::doSelectJoinSubreaktor($criteria, $con);
			}
		} else {
									
			$criteria->add(SubreaktorArtworkPeer::ARTWORK_ID, $this->getId());

			if (!isset($this->lastSubreaktorArtworkCriteria) || !$this->lastSubreaktorArtworkCriteria->equals($criteria)) {
				$this->collSubreaktorArtworks = SubreaktorArtworkPeer::doSelectJoinSubreaktor($criteria, $con);
			}
		}
		$this->lastSubreaktorArtworkCriteria = $criteria;

		return $this->collSubreaktorArtworks;
	}


  public function __call($method, $arguments)
  {
    if (!$callable = sfMixer::getCallable('BaseReaktorArtwork:'.$method))
    {
      throw new sfException(sprintf('Call to undefined method BaseReaktorArtwork::%s', $method));
    }

    array_unshift($arguments, $this);

    return call_user_func_array($callable, $arguments);
  }


} 