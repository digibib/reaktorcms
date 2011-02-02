<?php
/**
 * Components used for messaging
 *
 * PHP version 5
 *
 * @author    olepw <olepw@linpro.no>
 * @copyright 2008 Linpro
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 *
 */

/**
 * Components used for messaging
 * 
 * PHP version 5
 *
 * @author    olepw <olepw@linpro.no>
 * @copyright 2008 Linpro
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 */
class messagingComponents extends sfComponents
{

  public function executeSendMessageForm()
  {
    
  }
  
  public function executeMessageCounter()
  {
    if (!isset($this->count))
    {
      $messages = MessagesPeer::getAllMessages($this->getUser()->getGuardUser()->getId());
      $this->newMessagesCount = 0;
      foreach ($messages as $message)
      {
        if (!$message->getIsRead())
        {
          $this->newMessagesCount++;
        }
      }
    }
    else
    {
      $this->newMessagesCount = $this->count;
    }
  }

  public function executeMessagesSummary()
  {
    $this->readMessagesCount = 0;
    $this->newMessagesCount = 0;
    $this->archiveMessagesCount = 0;
    
    $this->messages = MessagesPeer::getAllMessages($this->getUser()->getGuardUser()->getId());
    foreach ($this->messages as $message)
    {
      if (!$message->getIsRead())
      {
        $this->newMessagesCount++;
      }
      elseif ($message->getIsDeleted($this->getUser()->getGuardUser()->getId()))
      {
        $this->archiveMessagesCount++;
      }
      else
      {
        $this->readMessagesCount++;
      }
    }
    $c = new Criteria();
    $c->add(MessagesIgnoredUserPeer::USER_ID, $this->getUser()->getGuardUser()->getId());
    $res = MessagesIgnoredUserPeer::doSelectJoinsfGuardUserRelatedByIgnoresUserId($c);
    $this->ignoredusers = array();
    if (!empty($res))
    {
	    foreach ($res as $row)
	    {
	    	$this->ignoredusers[] = array('id' => $row->getIgnoresUserId(), 'username' => $row->getsfGuardUserRelatedByIgnoresUserId()->getUsername());
	    }
    }
    $this->hasignored = (count($this->ignoredusers) > 0) ? true : false;
  }
  
}

?>
