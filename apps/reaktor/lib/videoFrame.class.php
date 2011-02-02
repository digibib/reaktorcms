<?php
/**
 * Class that represents a videoFrame
 * 
 * PHP version 5
 * 
 * @author    Kjell-Magne Oierud <kjellm@linpro.no>
 * @copyright 2008 Linpro AS
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 * @version   SVN: $Id: videoFrame.class.php 3031 2009-02-17 18:46:40Z wojak $
 */

/**
 * Class that represents a videoFrame
 * 
 * PHP version 5
 * 
 * @author    Kjell-Magne Oierud <kjellm@linpro.no>
 * @copyright 2008 Linpro AS
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 */

require_once 'videoInfo.class.php';

final class videoFrame
{

  private $content;

  private $frameOffset;

  private $mime;

  private $sourceFile;

  /**
   * Content accessor.
   *
   * @return string the content of the video frame.
   */
  function getContent()
  {
    return $this->content;
  }

  /**
   * Mime accessor.
   *
   * @return string the mime type of the video frame
   */
  function getMime()
  {
    return $this->mime;
  }


  /**
   * Creates a videoFrame from a file.
   *
   * @param string $videoFile the file name of the video
   *
   * @return videoFrame the newly created    
   */
  static function fromVideoFile($videoFile,$mime='')
  {
    if (!file_exists($videoFile))
    {
      throw new Exception("File not found: $videoFile");
    }

    $safeFile = escapeshellarg($videoFile);

    $outDir  = self::_tempdir('/tmp', 'videoFrame-');
    $outFile = '00000002.jpg';

    $offset = round(videoInfo::videoLength($videoFile)) / 2;

    $command = "/usr/bin/mplayer -ss $offset -really-quiet -nojoystick -nolirc -nocache -nortc -noautosub -vf scale  -nosound -frames 4 -zoom -vo jpeg:outdir=$outDir:quality=100 $safeFile 2>&1";
    //die($command);
    exec($command, &$output, &$returnVal);
    
    $vf              = new videoFrame();
    $vf->frameOffset = $offset;
    if (!file_exists($outDir.'/'.$outFile))
    {
      return false;
    }
    $vf->content     = file_get_contents($outDir.'/'.$outFile);
    $vf->mime        = 'image/jpeg';
    $vf->sourceFile  = $videoFile;

    unlink($outDir.'/'.$outFile);
    unlink($outDir.'/00000001.jpg');
    unlink($outDir.'/00000003.jpg');
    unlink($outDir.'/00000004.jpg');
    rmdir($outDir);
    
    return $vf;
  }


  /**
   * Creates a temporary folder with a unique name.
   *
   * @param string $dir    Where to create it
   * @param string $prefix Prepend this to the directory name
   * @param int    $mode   Permissions
   *
   * @return string the name of the folder
   */
  private static function _tempdir($dir, $prefix='', $mode=0700)
  {
    if (substr($dir, -1) != '/')
    {
      $dir .= '/';
    }

    do
    {
      $path = $dir.$prefix.mt_rand(0, 9999999);
    } 
    while (!mkdir($path, $mode));

    return $path;
  }


}