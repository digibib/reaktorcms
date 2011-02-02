<?php

/**
 * Subclass for representing a row from the 'admin_message' table.
 *
 * 
 *
 * @package lib.model
 */ 
class AdminMessage extends BaseAdminMessage
{
  /**
   * Custom field to get the username of who sent the message/updated the message.
   *
   * @return unknown
   */
  public function getSender()
  {
    return $this->getsfGuardUser()->getUsername();
  }
}
