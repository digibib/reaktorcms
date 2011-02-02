<?php
/**
 * Extending the sfGuardUser Classes
 *
 * PHP Version 5
 *
 * @author    Russ <russ@linpro.no>
 * @copyright 2008 Linpro AS
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 *
 */

require_once(sfConfig::get('sf_plugins_dir').'/sfGuardPlugin/modules/sfGuardAuth/lib/BasesfGuardAuthActions.class.php');

class sfGuardAuthActions extends BasesfGuardAuthActions
{
   public function executeSignin()
   {
     if ($this->getRequest()->getMethod() == sfRequest::POST)
     {
       $referer    = $this->getRequestParameter('referer') ? $this->getRequestParameter('referer') : "/";

       $signin_url = sfConfig::get('app_sf_guard_plugin_success_signin_url', $referer);
       $languages  = CataloguePeer::doSelect(new Criteria());
       
       $loggedInUser = $this->getUser()->getGuardUser();
       
       // Set the session culture from the db culture when the user has signed in
       $this->getUser()->setCulture($loggedInUser->getCulture());
       
       //Check if this user needs to go to the profile
       if ($loggedInUser->getDobIsDerived() || $loggedInUser->getNeedProfileCheck())
       {
         $this->redirect('@profile');
       }
       
       //Switch the language in the URL (if it exists) with the one from user culture in DB
       foreach ($languages as $language)
       {
         $signin_url = str_replace("sf_culture=".$language->getTargetLang(),"sf_culture=".$this->getUser()->getGuardUser()->getCulture(), $signin_url);
       }
      
       if ($this->getUser()->hasCredential('staff') && strpos($this->getRequestParameter('referer'), "home") !== false)
       {
         $this->redirect('@admin_home');
       }
       // Don't redirect to pages such as profile/activate
       elseif (strpos($referer, "profile/") === 0)
       {
         if (strpos($referer, "profile/portfolio") === false && strpos($referer, "profile/myPage") === false)
         {
           $this->redirect('@home');
         }
         elseif (strpos($referer, "user={$this->getUser()->getUsername()}") === false)
         {
           $this->redirect('@home');
         }
       }
       try 
       {
        $this->redirect('' != $signin_url ? $signin_url : '@home');
       } 
       catch (sfConfigurationException $e)
       {
        $this->redirect('@home');
       }
       
     }
     
     // Do the rest of the stuff provided by sfGuardUser plugin signin function
     parent::executeSignin();
   }

   /**
    * Doesn't seem like the built in security does the following, so we will
    *
    * @return null
    */
   public function executeSignout()
   {
     if (sfConfig::get('sf_environment') != 'test')
     {
      $_SESSION = array();
      session_destroy();
      session_write_close();
      session_regenerate_id();
     }
     
     $this->getUser()->signOut();
     //XXX: could add logic here, see issue #516 , and example logic in signin function
     //$this->redirect($this->getRequest()->getReferer());
     sfLoader::loadHelpers(array("Url", 'subreaktor'));
     $this->redirect(reaktor_url_for('@home', true));
     
   }

}
