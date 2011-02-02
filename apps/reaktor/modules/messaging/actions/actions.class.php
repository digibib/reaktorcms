<?php
/**
 * Actions used for messaging
 *
 * PHP version 5
 *
 * @author    olepw <olepw@linpro.no>
 * @copyright 2008 Linpro
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 *
 */

/**
 * actions used for messaging
 * 
 * PHP version 5
 *
 * @author    olepw <olepw@linpro.no>
 * @copyright 2008 Linpro
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 */
class messagingActions extends sfActions
{
  /**
   * action used for sending messages
   * 
  */
  public function executeSendMessageAction()
  {
    $this->forward404Unless($this->getUser()->isAuthenticated() && $this->getRequest()->isXmlHttpRequest() && $this->getUser()->hasCredential('sendmessages'));

    //TODO: isn't really necessary to duplicate the message when sending to all users
    if($this->getRequestParameter('send_to_all'))
    {      
      $all_users = sfGuardUserPeer::getAllActiveUsers();
      foreach ($all_users as $user)
      {
        MessagesPeer::sendMessage($user->getId(),$this->getUser()->getGuardUser()->getId(),$this->getRequestParameter('message_subject'),$this->getRequestParameter('message_body'),$this->getRequestParameter('reply_to'));
      }
      $this->to = true;
      $this->duplicated = false;
    }
    else
    {
      $this->to = sfGuardUserPeer::getByUsername($this->getRequestParameter('message_to'));
      $this->duplicated = 0;
      if ($this->to)
      {
        //make sure message is not sent twice. Don't allow a user to sent a new message to that user within 30 seconds or so...              	
        $this->duplicated = MessagesPeer::getMessagesByAge(0,$this->to->getId(),$this->getUser()->getGuardUser()->getId());
        if (!$this->duplicated)
        {
        	MessagesPeer::sendMessage($this->to->getId(),$this->getUser()->getGuardUser()->getId(),$this->getRequestParameter('message_subject'),$this->getRequestParameter('message_body'),$this->getRequestParameter('reply_to'));
        }
      }
    }
  }
  
  /**
   * action used for marking messages as read
   * 
  */
  
  public function executeMarkMessageRead()
  {
    if ($this->getUser()->isAuthenticated())
    {
  	  MessagesPeer::markAsRead($this->getRequestParameter('id'));
    }
  }

  /**
   * action used for deleting a message
   * 
  */
  
  public function executeDeleteMessage()
  {
    if ($this->getUser()->isAuthenticated())
    {
      $user_id = $this->getUser()->getGuardUser()->getId();
      $m = MessagesPeer::retrieveByPK($this->getRequestParameter('id'));
      if ($m->getFromUserId() == $user_id)
      {
        $m->markAsDeletedByFrom();
      }
      elseif ($m->getToUserId() == $user_id)
      {
        $m->markAsDeletedByTo();
      }
      else {
        /* hax0r alert */
        return;
      }
      $m->setIsRead(1);
      $m->save();
    }
  }

  /**
   * action used for restoring a message
   * 
  */
  
  public function executeRestoreMessage()
  {
    if ($this->getUser()->isAuthenticated())
    {
      MessagesPeer::markAsRestored($this->getRequestParameter('id'));
    }
  }
  
  /**
   * action used for periodically update message div 
   * 
  */
  public function executeGetNewMessages()
  {
  
  }

  /**
   * action used for manually updating message counter 
   * 
  */
  public function executeUpdateMessageCounter()
  {
  
  }
  
/**
   * action used for pignoring user
   * 
  */
  public function executeIgnoreUser()
  {
    if ($this->getUser()->isAuthenticated())
    {
    	switch ($this->getRequestParameter('do'))
    	{
    		case 'add':
		      $ignore = new MessagesIgnoredUser();
          $user = sfGuardUserPeer::retrieveByPK($this->getRequestParameter('id'));

          foreach($user->getsfGuardUserGroups() as $group) {
            if (in_array($group->getsfGuardGroup()->getName(), array("admin", "staff"))) {
              return $this->renderText($this->getContext()->getI18N()->__('Sorry, you cannot ignore our staff'));
            }
          }

		      $ignore->setIgnoresUserId($user->getId());
		      $ignore->setUserId($this->getUser()->getGuardUser()->getId());
		      $ignore->save();
          if ($read = $this->getRequestParameter('read'))
          {
            $m = MessagesPeer::retrieveByPK($read);
            if ($m->getToUserId() == $this->getUser()->getGuardUser()->getId())
            {
              $m->setIsRead(1);
              $m->save();
            }
          }
		      $this->forward('messaging','InboxComponent');
    			break;
    		case 'remove':
    			$c = new Criteria();
    			$c->add(MessagesIgnoredUserPeer::IGNORES_USER_ID, $this->getRequestParameter('id'));
    			$c->add(MessagesIgnoredUserPeer::USER_ID, $this->getUser()->getGuardUser()->getId());
    			MessagesIgnoredUserPeer::doDelete($c);
    			return $this->renderText($this->getContext()->getI18N()->__('The user is not ignored'));
    			break;
    	}
    }
  }
  
  /**
  * action used for displaying message inbox page 
  * 
  */
  public function executeMessageInbox()
  {
  	$this->pager = MessagesPeer::getMessagesPaginated($this->getUser()->getGuardUser()->getId());
  	$this->pager->setPage($this->getRequestParameter('page', 1));
    $this->pager->init();
  }
  /*
   * Messagebox inbox doclet
   */
  public function executeInboxComponent() {
    
  }
  
  public function executeMessageContentAjax() {
    $this->messages = MessagesPeer::getAllMessages($this->getUser()->getGuardUser()->getId());
  }
}



?>
