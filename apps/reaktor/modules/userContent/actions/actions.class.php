<?php
/**
 * User content management, allows users to see and manage everything they have on the site, including files and artworks
 * and all the statuses involved. (Awaiting approval etc) 
 *
 * PHP Version 5
 *
 * @author    Russ Flynn <russ@linpro.no>
 * @copyright 2008 Linpro AS
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 *
 */

/**
 * User content management, allows users to see and manage everything they have on the site, including files and artworks
 * and all the statuses involved. (Awaiting approval etc) 
 *
 * PHP Version 5
 *
 * @author    Russ Flynn <russ@linpro.no>
 * @copyright 2008 Linpro AS
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 *
 */
class userContentActions extends sfActions
{
  /**
   * The user object that we are managing files for
   *
   * @var sfGuardUser
   */
   private static $thisUser;
  
   /**
    * The artwork object we are linking to if provided
    *
    * @var genericArtwork
    */
   private static $linkArtwork;

   /**
    * The file object we are working on if provided
    *
    * @var artworkFile
    */
   private static $file;
   
  /**
   * Common functions to execute before all on this page
   * There is a user and an admin action for all the tasks when it comes to managing content, so this function 
   * ensures that we are always covered.
   * 
   * @return null
   */
  public function preExecute()
  {
    // Are we managing our own content or somebody elses?
    if ($this->getRequestParameter("user"))
    {
      $thisUser = sfGuardUserPeer::getByUsername($this->getRequestParameter("user"));
      $this->forward404Unless($thisUser && ($this->getUser()->hasCredential("editusercontent") || $thisUser->getId() == $this->getUser()->getId()));
      $this->route = "@user_content";
    }
    else
    {
      $thisUser = $this->getUser()->getGuardUser();
      $this->route = "@my_content";
    }
    
    if ($this->getRequestParameter("fileId"))
    {
      try
      {
        $this->file = new artworkFile($this->getRequestParameter("fileId"));  
      }
      catch (exception $e)
      {
        throw new exception ($e);
      }
    }
    
    if ($this->getRequestParameter("artworkId"))
    {
      $reaktorArtwork = ReaktorArtworkPeer::retrieveByPK($this->getRequestParameter("artworkId"));
      if ($reaktorArtwork && ($reaktorArtwork->getUserId() == $this->getUser()->getId() || $this->getUser()->hasCredential("editusercontent")))
      {
        $this->linkArtwork = new genericArtwork($reaktorArtwork);
      }
      else
      {
        $this->forward404();
      }
    }
    elseif ($this->getRequestParameter("link") && $this->getRequestParameter("fileId") && $this->getUser()->hasCredential("createcompositeartwork"))
    // Creating a new one (composite)- admin only
    {
      $this->linkArtwork = new genericArtwork();
      $this->linkArtwork->setCreatedAt(time());
      $this->linkArtwork->setArtworkType($this->file->getIdentifier());
      $this->linkArtwork->setUser($this->getUser()->getGuardUser());
      $this->linkArtwork->setMultiUser();
      $this->linkArtwork->save();
      $this->linkArtwork->setTitle(sfContext::getInstance()->getI18n()->__("New composite artwork %artwork_id%", array("%artwork_id%" => $this->linkArtwork->getId())));
      $this->linkArtwork->save();     
    }
    
    $includeHidden = false;
    if ($this->getUser()->hasCredential("viewallcontent"))
    {
      $includeHidden = true;
    }
    
    // Pass the required template variables that are common to all actions
    $this->thisUser      = $thisUser;
    $this->uploadedCount = ReaktorFilePeer::countFilesByUser($this->thisUser, null, false, $includeHidden);
   
  }
  
  /**
   * Executes overview (manage) page template with counts and links, or loads the correct tamplates based on the mode
   * 
   * @return null
   */
  public function executeManage()
  {
    $this->mode = $this->getRequestParameter('mode');
    switch ($this->getRequestParameter("mode"))
    {
      case "allartwork":
        $this->titleFilter = "";
        return $this->artworkList();
      break;
      case "allfiles":
        $this->titleFilter = "";
        return $this->fileList();
      break;
      case "orphanedfiles":
        $this->titleFilter = sfContext::getInstance()->getI18N()->__("unused");
        return $this->fileList(true);
      break;
      case "unsuitablefiles":
        $this->titleFilter = sfContext::getInstance()->getI18N()->__("unsuitable");
        return $this->fileList(null, true);
      break;      
      case "draftartwork":
        $this->titleFilter = sfContext::getInstance()->getI18N()->__("draft");
        return $this->artworkList(ReaktorArtwork::DRAFT);
      break;
      case "submittedartwork":
        $this->titleFilter = sfContext::getInstance()->getI18N()->__("awaiting approval");
        return $this->artworkList(ReaktorArtwork::SUBMITTED);
      break;
      case "allrejected":
        $this->titleFilter = sfContext::getInstance()->getI18N()->__("rejected");
        return $this->artworkList(ReaktorArtwork::REJECTED);
      break;
      case "allremoved":
        $this->titleFilter = sfContext::getInstance()->getI18N()->__("removed");
        return $this->artworkList(array(ReaktorArtwork::REMOVED));
      break;
      case "allapproved":
        $this->titleFilter = sfContext::getInstance()->getI18N()->__("approved");
        return $this->artworkList(array(ReaktorArtwork::APPROVED, ReaktorArtwork::APPROVED_HIDDEN));
      break;
      case "link":
        $this->titleFilter = '"'.$this->linkArtwork->getTitle().'"';
        $this->makeCollection();
        break;
      default:
        $c = null;
        if (!$this->getUser()->hasCredential("viewallcontent"))
        {
          $c = new Criteria();
          $c->add(ReaktorArtworkPeer::STATUS, ReaktorArtwork::REMOVED, Criteria::NOT_EQUAL);
        }
        $artworkCountArray = ReaktorArtworkPeer::countUserArtworks($this->thisUser, null, null, true, $c);
        $this->allArtworkCount        = 0;
        $this->draftArtworkCount      = isset($artworkCountArray[1]) ? array_sum($artworkCountArray[1]) : false;
        $this->rejectedArtworkCount   = isset($artworkCountArray[4]) ? array_sum($artworkCountArray[4]) : false;
        $this->submittedArtworkCount  = isset($artworkCountArray[2]) ? array_sum($artworkCountArray[2]) : false;
        
        $this->approvedCount          = isset($artworkCountArray[3]) ? array_sum($artworkCountArray[3]) : false;
        $this->approvedHiddenCount    = isset($artworkCountArray[6]) ? array_sum($artworkCountArray[6]) : false;
        
        $this->approvedArtworkCount = $this->approvedCount + $this->approvedHiddenCount;
        
        $this->orphanedCount          = ReaktorFilePeer::countFilesByUser($this->thisUser, null, true);
        
        foreach($artworkCountArray as $item)
        {
          $this->allArtworkCount += array_sum($item);
        }
      break;
    }
  }
  
  /**
   * Execute the list of all the users artwork, or artwork with a certain status
   *
   * @param integer $status if set, will return only artworks that match the status id supplied
   * 
   * @return null
   */
  private function artworkList($status = null)
  {
    // Get all the artworks for this user, passing status to filter on if need be
    // If not admin, do not show artworks the user has removed
    if ($this->getUser()->hasCredential("viewallcontent"))
    {
      $statusExclude = array();
    }
    else
    {
      $statusExclude = array(ReaktorArtwork::REMOVED);
    }
    $c = null;
    
    // If we are filtering on year, we'll pass some extra criteria to the query
    if ($this->getRequestParameter("year"))
    {
      $c = new Criteria();
      $critA = $c->getNewCriterion(ReaktorArtworkPeer::ACTIONED_AT, $this->getRequestParameter("year")."-01-01 00:00:00", Criteria::GREATER_EQUAL);
      $critB = $c->getNewCriterion(ReaktorArtworkPeer::ACTIONED_AT, $this->getRequestParameter("year")."-12-31 23:59:59", Criteria::LESS_EQUAL);
      $critA->addAnd($critB);
      $c->add($critA);
    }
    
    $this->artworks = ReaktorArtworkPeer::getArtworksByUser($this->thisUser, 0, false, array(), $status, $statusExclude, $c);

    // Set whether to allow ordering in the template (only applicable if we are not filtering)
    if (1)  // Set to always on but will leave this here in case this flag is useful in future
    {
      $this->allowOrdering = true;
    }
    else
    {
      $this->allowOrdering = false;
    }
    
    $this->setTemplate("artworkList");
  }
  
  /**
   * Execute the list of all the users files, or files with a certain criteria
   *
   * @param boolean $orphaned If set will check to see if the file is orphaned or not - if not set, all files are returned
   * @param boolean $link     If set, will show link options
   * 
   * @return null
   */
  private function fileList($orphaned = null, $unsuitable = null)
  {
    $showHidden = false;
    if ($this->getUser()->hasCredential("viewallcontent"))
    {
      $showHidden = true;
    }
    $this->files = ReaktorFilePeer::getFilesByUser($this->thisUser, null, $orphaned, false, false, array(), $showHidden, $unsuitable);
    $this->setTemplate("fileList");
  }
  
  /**
   * Execute the collection page for making drag and drop galleries
   * 
   * @return null
   */
  private function makeCollection()
  {
    if ($this->getRequestParameter("allusers") && $this->getUser()->hasCredential("createcompositeartwork"))
    {
      $this->eligibleFiles = ReaktorFilePeer::getFilesByType($this->linkArtwork->getEligbleFileTypes(), $this->linkArtwork->getFiles(true), false);
    }
    else
    {
      $this->eligibleFiles = ReaktorFilePeer::getFilesByUser($this->thisUser, $this->linkArtwork->getEligbleFileTypes(), null, null, true, $this->linkArtwork->getFiles(true), false, false);
    }
    $this->setTemplate("collection");
    $this->artworkFiles  = $this->linkArtwork->getFiles();
  }

  /**
   * Ajax function for adding a file to the gallery
   *
   * @return null
   */
  public function executeAdd()
  {
    $this->forward404Unless($this->getRequest()->isXmlHttpRequest() && 
      ($this->getUser()->getId() == $this->thisUser->getId() || $this->getUser()->hasCredential("editusercontent")));
    
    try
    {
      $this->linkArtwork->addFile($this->getRequestParameter("fileId"));
      
      // Set it back to ready for approval
      if (!$this->linkArtwork->isDraft())
      {
        if (!$this->getUser()->hasCredential("editusercontent"))
        {
          $this->linkArtwork->changeStatus($this->getUser(), 2, sfContext::getInstance()->getI18n()->__("New files added to collection"));
        }
      }
      // Or just mark it as changed
      else
      {
        sfLoader::loadHelpers(array("Url", "Tag"));
        $selectedFile = ReaktorFilePeer::retrieveByPK($this->getRequestParameter("fileId"), null, true);
        $translateMe = sfContext::getInstance()->getI18n()->__("The following file was added to the collection");
        $this->linkArtwork->flagChanged($this->getUser(), "The following file was added to the collection");
        $this->linkArtwork->flagChanged($this->getUser(), " - ".link_to($selectedFile->getTitle()." (".$selectedFile->getId().")", "@edit_upload?fileId=".$selectedFile->getId()));
      }
      $this->linkArtwork->save();
    }
    catch (Exception $e)
    {
      throw new exception($e);// Not too fussed if it doesn't work - just means someone is trying to add the same file again
    }
    $this->artworkFiles  = ReaktorArtworkFilePeer::getFilesInArtwork($this->linkArtwork);
 
    sfLoader::loadHelpers("Partial");
    
    if ($this->getRequestParameter("miniResult"))
    {
      $file = new artworkFile($this->getRequestParameter("fileId"));
      return $this->renderText(get_component("userContent", "artworkCompositeSelect", 
                               array("file" => $file, "thisUser" => $this->thisUser)));
    }
    else
    {
      return $this->renderText(get_partial("userContent/simpleFileListForAjax", 
                               array("artworkFiles" => $this->artworkFiles, 
                                     "button" => "remove", 
                                     "linkArtwork" => $this->linkArtwork,  
                                     "thisUser" => $this->thisUser,
                                     "allowOrdering" => true )));
    }
  }
  
  /**
   * Ajax function for removing a file from gallery
   *
   * @return null
   */
  public function executeRemove()
  {
    $this->forward404Unless($this->getRequest()->isXmlHttpRequest() && 
      ($this->getUser()->getId() == $this->thisUser->getId() || $this->getUser()->hasCredential("editusercontent") || $this->getUser()->hasCredential("createcompositeartwork")));
    
    try
    {
      // Shouldn't be here if they don't have more than one file
      if (count(ReaktorArtworkFilePeer::getFilesInArtwork($this->linkArtwork)) > 1)
      {
        $this->linkArtwork->removeFile($this->getRequestParameter("fileId"));
        
        sfLoader::loadHelpers(array("Url", "Tag"));
        $selectedFile = ReaktorFilePeer::retrieveByPK($this->getRequestParameter("fileId"), null, true);
        $translateMe = sfContext::getInstance()->getI18n()->__("The following file was removed from the collection");
        $this->linkArtwork->flagChanged($this->getUser(), "The following file was removed from the collection");
        $this->linkArtwork->flagChanged($this->getUser(), " - ".link_to($selectedFile->getTitle()." (".$selectedFile->getId().")", "@edit_upload?fileId=".$selectedFile->getId()));
      }
    }
    catch (Exception $e)
    {
      // Not too fussed if it doesn't work - just means someone is trying to add the same file again
    }
    $this->linkArtwork->save();
    
    if ($this->getRequestParameter("allusers") && $this->getUser()->hasCredential("createcompositeartwork"))
    {
      $this->eligibleFiles = ReaktorFilePeer::getFilesByType($this->linkArtwork->getArtworkType(), $this->linkArtwork->getFiles(true));
    }
    else
    {
      $this->eligibleFiles = ReaktorFilePeer::getFilesByUser($this->thisUser, $this->linkArtwork->getArtworkType(), null, null, true, $this->linkArtwork->getFiles(true));
    }

    sfLoader::loadHelpers("Partial");
    return $this->renderText(get_partial("userContent/simpleFileListForAjax", 
                             array("artworkFiles" => $this->eligibleFiles, 
                                   "button" => "add", "linkArtwork" => $this->linkArtwork,  
                                   "thisUser" => $this->thisUser )));
  }
  
  /**
   * Ajax responder for getting a list of artworks from a partial
   *
   * @return null
   */
  public function executeGetArtworkList()
  {
    $this->forward404Unless($this->getRequest()->isXmlHttpRequest());
    
    $file = new artworkFile($this->getRequestParameter("fileId"));
    sfLoader::loadHelpers("Partial");
    return $this->renderText(get_partial("userContent/listArtworks", array("file" => $file)));
  }
  
  /**
   * Ajax functionality for hiding a file
   * 
   * @return string "ok" on success
   */
  public function executeHideFile()
  {
    $this->forward404Unless($this->getRequest()->isXmlHttpRequest());
    
    $file = new artworkFile($this->getRequestParameter("fileId"));
    $this->forward404Unless($file->getUserId() == $this->getUser()->getId() || $this->getUser()->hasCredential("editusercontent"));

    $file->setHidden();
    $file->save();
    
    return $this->renderText("ok");
    
  }
  
  /**
   * Ajax call to update the sidebar menu
   *
   * @return null
   */
  public function executeUpdateSidebar()
  {
    sfLoader::loadHelpers("Partial");
    return $this->renderText(get_component('userContent', 'contentManagerSidebarAjaxblock'));
  }
}
