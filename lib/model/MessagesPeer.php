<?php

/**
 * Subclass for performing query and update operations on the 'messages' table.
 *
 * 
 *
 * @package lib.model
 */ 
class MessagesPeer extends BaseMessagesPeer
{
  public static function sendMessage($to_id,$from_id,$subject,$body,$reply)
  {
    $message = new Messages();
    $message->setToUserId($to_id);
    $message->setFromUserId($from_id);
    $message->setSubject($subject);
    $message->setMessage($body);
    $message->setTimestamp(time());
    $message->setReplyTo($reply);
    
    // check if the recipient has blocked the sender - if so, 
    // just set the ignored flag on the message
    $c = new Criteria();
    $c->add(MessagesIgnoredUserPeer::IGNORES_USER_ID, $from_id);
    $c->add(MessagesIgnoredUserPeer::USER_ID, $to_id);
    $res = MessagesIgnoredUserPeer::doCount($c);
    if ($res > 0)
    {
      $message->setIsIgnored(true);
    }
    $message->save();
  }
  
  public static function getMessagesByAge($time,$to_id=null,$from_id=null)
  {
    $c = new Criteria();
    $c->add(MessagesPeer::TIMESTAMP,time()-$time,Criteria::GREATER_THAN);
    return self::doSelect($c);
    
  }
  
  public static function getAllMessages($user_id)
  {
    $c = new Criteria();
    $crit0 = $c->getNewCriterion(MessagesPeer::TO_USER_ID, $user_id);

    $crit2 = $c->getNewCriterion(MessagesPeer::DELETED_BY_FROM, $user_id, Criteria::ALT_NOT_EQUAL);
    $crit3 = $c->getNewCriterion(MessagesPeer::DELETED_BY_TO, $user_id, Criteria::ALT_NOT_EQUAL);

    $crit0->addAnd($crit2);
    $crit0->addAnd($crit3);

    $c->add($crit0);

    // Ignore "ignored" messages
    $c->add(self::IS_IGNORED, 0);
    
    $c->addDescendingOrderByColumn(MessagesPeer::TIMESTAMP);
    return self::doSelectJoinsfGuardUserRelatedByFromUserId($c);
  }
  
  public static function markAsRead($message_id)
  {
    $msg = self::retrieveByPK($message_id);
    $msg->setIsRead(1);
    $msg->save();
  }

  /*
  public static function markAsDeleted($message_id)
  {
    $msg = self::retrieveByPK($message_id);
    //$msg->setIsDeleted(1);
    $msg->save();
  }
  */
  
  /*
  public static function markAsRestored($message_id)
  {
    $msg = self::retrieveByPK($message_id);
    //$msg->setIsDeleted(0);
    $msg->save();
  }
  */
  
  public static function getMessagesPaginated($user_id)
  {
    $c = new Criteria();
    $crit0 = $c->getNewCriterion(MessagesPeer::TO_USER_ID, $user_id);
    $crit1 = $c->getNewCriterion(MessagesPeer::FROM_USER_ID, $user_id);

    // Perform OR at level 1 ($crit0 $crit1 )
    $crit0->addOr($crit1);
    $crit2 = $c->getNewCriterion(MessagesPeer::DELETED_BY_FROM, $user_id, Criteria::ALT_NOT_EQUAL);
    $crit3 = $c->getNewCriterion(MessagesPeer::DELETED_BY_TO, $user_id, Criteria::ALT_NOT_EQUAL);

    // Perform AND at level 0 ($crit0 $crit2 $crit3 )
    $crit0->addAnd($crit2);
    $crit0->addAnd($crit3);

    $c->add($crit0);

  	$c->addDescendingOrderByColumn(MessagesPeer::TIMESTAMP);
  	$pager = new sfPropelPager('Messages', 10);
    $pager->setCriteria($c);
    return $pager;
   
  }
 
 
 public static function getMySentMessages($user_id)
  {
  	$c = new Criteria();
  	$c->add(MessagesPeer::FROM_USER_ID, $user_id);
  	$c->addDescendingOrderByColumn(MessagesPeer::TIMESTAMP);
  	return MessagesPeer::doSelect($c);
   
  }
  
}
