<?php
/**
 * Class for shortcuts to Reaktor specific tasks which are reused
 *
 * PHP Version 5
 *
 * @author    Russ <russ@linpro.no>
 * @copyright 2008 Linpro AS
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 *
 */

class reaktor
{
  /**
   * Set the page title in for the browser, you should do any translation operations before calling this function
   *
   * @param string $extraTitle appended after the site title and default seperator
   */
  public static function setReaktorTitle($extraTitle)
  {
    $currentTitle = sfConfig::get("app_site_title");

    $seperator    = sfConfig::get("app_title_seperator", " ~ ");
    $newTitle     = $currentTitle.$seperator.$extraTitle; 
    
    sfContext::getInstance()->getResponse()->setTitle($newTitle);
  }
  
  /**
   * Function to add javascript that will be loaded in the footer template
   * Useful when accessing dom elements that appear later in the loading process than the template you are working on
   *
   * @param string $js The javascript you want to add
   */
  public static function addJsToFooter($js)
  {
    $footerJs = sfContext::getInstance()->getRequest()->getAttribute('footer_js', array());
    $footerJs[] = $js; 
    sfContext::getInstance()->getRequest()->setAttribute('footer_js', $footerJs);
  }
}