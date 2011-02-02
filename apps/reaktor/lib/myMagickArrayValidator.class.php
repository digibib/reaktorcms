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

class myMagickArrayValidator extends sfValidator {

    public function execute(&$value, &$error)
    {
    	if(!is_array($value))
        {
            // Wrong type
            $error = $this->getParameterHolder()->get('type_error');
            return false;
        }

        $min = $this->getParameterHolder()->get('min');
        if($min !== null && count($value) < $min)
        {
            // Array too small
            $error = $this->getParameterHolder()->get('min_error');
            return false;
        }

        $max = $this->getParameterHolder()->get('max');
        if($max !== null && count($value) > $max)
        {
            // Array too large
            $error = $this->getParameterHolder()->get('max_error');
            return false;
        }
        return true;
    }

    public function initialize($context, $parameters = null)
    {
        // Initialize parent
        parent::initialize($context);

        // Set default parameters value
        $this->setParameter('min', null);
        $this->setParameter('min_error', 'Insufficient elements checked.');
        $this->setParameter('max', null);
        $this->setParameter('max_error', 'Too many elements checked.');
        $this->setParameter('type_error', 'Wrong type.');

        // Set parameters
        $this->getParameterHolder()->add($parameters);

        return true;
    }
}
?>