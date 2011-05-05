<?php


abstract class BaseReaktorFile extends BaseObject  implements Persistent {


	
	protected static $peer;


	
	protected $id;


	
	protected $filename;


	
	protected $user_id;


	
	protected $realpath;


	
	protected $thumbpath;


	
	protected $originalpath;


	
	protected $original_mimetype_id;


	
	protected $converted_mimetype_id;


	
	protected $thumbnail_mimetype_id;


	
	protected $uploaded_at;


	
	protected $modified_at;


	
	protected $reported_at;


	
	protected $reported = 0;


	
	protected $total_reported_ever = 0;


	
	protected $marked_unsuitable = 0;


	
	protected $under_discussion = 0;


	
	protected $identifier;


	
	protected $hidden = 0;


	
	protected $deleted = 0;

	
	protected $asfGuardUser;

	
	protected $collReaktorArtworkFiles;

	
	protected $lastReaktorArtworkFileCriteria = null;

	
	protected $collReaktorArtworks;

	
	protected $lastReaktorArtworkCriteria = null;

	
	protected $collFileMetadatas;

	
	protected $lastFileMetadataCriteria = null;

	
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

	
	public function getUserId()
	{

		return $this->user_id;
	}

	
	public function getRealpath()
	{

		return $this->realpath;
	}

	
	public function getThumbpath()
	{

		return $this->thumbpath;
	}

	
	public function getOriginalpath()
	{

		return $this->originalpath;
	}

	
	public function getOriginalMimetypeId()
	{

		return $this->original_mimetype_id;
	}

	
	public function getConvertedMimetypeId()
	{

		return $this->converted_mimetype_id;
	}

	
	public function getThumbnailMimetypeId()
	{

		return $this->thumbnail_mimetype_id;
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

	
	public function getModifiedAt($format = 'Y-m-d H:i:s')
	{

		if ($this->modified_at === null || $this->modified_at === '') {
			return null;
		} elseif (!is_int($this->modified_at)) {
						$ts = strtotime($this->modified_at);
			if ($ts === -1 || $ts === false) { 				throw new PropelException("Unable to parse value of [modified_at] as date/time value: " . var_export($this->modified_at, true));
			}
		} else {
			$ts = $this->modified_at;
		}
		if ($format === null) {
			return $ts;
		} elseif (strpos($format, '%') !== false) {
			return strftime($format, $ts);
		} else {
			return date($format, $ts);
		}
	}

	
	public function getReportedAt($format = 'Y-m-d H:i:s')
	{

		if ($this->reported_at === null || $this->reported_at === '') {
			return null;
		} elseif (!is_int($this->reported_at)) {
						$ts = strtotime($this->reported_at);
			if ($ts === -1 || $ts === false) { 				throw new PropelException("Unable to parse value of [reported_at] as date/time value: " . var_export($this->reported_at, true));
			}
		} else {
			$ts = $this->reported_at;
		}
		if ($format === null) {
			return $ts;
		} elseif (strpos($format, '%') !== false) {
			return strftime($format, $ts);
		} else {
			return date($format, $ts);
		}
	}

	
	public function getReported()
	{

		return $this->reported;
	}

	
	public function getTotalReportedEver()
	{

		return $this->total_reported_ever;
	}

	
	public function getMarkedUnsuitable()
	{

		return $this->marked_unsuitable;
	}

	
	public function getUnderDiscussion()
	{

		return $this->under_discussion;
	}

	
	public function getIdentifier()
	{

		return $this->identifier;
	}

	
	public function getHidden()
	{

		return $this->hidden;
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
			$this->modifiedColumns[] = ReaktorFilePeer::ID;
		}

	} 
	
	public function setFilename($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->filename !== $v) {
			$this->filename = $v;
			$this->modifiedColumns[] = ReaktorFilePeer::FILENAME;
		}

	} 
	
	public function setUserId($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->user_id !== $v) {
			$this->user_id = $v;
			$this->modifiedColumns[] = ReaktorFilePeer::USER_ID;
		}

		if ($this->asfGuardUser !== null && $this->asfGuardUser->getId() !== $v) {
			$this->asfGuardUser = null;
		}

	} 
	
	public function setRealpath($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->realpath !== $v) {
			$this->realpath = $v;
			$this->modifiedColumns[] = ReaktorFilePeer::REALPATH;
		}

	} 
	
	public function setThumbpath($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->thumbpath !== $v) {
			$this->thumbpath = $v;
			$this->modifiedColumns[] = ReaktorFilePeer::THUMBPATH;
		}

	} 
	
	public function setOriginalpath($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->originalpath !== $v) {
			$this->originalpath = $v;
			$this->modifiedColumns[] = ReaktorFilePeer::ORIGINALPATH;
		}

	} 
	
	public function setOriginalMimetypeId($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->original_mimetype_id !== $v) {
			$this->original_mimetype_id = $v;
			$this->modifiedColumns[] = ReaktorFilePeer::ORIGINAL_MIMETYPE_ID;
		}

	} 
	
	public function setConvertedMimetypeId($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->converted_mimetype_id !== $v) {
			$this->converted_mimetype_id = $v;
			$this->modifiedColumns[] = ReaktorFilePeer::CONVERTED_MIMETYPE_ID;
		}

	} 
	
	public function setThumbnailMimetypeId($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->thumbnail_mimetype_id !== $v) {
			$this->thumbnail_mimetype_id = $v;
			$this->modifiedColumns[] = ReaktorFilePeer::THUMBNAIL_MIMETYPE_ID;
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
			$this->modifiedColumns[] = ReaktorFilePeer::UPLOADED_AT;
		}

	} 
	
	public function setModifiedAt($v)
	{

		if ($v !== null && !is_int($v)) {
			$ts = strtotime($v);
			if ($ts === -1 || $ts === false) { 				throw new PropelException("Unable to parse date/time value for [modified_at] from input: " . var_export($v, true));
			}
		} else {
			$ts = $v;
		}
		if ($this->modified_at !== $ts) {
			$this->modified_at = $ts;
			$this->modifiedColumns[] = ReaktorFilePeer::MODIFIED_AT;
		}

	} 
	
	public function setReportedAt($v)
	{

		if ($v !== null && !is_int($v)) {
			$ts = strtotime($v);
			if ($ts === -1 || $ts === false) { 				throw new PropelException("Unable to parse date/time value for [reported_at] from input: " . var_export($v, true));
			}
		} else {
			$ts = $v;
		}
		if ($this->reported_at !== $ts) {
			$this->reported_at = $ts;
			$this->modifiedColumns[] = ReaktorFilePeer::REPORTED_AT;
		}

	} 
	
	public function setReported($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->reported !== $v || $v === 0) {
			$this->reported = $v;
			$this->modifiedColumns[] = ReaktorFilePeer::REPORTED;
		}

	} 
	
	public function setTotalReportedEver($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->total_reported_ever !== $v || $v === 0) {
			$this->total_reported_ever = $v;
			$this->modifiedColumns[] = ReaktorFilePeer::TOTAL_REPORTED_EVER;
		}

	} 
	
	public function setMarkedUnsuitable($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->marked_unsuitable !== $v || $v === 0) {
			$this->marked_unsuitable = $v;
			$this->modifiedColumns[] = ReaktorFilePeer::MARKED_UNSUITABLE;
		}

	} 
	
	public function setUnderDiscussion($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->under_discussion !== $v || $v === 0) {
			$this->under_discussion = $v;
			$this->modifiedColumns[] = ReaktorFilePeer::UNDER_DISCUSSION;
		}

	} 
	
	public function setIdentifier($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->identifier !== $v) {
			$this->identifier = $v;
			$this->modifiedColumns[] = ReaktorFilePeer::IDENTIFIER;
		}

	} 
	
	public function setHidden($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->hidden !== $v || $v === 0) {
			$this->hidden = $v;
			$this->modifiedColumns[] = ReaktorFilePeer::HIDDEN;
		}

	} 
	
	public function setDeleted($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->deleted !== $v || $v === 0) {
			$this->deleted = $v;
			$this->modifiedColumns[] = ReaktorFilePeer::DELETED;
		}

	} 
	
	public function hydrate(ResultSet $rs, $startcol = 1)
	{
		try {

			$this->id = $rs->getInt($startcol + 0);

			$this->filename = $rs->getString($startcol + 1);

			$this->user_id = $rs->getInt($startcol + 2);

			$this->realpath = $rs->getString($startcol + 3);

			$this->thumbpath = $rs->getString($startcol + 4);

			$this->originalpath = $rs->getString($startcol + 5);

			$this->original_mimetype_id = $rs->getInt($startcol + 6);

			$this->converted_mimetype_id = $rs->getInt($startcol + 7);

			$this->thumbnail_mimetype_id = $rs->getInt($startcol + 8);

			$this->uploaded_at = $rs->getTimestamp($startcol + 9, null);

			$this->modified_at = $rs->getTimestamp($startcol + 10, null);

			$this->reported_at = $rs->getTimestamp($startcol + 11, null);

			$this->reported = $rs->getInt($startcol + 12);

			$this->total_reported_ever = $rs->getInt($startcol + 13);

			$this->marked_unsuitable = $rs->getInt($startcol + 14);

			$this->under_discussion = $rs->getInt($startcol + 15);

			$this->identifier = $rs->getString($startcol + 16);

			$this->hidden = $rs->getInt($startcol + 17);

			$this->deleted = $rs->getInt($startcol + 18);

			$this->resetModified();

			$this->setNew(false);

						return $startcol + 19; 
		} catch (Exception $e) {
			throw new PropelException("Error populating ReaktorFile object", $e);
		}
	}

	
	public function delete($con = null)
	{

    foreach (sfMixer::getCallables('BaseReaktorFile:delete:pre') as $callable)
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
			$con = Propel::getConnection(ReaktorFilePeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			ReaktorFilePeer::doDelete($this, $con);
			$this->setDeleted(true);
			$con->commit();
		} catch (PropelException $e) {
			$con->rollback();
			throw $e;
		}
	

    foreach (sfMixer::getCallables('BaseReaktorFile:delete:post') as $callable)
    {
      call_user_func($callable, $this, $con);
    }

  }
	
	public function save($con = null)
	{

    foreach (sfMixer::getCallables('BaseReaktorFile:save:pre') as $callable)
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
			$con = Propel::getConnection(ReaktorFilePeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			$affectedRows = $this->doSave($con);
			$con->commit();
    foreach (sfMixer::getCallables('BaseReaktorFile:save:post') as $callable)
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
					$pk = ReaktorFilePeer::doInsert($this, $con);
					$affectedRows += 1; 										 										 
					$this->setId($pk);  
					$this->setNew(false);
				} else {
					$affectedRows += ReaktorFilePeer::doUpdate($this, $con);
				}
				$this->resetModified(); 			}

			if ($this->collReaktorArtworkFiles !== null) {
				foreach($this->collReaktorArtworkFiles as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collReaktorArtworks !== null) {
				foreach($this->collReaktorArtworks as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collFileMetadatas !== null) {
				foreach($this->collFileMetadatas as $referrerFK) {
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


			if (($retval = ReaktorFilePeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}


				if ($this->collReaktorArtworkFiles !== null) {
					foreach($this->collReaktorArtworkFiles as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collReaktorArtworks !== null) {
					foreach($this->collReaktorArtworks as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collFileMetadatas !== null) {
					foreach($this->collFileMetadatas as $referrerFK) {
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
		$pos = ReaktorFilePeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				return $this->getUserId();
				break;
			case 3:
				return $this->getRealpath();
				break;
			case 4:
				return $this->getThumbpath();
				break;
			case 5:
				return $this->getOriginalpath();
				break;
			case 6:
				return $this->getOriginalMimetypeId();
				break;
			case 7:
				return $this->getConvertedMimetypeId();
				break;
			case 8:
				return $this->getThumbnailMimetypeId();
				break;
			case 9:
				return $this->getUploadedAt();
				break;
			case 10:
				return $this->getModifiedAt();
				break;
			case 11:
				return $this->getReportedAt();
				break;
			case 12:
				return $this->getReported();
				break;
			case 13:
				return $this->getTotalReportedEver();
				break;
			case 14:
				return $this->getMarkedUnsuitable();
				break;
			case 15:
				return $this->getUnderDiscussion();
				break;
			case 16:
				return $this->getIdentifier();
				break;
			case 17:
				return $this->getHidden();
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
		$keys = ReaktorFilePeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getId(),
			$keys[1] => $this->getFilename(),
			$keys[2] => $this->getUserId(),
			$keys[3] => $this->getRealpath(),
			$keys[4] => $this->getThumbpath(),
			$keys[5] => $this->getOriginalpath(),
			$keys[6] => $this->getOriginalMimetypeId(),
			$keys[7] => $this->getConvertedMimetypeId(),
			$keys[8] => $this->getThumbnailMimetypeId(),
			$keys[9] => $this->getUploadedAt(),
			$keys[10] => $this->getModifiedAt(),
			$keys[11] => $this->getReportedAt(),
			$keys[12] => $this->getReported(),
			$keys[13] => $this->getTotalReportedEver(),
			$keys[14] => $this->getMarkedUnsuitable(),
			$keys[15] => $this->getUnderDiscussion(),
			$keys[16] => $this->getIdentifier(),
			$keys[17] => $this->getHidden(),
			$keys[18] => $this->getDeleted(),
		);
		return $result;
	}

	
	public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = ReaktorFilePeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				$this->setUserId($value);
				break;
			case 3:
				$this->setRealpath($value);
				break;
			case 4:
				$this->setThumbpath($value);
				break;
			case 5:
				$this->setOriginalpath($value);
				break;
			case 6:
				$this->setOriginalMimetypeId($value);
				break;
			case 7:
				$this->setConvertedMimetypeId($value);
				break;
			case 8:
				$this->setThumbnailMimetypeId($value);
				break;
			case 9:
				$this->setUploadedAt($value);
				break;
			case 10:
				$this->setModifiedAt($value);
				break;
			case 11:
				$this->setReportedAt($value);
				break;
			case 12:
				$this->setReported($value);
				break;
			case 13:
				$this->setTotalReportedEver($value);
				break;
			case 14:
				$this->setMarkedUnsuitable($value);
				break;
			case 15:
				$this->setUnderDiscussion($value);
				break;
			case 16:
				$this->setIdentifier($value);
				break;
			case 17:
				$this->setHidden($value);
				break;
			case 18:
				$this->setDeleted($value);
				break;
		} 	}

	
	public function fromArray($arr, $keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = ReaktorFilePeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setFilename($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setUserId($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setRealpath($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setThumbpath($arr[$keys[4]]);
		if (array_key_exists($keys[5], $arr)) $this->setOriginalpath($arr[$keys[5]]);
		if (array_key_exists($keys[6], $arr)) $this->setOriginalMimetypeId($arr[$keys[6]]);
		if (array_key_exists($keys[7], $arr)) $this->setConvertedMimetypeId($arr[$keys[7]]);
		if (array_key_exists($keys[8], $arr)) $this->setThumbnailMimetypeId($arr[$keys[8]]);
		if (array_key_exists($keys[9], $arr)) $this->setUploadedAt($arr[$keys[9]]);
		if (array_key_exists($keys[10], $arr)) $this->setModifiedAt($arr[$keys[10]]);
		if (array_key_exists($keys[11], $arr)) $this->setReportedAt($arr[$keys[11]]);
		if (array_key_exists($keys[12], $arr)) $this->setReported($arr[$keys[12]]);
		if (array_key_exists($keys[13], $arr)) $this->setTotalReportedEver($arr[$keys[13]]);
		if (array_key_exists($keys[14], $arr)) $this->setMarkedUnsuitable($arr[$keys[14]]);
		if (array_key_exists($keys[15], $arr)) $this->setUnderDiscussion($arr[$keys[15]]);
		if (array_key_exists($keys[16], $arr)) $this->setIdentifier($arr[$keys[16]]);
		if (array_key_exists($keys[17], $arr)) $this->setHidden($arr[$keys[17]]);
		if (array_key_exists($keys[18], $arr)) $this->setDeleted($arr[$keys[18]]);
	}

	
	public function buildCriteria()
	{
		$criteria = new Criteria(ReaktorFilePeer::DATABASE_NAME);

		if ($this->isColumnModified(ReaktorFilePeer::ID)) $criteria->add(ReaktorFilePeer::ID, $this->id);
		if ($this->isColumnModified(ReaktorFilePeer::FILENAME)) $criteria->add(ReaktorFilePeer::FILENAME, $this->filename);
		if ($this->isColumnModified(ReaktorFilePeer::USER_ID)) $criteria->add(ReaktorFilePeer::USER_ID, $this->user_id);
		if ($this->isColumnModified(ReaktorFilePeer::REALPATH)) $criteria->add(ReaktorFilePeer::REALPATH, $this->realpath);
		if ($this->isColumnModified(ReaktorFilePeer::THUMBPATH)) $criteria->add(ReaktorFilePeer::THUMBPATH, $this->thumbpath);
		if ($this->isColumnModified(ReaktorFilePeer::ORIGINALPATH)) $criteria->add(ReaktorFilePeer::ORIGINALPATH, $this->originalpath);
		if ($this->isColumnModified(ReaktorFilePeer::ORIGINAL_MIMETYPE_ID)) $criteria->add(ReaktorFilePeer::ORIGINAL_MIMETYPE_ID, $this->original_mimetype_id);
		if ($this->isColumnModified(ReaktorFilePeer::CONVERTED_MIMETYPE_ID)) $criteria->add(ReaktorFilePeer::CONVERTED_MIMETYPE_ID, $this->converted_mimetype_id);
		if ($this->isColumnModified(ReaktorFilePeer::THUMBNAIL_MIMETYPE_ID)) $criteria->add(ReaktorFilePeer::THUMBNAIL_MIMETYPE_ID, $this->thumbnail_mimetype_id);
		if ($this->isColumnModified(ReaktorFilePeer::UPLOADED_AT)) $criteria->add(ReaktorFilePeer::UPLOADED_AT, $this->uploaded_at);
		if ($this->isColumnModified(ReaktorFilePeer::MODIFIED_AT)) $criteria->add(ReaktorFilePeer::MODIFIED_AT, $this->modified_at);
		if ($this->isColumnModified(ReaktorFilePeer::REPORTED_AT)) $criteria->add(ReaktorFilePeer::REPORTED_AT, $this->reported_at);
		if ($this->isColumnModified(ReaktorFilePeer::REPORTED)) $criteria->add(ReaktorFilePeer::REPORTED, $this->reported);
		if ($this->isColumnModified(ReaktorFilePeer::TOTAL_REPORTED_EVER)) $criteria->add(ReaktorFilePeer::TOTAL_REPORTED_EVER, $this->total_reported_ever);
		if ($this->isColumnModified(ReaktorFilePeer::MARKED_UNSUITABLE)) $criteria->add(ReaktorFilePeer::MARKED_UNSUITABLE, $this->marked_unsuitable);
		if ($this->isColumnModified(ReaktorFilePeer::UNDER_DISCUSSION)) $criteria->add(ReaktorFilePeer::UNDER_DISCUSSION, $this->under_discussion);
		if ($this->isColumnModified(ReaktorFilePeer::IDENTIFIER)) $criteria->add(ReaktorFilePeer::IDENTIFIER, $this->identifier);
		if ($this->isColumnModified(ReaktorFilePeer::HIDDEN)) $criteria->add(ReaktorFilePeer::HIDDEN, $this->hidden);
		if ($this->isColumnModified(ReaktorFilePeer::DELETED)) $criteria->add(ReaktorFilePeer::DELETED, $this->deleted);

		return $criteria;
	}

	
	public function buildPkeyCriteria()
	{
		$criteria = new Criteria(ReaktorFilePeer::DATABASE_NAME);

		$criteria->add(ReaktorFilePeer::ID, $this->id);

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

		$copyObj->setUserId($this->user_id);

		$copyObj->setRealpath($this->realpath);

		$copyObj->setThumbpath($this->thumbpath);

		$copyObj->setOriginalpath($this->originalpath);

		$copyObj->setOriginalMimetypeId($this->original_mimetype_id);

		$copyObj->setConvertedMimetypeId($this->converted_mimetype_id);

		$copyObj->setThumbnailMimetypeId($this->thumbnail_mimetype_id);

		$copyObj->setUploadedAt($this->uploaded_at);

		$copyObj->setModifiedAt($this->modified_at);

		$copyObj->setReportedAt($this->reported_at);

		$copyObj->setReported($this->reported);

		$copyObj->setTotalReportedEver($this->total_reported_ever);

		$copyObj->setMarkedUnsuitable($this->marked_unsuitable);

		$copyObj->setUnderDiscussion($this->under_discussion);

		$copyObj->setIdentifier($this->identifier);

		$copyObj->setHidden($this->hidden);

		$copyObj->setDeleted($this->deleted);


		if ($deepCopy) {
									$copyObj->setNew(false);

			foreach($this->getReaktorArtworkFiles() as $relObj) {
				$copyObj->addReaktorArtworkFile($relObj->copy($deepCopy));
			}

			foreach($this->getReaktorArtworks() as $relObj) {
				$copyObj->addReaktorArtwork($relObj->copy($deepCopy));
			}

			foreach($this->getFileMetadatas() as $relObj) {
				$copyObj->addFileMetadata($relObj->copy($deepCopy));
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
			self::$peer = new ReaktorFilePeer();
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

				$criteria->add(ReaktorArtworkFilePeer::FILE_ID, $this->getId());

				ReaktorArtworkFilePeer::addSelectColumns($criteria);
				$this->collReaktorArtworkFiles = ReaktorArtworkFilePeer::doSelect($criteria, $con);
			}
		} else {
						if (!$this->isNew()) {
												

				$criteria->add(ReaktorArtworkFilePeer::FILE_ID, $this->getId());

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

		$criteria->add(ReaktorArtworkFilePeer::FILE_ID, $this->getId());

		return ReaktorArtworkFilePeer::doCount($criteria, $distinct, $con);
	}

	
	public function addReaktorArtworkFile(ReaktorArtworkFile $l)
	{
		$this->collReaktorArtworkFiles[] = $l;
		$l->setReaktorFile($this);
	}


	
	public function getReaktorArtworkFilesJoinReaktorArtwork($criteria = null, $con = null)
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

				$criteria->add(ReaktorArtworkFilePeer::FILE_ID, $this->getId());

				$this->collReaktorArtworkFiles = ReaktorArtworkFilePeer::doSelectJoinReaktorArtwork($criteria, $con);
			}
		} else {
									
			$criteria->add(ReaktorArtworkFilePeer::FILE_ID, $this->getId());

			if (!isset($this->lastReaktorArtworkFileCriteria) || !$this->lastReaktorArtworkFileCriteria->equals($criteria)) {
				$this->collReaktorArtworkFiles = ReaktorArtworkFilePeer::doSelectJoinReaktorArtwork($criteria, $con);
			}
		}
		$this->lastReaktorArtworkFileCriteria = $criteria;

		return $this->collReaktorArtworkFiles;
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

				$criteria->add(ReaktorArtworkPeer::FIRST_FILE_ID, $this->getId());

				ReaktorArtworkPeer::addSelectColumns($criteria);
				$this->collReaktorArtworks = ReaktorArtworkPeer::doSelect($criteria, $con);
			}
		} else {
						if (!$this->isNew()) {
												

				$criteria->add(ReaktorArtworkPeer::FIRST_FILE_ID, $this->getId());

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

		$criteria->add(ReaktorArtworkPeer::FIRST_FILE_ID, $this->getId());

		return ReaktorArtworkPeer::doCount($criteria, $distinct, $con);
	}

	
	public function addReaktorArtwork(ReaktorArtwork $l)
	{
		$this->collReaktorArtworks[] = $l;
		$l->setReaktorFile($this);
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

				$criteria->add(ReaktorArtworkPeer::FIRST_FILE_ID, $this->getId());

				$this->collReaktorArtworks = ReaktorArtworkPeer::doSelectJoinsfGuardUser($criteria, $con);
			}
		} else {
									
			$criteria->add(ReaktorArtworkPeer::FIRST_FILE_ID, $this->getId());

			if (!isset($this->lastReaktorArtworkCriteria) || !$this->lastReaktorArtworkCriteria->equals($criteria)) {
				$this->collReaktorArtworks = ReaktorArtworkPeer::doSelectJoinsfGuardUser($criteria, $con);
			}
		}
		$this->lastReaktorArtworkCriteria = $criteria;

		return $this->collReaktorArtworks;
	}


	
	public function getReaktorArtworksJoinArtworkStatus($criteria = null, $con = null)
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

				$criteria->add(ReaktorArtworkPeer::FIRST_FILE_ID, $this->getId());

				$this->collReaktorArtworks = ReaktorArtworkPeer::doSelectJoinArtworkStatus($criteria, $con);
			}
		} else {
									
			$criteria->add(ReaktorArtworkPeer::FIRST_FILE_ID, $this->getId());

			if (!isset($this->lastReaktorArtworkCriteria) || !$this->lastReaktorArtworkCriteria->equals($criteria)) {
				$this->collReaktorArtworks = ReaktorArtworkPeer::doSelectJoinArtworkStatus($criteria, $con);
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

				$criteria->add(ReaktorArtworkPeer::FIRST_FILE_ID, $this->getId());

				$this->collReaktorArtworks = ReaktorArtworkPeer::doSelectJoinsfGuardGroup($criteria, $con);
			}
		} else {
									
			$criteria->add(ReaktorArtworkPeer::FIRST_FILE_ID, $this->getId());

			if (!isset($this->lastReaktorArtworkCriteria) || !$this->lastReaktorArtworkCriteria->equals($criteria)) {
				$this->collReaktorArtworks = ReaktorArtworkPeer::doSelectJoinsfGuardGroup($criteria, $con);
			}
		}
		$this->lastReaktorArtworkCriteria = $criteria;

		return $this->collReaktorArtworks;
	}

	
	public function initFileMetadatas()
	{
		if ($this->collFileMetadatas === null) {
			$this->collFileMetadatas = array();
		}
	}

	
	public function getFileMetadatas($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseFileMetadataPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collFileMetadatas === null) {
			if ($this->isNew()) {
			   $this->collFileMetadatas = array();
			} else {

				$criteria->add(FileMetadataPeer::FILE, $this->getId());

				FileMetadataPeer::addSelectColumns($criteria);
				$this->collFileMetadatas = FileMetadataPeer::doSelect($criteria, $con);
			}
		} else {
						if (!$this->isNew()) {
												

				$criteria->add(FileMetadataPeer::FILE, $this->getId());

				FileMetadataPeer::addSelectColumns($criteria);
				if (!isset($this->lastFileMetadataCriteria) || !$this->lastFileMetadataCriteria->equals($criteria)) {
					$this->collFileMetadatas = FileMetadataPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastFileMetadataCriteria = $criteria;
		return $this->collFileMetadatas;
	}

	
	public function countFileMetadatas($criteria = null, $distinct = false, $con = null)
	{
				include_once 'lib/model/om/BaseFileMetadataPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(FileMetadataPeer::FILE, $this->getId());

		return FileMetadataPeer::doCount($criteria, $distinct, $con);
	}

	
	public function addFileMetadata(FileMetadata $l)
	{
		$this->collFileMetadatas[] = $l;
		$l->setReaktorFile($this);
	}


  public function __call($method, $arguments)
  {
    if (!$callable = sfMixer::getCallable('BaseReaktorFile:'.$method))
    {
      throw new sfException(sprintf('Call to undefined method BaseReaktorFile::%s', $method));
    }

    array_unshift($arguments, $this);

    return call_user_func_array($callable, $arguments);
  }


} 