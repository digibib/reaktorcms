<?php
/**
 * Class that extracts meta information from video files
 * 
 * PHP version 5
 * 
 * @author    Kjell-Magne Oierud <kjellm@linpro.no>
 * @copyright 2008 Linpro AS
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 * @version   SVN: $Id$
 */

/**
 * Class that extracts meta information from video files
 * 
 * PHP version 5
 * 
 * @author    Kjell-Magne Oierud <kjellm@linpro.no>
 * @copyright 2008 Linpro AS
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 */
final class videoInfo
{


  /**
   * Finds the length of a video 
   *
   * @param string $videoFile the file name of the video
   *
   * @return float the length of the video in seconds.
   */
  public static function videoLength($videoFile)
  {
    
    if (!file_exists($videoFile))
    {
      throw new Exception("File not found: $videoFile");
    }

    $pattern = 'ID_LENGTH=';
    exec("/usr/bin/mplayer -identify \"$videoFile\" -nojoystick -nolirc -nosound -vc dummy -vo null", $mplayerOut);
    $len = preg_grep("/^$pattern/", $mplayerOut);
    $len = array_pop($len);
    $len = substr($len, strlen($pattern));

    return $len + 0.0; /* Convert string to float */
  }

  
}