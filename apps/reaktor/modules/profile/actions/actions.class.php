<?php
/**
 * The main file for profile actions.
 *
 * PHP version 5
 * 
 * @author    June Henriksen <juneih@linpro.no>
 * @author    Ole Petter Wikene <olepw@linpro.no>
 * @author    Kjell-Magne Oierud <kjellm@linpro.no>
 * @author    Russ Flynn <russ@linpro.no>
 * @copyright 2008 Linpro AS
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 */

/**
 * Actions regarding a user and its profile is controlled from this
 * class - like registering and updating a user, getting a new password, etc.
 *
 * PHP version 5
 * 
 * @author    June Henriksen <juneih@linpro.no>
 * @author    Ole Petter Wikene <olepw@linpro.no>
 * @author    Kjell-Magne Oierud <kjellm@linpro.no>
 * @copyright 2008 Linpro AS
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 */
class profileActions extends sfActions
{
 
  /**
   * Add url to a users resource list and return message.
   *
   * @return void
   */
  public function executeAddResource()
  {
    $this->forward404Unless($this->getUser()->isAuthenticated() && $this->getUser()->hasCredential('addresources'));
    //Security: display if ajax, and the logged in user is admin or own the mypage
    if (!$this->getRequest()->isXmlHttpRequest())
    {
      //User shouldn't be here
      die();
    }    
    $user           = $this->getRequestParameter('user');
    $logged_in_user = $this->getUser()->getGuardUser()->getId();
    $url            = $this->getRequestParameter('resource_url');

    $this->forward404Unless(($user&&$user==$logged_in_user)||($user&&$this->getUser()->hasCredential('editprofile')));
    

    UserResourcePeer::addResource($user, $url);
    
    sfLoader::loadHelpers(array('Partial'));    
    return $this->renderText(get_component('profile', 'resources', array('user' => $user) ));                              
  }
  
  /**
   * Remove a resource 
   *
   * @return unknown
   */
  public function executeRemoveResource()
  {
    $this->forward404Unless($this->getUser()->isAuthenticated() && $this->getUser()->hasCredential('addresources'));
    //Security: display if ajax, and the logged in user is admin or own the mypage
    if (!$this->getRequest()->isXmlHttpRequest())
    {
      //User shouldn't be here
      die();
    }
    $user           = $this->getRequestParameter('user');
    $logged_in_user = $this->getUser()->getGuardUser()->getId();
    
    $this->forward404Unless(($user&&$user==$logged_in_user)||($user&&$this->getUser()->hasCredential('editprofile')));

    //delete resource
    $c = new Criteria();
    $c->add(UserResourcePeer::ID, $this->getRequestParameter('resourceid'));
    UserResourcePeer::doDelete($c);
    
    //reload component 
    sfLoader::loadHelpers(array('Partial'));    
    return $this->renderText(get_component('profile', 'resources', array('user' => $user) ));
    
  }
  
  /**
   * Display page resources page. This is needed to display error messsages. Validation doesn't
   * work with components.
   *
   * @return void
   */
  public function executeResources()
  {    
    $this->user = $this->getRequestParameter('user');
  }
  
  /**
   * Handle validation errors when adding a resource
   *
   * @return void
   */
  public function handleErrorAddResource()
  {
    
    $params = $this->getContext()->getController()->convertUrlStringToParameters($this->getRequestParameter('sf_comment_referer'));

    foreach ($params[1] as $param => $value)
    {
      $this->getRequest()->setParameter($param, $value);
    }
    $this->getResponse()->setStatusCode(500);
   
    $this->forward('profile', 'resources');
  }
  
  /**
   * We want to edit both the login and profile information at the same time,
   * so we collect both for registerSuccess template.
   * 
   * @return void
   */	
  public function executeRegister()
  {    
    $this->redirectUnless(!$this->getUser()->isAuthenticated(), '@profile'); 
    $this->sf_guard_user   = new sfGuardUser();
    $this->residence_array = ResidencePeer::getResidenceLevel();
  }
  
  /**
   * In order to display the form again with error messages we have to 
   * override the error handling.
   * 
   * @return void
   */
  public function handleErrorUpdate()
  {
    $this->forward('profile', 'edit'); 
  }
  
  /**
   * In order to display the form again with error messages we have to 
   * override the error handling.
   * 
   * @return void
   */ 
  public function handleErrorCreate() 
  {
    $this->redirectIf($this->getUser()->isAuthenticated(), '@profile');
    $this->redirectIf($this->getRequest()->getMethod() != sfRequest::POST, '@register');
    
    $this->forward('profile', 'register');
  }
  
  /**
   * We want to edit both the login and profile information at the same time,
   * so we collect both for editSuccess template.
   * 
   * @return void 
   */
  public function executeEdit()
  {
  	$this->redirectUnless($this->getUser()->isAuthenticated(), '@register');
    if ($this->getUser()->hasCredential('editprofile') && $this->getRequestParameter('id') != '')
    {
      $user_id = $this->getRequestParameter('id');
    }
    else
    {
      $user_id = $this->getUser()->getGuardUser()->getId(); 
    }
    
    if ($this->getFlash('issaved'))
    {
    	$this->issaved = true;
    }
    else
    {
    	$this->issaved = false;
    }
    
    $user_interests = UserInterestPeer::retrieveByUser($user_id);
    $interests = array();
    if($user_interests)
    {
      $this->user_interests= $user_interests;
      foreach($user_interests as $user_interest)
      {
      	$id = $user_interest->getSubreaktorId();
        $interests[$id] = $id;
      }
    }
    $this->interests     = $interests;
    $this->sf_guard_user = sfGuardUserPeer::retrieveByPk($user_id);
    $this->forward404Unless($this->sf_guard_user);
    if ($this->getRequestParameter('revert_email') == 'yes')
    {
      $this->sf_guard_user->setNewEmail('');
      $this->sf_guard_user->setNewEmailKey('');
      $this->sf_guard_user->save();
    }
    $this->catalogue = CataloguePeer::getSelectArr();
    $this->cat_default = $this->sf_guard_user->getCulture();
    $this->residence_array = ResidencePeer::getResidenceLevel();
  }

  /**
   * Create a new user and send an e-mail for validation.
   * 
   * @return void
   */
  public function executeCreate()
  {    
    $sf_guard_user = new sfGuardUser();
    $sf_guard_user->registerUser($this);
 
    // 
    // Create and send e-mail
    //
    global $mail_data;
    $mail_data = array('user' => $sf_guard_user);
    $raw_email = $this->sendEmail('mail', 'sendActivationEmail');
    $this->logMessage($raw_email, 'debug');
    
    //We've set up a goal at Google Analytics in order to track if users manage to register.
    //This will help identify if the user is successful
    $this->getTracker()->setPageName('/profile/thankyou', array(
        'use_flash' => true,
      ));
    $this->newUser = $sf_guard_user;
  }
   
  public function validateCreate()
  {
    $userDate=$this->getRequestParameter("dob");
    $currentDate = getdate();

    if(
	((int)$userDate['month']>$currentDate['mon'] && (int)$userDate['year']>=$currentDate['year']) ||
	((int)$userDate['month']==$currentDate['mon'] && (int)$userDate['day']>$currentDate['mday'] && (int)$userDate['year']==$currentDate['year']) 
	) {
        $this->getRequest()->setError("dob", "Date is not correct");
        return false;
        }
  return true;
  }

 
  /**
   * Update user and redirect to the same profile page.
   *
   * @return void
   */
  public function executeUpdate()
  {
    $sf_guard_user = sfGuardUserPeer::retrieveByPk($this->getRequestParameter('id'));
    $this->forward404Unless($sf_guard_user);
    $sf_guard_user->setNeedProfileCheck(0);
    $sf_guard_user->setDobIsDerived(0);
    $sf_guard_user->updateUser($this);
    $this->setFlash('issaved', true);
    $this->redirect(Subreaktor::addSubreaktorToRoute('@otherprofile?id='.$this->getRequestParameter('id')));
  }

  public function validateUpdate()
  {

    $userDate=$this->getRequestParameter("dob");
    $currentDate = getdate();


    if(
        ((int)$userDate['month']>$currentDate['mon'] && (int)$userDate['year']>=$currentDate['year']) ||
        ((int)$userDate['month']==$currentDate['mon'] && (int)$userDate['day']>$currentDate['mday'] && (int)$userDate['year']==$currentDate['year']) 
        ) {
    		$this->getRequest()->setError("dob", "Date is not correct");
		return false;
	}

    if ($this->getRequest()->getMethod() != sfRequest::POST)
    {
      return true;
    }

    /* the `email` is semi-required. Only when new_email is not in use */
    $user = sfGuardUserPeer::retrieveByPk($this->getRequestParameter('id'));
    if ($this->getRequestParameter("email") == $user->getEmail())
    {
      return true;
    }

    if ($this->getRequestParameter("new_email") == $user->getNewEmail()) {
      return true;
    }

    if ($this->getRequestParameter("email") == "")
    {
      if ($this->getRequestParameter("new_email") != "")
      {
        return true;
      }

      $this->getRequest()->setError("email", "Please enter an email address");
      return false;
    }


    /* Everything else has been validated via Validation filters */
    return true;
  }

  /**
   * Activate user given key, and redirect according to success or not.
   * TODO: format 404 template to show error message
   * 
   * @return void
   */
  public function executeActivate()
  {  	  	
    $sf_guard_user = sfGuardUserPeer::retrieveBySalt($this->getRequestParameter('key'));
    
    
    $this->forward404Unless($sf_guard_user);
    $this->forwardIf(@$this->getUser()->isAuthenticated(), 'home','index');
    $this->changed_email = false;

    $this->redirectIf($sf_guard_user->getIsVerified(), '@home');
    
    $sf_guard_user->activateUser($this);
    $this->newUser = $sf_guard_user;
  }
  
  /**
   * Ajax function for checking availability of a username on the registration form
   *
   * @return null
   */
  public function executeCheckUsername()
  {
    $username = $this->getRequestParameter('username');
  	$retval   = '';
  	$image    = "cancel.png";
  	
  	if (trim($username) == '')
  	{
  		$retval  = sfContext::getInstance()->getI18N()->__('Please enter a username');
  	}
  	elseif (strlen($username) < 3)
  	{
  		$retval = sfContext::getInstance()->getI18N()->__('Please enter a longer username');
  	}
    elseif (strlen($username) > 30)
    {
      $retval = sfContext::getInstance()->getI18N()->__('Please enter fewer than 30 characters');
    }
    elseif (!preg_match('/^([A-Za-z0-9@_-\søåæäöØÅÆÖÄ])+$/', $username))
    {
    	$retval = sfContext::getInstance()->getI18N()->__('Only letters (A-Å), numbers, and -_@ are valid characters');
    }
    elseif ($this->getUser()->isAuthenticated() && $this->getUser()->getGuardUser()->getUsername() == $username)
    {
    	$retval = sfContext::getInstance()->getI18N()->__('Username availability will be displayed here');
    	$image = "karakter_gronn.gif";
    }
    else
    {
    	$crit = new Criteria();
    	$crit->add(sfGuardUserPeer::USERNAME, $username);
    	if (sfGuardUserPeer::doCount($crit) > 0)
    	{
    		$retval = sfContext::getInstance()->getI18N()->__('This username is unavailable');
    	}
    	else
    	{
    		$retval = sfContext::getInstance()->getI18N()->__('This username is available');
    		$image = "accept.png";
    	}
    }
    $output = json_encode(array("image" => $image, "message" => $retval));
    $this->getResponse()->setHttpHeader("X-JSON", '('.$output.')');
    
    return sfView::HEADER_ONLY;
  }

  /**
   * Change e-mail 
   * 
   * @return void
   */
  public function executeChangeemail()
  {       
    $this->changed_email = false;
    $this->already_changed = false;

    $sf_guard_user = sfGuardUserPeer::retrieveBySalt($this->getRequestParameter('key'));
    $this->forward404Unless($sf_guard_user, 'This user does not exist');

    if ($sf_guard_user->getNewEmailKey() == $this->getRequestParameter('new_email_key') && $sf_guard_user->getNewEmail() != '')
    {
      $this->changed_email = true; 
      $sf_guard_user->setEmail($sf_guard_user->getNewEmail());
      $sf_guard_user->setNewEmail('');
      $sf_guard_user->setNewEmailKey('');
      $sf_guard_user->save();
    }
    elseif (!$sf_guard_user->getNewEmailKey())
    {
      $this->already_changed = true;
    }
  }
      
  /**
   * In order to display the form again with error messages we have to 
   * override the error handling.
   * 
   * @return void
   */
  public function handleErrorPasswordSend()
  {
    sfLoader::loadHelpers(array('Partial'));
    return $this->renderText(get_partial('profile/passRequest'));
  }
  
  public function executeChangePassword()
  {
  	$this->verified = false;
    $this->error = '';
    $this->verifyerror = '';
    $this->passworderror = false;
    $this->passwordupdated = false;
    $this->forgot = false;
  	if ($this->getUser()->isAuthenticated())
  	{
  		$this->user = $this->getUser()->getGuardUser();
  		$this->key = 0;
  	}
  	else
  	{
      $this->forgot = true;
  		$c = new Criteria();
  		$c->add(sfGuardUserPeer::NEW_PASSWORD_KEY, $this->getRequestParameter('key'));
  		$c->add(sfGuardUserPeer::USERNAME, $this->getRequestParameter('username'));
  		$this->user = sfGuardUserPeer::doSelectOne($c);
  		$this->key = $this->getRequestParameter('key');
  		if (!$this->user instanceof sfGuardUser)
  		{
  			$this->error = 'Invalid key';
  		}
      elseif ($this->user->getKeyExpires("U") < $_SERVER["REQUEST_TIME"])
      {
        $this->error = $this->getContext()->getI18n()->__('Key expired');
      }
  	}
  	if ($this->getRequestParameter('verify') != '')
  	{ 
  		$this->verifyerror = $this->getContext()->getI18n()->__('The information you provided was not correct');
  		if ($this->getUser()->isAuthenticated())
  		{
  			$current_pass_md5 = $this->getUser()->getGuardUser()->getPassword();
  			$this->user->setPassword($this->getRequestParameter('current_pass'));
  			$new_pass_md5 = $this->getUser()->getGuardUser()->getPassword();
			$usr = sfGuardUserPeer::retrieveByUsername($this->getUser()->getUserName());
      			if ($usr->checkPassword($this->getRequestParameter('current_pass')) || $usr->getIsActive() == 0 )
  			{
  				$this->verified = true;
  				$this->setFlash('isverified', true);
  			}
  			elseif ($this->getFlash('isverified') == true)
  			{
  				$this->setFlash('isverified', true);
  				$this->verified = true;
  			}
  		}
  		else
  		{
  				$this->verified = true;
  		}
  	}
  	if ($this->verified)
  	{
  		if ($this->getRequestParameter('updatepassword') != '')
  		{
  			if ($this->getRequestParameter('new_password1') != '' && $this->getRequestParameter('new_password1') == $this->getRequestParameter('new_password2'))
  			{
  				$this->passwordupdated = true;
  				$this->user->setPassword($this->getRequestParameter('new_password1'));
  				$this->user->setNewPasswordKey(null);
  				$this->user->save();
  				$this->setFlash('isverified', false);
  			}
  			else
  			{
  				$this->passworderror = true;
  			}
  		}
  	}
  }
  
  /**
   * Handles the sending of new password via email
   * 
   * @return null
   */
  public function executePasswordSend()
  {
    $thisUser = sfGuardUserPeer::retrieveByEmail($this->getRequestParameter('toemail'));

    // We'll need this to render the partials later on
    sfLoader::loadHelpers(array('Partial'));

    //Simple validation
    if (!$thisUser)
    {
      $this->getRequest()->setError('toemail', 'User not found');
      return $this->renderText(get_partial('profile/passRequest'));
    }

   
    $raw = $this->sendEmail('mail', 'sendPasswordEmail');
    $this->logMessage($raw, 'debug');

    // Render the original partial (this is an ajax request so the least overhead the better)
    return $this->renderText(get_partial('profile/passRequest', array("sentOk" => true)));

  }

  /**
   * Display mypage 
   *
   * @return void
   */
  function executeMyPage()
  {
    
    $this->forward404Unless($this->getUser()->isAuthenticated() );
    $user           = $this->getRequestParameter('user');    
    $logged_in_user = $this->getUser()->getGuardUser()->getUsername();
    
    $this->forward404Unless(($user&&$user==$logged_in_user)||($user&&$this->getUser()->hasCredential('editprofile')));
    $this->user = sfGuardUserPeer::getByUsername($this->getRequestParameter('user'));
    $this->forward404Unless($this->user);
    
    if ($this->getUser()->hasCredential("manageusercontent") && $this->getUser()->getId() != $this->user->getId())
    {
      $this->contentRoute = "user_content"; 
    }
    else
    {
      $this->contentRoute = "my_content";
    }
  }
  
  /**
   * Display portfolio page
   *
   * @return void
   */
  function executePortfolio()
  {
    if ($this->hasRequestParameter('user'))
    {
      $this->user = sfGuardUserPeer::getByUsername($this->getRequestParameter('user'));
      $this->forward404Unless($this->user);

      $this->blocked_profile = (!$this->user->getShowContent()) ? true : false;
      if ($this->user->getId() == $this->getUser()->getId() || $this->getUser()->hasCredential('viewallcontent'))
      {
      	$this->blocked_profile = false;
      }
      $this->page = $this->getRequestParameter('page');
      $this->orderBy = $this->getRequestParameter('orderby');
    } 
    else
    { 
      $this->forward('profile','portfolio?user='.$this->getUser()->getUsername());
    }
   
  }
  
  function executeListMatchingUsers()
  {
    $this->forward404Unless($this->getUser()->isAuthenticated());
    //Security: display if ajax, and the logged in user is admin or own the mypage
    if (!$this->getRequest()->isXmlHttpRequest())
    {
      //User shouldn't be here
      die();
    }
    $user           = $this->getRequestParameter('user_id');
    $all            = $this->getRequestParameter('all');
    $logged_in_user = $this->getUser()->getGuardUser()->getId();
    
    
    $this->forward404Unless(($user&&$user==$logged_in_user)||($user&&$this->getUser()->hasCredential('editprofile')));
    
    //reload component 
    sfLoader::loadHelpers(array('Partial'));    
        
    return $this->renderText(get_component('profile', 'matchingInterests', array('user_id' => $user, 'all'=>$all)));
  }
  
  
}
