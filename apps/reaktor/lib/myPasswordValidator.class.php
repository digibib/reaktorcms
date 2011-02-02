<?php

/**
 * myPasswordValidator 
 * 
 * @uses sfValidator
 * @copyright 2008 Linpro AS
 * @author Hannes Magnusson <bjori@linpro.no> 
 * @license http://www.gnu.org/copyleft/lesser.html LGPL License 2.1
 */
class myPasswordValidator extends sfValidator
{
  /**
   * Executes this validator.
   *
   * @param mixed A parameter value
   * @param error An error message reference
   *
   * @return bool true, if this validator executes successfully, otherwise false
   */
  public function execute(&$value, &$error)
  {
    $decodedValue = sfToolkit::isUTF8($value) && function_exists('utf8_decode') ? utf8_decode($value) : $value;

    $min = $this->getParameterHolder()->get('min');
    if ($min !== null && strlen($decodedValue) < $min)
    {
      // too short
      $error = $this->getParameterHolder()->get('min_error');

      return false;
    }

    $max = $this->getParameterHolder()->get('max');
    if ($max !== null && strlen($decodedValue) > $max)
    {
      // too long
      $error = $this->getParameterHolder()->get('max_error');

      return false;
    }

    $values = $this->getParameterHolder()->get('values');
    if ($values !== null)
    {
      if ($this->getParameterHolder()->get('insensitive'))
      {
        $value = strtolower($value);
        $found = false;
        foreach ($values as $avalue)
        {
          if ($value == strtolower($avalue))
          {
            $found = true;
            break;
          }
        }
        if (!$found)
        {
          // can't find a match
          $error = $this->getParameterHolder()->get('values_error');

          return false;
        }
      }
      else
      {
        if (!in_array($value, (array) $values))
        {
          // can't find a match
          $error = $this->getParameterHolder()->get('values_error');

          return false;
        }
      }
    }

    return true;
  }

  /**
   * Initializes this validator.
   *
   * @param sfContext The current application context
   * @param array   An associative array of initialization parameters
   *
   * @return bool true, if initialization completes successfully, otherwise false
   */
  public function initialize($context, $parameters = null)
  {
    // initialize parent
    parent::initialize($context);

    // set defaults
    $this->getParameterHolder()->set('insensitive',  false);
    $this->getParameterHolder()->set('max',          null);
    $this->getParameterHolder()->set('max_error',    'Input is too long');
    $this->getParameterHolder()->set('min',          null);
    $this->getParameterHolder()->set('min_error',    'Input is too short');
    $this->getParameterHolder()->set('values',       null);
    $this->getParameterHolder()->set('values_error', 'Invalid selection');

    $this->getParameterHolder()->add($parameters);

    return true;
  }
}
