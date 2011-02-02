<?php

/**
 * Helper for different array task not directly covered by SPL
 * PHP Version 5
 *
 * @author    Ole-Petter Wikene <olepw@linpro.no>
 * @copyright 2008 Linpro AS
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 *
 

function countKeyOccurenceRecursive($array,$key)
{
  global $theKey ;
  global $count ;
  $theKey = $key;
  $count = 0; 
  array_walk_recursive($array,'countKey');
  return $count;
}

function countkey($item,$key)
{
  global $theKey,$count;

  if ($key == $theKey)
    $count++;
  

}*/
?>