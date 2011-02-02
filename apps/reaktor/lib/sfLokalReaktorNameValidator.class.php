<?php
/**
 * Validator for Artwork titles
 *
 * PHP Version 5
 *
 * @author    Russ Flynn <russ@linpro.no>
 * @copyright 2008 Linpro AS
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 *
 */

/**
 * Validator for Artwork titles
 *
 * PHP Version 5
 *
 * @author    Russ Flynn <russ@linpro.no>
 * @copyright 2008 Linpro AS
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 *
 */
class sfLokalReaktorNameValidator extends sfValidator
{
  /**
   * Validator looking for URL on each line of text field
   *
   * @param mixed  &$value Pointer to the value to validate
   * @param string &$error Pointer to the error
   * 
   * @return boolean
   */
  public function execute (&$value, &$error)
  {
    sfLoader::loadHelpers("Url");
    $link = null;

    if (strlen($value) > $this->getParameterHolder()->get("max_len")) {
      $error = $this->getParameterHolder()->get("max_len_error");
      return false;
    }

    $error = $this->getParameterHolder()->get("url_error");

    try {
      // Check if the exact routing exists
      $link = url_for("@$value");

    } catch(sfConfigurationException $ex) {
      /* Configuration exception is thrown when url_for() does not find a match, 
       * which in our case is exactly what we want */
    } catch(sfException $ex) {
      /* Thrown when the routing exists, but is missing some components, which 
       * in our case is very very bad */
      return false;
    }
    // Now make really sure we have no similar URIs
    $yml = sfYaml::load(sfConfig::get('sf_root_dir')."/apps/reaktor/config/routing.yml");
    $val = "/" . strtolower($value) . "/";
    foreach($yml as $route) {
      if (strpos($route["url"], $val) !== false) {
        return false;
      }
    }

    /* Check if url_for() did resolve to anything, bad if it did */
    return $link == null;
  }
 
  /**
   * Initializes the validator
   *
   * @param unknown_type $context    Context
   * @param unknown_type $parameters Parameters
   * 
   * @return boolean
   */
  public function initialize ($context, $parameters = null)
  {
    // Initialize parent
    parent::initialize($context);
 
    $this->setParameter("url_error", "I am sorry but the reference you entered is not available for the moment.");
    // The database scheme limits this to 15 chars, so lets be nice and error 
    // out rather then silently chop of the rest
    $this->setParameter("max_len", 15);
    $this->setParameter("max_len_error", "The reference URI is limited to 15 characters");
    
    // Set parameters
    $this->getParameterHolder()->add($parameters);
 
    return true;
  }	
}
