<?php
/**
 * Components for admin system messages
 *
 * PHP version 5
 *
 * @author    juneih <juneih@linpro.no>
 * @copyright 2008 Linpro
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 *
 */

/**
 * Components for admin system messages
 * 
 * PHP version 5
 *
 * @author    juneih <juneih@linpro.no>
 * @copyright 2008 Linpro
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 */
class adminmessageComponents extends sfComponents
{
  /**
   * Get the next message due to expire and display it in the sidebar. 
   * All admin messages have a date on them saying when they expire, and 
   * this is used to decide which message is next. 
   *  
   * This should only be used in special cases, i.e when the system
   * has to be taken down for a short period of time. Consider sending a 
   * message to all users using the flash messaging system before using this. 
   * 
   * This message cannot be translated, because it is intended to be as
   * simple as possible.
   *
   * @return void
   */
  function executeNextMessageDueToExpire()
  {    
    $this->admin_message = AdminMessagePeer::getNextMessageDueToExpire();   
  }
}