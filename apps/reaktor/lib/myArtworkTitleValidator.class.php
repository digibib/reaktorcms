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
class myArtworkTitleValidator extends sfValidator
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
    if (mb_strlen($value, 'UTF-8') > $this->getParameterHolder()->get('max_length'))
    {
      $error = $this->getParameterHolder()->get('max_length_error');
      return false;
    }
    
    if (mb_strlen($value, 'UTF-8') < $this->getParameterHolder()->get('min_length'))
    {
      $error = $this->getParameterHolder()->get('min_length_error');
      return false;
    }
     
    
    if (preg_match("/[^".$this->getParameterHolder()->get("valid_chars")."]/i", $value))
    {
      $error = $this->getParameterHolder()->get('invalid_error');
      return false; 
    }
    
    return true;
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
 
    // Set default parameters value (in case yml is missing)
    $minError = $this->getContext()->getI18n()->__('Please enter at least %1% characters', array("%1%" => sfConfig::get('app_artwork_min_title_length', 3))); 
    $maxError = $this->getContext()->getI18n()->__('Please enter less than %1% characters', array("%1%" => sfConfig::get('app_artwork_max_title_length', 40)));
    
    $this->setParameter('invalid_error', 'Title contains invalid characters');
    $this->setParameter('min_length_error', $minError);
    $this->setParameter('max_length_error', $maxError);
    
    $this->setParameter("valid_chars", sfConfig::get('app_artwork_valid_title_chars', 'a-z0-9-_\søåæäöØÅÆÖÄ!?\'"'));
    $this->setParameter('max_length', sfConfig::get('app_artwork_max_title_length', 40));
    $this->setParameter('min_length', sfConfig::get('app_artwork_min_title_length', 3));
    
    // Set parameters
    $this->getParameterHolder()->add($parameters);
 
    return true;
  }	
}
