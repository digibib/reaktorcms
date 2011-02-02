<?php
/**
 * Class to set some useful globals regarding subreaktors and lokalreaktors
 *
 * PHP Version 5
 *
 * @author    Russ <russ@linpro.no>
 * @copyright 2008 Linpro AS
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 *
 */

class subreaktorFilter extends sfFilter
{
  public function execute ($filterChain)
  {    
    // execute this filter only once
    if ($this->isFirstCall())
    {
      sfContext::getInstance()->getRequest()->setAttribute("subreaktor", Subreaktor::getProvidedSubreaktor());
      sfContext::getInstance()->getRequest()->setAttribute("lokalreaktor", Subreaktor::getProvidedLokalreaktor());
      
      if (Subreaktor::getProvidedSubreaktor() && !Subreaktor::getProvidedLokalreaktor())
      {
        sfContext::getInstance()->getResponse()->setTitle(sfConfig::get("app_site_title")." ".Subreaktor::getProvidedSubreaktor()->getName());
        sfConfig::set("app_site_title", sfConfig::get("app_site_title")." ".Subreaktor::getProvidedSubreaktor()->getName());
      }
      elseif (Subreaktor::getProvidedLokalreaktor() && !Subreaktor::getProvidedSubreaktor())
      {
        sfContext::getInstance()->getResponse()->setTitle(sfConfig::get("app_site_title")." ".Subreaktor::getProvidedLokalreaktor()->getName());
        sfConfig::set("app_site_title", sfConfig::get("app_site_title")." ".Subreaktor::getProvidedLokalreaktor()->getName());
      }
      elseif (Subreaktor::getProvidedLokalreaktor() && Subreaktor::getProvidedSubreaktor())
      {
        sfContext::getInstance()->getResponse()->setTitle(sfConfig::get("app_site_title")." ".Subreaktor::getProvidedLokalreaktor()->getName()." (".Subreaktor::getProvidedSubreaktor()->getName().")");
        sfConfig::set("app_site_title", sfConfig::get("app_site_title")." ".Subreaktor::getProvidedLokalreaktor()->getName()." (".Subreaktor::getProvidedSubreaktor()->getName().")");
      }
      
    }
    // execute next filter
    $filterChain->execute();
  }
}