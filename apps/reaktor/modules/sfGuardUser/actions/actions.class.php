<?php
/**
 * sfGuardUser actions
 *  
 * PHP version 5
 * 
 * @author    Daniel Andre Eikeland <dae@linpro.no>
 * @author    Ole-Petter Wikene <olepw@linpro.no>
 * @copyright 2008 Linpro AS
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 */
require_once SF_ROOT_DIR . DIRECTORY_SEPARATOR . 'plugins/sfGuardPlugin/modules/sfGuardUser/lib/BasesfGuardUserActions.class.php';

class sfGuardUserActions extends BasesfGuardUserActions
{
  /**
   * Send mail to user  
   *
   * @param integer $db_user
   */
  public function sendAdminMail($db_user)
  {
    // 
    // Create and send e-mail
    //
    
    global $mail_data;
    $mail_data = array('user' => $db_user,
                       'password' => $this->getRequestParameter('sf_guard_user[password]'));
    $raw_email = $this->sendEmail('mail', 'sendProfileRegisteredByAdmin');
    $this->logMessage($raw_email, 'debug');

  }
  
  public function sendActivationEmail($sf_guard_user)
  {
    // 
    // Create and send e-mail
    //
    
    global $mail_data;

    $mail_data = array('user' => $sf_guard_user,
                       'password' => "tjall");//$this->getRequestParameter('password_profile'));
    $raw_email = $this->sendEmail('mail', 'sendActivationEmail');
    $this->logMessage($raw_email, 'debug');
    
  }
  
  /**
   * Overriding the action used by the admin generator to process user lists
   * Added automatic wildcards so searching for "monkey" will now find "monkeyboy" automatically
   * 
   * @return null
   */
  public function executeList()
  {
    //Add fields to auto-wildcard to this list
    $wildcardFields  = array("username");
    $originalFilters = array();
    
    if ($filters = $this->getRequestParameter("filters"))
    {
      $originalFilters = $filters;
      
      foreach ($wildcardFields as $fieldName)
      {
        // Only add the wildcards if the user is not already using them
        if (strpos($filters[$fieldName], "*") === false)
        {
          $filters[$fieldName]  = "*".$filters[$fieldName]."*";
        }
      }
      $this->getRequest()->getParameterHolder()->set("filters", $filters);
      
    }
    parent::executeList();
    //  Set the filters back to their original values before the template is rendered
    $this->filters = $originalFilters;
    
  }
  
  /**
   * Redirect the user to comment list view for this user
   * This is the only way I can see that we can generate a link via a generated admin
   * page, but it works and is clean enough.
   * 
   * @return void
   */
  public function executeListComments()
  {
    $this->redirect("@commentsbyuser?user_id=".$this->getRequestParameter("id"));
  }
  
  public function executeListUsers()
  {
    $exclude = sfConfig::get("app_userlist_exclude", array());
    // Autocomplete usernames
    if ($this->getRequest()->isXmlHttpRequest())
    {
      $chars = $this->getRequestParameter("message_to");
      if (!$chars)
      {
        $chars = $this->getRequestParameter("startingwith");
        if (!$chars)
        {
          return;
        }
      }

      $output = "";
      foreach((array)sfGuardUserPeer::getUsernamesStartingWith($chars) as $user)
      {
        if (!in_array($user->getUsername(), $exclude))
        {
          $output .= "<li>" . $user->getUsername() . "</li>";
        }
      }
      return $this->renderText("<ul>$output</ul>");
    }

    $this->users = array();
    $startingwith = '';
    $startingwith = $this->getRequestParameter('startingwith', '');
    if ($startingwith == '')
    {
    	$startingwith = $this->getRequestParameter('tag', '');
    }
  	if ($startingwith)
  	{
  	  $this->users = sfGuardUserPeer::getUsernamesStartingWith($startingwith, -1);
  	}

    foreach ($this->users as $k =>$user)
    {
      if (in_array($user->getUsername(), $exclude))
      {
        unset($this->users[$k]);
      }
    }
  	
  	$this->startingwith = $startingwith;
  }

  /**
   * Redirect the admin user to portfolio for this user
   * 
   * @return void
   */
  public function executeShowPortfolio()
  {
  	$this->redirect("@portfolio?user=".sfGuardUserPeer::retrieveByPK($this->getRequestParameter("id"))->getUsername());
  }
  
  /**
   * Redirect the admin user to the content manage page for this user
   *
   * @return null
   */
  public function executeShowUserContent()
  {
    $this->redirect("@user_content?mode=menu&user=".sfGuardUserPeer::retrieveByPK($this->getRequestParameter("id"))->getUsername());
  }
  
  public function executeEdit()
  {
  	if (!($this->getRequestParameter('id') == '' || $this->getUser()->hasCredential('edituser')))
    {
    	sfActions::forward('sfGuardUser', 'list');
    }
  	$this->sf_guard_user = $this->getsfGuardUserOrCreate();
  	$sendnotify_email = ($this->sf_guard_user->getId() != '') ? false : true;
    
    if ($this->getRequest()->getMethod() == sfRequest::POST)
    {
      $this->updatesfGuardUserFromRequest();
      
      
      $this->savesfGuardUser($this->sf_guard_user);
      
      if (!$this->getUser()->hasCredential('editprofile'))
      {
        $this->sendActivationEmail($this->sf_guard_user);
        $this->sf_guard_user->setIsActive(false);
        $this->sf_guard_user->save();
        $this->setTemplate('newuser');
      }
      else
      {
        if ($sendnotify_email) $this->sendAdminMail($this->sf_guard_user);
      
        $this->setFlash('notice', 'Your modifications have been saved');
      	if ($this->getRequestParameter('save_and_add'))
	      {
	      	return $this->redirect('sfGuardUser/create');
	      }
	      else if ($this->getRequestParameter('save_and_list'))
	      {
	        return $this->redirect('sfGuardUser/list');
	      }
	      else
	      {
	        return $this->redirect('sfGuardUser/edit?id='.$this->sf_guard_user->getId());
	      }
      }
    }
    else
    {
      $this->labels = $this->getLabels();
    }
  }
  
  public function validateEdit()
  {
    if ($this->getRequest()->getMethod() == sfRequest::POST && !$this->getRequestParameter('id'))
    {   
      if ($this->getRequestParameter('sf_guard_user[password]') == '' || $this->getRequestParameter('sf_guard_user[password_bis]') == '')
      {
        $this->getRequest()->setError('sf_guard_user{password}', 'Password is mandatory');
        $this->getRequest()->setError('sf_guard_user{password_bis}', 'Don\'t forget to verify the password');
        return false;
      }
    }
    return true;
  }

  protected function savesfGuardUser($sf_guard_user)
  {
    // We have to execute the parent first, it drops all the permissions
    $retval = parent::savesfGuardUser($sf_guard_user);

    if ($this->getUser()->hasCredential('editprofile'))
    {
      $ids = $this->getRequestParameter('unassociated_permissions');
      if (is_array($ids))
      {
        foreach ($ids as $id)
        {
          $SfGuardUserPermission = new sfGuardUserPermission();
          $SfGuardUserPermission->setUserId($sf_guard_user->getPrimaryKey());
          $SfGuardUserPermission->setPermissionId($id);
          $SfGuardUserPermission->setExclude(1);
          $SfGuardUserPermission->save();
        }
      }
    }
    return $retval;
  }
 
}

