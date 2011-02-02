<?php
/**
 * Validator for multiple URL field
 *
 * PHP Version 5
 *
 * @author    Russ Flynn <russ@linpro.no>
 * @copyright 2008 Linpro AS
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 *
 */

/**
 * Validator for multiple URL field
 *
 * PHP Version 5
 *
 * @author    Russ Flynn <russ@linpro.no>
 * @copyright 2008 Linpro AS
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 *
 */
class myUrlFieldValidator extends sfValidator
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
    //Break into the text, line by line
    $url_lines = explode("\n", $value);
    
    //Lets look at each one, line by line
    foreach ($url_lines as $key => $line)
    {
      $line = trim($line);
      if ($line == "")
      {
        unset ($url_lines[$key]);
        continue;
      }
      
      $re = '/^(http|https|ftp):\/\/(([A-Z0-9][A-Z0-9_-]*)(\.[A-Z0-9][A-Z0-9_-]*)+)/i';

      if (!preg_match($re, $line))
      {
        $error = $this->getParameterHolder()->get('format_error');
      }
      $url_lines[$key] = $line;
    }
        
    //Rebuild the text field
    $value              = implode("\n", $url_lines);
    $_POST['resources'] = $value;
    
    if (isset($error))
    {
      return false;
    }
    return true;
    
    //$error = parent::getParameter('url_error');
    //return false;
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
 
    // Set default parameters value
    $this->setParameter('format_error', 'Invalid format');
    
    // Set parameters
    $this->getParameterHolder()->add($parameters);
 
    return true;
  }	
}