<?php

/**
 * Subclass for representing a row from the 'messages' table.
 *
 * 
 *
 * @package lib.model
 */ 
class Messages extends BaseMessages
{

/**
 * Checks if the sender of a message is ignored
 *
 * @return integer
 */
  
  public function isIgnored()
  {
    $user = sfContext::getInstance()->getUser()->getGuardUser();
    $c = new Criteria();
    $c->add(MessagesIgnoredUserPeer::IGNORES_USER_ID,$this->getFromUserId());
    $c->add(MessagesIgnoredUserPeer::USER_ID,$user->getId());
    return MessagesIgnoredUserPeer::doCount($c);
    
  }

  /**
   * Retrieves the message length (bytes)
   * 
   * @return int
   */
  public function getMessageLength()
  {
    return strlen($this->getMessage());
  }

  /**
   * Return the message up to $maxlen bytes
   * 
   * @param int $maxlen     The maximum length of the message to return
   * @param bool &$cropped  Set to true when message was cropped
   * @return string         The message
   */
  public function getPartialMessage($maxlen = 0, &$cropped = false)
  {
    $len = $this->getMessageLength();
    if ($maxlen && $len > $maxlen)
    {
      $cropped = true;
      return substr($this->getMessage(), 0, $maxlen);
    }
    return $this->getMessage();
  }

  public function markAsDeletedByFrom()
  {
    parent::setDeletedByFrom($this->getFromUserId());
  }

  public function markAsDeletedByTo()
  {
    parent::setDeletedByTo($this->getToUserId());
  }

  public function getIsDeleted($user_id)
  {
    return $this->getDeletedByTo() == $user_id || $this->getDeletedByFrom() == $user_id;
  }

}

