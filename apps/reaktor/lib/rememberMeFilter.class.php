<?php
/**
 * A bug in sfGuardPlugin means that unless you access a secure page, the "remember me" cookie is never checked
 * This filter will be run on every page load and will ensure users who have the cookie are logged in automatically
 * The actual setting of the cookie and the database inserts/deletes are correctly handled by the plugin
 *
 * PHP Version 5
 *
 * @author    Russ <russ@linpro.no>
 * @copyright 2008 Linpro AS
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 *
 */

class rememberMeFilter extends sfFilter
{
  public function execute ($filterChain)
  {    
    // execute this filter only once, and if the user is not already logged in, and has a cookie set
    if ($this->isFirstCall() && !$this->getContext()->getUser()->isAuthenticated())
    {
      if ($this->getContext()->getRequest()->getCookie(sfConfig::get('app_sf_guard_plugin_remember_cookie_name', 'sfRemember')))
      {
        // See if a user exists with this cookie in the remember database
        $c = new Criteria();
        $c->add(sfGuardRememberKeyPeer::REMEMBER_KEY, $this->getContext()->getRequest()->getCookie(sfConfig::get('app_sf_guard_plugin_remember_cookie_name', 'sfRemember')));
        $c->add(sfGuardRememberKeyPeer::IP_ADDRESS, $this->getContext()->getRequest()->getHttpHeader ('addr','remote'));
        
        if ($resultArray = sfGuardRememberKeyPeer::doSelectJoinsfGuardUser($c))
        {
          $resultRow = current($resultArray);
          $this->getContext()->getUser()->signIn($resultRow->getSfGuardUser(), true);
        }
        
        // Redirect to admin home page if we are an admin user accessing the default home index
        if ($this->getContext()->getUser()->hasCredential('staff') && $this->getContext()->getRequest()->getParameter("module") == "home")
        {
          $this->getContext()->getController()->redirect($this->getContext()->getController()->genUrl('@admin_home', true));
        }
      }
      // Check for i18n cookie
      if ($lang = $this->getContext()->getRequest()->getCookie(sfConfig::get('app_sf_guard_plugin_lang_cookie_name', 'lang')))
      {
        $this->getContext()->getUser()->setCulture($lang);
      }
    }
    // execute next filter
    $filterChain->execute();
  }
}