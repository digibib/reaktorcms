<?php
/**
 * Serve content to the web from a hidden location
 * 
 * This is required so content which is not yet public cannot be directly accessed
 *
 * PHP Version 5
 *
 * @author    Russ Flynn <russ@linpro.no>
 * @copyright 2008 Linpro AS
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 *
 */

/**
 * Serve content to the web from a hidden location
 * 
 * This is required so content which is not yet public cannot be directly accessed
 *
 * PHP Version 5
 *
 * @author    Russ Flynn <russ@linpro.no>
 * @copyright 2008 Linpro AS
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 *
 */
class contentServerActions extends sfActions
{
  /**
   * The file identifier, (image, pdf)
   *
   * @var string
   */
  protected $_identifier;
  
   /**
   * The original name (the name to use when serving the file)
   * For example myimage.jpg
   *
   * @var string
   */
  protected $_originalName;
  
  /**
   * The content type (mime type) of the file
   *
   * @var string
   */
  protected $_contentType;
  
  /**
   * The actual name of the file on the server
   *
   * @var string
   */
  protected $_realname;
    
  /**
   * The full path to the file on the server
   *
   * @var string
   */
  protected $_filePath;
  
  /**
   * The Return type of the file (thumbnail/mini etc)
   *
   * @var unknown_type
   */
  protected $_returnType;
  
 /**
   * From routing /content/:id/:filename
   * Serve the normal file that will be shown on the artwork view
   * 
   * @return null
   *
   */
  public function executeContentServer()
  { 
    $this->_getFile("converted");
  }
  
  /**
   * From routing /content/:id/thumb/:filename
   * Serve the thumbnail image associated with a file
   *
   * @return null
   */
  public function executeContentThumb()
  {
    $this->_getFile("thumbnail");
  }
  
    /**
   * From routing /content/:id/mini/:filename
   * Serve the mini thumbnail image associated with a file
   *
   * @return null
   */
  public function executeContentMini()
  {
    $this->_getFile("thumbnail", "/mini");
  }
  
  /**
   * From routing /content/:id/original/:filename
   * Serve the original (non resized) version of a file
   * If one exists
   * 
   * @return null
   *
   */
  public function executeContentOriginal()
  {
    $this->_getfile("original");
  }
  
  /**
   * Look up the file from the DB and gather the required information
   *
   * @param string $returnType The mode based on the route to this script
   * @param string $subsubdir  The sub-sub directory (for example when using mini)
   * 
   * @return nothing - calls the page renderer if all ok
   */
  protected function _getFile($returnType, $subsubdir = "")
  {
  	$contentDir        = sfConfig::get('upload_dir', 'content');
    $fileId            = $this->getRequestParameter('id');        
    $authSql           = "";
    $subdir            = "";
    $this->_returnType = $returnType;
    $c = new Criteria();
   
    $c->add(ReaktorFilePeer::ID, $fileId);
    $c->setLimit(1);
    if (!$this->getUser()->hasCredential("viewallcontent"))
    {
      $crit = $c->getNewCriterion(ReaktorArtworkPeer::STATUS, 3);
      $crit->addOr($c->getNewCriterion(ReaktorFilePeer::USER_ID, $this->getUser()->getId()));
      $c->add($crit);
    }
     
    $resultset = ReaktorArtworkFilePeer::doSelectJoinAll($c);
    $resultset = array_shift($resultset);
    if (!$resultset)
    {
      $c = new Criteria();
      
    if (!$this->getUser()->hasCredential("viewallcontent"))
      $c->add(ReaktorFilePeer::USER_ID, $this->getUser()->getId());
      $c->add(ReaktorFilePeer::ID, $fileId);

      $fileObj = ReaktorFilePeer::doSelectOne($c);
    } else
    {
    
      $fileObj = $resultset->getReaktorFile();
    }
    // If we didn't get a hit then we should use a "file not found" image or similar
    // Most likely is that the parent artwork/user has been removed/disabled
    if (!$fileObj)
    {
      $this->_sendFileNotFound();
    }
    
    $this->_realname     = $fileObj->getRealPath();
    $this->_originalName = $fileObj->getFilename();
    $this->_identifier   = $fileObj->getIdentifier();
    $this->_originalpath   = $fileObj->getOriginalpath();
    $location           = "/content/".$this->_identifier;
    $mimeFunc           = 'get'.ucfirst($returnType).'MimetypeId';
    $mimeTypeId         = $fileObj->$mimeFunc();
    



// to avoid wrong mimetype of movie thumbnail
 if (($returnType == "thumbnail" || $returnType == "mini") && $this->_identifier != "image") {
	 $this->_contentType = "image/jpeg";
	}else {
	$this->_contentType  = FileMimetypePeer::retrieveByPK($mimeTypeId)->getMimeType();
	}

 
 if ($returnType != "converted") 
    {
      $subdir = "/".$returnType;
      if ($returnType == "thumbnail" && $this->_identifier != "image")
      {
        $this->_realname .= ".jpg";
      }
    }
    if ($returnType != 'original')
    {
    
      $this->_filePath = sfConfig::get('sf_root_dir').$location.$subdir.$subsubdir."/".$this->_realname; 
    } 
    else
    {
      $this->_contentType = "application/octet-stream";
      $this->_filePath = sfConfig::get('sf_root_dir').$location.$subdir.$subsubdir."/".$this->_originalpath;
    }
   
   
    if (!$this->_fileOk() && $returnType == "thumbnail")
    {
      if (!$this->_getPostGeneratedFile($fileObj,$location))
      {
        $this->_contentType = "image/gif";
        $this->_filePath    = sfConfig::get('sf_root_dir').$location.$subdir.$subsubdir."/default.gif";

      }
    }
    else
    {
      if (!$this->_fileOk())
      {
      
        $this->_sendFileNotFound();
      }
    }
    $this->_sendpage();
  }
   
  /**
   * Render the page
   * 
   * @return formatted html page
   *
   */
  protected function _sendpage()
  {
    if (ini_get('zlib.output_compression'))
    {
      ini_set('zlib.output_compression', 'Off');
    }

    header("Pragma: public");
    header("Expires: 0");
    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
    header("Cache-Control: private", false);
    header("Content-Type: ".$this->_contentType);
    
    set_time_limit(0);

    @readfile($this->_filePath);
    
    exit(); // Brutal but we should make sure there is no further output once this function is perfomed
  }

  /**
   * Checks to see if a file matches the required criteria to be served
   *
   * @return boolean (true if file exists and is ok)
   */  
  protected function _fileOk()
  { 
sfLoader::loadHelpers('string');
  $path_parts = pathinfo($this->getRequestParameter("filename") );
  $extension = $path_parts['extension'];
    return (file_exists($this->_filePath) && ($this->_originalName == $this->getRequestParameter("filename") 
    || $this->getRequestParameter("filename") == $this->_originalName.".".$extension
            || $this->getRequestParameter("filename") == $this->_originalName.".jpg"
            || getThumbNameFromFile($this->getRequestParameter("filename")) == getThumbNameFromFile($this->_originalName)
)
            );
  }
  
  /**
   * Send a file not found image in case of errors
   * Used instead of 404 because it covers artworks that have been removed etc
   * 
   * @return void triggers the send page function
   */
  protected function _sendFileNotFound()
  {
    if ($this->_returnType == "mini")
    {
      $this->_contentType = "image/gif";
      $this->_filePath    = sfConfig::get('sf_web_dir').'/images/filenotfound78x65.gif';  
    }
    else
    {
      $this->_contentType = "image/gif";
      $this->_filePath    = sfConfig::get('sf_web_dir').'/images/filenotfound240x160.gif';  
    } 
    $this->_sendpage();
  }
  
  protected function _getPostGeneratedFile($fileObj, $location)
  {
    $thumbLocation =  sfConfig::get('sf_root_dir').$location."/".$fileObj->getRealPath().".thumb.jpg";
    $newThumb      = sfConfig::get('sf_root_dir').$location."/thumbnail/".$fileObj->getRealPath().".jpg";
    $newMini       = sfConfig::get('sf_root_dir').$location."/thumbnail/mini/".$fileObj->getRealPath().".jpg";

    if (file_exists($thumbLocation) && (!file_exists($newThumb) || !file_exists($newMini)))
    {

      $image = new imageResize($thumbLocation,
        $newThumb,
        240,
        160,
        true);
      $image->imageWrite();

      $image = new imageResize($thumbLocation,
        $newMini,
        78,
        65,
        true);
      $image->imageWrite();
      unlink($thumbLocation);
      
      $fileObj->setThumbnailMimetypeId(2);
      $fileObj->save();
      
      header("Location: ".$this->getRequest()->getUri());
    }
    return false;
  }
}

