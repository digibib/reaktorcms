<?php
/**
 * Class to set some useful globals regarding whether we are in the admin zone or not
 *
 * PHP Version 5
 *
 * @author    Russ <russ@linpro.no>
 * @copyright 2008 Linpro AS
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 *
 */

class adminFilter extends sfFilter
{
  public function execute ($filterChain)
  {    
    // execute this filter only once
    if ($this->isFirstCall())
    {
      if ((sfContext::getInstance()->getModuleName() == 'admin' || strpos(sfContext::getInstance()->getRequest()->getUri(), '/admin') !== false)
           && (sfContext::getInstance()->getUser()->hasCredential("admin") || sfContext::getInstance()->getUser()->hasCredential("staff")))
      {
        sfConfig::set("admin_mode", true);
        if (sfContext::getInstance()->getUser()->hasCredential("admin"))
        {
          sfContext::getInstance()->getResponse()->setTitle(sfConfig::get("app_site_title")." ".sfContext::getInstance()->getI18N()->__("administrator"));
          sfConfig::set("app_site_title", sfConfig::get("app_site_title")." ".sfContext::getInstance()->getI18N()->__("administrator"));
          sfConfig::set("app_admin_logo", sfConfig::get("admin_logo", "logoAdmin.gif"));
        }
        elseif (sfContext::getInstance()->getUser()->hasCredential("staff"))
        {
          sfContext::getInstance()->getResponse()->setTitle(sfConfig::get("app_site_title")." ".sfContext::getInstance()->getI18N()->__("editorial centre"));
          sfConfig::set("app_site_title", sfConfig::get("app_site_title")." ".sfContext::getInstance()->getI18N()->__("editorial centre"));
          sfConfig::set("app_admin_logo", sfConfig::get("redaksjon_logo", "reaktor_red.gif"));
        }
      }
    }
    // execute next filter
    $filterChain->execute();
  }
}