<?php
/**
 * Class to set some useful globals regarding whether we are in the user (mypage) zone or not
 *
 * PHP Version 5
 *
 * @author    Russ <russ@linpro.no>
 * @copyright 2008 Linpro AS
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 *
 */

class userFilter extends sfFilter
{
  public function execute ($filterChain)
  {    
    // execute this filter only once
    if ($this->isFirstCall())
    {
      if (sfContext::getInstance()->getUser()->isAuthenticated() && !sfConfig::get("admin_mode")
           && (sfContext::getInstance()->getModuleName() == 'userContent' || strpos(sfContext::getInstance()->getRequest()->getUri(), '/mypage/') !== false))
      {
        sfConfig::set("mypage_mode", true);
        sfContext::getInstance()->getResponse()->setTitle(sfConfig::get("app_site_title")." ".sfContext::getInstance()->getI18N()->__("editorial centre"));
        sfConfig::set("app_site_title", sfConfig::get("app_site_title")." ".sfContext::getInstance()->getI18N()->__("My page"));
      }
    }
    // execute next filter
    $filterChain->execute();
  }
}