<?php
/**
 * Transcodes media files to format suitable for serving through a
 * flash player.
 * 
 * PHP version 5
 * 
 * @author    Kjell-Magne Oierud <kjellm@linpro.no>
 * @copyright 2008 Linpro AS
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 * @version   SVN: $Id:transcoder.php 294 2008-02-21 10:46:58Z russ $
 */

/**
 * Transcodes media files to format suitable for serving through a
 * flash player.
 * 
 * PHP version 5
 * 
 * @author    Kjell-Magne Oierud <kjellm@linpro.no>
 * @copyright 2008 Linpro AS
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 */
final class transcoder
{

  const MIME_CONTENT_TYPE_CATEGORY_VIDEO = 'video';
  const MIME_CONTENT_TYPE_CATEGORY_AUDIO = 'audio';
  
  const MIME_CONTENT_TYPE_OGG  = 'application/ogg';
  const MIME_CONTENT_TYPE_WAV  = 'audio/x-wav';
  const MIME_CONTENT_TYPE_MPEG = 'audio/mpeg';
  
  // FIX make below constants into instance variables?

  const TRANSCODE_TMP_DIR = '/tmp';
  
  const TRANSCODE_MPLAYER_CMD  = '/usr/bin/mplayer';
  const TRANSCODE_LAME_CMD     = '/usr/bin/lame';
  const TRANSCODE_FFMPEG_CMD   = '/usr/bin/ffmpeg';
  const TRANSCODE_FLVTOOL2_CMD = '/usr/bin/flvtool2';
  const TRANSCODE_TIMIDITY_CMD = '/usr/bin/timidity';

  /**
   * The transcoded files will be stored in subdirectories of this directory.
   */
  private $_outputBaseDir;

  /**
   * The name of the original file
   *
   * @var string
   */
  private $_originalName;
  
  /**
   * Detecetd mime type to return with the transcoding results
   *
   * @var string
   */
  private $_detectedMime = null;
  
  /**
   * An array of extra info that can be passed to transcoder function
   *
   * @var array
   */
  private $_extraInfo = array();
  
  /**
   * Constructor
   *
   * @param string $outputBaseDir The transcoded files will be stored in
   *                              subdirectories of this directory.
   */
  function __construct($outputBaseDir = null)
  {
    if (!$outputBaseDir)
    {
      $outputBaseDir = sfConfig::get('sf_root_dir')."/".sfConfig::get('app_upload_upload_dir')."/"; 
    }
    
    if (!is_dir($outputBaseDir))
    {
      throw new Exception("Not a folder");
    }
    if (!is_writable($outputBaseDir))
    {
      throw new Exception("Can't write to output directory.");
    }

    $this->_outputBaseDir = $outputBaseDir;
  } 


  /**
   * Transcodes a media file
   *
   * @param string $fileName  the full path to the file to be converted
   * @param string $newName   the name of the transcoded file is
   *                          extracted from this.
   * @param array  $extraInfo Extra info that may be useful
   * 
   * @return array Filename and mime type of the generated file
   */
  function transcode($fileName, $newName, $extraInfo = array())
  {
    if (!file_exists($fileName))
    {
      throw new Exception("File not found: '$fileName'");
    }
    elseif (filesize($fileName) == 0) 
    {
      throw new Exception("Don't know how to transcode an empty file: '$fileName'");
    }

    $this->_extraInfo    = $extraInfo;
    $this->_originalName = $newName;
    $outputFile          = $this->_removeDirsAndSuffix($newName);
    $mime                = $this->_getMime($fileName);
    $this->_detectedMime = $mime;
    if ($this->_isVideo($fileName, $mime)) 
    {
    	return $this->_transcodeVideo($fileName, $this->_outputBaseDir."video/".$outputFile, $mime);
    }
    else if ($this->_isAudio($fileName, $mime))
    { 
      return $this->_transcodeAudio($fileName, $this->_outputBaseDir."audio/".$outputFile, $mime);
    }


    throw new Exception("Unrecognised media format: File:".$fileName."<br />".
                        "TranscoderMime: ".$mime."<br />".
                        "UploadedMime: ".$this->_extraInfo["suggested_mime"]."<br />".
                        "ExtraFileDetails: ".$this->_getFileType($fileName)."<br />".
                        "Extension: ".$this->_getFileSuffix());
  } 
  

  /**
   * Checks if a file is a video.
   *
   * @param string $fileName name of the file that should be checked
   * @param string $mime     the mime type
   *
   * @return bool TRUE if the file is a video file, FALSE otherwise
   */
  private function _isVideo($fileName, $mime)
  { 

/*      return strpos($mime, self::MIME_CONTENT_TYPE_CATEGORY_VIDEO) === 0
    || $this->_isOggTheora($fileName, $mime)
    || $this->_isFlv($fileName, $mime)
    || $this->_isWmv($fileName);
// Functions _isOggTheora, _isFlv and _isWmv below, are executed to handle backward compatibility (they converts mimeType) - Needs to be improve

*/
$this->_isOggTheora($fileName, $mime);
$this->_isFlv($fileName, $mime);
$this->_isWmv($fileName);
//echo $this->_getContainerType($fileName,$mime);
//die();
    return $this->_getContainerType($fileName,$mime)=="video";

  }


  /**
   * Checks if a file is an audio file.
   *
   * @param string $fileName name of the file that should be checked
   * @param string $mime     the mime type
   *
   * @return bool TRUE if the file is an audio file, FALSE otherwise
   */
  private function _isAudio($fileName, $mime)
  {
  
    /*return strpos($mime, self::MIME_CONTENT_TYPE_CATEGORY_AUDIO) === 0
      || $this->_isOggVorbis($fileName, $mime)
      || $this->_getContainerType($fileName)=="audio"
      || $this->_isWma($fileName);
// Functions _isOggVorbis and _isWma below, are executed to handle backward compatibility (they converts mimeType) - Needs to be improved
*/
	
	
     $this->_isOggVorbis($fileName, $mime);
     $this->_isWma($fileName);
//echo $this->_getContainerType($fileName)=="audio".$this->_isMidi($fileName)."wojak";

     return $this->_getContainerType($fileName)=="audio" || $this->_isMidi($fileName);

  }


  /**
   * Checks if a file is a flv file.
   *
   * @param string $fileName name of the file that should be checked
   * @param string $mime     the mime type
   *
   * @return bool TRUE if the file is a flv file, FALSE otherwise
   */
  private function _isFlv($fileName, $mime)
  {
    if (strpos($this->_getFileType($fileName), 'Macromedia Flash Video') !== false)
    {
      $this->_detectedMime = "video/x-flv";
      return true;
    }
  }


  /**
   * Checks if a file is a Ogg/Theora file
   *
   * @param string $fileName name of the file that should be checked
   * @param string $mime     the mime type
   *
   * @return bool TRUE if the file is an Ogg/Theora file, FALSE otherwise
   * FIX
   */
  private function _isOggTheora($fileName, $mime)
  {
    if ($mime == self::MIME_CONTENT_TYPE_OGG 
      && strpos($this->_getFileType($fileName), 'Theora video') !== false)
      {
        $this->_detectedMime = "video/ogg-theora";
        return true;
      }
  }
      

  /**
   * Checks if a file is a WMV file.
   *
   * @param string $fileName name of the file that should be checked
   *
   * @return bool TRUE if the file is a WMV file, FALSE otherwise
   */
  private function _isWmv($fileName)
  {
    if ($this->_isWmx($fileName, 'wmv'))
    {
      $this->_detectedMime = "	audio/x-ms-wmv";
      return;
    }
  }

  /**
   * Checks if a file is a WMA file.
   *
   * @param string $fileName name of the file that should be checked
   *
   * @return bool TRUE if the file is a WMV file, FALSE otherwise
   */
  private function _isWma($fileName)
  {
    if ($this->_isWmx($fileName, 'wma'))
    {
      $this->_detectedMime = "audio/x-ms-wma";
      return true;
    }
  }

  private function _isMidi($fileName)
  {
//$mesg= "_getFileType=".$this->_getFileType($fileName)."   strpos_result=". strpos($this->_getFileType($fileName), 'MIDI');
//sfLoader::loadHelpers(array("Debug")); log_message($mesg);

if (strpos($this->_getFileType($fileName), 'Standard MIDI data') !== false)
    {
	
      $this->_detectedMime = "audio/midi";
      return true;
    }
    return false;
  }
  
  /**
   * Checks if a file is a WMA or WMV file. Helper for _isWmv() and
   * _isWma().
   *
   * @param string $fileName name of the file that should be checked
   * @param string $type     either 'wma' or 'wmv'
   *
   * @return bool TRUE if the file is a WMV or WMA file, FALSE otherwise
   */
  private function _isWmx($fileName, $type)
  {
    return strpos($this->_getFileType($fileName), 'Microsoft ASF') !== false
      && strcasecmp($this->_getFileSuffix(), $type) == 0;
  }

  /**
   * Checks if a file is Ogg/Vorbis.
   *
   * @param string $fileName name of the file that should be checked
   * @param string $mime     the mime type
   *
   * @return bool TRUE if the file is an Ogg/Vorbis file, FALSE otherwise
   */
  private function _isOggVorbis($fileName, $mime)
  {
    if ($mime == self::MIME_CONTENT_TYPE_OGG 
      && strpos($this->_getFileType($fileName), 'Vorbis audio') !== false)
      {
        $this->_detectedMime = "application/ogg";
        return true;
      }
  }
      

  /**
   * Removes directories and the suffix from a file name.
   *
   * @param string $filePath the file name that should be stripped
   *
   * @return the stripped file name
   */
  private function _removeDirsAndSuffix($filePath)
  {
    $filePath = basename($filePath);
    if (strrpos($filePath, '.'))
    {
      $filePath = substr($filePath, 0, strrpos($filePath, '.'));
    }
    return $filePath;
  }

  
  /** 
   * Returns the suffix part of a file name
   *
   * @param string $filePath get suffix of this
   * 
   * @return string the suffix or '' (the empty string) if there are
   *                no suffix
   */
  private function _getFileSuffix()
  {
    if (strrpos($this->_originalName, '.'))
    {
      return substr($this->_originalName, strrpos($this->_originalName, '.') +1);
    }
    else   
    {
      return '';
    }
  }


  /**
   * Finds the mime type of a file
   *
   * @param string $fileName name of the file that should be analyzed
   *
   * @return string the mime type
   */
  private function _getMime($fileName)
  {
    /* Using the unix comand 'file' to get mime type. PHP has a built in
     * function for this, mime_content_type(), but it is
     * depreciated. Instead you are supposed to use a PECL extension
     * 'Fileinfo'. However, that is a bit inconvinient ... */
    $safeFileName = escapeshellarg($fileName);
    return trim(exec("file -i -b $safeFileName"));
  }





function getFileType2($fileName)
  {

   $execCommand = sprintf(str_replace("transcoder.class.php", 'transcode/getmimetype.sh', __file__).' %s',   escapeshellarg($fileName));

      
//         exec($execCommand);
//if(!file_exists($fileName)) echo "No file!";
         exec($execCommand, $cmdOutput, $exitCode);
//var_dump($cmdOutput);
    return trim($cmdOutput[0]);

  }



  /**
   * Finds the file type of a file
   *
   * @param string $fileName name of the file that should be analyzed
   *
   * @return string the file type
   */
  private function _getFileType($fileName)
  {
    $safeFileName = escapeshellarg($fileName);
    return trim(exec("file -b $safeFileName"));

//return $this->getFileType2($fileName);
  }








  /**
   * Finds the data type in container
   *
   * @param string $fileName name of the file that should be analyzed
   *
   * @return string: audio video unknown
   */
  private function _getContainerType($fileName,$mime='')
  {
      $exitCode = false;
#      file_put_contents($outputFilePath.".log",'');
      $execCommand = sprintf(str_replace("transcoder.class.php", 'transcode/getcontainertype.sh', __file__).' %s "%s"', 
         escapeshellarg($fileName),$mime);
 

      
         exec($execCommand, $cmdOutput, $exitCode);
      
      
      
      if ($exitCode !== 0) 
      {
        throw new Exception("Transcode failed!\nTranscode Output:\n" . $exitCode);
      }




    return trim($cmdOutput[0]);
  }






 public function getGifType($fileName)
  {
      $exitCode = false;
#      file_put_contents($outputFilePath.".log",'');

      $execCommand = sprintf(str_replace("transcoder.class.php", 'transcode/getgiftype.sh', __file__).' %s ', 
         escapeshellarg($fileName));
 

      
         exec($execCommand, $cmdOutput, $exitCode);
      
      
      
      if ($exitCode !== 0) 
      {
        throw new Exception("Transcode failed!\nTranscode Output:\n" . $exitCode);
      }




    return trim($cmdOutput[0]);
  }













  /**
   * Transcodes a audio file to flv
   *
   * This function uses ffmpeg for the transcoding. So make shure that
   * you have a version with compiled support for mp3. The one that is
   * packaged with Ubuntu is not.
   *
   * You also need flvtool2 which is not packaged for Ubuntu.
   *
   * @param string $fileName       the path to the file to be converted
   * @param string $outputFilePath transcoding result goues here (should
   *                               not include the file name suffix)
   * @param string $mime           the mime type of $file_name
   *
   * @return array Filename and mime type of the generated file
   */
  private function _transcodeVideo($fileName, $outputFilePath, $mime)
  {
    $outputFilePath .= '.flv';
   
    if ($this->_isFlv($fileName, $mime))
    {
      // Don't need to transcode FIX should we recode?
      // FIX check for errors!
      copy($fileName, $outputFilePath);
    }
    else 
    {
      // FIX Does the -ar param nprint $fileName;eed to be set according to input file?
      /*$transcodeCmd = sprintf('%s -map_meta_data infile:outfile -i %s -acodec libmp3lame -ab 192 -ar 44100 %s > /dev/null 2>&1',
                              self::TRANSCODE_FFMPEG_CMD, 
                              escapeshellarg($fileName), 
                              escapeshellarg($outputFilePath));
      
                              $flvtoolCmd   = sprintf("%s -U %s > /dev/null 2>&1 &", 
                              self::TRANSCODE_FLVTOOL2_CMD, 
                              escapeshellarg($outputFilePath));
     
      */;
      $exitCode = false;
      file_put_contents($outputFilePath.".log",'');
      $execCommand = sprintf(str_replace("transcoder.class.php", 'transcode/transcodevideo.sh', __file__).' %s %s %s %s %s > '.$outputFilePath.'.log 2>&1 &', 
        self::TRANSCODE_FFMPEG_CMD,
         escapeshellarg($fileName),
         escapeshellarg($outputFilePath),
         self::TRANSCODE_FLVTOOL2_CMD,
	$mime
);
         
         
      
         exec($execCommand, $cmdOutput, $exitCode);
      
      
      
      if ($exitCode !== 0) 
      {
        throw new Exception("Transcode failed!\nTranscode Output:\n" . $exitCode);
      }
      //unset($cmdOutput);
      //exec($flvtoolCmd, $cmdOutput, $exitCode);
    }
    
    return array('newFileName'   => basename($outputFilePath), 
                 'convertedMime' => 'video/flv',
                 'detectedMime'  => $this->_detectedMime,
                );
  }
  

  /**
   * Transcodes a audio file to mp3
   *
   * @param string $fileName       the file that should be transcoded
   * @param string $outputFilePath transcoding result goues here (should
   *                               not include the file name suffix)
   * @param string $mime           the mime type of $file_name
   *
   * @return array Filename and mime type of the generated file
   */
  private function _transcodeAudio($fileName, $outputFilePath, $mime)
  {
    $outputFilePath .= '.mp3';
  
    if ($mime == self::MIME_CONTENT_TYPE_MPEG)
    {
      // MP3 - Don't need to transcode FIX should we recode?
      // FIX check that it actually is a MPEG-1 Audio Layer 3 file
      // FIX check for errors!
      copy($fileName, $outputFilePath);
    }
    // We use mplayer with wma files to dump wav before encoding to mp3 with lame
    else //if ($this->_isWma($fileName))
    {
        
        if ($this->_isMidi($fileName) !== false)
        {
          $midiToWaveCmd = sprintf(str_replace("transcoder.class.php", 'transcode/transcodeMidi.sh', __file__). " %s %s %s %s %s > /dev/null 2>&1 &",
          self::TRANSCODE_TIMIDITY_CMD,
          self::TRANSCODE_FFMPEG_CMD,
          escapeshellarg($fileName),
          escapeshellarg($outputFilePath),
          str_replace("transcoder.class.php", 'transcode/transcodeaudio.sh', __file__));
        
        exec($midiToWaveCmd, $cmdOutput, $exitCode);
        } else
        {
        $transcodeWmaCommand = sprintf(str_replace("transcoder.class.php", 'transcode/transcodeaudio.sh', __file__).' %s %s %s >/dev/null 2>&1 &',
        self::TRANSCODE_FFMPEG_CMD,
        escapeshellarg($fileName),
        escapeshellarg($outputFilePath));
      //echo $transcodeWmaCommand."<br /><br />";
      exec($transcodeWmaCommand, $cmdOutput, $exitCode);
      file_put_contents($fileName.".log",$cmdOutput);
        }
/*foreach($cmdOutput as $line)
      {
        echo $line."<br />\n";
      }
      die();*/
    }
    /*else
    {
    
      $pcmFile  = $fileName;
      $pcmIsTmp = false;
      if ($mime != self::MIME_CONTENT_TYPE_WAV)
      {
        $pcmFile = tempnam(self::TRANSCODE_TMP_DIR, 'transcode');
        $this->_decodeAudio($fileName, $pcmFile);
        $pcmIsTmp = true;
      }
      
      $transcodeMp3Cmd = sprintf('%s --quiet --abr 192 %s %s 2>&1',
                                 self::TRANSCODE_LAME_CMD, $pcmFile, 
                                 escapeshellarg($outputFilePath));
                                       
      // FIX check for errors!
      exec($transcodeMp3Cmd);    

      if ($pcmIsTmp) 
      {
        unlink($pcmFile);
      }

    }*/
    
    return array('newFileName'   => basename($outputFilePath), 
                 'convertedMime' => 'audio/mpeg',
                 'detectedMime'  => $this->_detectedMime);
  }


  /**
   * Decodes an audio file into a PCM WAV file.
   *
   * @param string $fileName       the file that should be decoded
   * @param string $outputFileName put result in this file
   *
   * @return void
   */
  private function _decodeAudio($fileName, $outputFileName)
  {
    if (strpos($this->_getFileType($fileName), 'Standard MIDI data') !== false)
    {
      $transcodeWavCmd = sprintf('%s -Ow -o %s %s 2>&1',
                               self::TRANSCODE_TIMIDITY_CMD, $outputFileName, 
                               escapeshellarg($fileName));
      
    }
    else
    {
      $transcodeWavCmd = sprintf('/usr/bin/env MPLAYER_VERBOSE=-2 %s -msglevel all=5 -nolirc -nojoystick -vo null -vc null -ao pcm:fast:waveheader:file=%s %s 2>&',
                                 self::TRANSCODE_MPLAYER_CMD,
                                 $outputFileName, 
                                 escapeshellarg($fileName));
    
      /* MPlayer doesn't seem to give any exit status codes :( */
    }
    // FIX check for errors!
    exec($transcodeWavCmd);
  }
}

