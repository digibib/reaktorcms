<?php 
/**
 * Display a many 2 many relation between objects as a set of checkboxes.  
 *  
 * PHP version 5
 * 
 * @author juneih <juneih@linpro.no>
 * @copyright 2008 Linpro
 * @license http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 * 
 */



/**
 * Accepts a container of objects, the method name to use for the value,
 * and the method name to use for the display.
 * It returns a string of option tags.
 *
 * @param object $options
 * @param string $value_method
 * @param string $text_method
 * @param array $selected
 * @return unknown
 */
function items_for_select($options = array(), $value_method, $text_method = null, $selected = array())
{
      $select_options = array();
      foreach ($options as $option)
      {
        // text method exists?
    if ($text_method && !is_callable(array($option, $text_method)))
    {
      $error = sprintf('Method "%s" doesn\'t exist for object of class "%s"', $text_method, _get_class_decorated($option));
      throw new sfViewException($error);
    }

    // value method exists?
    if (!is_callable(array($option, $value_method)))
    {
      $error = sprintf('Method "%s" doesn\'t exist for object of class "%s"', $value_method, _get_class_decorated($option));
      throw new sfViewException($error);
    }

    $value = $option->$value_method();
    $key = ($text_method != null) ? $option->$text_method() : $value;

    $select_options[$value] = $key;
  }
  
  return $select_options;
}


