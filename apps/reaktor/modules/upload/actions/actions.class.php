<?php
/**
 * Upload page
 *
 * PHP Version 5
 *
 * @author    Russ Flynn <russ@linpro.no>
 * @copyright 2008 Linpro AS
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 *
 */

/**
 * The main upload class file
 *
 * PHP Version 5
 *
 * @author    Russ Flynn <russ@linpro.no>
 * @copyright 2008 Linpro AS
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 *
 */
class uploadActions extends sfActions
{
  /**
   * The identifier used to connect the file to a type
   * For example: image, video, pdf...
   *
   * @var string
   */ 
  protected $identifier;
   
  /**
   * The subdirectory to use based on the type
   *
   * @var string
   */
  protected $subdir;
   
  /**
   * The mimetype of the file
   *
   * @var string
   */
  protected $mimeType;
  
  /**
   * The thumbnail name
   * 
   * @var string
   */
  protected $thumbname = "";
  
  /**
   * Shows a list of the user's files, or if admin any user based on params
   * 
   * @return void
   */
  public function executeShowFiles()
  {
    // Lets see if we are an admin user accessing a specific user page
    if ($this->getRequestParameter("user"))
    {
      $this->forward404Unless($this->getUser()->hasCredential('viewallcontent'));
      $userId = $this->getRequestParameter("user");
    }
    else
    {
      $userId = $this->getUser()->getGuardUser()->getId();
    }
    
    $c = new Criteria();
    $c->add(ReaktorFilePeer::USER_ID, $userId);
    $c->addAscendingOrderByColumn(ReaktorFilePeer::UPLOADED_AT);
    
    if (!$userFilesArray = ReaktorFilePeer::doSelect($c))
    {
      return sfView::SUCCESS;
    }
    
    foreach ($userFilesArray as $key => $fileObject)
    {
      $userFiles[] = new artworkFile($fileObject->getId());
    }
    
    $this->userFiles = $userFiles;
    
  }
 
 

 
 
/**
   * Uploads the file and triggers events associated with the upload
   * 
   * @return void
   */
  public function executeUpload()
  {
//sfLoader::loadHelpers(array("Debug"));
//  log_message('test message');
    // Is the user trying to link this file to another artwork? 





	
    if ($this->getRequestParameter("link_artwork_id") > 0)
    {
      // Check if they own the artwork, or are allowed to link to it
      try
      {   
        $linkArtwork = new genericArtwork($this->getRequestParameter("link_artwork_id"));       
      }
      catch (exception $e)
      { 
        return $this->redirect(Subreaktor::addSubreaktorToRoute("@upload_content"));
      }
      if ($linkArtwork->getUserId() != $this->getUser()->getGuardUser()->getId() && !$this->getUser()->hasCredential('editusercontent'))
      {
        return $this->redirect(Subreaktor::addSubreaktorToRoute("@upload_content"));
      }
      else
      {    
        $this->artwork = $linkArtwork; // For the template
        $extraParam         = "&link=".$linkArtwork->getId();
      }
    }
    else
    {
      $extraParam = ""; //x
    }
    
    $this->forward404Unless($this->getUser()->hasCredential('uploadcontent'));
    
    if ($this->getRequest()->getMethod() != sfRequest::POST && !$this->getRequestParameter("mce_data"))
    {
      return sfView::SUCCESS;
    }
     
    //******* File has been uploaded ********/
    
    if (!$this->getRequest()->getFileName('file') && !$this->getRequestParameter('mce_data'))
    {
      return $this->returnError('Please select a valid file');
    }
    
    $webAbsCurrentDir       = '/'.$this->uploadDirName;
    $meta                   = array();

    if ( !$this->getRequestParameter('mce_data')  )
    {
      $this->originalFilename = $this->sanitizeFile($this->getRequest()->getFileName('file'));
      $this->filename         = $this->nameFile($this->originalFilename);

      /* mime_content_type is deprecated but the alternatives were becoming a nightmare to set up
       * sometimes this function returns false (for example with wma files) in which case we then revert to
       * the mime type that the browser sends. It seems to work.
      */ 
	
#	if (!$this->mimeType = mime_content_type($this->getRequest()->getFilePath('file')))


/*

    mime_content_type funcion have been replaced by getFileType2 in the transcoderlibrary
    
    !!!!!!!!!!!!!!!!!!!!!!!!!
    If you have problem witch mimetype detection!
    Please remeber to give write access to apache user home direcory, so it can create ~/.gnome folder which is needed by one of library
    !!!!!!!!!!!!!!!!!!!!!!!!!
    
*/

        $outputBaseDir   = sfConfig::get('sf_root_dir')."/".sfConfig::get('app_upload_upload_dir')."/";
        $transcoder      = new transcoder($outputBaseDir); 


	if (!$this->mimeType = $transcoder->getFileType2($this->getRequest()->getFilePath('file')))
     {
        $this->mimeType = $this->getRequest()->getFileType('file');

      } 
    } 
    else
    {
      $this->filename         = $this->nameFile($this->originalFilename).".html";
      $this->originalFilename = $this->filename;
      $this->mimeType         = "text/html";
    }
		
     
    $info['ext']            = strtolower(substr($this->filename, strpos($this->filename, '.') - mb_strlen($this->filename, 'UTF-8') + 1));
    $info['size']           = $this->getRequest()->getFileSize('file');
    $convertedMime          = $this->mimeType; // ZOID: These are a bit dirty in the db so improve
    $thumbMime              = $this->mimeType;
    $this->originalPath     = $this->filename;
	
    //Get parameters
    if ($paramArray = $this->getParams($this->mimeType))
    {
      $this->identifier = $paramArray["identifier"];
      $this->subdir     = $paramArray["subdir"];
    
	}
    else
    {   
      if ($this->getUser()->hasCredential("viewdetailederrors"))
      {
        return $this->returnError('Mime type does not exist in db: '.$this->mimeType);
      }
      //Trick to make script translate 
      $translateMe   = sfContext::getInstance()->getI18N()->__('Unsupported file type');
      return $this->returnError('Unsupported file type');
    }
    
    //If linking, lets check that the user is uploading a file of the same type
    
    if (isset($linkArtwork) && !in_array($this->identifier, $linkArtwork->getEligbleFileTypes()))
    {
      $this->getRequest()->setError('link_error', $this->identifier);
      return $this->returnError("Wrong file type");
    }
    
    $this->absCurrentDir = $this->uploadDir.'/'.$this->subdir;
    
    if ( !is_dir($this->absCurrentDir) || !file_exists($this->getRequest()->getFilePath('file')) )
    {
      if ( $this->getRequestParameter('mce_data') && is_dir($this->absCurrentDir) )
      {
        $text = $this->stripTags($this->getRequestParameter('mce_data'));
        file_put_contents($this->absCurrentDir . '/' . $this->filename,$text);
      } 
      else
      {
        return $this->returnError('The upload failed');
      }
    }
    
    
    switch ($this->identifier) {

    case "image": 

      try
      {
        if ($this->useThumbnails) 
        {
        	$this->createThumb();
        }
        $this->processImage();
      }
      catch (Exception $e)
      {
	$this->getRequest()->setError('file', sfContext::getInstance()->getI18N()->__('Reading the image failed'));
        return sfView::SUCCESS;
      }

    break;


    case "pdf": 
      try 
      {
        $this->createPdfThumb();
      }
      catch (Exception $e)
      {
        $this->getRequest()->setError('file', 'Reading the pdf failed');
        return sfView::SUCCESS;
      }
    break;
    
    case "text": 
      //After moving the text creation, text is written _after_ the thumb is generated,
      //We better leave the artwork with the default thumb
      /*try 
        {
          $this->createHTMLThumb($this->uploadDir.'/'.$this->subdir.'/'.$this->filename);
          
        }
        catch (Exception $e)
        {
          $this->getRequest()->setError('file', 'Reading the text failed');
          return sfView::SUCCESS;
        }
      */
    break;

default:

;



    }
    
    
    
    // Is this a media type we must transcode? 
    if ((($this->identifier == "video" && $this->mimeType != 'application/x-shockwave-flash') || ($this->identifier == "audio" && $info['ext'] != "mp3") || ($this->identifier == "container")) && ($this->mimeType != 'image/gif'))
    {
      // Now send for transcoding
	  
      try
      {
//        $outputBaseDir   = sfConfig::get('sf_root_dir')."/".sfConfig::get('app_upload_upload_dir')."/";
//        $transcoder      = new transcoder($outputBaseDir); 
        $file            = $this->getRequest()->getFilePath('file');
        $transcodingInfo = $transcoder->transcode($file, $this->filename, array("suggested_mime" => $this->mimeType));

        $this->filename      = $transcodingInfo['newFileName'];
        $this->convertedMime = $transcodingInfo['convertedMime'];
        $this->mimeType      = $transcodingInfo['detectedMime'];

        $dir = null; 
        switch ($this->convertedMime)
        {
          case 'video/flv':
            $dir = 'video';
            $this->identifier    = "video";
            $this->subdir        = "video";
            $this->absCurrentDir = $this->uploadDir.'/'.$this->subdir;

            break;
          case 'audio/mpeg':
            $dir = 'audio'; 
            $this->identifier    = "audio";
            $this->subdir        = "audio";
            $this->absCurrentDir = $this->uploadDir.'/'.$this->subdir; 
            break;

          default:
            throw new Exception('Unhandled mime type');
            break;
        }
      }
      catch (Exception $e)
      {
        if ($this->getUser()->hasCredential("viewdetailederrors"))
        {
          return $this->returnError(sfContext::getInstance()->getI18N()->__("Converting the file failed")." - ".$e->getMessage());
        }
	return $this->returnError(sfContext::getInstance()->getI18N()->__("Converting the file failed"));
      }
      $orig = $outputBaseDir.$dir."/original/".$this->originalPath;
      copy($file, $orig);

      if ($this->convertedMime == 'video/flv')
      {
              
        new videoFrame();
        $vf = videoFrame::fromVideoFile($file);
        if ($vf)     
        {
                  $this->createThumbFromVideoFrame($vf);
        }
        
      }
    }
    else
    {
      // Doesn't need transcoding, move the file from temp dir to main dir
      $this->getRequest()->moveFile('file', $this->absCurrentDir.'/'.$this->filename);
      if ($this->mimeType == "text/html")
      {
        $html_data = file_get_contents($this->absCurrentDir.'/'.$this->filename);
        file_put_contents($this->absCurrentDir.'/'.$this->filename,$this->stripTags($html_data));
      }
    }
      
    //Save file information to database via the artworkFile object
    try
    {
      $uploadedFile = new artworkFile();
      $uploadedFile->setPath($this->filename);
      $uploadedFile->setOriginalpath($this->originalPath);
      $uploadedFile->setFilename($this->originalFilename);
      $uploadedFile->setThumbpath($this->thumbname);

      $uploadedFile->setIdentifier($this->identifier);
      $uploadedFile->setMimetype($convertedMime, "converted");
      $uploadedFile->setMimetype($this->mimeType, "original");
      $uploadedFile->setMimetype($thumbMime, "thumbnail");
      $uploadedFile->setUploadedAt(time());
      $uploadedFile->setModifiedAt(time());
      if (isset($linkArtwork) && $this->getUser()->hasCredential("editusercontent"))
      {
        $uploadedFile->setUserId($linkArtwork->getUserId());
      }
      else
      {
        $uploadedFile->setUserId($this->getUser()->getGuardUser()->getId());
      }
     
      $uploadedFile->save();
  
    
      //Add the file metadata that we can automatically extract
      $this->addMeta($info, $uploadedFile);
      
      // Lets add the current user as "creator"
      if (!$uploadedFile->getMetadata("creator") && $this->getUser()->getGuardUser()->getUserName())
      {
        $uploadedFile->addMetadata("creator", null, $this->getUser()->getGuardUser()->getUserName());
      }
      HistoryPeer::logAction(11, $this->getUser()->getId(), $uploadedFile);
      $this->redirect(Subreaktor::addSubreaktorToRoute('@edit_upload?fileId='.$uploadedFile->getId().$extraParam));
    }
      
    catch (Exception $e)
    {
      if ($this->getUser()->hasCredential("viewdetailederrors"))
      {
        return $this->returnError('Error saving file: '.$e->getMessage());
      }
      $this->returnError('Unsupported file type');
    }  
  }
  
  function executeUploadAttachment()
  {
    $this->getTracker()->setEnabled(false);
    sfConfig::set('sf_web_debug', false);
    do {
      if (!($this->getUser()->isAuthenticated()))
      {
        $error = "You cannot do that";
        break;
      }

      if (!is_uploaded_file($this->getRequest()->getFilePath('file')))
      {
        $error = "Not uploading?";
        break;
      }

      $article_id = $this->getRequestParameter("article_id");

      if (!$article_id || !($article = ArticlePeer::retrieveByPK($article_id)))
      {
        $error = "Cannot find the article to attach to";
        break;
      }

      $access = ArticlePeer::getArticleTypesByPermission($this->getUser());
      if (!isset($access[$article->getArticleType()]))
      {
        $error = "You are not allowed to do that";
        break;
       }

      $banner = (bool)$this->getRequestParameter("banner");

      $path  = sfConfig::get("sf_web_dir") . sfConfig::get("app_upload_attachment_dir", "attachment") . "/";
      $ofn   = $this->sanitizeFile($this->getRequest()->getFileName('file'));
      $fn    = $this->nameFile($ofn);

      $mime = FileMimetypePeer::retrieveByMimetype($this->getRequest()->getFileType('file'));
      if (!$mime)
      {
        $error = "Invalid mime type";
        break;
      }

      $file = new ArticleFile;
      $file->setPath($path);
      $file->setFilename($fn);
      $file->setsfGuardUser($this->getUser()->getGuardUser());
      $file->setUploadedAt($_SERVER['REQUEST_TIME']);
      $file->upload($this->getRequest()->getFilePath('file'));
      $file->setFileMimeType($mime);
      $file->save();

 //if($article->getArticletype()==2){
//      if (!$banner)
//      {
//        $attachment = new ArticleAttachment;
//        $attachment->setArticleFile($file);
//
//        $article->addArticleAttachment($attachment);
//
//        $attachment->save();
//      }
//      else
//      {
//        $article->setBannerFileId($file->getId());
//      }

//7      $article->save();
// }
#    sfLoader::loadHelpers('Partial');
#    return $this->renderText(get_component('filelist', 'browseFiles', array(
#      'article'  => $article->getId(),
#      'chosen_format' => $this->getRequestParameter('chosen_format'),
#    )));
 
      $this->forward('filelist', 'browseFiles',array());
     // return $this->renderText("OK");

    } while(false);
    return $this->renderText($error);
  }
 
  /**
   * File uploaded, now we need to do something with it
   * Could also be used for editing "after the event"
   * 
   * @return void - the template 
   */
  public function executeEdit()
  {
    $fileId = intval($this->getRequestParameter('fileId'));
    try
    {
      //sfContext::getInstance()->getLogger()->info("Before creating file object with ID: ".$fileId);
      $this->thisFile = new artworkFile($fileId);
      //sfContext::getInstance()->getLogger()->info("After creating file object".$fileId);
    }
    catch (Exception $e)
    {
      $this->forward404($e);
    }
    
    $filename     = $this->thisFile->getFilename();
    $submitter_id = $this->thisFile->getUserId();
    
    //Check that this user is allowed to be on this page, either the user who submitted
    //the file, or an admin user with the correct credentials.
    $this->forward404Unless($submitter_id == $this->getUser()->getGuardUser()->getId() 
      || $this->getUser()->hasCredential('editusercontent'));
    
    // This will be overridden by the i18n in the template but must be set here so it appears at the top
    $artworkArray[0] = "--- Select the artwork to attach this file to ---"; 
    
    $eligibleArtwork = ReaktorArtworkPeer::getLinkableArtworks($this->thisFile); 
    
    if ($eligibleArtwork)
    {
      foreach ($eligibleArtwork as $artworkObject)
      {
        $artworkArray[$artworkObject->getId()] = $artworkObject->getTitle(); 
      }
    }
    $this->artworkArray = $artworkArray;
   
    //if not post, and html file, read the file content
    if ($this->getRequest()->getMethod() != sfRequest::POST && $this->thisFile->getIdentifier() == "text")
    {
      $paramArray = $this->getParams($this->thisFile->getMimetype());
      $this->identifier = $paramArray["identifier"];
      $this->subdir     = $paramArray["subdir"]; 
    
      $this->filename      = $this->thisFile->getRealPath();
      $this->absCurrentDir = $this->uploadDir.'/'.$this->subdir;
      $this->mce_data      = file_get_contents($this->absCurrentDir . '/' . $this->filename);
    
    }
    // Stop here and display the form if no form submission
    if ($this->getRequest()->getMethod() != sfRequest::POST)
    {
      return sfView::SUCCESS;
    }
       
    if ($this->getRequest()->hasErrors())
    {
      //Take care of the already entered metadata when form errs
      $this->thisFile->fillinMetaData("title", null, $this->getRequestParameter('title'));
      $this->thisFile->fillinMetaData("creator", null, $this->getRequestParameter("author"));
      $this->thisFile->fillinMetaData("relation", "references", $this->getRequestParameter("resources"));
      $this->thisFile->fillinMetaData("license", null, $this->getRequestParameter("meta_license"));
      if ($this->thisFile->getMimetype() != "text/html")
      {        
        $this->thisFile->fillinMetadata("description", "abstract", $this->getRequestParameter("description"));
        $this->thisFile->fillinMetadata("description", "creation", $this->getRequestParameter("production"));
        //$this->thisFile->fillinMetadata("relation", "references", $this->getRequestParameter("resources"));
      }
      return sfView::SUCCESS;
    }

    $this->thisFile->addMetadata("title", null, $this->getRequestParameter('title'));
    $this->thisFile->addMetadata("creator", null, $this->getRequestParameter("author"));
    $this->thisFile->addMetadata("relation", "references", $this->getRequestParameter("resources"));
    $this->thisFile->addMetadata("license", null, $this->getRequestParameter("meta_license"));
    $main_mime_type = substr($this->thisFile->getMimetype(),0,4);
    if ( $main_mime_type == "text" )
    {
      $paramArray = $this->getParams($this->thisFile->getMimetype());
      $this->identifier = $paramArray["identifier"];
      $this->subdir     = $paramArray["subdir"]; 
      
      $this->filename   = $this->thisFile->getRealPath();
      $text = $this->stripTags($this->getRequestParameter('mce_data'));
      $this->absCurrentDir = $this->uploadDir.'/'.$this->subdir;
      file_put_contents($this->absCurrentDir . '/' . $this->filename,$text);
      $this->mce_data = $text;
      
    }
    else
    {
      $this->thisFile->addMetadata("description", "abstract", $this->getRequestParameter("description"));
      $this->thisFile->addMetadata("description", "creation", $this->getRequestParameter("production"));
    }
    
    /* Check if this file is linked to any artworks already, and if so, we need to
    Make sure they are flagged for follow up - unless being
    Edited by an admin user with editusercontent credential*/
 
    try
    {
      if ($this->thisFile->hasArtwork() && !$this->getUser()->hasCredential('editusercontent'))
      {
        $parentArtworks = $this->thisFile->getParentArtworks();
        foreach($parentArtworks as $parentArtwork)
        {  
          if ($parentArtwork->getStatus() == 3)
          {  
            sfLoader::loadHelpers(array("Url", "Tag"));
            $translateMe = sfContext::getInstance()->getI18n()->__("The following file was edited");
            $parentArtwork->flagChanged($this->getUser(), "The following file was edited");
            $parentArtwork->flagChanged($this->getUser(), " - ".link_to($this->thisFile->getTitle()." (".$this->thisFile->getId().")", "@edit_upload?fileId=".$this->thisFile->getId()));
            $parentArtwork->save();
          }
        }
      }
    }
    catch (Exception $e)
    {
      die($e->getMessage());
    }
    $this->thisFile->save();
    // Are we creating a new artwork?
    if ($this->getRequestParameter("new_artwork"))
    {
      try
      {
        $newArtwork = new genericArtwork();
        $newArtwork->setTitle($this->getRequestParameter('title'));
        $newArtwork->setUserId($submitter_id);
        $newArtwork->setArtworkType($this->thisFile->getIdentifier()); 
        $newArtwork->setDescription($this->thisFile->getMetadata("description", "abstract"));
        $newArtwork->save();
        
        // Add local reaktor automatically if we are in one now
        if (Subreaktor::getProvidedLokalReference())
        {
          $newArtwork->addSubreaktor(Subreaktor::getProvidedLokalReference());
        }

//Add artwork to LokalReaktor if user residence = reaktor residence
// Ticket 23735
    $LokalReaktorsByResidences=LokalreaktorResidencePeer::getSubreaktorsByResidence($this->getUser()->getGuardUser()->getResidenceId());

    if(is_array($LokalReaktorsByResidences)) {
    foreach($LokalReaktorsByResidences as $LokalReaktor)
          $newArtwork->addSubreaktor($LokalReaktor->getSubreaktorId());
    
    }

        
        $newArtwork->addFile($this->thisFile->getId());
        
        // Add subreaktor too if we are in one
        // Will only work if subreaktor is relevant, for example an image won't be added to video subreaktor
        // Fix bug #473, customer does not want this.
        /*if (Subreaktor::getProvidedSubreaktor())
        {
          $newArtwork->addSubreaktor(Subreaktor::getProvidedSubreaktor()->getId());
        }*/   
        $newArtwork->resetFirstFile();
      }
      catch (Exception $e)
      {
        // ZOID: Move to general error area
        $this->getRequest()->setError("title", $e->getMessage());
        //$this->getRequest()->setError("title", "Error creating new artwork");
        return sfView::SUCCESS;
      }
       // Redirect back to upload page if they chose to
      if ($this->getRequestParameter("upload_another"))
      {
        return $this->redirect(Subreaktor::addSubreaktorToRoute("@artwork_link?link_artwork_id=".$newArtwork->getId()));
      }
      else
      {
      	//$tmproute = '@show_artwork?title='.$newArtwork->getTitle().'&id='.$newArtwork->getId();
      	//Subreaktor::addSubreaktorToRoute('@show_artwork?title='.$newArtwork->getTitle().'&id='.$newArtwork->getId());
        $this->redirect(Subreaktor::addSubreaktorToRoute('@edit_artwork?id='.$newArtwork->getId()));
      }
    }
    elseif ($this->getRequestParameter("link_artwork")) 
    {
      try
      {
        $artwork = new genericArtwork($this->getRequestParameter("artwork_select"));
        $artwork->addFile($this->thisFile);
        if (!$artwork->isDraft())
        {
          $artwork->changeStatus($this->getUser()->getGuardUser()->getId(), ReaktorArtwork::SUBMITTED); //Set the status back to ready for approval
        }
        $artwork->save();
        $artwork->resetFirstFile();
      }
      catch (Exception $e)
      {
        //ZOID: Move to general error area
        $this->getRequest()->setError("title", "Error linking artwork");
        return sfView::SUCCESS;
      }
      if ($this->getRequestParameter("link_another"))
      {
        return $this->redirect(Subreaktor::addSubreaktorToRoute("@artwork_link?link_artwork_id=".$artwork->getId()));
      }
      else
      {
      	return $this->redirect(Subreaktor::addSubreaktorToRoute('@edit_artwork?id='.$artwork->getId()));
      }    
    }
    else
    {
      //Everything went ok so lets give a message to say so
      $this->successful = true;
      return sfView::SUCCESS;
    }
  }
  
  /**
   * File validator - ZOID: IS THIS USED?
   * Placed here instead of in Yaml file so it will be processed regardless
   * of any other form errors
   * 
   * @param string $fieldName the value to look for in the post request
   * 
   * @return boolean success or failure of validation 
   */
  protected function validateFile($fieldName)
  {
    $name = $this->getRequest()->getFilename($fieldName);
    if (!$name)
    {
      return false;
    }
    
    $myValidator = new sfFileValidator();
    $myValidator->initialize($this->getContext(), array(
      'mime_types' => array('image/jpeg'),
      'mime_types_error' => 'Only JPEG images are allowed',
      'max_size' => 512000,
      'max_size_error' => 'Max size is 512Kb'
    ));
    $file_array = $this->getRequest()->getFile($fieldName);
    if (!$myValidator->execute($file_array, $error))
    {  
      $this->getRequest()->setError($fieldName, $error);
      return false;
    }
    return true;
  }
  
  /**
   * Direct form errors back to main template
   *
   * @return void
   */
  public function handleErrorEdit()
  {
    $this->executeEdit();
    return sfView::SUCCESS;
  }

  /**
   * Set new thumbnail for artwork file or avatar for user
   *
   * @param object $selectedObject The file or user object
   * @param string $postname       The name of the posted file
   * 
   * @return void The thumb is written to the thumbnail dir
   */
  protected function setNewThumb($selectedObject, $postname = "newimage")
  {
    $tempFile = $this->getRequest()->getFileValue($postname, 'tmp_name');
   
    if ($selectedObject instanceof artworkFile)
    {
      $identifier    = $selectedObject->getIdentifier();
      $name          = $selectedObject->getRealpath();
      $path          = sfConfig::get('sf_root_dir')."/".sfConfig::get("app_upload_upload_dir")."/".$selectedObject->getIdentifier()."/thumbnail/".$selectedObject->getRealpath();
      $miniPath      = sfConfig::get('sf_root_dir')."/".sfConfig::get("app_upload_upload_dir")."/".$selectedObject->getIdentifier()."/thumbnail/mini/".$selectedObject->getRealpath();
      $maxWidth      = sfConfig::get('app_upload_fix_thumb_width', '150');
      $maxHeight     = sfConfig::get('app_upload_fix_thumb_height', '150');
      $miniMaxWidth  = sfConfig::get('app_upload_fix_mini_width', '150');
      $miniMaxHeight = sfConfig::get('app_upload_fix_mini_height', '150');
    }
    elseif ($selectedObject instanceof sfGuardUser)
    {
      $identifier = "image"; 
      $oldAvatar  = $selectedObject->getAvatar();
      
      if ($oldAvatar != "" && file_exists(sfConfig::get('app_profile_avatar_path').$oldAvatar))
      {
        //IE was not updating the image so instead of overwriting we're deleting and replacing (with new filename)
        unlink(sfConfig::get('app_profile_avatar_path').$oldAvatar);
      }
      
      $explodeAvatarFilename = explode(".", $this->getRequest()->getFilename($postname));
      $fileExtension         = end($explodeAvatarFilename);
      $random                = stringMagick::randomString();
      $avatar                = time().$random.'.'.$fileExtension;
      $selectedObject->setAvatar($avatar);
      $selectedObject->save();
      
      $path      = sfConfig::get('app_profile_avatar_path').$avatar;
      $maxWidth  = sfConfig::get('app_profile_max_image_width');
      $maxHeight = sfConfig::get('app_profile_max_image_height');
      
    }
    else
    {
      throw new Exception("Wrong object type");
    }

    if (!$this->getRequest()->getFilename($postname))
    {
      throw new Exception("No image submitted");
    }
    $ext = "";
    if ($identifier != "image")
    {
      $ext = ".jpg";
    }
     
    try
    {    
      if ($selectedObject instanceof artworkFile || $selectedObject instanceof sfGuardUser )
      {
        $force = true;
      }
      else
      {
        $force = false;
      }
      $resizedImage = new imageResize($tempFile,
      $path.$ext,
      $maxWidth,
      $maxHeight,
      $force);
      // ZOID: Should refactor the create thumb function, maybe in the imageresize class  
      
      $resizedImage->imageWrite();
      
      if ($selectedObject instanceof artworkFile)
      { 
        $miniImage = new imageResize($tempFile,
        $miniPath.$ext,
        $miniMaxWidth,
        $miniMaxHeight,
        true);  
      
        $miniImage->imageWrite();
        
        $selectedObject->setThumbpath($name.$ext);
        $selectedObject->save();  
      }
    } 
    catch (Exception $e)
    {
      if ($selectedObject instanceof sfGuardUser)
      {
        $selectedObject->setAvatar(null);
        $selectedObject->save();
      }
      throw new Exception($e->getMessage());
    } 
  }
  
  /**
   * Get the meta data values and save them
   * 
   * @param array       $info         the info array
   * @param reaktorFile $selectedFile the file object
   * 
   * @return void - just writes the meta values to the db
   */
  protected function addMeta($info, $selectedFile)
  {
    $metaMap = sfYaml::load(sfConfig::get('sf_root_dir')."/apps/reaktor/config/metaMap.yml");
    
    if ($this->identifier == "image") 
    {
      $meta     = @exif_read_data($this->absCurrentDir.'/'.$this->filename, 0, true);
      $metaList = $metaMap["image_list"];
    }
    elseif ($this->identifier == "audio")
    {
      $meta     = $this->getAudioMeta();     
      $metaList = $metaMap["audio_list"];

      $selectedFile->addMetadata("format", "mime", $this->mimeType);     
      $selectedFile->addMetadata("format", "size", $info['size']);
    }
    else
    {
      // Can't continue with other types
      return;
    }
    
    // Process extra mappings from yaml file
    foreach ($metaList as $metaMap => $valuesArray)
    {
      $dcArray   = explode(".", $metaMap);
      $element   = $dcArray[0];
      $qualifier = isset($dcArray[1]) ? $dcArray[1] : null;
        
      foreach ($valuesArray as $thisVal)
      { 
        $arrayMap = explode(".", $thisVal);
        $thisVal  = $meta;
        
        for ($i = 0; $i < count($arrayMap); $i++)
        {
          $thisItem = $arrayMap[$i];
          if (isset($thisVal[$thisItem]))
          {
            $thisVal = $thisVal[$thisItem];
          }
          else 
          {
            continue 2;
          }
        }
        if ($thisVal != "")
        {        
          try
          {
            $selectedFile->addMetadata($element, $qualifier, trim($thisVal));
            continue 2;      
          }
          catch (Exception $e)
          {
            $this->returnError('The upload failed');
          }
          break;
        }
      }
    }
  }
  
  /**
   * Check the file format so we know what to process
   *
   * @param string $mimetype the file mimetype
   * 
   * @return string or false
   */
  protected function getParams($mimetype)
  {
    $c = new Criteria();
    
    $c->add(FileMimetypePeer::MIMETYPE, $mimetype);
    $thisType = FileMimetypePeer::doSelectOne($c);

if (!$thisType)
    {
      return false;
    }
    $identifier = $thisType->getIdentifier();
    $subdir     = sfConfig::get('app_upload_'.$identifier.'_dir', 'text');
    return array("identifier" => $identifier, "subdir" => $subdir);
  }
   
  /**
   * Some preExecute tasks 
   *
   * PHP Version 5
   *
   * @author    Russ Flynn <russ@linpro.no>
   * @copyright 2008 Linpro AS
   * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
   *
   * @return void
   */ 
  public function preExecute()
  {
    if (sfConfig::get('app_upload_use_thumbnails', true) && class_exists('sfThumbnail'))
    {
      $this->useThumbnails = true;
      $this->thumbnailsDir = sfConfig::get('app_upload_thumbnails_dir', 'thumbnail');
    }

    $this->uploadDirName = sfConfig::get('app_upload_upload_dir', 'content');
    $this->uploadDir     = sfConfig::get('sf_root_dir').'/'.$this->uploadDirName;
  }
  
  /**
  * Returns the information about a file that has been uploaded
  * 
  * @param string $filename the uploaded file
  * 
  * @return array
  */
  protected function getInfo($filename)
  {
    $info              = array();
    $info['ext']       = substr($filename, strpos($filename, '.') - mb_strlen($filename, 'UTF-8') + 1);
    $stats             = stat($this->absCurrentDir.'/'.$filename);
    $info['size']      = $stats['size'];
    $info['thumbnail'] = true;
    
    if ($this->identifier = "image")
    {
      if ($this->useThumbnails && is_readable(sfConfig::get('sf_web_dir').$this->webAbsCurrentDir.'/'.$this->thumbnailsDir.'/'.$filename))
      {
        $info['icon'] = $this->webAbsCurrentDir.'/'.$this->thumbnailsDir.'/'.$filename;
      }
      else
      {
        $info['icon']      = $this->webAbsCurrentDir.'/'.$filename;
        $info['thumbnail'] = false;
      }
    }
    else
    {
      if (is_readable(sfConfig::get('sf_web_dir').'/image/'.$info['ext'].'.png'))
      {
        $info['icon'] = '/image/'.$info['ext'].'.png';
      }
      else
      {
        $info['icon'] = '/image/unknown.png';
      }
    }
    return $info;
  }
  
  /**
   * Create thumbnail from standard image
   * 
   * @return void - the image is written to th thumbnail directory
   */
  protected function createThumb()
  {
    if (!is_dir($this->absCurrentDir.'/'.$this->thumbnailsDir))
    {
      // If the thumbnails directory doesn't exist, create it now
      $old = umask(0000);
      @mkdir($this->absCurrentDir.'/'.$this->thumbnailsDir, 0777, true);
      umask($old);
    }
    try
    {
      $thumbnail = new sfThumbnail(sfConfig::get('app_upload_fix_thumb_width', '150'), 
        sfConfig::get('app_upload_fix_thumb_height', '150'), false, true, 80, 'sfImageMagickAdapter');
      $thumbnail->loadFile($this->getRequest()->getFilePath('file'));
      $thumbnail->save($this->absCurrentDir.'/'.$this->thumbnailsDir.'/'.$this->filename);
      $this->thumbname = $this->filename;
      
      $miniThumbnail = new sfThumbnail(sfConfig::get('app_upload_fix_mini_width', '150'), 
        sfConfig::get('app_upload_fix_mini_height', '150'), false, true, 80, 'sfImageMagickAdapter');
      $miniThumbnail->loadFile($this->getRequest()->getFilePath('file'));
      $miniThumbnail->save($this->absCurrentDir.'/'.$this->thumbnailsDir.'/mini/'.$this->filename);
      
    }
    catch (Exception $e)
    {
      throw new Exception($e);
    }
  }
   
  /**
   * Create thumbnail from a videoFrame
   * 
   * @param object $frame the video frame object
   * 
   * @return void - the image is written to the thumbnail directory
   */
  protected function createThumbFromVideoFrame($frame)
  {
    if (!is_dir($this->absCurrentDir.'/'.$this->thumbnailsDir))
    {
      // If the thumbnails directory doesn't exist, create it now
      $old = umask(0000);
      @mkdir($this->absCurrentDir.'/'.$this->thumbnailsDir, 0777, true);
      umask($old);
    }
    $thumbnail = new sfThumbnail(sfConfig::get('app_upload_fix_thumb_width', '150'), 
      sfConfig::get('app_upload_fix_thumb_height', '150'), false, true, 80, 'sfGDAdapter');
    $thumbnail->loadData($frame->getContent(), $frame->getMime());
    $thumbnail->save($this->absCurrentDir.'/'.$this->thumbnailsDir.'/'.$this->filename.'.jpg', 'image/jpeg');
    $this->thumbname = $this->filename;
    
    $miniThumbnail = new sfThumbnail(sfConfig::get('app_upload_fix_mini_width', '150'), 
      sfConfig::get('app_upload_fix_mini_height', '150'), false, true, 80, 'sfGDAdapter');
    $miniThumbnail->loadData($frame->getContent(), $frame->getMime());
    $miniThumbnail->save($this->absCurrentDir.'/'.$this->thumbnailsDir.'/mini/'.$this->filename.'.jpg', 'image/jpeg');
  }
   
  /**
   * Create thumbnail from first page of Pdf
   * Uses imagemagick
   * 
   * @return void - the image is written to th thumbnail directory
   */ 
  protected function createPdfThumb()
  {
    if (!is_dir($this->absCurrentDir.'/'.$this->thumbnailsDir))
    {
      // If the thumbnails directory doesn't exist, create it now
      $old = umask(0000);
      @mkdir($this->absCurrentDir.'/'.$this->thumbnailsDir, 0777, true);
      umask($old);
    }
    
    //ZOID: This should be combined with the image resize class
    $command  = "convert ".$this->getRequest()->getFilePath('file')."[0] -colorspace rgb -resize ";
    $command .= sfConfig::get('app_upload_fix_thumb_width', '106')."x";
    $command .= sfConfig::get('app_upload_fix_thumb_height', '150')."\! ";
    $command .= $this->absCurrentDir.'/'.$this->thumbnailsDir.'/'.$this->filename.".jpg";
    
    $response        = `$command`;
    $this->thumbname = $this->filename.".jpg"; 

    //ZOID: This should be combined with the image resize class
    $command  = "convert ".$this->getRequest()->getFilePath('file')."[0] -colorspace rgb -resize ";
    $command .= sfConfig::get('app_upload_fix_mini_width', '106')."x";
    $command .= sfConfig::get('app_upload_fix_mini_height', '150')."\! ";
    $command .= $this->absCurrentDir.'/'.$this->thumbnailsDir.'/mini/'.$this->filename.".jpg";
    
    $response = `$command`;
  }
  
  /**
   * Create thumbnail from first page of HTML document
   * Uses imagemagick and html2ps
   * 
   * @return void - the image is written to th thumbnail directory
   */ 
  protected function createHTMLThumb($filename)
  {
    if (!is_dir($this->absCurrentDir.'/'.$this->thumbnailsDir))
    {
      // If the thumbnails directory doesn't exist, create it now
      $old = umask(0000);
      @mkdir($this->absCurrentDir.'/'.$this->thumbnailsDir, 0777, true);
      umask($old);
    }
    
    //ZOID: This should be combined with the image resize class
    $command  = "html2ps ".$filename." | ";
    $command  .= "convert -[0] -colorspace rgb -resize ";
    $command .= sfConfig::get('app_upload_fix_thumb_width', '106')."x";
    $command .= sfConfig::get('app_upload_fix_thumb_height', '150')."\! ";
    $command .= $this->absCurrentDir.'/'.$this->thumbnailsDir.'/'.$this->filename.".jpg 2>&1";
    
    $response        = `$command`;
    $this->thumbname = $this->filename.".jpg"; 
    /*echo "<br />";
    echo $command;
    echo "<br />";
    echo $this->absCurrentDir;
    echo "<br />";
    echo $this->thumbnailsDir;
    echo "<br />";
    echo $this->filename;
    echo "<br />";
    print_r($response);
    die();*/
    
    //ZOID: This should be combined with the image resize class
    $command  = "html2ps ".$filename." | ";
    $command  .= "convert -[0] -colorspace rgb -resize ";
    $command .= sfConfig::get('app_upload_fix_mini_width', '106')."x";
    $command .= sfConfig::get('app_upload_fix_mini_height', '150')."\! ";
    $command .= $this->absCurrentDir.'/'.$this->thumbnailsDir.'/mini/'.$this->filename.".jpg";
    
    $response = `$command`;
  }
  
  /**
   * Resize and copy the image
   * 
   * @return void - the image is copied and resized
   */
  protected function processImage() 
  {
    if (!is_dir($this->absCurrentDir.'/original'))
    {
      // If the original image dir doesn't exist
      $old = umask(0000);
      @mkdir($this->absCurrentDir.'/original', 0777, true);
      umask($old);
    }
   
    try
    {
      $resizedImage = new imageResize($this->getRequest()->getFilePath('file'), 
        $this->absCurrentDir.'/'.$this->filename, sfConfig::get('app_upload_max_image_width', '500'), 
        sfConfig::get('app_upload_max_image_height', '500'));
        $resizedImage->imageWrite();
    }
    catch (Exception $e)
    {
      throw new Exception($e->getMessage());
    }
    $this->absCurrentDir .= "/original";
  }

  /**
   * Get all know id3 tags from Audio file
   *
   * @return array - the meta data array
   */
  protected function getAudioMeta()
  {
    $thisInfo = new audioInfo();
    try {
      $meta     = $thisInfo->info($this->uploadDir.'/'.$this->identifier.'/original/'.$this->originalPath);
    }
    catch (Exception $e)
    {
        try {
            // Try again, without the original path..
            $meta = $thisInfo->info($this->uploadDir.'/'.$this->identifier.'/' .$this->originalPath);
            $fail = false;
        } catch(Exception $e) {
            $fail = true;
        }
        if ($fail) {
            //Unhandled - so the user gets no metadata
            $meta = array();

            // If we are in dev environment - probably good to display this error
            if (sfConfig::get("sf_environment" == "dev"))
            {
                die("Could not extract metadata for file: ".$this->uploadDir.'/'.$this->identifier.'/original/'.$this->originalPath);
            }
        }
    }
    
    return $meta;
  }

  /**
   * Give the file a unique filename on the filesystem
   * Uses timestamp and user id
   *
   * @param string $file the existing filename
   * 
   * @return string the new filename 
   */
  protected function nameFile($file)
  {
    return time()."_".$this->getUser()->getGuardUser()->getId()."_".$file;
  }
  
  /**
   * Return the upload page with an error
   *
   * @param string $message the error message to append to the file field
   * 
   * @return void the template is rendered with error message
   */
  protected function returnError($message) 
  {
    if ($this->getRequestParameter('add'))
    {
      $this->getRequest()->setError('file', sfContext::getInstance()->getI18N()->__($message));
      return sfView::SUCCESS; 
    }
  }

  /**
   * Validate edit, the required fields differ depending on the user
   * submission so we'll handle the required fields here.
   * 
   * @return boolean only if validation success
   * 
   */
  public function validateEdit()
  {
    $thisFile = new artworkFile($this->getRequestParameter('fileId'));
    
    if ($this->getRequest()->getMethod() != sfRequest::POST)
    {
      return true;
    }
    if ($this->getRequestParameter("save_draft"))
    {
      $requiredArray = array("title" => $this->getRequestParameter('title'));
    }
    else
    {
      if ($this->hasRequestParameter("mce_data"))
      {
      $requiredArray = array("author" => $this->getRequestParameter('author'),
         "mce_data" => $this->getRequestParameter("mce_data"),
         "title"       => $this->getRequestParameter('title'),
         "meta_license"=> $this->getRequestParameter('meta_license'));
      } 
      else
      {
         $requiredArray = array("author" => $this->getRequestParameter('author'),
         "description" => $this->getRequestParameter("description"),
         "title"       => $this->getRequestParameter('title'),
         "meta_license"=> $this->getRequestParameter('meta_license'));
      }
      // We need to check that there are some tags assigned to this file
      // fix for issue #466 - don't require tags for files - CHANGE IN YML DO NOT COMMENT OUT WORKING CODE!
       $fileTags = $thisFile->getTags(true);
      
      if (count($fileTags) < sfConfig::get("app_tagging_minimum_tags"))
      {
        $error = $this->getContext()->getI18n()->__("Please enter at least %1%", array("%1%" => sfConfig::get("app_tagging_minimum_tags")))." ";
        if (sfConfig::get("app_tagging_minimum_tags") > 1)
        {
          $error .= $this->getContext()->getI18n()->__("tags");
        }
        else
        {
          $error .= $this->getContext()->getI18n()->__("tag");
        }
        $this->getRequest()->setError("tags", $error);
         
      }
    }
    
    foreach ($requiredArray as $param => $value)
    {
      if (!$value)
      {
        $this->getRequest()->setError($param, $this->getContext()->getI18n()->__("Required")); 
      }
    }
    
    if ($this->getRequest()->hasErrors())
    {
      return false;
    }
    return true;
  }
  
  /**
   * Ajax method for updating uploaded images inline
   * Used for thumbnails and avatars
   *
   * @return void
   */
  public function executeUpdateInline()
  {
    if ($this->getRequest()->getMethod() != sfRequest::POST)
    {
      die();
    }
    elseif (!$this->getUser()->isAuthenticated())
    {
      // Handle potential session timeout
      $this->getRequest()->setError("newimage", "Session timed out, refresh and try again");
      return $this->handleErrorUpdateInline();
    }
    
    // Are we editing a thumbnail for a file?
    if ($this->getRequestParameter("fileId"))
    {
      // Since this is a kind of Ajax request, we should be sure that this user should be editing this file
      try
      {
        $thisFile = new artworkFile($this->getRequestParameter("fileId"));
        if ($thisFile->getUserId() != $this->getUser()->getGuardUser()->getId() && !$this->getUser()->hasCredential('editusercontent'))
        {
          die(); // This person/request should not be here
        }        
        $this->setNewThumb($thisFile);  
      }
      catch (Exception $e)
      {
        $this->getRequest()->setError("newimage", "Upload failed ".$e->getMessage());
        return $this->handleErrorUpdateInline();
      }
      
      if ($thisFile->hasArtwork())
      {
        $parentArtworks = $thisFile->getParentArtworks();
        foreach($parentArtworks as $parentArtwork)
        {
          if ($parentArtwork->getStatus() == 3)
          { 
            sfLoader::loadHelpers(array("Url", "Tag"));
            $selectedFile = $thisFile;
            $translateMe = sfContext::getInstance()->getI18n()->__("The following file's thumbnail was changed");
            $parentArtwork->flagChanged($this->getUser(), "The following file's thumbnail was changed");
            $parentArtwork->flagChanged($this->getUser(), " - ".link_to($selectedFile->getTitle()." (".$selectedFile->getId().")", "@edit_upload?fileId=".$selectedFile->getId()));
            $parentArtwork->save();
          }
        }
      }
        
      $imageResponse = $this->getRequestParameter("imgTag");
      $imageResponse = str_replace("?id", "?id" . rand(0, 100), $imageResponse);
    }
    elseif ($this->getRequestParameter("avatarUserId"))
    {
      $selectedUser = sfGuardUserPeer::retrieveByPK($this->getRequestParameter("avatarUserId"));
      
      if (!$selectedUser || ($selectedUser->getId() != $this->getUser()->getGuardUser()->getId() && !$this->getUser()->hasCredential('editprofile')))
      {
         die(); // This person/request should not be here
      }
      try
      {
        $this->setNewThumb($selectedUser);
      }
      catch (Exception $e)
      {
        $this->getRequest()->setError("newimage", "Upload failed: ".$e->getMessage());
        return $this->handleErrorUpdateInline();
      }
      $imageResponse = "<img src = '".sfConfig::get('app_profile_avatar_url').$selectedUser->getAvatar()."' alt = 'Avatar' />";
    }
    else 
    {
      die(); // Nothing to output   
    }
    // All went well then
    return $this->renderText($imageResponse);   
  }
  
  /**
   * Re-send the partial if there are validation errors
   * Errors can come from the validation yml or from the
   * above method.
   *
   * @return void
   */
  public function handleErrorUpdateInline()
  {
    //Return original image and the error message
    //return $this->renderPartial('inlineUpload'); ZOID: Not available in this version of Symfony!! Update when released
    $response  = $this->getRequestParameter("imgTag")."<br />"; 
    $response .= "<span class = 'form_error'>&darr; ".$this->getRequest()->getError("newimage")." &darr;</span>";
    return $this->renderText($response);
  }

  /**
   * Additional custom validator for inline upload of thumbnails
   * Validation here extends the validation offered by the validate/updateInline.yml file
   * 
   * @return boolean true on validation success
   */
  public function validateUpdateInline()
  {
    // See if we have any extra rules for this type
    $thisFile         = ReaktorFilePeer::retrieveByPK($this->getRequestParameter("fileId")); 
    $allowedMimeArray = sfConfig::get("app_upload_thumb_allowed_mime"); 
    if (is_array($allowedMimeArray) && isset($thisFile) &&isset($allowedMimeArray[$thisFile->getIdentifier()]))
    {
      $myValidator = new sfFileValidator();
      $myValidator->initialize($this->getContext(), array(
      	'mime_types' => $allowedMimeArray[$thisFile->getIdentifier()],
      	'mime_types_error' => 'Only JPEG images are allowed',
      ));
      
      $file_array = $this->getRequest()->getFile("newimage");
      if (!$myValidator->execute($file_array, $error))
      {  
        $this->getRequest()->setError("newimage", $error);
      }
    }
    
    if (!$this->getRequest()->hasErrors())
    {
      return true;
    }
    return false;
  }
  
  /**
   * Delete a file completely, admin only function
   * 
   * @return void the file is deleted
   */
  public function executeDeleteFile()
  {
    // ZOID: Expand to allow users to delete own files? Also change button in template
    $this->forward404Unless($this->getUser()->hasCredential("deletecontent"));
    
    // Get the File details ZOID: Move to pre-execute?
    $fileId = intval($this->getRequestParameter('fileId'));
    try
    {
      $selectedFile = new artworkFile($fileId);
    }
    catch (Exception $e)
    {
      $this->forward404($e);
    }
      
    try
    {
      $fileUser = $selectedFile->getUser();
      $selectedFile->deleteFile();
    }
    catch (Exception $e)
    {
      die($e->getMessage());
    }
    //$tmproute = '@user_files?user='.$fileUser;
    //Subreaktor::addSubreaktorToRoute('@user_files?user='.$fileUser);
    $this->redirect(Subreaktor::addSubreaktorToRoute('@user_content?mode=allartwork&user='.$fileUser->getUsername()));
  }

  /**
   * Strips tags from html data
   * 
   * @return string
   */
  public function stripTags($text)
  {
    return strip_tags($text,"<p><h1><h2><h3><h4><h5><h6><em><strong><span><address><ul><ol><li><pre>");
  }
  
  protected function sanitizeFile($file)
  {
    return preg_replace('/[^a-z0-9_\.-]/i', '_', $file);
  }
  
  /**
   * Show the thumbnail cropping page for an uploaded file
   * 
   * @return void
   */
  public function executeThumbnailCrop()
  {
    try 
    {
      $file = new artworkFile($this->getRequestParameter("fileId"));
        
      // Send required values to template
      $this->file = $file;
    }
    catch (exception $e)
    {
      $this->forward404();
    }
    if (!$file->getId() || !$file->hasStaticThumbnail())
    {
      $this->forward404();
    }
  }

  /**
   * Show the thumbnail cropping page for an uploaded file
   * 
   * @return void
   */
  public function executeCrop()
  {
    try 
    {
      $file = new artworkFile($this->getRequestParameter("file"));
      $this->file = $file;
    }
    catch (exception $e)
    {
      $this->forward404();
    }
    if (!$file->getId() || !$file->hasStaticThumbnail())
    {
      $this->forward404();
    }

    $sourceFile = $file->getFullFilePath('normal');
    
    $x1 = $this->getRequestParameter('x1');
    $x2 = $this->getRequestParameter('x2');
    $y1 = $this->getRequestParameter('y1');
    $y2 = $this->getRequestParameter('y2');
    
    $cropWidth = $this->getRequestParameter('width');
    $cropHeight = $this->getRequestParameter('height');

    $cropX = $x1;
    $cropY = $y1;
    $destinationFile = $file->getFullFilePath('thumb');
    
    $output = array();
    sfLoader::loadHelpers(array('content', 'Partial', 'Url'));
    
    $convertString = "convert $sourceFile -crop " . $cropWidth . "x" . $cropHeight . "+" . $cropX . "+" . $cropY . " +repage $destinationFile 2>&1";
    //echo $convertString;
    exec($convertString, $output);

    $sourceFile = $destinationFile;
    
    $resizeString = "convert $sourceFile -resize 240x160! $destinationFile 2>&1";
    exec($resizeString, $output);
    
    $destinationFile = $file->getFullFilePath('mini');
    
    $cropWidth -= 50;
    
    $convertString = "convert $sourceFile -resize 78x65! -gravity center +repage $destinationFile 2>&1";
    exec($convertString, $output);
    
    $this->redirect(Subreaktor::addSubreaktorToRoute('@edit_upload?fileId='.$file->getId()));
  }
  
  public function executeResolveUploadFileId()
  {
    $this->forward404Unless($this->getUser()->hasCredential('staff'));
    $attachment = ArticleAttachmentPeer::retrieveById($this->getRequestParameter("id"));
    $this->forward404Unless($attachment);
    $file = $attachment->getArticleFile();
    $this->forward404Unless($file);

    list($width, $height,) = getimagesize($file->getFullPath());
    $retval = array(
      "absolutePath" => $file->getDirectLink(),
      "width"        => $width,
      "height"       => $height,
    );

    $output = json_encode($retval);
    $this->getResponse()->setHttpHeader("X-JSON", '('.$output.')');
    return sfView::HEADER_ONLY;
  }
}

