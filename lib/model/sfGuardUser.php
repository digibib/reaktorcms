<?php
/**
 * This file overrides the sfGuardUser file in the plugin/sfGuardPlugin/lib/model
 * file. 
 * 
 * PHP version 5
 *
 * @author    juneih <juneih@linpro.no>
 * @copyright 2008 Linpro
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 * 
 */

/**
 * The sfGuardUser class, extended with some basic functions
 * 
 * PHP version 5
 *
 * @author    juneih <juneih@linpro.no>
 * @copyright 2008 Linpro
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 * 
 */
class sfGuardUser extends PluginsfGuardUser
{
  
	protected $_editorialteams = null;
	
  /**
   * To string is used in dropdowns and when trying to print objects.
   *
   * @return unknown
   */
  public function __toString()
  {
    return $this->getUsername();
  }

  /**
   * Same as the __toString() method. Needed for the Feed plugin
   *
   * @see __toString()
   * @return string
   */
  public function getUser()
  {
    return (string)$this;
  }
  
  /**
	 * Set date of birth, and handle both input as array and string.
	 *
	 * @param array $v Date of birth
	 * 
	 * @return void
	 */
  public function setDob($v)
  {
    if ( is_array($v) && array_key_exists('year', $v) && array_key_exists('month', $v) && array_key_exists('day', $v))
    {
      if ( !empty($v['year']) && !empty($v['month']) && !empty($v['day']) )
      {
        parent::setDob($v['year'].'-'.$v['month'].'-'.$v['day']);
      }
      else
      {
        parent::setDob(null);
      }
    }
    else
    {
      parent::setDob($v);
    }
  }
  
  /**
   * Handles updating reaktor userdata
   *
   * @param object $action webrequest object
   * 
   * @return null
   */
  public function updateUser($action)
  {   
    if ($action->getRequestParameter('password_profile'))
    {
      parent::setPassword($action->getRequestParameter('password_profile'));
    }
    parent::setUsername($action->getRequestParameter('username_profile'));
    //parent::setId($action->getRequestParameter('id') ? $action->getRequestParameter('id') : null);
    if ($action->getRequestParameter('email') != parent::getEmail())
    {
      if (!$action->getUser()->hasCredential('editprofile'))
      {
        parent::setNewEmail($action->getRequestParameter('email'));
        parent::setNewEmailKey(stringMagick::generateSalt());
    
        global $mail_data;
        $mail_data = array('user' => $this,
                             'salt' => $this->getSalt(),
                             'newEmailKey' => $this->getNewEmailKey());
       
        // Send e-mail to new address
        $raw_email = $action->sendEmail('mail', 'sendNewEmailActivation');
        $action->logMessage($raw_email, 'debug');
        
        // Send e-mail to old address  
        $raw_email = $action->sendEmail('mail', 'sendNewEmailActivationNotification');
        $action->logMessage($raw_email, 'debug');
      }
      else
      {
        parent::setEmail($action->getRequestParameter('email'));
      }
    }
    parent::setName($action->getRequestParameter('name'));
    
    $this->setDob($action->getRequestParameter('dob'));
    if($action->getRequestParameter('sex')=='2'||$action->getRequestParameter('sex')=='1')
    {    
      parent::setSex($action->getRequestParameter('sex'));
    }
    parent::setDescription($action->getRequestParameter('description'));
    parent::setResidenceId($action->getRequestParameter('residence_id'));
    
    //set Interests
    UserInterestPeer::deleteByUser($action->getRequestParameter('id'));    
    $subs = SubreaktorPeer::doSelect(new Criteria());
    foreach ($subs as $sub)
    {      
      if ($action->getRequestParameter($sub->getName()))
      {
        $user_interest = new UserInterest();
        $user_interest->setUserId($action->getRequestParameter('id'));
        $user_interest->setSubreaktorId($action->getRequestParameter($sub->getName()));
        $user_interest->save();
      }
    }

    parent::setMsn($action->getRequestParameter('msn'));
    if($action->getRequestParameter('icq'))
    {
      parent::setIcq($action->getRequestParameter('icq'));
    }
    else
    {
      parent::setIcq(null);
    }
    parent::setHomepage($action->getRequestParameter('homepage'));
    parent::setEmailPrivate(($action->getRequestParameter('email_private') == '') ? 0 : 1);
    parent::setNamePrivate(($action->getRequestParameter('name_private') == '') ? 0 : 1);
    parent::setShowLoginStatus(($action->getRequestParameter('show_login_status') == '') ? 0 : 1);
    parent::setPhone($action->getRequestParameter('phone'));
    parent::setOptIn(($action->getRequestParameter('opt_in') == '') ? 0 : 1 );
    parent::setCulture($action->getRequestParameter('catalogue'));
    $avatar_filename = $action->getRequest()->getFilename('avatar');
    
    if ($avatar_filename)
    {
      //create filename 
      if (!parent::getAvatar())
      {
        $explode_avatar_filename = explode(".", $avatar_filename);
        $file_extention          = end($explode_avatar_filename);
        $string_magick           = new stringMagick();
        $random                  = $string_magick->randomString();
        $new_avatar_filename     = time().$random.'.'.$file_extention; 
      }
      else
      {
        $new_avatar_filename = parent::getAvatar();
      }                
      $avatar_filepath = sfConfig::get('sf_upload_dir').'/profile_images/'.$new_avatar_filename;

      //resize avatar
      $resizedImage = new imageResize($action->getRequest()->getFileValue('avatar', 'tmp_name'),
        $avatar_filepath, sfConfig::get('app_profile_max_image_width', '75'),
        sfConfig::get('app_profile_max_image_height', '100'));
        
      //save file in web/upload/profile_images/timestamprandom.extention and filname in database
      $resizedImage->imageWrite();                  
      parent::setAvatar($new_avatar_filename);
    }        
    parent::save();
  }
  
  /**
   * Overrides the parent save function
   *
   * @param unknown_type $con Connection object
   * 
   * @return void
   */
  public function save($con = null)
  {
    // pre save hook
    $send_email = false;
    
    // If the user is created when a user is logged in, that means we
    // are talking about an admin user, since users who are authenticated
    // will be redirected to the profile page if they try to register
    if (sfContext::getInstance()->getUser()->isAuthenticated())
    {
      // is this a new user?
      if (!$this->getId() && !$this->getIsVerified())
      {
        $send_email = true;
      }
    }
    // call the parent save() method
    parent::save($con);

    if ($send_email)
    {
      // Create and send e-mail
      global $mail_data;
      $mail_data = array('user' => $this);
      $raw_email = sfContext::getInstance()->getController()->sendEmail('mail', 'sendActivationEmail');
    }
  }
  
  /**
   * Handles registering reaktor userdata
   *
   * @param object $action Web request object
   * 
   * @return void
   */
  public function registerUser($action)
  {
    //$db_user = new sfGuardUser();
    parent::setUsername(trim($action->getRequestParameter('username_profile')));
    parent::setPassword($action->getRequestParameter('password_profile'));
    parent::setIsActive(1); 
    parent::setShowContent(1);   
    parent::setEmail($action->getRequestParameter('email'));
    parent::setResidenceId($action->getRequestParameter('residence_id'));
    $this->setDob($action->getRequestParameter('dob'));
    parent::setSex($action->getRequestParameter('sex'));

    parent::save();
    $user_group = new sfGuardUserGroup();
    $user_group->setsfGuardGroup(sfGuardGroupPeer::retrieveByPK(2));
    $user_group->setsfGuardUser($this);
    $user_group->save();
    //return $db_user;
  }
   
  /**
   * Handles activating reaktor user 
   *
   * @param object $action web_request object
   * 
   * @return void
   */ 
  public function activateUser($action)
  {    
    parent::setIsVerified(1);
    parent::save();
  }
  
  /**
   * Set the email to the new email and blank out the 'new email' field.
   *
   * @param object $action web request object
   * 
   * @return void
   */
  public function changeEmail($action)
  {
    parent::setEmail(parent::getNewEmail());
    parent::setNewEmail('');
    parent::save();
  }
  
  /**
   * Return the number of artworks this user has submitted
   *
   * @param string $type The type to filter by
   * 
   * @return integer number of artworks
   */
  public function getArtworkCount($type = null)
  {
    return ReaktorArtworkPeer::countUserArtworks($this, $type);
  }
  
  /**
   * returns a list of a users editorial teams
   *
   * @return array
   */
  public function getEditorialTeams()
  {
  	if ($this->_editorialteams === null)
  	{
  		$this->_editorialteams = array();
  		foreach ($this->getGroups() as $aGroup)
  		{
  			if ($aGroup->getIsEditorialTeam())
  			{
  				$this->_editorialteams[$aGroup->getName()] = $aGroup;
  			}
  		}
  	}
  	return $this->_editorialteams;
  }
  
  /**
   * Return true if the user is part of the specified editorial team
   *
   * @param string $teamname
   * 
   * @return boolean
   */
  public function hasEditorialTeam($teamname)
  {
  	if ($this->hasGroup($teamname))
  	{
  		if ($this->groups[$teamname]->isEditorialTeam())
  		{
  			return true;
  		}
  		else
  		{
  			return false;
  		}
  	}
  	else
  	{
  		return false;
  	}
  }
  
  /**
   * Returns the users avatar or a default image
   * 
   * @param string $default optional filename, default is default.gif
   * @return string filename
   */
  public function getAvatarOrDefault($default = "default.gif")
  {
    return parent::getAvatar() ? parent::getAvatar() : $default;
  }

  /**
   * Required by the Feed plugin to generate routes automatically
   *
   * @return string The culture in question, "no" if none specified
   */
  public function getFeedsfCulture()
  {
    return sfContext::getInstance()->getRequest()->getParameter("sf_culture", "no");
  }

  /**
   * Get the provided subreaktor for Feed generator
   *
   * @return subreaktor|null
   */
  public function getFeedSubreaktor()
  {
    if (subreaktor::isValid())
    {
      return Subreaktor::getProvided();
    }
  }
  
  /**
   * Get the absolute URL to the users portfolio
   * Required to generate valid Atom1.0 feeds
   * 
   * @return string absolute URL to his portfolio
   */
  public function getFeedUniqueId()
  {
    return sfContext::getInstance()->getController()->genUrl("@portfolio?user={$this->getId()}", true);
  }


  public function getPermissions()
  {
    if (!$this->permissions)
    {
      $this->permissions = array();

      $c = new Criteria();
      $c->add(sfGuardUserPermissionPeer::USER_ID, $this->getId());
      $c->add(sfGuardUserPermissionPeer::EXCLUDE, 0);
      $ups = sfGuardUserPermissionPeer::doSelectJoinsfGuardPermission($c);

      foreach ($ups as $up)
      {
        $permission = $up->getsfGuardPermission();
        $this->permissions[$permission->getName()] = $permission;
      }
    }

    return $this->permissions;
  }

  // merge of permission in a group + permissions, and exclude the explicitly 
  // revoked permissions
  public function getAllPermissions()
  {
    if (!$this->allPermissions)
    {
      $this->allPermissions = $this->getPermissions();

      foreach ($this->getGroups() as $group)
      {
        foreach ($group->getsfGuardGroupPermissions() as $gp)
        {
          $permission = $gp->getsfGuardPermission();

          $this->allPermissions[$permission->getName()] = $permission;
        }
      }

      /* Remove excluded permissinos */
      $c = new Criteria();
      $c->add(sfGuardUserPermissionPeer::USER_ID, $this->getId());
      $c->add(sfGuardUserPermissionPeer::EXCLUDE, 1);
      $ups = sfGuardUserPermissionPeer::doSelectJoinsfGuardPermission($c);

      foreach ($ups as $up)
      {
        $permission = $up->getsfGuardPermission()->getName();
        unset($this->allPermissions[$permission]);
      }
 
    }

    return $this->allPermissions;
  }


  public function getNameOrUsername()
  {
    return ($this->getName()!='' ? $this->getName() : $this->getUsername() );
  }



  public function checkPasswordByGuard($password)
  {
    $algorithm = $this->getAlgorithm();
    if (false !== $pos = strpos($algorithm, '::'))
    {
      $algorithm = array(substr($algorithm, 0, $pos), substr($algorithm, $pos + 2));
    }
    if (!is_callable($algorithm))
    {
      throw new sfException(sprintf('The algorithm callable "%s" is not callable.', $algorithm));
    }
	$prototype_login = $this->getPassword() == call_user_func_array($algorithm, array($password.$this->getSalt()));
	if ($algorithm === 'md5' && $prototype_login)
	{
		return $prototype_login;
	}
	else
	{
    	return $this->getPassword() == call_user_func_array($algorithm, array($this->getSalt().$password));
	}
  }

  public function getLink()
  {
    return '@portfolio?user=' . $this->getUsername();
  }
  
  /**
   * For the sake of form validation, it's better if we have an empty string as default in the field
   * in the cases where icq number is 0 or null
   *
   * @return integer
   */
  public function getIcq()
  {
    return parent::getIcq() ? parent::getIcq() : "";
  }
  
  /**
   * Return the correct age for this user
   *
   * @return integer
   */
  public function getAge()
  {
    $dob = strtotime($this->getDob());
    
    $year_diff  = date("Y") - date("Y", $dob);
    $month_diff = date("m") - date("m", $dob);
    $day_diff   = date("d") - date("d", $dob);
    
    if ($month_diff < 0 || ($month_diff == 0 && $day_diff < 0)) 
    {
      $year_diff--;
    }
    return $year_diff;
  }
}

