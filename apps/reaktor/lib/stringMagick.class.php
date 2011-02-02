<?php
/**
 * Helpful functions for generating/mainpulating strings.
 * 
 * PHP 5 version 5
 *
 * @author  juneih <juneih@linpro.no>
 * @author  Russ   <russ@linpro.no>
 * @license http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 * @copyright 2008 Linpro
 *
 */
class stringMagick
{
 
  /**
   * Returns random string of $length. 
   *
   * @param integer $length
   * @return string $newstring
   */
  public static function randomString($length = 5)
  {
    if (!is_int($length) || $length < 0) {
      throw new Exception("Illegal argument");
    }

    // Shuffle the pool
    $str = str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789');
    // And ones more before announcing the winners
    return substr(str_shuffle($str), 0, $length);
  }

  /**
   * Generates secure salts, useful for "forgotten password"
   * 
   * @return string
   */
  public static function generateSalt()
  {
    return md5(microtime() . uniqid(mt_rand(), true) . implode("", fstat(fopen(__FILE__, 'r'))));
  }
  
  /**
   * Return cleaned tag or false if invalid tag
   *
   * @param string $tag the tag to clean
   * @return false|string the clean tag or false if invalid
   */
  public static function cleanTag($tag)
  {
    $tag = mb_strtolower($tag, 'UTF-8');
    $tag = trim(str_replace(array("_", ":"), " ", $tag));
    $tag = str_replace("  ", " ", $tag);
    
    $returnArray["cleantag"] = $tag;
    
    if (mb_strlen($tag, 'UTF-8') < sfConfig::get("app_tagging_min_length") || mb_strlen($tag, 'UTF-8') > sfConfig::get("app_tagging_max_length"))
    {
      if (trim($tag) != '')
      {
        $returnArray["error"] = sfContext::getInstance()->getI18n()->__(
           "The tag \"%tag%\" could not be added. Tags should be between %min_length% and %max_length% characters", 
           array("%min_length%" => sfConfig::get("app_tagging_min_length"), 
                 "%max_length%" => sfConfig::get("app_tagging_max_length"),
                 "%tag%" => $tag != "" ? $tag : sfContext::getInstance()->getI18n()->__("Empty tag")));
      }
    }    
    elseif (preg_match("/[^a-z0-9-_\søåæØÅÆäö]/i", $tag))
    {
      $returnArray["error"] = sfContext::getInstance()->getI18n()->__(
         "%tag% could not be added. Invalid characters were found! Use only numbers, letters, spaces and dashes", 
         array("%tag%" => $tag));
    }

    return $returnArray;
    
  }

  /**
   * Smart chopping of strings.
   *
   * Chops $txt at ca $max, on spaces, commans, dots, dashes...
   * For optimization reason you can pass the original string
   * length as the 3rd parameter.
   *
   * You can check if the string was chopped or not by passing 
   * $txt_len and $cut_len (no need to initialize them), and
   * compare them afterwards. (Useful to know if you should
   * print "read more" links).
   *
   * NOTE:
   *     - This function will append the string "[...]" if chopped.
   *     - The returned string can underflow down to 50% of $max
   *     - The returned string can overflow 15 chars
   *
   * 
   * @param mixed $txt         The text to cut
   * @param int $max           Max strlen
   * @param int &$txt_len      The string length (optional)
   * @param int &$cut_len      The string length after cutting (optional)
   * @return string            The chopped string
   */
  public static function chop($txt, $max, &$txt_len = 0, &$cut_len = 0)
  {
    $cut_len = PHP_INT_MAX;

    if ($txt_len < 1)
    {
      $txt_len = strlen($txt);
    }
    if ($txt_len < $max)
    {
      return $txt;
    }

    // Try to find a reasonable cutting point
    $cut_len = strcspn($txt, " ,-!?", $max);
    $cut_len += $max;

    if ($cut_len > $max+8)
    {
      // If the cutting poing is way to long, or nonexistent we try again, this 
      // time with using much lower offset
      $half = (int)$max*0.5;
      $cut_len = strcspn($txt, " ,.-", $half);
      $cut_len += $half;

      if ($cut_len > $max)
      {
        // Still out-of-bounds? Lets hardcut it to $max then
        $cut_len = $max;
      }
    }
    if ($cut_len == $txt_len)
    {
      return $txt;
    }
    return substr($txt, 0, $cut_len). '[...]';

  }

  /**
   * Convert a camelcased string to lowercase with underscores
   *
   * @param string $word
   * 
   * @return string
   */
  public static function camelCaseToUnderscores($word)
  {
    return strtolower(preg_replace(
    array('/[^A-Z^a-z^0-9^\/]+/','/([a-z\d])([A-Z])/','/([A-Z]+)([A-Z][a-z])/'),
    array('_','\1_\2','\1_\2'), $word));
  }
  
}


