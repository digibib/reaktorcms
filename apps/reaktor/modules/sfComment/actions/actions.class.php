<?php
/**
 * Functionality regarding comments, both for frontend and backend.
 *
 * PHP version 5
 *
 * @author    juneih <juneih@linpro.no>
 * @author    Russ Flynn <russ@linpro.no>
 * @copyright 2008 Linpro
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 */

require_once SF_ROOT_DIR . DIRECTORY_SEPARATOR . 'plugins/sfPropelActAsCommentableBehaviorPlugin/modules/sfComment/lib/BasesfCommentActions.class.php';
require_once SF_ROOT_DIR . DIRECTORY_SEPARATOR . 'lib/model/sfCommentPeer.php';
require_once SF_ROOT_DIR . DIRECTORY_SEPARATOR . 'lib/model/sfComment.php';
require_once SF_ROOT_DIR . DIRECTORY_SEPARATOR . 'apps/reaktor/lib/commentCalendar.class.php';


/**
 * Functionality regarding comments, both for frontend and backend.
 * 
 * PHP version 5
 *
 * @author    juneih <juneih@linpro.no>
 * @copyright 2008 Linpro
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 */
class sfCommentActions extends BasesfCommentActions
{  
	private
    $config,
    $config_user,
    $config_anonymous;
    
  /**
   * Saves a comment, for an authentified user
   */
  public function executeAuthenticatedComment()
  {
    $this->getConfig();
      
    if ((sfContext::getInstance()->getUser()->isAuthenticated() 
         && $this->config_user['enabled'])
         && $this->getRequest()->getMethod() == sfRequest::POST)
    {
      if (!$this->getUser()->hasCredential('postnewcomments'))
      {
        return;
      }
      $token     = $this->getRequestParameter('sf_comment_object_token');
      $object    = sfPropelActAsCommentableToolkit::retrieveFromToken($token);
      $comment   = array('text' => htmlspecialchars(urldecode($this->getRequestParameter('sf_comment'))));      
      $id_method = $this->config_user['id_method'];
      $namespace = $this->getRequestParameter('sf_comment_namespace', null);
      $this->namespace = $namespace;

      $this->validateNamespace($namespace);

      $session = sfContext::getInstance()->getUser();
      $comment['author_id'] = $session->getGuardUser()->getId();
      $comment['namespace'] = $namespace;
       
      //HACK: get callables doesn't include title, this is a temporary fix
      $comment['title']     = htmlspecialchars(urldecode($this->getRequestParameter('sf_comment_title')));
      
      foreach (sfMixer::getCallables('sfCommentActions:addComment:pre') as $callable)
      {      
        call_user_func($callable, $comment, $object);
      }

      $comment_object = $object->addComment($comment);
      $comment_object->setParentId($this->getRequestParameter('comment_parent_id'));
      $comment_object->setEmailNotify($this->getRequestParameter('sf_comment_email_notify'));
      $comment_object->save();
      HistoryPeer::logAction(12, $this->getUser()->getId(), $comment_object);
      
      foreach (sfMixer::getCallables('sfCommentActions:addComment:post') as $callable)
      {
        call_user_func($callable, $comment_object, $object);
      }

      $this->object = $object;

      //get parent to see if we shall notify anyone
      if ($parent_id = $this->getRequestParameter('comment_parent_id'))
      {
        $parent = sfCommentPeer::retrieveByPk($parent_id);
        /*
        * Email: http://www.symfony-project.org/cookbook/1_0/email 
        */
        if ($parent->getEmailNotify())
        {
          global $mail_data;
          $mail_data = array('comment' => $comment_object,
                            'artwork' => $object,
                            'parent' => $parent);
          $raw_email = $this->sendEmail('mail', 'sendCommentNotification');
          $this->logMessage($raw_email, 'debug');
        }
      }

      if (!$this->getContext()->getRequest()->isXmlHttpRequest())
      {
        $this->redirect($this->getRequestParameter('sf_comment_referer'));
      }
    }

    sfLoader::loadHelpers(array('Partial'));
    return $this->renderText(get_component('sfComment', 'commentList', array('object' => $object, 'namespace' => $namespace)).
                             '<a name="_newcomment"></a><div id="comment_new">'.
                             get_component('sfComment', 'commentForm', array('object' => $object, 'namespace' => $namespace)).
                             '</div>');
    //$this->setTemplate('comment');
  }
  
  protected function getConfig()
  {
    $config_anonymous = array('enabled' => true, 
                              'layout'  => array('name' => 'required', 
                                                 'email' => 'required', 
                                                 'title' => 'optional', 
                                                 'comment' => 'required'), 
                              'name'    => 'Anonymous User');
    $config_user = array('enabled'   => true, 
                         'layout'    => array('title' => 'optional', 
                                              'comment' => 'required'), 
                         'table'     => 'sf_guard_user', 
                         'id'        => 'id', 
                         'class'     => 'sfGuardUser', 
                         'id_method' => 'getUserId', 
                         'toString'  => 'toString', 
                         'save_name' => false);

    $this->config_anonymous = sfConfig::get('app_sfPropelActAsCommentableBehaviorPlugin_anonymous', $config_anonymous);
    $this->config_user = sfConfig::get('app_sfPropelActAsCommentableBehaviorPlugin_user', $config_user);

    $config = array('user'             => $this->config_user,
                    'anonymous'        => $this->config_anonymous,
                    'use_ajax'         => sfConfig::get('app_sfPropelActAsCommentableBehaviorPlugin_use_ajax', false),
                    'namespaces'       => sfConfig::get('app_sfPropelActAsCommentableBehaviorPlugin_namespaces', false));
    $this->config = $config;
  }
  
  /**
   * List comments within a period of time
   *
   */
  public function executeListComments()
  {
    $comment_object  = 'ReaktorArtwork';
    $namespace       = 'frontend';
    $this->comments  = array();    
    $this->namespace = $namespace;
    if ($this->getRequestParameter("subreaktor"))
    {
      $subRoute = "subreaktor=".$this->getRequestParameter("subreaktor")."&";
    }
    else
    {
      $subRoute = "";
    }
    
    if ($this->getRequestParameter('username') 
      && $this->getRequestParameter('username') === $this->getUser()->getGuardUser()->getUsername() 
      || $this->getUser()->hasCredential("commentadmin"))
    {
      $this->thisUser = $this->getRequestParameter('username');
      $this->route    = '@'.sfRouting::getInstance()->getCurrentRouteName().'?'.$subRoute.'username='.$this->getRequestParameter('username');
 
      $this->userId = sfGuardUserPeer::getByUsername($this->getRequestParameter('username'));
      $this->comment_pager = sfCommentPeer::getCommentsByUser($this->userId, $comment_object, $namespace, $this->getRequestParameter("page", 1));
    }else 
    {
      $this->forward404();
    }
    
    if ($this->getRequestParameter('user_id'))
    {
     if ($thisUser = sfGuardUserPeer::retrieveByPK($this->getRequestParameter('user_id')))
      {
        $this->thisUser = $thisUser->getUsername();
        $this->route    = '@'.sfRouting::getInstance()->getCurrentRouteName().'?'.$subRoute.'user_id='.$this->getRequestParameter('user_id');
      }
      else
      {
        return $this->forward404();
      }
      $this->comment_pager = sfCommentPeer::getCommentsByUser($this->getRequestParameter('user_id'), $comment_object, $namespace, $this->getRequestParameter("page", 1));
    }
    elseif (!$this->getRequestParameter('username'))
    {
      $date                = $this->getRequestParameter('date') ? $this->getRequestParameter('date') : date('Y-m-d');      
      $this->comment_pager = sfCommentPeer::getCommentsByDate($comment_object, $namespace, $date, $this->getRequestParameter("page", 1));
      $this->date          = date("d/m/Y", strtotime($date));
      $this->route         = '@'.sfRouting::getInstance()->getCurrentRouteName().'?'.$subRoute.'&date='.$this->getRequestParameter('date');
    }
    
    $comments = array();
    
    foreach ($this->comment_pager->getResults() as $comment_object)
    {
      $commentId = $comment_object->getId();
      
      $comment = $comment_object->toArray();
      $comments[$commentId] = $comment;
      $comments[$commentId]["AuthorName"]   = $comment_object->getUser()->getUsername();
      $comments[$commentId]["ArtworkTitle"] = $comment_object->getArtwork()->getTitle();    
      $comments[$commentId]["ArtworkId"]    = $comment_object->getArtwork()->getId();
      $comments[$commentId]['AuthorVisible'] = $comment_object->getUser()->getShowContent();
    }
    
    $this->unsuitable = 0;
    CommentMagick::sortRecursive($comments, $this->comments, -1);
  }

  /**
   * Updates a comment (Ajax request)
   *
   */
  public function executeUnsuitableToggle()
  {
    // Must be an ajax request
    if (!$this->getRequest()->isXmlHttpRequest())
    {
     die();
    }
    
    // Check we have the right details and credentials
    if ($this->getUser()->isAuthenticated() && $this->getUser()->hasCredential("commentadmin"))
    {
      try
      {
        $commentObject = sfCommentPeer::retrieveByPK($this->getRequestParameter("id"));
   
        switch ($this->getRequestParameter("mode"))
        {
          case "remove":
            $newVal = 2;
            break;
          case "restore":
            $newVal = 0;         
        }
        
        $commentObject->setUnsuitable($newVal);
        $commentObject->save();
        
        $comment["Id"]       = $commentObject->getId();
        $comment["Unsuitable"] = $commentObject->getUnsuitable(); 
        
        sfLoader::loadHelpers(array('Partial'));
        return $this->renderText(get_partial('sfComment/adminButtons', array("comment" => $comment)));
      }
      catch (Exception $e)
      {
        return $this->renderText($e->getMessage());
      }
    }
    else
    {
      // No need for nice things - this is a remote request and this user should not be here
      die();
    }
  }
  
  /**
   * Show calendar overview over when comments are made
   *
   * @return void
   */
  public function executeCommentsCalendar()
  {
  	$date             = $this->getRequestParameter('date');
  	$date             = !$date?date('Y-m-d'):$date;  	
    $c                = new commentCalendar('month', $date);
    $calendar         = $c->getEventCalendar();
    $date_array       = explode('-', $date);    
    $this->prev_month = $c->getCalendar()->beginOfPrevMonth($date_array[2],$date_array[1],$date_array[0], '%Y-%m-%d');
    $this->next_month = $c->getCalendar()->beginOfNextMonth($date_array[2],$date_array[1],$date_array[0], '%Y-%m-%d');
    $this->date       = $date;
    $this->calendar   = $calendar;
  }

  /**
   * Flag a comment as reported, ajax request
   *
   * @return unknown
   */
  public function executeReport()
  {
    if(!$this->getRequest()->isXmlHttpRequest())
    {
      die();
    }
    if(!$this->getUser()->isAuthenticated())
    {
      return $this->renderText("Please log in!"); 
    }
    
    $id = $this->getRequestParameter('id');   
    if($id)
    {
      $comment = sfCommentPeer::retrieveByPK($id);
      $comment->setUnsuitable(1);
      $comment->save();
    }
    else 
    {
      return $this->renderText("Fail!"); 
    }
    
    return $this->renderText("OK!"); 
  }
  
  /**
   * List reported comments
   *
   * @return void
   */
  public function executeListReportedComments()
  {
    $this->doUnsuitableList();
  }
  
 /**
   * List unsuitable comments
   *
   * @return void
   */
  public function executeListUnsuitableComments()
  {
    $this->doUnsuitableList(2);
  }
  
  /**
   * Function to remove a lot of code duplication
   * 
   * @param  $unsuitable integer Value to check for in unsuitable column in db
   * @return void
   * 
   */
  protected function doUnsuitableList($unsuitable = 1)
  {
    $comment_object           = 'ReaktorArtwork';
    $this->namespace          = 'frontend';
    $this->comments           = array();         
    $this->date               = $this->getRequestParameter('date') ? $this->getRequestParameter('date') : date('Y-m-d');    
    list($year, $month, $day) = split('[/.-]', $this->date);      
    $this->prev_month         = date('Y-m-d', strtotime('-1 month', strtotime($this->date)));
    $this->next_month         = date('Y-m-d', strtotime('+1 month', strtotime($this->date)));
    $this->comment_pager      = sfCommentPeer::getCommentsByUnsuitableStatus($comment_object, $this->namespace, $this->getRequestParameter("page", 1), $unsuitable);
    //$this->comment_pager      = sfCommentPeer::getCommentsByDate($comment_object, $this->namespace, $year.'-'.$month, $this->getRequestParameter("page", 1), $unsuitable);
    $this->route              = '@'.sfRouting::getInstance()->getCurrentRouteName().'?date='.$this->date;
    
    // Extract the data into an array - one query gives us all the data we need
    foreach ($this->comment_pager->getResults() as $comment_object)
    {
      $commentId = $comment_object->getId();  
      $comment   = $comment_object->toArray();
      
      $comments[$commentId] = $comment;
      $comments[$commentId]['AuthorVisible'] = $comment_object->getUser()->getShowContent();
      $comments[$commentId]["AuthorName"]   = $comment_object->getUser()->getUsername();
      $comments[$commentId]["ArtworkTitle"] = $comment_object->getArtwork()->getTitle();    
      $comments[$commentId]["ArtworkId"]    = $comment_object->getArtwork()->getId();
    }
    if (!empty($comments))
    {
      CommentMagick::sortRecursive($comments, $this->comments, 0, true);
    }   
  }
}

