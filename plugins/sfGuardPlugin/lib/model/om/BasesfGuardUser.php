<?php


abstract class BasesfGuardUser extends BaseObject  implements Persistent {


	
	protected static $peer;


	
	protected $id;


	
	protected $username;


	
	protected $algorithm = 'sha1';


	
	protected $salt;


	
	protected $password;


	
	protected $created_at;


	
	protected $last_login;


	
	protected $is_active = true;


	
	protected $is_super_admin = false;


	
	protected $is_verified = false;


	
	protected $show_content = false;


	
	protected $culture = 'no';


	
	protected $email;


	
	protected $email_private = true;


	
	protected $new_email;


	
	protected $new_email_key;


	
	protected $new_password_key;


	
	protected $key_expires;


	
	protected $name;


	
	protected $name_private = false;


	
	protected $dob;


	
	protected $sex;


	
	protected $description;


	
	protected $residence_id;


	
	protected $avatar;


	
	protected $msn;


	
	protected $icq;


	
	protected $homepage;


	
	protected $phone;


	
	protected $opt_in = false;


	
	protected $editorial_notification = 0;


	
	protected $show_login_status = 1;


	
	protected $last_active;


	
	protected $dob_is_derived = 0;


	
	protected $need_profile_check = 0;


	
	protected $first_reaktor_login;

	
	protected $aResidence;

	
	protected $collUserInterests;

	
	protected $lastUserInterestCriteria = null;

	
	protected $collRecommendedArtworks;

	
	protected $lastRecommendedArtworkCriteria = null;

	
	protected $collRelatedArtworks;

	
	protected $lastRelatedArtworkCriteria = null;

	
	protected $collArticles;

	
	protected $lastArticleCriteria = null;

	
	protected $collArticleArticleRelations;

	
	protected $lastArticleArticleRelationCriteria = null;

	
	protected $collArticleArtworkRelations;

	
	protected $lastArticleArtworkRelationCriteria = null;

	
	protected $collArticleFiles;

	
	protected $lastArticleFileCriteria = null;

	
	protected $collsfComments;

	
	protected $lastsfCommentCriteria = null;

	
	protected $collTags;

	
	protected $lastTagCriteria = null;

	
	protected $collTaggings;

	
	protected $lastTaggingCriteria = null;

	
	protected $collReaktorArtworks;

	
	protected $lastReaktorArtworkCriteria = null;

	
	protected $collFavouritesRelatedByUserId;

	
	protected $lastFavouriteRelatedByUserIdCriteria = null;

	
	protected $collFavouritesRelatedByFriendId;

	
	protected $lastFavouriteRelatedByFriendIdCriteria = null;

	
	protected $collsfGuardUserPermissions;

	
	protected $lastsfGuardUserPermissionCriteria = null;

	
	protected $collsfGuardUserGroups;

	
	protected $lastsfGuardUserGroupCriteria = null;

	
	protected $collsfGuardRememberKeys;

	
	protected $lastsfGuardRememberKeyCriteria = null;

	
	protected $collUserResources;

	
	protected $lastUserResourceCriteria = null;

	
	protected $collCategoryArtworks;

	
	protected $lastCategoryArtworkCriteria = null;

	
	protected $collMessagessRelatedByToUserId;

	
	protected $lastMessagesRelatedByToUserIdCriteria = null;

	
	protected $collMessagessRelatedByFromUserId;

	
	protected $lastMessagesRelatedByFromUserIdCriteria = null;

	
	protected $collMessagesIgnoredUsersRelatedByUserId;

	
	protected $lastMessagesIgnoredUserRelatedByUserIdCriteria = null;

	
	protected $collMessagesIgnoredUsersRelatedByIgnoresUserId;

	
	protected $lastMessagesIgnoredUserRelatedByIgnoresUserIdCriteria = null;

	
	protected $collAdminMessages;

	
	protected $lastAdminMessageCriteria = null;

	
	protected $collReaktorFiles;

	
	protected $lastReaktorFileCriteria = null;

	
	protected $collReaktorArtworkHistorys;

	
	protected $lastReaktorArtworkHistoryCriteria = null;

	
	protected $collHistorys;

	
	protected $lastHistoryCriteria = null;

	
	protected $alreadyInSave = false;

	
	protected $alreadyInValidation = false;

	
	public function getId()
	{

		return $this->id;
	}

	
	public function getUsername()
	{

		return $this->username;
	}

	
	public function getAlgorithm()
	{

		return $this->algorithm;
	}

	
	public function getSalt()
	{

		return $this->salt;
	}

	
	public function getPassword()
	{

		return $this->password;
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

	
	public function getLastLogin($format = 'Y-m-d H:i:s')
	{

		if ($this->last_login === null || $this->last_login === '') {
			return null;
		} elseif (!is_int($this->last_login)) {
						$ts = strtotime($this->last_login);
			if ($ts === -1 || $ts === false) { 				throw new PropelException("Unable to parse value of [last_login] as date/time value: " . var_export($this->last_login, true));
			}
		} else {
			$ts = $this->last_login;
		}
		if ($format === null) {
			return $ts;
		} elseif (strpos($format, '%') !== false) {
			return strftime($format, $ts);
		} else {
			return date($format, $ts);
		}
	}

	
	public function getIsActive()
	{

		return $this->is_active;
	}

	
	public function getIsSuperAdmin()
	{

		return $this->is_super_admin;
	}

	
	public function getIsVerified()
	{

		return $this->is_verified;
	}

	
	public function getShowContent()
	{

		return $this->show_content;
	}

	
	public function getCulture()
	{

		return $this->culture;
	}

	
	public function getEmail()
	{

		return $this->email;
	}

	
	public function getEmailPrivate()
	{

		return $this->email_private;
	}

	
	public function getNewEmail()
	{

		return $this->new_email;
	}

	
	public function getNewEmailKey()
	{

		return $this->new_email_key;
	}

	
	public function getNewPasswordKey()
	{

		return $this->new_password_key;
	}

	
	public function getKeyExpires($format = 'Y-m-d H:i:s')
	{

		if ($this->key_expires === null || $this->key_expires === '') {
			return null;
		} elseif (!is_int($this->key_expires)) {
						$ts = strtotime($this->key_expires);
			if ($ts === -1 || $ts === false) { 				throw new PropelException("Unable to parse value of [key_expires] as date/time value: " . var_export($this->key_expires, true));
			}
		} else {
			$ts = $this->key_expires;
		}
		if ($format === null) {
			return $ts;
		} elseif (strpos($format, '%') !== false) {
			return strftime($format, $ts);
		} else {
			return date($format, $ts);
		}
	}

	
	public function getName()
	{

		return $this->name;
	}

	
	public function getNamePrivate()
	{

		return $this->name_private;
	}

	
	public function getDob()
	{

		return $this->dob;
	}

	
	public function getSex()
	{

		return $this->sex;
	}

	
	public function getDescription()
	{

		return $this->description;
	}

	
	public function getResidenceId()
	{

		return $this->residence_id;
	}

	
	public function getAvatar()
	{

		return $this->avatar;
	}

	
	public function getMsn()
	{

		return $this->msn;
	}

	
	public function getIcq()
	{

		return $this->icq;
	}

	
	public function getHomepage()
	{

		return $this->homepage;
	}

	
	public function getPhone()
	{

		return $this->phone;
	}

	
	public function getOptIn()
	{

		return $this->opt_in;
	}

	
	public function getEditorialNotification()
	{

		return $this->editorial_notification;
	}

	
	public function getShowLoginStatus()
	{

		return $this->show_login_status;
	}

	
	public function getLastActive($format = 'Y-m-d H:i:s')
	{

		if ($this->last_active === null || $this->last_active === '') {
			return null;
		} elseif (!is_int($this->last_active)) {
						$ts = strtotime($this->last_active);
			if ($ts === -1 || $ts === false) { 				throw new PropelException("Unable to parse value of [last_active] as date/time value: " . var_export($this->last_active, true));
			}
		} else {
			$ts = $this->last_active;
		}
		if ($format === null) {
			return $ts;
		} elseif (strpos($format, '%') !== false) {
			return strftime($format, $ts);
		} else {
			return date($format, $ts);
		}
	}

	
	public function getDobIsDerived()
	{

		return $this->dob_is_derived;
	}

	
	public function getNeedProfileCheck()
	{

		return $this->need_profile_check;
	}

	
	public function getFirstReaktorLogin($format = 'Y-m-d H:i:s')
	{

		if ($this->first_reaktor_login === null || $this->first_reaktor_login === '') {
			return null;
		} elseif (!is_int($this->first_reaktor_login)) {
						$ts = strtotime($this->first_reaktor_login);
			if ($ts === -1 || $ts === false) { 				throw new PropelException("Unable to parse value of [first_reaktor_login] as date/time value: " . var_export($this->first_reaktor_login, true));
			}
		} else {
			$ts = $this->first_reaktor_login;
		}
		if ($format === null) {
			return $ts;
		} elseif (strpos($format, '%') !== false) {
			return strftime($format, $ts);
		} else {
			return date($format, $ts);
		}
	}

	
	public function setId($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->id !== $v) {
			$this->id = $v;
			$this->modifiedColumns[] = sfGuardUserPeer::ID;
		}

	} 
	
	public function setUsername($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->username !== $v) {
			$this->username = $v;
			$this->modifiedColumns[] = sfGuardUserPeer::USERNAME;
		}

	} 
	
	public function setAlgorithm($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->algorithm !== $v || $v === 'sha1') {
			$this->algorithm = $v;
			$this->modifiedColumns[] = sfGuardUserPeer::ALGORITHM;
		}

	} 
	
	public function setSalt($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->salt !== $v) {
			$this->salt = $v;
			$this->modifiedColumns[] = sfGuardUserPeer::SALT;
		}

	} 
	
	public function setPassword($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->password !== $v) {
			$this->password = $v;
			$this->modifiedColumns[] = sfGuardUserPeer::PASSWORD;
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
			$this->modifiedColumns[] = sfGuardUserPeer::CREATED_AT;
		}

	} 
	
	public function setLastLogin($v)
	{

		if ($v !== null && !is_int($v)) {
			$ts = strtotime($v);
			if ($ts === -1 || $ts === false) { 				throw new PropelException("Unable to parse date/time value for [last_login] from input: " . var_export($v, true));
			}
		} else {
			$ts = $v;
		}
		if ($this->last_login !== $ts) {
			$this->last_login = $ts;
			$this->modifiedColumns[] = sfGuardUserPeer::LAST_LOGIN;
		}

	} 
	
	public function setIsActive($v)
	{

		if ($this->is_active !== $v || $v === true) {
			$this->is_active = $v;
			$this->modifiedColumns[] = sfGuardUserPeer::IS_ACTIVE;
		}

	} 
	
	public function setIsSuperAdmin($v)
	{

		if ($this->is_super_admin !== $v || $v === false) {
			$this->is_super_admin = $v;
			$this->modifiedColumns[] = sfGuardUserPeer::IS_SUPER_ADMIN;
		}

	} 
	
	public function setIsVerified($v)
	{

		if ($this->is_verified !== $v || $v === false) {
			$this->is_verified = $v;
			$this->modifiedColumns[] = sfGuardUserPeer::IS_VERIFIED;
		}

	} 
	
	public function setShowContent($v)
	{

		if ($this->show_content !== $v || $v === false) {
			$this->show_content = $v;
			$this->modifiedColumns[] = sfGuardUserPeer::SHOW_CONTENT;
		}

	} 
	
	public function setCulture($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->culture !== $v || $v === 'no') {
			$this->culture = $v;
			$this->modifiedColumns[] = sfGuardUserPeer::CULTURE;
		}

	} 
	
	public function setEmail($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->email !== $v) {
			$this->email = $v;
			$this->modifiedColumns[] = sfGuardUserPeer::EMAIL;
		}

	} 
	
	public function setEmailPrivate($v)
	{

		if ($this->email_private !== $v || $v === true) {
			$this->email_private = $v;
			$this->modifiedColumns[] = sfGuardUserPeer::EMAIL_PRIVATE;
		}

	} 
	
	public function setNewEmail($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->new_email !== $v) {
			$this->new_email = $v;
			$this->modifiedColumns[] = sfGuardUserPeer::NEW_EMAIL;
		}

	} 
	
	public function setNewEmailKey($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->new_email_key !== $v) {
			$this->new_email_key = $v;
			$this->modifiedColumns[] = sfGuardUserPeer::NEW_EMAIL_KEY;
		}

	} 
	
	public function setNewPasswordKey($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->new_password_key !== $v) {
			$this->new_password_key = $v;
			$this->modifiedColumns[] = sfGuardUserPeer::NEW_PASSWORD_KEY;
		}

	} 
	
	public function setKeyExpires($v)
	{

		if ($v !== null && !is_int($v)) {
			$ts = strtotime($v);
			if ($ts === -1 || $ts === false) { 				throw new PropelException("Unable to parse date/time value for [key_expires] from input: " . var_export($v, true));
			}
		} else {
			$ts = $v;
		}
		if ($this->key_expires !== $ts) {
			$this->key_expires = $ts;
			$this->modifiedColumns[] = sfGuardUserPeer::KEY_EXPIRES;
		}

	} 
	
	public function setName($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->name !== $v) {
			$this->name = $v;
			$this->modifiedColumns[] = sfGuardUserPeer::NAME;
		}

	} 
	
	public function setNamePrivate($v)
	{

		if ($this->name_private !== $v || $v === false) {
			$this->name_private = $v;
			$this->modifiedColumns[] = sfGuardUserPeer::NAME_PRIVATE;
		}

	} 
	
	public function setDob($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->dob !== $v) {
			$this->dob = $v;
			$this->modifiedColumns[] = sfGuardUserPeer::DOB;
		}

	} 
	
	public function setSex($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->sex !== $v) {
			$this->sex = $v;
			$this->modifiedColumns[] = sfGuardUserPeer::SEX;
		}

	} 
	
	public function setDescription($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->description !== $v) {
			$this->description = $v;
			$this->modifiedColumns[] = sfGuardUserPeer::DESCRIPTION;
		}

	} 
	
	public function setResidenceId($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->residence_id !== $v) {
			$this->residence_id = $v;
			$this->modifiedColumns[] = sfGuardUserPeer::RESIDENCE_ID;
		}

		if ($this->aResidence !== null && $this->aResidence->getId() !== $v) {
			$this->aResidence = null;
		}

	} 
	
	public function setAvatar($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->avatar !== $v) {
			$this->avatar = $v;
			$this->modifiedColumns[] = sfGuardUserPeer::AVATAR;
		}

	} 
	
	public function setMsn($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->msn !== $v) {
			$this->msn = $v;
			$this->modifiedColumns[] = sfGuardUserPeer::MSN;
		}

	} 
	
	public function setIcq($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->icq !== $v) {
			$this->icq = $v;
			$this->modifiedColumns[] = sfGuardUserPeer::ICQ;
		}

	} 
	
	public function setHomepage($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->homepage !== $v) {
			$this->homepage = $v;
			$this->modifiedColumns[] = sfGuardUserPeer::HOMEPAGE;
		}

	} 
	
	public function setPhone($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->phone !== $v) {
			$this->phone = $v;
			$this->modifiedColumns[] = sfGuardUserPeer::PHONE;
		}

	} 
	
	public function setOptIn($v)
	{

		if ($this->opt_in !== $v || $v === false) {
			$this->opt_in = $v;
			$this->modifiedColumns[] = sfGuardUserPeer::OPT_IN;
		}

	} 
	
	public function setEditorialNotification($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->editorial_notification !== $v || $v === 0) {
			$this->editorial_notification = $v;
			$this->modifiedColumns[] = sfGuardUserPeer::EDITORIAL_NOTIFICATION;
		}

	} 
	
	public function setShowLoginStatus($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->show_login_status !== $v || $v === 1) {
			$this->show_login_status = $v;
			$this->modifiedColumns[] = sfGuardUserPeer::SHOW_LOGIN_STATUS;
		}

	} 
	
	public function setLastActive($v)
	{

		if ($v !== null && !is_int($v)) {
			$ts = strtotime($v);
			if ($ts === -1 || $ts === false) { 				throw new PropelException("Unable to parse date/time value for [last_active] from input: " . var_export($v, true));
			}
		} else {
			$ts = $v;
		}
		if ($this->last_active !== $ts) {
			$this->last_active = $ts;
			$this->modifiedColumns[] = sfGuardUserPeer::LAST_ACTIVE;
		}

	} 
	
	public function setDobIsDerived($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->dob_is_derived !== $v || $v === 0) {
			$this->dob_is_derived = $v;
			$this->modifiedColumns[] = sfGuardUserPeer::DOB_IS_DERIVED;
		}

	} 
	
	public function setNeedProfileCheck($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->need_profile_check !== $v || $v === 0) {
			$this->need_profile_check = $v;
			$this->modifiedColumns[] = sfGuardUserPeer::NEED_PROFILE_CHECK;
		}

	} 
	
	public function setFirstReaktorLogin($v)
	{

		if ($v !== null && !is_int($v)) {
			$ts = strtotime($v);
			if ($ts === -1 || $ts === false) { 				throw new PropelException("Unable to parse date/time value for [first_reaktor_login] from input: " . var_export($v, true));
			}
		} else {
			$ts = $v;
		}
		if ($this->first_reaktor_login !== $ts) {
			$this->first_reaktor_login = $ts;
			$this->modifiedColumns[] = sfGuardUserPeer::FIRST_REAKTOR_LOGIN;
		}

	} 
	
	public function hydrate(ResultSet $rs, $startcol = 1)
	{
		try {

			$this->id = $rs->getInt($startcol + 0);

			$this->username = $rs->getString($startcol + 1);

			$this->algorithm = $rs->getString($startcol + 2);

			$this->salt = $rs->getString($startcol + 3);

			$this->password = $rs->getString($startcol + 4);

			$this->created_at = $rs->getTimestamp($startcol + 5, null);

			$this->last_login = $rs->getTimestamp($startcol + 6, null);

			$this->is_active = $rs->getBoolean($startcol + 7);

			$this->is_super_admin = $rs->getBoolean($startcol + 8);

			$this->is_verified = $rs->getBoolean($startcol + 9);

			$this->show_content = $rs->getBoolean($startcol + 10);

			$this->culture = $rs->getString($startcol + 11);

			$this->email = $rs->getString($startcol + 12);

			$this->email_private = $rs->getBoolean($startcol + 13);

			$this->new_email = $rs->getString($startcol + 14);

			$this->new_email_key = $rs->getString($startcol + 15);

			$this->new_password_key = $rs->getString($startcol + 16);

			$this->key_expires = $rs->getTimestamp($startcol + 17, null);

			$this->name = $rs->getString($startcol + 18);

			$this->name_private = $rs->getBoolean($startcol + 19);

			$this->dob = $rs->getString($startcol + 20);

			$this->sex = $rs->getInt($startcol + 21);

			$this->description = $rs->getString($startcol + 22);

			$this->residence_id = $rs->getInt($startcol + 23);

			$this->avatar = $rs->getString($startcol + 24);

			$this->msn = $rs->getString($startcol + 25);

			$this->icq = $rs->getInt($startcol + 26);

			$this->homepage = $rs->getString($startcol + 27);

			$this->phone = $rs->getString($startcol + 28);

			$this->opt_in = $rs->getBoolean($startcol + 29);

			$this->editorial_notification = $rs->getInt($startcol + 30);

			$this->show_login_status = $rs->getInt($startcol + 31);

			$this->last_active = $rs->getTimestamp($startcol + 32, null);

			$this->dob_is_derived = $rs->getInt($startcol + 33);

			$this->need_profile_check = $rs->getInt($startcol + 34);

			$this->first_reaktor_login = $rs->getTimestamp($startcol + 35, null);

			$this->resetModified();

			$this->setNew(false);

						return $startcol + 36; 
		} catch (Exception $e) {
			throw new PropelException("Error populating sfGuardUser object", $e);
		}
	}

	
	public function delete($con = null)
	{

    foreach (sfMixer::getCallables('BasesfGuardUser:delete:pre') as $callable)
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
			$con = Propel::getConnection(sfGuardUserPeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			sfGuardUserPeer::doDelete($this, $con);
			$this->setDeleted(true);
			$con->commit();
		} catch (PropelException $e) {
			$con->rollback();
			throw $e;
		}
	

    foreach (sfMixer::getCallables('BasesfGuardUser:delete:post') as $callable)
    {
      call_user_func($callable, $this, $con);
    }

  }
	
	public function save($con = null)
	{

    foreach (sfMixer::getCallables('BasesfGuardUser:save:pre') as $callable)
    {
      $affectedRows = call_user_func($callable, $this, $con);
      if (is_int($affectedRows))
      {
        return $affectedRows;
      }
    }


    if ($this->isNew() && !$this->isColumnModified(sfGuardUserPeer::CREATED_AT))
    {
      $this->setCreatedAt(time());
    }

		if ($this->isDeleted()) {
			throw new PropelException("You cannot save an object that has been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(sfGuardUserPeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			$affectedRows = $this->doSave($con);
			$con->commit();
    foreach (sfMixer::getCallables('BasesfGuardUser:save:post') as $callable)
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


												
			if ($this->aResidence !== null) {
				if ($this->aResidence->isModified()) {
					$affectedRows += $this->aResidence->save($con);
				}
				$this->setResidence($this->aResidence);
			}


						if ($this->isModified()) {
				if ($this->isNew()) {
					$pk = sfGuardUserPeer::doInsert($this, $con);
					$affectedRows += 1; 										 										 
					$this->setId($pk);  
					$this->setNew(false);
				} else {
					$affectedRows += sfGuardUserPeer::doUpdate($this, $con);
				}
				$this->resetModified(); 			}

			if ($this->collUserInterests !== null) {
				foreach($this->collUserInterests as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collRecommendedArtworks !== null) {
				foreach($this->collRecommendedArtworks as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collRelatedArtworks !== null) {
				foreach($this->collRelatedArtworks as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collArticles !== null) {
				foreach($this->collArticles as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collArticleArticleRelations !== null) {
				foreach($this->collArticleArticleRelations as $referrerFK) {
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

			if ($this->collArticleFiles !== null) {
				foreach($this->collArticleFiles as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collsfComments !== null) {
				foreach($this->collsfComments as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collTags !== null) {
				foreach($this->collTags as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collTaggings !== null) {
				foreach($this->collTaggings as $referrerFK) {
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

			if ($this->collFavouritesRelatedByUserId !== null) {
				foreach($this->collFavouritesRelatedByUserId as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collFavouritesRelatedByFriendId !== null) {
				foreach($this->collFavouritesRelatedByFriendId as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collsfGuardUserPermissions !== null) {
				foreach($this->collsfGuardUserPermissions as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collsfGuardUserGroups !== null) {
				foreach($this->collsfGuardUserGroups as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collsfGuardRememberKeys !== null) {
				foreach($this->collsfGuardRememberKeys as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collUserResources !== null) {
				foreach($this->collUserResources as $referrerFK) {
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

			if ($this->collMessagessRelatedByToUserId !== null) {
				foreach($this->collMessagessRelatedByToUserId as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collMessagessRelatedByFromUserId !== null) {
				foreach($this->collMessagessRelatedByFromUserId as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collMessagesIgnoredUsersRelatedByUserId !== null) {
				foreach($this->collMessagesIgnoredUsersRelatedByUserId as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collMessagesIgnoredUsersRelatedByIgnoresUserId !== null) {
				foreach($this->collMessagesIgnoredUsersRelatedByIgnoresUserId as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collAdminMessages !== null) {
				foreach($this->collAdminMessages as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collReaktorFiles !== null) {
				foreach($this->collReaktorFiles as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collReaktorArtworkHistorys !== null) {
				foreach($this->collReaktorArtworkHistorys as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collHistorys !== null) {
				foreach($this->collHistorys as $referrerFK) {
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


												
			if ($this->aResidence !== null) {
				if (!$this->aResidence->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aResidence->getValidationFailures());
				}
			}


			if (($retval = sfGuardUserPeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}


				if ($this->collUserInterests !== null) {
					foreach($this->collUserInterests as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collRecommendedArtworks !== null) {
					foreach($this->collRecommendedArtworks as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collRelatedArtworks !== null) {
					foreach($this->collRelatedArtworks as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collArticles !== null) {
					foreach($this->collArticles as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collArticleArticleRelations !== null) {
					foreach($this->collArticleArticleRelations as $referrerFK) {
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

				if ($this->collArticleFiles !== null) {
					foreach($this->collArticleFiles as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collsfComments !== null) {
					foreach($this->collsfComments as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collTags !== null) {
					foreach($this->collTags as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collTaggings !== null) {
					foreach($this->collTaggings as $referrerFK) {
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

				if ($this->collFavouritesRelatedByUserId !== null) {
					foreach($this->collFavouritesRelatedByUserId as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collFavouritesRelatedByFriendId !== null) {
					foreach($this->collFavouritesRelatedByFriendId as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collsfGuardUserPermissions !== null) {
					foreach($this->collsfGuardUserPermissions as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collsfGuardUserGroups !== null) {
					foreach($this->collsfGuardUserGroups as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collsfGuardRememberKeys !== null) {
					foreach($this->collsfGuardRememberKeys as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collUserResources !== null) {
					foreach($this->collUserResources as $referrerFK) {
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

				if ($this->collMessagessRelatedByToUserId !== null) {
					foreach($this->collMessagessRelatedByToUserId as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collMessagessRelatedByFromUserId !== null) {
					foreach($this->collMessagessRelatedByFromUserId as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collMessagesIgnoredUsersRelatedByUserId !== null) {
					foreach($this->collMessagesIgnoredUsersRelatedByUserId as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collMessagesIgnoredUsersRelatedByIgnoresUserId !== null) {
					foreach($this->collMessagesIgnoredUsersRelatedByIgnoresUserId as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collAdminMessages !== null) {
					foreach($this->collAdminMessages as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collReaktorFiles !== null) {
					foreach($this->collReaktorFiles as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collReaktorArtworkHistorys !== null) {
					foreach($this->collReaktorArtworkHistorys as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collHistorys !== null) {
					foreach($this->collHistorys as $referrerFK) {
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
		$pos = sfGuardUserPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->getByPosition($pos);
	}

	
	public function getByPosition($pos)
	{
		switch($pos) {
			case 0:
				return $this->getId();
				break;
			case 1:
				return $this->getUsername();
				break;
			case 2:
				return $this->getAlgorithm();
				break;
			case 3:
				return $this->getSalt();
				break;
			case 4:
				return $this->getPassword();
				break;
			case 5:
				return $this->getCreatedAt();
				break;
			case 6:
				return $this->getLastLogin();
				break;
			case 7:
				return $this->getIsActive();
				break;
			case 8:
				return $this->getIsSuperAdmin();
				break;
			case 9:
				return $this->getIsVerified();
				break;
			case 10:
				return $this->getShowContent();
				break;
			case 11:
				return $this->getCulture();
				break;
			case 12:
				return $this->getEmail();
				break;
			case 13:
				return $this->getEmailPrivate();
				break;
			case 14:
				return $this->getNewEmail();
				break;
			case 15:
				return $this->getNewEmailKey();
				break;
			case 16:
				return $this->getNewPasswordKey();
				break;
			case 17:
				return $this->getKeyExpires();
				break;
			case 18:
				return $this->getName();
				break;
			case 19:
				return $this->getNamePrivate();
				break;
			case 20:
				return $this->getDob();
				break;
			case 21:
				return $this->getSex();
				break;
			case 22:
				return $this->getDescription();
				break;
			case 23:
				return $this->getResidenceId();
				break;
			case 24:
				return $this->getAvatar();
				break;
			case 25:
				return $this->getMsn();
				break;
			case 26:
				return $this->getIcq();
				break;
			case 27:
				return $this->getHomepage();
				break;
			case 28:
				return $this->getPhone();
				break;
			case 29:
				return $this->getOptIn();
				break;
			case 30:
				return $this->getEditorialNotification();
				break;
			case 31:
				return $this->getShowLoginStatus();
				break;
			case 32:
				return $this->getLastActive();
				break;
			case 33:
				return $this->getDobIsDerived();
				break;
			case 34:
				return $this->getNeedProfileCheck();
				break;
			case 35:
				return $this->getFirstReaktorLogin();
				break;
			default:
				return null;
				break;
		} 	}

	
	public function toArray($keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = sfGuardUserPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getId(),
			$keys[1] => $this->getUsername(),
			$keys[2] => $this->getAlgorithm(),
			$keys[3] => $this->getSalt(),
			$keys[4] => $this->getPassword(),
			$keys[5] => $this->getCreatedAt(),
			$keys[6] => $this->getLastLogin(),
			$keys[7] => $this->getIsActive(),
			$keys[8] => $this->getIsSuperAdmin(),
			$keys[9] => $this->getIsVerified(),
			$keys[10] => $this->getShowContent(),
			$keys[11] => $this->getCulture(),
			$keys[12] => $this->getEmail(),
			$keys[13] => $this->getEmailPrivate(),
			$keys[14] => $this->getNewEmail(),
			$keys[15] => $this->getNewEmailKey(),
			$keys[16] => $this->getNewPasswordKey(),
			$keys[17] => $this->getKeyExpires(),
			$keys[18] => $this->getName(),
			$keys[19] => $this->getNamePrivate(),
			$keys[20] => $this->getDob(),
			$keys[21] => $this->getSex(),
			$keys[22] => $this->getDescription(),
			$keys[23] => $this->getResidenceId(),
			$keys[24] => $this->getAvatar(),
			$keys[25] => $this->getMsn(),
			$keys[26] => $this->getIcq(),
			$keys[27] => $this->getHomepage(),
			$keys[28] => $this->getPhone(),
			$keys[29] => $this->getOptIn(),
			$keys[30] => $this->getEditorialNotification(),
			$keys[31] => $this->getShowLoginStatus(),
			$keys[32] => $this->getLastActive(),
			$keys[33] => $this->getDobIsDerived(),
			$keys[34] => $this->getNeedProfileCheck(),
			$keys[35] => $this->getFirstReaktorLogin(),
		);
		return $result;
	}

	
	public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = sfGuardUserPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->setByPosition($pos, $value);
	}

	
	public function setByPosition($pos, $value)
	{
		switch($pos) {
			case 0:
				$this->setId($value);
				break;
			case 1:
				$this->setUsername($value);
				break;
			case 2:
				$this->setAlgorithm($value);
				break;
			case 3:
				$this->setSalt($value);
				break;
			case 4:
				$this->setPassword($value);
				break;
			case 5:
				$this->setCreatedAt($value);
				break;
			case 6:
				$this->setLastLogin($value);
				break;
			case 7:
				$this->setIsActive($value);
				break;
			case 8:
				$this->setIsSuperAdmin($value);
				break;
			case 9:
				$this->setIsVerified($value);
				break;
			case 10:
				$this->setShowContent($value);
				break;
			case 11:
				$this->setCulture($value);
				break;
			case 12:
				$this->setEmail($value);
				break;
			case 13:
				$this->setEmailPrivate($value);
				break;
			case 14:
				$this->setNewEmail($value);
				break;
			case 15:
				$this->setNewEmailKey($value);
				break;
			case 16:
				$this->setNewPasswordKey($value);
				break;
			case 17:
				$this->setKeyExpires($value);
				break;
			case 18:
				$this->setName($value);
				break;
			case 19:
				$this->setNamePrivate($value);
				break;
			case 20:
				$this->setDob($value);
				break;
			case 21:
				$this->setSex($value);
				break;
			case 22:
				$this->setDescription($value);
				break;
			case 23:
				$this->setResidenceId($value);
				break;
			case 24:
				$this->setAvatar($value);
				break;
			case 25:
				$this->setMsn($value);
				break;
			case 26:
				$this->setIcq($value);
				break;
			case 27:
				$this->setHomepage($value);
				break;
			case 28:
				$this->setPhone($value);
				break;
			case 29:
				$this->setOptIn($value);
				break;
			case 30:
				$this->setEditorialNotification($value);
				break;
			case 31:
				$this->setShowLoginStatus($value);
				break;
			case 32:
				$this->setLastActive($value);
				break;
			case 33:
				$this->setDobIsDerived($value);
				break;
			case 34:
				$this->setNeedProfileCheck($value);
				break;
			case 35:
				$this->setFirstReaktorLogin($value);
				break;
		} 	}

	
	public function fromArray($arr, $keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = sfGuardUserPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setUsername($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setAlgorithm($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setSalt($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setPassword($arr[$keys[4]]);
		if (array_key_exists($keys[5], $arr)) $this->setCreatedAt($arr[$keys[5]]);
		if (array_key_exists($keys[6], $arr)) $this->setLastLogin($arr[$keys[6]]);
		if (array_key_exists($keys[7], $arr)) $this->setIsActive($arr[$keys[7]]);
		if (array_key_exists($keys[8], $arr)) $this->setIsSuperAdmin($arr[$keys[8]]);
		if (array_key_exists($keys[9], $arr)) $this->setIsVerified($arr[$keys[9]]);
		if (array_key_exists($keys[10], $arr)) $this->setShowContent($arr[$keys[10]]);
		if (array_key_exists($keys[11], $arr)) $this->setCulture($arr[$keys[11]]);
		if (array_key_exists($keys[12], $arr)) $this->setEmail($arr[$keys[12]]);
		if (array_key_exists($keys[13], $arr)) $this->setEmailPrivate($arr[$keys[13]]);
		if (array_key_exists($keys[14], $arr)) $this->setNewEmail($arr[$keys[14]]);
		if (array_key_exists($keys[15], $arr)) $this->setNewEmailKey($arr[$keys[15]]);
		if (array_key_exists($keys[16], $arr)) $this->setNewPasswordKey($arr[$keys[16]]);
		if (array_key_exists($keys[17], $arr)) $this->setKeyExpires($arr[$keys[17]]);
		if (array_key_exists($keys[18], $arr)) $this->setName($arr[$keys[18]]);
		if (array_key_exists($keys[19], $arr)) $this->setNamePrivate($arr[$keys[19]]);
		if (array_key_exists($keys[20], $arr)) $this->setDob($arr[$keys[20]]);
		if (array_key_exists($keys[21], $arr)) $this->setSex($arr[$keys[21]]);
		if (array_key_exists($keys[22], $arr)) $this->setDescription($arr[$keys[22]]);
		if (array_key_exists($keys[23], $arr)) $this->setResidenceId($arr[$keys[23]]);
		if (array_key_exists($keys[24], $arr)) $this->setAvatar($arr[$keys[24]]);
		if (array_key_exists($keys[25], $arr)) $this->setMsn($arr[$keys[25]]);
		if (array_key_exists($keys[26], $arr)) $this->setIcq($arr[$keys[26]]);
		if (array_key_exists($keys[27], $arr)) $this->setHomepage($arr[$keys[27]]);
		if (array_key_exists($keys[28], $arr)) $this->setPhone($arr[$keys[28]]);
		if (array_key_exists($keys[29], $arr)) $this->setOptIn($arr[$keys[29]]);
		if (array_key_exists($keys[30], $arr)) $this->setEditorialNotification($arr[$keys[30]]);
		if (array_key_exists($keys[31], $arr)) $this->setShowLoginStatus($arr[$keys[31]]);
		if (array_key_exists($keys[32], $arr)) $this->setLastActive($arr[$keys[32]]);
		if (array_key_exists($keys[33], $arr)) $this->setDobIsDerived($arr[$keys[33]]);
		if (array_key_exists($keys[34], $arr)) $this->setNeedProfileCheck($arr[$keys[34]]);
		if (array_key_exists($keys[35], $arr)) $this->setFirstReaktorLogin($arr[$keys[35]]);
	}

	
	public function buildCriteria()
	{
		$criteria = new Criteria(sfGuardUserPeer::DATABASE_NAME);

		if ($this->isColumnModified(sfGuardUserPeer::ID)) $criteria->add(sfGuardUserPeer::ID, $this->id);
		if ($this->isColumnModified(sfGuardUserPeer::USERNAME)) $criteria->add(sfGuardUserPeer::USERNAME, $this->username);
		if ($this->isColumnModified(sfGuardUserPeer::ALGORITHM)) $criteria->add(sfGuardUserPeer::ALGORITHM, $this->algorithm);
		if ($this->isColumnModified(sfGuardUserPeer::SALT)) $criteria->add(sfGuardUserPeer::SALT, $this->salt);
		if ($this->isColumnModified(sfGuardUserPeer::PASSWORD)) $criteria->add(sfGuardUserPeer::PASSWORD, $this->password);
		if ($this->isColumnModified(sfGuardUserPeer::CREATED_AT)) $criteria->add(sfGuardUserPeer::CREATED_AT, $this->created_at);
		if ($this->isColumnModified(sfGuardUserPeer::LAST_LOGIN)) $criteria->add(sfGuardUserPeer::LAST_LOGIN, $this->last_login);
		if ($this->isColumnModified(sfGuardUserPeer::IS_ACTIVE)) $criteria->add(sfGuardUserPeer::IS_ACTIVE, $this->is_active);
		if ($this->isColumnModified(sfGuardUserPeer::IS_SUPER_ADMIN)) $criteria->add(sfGuardUserPeer::IS_SUPER_ADMIN, $this->is_super_admin);
		if ($this->isColumnModified(sfGuardUserPeer::IS_VERIFIED)) $criteria->add(sfGuardUserPeer::IS_VERIFIED, $this->is_verified);
		if ($this->isColumnModified(sfGuardUserPeer::SHOW_CONTENT)) $criteria->add(sfGuardUserPeer::SHOW_CONTENT, $this->show_content);
		if ($this->isColumnModified(sfGuardUserPeer::CULTURE)) $criteria->add(sfGuardUserPeer::CULTURE, $this->culture);
		if ($this->isColumnModified(sfGuardUserPeer::EMAIL)) $criteria->add(sfGuardUserPeer::EMAIL, $this->email);
		if ($this->isColumnModified(sfGuardUserPeer::EMAIL_PRIVATE)) $criteria->add(sfGuardUserPeer::EMAIL_PRIVATE, $this->email_private);
		if ($this->isColumnModified(sfGuardUserPeer::NEW_EMAIL)) $criteria->add(sfGuardUserPeer::NEW_EMAIL, $this->new_email);
		if ($this->isColumnModified(sfGuardUserPeer::NEW_EMAIL_KEY)) $criteria->add(sfGuardUserPeer::NEW_EMAIL_KEY, $this->new_email_key);
		if ($this->isColumnModified(sfGuardUserPeer::NEW_PASSWORD_KEY)) $criteria->add(sfGuardUserPeer::NEW_PASSWORD_KEY, $this->new_password_key);
		if ($this->isColumnModified(sfGuardUserPeer::KEY_EXPIRES)) $criteria->add(sfGuardUserPeer::KEY_EXPIRES, $this->key_expires);
		if ($this->isColumnModified(sfGuardUserPeer::NAME)) $criteria->add(sfGuardUserPeer::NAME, $this->name);
		if ($this->isColumnModified(sfGuardUserPeer::NAME_PRIVATE)) $criteria->add(sfGuardUserPeer::NAME_PRIVATE, $this->name_private);
		if ($this->isColumnModified(sfGuardUserPeer::DOB)) $criteria->add(sfGuardUserPeer::DOB, $this->dob);
		if ($this->isColumnModified(sfGuardUserPeer::SEX)) $criteria->add(sfGuardUserPeer::SEX, $this->sex);
		if ($this->isColumnModified(sfGuardUserPeer::DESCRIPTION)) $criteria->add(sfGuardUserPeer::DESCRIPTION, $this->description);
		if ($this->isColumnModified(sfGuardUserPeer::RESIDENCE_ID)) $criteria->add(sfGuardUserPeer::RESIDENCE_ID, $this->residence_id);
		if ($this->isColumnModified(sfGuardUserPeer::AVATAR)) $criteria->add(sfGuardUserPeer::AVATAR, $this->avatar);
		if ($this->isColumnModified(sfGuardUserPeer::MSN)) $criteria->add(sfGuardUserPeer::MSN, $this->msn);
		if ($this->isColumnModified(sfGuardUserPeer::ICQ)) $criteria->add(sfGuardUserPeer::ICQ, $this->icq);
		if ($this->isColumnModified(sfGuardUserPeer::HOMEPAGE)) $criteria->add(sfGuardUserPeer::HOMEPAGE, $this->homepage);
		if ($this->isColumnModified(sfGuardUserPeer::PHONE)) $criteria->add(sfGuardUserPeer::PHONE, $this->phone);
		if ($this->isColumnModified(sfGuardUserPeer::OPT_IN)) $criteria->add(sfGuardUserPeer::OPT_IN, $this->opt_in);
		if ($this->isColumnModified(sfGuardUserPeer::EDITORIAL_NOTIFICATION)) $criteria->add(sfGuardUserPeer::EDITORIAL_NOTIFICATION, $this->editorial_notification);
		if ($this->isColumnModified(sfGuardUserPeer::SHOW_LOGIN_STATUS)) $criteria->add(sfGuardUserPeer::SHOW_LOGIN_STATUS, $this->show_login_status);
		if ($this->isColumnModified(sfGuardUserPeer::LAST_ACTIVE)) $criteria->add(sfGuardUserPeer::LAST_ACTIVE, $this->last_active);
		if ($this->isColumnModified(sfGuardUserPeer::DOB_IS_DERIVED)) $criteria->add(sfGuardUserPeer::DOB_IS_DERIVED, $this->dob_is_derived);
		if ($this->isColumnModified(sfGuardUserPeer::NEED_PROFILE_CHECK)) $criteria->add(sfGuardUserPeer::NEED_PROFILE_CHECK, $this->need_profile_check);
		if ($this->isColumnModified(sfGuardUserPeer::FIRST_REAKTOR_LOGIN)) $criteria->add(sfGuardUserPeer::FIRST_REAKTOR_LOGIN, $this->first_reaktor_login);

		return $criteria;
	}

	
	public function buildPkeyCriteria()
	{
		$criteria = new Criteria(sfGuardUserPeer::DATABASE_NAME);

		$criteria->add(sfGuardUserPeer::ID, $this->id);

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

		$copyObj->setUsername($this->username);

		$copyObj->setAlgorithm($this->algorithm);

		$copyObj->setSalt($this->salt);

		$copyObj->setPassword($this->password);

		$copyObj->setCreatedAt($this->created_at);

		$copyObj->setLastLogin($this->last_login);

		$copyObj->setIsActive($this->is_active);

		$copyObj->setIsSuperAdmin($this->is_super_admin);

		$copyObj->setIsVerified($this->is_verified);

		$copyObj->setShowContent($this->show_content);

		$copyObj->setCulture($this->culture);

		$copyObj->setEmail($this->email);

		$copyObj->setEmailPrivate($this->email_private);

		$copyObj->setNewEmail($this->new_email);

		$copyObj->setNewEmailKey($this->new_email_key);

		$copyObj->setNewPasswordKey($this->new_password_key);

		$copyObj->setKeyExpires($this->key_expires);

		$copyObj->setName($this->name);

		$copyObj->setNamePrivate($this->name_private);

		$copyObj->setDob($this->dob);

		$copyObj->setSex($this->sex);

		$copyObj->setDescription($this->description);

		$copyObj->setResidenceId($this->residence_id);

		$copyObj->setAvatar($this->avatar);

		$copyObj->setMsn($this->msn);

		$copyObj->setIcq($this->icq);

		$copyObj->setHomepage($this->homepage);

		$copyObj->setPhone($this->phone);

		$copyObj->setOptIn($this->opt_in);

		$copyObj->setEditorialNotification($this->editorial_notification);

		$copyObj->setShowLoginStatus($this->show_login_status);

		$copyObj->setLastActive($this->last_active);

		$copyObj->setDobIsDerived($this->dob_is_derived);

		$copyObj->setNeedProfileCheck($this->need_profile_check);

		$copyObj->setFirstReaktorLogin($this->first_reaktor_login);


		if ($deepCopy) {
									$copyObj->setNew(false);

			foreach($this->getUserInterests() as $relObj) {
				$copyObj->addUserInterest($relObj->copy($deepCopy));
			}

			foreach($this->getRecommendedArtworks() as $relObj) {
				$copyObj->addRecommendedArtwork($relObj->copy($deepCopy));
			}

			foreach($this->getRelatedArtworks() as $relObj) {
				$copyObj->addRelatedArtwork($relObj->copy($deepCopy));
			}

			foreach($this->getArticles() as $relObj) {
				$copyObj->addArticle($relObj->copy($deepCopy));
			}

			foreach($this->getArticleArticleRelations() as $relObj) {
				$copyObj->addArticleArticleRelation($relObj->copy($deepCopy));
			}

			foreach($this->getArticleArtworkRelations() as $relObj) {
				$copyObj->addArticleArtworkRelation($relObj->copy($deepCopy));
			}

			foreach($this->getArticleFiles() as $relObj) {
				$copyObj->addArticleFile($relObj->copy($deepCopy));
			}

			foreach($this->getsfComments() as $relObj) {
				$copyObj->addsfComment($relObj->copy($deepCopy));
			}

			foreach($this->getTags() as $relObj) {
				$copyObj->addTag($relObj->copy($deepCopy));
			}

			foreach($this->getTaggings() as $relObj) {
				$copyObj->addTagging($relObj->copy($deepCopy));
			}

			foreach($this->getReaktorArtworks() as $relObj) {
				$copyObj->addReaktorArtwork($relObj->copy($deepCopy));
			}

			foreach($this->getFavouritesRelatedByUserId() as $relObj) {
				$copyObj->addFavouriteRelatedByUserId($relObj->copy($deepCopy));
			}

			foreach($this->getFavouritesRelatedByFriendId() as $relObj) {
				$copyObj->addFavouriteRelatedByFriendId($relObj->copy($deepCopy));
			}

			foreach($this->getsfGuardUserPermissions() as $relObj) {
				$copyObj->addsfGuardUserPermission($relObj->copy($deepCopy));
			}

			foreach($this->getsfGuardUserGroups() as $relObj) {
				$copyObj->addsfGuardUserGroup($relObj->copy($deepCopy));
			}

			foreach($this->getsfGuardRememberKeys() as $relObj) {
				$copyObj->addsfGuardRememberKey($relObj->copy($deepCopy));
			}

			foreach($this->getUserResources() as $relObj) {
				$copyObj->addUserResource($relObj->copy($deepCopy));
			}

			foreach($this->getCategoryArtworks() as $relObj) {
				$copyObj->addCategoryArtwork($relObj->copy($deepCopy));
			}

			foreach($this->getMessagessRelatedByToUserId() as $relObj) {
				$copyObj->addMessagesRelatedByToUserId($relObj->copy($deepCopy));
			}

			foreach($this->getMessagessRelatedByFromUserId() as $relObj) {
				$copyObj->addMessagesRelatedByFromUserId($relObj->copy($deepCopy));
			}

			foreach($this->getMessagesIgnoredUsersRelatedByUserId() as $relObj) {
				$copyObj->addMessagesIgnoredUserRelatedByUserId($relObj->copy($deepCopy));
			}

			foreach($this->getMessagesIgnoredUsersRelatedByIgnoresUserId() as $relObj) {
				$copyObj->addMessagesIgnoredUserRelatedByIgnoresUserId($relObj->copy($deepCopy));
			}

			foreach($this->getAdminMessages() as $relObj) {
				$copyObj->addAdminMessage($relObj->copy($deepCopy));
			}

			foreach($this->getReaktorFiles() as $relObj) {
				$copyObj->addReaktorFile($relObj->copy($deepCopy));
			}

			foreach($this->getReaktorArtworkHistorys() as $relObj) {
				$copyObj->addReaktorArtworkHistory($relObj->copy($deepCopy));
			}

			foreach($this->getHistorys() as $relObj) {
				$copyObj->addHistory($relObj->copy($deepCopy));
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
			self::$peer = new sfGuardUserPeer();
		}
		return self::$peer;
	}

	
	public function setResidence($v)
	{


		if ($v === null) {
			$this->setResidenceId(NULL);
		} else {
			$this->setResidenceId($v->getId());
		}


		$this->aResidence = $v;
	}


	
	public function getResidence($con = null)
	{
		if ($this->aResidence === null && ($this->residence_id !== null)) {
						include_once 'lib/model/om/BaseResidencePeer.php';

			$this->aResidence = ResidencePeer::retrieveByPK($this->residence_id, $con);

			
		}
		return $this->aResidence;
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

				$criteria->add(UserInterestPeer::USER_ID, $this->getId());

				UserInterestPeer::addSelectColumns($criteria);
				$this->collUserInterests = UserInterestPeer::doSelect($criteria, $con);
			}
		} else {
						if (!$this->isNew()) {
												

				$criteria->add(UserInterestPeer::USER_ID, $this->getId());

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

		$criteria->add(UserInterestPeer::USER_ID, $this->getId());

		return UserInterestPeer::doCount($criteria, $distinct, $con);
	}

	
	public function addUserInterest(UserInterest $l)
	{
		$this->collUserInterests[] = $l;
		$l->setsfGuardUser($this);
	}


	
	public function getUserInterestsJoinSubreaktor($criteria = null, $con = null)
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

				$criteria->add(UserInterestPeer::USER_ID, $this->getId());

				$this->collUserInterests = UserInterestPeer::doSelectJoinSubreaktor($criteria, $con);
			}
		} else {
									
			$criteria->add(UserInterestPeer::USER_ID, $this->getId());

			if (!isset($this->lastUserInterestCriteria) || !$this->lastUserInterestCriteria->equals($criteria)) {
				$this->collUserInterests = UserInterestPeer::doSelectJoinSubreaktor($criteria, $con);
			}
		}
		$this->lastUserInterestCriteria = $criteria;

		return $this->collUserInterests;
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

				$criteria->add(RecommendedArtworkPeer::UPDATED_BY, $this->getId());

				RecommendedArtworkPeer::addSelectColumns($criteria);
				$this->collRecommendedArtworks = RecommendedArtworkPeer::doSelect($criteria, $con);
			}
		} else {
						if (!$this->isNew()) {
												

				$criteria->add(RecommendedArtworkPeer::UPDATED_BY, $this->getId());

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

		$criteria->add(RecommendedArtworkPeer::UPDATED_BY, $this->getId());

		return RecommendedArtworkPeer::doCount($criteria, $distinct, $con);
	}

	
	public function addRecommendedArtwork(RecommendedArtwork $l)
	{
		$this->collRecommendedArtworks[] = $l;
		$l->setsfGuardUser($this);
	}


	
	public function getRecommendedArtworksJoinReaktorArtwork($criteria = null, $con = null)
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

				$criteria->add(RecommendedArtworkPeer::UPDATED_BY, $this->getId());

				$this->collRecommendedArtworks = RecommendedArtworkPeer::doSelectJoinReaktorArtwork($criteria, $con);
			}
		} else {
									
			$criteria->add(RecommendedArtworkPeer::UPDATED_BY, $this->getId());

			if (!isset($this->lastRecommendedArtworkCriteria) || !$this->lastRecommendedArtworkCriteria->equals($criteria)) {
				$this->collRecommendedArtworks = RecommendedArtworkPeer::doSelectJoinReaktorArtwork($criteria, $con);
			}
		}
		$this->lastRecommendedArtworkCriteria = $criteria;

		return $this->collRecommendedArtworks;
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

				$criteria->add(RecommendedArtworkPeer::UPDATED_BY, $this->getId());

				$this->collRecommendedArtworks = RecommendedArtworkPeer::doSelectJoinSubreaktorRelatedBySubreaktor($criteria, $con);
			}
		} else {
									
			$criteria->add(RecommendedArtworkPeer::UPDATED_BY, $this->getId());

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

				$criteria->add(RecommendedArtworkPeer::UPDATED_BY, $this->getId());

				$this->collRecommendedArtworks = RecommendedArtworkPeer::doSelectJoinSubreaktorRelatedByLocalsubreaktor($criteria, $con);
			}
		} else {
									
			$criteria->add(RecommendedArtworkPeer::UPDATED_BY, $this->getId());

			if (!isset($this->lastRecommendedArtworkCriteria) || !$this->lastRecommendedArtworkCriteria->equals($criteria)) {
				$this->collRecommendedArtworks = RecommendedArtworkPeer::doSelectJoinSubreaktorRelatedByLocalsubreaktor($criteria, $con);
			}
		}
		$this->lastRecommendedArtworkCriteria = $criteria;

		return $this->collRecommendedArtworks;
	}

	
	public function initRelatedArtworks()
	{
		if ($this->collRelatedArtworks === null) {
			$this->collRelatedArtworks = array();
		}
	}

	
	public function getRelatedArtworks($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseRelatedArtworkPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collRelatedArtworks === null) {
			if ($this->isNew()) {
			   $this->collRelatedArtworks = array();
			} else {

				$criteria->add(RelatedArtworkPeer::CREATED_BY, $this->getId());

				RelatedArtworkPeer::addSelectColumns($criteria);
				$this->collRelatedArtworks = RelatedArtworkPeer::doSelect($criteria, $con);
			}
		} else {
						if (!$this->isNew()) {
												

				$criteria->add(RelatedArtworkPeer::CREATED_BY, $this->getId());

				RelatedArtworkPeer::addSelectColumns($criteria);
				if (!isset($this->lastRelatedArtworkCriteria) || !$this->lastRelatedArtworkCriteria->equals($criteria)) {
					$this->collRelatedArtworks = RelatedArtworkPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastRelatedArtworkCriteria = $criteria;
		return $this->collRelatedArtworks;
	}

	
	public function countRelatedArtworks($criteria = null, $distinct = false, $con = null)
	{
				include_once 'lib/model/om/BaseRelatedArtworkPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(RelatedArtworkPeer::CREATED_BY, $this->getId());

		return RelatedArtworkPeer::doCount($criteria, $distinct, $con);
	}

	
	public function addRelatedArtwork(RelatedArtwork $l)
	{
		$this->collRelatedArtworks[] = $l;
		$l->setsfGuardUser($this);
	}


	
	public function getRelatedArtworksJoinReaktorArtworkRelatedByFirstArtwork($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseRelatedArtworkPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collRelatedArtworks === null) {
			if ($this->isNew()) {
				$this->collRelatedArtworks = array();
			} else {

				$criteria->add(RelatedArtworkPeer::CREATED_BY, $this->getId());

				$this->collRelatedArtworks = RelatedArtworkPeer::doSelectJoinReaktorArtworkRelatedByFirstArtwork($criteria, $con);
			}
		} else {
									
			$criteria->add(RelatedArtworkPeer::CREATED_BY, $this->getId());

			if (!isset($this->lastRelatedArtworkCriteria) || !$this->lastRelatedArtworkCriteria->equals($criteria)) {
				$this->collRelatedArtworks = RelatedArtworkPeer::doSelectJoinReaktorArtworkRelatedByFirstArtwork($criteria, $con);
			}
		}
		$this->lastRelatedArtworkCriteria = $criteria;

		return $this->collRelatedArtworks;
	}


	
	public function getRelatedArtworksJoinReaktorArtworkRelatedBySecondArtwork($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseRelatedArtworkPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collRelatedArtworks === null) {
			if ($this->isNew()) {
				$this->collRelatedArtworks = array();
			} else {

				$criteria->add(RelatedArtworkPeer::CREATED_BY, $this->getId());

				$this->collRelatedArtworks = RelatedArtworkPeer::doSelectJoinReaktorArtworkRelatedBySecondArtwork($criteria, $con);
			}
		} else {
									
			$criteria->add(RelatedArtworkPeer::CREATED_BY, $this->getId());

			if (!isset($this->lastRelatedArtworkCriteria) || !$this->lastRelatedArtworkCriteria->equals($criteria)) {
				$this->collRelatedArtworks = RelatedArtworkPeer::doSelectJoinReaktorArtworkRelatedBySecondArtwork($criteria, $con);
			}
		}
		$this->lastRelatedArtworkCriteria = $criteria;

		return $this->collRelatedArtworks;
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

				$criteria->add(ArticlePeer::AUTHOR_ID, $this->getId());

				ArticlePeer::addSelectColumns($criteria);
				$this->collArticles = ArticlePeer::doSelect($criteria, $con);
			}
		} else {
						if (!$this->isNew()) {
												

				$criteria->add(ArticlePeer::AUTHOR_ID, $this->getId());

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

		$criteria->add(ArticlePeer::AUTHOR_ID, $this->getId());

		return ArticlePeer::doCount($criteria, $distinct, $con);
	}

	
	public function addArticle(Article $l)
	{
		$this->collArticles[] = $l;
		$l->setsfGuardUser($this);
	}


	
	public function getArticlesJoinArticleFile($criteria = null, $con = null)
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

				$criteria->add(ArticlePeer::AUTHOR_ID, $this->getId());

				$this->collArticles = ArticlePeer::doSelectJoinArticleFile($criteria, $con);
			}
		} else {
									
			$criteria->add(ArticlePeer::AUTHOR_ID, $this->getId());

			if (!isset($this->lastArticleCriteria) || !$this->lastArticleCriteria->equals($criteria)) {
				$this->collArticles = ArticlePeer::doSelectJoinArticleFile($criteria, $con);
			}
		}
		$this->lastArticleCriteria = $criteria;

		return $this->collArticles;
	}

	
	public function initArticleArticleRelations()
	{
		if ($this->collArticleArticleRelations === null) {
			$this->collArticleArticleRelations = array();
		}
	}

	
	public function getArticleArticleRelations($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseArticleArticleRelationPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collArticleArticleRelations === null) {
			if ($this->isNew()) {
			   $this->collArticleArticleRelations = array();
			} else {

				$criteria->add(ArticleArticleRelationPeer::CREATED_BY, $this->getId());

				ArticleArticleRelationPeer::addSelectColumns($criteria);
				$this->collArticleArticleRelations = ArticleArticleRelationPeer::doSelect($criteria, $con);
			}
		} else {
						if (!$this->isNew()) {
												

				$criteria->add(ArticleArticleRelationPeer::CREATED_BY, $this->getId());

				ArticleArticleRelationPeer::addSelectColumns($criteria);
				if (!isset($this->lastArticleArticleRelationCriteria) || !$this->lastArticleArticleRelationCriteria->equals($criteria)) {
					$this->collArticleArticleRelations = ArticleArticleRelationPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastArticleArticleRelationCriteria = $criteria;
		return $this->collArticleArticleRelations;
	}

	
	public function countArticleArticleRelations($criteria = null, $distinct = false, $con = null)
	{
				include_once 'lib/model/om/BaseArticleArticleRelationPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(ArticleArticleRelationPeer::CREATED_BY, $this->getId());

		return ArticleArticleRelationPeer::doCount($criteria, $distinct, $con);
	}

	
	public function addArticleArticleRelation(ArticleArticleRelation $l)
	{
		$this->collArticleArticleRelations[] = $l;
		$l->setsfGuardUser($this);
	}


	
	public function getArticleArticleRelationsJoinArticleRelatedByFirstArticle($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseArticleArticleRelationPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collArticleArticleRelations === null) {
			if ($this->isNew()) {
				$this->collArticleArticleRelations = array();
			} else {

				$criteria->add(ArticleArticleRelationPeer::CREATED_BY, $this->getId());

				$this->collArticleArticleRelations = ArticleArticleRelationPeer::doSelectJoinArticleRelatedByFirstArticle($criteria, $con);
			}
		} else {
									
			$criteria->add(ArticleArticleRelationPeer::CREATED_BY, $this->getId());

			if (!isset($this->lastArticleArticleRelationCriteria) || !$this->lastArticleArticleRelationCriteria->equals($criteria)) {
				$this->collArticleArticleRelations = ArticleArticleRelationPeer::doSelectJoinArticleRelatedByFirstArticle($criteria, $con);
			}
		}
		$this->lastArticleArticleRelationCriteria = $criteria;

		return $this->collArticleArticleRelations;
	}


	
	public function getArticleArticleRelationsJoinArticleRelatedBySecondArticle($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseArticleArticleRelationPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collArticleArticleRelations === null) {
			if ($this->isNew()) {
				$this->collArticleArticleRelations = array();
			} else {

				$criteria->add(ArticleArticleRelationPeer::CREATED_BY, $this->getId());

				$this->collArticleArticleRelations = ArticleArticleRelationPeer::doSelectJoinArticleRelatedBySecondArticle($criteria, $con);
			}
		} else {
									
			$criteria->add(ArticleArticleRelationPeer::CREATED_BY, $this->getId());

			if (!isset($this->lastArticleArticleRelationCriteria) || !$this->lastArticleArticleRelationCriteria->equals($criteria)) {
				$this->collArticleArticleRelations = ArticleArticleRelationPeer::doSelectJoinArticleRelatedBySecondArticle($criteria, $con);
			}
		}
		$this->lastArticleArticleRelationCriteria = $criteria;

		return $this->collArticleArticleRelations;
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

				$criteria->add(ArticleArtworkRelationPeer::CREATED_BY, $this->getId());

				ArticleArtworkRelationPeer::addSelectColumns($criteria);
				$this->collArticleArtworkRelations = ArticleArtworkRelationPeer::doSelect($criteria, $con);
			}
		} else {
						if (!$this->isNew()) {
												

				$criteria->add(ArticleArtworkRelationPeer::CREATED_BY, $this->getId());

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

		$criteria->add(ArticleArtworkRelationPeer::CREATED_BY, $this->getId());

		return ArticleArtworkRelationPeer::doCount($criteria, $distinct, $con);
	}

	
	public function addArticleArtworkRelation(ArticleArtworkRelation $l)
	{
		$this->collArticleArtworkRelations[] = $l;
		$l->setsfGuardUser($this);
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

				$criteria->add(ArticleArtworkRelationPeer::CREATED_BY, $this->getId());

				$this->collArticleArtworkRelations = ArticleArtworkRelationPeer::doSelectJoinArticle($criteria, $con);
			}
		} else {
									
			$criteria->add(ArticleArtworkRelationPeer::CREATED_BY, $this->getId());

			if (!isset($this->lastArticleArtworkRelationCriteria) || !$this->lastArticleArtworkRelationCriteria->equals($criteria)) {
				$this->collArticleArtworkRelations = ArticleArtworkRelationPeer::doSelectJoinArticle($criteria, $con);
			}
		}
		$this->lastArticleArtworkRelationCriteria = $criteria;

		return $this->collArticleArtworkRelations;
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

				$criteria->add(ArticleArtworkRelationPeer::CREATED_BY, $this->getId());

				$this->collArticleArtworkRelations = ArticleArtworkRelationPeer::doSelectJoinReaktorArtwork($criteria, $con);
			}
		} else {
									
			$criteria->add(ArticleArtworkRelationPeer::CREATED_BY, $this->getId());

			if (!isset($this->lastArticleArtworkRelationCriteria) || !$this->lastArticleArtworkRelationCriteria->equals($criteria)) {
				$this->collArticleArtworkRelations = ArticleArtworkRelationPeer::doSelectJoinReaktorArtwork($criteria, $con);
			}
		}
		$this->lastArticleArtworkRelationCriteria = $criteria;

		return $this->collArticleArtworkRelations;
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

				$criteria->add(ArticleFilePeer::UPLOADED_BY, $this->getId());

				ArticleFilePeer::addSelectColumns($criteria);
				$this->collArticleFiles = ArticleFilePeer::doSelect($criteria, $con);
			}
		} else {
						if (!$this->isNew()) {
												

				$criteria->add(ArticleFilePeer::UPLOADED_BY, $this->getId());

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

		$criteria->add(ArticleFilePeer::UPLOADED_BY, $this->getId());

		return ArticleFilePeer::doCount($criteria, $distinct, $con);
	}

	
	public function addArticleFile(ArticleFile $l)
	{
		$this->collArticleFiles[] = $l;
		$l->setsfGuardUser($this);
	}


	
	public function getArticleFilesJoinFileMimetype($criteria = null, $con = null)
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

				$criteria->add(ArticleFilePeer::UPLOADED_BY, $this->getId());

				$this->collArticleFiles = ArticleFilePeer::doSelectJoinFileMimetype($criteria, $con);
			}
		} else {
									
			$criteria->add(ArticleFilePeer::UPLOADED_BY, $this->getId());

			if (!isset($this->lastArticleFileCriteria) || !$this->lastArticleFileCriteria->equals($criteria)) {
				$this->collArticleFiles = ArticleFilePeer::doSelectJoinFileMimetype($criteria, $con);
			}
		}
		$this->lastArticleFileCriteria = $criteria;

		return $this->collArticleFiles;
	}

	
	public function initsfComments()
	{
		if ($this->collsfComments === null) {
			$this->collsfComments = array();
		}
	}

	
	public function getsfComments($criteria = null, $con = null)
	{
				include_once 'plugins/sfPropelActAsCommentableBehaviorPlugin/lib/model/om/BasesfCommentPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collsfComments === null) {
			if ($this->isNew()) {
			   $this->collsfComments = array();
			} else {

				$criteria->add(sfCommentPeer::AUTHOR_ID, $this->getId());

				sfCommentPeer::addSelectColumns($criteria);
				$this->collsfComments = sfCommentPeer::doSelect($criteria, $con);
			}
		} else {
						if (!$this->isNew()) {
												

				$criteria->add(sfCommentPeer::AUTHOR_ID, $this->getId());

				sfCommentPeer::addSelectColumns($criteria);
				if (!isset($this->lastsfCommentCriteria) || !$this->lastsfCommentCriteria->equals($criteria)) {
					$this->collsfComments = sfCommentPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastsfCommentCriteria = $criteria;
		return $this->collsfComments;
	}

	
	public function countsfComments($criteria = null, $distinct = false, $con = null)
	{
				include_once 'plugins/sfPropelActAsCommentableBehaviorPlugin/lib/model/om/BasesfCommentPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(sfCommentPeer::AUTHOR_ID, $this->getId());

		return sfCommentPeer::doCount($criteria, $distinct, $con);
	}

	
	public function addsfComment(sfComment $l)
	{
		$this->collsfComments[] = $l;
		$l->setsfGuardUser($this);
	}

	
	public function initTags()
	{
		if ($this->collTags === null) {
			$this->collTags = array();
		}
	}

	
	public function getTags($criteria = null, $con = null)
	{
				include_once 'plugins/sfPropelActAsTaggableBehaviorPlugin/lib/model/om/BaseTagPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collTags === null) {
			if ($this->isNew()) {
			   $this->collTags = array();
			} else {

				$criteria->add(TagPeer::APPROVED_BY, $this->getId());

				TagPeer::addSelectColumns($criteria);
				$this->collTags = TagPeer::doSelect($criteria, $con);
			}
		} else {
						if (!$this->isNew()) {
												

				$criteria->add(TagPeer::APPROVED_BY, $this->getId());

				TagPeer::addSelectColumns($criteria);
				if (!isset($this->lastTagCriteria) || !$this->lastTagCriteria->equals($criteria)) {
					$this->collTags = TagPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastTagCriteria = $criteria;
		return $this->collTags;
	}

	
	public function countTags($criteria = null, $distinct = false, $con = null)
	{
				include_once 'plugins/sfPropelActAsTaggableBehaviorPlugin/lib/model/om/BaseTagPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(TagPeer::APPROVED_BY, $this->getId());

		return TagPeer::doCount($criteria, $distinct, $con);
	}

	
	public function addTag(Tag $l)
	{
		$this->collTags[] = $l;
		$l->setsfGuardUser($this);
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

				$criteria->add(TaggingPeer::PARENT_USER_ID, $this->getId());

				TaggingPeer::addSelectColumns($criteria);
				$this->collTaggings = TaggingPeer::doSelect($criteria, $con);
			}
		} else {
						if (!$this->isNew()) {
												

				$criteria->add(TaggingPeer::PARENT_USER_ID, $this->getId());

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

		$criteria->add(TaggingPeer::PARENT_USER_ID, $this->getId());

		return TaggingPeer::doCount($criteria, $distinct, $con);
	}

	
	public function addTagging(Tagging $l)
	{
		$this->collTaggings[] = $l;
		$l->setsfGuardUser($this);
	}


	
	public function getTaggingsJoinTag($criteria = null, $con = null)
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

				$criteria->add(TaggingPeer::PARENT_USER_ID, $this->getId());

				$this->collTaggings = TaggingPeer::doSelectJoinTag($criteria, $con);
			}
		} else {
									
			$criteria->add(TaggingPeer::PARENT_USER_ID, $this->getId());

			if (!isset($this->lastTaggingCriteria) || !$this->lastTaggingCriteria->equals($criteria)) {
				$this->collTaggings = TaggingPeer::doSelectJoinTag($criteria, $con);
			}
		}
		$this->lastTaggingCriteria = $criteria;

		return $this->collTaggings;
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

				$criteria->add(ReaktorArtworkPeer::USER_ID, $this->getId());

				ReaktorArtworkPeer::addSelectColumns($criteria);
				$this->collReaktorArtworks = ReaktorArtworkPeer::doSelect($criteria, $con);
			}
		} else {
						if (!$this->isNew()) {
												

				$criteria->add(ReaktorArtworkPeer::USER_ID, $this->getId());

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

		$criteria->add(ReaktorArtworkPeer::USER_ID, $this->getId());

		return ReaktorArtworkPeer::doCount($criteria, $distinct, $con);
	}

	
	public function addReaktorArtwork(ReaktorArtwork $l)
	{
		$this->collReaktorArtworks[] = $l;
		$l->setsfGuardUser($this);
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

				$criteria->add(ReaktorArtworkPeer::USER_ID, $this->getId());

				$this->collReaktorArtworks = ReaktorArtworkPeer::doSelectJoinArtworkStatus($criteria, $con);
			}
		} else {
									
			$criteria->add(ReaktorArtworkPeer::USER_ID, $this->getId());

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

				$criteria->add(ReaktorArtworkPeer::USER_ID, $this->getId());

				$this->collReaktorArtworks = ReaktorArtworkPeer::doSelectJoinsfGuardGroup($criteria, $con);
			}
		} else {
									
			$criteria->add(ReaktorArtworkPeer::USER_ID, $this->getId());

			if (!isset($this->lastReaktorArtworkCriteria) || !$this->lastReaktorArtworkCriteria->equals($criteria)) {
				$this->collReaktorArtworks = ReaktorArtworkPeer::doSelectJoinsfGuardGroup($criteria, $con);
			}
		}
		$this->lastReaktorArtworkCriteria = $criteria;

		return $this->collReaktorArtworks;
	}


	
	public function getReaktorArtworksJoinReaktorFile($criteria = null, $con = null)
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

				$criteria->add(ReaktorArtworkPeer::USER_ID, $this->getId());

				$this->collReaktorArtworks = ReaktorArtworkPeer::doSelectJoinReaktorFile($criteria, $con);
			}
		} else {
									
			$criteria->add(ReaktorArtworkPeer::USER_ID, $this->getId());

			if (!isset($this->lastReaktorArtworkCriteria) || !$this->lastReaktorArtworkCriteria->equals($criteria)) {
				$this->collReaktorArtworks = ReaktorArtworkPeer::doSelectJoinReaktorFile($criteria, $con);
			}
		}
		$this->lastReaktorArtworkCriteria = $criteria;

		return $this->collReaktorArtworks;
	}

	
	public function initFavouritesRelatedByUserId()
	{
		if ($this->collFavouritesRelatedByUserId === null) {
			$this->collFavouritesRelatedByUserId = array();
		}
	}

	
	public function getFavouritesRelatedByUserId($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseFavouritePeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collFavouritesRelatedByUserId === null) {
			if ($this->isNew()) {
			   $this->collFavouritesRelatedByUserId = array();
			} else {

				$criteria->add(FavouritePeer::USER_ID, $this->getId());

				FavouritePeer::addSelectColumns($criteria);
				$this->collFavouritesRelatedByUserId = FavouritePeer::doSelect($criteria, $con);
			}
		} else {
						if (!$this->isNew()) {
												

				$criteria->add(FavouritePeer::USER_ID, $this->getId());

				FavouritePeer::addSelectColumns($criteria);
				if (!isset($this->lastFavouriteRelatedByUserIdCriteria) || !$this->lastFavouriteRelatedByUserIdCriteria->equals($criteria)) {
					$this->collFavouritesRelatedByUserId = FavouritePeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastFavouriteRelatedByUserIdCriteria = $criteria;
		return $this->collFavouritesRelatedByUserId;
	}

	
	public function countFavouritesRelatedByUserId($criteria = null, $distinct = false, $con = null)
	{
				include_once 'lib/model/om/BaseFavouritePeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(FavouritePeer::USER_ID, $this->getId());

		return FavouritePeer::doCount($criteria, $distinct, $con);
	}

	
	public function addFavouriteRelatedByUserId(Favourite $l)
	{
		$this->collFavouritesRelatedByUserId[] = $l;
		$l->setsfGuardUserRelatedByUserId($this);
	}


	
	public function getFavouritesRelatedByUserIdJoinReaktorArtwork($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseFavouritePeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collFavouritesRelatedByUserId === null) {
			if ($this->isNew()) {
				$this->collFavouritesRelatedByUserId = array();
			} else {

				$criteria->add(FavouritePeer::USER_ID, $this->getId());

				$this->collFavouritesRelatedByUserId = FavouritePeer::doSelectJoinReaktorArtwork($criteria, $con);
			}
		} else {
									
			$criteria->add(FavouritePeer::USER_ID, $this->getId());

			if (!isset($this->lastFavouriteRelatedByUserIdCriteria) || !$this->lastFavouriteRelatedByUserIdCriteria->equals($criteria)) {
				$this->collFavouritesRelatedByUserId = FavouritePeer::doSelectJoinReaktorArtwork($criteria, $con);
			}
		}
		$this->lastFavouriteRelatedByUserIdCriteria = $criteria;

		return $this->collFavouritesRelatedByUserId;
	}


	
	public function getFavouritesRelatedByUserIdJoinArticle($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseFavouritePeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collFavouritesRelatedByUserId === null) {
			if ($this->isNew()) {
				$this->collFavouritesRelatedByUserId = array();
			} else {

				$criteria->add(FavouritePeer::USER_ID, $this->getId());

				$this->collFavouritesRelatedByUserId = FavouritePeer::doSelectJoinArticle($criteria, $con);
			}
		} else {
									
			$criteria->add(FavouritePeer::USER_ID, $this->getId());

			if (!isset($this->lastFavouriteRelatedByUserIdCriteria) || !$this->lastFavouriteRelatedByUserIdCriteria->equals($criteria)) {
				$this->collFavouritesRelatedByUserId = FavouritePeer::doSelectJoinArticle($criteria, $con);
			}
		}
		$this->lastFavouriteRelatedByUserIdCriteria = $criteria;

		return $this->collFavouritesRelatedByUserId;
	}

	
	public function initFavouritesRelatedByFriendId()
	{
		if ($this->collFavouritesRelatedByFriendId === null) {
			$this->collFavouritesRelatedByFriendId = array();
		}
	}

	
	public function getFavouritesRelatedByFriendId($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseFavouritePeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collFavouritesRelatedByFriendId === null) {
			if ($this->isNew()) {
			   $this->collFavouritesRelatedByFriendId = array();
			} else {

				$criteria->add(FavouritePeer::FRIEND_ID, $this->getId());

				FavouritePeer::addSelectColumns($criteria);
				$this->collFavouritesRelatedByFriendId = FavouritePeer::doSelect($criteria, $con);
			}
		} else {
						if (!$this->isNew()) {
												

				$criteria->add(FavouritePeer::FRIEND_ID, $this->getId());

				FavouritePeer::addSelectColumns($criteria);
				if (!isset($this->lastFavouriteRelatedByFriendIdCriteria) || !$this->lastFavouriteRelatedByFriendIdCriteria->equals($criteria)) {
					$this->collFavouritesRelatedByFriendId = FavouritePeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastFavouriteRelatedByFriendIdCriteria = $criteria;
		return $this->collFavouritesRelatedByFriendId;
	}

	
	public function countFavouritesRelatedByFriendId($criteria = null, $distinct = false, $con = null)
	{
				include_once 'lib/model/om/BaseFavouritePeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(FavouritePeer::FRIEND_ID, $this->getId());

		return FavouritePeer::doCount($criteria, $distinct, $con);
	}

	
	public function addFavouriteRelatedByFriendId(Favourite $l)
	{
		$this->collFavouritesRelatedByFriendId[] = $l;
		$l->setsfGuardUserRelatedByFriendId($this);
	}


	
	public function getFavouritesRelatedByFriendIdJoinReaktorArtwork($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseFavouritePeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collFavouritesRelatedByFriendId === null) {
			if ($this->isNew()) {
				$this->collFavouritesRelatedByFriendId = array();
			} else {

				$criteria->add(FavouritePeer::FRIEND_ID, $this->getId());

				$this->collFavouritesRelatedByFriendId = FavouritePeer::doSelectJoinReaktorArtwork($criteria, $con);
			}
		} else {
									
			$criteria->add(FavouritePeer::FRIEND_ID, $this->getId());

			if (!isset($this->lastFavouriteRelatedByFriendIdCriteria) || !$this->lastFavouriteRelatedByFriendIdCriteria->equals($criteria)) {
				$this->collFavouritesRelatedByFriendId = FavouritePeer::doSelectJoinReaktorArtwork($criteria, $con);
			}
		}
		$this->lastFavouriteRelatedByFriendIdCriteria = $criteria;

		return $this->collFavouritesRelatedByFriendId;
	}


	
	public function getFavouritesRelatedByFriendIdJoinArticle($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseFavouritePeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collFavouritesRelatedByFriendId === null) {
			if ($this->isNew()) {
				$this->collFavouritesRelatedByFriendId = array();
			} else {

				$criteria->add(FavouritePeer::FRIEND_ID, $this->getId());

				$this->collFavouritesRelatedByFriendId = FavouritePeer::doSelectJoinArticle($criteria, $con);
			}
		} else {
									
			$criteria->add(FavouritePeer::FRIEND_ID, $this->getId());

			if (!isset($this->lastFavouriteRelatedByFriendIdCriteria) || !$this->lastFavouriteRelatedByFriendIdCriteria->equals($criteria)) {
				$this->collFavouritesRelatedByFriendId = FavouritePeer::doSelectJoinArticle($criteria, $con);
			}
		}
		$this->lastFavouriteRelatedByFriendIdCriteria = $criteria;

		return $this->collFavouritesRelatedByFriendId;
	}

	
	public function initsfGuardUserPermissions()
	{
		if ($this->collsfGuardUserPermissions === null) {
			$this->collsfGuardUserPermissions = array();
		}
	}

	
	public function getsfGuardUserPermissions($criteria = null, $con = null)
	{
				include_once 'plugins/sfGuardPlugin/lib/model/om/BasesfGuardUserPermissionPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collsfGuardUserPermissions === null) {
			if ($this->isNew()) {
			   $this->collsfGuardUserPermissions = array();
			} else {

				$criteria->add(sfGuardUserPermissionPeer::USER_ID, $this->getId());

				sfGuardUserPermissionPeer::addSelectColumns($criteria);
				$this->collsfGuardUserPermissions = sfGuardUserPermissionPeer::doSelect($criteria, $con);
			}
		} else {
						if (!$this->isNew()) {
												

				$criteria->add(sfGuardUserPermissionPeer::USER_ID, $this->getId());

				sfGuardUserPermissionPeer::addSelectColumns($criteria);
				if (!isset($this->lastsfGuardUserPermissionCriteria) || !$this->lastsfGuardUserPermissionCriteria->equals($criteria)) {
					$this->collsfGuardUserPermissions = sfGuardUserPermissionPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastsfGuardUserPermissionCriteria = $criteria;
		return $this->collsfGuardUserPermissions;
	}

	
	public function countsfGuardUserPermissions($criteria = null, $distinct = false, $con = null)
	{
				include_once 'plugins/sfGuardPlugin/lib/model/om/BasesfGuardUserPermissionPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(sfGuardUserPermissionPeer::USER_ID, $this->getId());

		return sfGuardUserPermissionPeer::doCount($criteria, $distinct, $con);
	}

	
	public function addsfGuardUserPermission(sfGuardUserPermission $l)
	{
		$this->collsfGuardUserPermissions[] = $l;
		$l->setsfGuardUser($this);
	}


	
	public function getsfGuardUserPermissionsJoinsfGuardPermission($criteria = null, $con = null)
	{
				include_once 'plugins/sfGuardPlugin/lib/model/om/BasesfGuardUserPermissionPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collsfGuardUserPermissions === null) {
			if ($this->isNew()) {
				$this->collsfGuardUserPermissions = array();
			} else {

				$criteria->add(sfGuardUserPermissionPeer::USER_ID, $this->getId());

				$this->collsfGuardUserPermissions = sfGuardUserPermissionPeer::doSelectJoinsfGuardPermission($criteria, $con);
			}
		} else {
									
			$criteria->add(sfGuardUserPermissionPeer::USER_ID, $this->getId());

			if (!isset($this->lastsfGuardUserPermissionCriteria) || !$this->lastsfGuardUserPermissionCriteria->equals($criteria)) {
				$this->collsfGuardUserPermissions = sfGuardUserPermissionPeer::doSelectJoinsfGuardPermission($criteria, $con);
			}
		}
		$this->lastsfGuardUserPermissionCriteria = $criteria;

		return $this->collsfGuardUserPermissions;
	}

	
	public function initsfGuardUserGroups()
	{
		if ($this->collsfGuardUserGroups === null) {
			$this->collsfGuardUserGroups = array();
		}
	}

	
	public function getsfGuardUserGroups($criteria = null, $con = null)
	{
				include_once 'plugins/sfGuardPlugin/lib/model/om/BasesfGuardUserGroupPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collsfGuardUserGroups === null) {
			if ($this->isNew()) {
			   $this->collsfGuardUserGroups = array();
			} else {

				$criteria->add(sfGuardUserGroupPeer::USER_ID, $this->getId());

				sfGuardUserGroupPeer::addSelectColumns($criteria);
				$this->collsfGuardUserGroups = sfGuardUserGroupPeer::doSelect($criteria, $con);
			}
		} else {
						if (!$this->isNew()) {
												

				$criteria->add(sfGuardUserGroupPeer::USER_ID, $this->getId());

				sfGuardUserGroupPeer::addSelectColumns($criteria);
				if (!isset($this->lastsfGuardUserGroupCriteria) || !$this->lastsfGuardUserGroupCriteria->equals($criteria)) {
					$this->collsfGuardUserGroups = sfGuardUserGroupPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastsfGuardUserGroupCriteria = $criteria;
		return $this->collsfGuardUserGroups;
	}

	
	public function countsfGuardUserGroups($criteria = null, $distinct = false, $con = null)
	{
				include_once 'plugins/sfGuardPlugin/lib/model/om/BasesfGuardUserGroupPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(sfGuardUserGroupPeer::USER_ID, $this->getId());

		return sfGuardUserGroupPeer::doCount($criteria, $distinct, $con);
	}

	
	public function addsfGuardUserGroup(sfGuardUserGroup $l)
	{
		$this->collsfGuardUserGroups[] = $l;
		$l->setsfGuardUser($this);
	}


	
	public function getsfGuardUserGroupsJoinsfGuardGroup($criteria = null, $con = null)
	{
				include_once 'plugins/sfGuardPlugin/lib/model/om/BasesfGuardUserGroupPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collsfGuardUserGroups === null) {
			if ($this->isNew()) {
				$this->collsfGuardUserGroups = array();
			} else {

				$criteria->add(sfGuardUserGroupPeer::USER_ID, $this->getId());

				$this->collsfGuardUserGroups = sfGuardUserGroupPeer::doSelectJoinsfGuardGroup($criteria, $con);
			}
		} else {
									
			$criteria->add(sfGuardUserGroupPeer::USER_ID, $this->getId());

			if (!isset($this->lastsfGuardUserGroupCriteria) || !$this->lastsfGuardUserGroupCriteria->equals($criteria)) {
				$this->collsfGuardUserGroups = sfGuardUserGroupPeer::doSelectJoinsfGuardGroup($criteria, $con);
			}
		}
		$this->lastsfGuardUserGroupCriteria = $criteria;

		return $this->collsfGuardUserGroups;
	}

	
	public function initsfGuardRememberKeys()
	{
		if ($this->collsfGuardRememberKeys === null) {
			$this->collsfGuardRememberKeys = array();
		}
	}

	
	public function getsfGuardRememberKeys($criteria = null, $con = null)
	{
				include_once 'plugins/sfGuardPlugin/lib/model/om/BasesfGuardRememberKeyPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collsfGuardRememberKeys === null) {
			if ($this->isNew()) {
			   $this->collsfGuardRememberKeys = array();
			} else {

				$criteria->add(sfGuardRememberKeyPeer::USER_ID, $this->getId());

				sfGuardRememberKeyPeer::addSelectColumns($criteria);
				$this->collsfGuardRememberKeys = sfGuardRememberKeyPeer::doSelect($criteria, $con);
			}
		} else {
						if (!$this->isNew()) {
												

				$criteria->add(sfGuardRememberKeyPeer::USER_ID, $this->getId());

				sfGuardRememberKeyPeer::addSelectColumns($criteria);
				if (!isset($this->lastsfGuardRememberKeyCriteria) || !$this->lastsfGuardRememberKeyCriteria->equals($criteria)) {
					$this->collsfGuardRememberKeys = sfGuardRememberKeyPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastsfGuardRememberKeyCriteria = $criteria;
		return $this->collsfGuardRememberKeys;
	}

	
	public function countsfGuardRememberKeys($criteria = null, $distinct = false, $con = null)
	{
				include_once 'plugins/sfGuardPlugin/lib/model/om/BasesfGuardRememberKeyPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(sfGuardRememberKeyPeer::USER_ID, $this->getId());

		return sfGuardRememberKeyPeer::doCount($criteria, $distinct, $con);
	}

	
	public function addsfGuardRememberKey(sfGuardRememberKey $l)
	{
		$this->collsfGuardRememberKeys[] = $l;
		$l->setsfGuardUser($this);
	}

	
	public function initUserResources()
	{
		if ($this->collUserResources === null) {
			$this->collUserResources = array();
		}
	}

	
	public function getUserResources($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseUserResourcePeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collUserResources === null) {
			if ($this->isNew()) {
			   $this->collUserResources = array();
			} else {

				$criteria->add(UserResourcePeer::USER_ID, $this->getId());

				UserResourcePeer::addSelectColumns($criteria);
				$this->collUserResources = UserResourcePeer::doSelect($criteria, $con);
			}
		} else {
						if (!$this->isNew()) {
												

				$criteria->add(UserResourcePeer::USER_ID, $this->getId());

				UserResourcePeer::addSelectColumns($criteria);
				if (!isset($this->lastUserResourceCriteria) || !$this->lastUserResourceCriteria->equals($criteria)) {
					$this->collUserResources = UserResourcePeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastUserResourceCriteria = $criteria;
		return $this->collUserResources;
	}

	
	public function countUserResources($criteria = null, $distinct = false, $con = null)
	{
				include_once 'lib/model/om/BaseUserResourcePeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(UserResourcePeer::USER_ID, $this->getId());

		return UserResourcePeer::doCount($criteria, $distinct, $con);
	}

	
	public function addUserResource(UserResource $l)
	{
		$this->collUserResources[] = $l;
		$l->setsfGuardUser($this);
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

				$criteria->add(CategoryArtworkPeer::ADDED_BY, $this->getId());

				CategoryArtworkPeer::addSelectColumns($criteria);
				$this->collCategoryArtworks = CategoryArtworkPeer::doSelect($criteria, $con);
			}
		} else {
						if (!$this->isNew()) {
												

				$criteria->add(CategoryArtworkPeer::ADDED_BY, $this->getId());

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

		$criteria->add(CategoryArtworkPeer::ADDED_BY, $this->getId());

		return CategoryArtworkPeer::doCount($criteria, $distinct, $con);
	}

	
	public function addCategoryArtwork(CategoryArtwork $l)
	{
		$this->collCategoryArtworks[] = $l;
		$l->setsfGuardUser($this);
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

				$criteria->add(CategoryArtworkPeer::ADDED_BY, $this->getId());

				$this->collCategoryArtworks = CategoryArtworkPeer::doSelectJoinCategory($criteria, $con);
			}
		} else {
									
			$criteria->add(CategoryArtworkPeer::ADDED_BY, $this->getId());

			if (!isset($this->lastCategoryArtworkCriteria) || !$this->lastCategoryArtworkCriteria->equals($criteria)) {
				$this->collCategoryArtworks = CategoryArtworkPeer::doSelectJoinCategory($criteria, $con);
			}
		}
		$this->lastCategoryArtworkCriteria = $criteria;

		return $this->collCategoryArtworks;
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

				$criteria->add(CategoryArtworkPeer::ADDED_BY, $this->getId());

				$this->collCategoryArtworks = CategoryArtworkPeer::doSelectJoinReaktorArtwork($criteria, $con);
			}
		} else {
									
			$criteria->add(CategoryArtworkPeer::ADDED_BY, $this->getId());

			if (!isset($this->lastCategoryArtworkCriteria) || !$this->lastCategoryArtworkCriteria->equals($criteria)) {
				$this->collCategoryArtworks = CategoryArtworkPeer::doSelectJoinReaktorArtwork($criteria, $con);
			}
		}
		$this->lastCategoryArtworkCriteria = $criteria;

		return $this->collCategoryArtworks;
	}

	
	public function initMessagessRelatedByToUserId()
	{
		if ($this->collMessagessRelatedByToUserId === null) {
			$this->collMessagessRelatedByToUserId = array();
		}
	}

	
	public function getMessagessRelatedByToUserId($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseMessagesPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collMessagessRelatedByToUserId === null) {
			if ($this->isNew()) {
			   $this->collMessagessRelatedByToUserId = array();
			} else {

				$criteria->add(MessagesPeer::TO_USER_ID, $this->getId());

				MessagesPeer::addSelectColumns($criteria);
				$this->collMessagessRelatedByToUserId = MessagesPeer::doSelect($criteria, $con);
			}
		} else {
						if (!$this->isNew()) {
												

				$criteria->add(MessagesPeer::TO_USER_ID, $this->getId());

				MessagesPeer::addSelectColumns($criteria);
				if (!isset($this->lastMessagesRelatedByToUserIdCriteria) || !$this->lastMessagesRelatedByToUserIdCriteria->equals($criteria)) {
					$this->collMessagessRelatedByToUserId = MessagesPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastMessagesRelatedByToUserIdCriteria = $criteria;
		return $this->collMessagessRelatedByToUserId;
	}

	
	public function countMessagessRelatedByToUserId($criteria = null, $distinct = false, $con = null)
	{
				include_once 'lib/model/om/BaseMessagesPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(MessagesPeer::TO_USER_ID, $this->getId());

		return MessagesPeer::doCount($criteria, $distinct, $con);
	}

	
	public function addMessagesRelatedByToUserId(Messages $l)
	{
		$this->collMessagessRelatedByToUserId[] = $l;
		$l->setsfGuardUserRelatedByToUserId($this);
	}

	
	public function initMessagessRelatedByFromUserId()
	{
		if ($this->collMessagessRelatedByFromUserId === null) {
			$this->collMessagessRelatedByFromUserId = array();
		}
	}

	
	public function getMessagessRelatedByFromUserId($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseMessagesPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collMessagessRelatedByFromUserId === null) {
			if ($this->isNew()) {
			   $this->collMessagessRelatedByFromUserId = array();
			} else {

				$criteria->add(MessagesPeer::FROM_USER_ID, $this->getId());

				MessagesPeer::addSelectColumns($criteria);
				$this->collMessagessRelatedByFromUserId = MessagesPeer::doSelect($criteria, $con);
			}
		} else {
						if (!$this->isNew()) {
												

				$criteria->add(MessagesPeer::FROM_USER_ID, $this->getId());

				MessagesPeer::addSelectColumns($criteria);
				if (!isset($this->lastMessagesRelatedByFromUserIdCriteria) || !$this->lastMessagesRelatedByFromUserIdCriteria->equals($criteria)) {
					$this->collMessagessRelatedByFromUserId = MessagesPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastMessagesRelatedByFromUserIdCriteria = $criteria;
		return $this->collMessagessRelatedByFromUserId;
	}

	
	public function countMessagessRelatedByFromUserId($criteria = null, $distinct = false, $con = null)
	{
				include_once 'lib/model/om/BaseMessagesPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(MessagesPeer::FROM_USER_ID, $this->getId());

		return MessagesPeer::doCount($criteria, $distinct, $con);
	}

	
	public function addMessagesRelatedByFromUserId(Messages $l)
	{
		$this->collMessagessRelatedByFromUserId[] = $l;
		$l->setsfGuardUserRelatedByFromUserId($this);
	}

	
	public function initMessagesIgnoredUsersRelatedByUserId()
	{
		if ($this->collMessagesIgnoredUsersRelatedByUserId === null) {
			$this->collMessagesIgnoredUsersRelatedByUserId = array();
		}
	}

	
	public function getMessagesIgnoredUsersRelatedByUserId($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseMessagesIgnoredUserPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collMessagesIgnoredUsersRelatedByUserId === null) {
			if ($this->isNew()) {
			   $this->collMessagesIgnoredUsersRelatedByUserId = array();
			} else {

				$criteria->add(MessagesIgnoredUserPeer::USER_ID, $this->getId());

				MessagesIgnoredUserPeer::addSelectColumns($criteria);
				$this->collMessagesIgnoredUsersRelatedByUserId = MessagesIgnoredUserPeer::doSelect($criteria, $con);
			}
		} else {
						if (!$this->isNew()) {
												

				$criteria->add(MessagesIgnoredUserPeer::USER_ID, $this->getId());

				MessagesIgnoredUserPeer::addSelectColumns($criteria);
				if (!isset($this->lastMessagesIgnoredUserRelatedByUserIdCriteria) || !$this->lastMessagesIgnoredUserRelatedByUserIdCriteria->equals($criteria)) {
					$this->collMessagesIgnoredUsersRelatedByUserId = MessagesIgnoredUserPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastMessagesIgnoredUserRelatedByUserIdCriteria = $criteria;
		return $this->collMessagesIgnoredUsersRelatedByUserId;
	}

	
	public function countMessagesIgnoredUsersRelatedByUserId($criteria = null, $distinct = false, $con = null)
	{
				include_once 'lib/model/om/BaseMessagesIgnoredUserPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(MessagesIgnoredUserPeer::USER_ID, $this->getId());

		return MessagesIgnoredUserPeer::doCount($criteria, $distinct, $con);
	}

	
	public function addMessagesIgnoredUserRelatedByUserId(MessagesIgnoredUser $l)
	{
		$this->collMessagesIgnoredUsersRelatedByUserId[] = $l;
		$l->setsfGuardUserRelatedByUserId($this);
	}

	
	public function initMessagesIgnoredUsersRelatedByIgnoresUserId()
	{
		if ($this->collMessagesIgnoredUsersRelatedByIgnoresUserId === null) {
			$this->collMessagesIgnoredUsersRelatedByIgnoresUserId = array();
		}
	}

	
	public function getMessagesIgnoredUsersRelatedByIgnoresUserId($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseMessagesIgnoredUserPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collMessagesIgnoredUsersRelatedByIgnoresUserId === null) {
			if ($this->isNew()) {
			   $this->collMessagesIgnoredUsersRelatedByIgnoresUserId = array();
			} else {

				$criteria->add(MessagesIgnoredUserPeer::IGNORES_USER_ID, $this->getId());

				MessagesIgnoredUserPeer::addSelectColumns($criteria);
				$this->collMessagesIgnoredUsersRelatedByIgnoresUserId = MessagesIgnoredUserPeer::doSelect($criteria, $con);
			}
		} else {
						if (!$this->isNew()) {
												

				$criteria->add(MessagesIgnoredUserPeer::IGNORES_USER_ID, $this->getId());

				MessagesIgnoredUserPeer::addSelectColumns($criteria);
				if (!isset($this->lastMessagesIgnoredUserRelatedByIgnoresUserIdCriteria) || !$this->lastMessagesIgnoredUserRelatedByIgnoresUserIdCriteria->equals($criteria)) {
					$this->collMessagesIgnoredUsersRelatedByIgnoresUserId = MessagesIgnoredUserPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastMessagesIgnoredUserRelatedByIgnoresUserIdCriteria = $criteria;
		return $this->collMessagesIgnoredUsersRelatedByIgnoresUserId;
	}

	
	public function countMessagesIgnoredUsersRelatedByIgnoresUserId($criteria = null, $distinct = false, $con = null)
	{
				include_once 'lib/model/om/BaseMessagesIgnoredUserPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(MessagesIgnoredUserPeer::IGNORES_USER_ID, $this->getId());

		return MessagesIgnoredUserPeer::doCount($criteria, $distinct, $con);
	}

	
	public function addMessagesIgnoredUserRelatedByIgnoresUserId(MessagesIgnoredUser $l)
	{
		$this->collMessagesIgnoredUsersRelatedByIgnoresUserId[] = $l;
		$l->setsfGuardUserRelatedByIgnoresUserId($this);
	}

	
	public function initAdminMessages()
	{
		if ($this->collAdminMessages === null) {
			$this->collAdminMessages = array();
		}
	}

	
	public function getAdminMessages($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseAdminMessagePeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collAdminMessages === null) {
			if ($this->isNew()) {
			   $this->collAdminMessages = array();
			} else {

				$criteria->add(AdminMessagePeer::AUTHOR, $this->getId());

				AdminMessagePeer::addSelectColumns($criteria);
				$this->collAdminMessages = AdminMessagePeer::doSelect($criteria, $con);
			}
		} else {
						if (!$this->isNew()) {
												

				$criteria->add(AdminMessagePeer::AUTHOR, $this->getId());

				AdminMessagePeer::addSelectColumns($criteria);
				if (!isset($this->lastAdminMessageCriteria) || !$this->lastAdminMessageCriteria->equals($criteria)) {
					$this->collAdminMessages = AdminMessagePeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastAdminMessageCriteria = $criteria;
		return $this->collAdminMessages;
	}

	
	public function countAdminMessages($criteria = null, $distinct = false, $con = null)
	{
				include_once 'lib/model/om/BaseAdminMessagePeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(AdminMessagePeer::AUTHOR, $this->getId());

		return AdminMessagePeer::doCount($criteria, $distinct, $con);
	}

	
	public function addAdminMessage(AdminMessage $l)
	{
		$this->collAdminMessages[] = $l;
		$l->setsfGuardUser($this);
	}

	
	public function initReaktorFiles()
	{
		if ($this->collReaktorFiles === null) {
			$this->collReaktorFiles = array();
		}
	}

	
	public function getReaktorFiles($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseReaktorFilePeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collReaktorFiles === null) {
			if ($this->isNew()) {
			   $this->collReaktorFiles = array();
			} else {

				$criteria->add(ReaktorFilePeer::USER_ID, $this->getId());

				ReaktorFilePeer::addSelectColumns($criteria);
				$this->collReaktorFiles = ReaktorFilePeer::doSelect($criteria, $con);
			}
		} else {
						if (!$this->isNew()) {
												

				$criteria->add(ReaktorFilePeer::USER_ID, $this->getId());

				ReaktorFilePeer::addSelectColumns($criteria);
				if (!isset($this->lastReaktorFileCriteria) || !$this->lastReaktorFileCriteria->equals($criteria)) {
					$this->collReaktorFiles = ReaktorFilePeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastReaktorFileCriteria = $criteria;
		return $this->collReaktorFiles;
	}

	
	public function countReaktorFiles($criteria = null, $distinct = false, $con = null)
	{
				include_once 'lib/model/om/BaseReaktorFilePeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(ReaktorFilePeer::USER_ID, $this->getId());

		return ReaktorFilePeer::doCount($criteria, $distinct, $con);
	}

	
	public function addReaktorFile(ReaktorFile $l)
	{
		$this->collReaktorFiles[] = $l;
		$l->setsfGuardUser($this);
	}

	
	public function initReaktorArtworkHistorys()
	{
		if ($this->collReaktorArtworkHistorys === null) {
			$this->collReaktorArtworkHistorys = array();
		}
	}

	
	public function getReaktorArtworkHistorys($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseReaktorArtworkHistoryPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collReaktorArtworkHistorys === null) {
			if ($this->isNew()) {
			   $this->collReaktorArtworkHistorys = array();
			} else {

				$criteria->add(ReaktorArtworkHistoryPeer::USER_ID, $this->getId());

				ReaktorArtworkHistoryPeer::addSelectColumns($criteria);
				$this->collReaktorArtworkHistorys = ReaktorArtworkHistoryPeer::doSelect($criteria, $con);
			}
		} else {
						if (!$this->isNew()) {
												

				$criteria->add(ReaktorArtworkHistoryPeer::USER_ID, $this->getId());

				ReaktorArtworkHistoryPeer::addSelectColumns($criteria);
				if (!isset($this->lastReaktorArtworkHistoryCriteria) || !$this->lastReaktorArtworkHistoryCriteria->equals($criteria)) {
					$this->collReaktorArtworkHistorys = ReaktorArtworkHistoryPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastReaktorArtworkHistoryCriteria = $criteria;
		return $this->collReaktorArtworkHistorys;
	}

	
	public function countReaktorArtworkHistorys($criteria = null, $distinct = false, $con = null)
	{
				include_once 'lib/model/om/BaseReaktorArtworkHistoryPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(ReaktorArtworkHistoryPeer::USER_ID, $this->getId());

		return ReaktorArtworkHistoryPeer::doCount($criteria, $distinct, $con);
	}

	
	public function addReaktorArtworkHistory(ReaktorArtworkHistory $l)
	{
		$this->collReaktorArtworkHistorys[] = $l;
		$l->setsfGuardUser($this);
	}


	
	public function getReaktorArtworkHistorysJoinReaktorArtworkRelatedByArtworkId($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseReaktorArtworkHistoryPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collReaktorArtworkHistorys === null) {
			if ($this->isNew()) {
				$this->collReaktorArtworkHistorys = array();
			} else {

				$criteria->add(ReaktorArtworkHistoryPeer::USER_ID, $this->getId());

				$this->collReaktorArtworkHistorys = ReaktorArtworkHistoryPeer::doSelectJoinReaktorArtworkRelatedByArtworkId($criteria, $con);
			}
		} else {
									
			$criteria->add(ReaktorArtworkHistoryPeer::USER_ID, $this->getId());

			if (!isset($this->lastReaktorArtworkHistoryCriteria) || !$this->lastReaktorArtworkHistoryCriteria->equals($criteria)) {
				$this->collReaktorArtworkHistorys = ReaktorArtworkHistoryPeer::doSelectJoinReaktorArtworkRelatedByArtworkId($criteria, $con);
			}
		}
		$this->lastReaktorArtworkHistoryCriteria = $criteria;

		return $this->collReaktorArtworkHistorys;
	}


	
	public function getReaktorArtworkHistorysJoinReaktorArtworkRelatedByFileId($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseReaktorArtworkHistoryPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collReaktorArtworkHistorys === null) {
			if ($this->isNew()) {
				$this->collReaktorArtworkHistorys = array();
			} else {

				$criteria->add(ReaktorArtworkHistoryPeer::USER_ID, $this->getId());

				$this->collReaktorArtworkHistorys = ReaktorArtworkHistoryPeer::doSelectJoinReaktorArtworkRelatedByFileId($criteria, $con);
			}
		} else {
									
			$criteria->add(ReaktorArtworkHistoryPeer::USER_ID, $this->getId());

			if (!isset($this->lastReaktorArtworkHistoryCriteria) || !$this->lastReaktorArtworkHistoryCriteria->equals($criteria)) {
				$this->collReaktorArtworkHistorys = ReaktorArtworkHistoryPeer::doSelectJoinReaktorArtworkRelatedByFileId($criteria, $con);
			}
		}
		$this->lastReaktorArtworkHistoryCriteria = $criteria;

		return $this->collReaktorArtworkHistorys;
	}


	
	public function getReaktorArtworkHistorysJoinArtworkStatus($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseReaktorArtworkHistoryPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collReaktorArtworkHistorys === null) {
			if ($this->isNew()) {
				$this->collReaktorArtworkHistorys = array();
			} else {

				$criteria->add(ReaktorArtworkHistoryPeer::USER_ID, $this->getId());

				$this->collReaktorArtworkHistorys = ReaktorArtworkHistoryPeer::doSelectJoinArtworkStatus($criteria, $con);
			}
		} else {
									
			$criteria->add(ReaktorArtworkHistoryPeer::USER_ID, $this->getId());

			if (!isset($this->lastReaktorArtworkHistoryCriteria) || !$this->lastReaktorArtworkHistoryCriteria->equals($criteria)) {
				$this->collReaktorArtworkHistorys = ReaktorArtworkHistoryPeer::doSelectJoinArtworkStatus($criteria, $con);
			}
		}
		$this->lastReaktorArtworkHistoryCriteria = $criteria;

		return $this->collReaktorArtworkHistorys;
	}

	
	public function initHistorys()
	{
		if ($this->collHistorys === null) {
			$this->collHistorys = array();
		}
	}

	
	public function getHistorys($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseHistoryPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collHistorys === null) {
			if ($this->isNew()) {
			   $this->collHistorys = array();
			} else {

				$criteria->add(HistoryPeer::USER_ID, $this->getId());

				HistoryPeer::addSelectColumns($criteria);
				$this->collHistorys = HistoryPeer::doSelect($criteria, $con);
			}
		} else {
						if (!$this->isNew()) {
												

				$criteria->add(HistoryPeer::USER_ID, $this->getId());

				HistoryPeer::addSelectColumns($criteria);
				if (!isset($this->lastHistoryCriteria) || !$this->lastHistoryCriteria->equals($criteria)) {
					$this->collHistorys = HistoryPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastHistoryCriteria = $criteria;
		return $this->collHistorys;
	}

	
	public function countHistorys($criteria = null, $distinct = false, $con = null)
	{
				include_once 'lib/model/om/BaseHistoryPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(HistoryPeer::USER_ID, $this->getId());

		return HistoryPeer::doCount($criteria, $distinct, $con);
	}

	
	public function addHistory(History $l)
	{
		$this->collHistorys[] = $l;
		$l->setsfGuardUser($this);
	}


	
	public function getHistorysJoinHistoryAction($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseHistoryPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collHistorys === null) {
			if ($this->isNew()) {
				$this->collHistorys = array();
			} else {

				$criteria->add(HistoryPeer::USER_ID, $this->getId());

				$this->collHistorys = HistoryPeer::doSelectJoinHistoryAction($criteria, $con);
			}
		} else {
									
			$criteria->add(HistoryPeer::USER_ID, $this->getId());

			if (!isset($this->lastHistoryCriteria) || !$this->lastHistoryCriteria->equals($criteria)) {
				$this->collHistorys = HistoryPeer::doSelectJoinHistoryAction($criteria, $con);
			}
		}
		$this->lastHistoryCriteria = $criteria;

		return $this->collHistorys;
	}


  public function __call($method, $arguments)
  {
    if (!$callable = sfMixer::getCallable('BasesfGuardUser:'.$method))
    {
      throw new sfException(sprintf('Call to undefined method BasesfGuardUser::%s', $method));
    }

    array_unshift($arguments, $this);

    return call_user_func_array($callable, $arguments);
  }


} 