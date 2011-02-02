<?php

/**
 * Subclass for performing query and update operations on the 'admin_message' table.
 *
 * 
 *
 * @package lib.model
 */ 
class AdminMessagePeer extends BaseAdminMessagePeer
{
   
  /**
   * Get next message due to expire using the expires_at field.
   *
   * @return AdminMessage|null 
   */
  public static function getNextMessageDueToExpire()
  {
    $c = new Criteria();
    
    $c->add(parent::EXPIRES_AT, strtotime('now'), Criteria::GREATER_THAN);
    
    $c->addAscendingOrderByColumn(parent::EXPIRES_AT);
    
    return parent::doSelectOne($c);
  }

}
