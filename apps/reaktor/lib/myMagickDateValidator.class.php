<?php
/**
 * Date validator class, for use with CRUD generator date validation
 *  
 * PHP version 5
 * 
 * @author    Daniel Andre Eikeland <dae@linpro.no>
 * @copyright 2008 Linpro AS
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 */

/**
 * Same as above
 * 
 * @author    Daniel Andre Eikeland <dae@linpro.no>
 * @copyright 2008 Linpro AS
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 */

class myMagickDateValidator extends sfDateValidator
{
  /**
   * Validates value and provides error
   *
   * @param mixed  &$value Pointer to the value to validate
   * @param string &$error Pointer to the error
   * 
   * @return boolean
   */
  public function execute (&$value, &$error)
  { 
  	if (!isset($value['day'], $value['month'], $value['year']) || !$value['day'] || !$value['month'] || !$value['year'])
    {        	
    	$error = parent::getParameter('date_incomplete');
    	return false;
    }

    //this check only works if year is between 1901 and 2038. On some machines the lower range is 1970.
    //See php.net mktime for more information.
    $var_dob = $value['day'] . '/' . $value['month'] . '/' . $value['year'];
    $chk_dob = date('j/n/Y', mktime(0, 0, 1, $value['month'], $value['day'], $value['year']));
    
    if ($var_dob == $chk_dob)
    {
      $value = $var_dob;
      return true;
    }
    $error = parent::getParameter('date_error');
    return false;
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
    $this->setParameter('date_error', 'This date is not valid');
 
    // Set parameters
    $this->getParameterHolder()->add($parameters);
 
    return true;
  }	
}
