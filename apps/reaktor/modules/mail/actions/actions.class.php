<?php
/**
 * Mail actions.
 * 
 * PHP Version 5
 *
 * @author    Kjell-Magne Oierud <kjellm@linpro.no>
 * @copyright 2008 Linpro AS
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 * @version   SVN: $Id: actions.class.php 2561 2008-09-18 09:47:23Z bjori $
 */

/**
 * Mail actions.
 * 
 * PHP Version 5
 *
 * @author    Kjell-Magne Oierud <kjellm@linpro.no>
 * @copyright 2008 Linpro AS
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 */
class mailActions extends sfActions
{
  public function preExecute()
  {
    $this->mail = new sfMail();
    $this->mail->setCharset('utf-8');      
     
    $this->fromMail   = sfConfig::get('app_artwork_sender_email');
    $this->fromName   = sfConfig::get('app_artwork_sender');

    $this->mail->setSender($this->fromMail, $this->fromName);
    $this->mail->setFrom($this->fromMail, $this->fromName);
    $this->mail->addReplyTo(sfConfig::get('app_artwork_sender_email'));
 
  }

  /**
   * Sends an email notifiying the artwork creator that a comment to
   * one of her artworks has been posted.
   *
   * Assumes that the global variable mail_data is set and contains
   * artwork and comment objects.
   *
   * @return void
   */
  public function executeSendCommentNotification()
  {
    global $mail_data;

    $this->comment = $mail_data['comment'];
    $this->artwork = $mail_data['artwork'];
    $this->parent = $mail_data['parent'];
   

    // FIX why doesn't $this->artwork->getUser() work?
    $au = sfGuardUserPeer::retrieveByPk($this->parent->getAuthorId());
    $this->mail->addAddress($au->getEmail());
    
     
  }
  
  /**
   * Sends an email notifiication to new users
   * @return void
   */
  public function executeSendActivationEmail()
  {
    global $mail_data;
    
    $this->user = $mail_data['user'];
    $this->url = '@activate?key='.$this->user->getSalt();
    
    $this->mail->addAddress($mail_data['user']->getEmail());
    
  }

  public function executeSendProfileRegisteredByAdmin()
  {
    global $mail_data;
    
    $this->user = $mail_data['user'];
    $this->password = $mail_data['password'];
    $this->mail->addAddress($mail_data['user']->getEmail());
    
    
  }
  
  public function executeSendNewEmailActivation()
  {
    global $mail_data;
    
    $this->mail->addAddress($mail_data['user']->getNewEmail());
    $this->url = '@changeemail?key='.$mail_data['salt'].'&new_email_key='.$mail_data['newEmailKey'];
    $this->oldemail = $mail_data['user']->getEmail();
    $this->newemail = $mail_data['user']->getNewEmail();
    
  }

  public function executeSendNewEmailActivationNotification()
  {
    global $mail_data;
    
    $this->mail->addAddress($mail_data['user']->getEmail());
    $this->url = '@changeemail?key='.$mail_data['salt'].'&new_email_key='.$mail_data['newEmailKey'];
    $this->oldemail = $mail_data['user']->getEmail();
    $this->newemail = $mail_data['user']->getNewEmail();
    
  }

  public function executeEditorialTeamNotification()
  {
    global $mail_data;
    
    foreach ($mail_data['users'] as $user)
    {

    	$this->mail->addAddress($user->getsfGuardUser()->getEmail());
    }
    //$this->mail->addAddress($mail_data['user']->getEmail());
    //$this->mail->addAddress($mail_data['user']->getNewEmail());
    //$this->url = '@changeemail?key='.$mail_data['salt'].'&new_email_key='.$mail_data['newEmailKey'];
    
  }

  public function executeSendPasswordEmail()
  {
    $this->to           = $this->getRequestParameter('toemail');
    $this->newpassKey   = stringMagick::generateSalt();

    $user = sfGuardUserPeer::retrieveByEmail($this->to);
    $this->username     = $user->getUsername();

    $user->setNewPasswordKey($this->newpassKey);
    $user->setKeyExpires("+1 day");
    $user->save();

    $this->mail->addAddress($this->to);
  }

  public function executeSendRejectArtworkOrFile()
  {
    $this->rejectionmsg = $this->getRequestParameter('rejectionmsg');

    $this->mail->addAddress($this->getRequestParameter('to'));
    $this->mail->addCC($this->getRequestParameter('cc'));
    $this->mail->setSubject($this->getRequestParameter('subject'));
  }

}


