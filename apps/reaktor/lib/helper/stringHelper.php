<?php
/**
 * Helpers for string related tasks
 * 
 * PHP Version 5
 *
 * @author    Ole-Petter Wikene <olepw@linpro.no>
 * @copyright 2008 Linpro AS
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 *
 */

function getThumbNameFromFile($fileName){
 $ptch=pathinfo($fileName);
return $ptch['filename'].'.jpg';
}

/**
 * cut string, and add trailing '...'.
 *
 * @param string          $str is the string to be cutted
 * @param int             $len is the length before the string is cutted
 * @param bool            $trailingDots should the function add trailing dots (optional, defailt=true)
 * @return string the generated path to file (e.g. /content/1/myimage.jpg)
 */


function stringCut($str, $len, $trailingDots = true)
{
  if (mb_strlen($str, 'UTF-8') > $len)
    return substr($str, 0, $len).(($trailingDots) ? "..." : "");
  else
    return $str;
}
  
?>
