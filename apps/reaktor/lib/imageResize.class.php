<?php
/**
 * Resize and move image maintaining aspect ratio
 *
 * PHP Version 5
 *
 * @author    Russ Flynn <russ@linpro.no>
 * @copyright 2008 Linpro AS
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 *
 */

/**
 * Resize and move image maintaining aspect ratio
 *
 * PHP Version 5
 *
 * @author    Russ Flynn <russ@linpro.no>
 * @copyright 2008 Linpro AS
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 *
 */
class imageResize
{  
  /**
   * Main class constructor
   * 
   * @param string $postImage location of image
   * @param string $newFile   file to be created
   * @param int    $maxWidth  maximum allowed image width
   * @param int    $maxHeight maximum allowed image height   
   * 
   * @return null
   */
  function __construct($postImage, $newFile, $maxWidth = 10000, $maxHeight = 10000, $forceSize = false )
  {
    $this->originalFile = $postImage;
    $this->newFile      = $newFile; 
    
    if (!$picInfo = @getimagesize($this->originalFile))
    {
      throw new Exception ("Reading the image ($postImage) failed");
    }
    
    $width              = $picInfo[0];
    $height             = $picInfo[1];
    $mime               = $picInfo["mime"];
    
    if ($width > $maxWidth && $height <= $maxHeight )
    {
      $this->ratio = $maxWidth / $width;
    }
    elseif ($height > $maxHeight && $width <= $maxWidth )
    {
       $this->ratio = $maxHeight / $height;
    }
    elseif ($width > $maxWidth && $height > $maxHeight )
    {
      $ratio1      = $maxWidth / $width;
      $ratio2      = $maxHeight / $height;
      $this->ratio = $ratio1 < $ratio2 ? $ratio1 : $ratio2;
    }
    else
    {
      $this->ratio = 1;
    }
    
    $this->nWidth  = floor($width * $this->ratio);  
    $this->nHeight = floor($height * $this->ratio);
    
    if (!$forceSize)
    {
     $this->force = false;
    }
    else
    {
      $difference         = floor(intval($this->nWidth - $this->nHeight));
      $this->nWidth      += $difference;
      $this->nHeight     += $difference;  
      
      if ($this->nWidth < $maxWidth)
      {
        $widthDifference  = floor($maxWidth - $this->nWidth);
        $this->nWidth    += $widthDifference;
        $this->nHeight   += $widthDifference;
      }
      
      if ($this->nHeight < $maxHeight)
      {
        $heightDifference  = floor($maxHeight - $this->nHeight);
        $this->nWidth     += $heightDifference;
        $this->nHeight    += $heightDifference;
      }
      
      $this->forceWidth   = $maxWidth;
      $this->forceHeight  = $maxHeight;
      $this->force        = true;
    }
  }
  
  /**
   * convert and write the image to disk
   *  
   * @return null - image is written to disk
   */
  public function imageWrite()
  {
    // Send to imagemagick for resizing
    // ZOID: Needs some error checking & QC, should also check mime in db
	/*
	 * Bugfix for #21554: Major: Gif-animation does not play
	 * @author Robert Strind <robert.strind@redpill-linpro.com>
	 *
	 * Try first to find out if this is a gif file we are resizing
	 * If that is the case add coalesce parameter to the convert command.
	 *
	 * This fix does not adress cropped files.
	 *
	 * Fully define the look of each frame of an GIF animation sequence, to form
	 * a 'film strip' animation.
	 *
	 * This will not affect gifs that are not animated.
	 */
	$coalesce = '';
	
	if (class_exists('Transcoder')) {
		$transcoder = new Transcoder();
		$mimetype = $transcoder->getFileType2($this->originalFile);
		if( $mimetype == 'image/gif' ) {
			$coalesce = ' -coalesce';
		}
	}
	  $command = "convert ".$this->originalFile.$coalesce." -resize ".$this->nWidth."x".$this->nHeight."! ".$this->newFile." 2>&1"; 
      
    exec($command, &$result, &$returnVal); 
    
    if ($this->force)
    {
      $command = "convert ".$this->newFile." -gravity center -crop ".$this->forceWidth."x".$this->forceHeight."+0+0 ".$this->newFile." 2>&1";
      exec($command, &$result2, &$returnVal2);
    }
    
    if ($returnVal != 0 || !file_exists($this->newFile))
    {
      if (sfContext::getInstance()->getUser()->hasCredential("debug"))
      {
        $extra = $result[0];
      }
      else
      {
        $extra = "";
      }
      throw new Exception("Writing the new image failed ".$extra);   
    }
  }
}    
