<?php
/**
 * 
 *  
 * PHP version 5
 * 
 * @author    Daniel Andre Eikeland <dae@linpro.no>
 * @copyright 2008 Linpro AS
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 */

class myMagickWorkingRegexValidator extends sfValidator {

    public function execute(&$value, &$error)
    {
      preg_match($this->getParameterHolder()->get('pattern'), $value, $matches);
    	if (strlen($matches[0]) != strlen($value) || strtolower($this->getParameterHolder()->get('match')) == 'no')
      {
	      $error = $this->getParameterHolder()->get('match_error');
	      return false;
      }
      else
      {
      	return true;
      }
    }

    public function initialize($context, $parameters = null)
    {
        // Initialize parent
        parent::initialize($context);

        // Set parameters
        $this->getParameterHolder()->add($parameters);

        return true;
    }
}
?>