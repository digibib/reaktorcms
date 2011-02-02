<?php

/**
 * adminmessage actions.
 *
 * @package    reaktor
 * @subpackage adminmessage
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 2288 2006-10-02 15:22:13Z fabien $
 */
class adminmessageActions extends autoadminmessageActions
{
   /**
    * We want to author of the messag to always be the logge in user
    * so we set it here. 
    * 
    * @return void
    */
   protected function updateAdminMessageFromRequest()
   {
     $this->admin_message->setAuthor($this->getUser()->getGuardUser()->getId());
     
     //Let symfony handle the other fields
     parent::updateAdminMessageFromRequest();
             
   }
  
}
