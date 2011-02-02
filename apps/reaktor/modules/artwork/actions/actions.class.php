<?php

/**
 * Actions class for artwork view
 *  
 * PHP version 5
 * 
 * @author    Daniel Andre Eikeland <dae@linpro.no>
 * @author    Russ Flynn <russ@linpro.no>
 * @copyright 2008 Linpro AS
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 */
 
/**
 * artwork actions.
 *
 * @package    Reaktor
 * @subpackage Artwork
 * @author     Daniel Andre Eikeland <dae@linpro.no>
 * @author     Russ Flynn <russ@linpro.no>
 * @author     June Henriksen <juneih@linpro.no>
 * @copyright  2008 Linpro AS
 * @license    http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 */
class artworkActions extends sfActions
{
  /**
   * Forward to list artwork
   *
   * @return void
   */
  public function executeIndex()
  {
    $this->forward('artwork', 'list');
  }

  public function executeShowXML()
  {
  	$this->setFlash('format', 'xspf');
  	$this->forward('artwork', 'show');
  }
  
  public function executeShowMetadata()
  {
    if ($this->getUser()->hasCredential('viewmetadata'))
    {
  	  $this->setFlash('template', 'metadata');
    }
    $this->forward('artwork', 'show');
  }
  
  public function executeRemoveMetadata()
  {
  	$c = new Criteria();
  	$c->add(FileMetadataPeer::ID, $this->getRequestParameter('id'));
  	$res = FileMetadataPeer::doDelete($c);
  	return $this->renderText('');
  }
  
  /**
   * Show a specific work of art
   *
   * @return void
   */
  public function executeShow()
  {
    $this->logMessage("Starting the executeShow action");
    $this->editmode = $this->getFlash('editmode');
    $this->forward404Unless($this->getRequestParameter('id'));

    // Create a new genericArtwork object based on the id parameter
    
    try
    {
      $this->artwork = new genericArtwork($this->getRequestParameter('id'));
    }
    catch (Exception $e)
    {
      // Throw a 404 error if the artwork doesn't exist
      $this->forward404();
    }
    
    $this->logMessage("After getting artwork with ID: ".$this->getRequestParameter('id'));
    
    if (Subreaktor::getProvidedLokalreaktor() instanceof Subreaktor)
    {
    	if (!(in_array(Subreaktor::getProvidedLokalReference(), $this->artwork->getSubreaktors(true))))
    	{
    		$this->logMessage("The artwork was not in the specified lokalreaktor");
    		if (!(in_array($this->artwork->getUser()->getResidenceId(), Subreaktor::getProvidedLokalreaktor()->getResidences())))
    		{
    			$this->forward404();
    		}
    		else
    		{
    			$this->logMessage("But the user who published it lives in the area defined by the lokalreaktor");
    		}
    	}
    }
    if (Subreaktor::getProvidedSubreaktor() instanceof Subreaktor)
    {
      $this->logMessage("The artwork was not in the specified subreaktor");
    	$this->forward404Unless(in_array(Subreaktor::getProvidedSubreaktorReference(), $this->artwork->getSubreaktors(true)));
    }
    
    // Throw a 404 error if the artwork can't be viewed by the user
    $this->forward404Unless($this->artwork->isViewable());
    $this->usercanedit = ($this->getUser()->isAuthenticated() && ($this->getUser()->getGuardUser()->getId() == $this->artwork->getUserId() || $this->getUser()->hasCredential('editusercontent'))) ? true : false;
    
    /*
    // Throw a 404 error if the title isn't correct and the user is not the author, or if the title is not set in the url
    if (($this->artwork->getTitle() != urlencode($this->getRequestParameter('title')) && $this->usercanedit == false  && $this->getFlash('format') != 'xspf') || ( $this->getFlash('format') != 'xspf' && $this->getRequestParameter('title') == ''))
    {
      print $this->getFlash('format');
    	$this->forward404();
    }*/
     
    if ($this->getRequest()->isXmlHttpRequest())
    {
    	$this->stripmode = true;
    }
    else
    {
    	$this->stripmode = false;
    }
    // Get the artworkfiles and check if there is more than one file
    $awfiles = $this->artwork->getFiles();
    if (count($awfiles) > 1 && $this->getRequestParameter('file') != '')
    {
      // If we have specified a file id and there are more than one file in the artwork
      try
      {
        $this->thefile = $this->artwork->getFile($this->getRequestParameter('file'));
      }
      catch (Exception $e)
      {
        // Throw a 404 error if the specified file isn't found
        $this->forward404();
      }
    }
    else
    {
      // If there is only one file in the artwork, or no file id is specified, use the first file
      $this->thefile = array_shift($awfiles);
    }

    if ($this->getFlash('format') == 'xspf')
    {
      sfLoader::loadHelpers(array('Partial'));
      $this->getResponse()->setHttpHeader('Content-Type', 'text/xml');
    	$this->setLayout(false);
      $this->setFlash('format', '', false);
    	$this->setTemplate('xspfOutput');
    }
    elseif ($this->getFlash('template') == 'metadata')
    {
      $this->setFlash('template', '', false);
      $this->setTemplate('metadata');
    }
    
    //Get artwork's matching articles
    $articles = $this->artwork->getHelpArticles();
    $this->articles = array();
    if($articles) 
    { 
      $this->articles = $articles;
    }
  }

  /**
   * User unlinking/removing a file from artwork
   *
   * @return void
   */
  public function executeUnlink()
  {
    try
    {  
      $thisFile     = new artworkFile($this->getRequestParameter("fileId"));
      $thisArtworks = $thisFile->getParentArtworks();
      $thisArtwork  = $thisArtworks[$this->getRequestParameter("artworkId")];
    }
    catch (Exception $e)
    {
      $this->forward404();
    }
    
    $this->forward404Unless($this->getUser()->isAuthenticated() && ($this->getUser()->getGuardUser()->getId() == $thisArtwork->getUserId() || $this->getUser()->hasCredential('editusercontent')));
    switch($this->getRequestParameter("mode"))
    {
      case "remove":
        $thisArtwork->removeFile($thisFile);
        $this->redirect(Subreaktor::addSubreaktorToRoute("@show_artwork?id=".$thisArtwork->getId()."&title=".$thisArtwork->getTitle()));
        break;
      case "create":
        $thisArtwork->removeFile($thisFile->getId());
        $newArtwork = new genericArtwork();
        $newArtwork->setCreatedAt(time());
        $newArtwork->setSubmittedAt(time());
        $newArtwork->setTitle($thisFile->getTitle());
        $newArtwork->setUserId($thisFile->getUserId());
        $newArtwork->setArtworkType($thisFile->getIdentifier());
        $newArtwork->save();
        $newArtwork->changeStatus($this->getUser()->getGuardUser()->getId(), 2); // Ready for approval
        $newArtwork->addFile($thisFile);
        $thisFile->setModifiedAt();
        $thisFile->save();
        $this->redirect(Subreaktor::addSubreaktorToRoute("@show_artwork?id=".$newArtwork->getId()."&title=".$newArtwork->getTitle()));
        break;  
      case "link":
        $thisArtwork->removeFile($thisFile->getId());
        $this->redirect("@edit_upload?fileId=".$thisFile->getId()."&link=0");
        break;
      default:
        $this->forward404();
        break;
    }
  }
  
  /**
   * Report file
   *
   * @return void
   */
  public function executeReportfile()
  {

    if (!$this->getRequest()->isXmlHttpRequest())
    {
      //The user should not be here
      die();
    }
    try
    {
      $username      = $this->getUser()->getGuardUser()->getUsername();
      $userid        = $this->getUser()->getGuardUser()->getId();
      $cookiename    = md5($username.$this->getRequestParameter('file'));
      $this->artwork = new genericArtwork($this->getRequestParameter('id'));
      $this->artwork->getFile($this->getRequestParameter('file'))->reportAsUnsuitable($userid);
 
      $this->getResponse()->setCookie('reported_'.$cookiename, 1, time()+60*60*24*10);
    }
    catch (Exception $e)
    {
      $this->forward404();
    }
    $this->forward404Unless($this->artwork->isViewable($this->getUser()));
    $output = sfContext::getInstance()->getI18n()->__("You have reported this file, it will be reviewed by a staff member shortly");
    
    return $this->renderText($output);    
  }
  
  /**
   * Flag file as ok by resetting reported flag
   *
   * @return true
   */
  public function executeOkFile()
  {
    if (!$this->getRequest()->isXmlHttpRequest())
    {
      //The user should not be here
      die();
    }
    $this->forward404Unless($this->getUser()->hasCredential('editusercontent'));
    $file = new artworkFile($this->getRequestParameter('id'));
    $file->reportAsSuitable($this->getUser()->getGuardUser()->getId());
    
    return $this->renderText('File marked OK');    
  }
  
  /**
   * Flag file as ok by resetting reported flag
   *
   * @return true
   */
  public function executeSuitableFile()
  {
    if (!$this->getRequest()->isXmlHttpRequest())
    {
      //The user should not be here
      die();
    }
    $this->forward404Unless($this->getUser()->hasCredential('editusercontent'));
    $file = new artworkFile($this->getRequestParameter('id'));
    $file->reportAsSuitable($this->getUser()->getGuardUser()->getId());
    
    return $this->renderText('File marked suitable');    
  }

  /**
   * Write a message to user explaining why the file has been removed.
   *
   * @return void
   */
  public function executeRemoveFileMessage()
  { 
    $this->forward404Unless($this->getUser()->hasCredential('editusercontent'));
    $this->artwork_file   = new artworkFile($this->getRequestParameter('id'));
    $this->rejectiontypes = RejectionTypePeer::doSelect(new Criteria());       
  }
  
  /**
   * Display rejection form again with error messages
   *
   * @return void
   */
  public function handleErrorRemoveFile()
  {
    $this->forward('artwork', 'removeFileMessage');    
  }
  
  /**
   * Remove the file from the artwork, send message to user about it, and log
   * it in history.
   *
   * @return void
   */
  public function executeRemoveFile()
  {
    $fileId    = $this->getRequestParameter('id');
    $this->forward404Unless($this->getUser()->hasCredential('editusercontent') && $fileId);
    $file = new artworkFile($fileId);
    
    //reset flag so it is not shown in reported files list
    $file->setUnsuitable($this->getUser()->getGuardUser()->getId(),  $this->getRequestParameter('rejectionmsg'));
    $file->save();

    //remove from all artworks that this file belongs to
    foreach ($file->getParentArtworks() as $artwork)
    {
      if ($artwork->getFilesCount() == 1)
      {
      	$artwork->changeStatus($this->getUser()->getGuardUser()->getId(), 4, $this->getRequestParameter('rejectionmsg'));
      	
      	$artwork->save();
      }
      else
      {
      	$artwork->removeFile($fileId);
      	$artwork->resetFirstFile();
      }
    }
    
    //send email to user
    $raw_mail = $this->sendEmail('mail', 'sendRejectArtworkOrFile');
    $this->logMessage($raw_mail, 'debug');

    $this->redirect('@listrejectedfiles');       
  }
    
  /**
   * Executes edit action
   * 
   * @return void
   */
  public function executeEdit()
  {  	
    try
    {
      $this->artwork = new genericArtwork($this->getRequestParameter('id'));
      $this->firstfile = $this->artwork->getFirstFile();
    }
    catch (Exception $e)
    {
      // Throw a 404 error if the artwork doesn't exist
      $this->forward404();
    }
    //If artwork has only one file, then tagging should be just on that file object
    // fix for issue #466, tag the artwork instead, and let users specifically
    // add tags to files if the want to
    /*if ($this->artwork->getFilesCount() == 1)
    {
      $this->objectToTag = $this->firstfile;
    }
    else
    {
      $this->objectToTag = $this->artwork;
    }*/
    $this->objectToTag = $this->artwork;

    $this->forward404Unless(!$this->artwork->isRemoved() || $this->getUser()->hasCredential("editusercontent"));
    
    $this->forward404Unless($this->getUser()->isAuthenticated() 
      && ($this->getUser()->getGuardUser()->getId() == $this->artwork->getUserId() 
      || $this->getUser()->hasCredential("editusercontent")));
         
    if ($this->getRequest()->hasErrors())
    {
      return sfView::SUCCESS;
    }

    if (strpos(sfContext::getInstance()->getRequest()->getUri(), 'edit_nodecor'))
    {
      $this->setLayout('no_decor_layout');
    }
    
    if ($this->getRequest()->getMethod() == sfRequest::POST)
    {
      if ($this->getRequestParameter("submit_artwork"))
      {
                
        // Get artwork object
        $artworkId = $this->getRequestParameter("id");
        $artwork   = new genericArtwork($artworkId);
        
        // Set the artwork submitted
        $artwork->setSubmittedAt(time());
        $artwork->changeStatus($this->getUser()->getGuardUser()->getId(), 2);
        
        // Assign this artwork to an editorial team, then
        // trigger notification to the selected team members
        
        $teamMembers = $artwork->resetEditorialTeam()->getMembers();
        
        // 
        // Create and send e-mail
        //
        $this->logMessage('Am I gonna send email????', 'debug');
        if (count($teamMembers))
        {
	        global $mail_data;
	        $mail_data = array('users' => $teamMembers);
	        $raw_email = $this->sendEmail('mail', 'editorialTeamNotification');
	        $this->logMessage($raw_email, 'debug');
        }
        
        $artwork->save();
        
        // Pass the new artwork object back to the template
        $this->artwork = $artwork;
      }
    }
  }

/**
   * Validate edit, the required fields are added by ajax and submitted elsewhere, 
   * so they can't be validated in the normal way - well, maybe but this is easier
   * 
   * @return boolean only if validation success
   */
  public function validateEdit()
  {
    if ($this->getRequest()->getMethod() != sfRequest::POST)
    {
      return true;
    }
    
    $artworkId = $this->getRequestParameter("id");
    $artwork   = new genericArtwork($artworkId);
    
    if ($this->getRequestParameter("submit_artwork"))
    {
      // We need to check subreaktors and categories have been set - tags are optional at this level
      $artworkSubreaktors = $artwork->getSubreaktors(false, array("subreaktor"));
      if (empty($artworkSubreaktors))
      {
        $this->getRequest()->setError("subreaktors", $this->getContext()->getI18n()->__("Please select at least one"));
      }
      
      $artworkCategories = $artwork->getCategories();
      if (!$artworkCategories)
      {
        $this->getRequest()->setError("categories", $this->getContext()->getI18n()->__("Please select at least one"));
      }
      
      $artworkTags = $artwork->getTags(false, true);
      if (!$artworkTags)
      {
        $this->getRequest()->setError("tags", $this->getContext()->getI18n()->__("Please add at least one tag"));
      }
    }

    if ($this->getRequest()->hasErrors())
    {
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
   * Executes update action
   *
   * @return void
   */
  public function executeUpdate()
  {
    $this->forward404Unless($this->getRequest()->isXmlHttpRequest());
    $theartwork = new genericArtwork($this->getRequestParameter('id'));
    $returntext = "";
    
    if ($this->getRequestParameter("getText"))
    {
      switch ($this->getRequestParameter('field'))
      {
        case 'description':
          $returntext = htmlspecialchars_decode($theartwork->getDescription());
          return $this->renderText($returntext);
          break;
        default:
          $this->forward404();
          break;
      }
    }
    if (!$this->getUser()->isAuthenticated())
    {
      return $this->renderText("**Update failed, please refresh the page and try again**");
    }
    
    if ($this->getUser()->getGuardUser()->getId() == $theartwork->getUserId() || $this->getUser()->hasCredential('viewallcontent'))
    {
      switch ($this->getRequestParameter('field'))
      {
        case 'title':
          $checkTitle = new myArtworkTitleValidator($this->getRequestParameter());
          $checkTitle->initialize(sfContext::getInstance());
          $error = "";
          $title = $this->getRequestParameter('value');
          
          $modifiedField = "Title field modified";
          $translateMe   = sfContext::getInstance()->getI18N()->__("Title field modified");
          
          if ($checkTitle->execute($title, $error))
          {
            $theartwork->setTitle(trim($this->getRequestParameter('value')));
            //$returntext = substr(trim($this->getRequestParameter('value')), 0, sfConfig::get("app_artwork_max_title_length"));
            $returntext = sfContext::getInstance()->getI18N()->__("Title updated!");
          }
          else
          {
            $returntext = $this->getContext()->getI18n()->__("FAIL").": **".$error."**";
          }
          break;
        case 'description': 
          $description = trim(strip_tags($this->getRequestParameter('value'),"<p><a><br><h1><h2><h3><h4><h5><h6><table><tr><td><th><b><i><u><strong>"));
          $theartwork->setDescription($description);
          $returntext = sfContext::getInstance()->getI18N()->__("Description updated!");
          
          $modifiedField = "Description field modified";
          $translateMe   = sfContext::getInstance()->getI18N()->__("Description field modified");
          
          break;
        case 'files':
          $theorder = 1;
          foreach ($this->getRequestParameter('artwork_files', array()) as $afile)
          {
            $this->renderText("setting order of ".$afile." to ".$theorder);
            ReaktorArtworkFilePeer::setFileOrderPlacement($theorder, $afile, $theartwork);
            $theorder++;

          }
          $returntext = "File order saved!";
          $modifiedField = "File order changed";
          $translateMe   = sfContext::getInstance()->getI18N()->__("File order changed");
          break;
      }
      try
      {
        $theartwork->flagChanged($this->getUser(), $modifiedField);
        $theartwork->save();
      }
      catch (Exception $e)
      {
        return $this->renderText("*".$returntext."* - Not saved [Error]");
      }
      return $this->renderText($returntext);
    }
    else
    {
      return $this->renderText('Please don\'t mess with the system');
    }
  }
  
  /**
   * List all unapproved artwork in my editorial teams
   *
   * @return void
   */
  public function executeListUnapprovedMyTeams()
  {
    $editorialteams = array();
    foreach ($this->getUser()->getGuardUser()->getEditorialTeams() as $aTeam)
    {
      $editorialteams[] = $aTeam->getId();
    }
    $this->setFlash('editorialteams', $editorialteams, false);
    $this->forward('artwork', 'listUnapproved');
  }
  
  /**
   * List all unapproved artwork in other editorial teams (not mine)
   *
   * @return null
   */
  public function executeListUnapprovedOtherTeams()
  {
    $editorialteams = array();
    foreach ($this->getUser()->getGuardUser()->getEditorialTeams() as $aTeam)
    {
      $editorialteams[$aTeam->getId()] = $aTeam;
    }
    
    $othereditorialteams = array();
    if ($this->getRequestParameter('team'))
    {    
      $othereditorialteams[$this->getRequestParameter('team')] = $this->getRequestParameter('team');
      $this->setFlash('oneteam', $this->getRequestParameter('team'), false);
    }
    else
    {    
	    foreach (sfGuardGroupPeer::getEditorialTeams(false) as $aTeam)
	    {
	      if (!isset($editorialteams[$aTeam->getId()]))
	      {
	        $othereditorialteams[$aTeam->getId()] = $aTeam->getId();
	      }
	    }
    }
    foreach (sfGuardGroupPeer::getEditorialTeams(false) as $aTeam)
    {
      if (!isset($editorialteams[$aTeam->getId()]))
      {
        $othereditorialteamoptionslist[$aTeam->getId()] = $aTeam->getDescription() . ' (' . ReaktorArtworkPeer::getNumberofArtworksByEditorialTeam($aTeam->getId(), 2, true) . ')';
      }
    }
    
    $this->setFlash('othereditorialteams', $othereditorialteams, false);
    $this->setFlash('othereditorialteamoptionslist', $othereditorialteamoptionslist, false);
    $this->forward('artwork', 'listUnapproved');
  }
  
  /**
   * List unapproved artwork
   * 
   * @return null
   */
  public function executeListUnapproved()
  {
    //$this->artworks = ReaktorArtworkPeer::getUnapprovedArtworksByUser($this->getuser());
    if ($this->getFlash('editorialteams'))
    {
      $this->editorialteams = $this->getFlash('editorialteams'); 
    }

    if ($this->getFlash('othereditorialteams') !== null)
    {
    	$this->editorialteams = $this->getFlash('othereditorialteams'); 
      $this->othereditorialteams = $this->getFlash('othereditorialteams');
      $this->othereditorialteamoptionslist = $this->getFlash('othereditorialteamoptionslist');
    }
    
    if ($this->getUser()->hasCredential('approveartwork') && $this->editorialteams)
    {  
    	$this->pager = ReaktorArtworkPeer::getArtworkByStatusAndCredentialsPaginated(
    	               2, $this->getUser()->listCredentials(), null, $this->editorialteams, false, true);
    }
     
    else
    {
      $this->pager = ReaktorArtworkPeer::getArtworkByStatusAndCredentialsPaginated(
                     2, $this->getUser()->listCredentials(), $this->getUser()->getGuardUser()->getId(), null, false, true);
    }
    
    if ($this->getFlash('oneteam') !== null)
    {
    	$this->team = sfGuardGroupPeer::retrieveByPK($this->editorialteams[$this->getFlash('oneteam')]);
    }
    else
    {
    	$this->team = null;
    }
    $this->artworks = array();
    $this->pager->setPage($this->getRequestParameter('page', 1));
    $this->pager->init();
    foreach ($this->pager->getResults() as $artwork)
    {
    	$this->artworks[] = new genericArtwork($artwork->getId());
    }
  }

  /**
   * Show list of artwork files flagged for discussion
   * 
   * @return void
   */
  public function executeListDiscussion()
  {
    $this->forward404Unless($this->getUser()->hasCredential('discussartwork'));
    $this->files    = ReaktorFilePeer::getFilesUnderDiscussion();
    $this->artworks = ReaktorArtworkPeer::getArtworksUnderDiscussion();
  }
  
  /**
   * Reject an artwork
   *
   * @return void
   */
  public function executeRejectArtwork()
  { 
    $this->forward404Unless($this->getUser()->hasCredential('approveartwork'));      
    $id = $this->getRequestParameter('id');
    $this->forward404Unless($id);    

    $this->artwork        = new genericArtwork($id);
    $this->rejectiontypes = RejectionTypePeer::doSelect(new Criteria());       
  }
  
  /**
   * Ajax call to change artwork status
   *
   * @return unknown
   */
  public function executeChangeArtworkStatus()
  {
    $this->forward404Unless($this->getRequest()->isXmlHttpRequest());
    
    $id          = $this->getRequestParameter('id');
    $status      = $this->getRequestParameter('status');    

    $artwork     = new genericArtwork($id);
    $userAllowed = array(ReaktorArtwork::REMOVED, ReaktorArtwork::APPROVED_HIDDEN);
    $quiet       = false;  // Whether to avoid setting the actioned_by flags
    
    // If a user has hidden an artwork then they are allowed to make it "live" again
    if ($artwork->getStatus() == ReaktorArtwork::APPROVED_HIDDEN)
    {
      $userAllowed[] = ReaktorArtwork::APPROVED;
      $quiet = true;
    }
    
    // Users can set their own artwork to removed or deleted, but only admin can do the rest
    $this->forward404Unless($this->getUser()->hasCredential('approveartwork') || 
      ($this->getUser()->getId() == $artwork->getUserId() && in_array($status, $userAllowed)));
    
    $artwork->changeStatus($this->getUser()->getGuardUser()->getId(), $status, null, $quiet);

    if ($this->getRequestParameter("returndetails") && (!$artwork->isRemoved() || $this->getUser()->hasCredential("viewallcontent")))
    {
      sfLoader::loadHelpers("Partial");
      return $this->renderText(get_partial("artwork/userArtworkListElement", array("artwork" => $artwork, "thisUser" => $artwork->getUser())));
    }
    
    else
    {
      return $this->renderText('');
    }
  }
  
  /**
   * Change the discussion status of an artwork or file
   *
   */
  public function executeChangeDiscussionStatus()
  {
    $this->forward404Unless($this->getUser()->hasCredential('approveartwork'));
    $id          = $this->getRequestParameter('id');
    $object      = $this->getRequestParameter('type')=='artwork' ? new genericArtwork($id) : new artworkFile($id);
    
    if ($this->getRequestParameter('status') == 1)
    {
      $object->markUnderDiscussion();
    }
    else
    {
      $object->markNotUnderDiscussion();
    }
    
    if($this->getRequest()->isXmlHttpRequest())
    {
      return $this->renderText('');
    }
    
    $this->redirect('@listdiscussion');
  }
  
  /**
   * Ajax call to accept artwork modifications
   *
   * @return true
   */
  public function executeAcceptArtworkModifications()
  {
    $this->forward404Unless($this->getRequest()->isXmlHttpRequest() && $this->getUser()->hasCredential('approveartwork'));
    
    $id      = $this->getRequestParameter('id');
    $artwork = new genericArtwork($id);
    $artwork->flagCleared();
    $artwork->save();
    
    return $this->renderText(' ');
  }
  
  /**
   * Change the status of an artwork file (Ajax request)
   *
   * @return void
   */
  public function executeChangeFileStatus()
  {
    $this->forward404Unless($this->getRequest()->isXmlHttpRequest() && $this->getUser()->hasCredential('approveartwork'));
    
    try
    {
      $file = new artworkFile($this->getRequestParameter('id'));
    }
    catch (Exception $e)
    {
      throw new exception ('Could not create file object');
    }
    
    /*if ($this->getRequestParameter('discussion'))
    {
      if ($this->getRequestParameter('status') == 1)
      {
        $file->markUnderDiscussion();
      }
      else
      {
        $file->markNotUnderDiscussion();
      }
    }*/
    
    // Left scope for other status changes
    
    return $this->renderText(' ');
  }
  
  /**
   * Display rejection form again with error messages
   *
   * @return void
   */
  public function handleErrorReject()
  {
    $this->forward('artwork', 'rejectArtwork');
  }
  
  /**
   * Reject artwork: send email, and set status
   *
   * @return void
   */
  public function executeReject()
  {
    $raw_mail = $this->sendEmail('mail', 'sendRejectArtworkOrFile');
    $this->logMessage($raw_mail, 'debug');

    $artwork = new genericArtwork($this->getRequestParameter('id'));
    $artwork->changeStatus($this->getUser()->getGuardUser()->getId(), 4, 
                           $this->getRequestParameter('rejectionmsg'));

    $this->redirect('@listrejected');
  }
  
  /**
   * Show list of rejected artworks
   * 
   * @return void
   */
  public function executeListRejected()
  {
    $this->selected_year = ($this->getRequestParameter('year') != '') ? $this->getRequestParameter('year') : date('Y');
    if ($this->getRequestParameter('month') != '')
    {
      $this->selected_month = $this->getRequestParameter('month');
    }
    elseif ($this->getRequestParameter('year') == '')
    {
      $this->selected_month = date('n');
    }
    else
    {
      $this->selected_month = null;
    }
    $this->months = array();
    for ($cc = 1; $cc <= 12; $cc++)
    {
      $count = 0;
      $this->months[] = array('month' => $cc, 'artworkcount' => ReaktorArtworkPeer::countArtworksByDateAndStatus(4, $this->selected_year, $cc));
    }
    $this->artworks = array();
    $this->page = $this->getRequestParameter('page', 1);
    $this->pager = ReaktorArtworkPeer::getArtworksByDateAndStatus(4, $this->selected_year, $this->selected_month);
    $this->pager->setPage($this->page);
    $this->pager->init();
    foreach ($this->pager->getResults() as $reaktor_artwork)
    {
      $this->artworks[] = new genericArtwork($reaktor_artwork, null, null);
    }
    $this->route = '@rejectedartwork_month?year='.$this->selected_year.'&month='.$this->selected_month;
  }
  
  
  /**
   * Ajax function to remove a file from an artwork
   *
   * @return null
   */
  public function executeRemoveFileFromArtwork()
  {
  	try
  	{
  	  $artwork = new genericArtwork($this->getRequestParameter('artwork'));
  	  
  	  $this->forward404Unless($this->getRequest()->isXMLHttpRequest() && $this->getUser()->isAuthenticated()
  	     && $artwork->getFilesCount() > 1
  	     && ($artwork->getUserId() == $this->getUser()->getId() || $this->getUser()->hasCredential("editusercontent")));;
  	  $artwork->removeFile($this->getRequestParameter('file'));
  	}
  	catch (Exception $e)
  	{
  	  $this->forward404();
  	}
  	
  	return $this->renderText("ok");
  }
  
  /**
   * Show list of rejected artworks
   * 
   * @return void
   */
  public function executeListModified()
  {
    $this->forward404Unless($this->getUser()->hasCredential('approveartwork'));
    $this->pager = ReaktorArtworkPeer::getArtworkByStatusAndCredentialsPaginated(3, $this->getUser()->listCredentials(), null, null, true);
    $this->arts  = array(); 
    $this->pager->setPage($this->getRequestParameter('page', 1));
    $this->pager->init();
    
    foreach ($this->pager->getResults() as $artwork)
    {
      $this->arts[] = new genericArtwork($artwork);
    }      
  }

  /**
   * Show list of rejected artworks
   * 
   * @return void
   */
  public function executeListRejectedFiles()
  {
    $this->forward404Unless($this->getUser()->isAuthenticated()&&$this->getUser()->hasCredential('approveartwork'));
    $this->pager = ReaktorFilePeer::getMarkedUnsuitableFilesPaginated();
    
    $this->pager->setPage($this->getRequestParameter('page', 1));
    $this->pager->init();
    $this->files = array();

    foreach ($this->pager->getResults() as $file) //Get artwork file object and rejection message
    {
      $artwork_file = new artworkFile($file);
      $artwork_file->setRejectedMessage(ReaktorArtworkHistoryPeer::getLatestRejectionMessage($artwork_file->getId(), true, true));
      
      $this->files[] = $artwork_file;
    }
  }
  
  /**
   * Update artwork order when dragging and dropping
   * 
   * @return null
   */
  public function executeUpdateArtworkOrder()
  {
    $this->forward404Unless($this->getRequest()->isXmlHttpRequest());
    try
    {
      $artworkList = $this->getRequestParameter('artwork_list');

      foreach ($artworkList as $key => $artworkId)
      {
        $artwork = ReaktorArtworkPeer::retrieveByPK($artworkId);
        $artwork->setArtworkOrder($key);
        $artwork->save();
      }
      return $this->renderText("ok");
      
    } 
    catch (Exception $e)
    {
      return $this->renderText($this->getContext()->getI18N()->__("An error occured, your list was not updated"));
    }
  }
 
  /**
   * Discuss an artwork
   *
   * @return void
   */
  public function executeDiscuss()
  {
    $id = $this->getRequestParameter('id');
    
    $this->forward404Unless($id && $this->getUser()->hasCredential('discussartwork'));
    
    try
    {
      switch ($this->getRequestParameter('type'))
      {
        case "artwork":
          $this->object = new genericArtwork($id);
          $this->type   = "artwork";
          break;
        case "file":
          $this->object = new artworkFile($id);
          $this->type   = "file";
          break;
        default:
          throw new Exception();
          break;
      }
    }
    catch (Exception $e)
    {
      $this->forward404();    
    }
  }

  /**
   * List artwork files with reported flag set
   * 
   * @return void
   */
  public function executeListReportedContent()
  {
    $this->forward404Unless($this->getUser()->hasCredential('approveartwork'));
    $this->pager = ReaktorFilePeer::getReportedFilesPaginated();    
    $this->pager->setPage($this->getRequestParameter('page', 1));
    $this->pager->init();
    $this->reported_files = array();
     
    $artwork_files = $this->pager->getResults();
        
    $this->counter = array();
     
    foreach ($artwork_files as $artwork_file)
    {
      $this->reported_files[] = new artworkFile($artwork_file->getId());
    }
  }
  
  /**
   * update portfolio artwork list
   * 
   * @return void
   */
  public function executeLastArtworksFromUserAction()
  {
    $this->orderBy = $this->getRequestParameter('orderBy');
    $this->userid  = $this->getRequestParameter('userid');
    $this->user    = sfGuardUserPeer::retrieveByPk($this->userid);
  }
  
  /**
   * Relate an artwork to another, so they 
   *
   * @return void
   */
  public function executeRelateArtwork()
  {
    //Security: display if ajax, and the logged in user is admin or owns the artwork
    if (!$this->getRequest()->isXmlHttpRequest())
    {
      //User shouldn't be here
      die();
    } 
    
    $this->forward404Unless($this->getRequestParameter('id') && $this->getRequestParameter('relate_artwork_select'));

    $user     = $this->getUser();   
    $artwork  = new genericArtwork($this->getRequestParameter('id')); 
    $artwork2 = new genericArtwork($this->getRequestParameter('relate_artwork_select')); 
    
    //We need to check and pass on the usercanedit variable 
    $usercanedit = ($user->isAuthenticated() && 
                           ($user->getGuardUser()->getId() == $artwork->getUserId() ||
                            $user->hasCredential('createcompositeartwork') ||
                            $user->hasCredential('editusercontent'))) ? true : false;   
    $this->forward404Unless($usercanedit);

    //check the artworks are owned by the same user, or this is an admin user creating composite relationships
    $this->forward404Unless($artwork->getUserId() == $artwork2->getUserId() || $this->getUser()->hasCredential("createcompositeartwork"));
 
    //Make sure we don't add a relation that already exists
    if (!$artwork->isRelated($artwork2->getId()))
    {
      //Add relation
      RelatedArtworkPeer::addRelatedArtwork($artwork->getId(), $artwork2->getId(), $artwork->getUserId());
    }
    
    sfLoader::loadHelpers(array('Partial'));
        
    return $this->renderText(
      get_component('artwork', 'linkRelated', array(
      'artwork'     => $artwork,
      'usercanedit' => $usercanedit,
      'editmode'    => 1
      )));

  }

  public function executeCrossRelateArtwork()
  {
    $this->forward404Unless($this->getUser()->isAuthenticated());
    $this->forward404Unless($this->getUser()->hasCredential("createcompositeartwork"));
    $this->forward404Unless($this->getRequestParameter('id'));
    $userid = $this->getUser()->getId();
    $artwork = new genericArtwork($this->getRequestParameter('id')); 
    $relatedArtworksClone = $relatedArtworks = $artwork->getRelatedArtworks(0, 0);
    foreach($relatedArtworks as $related)
    {
      foreach($relatedArtworksClone as $current)
      {
        $this->relate($related, $current, $userid);
      }
    }
    return $this->renderText("OK");
  }
  protected function relate($a, $b, $userid)
  {
    if (!$a->isRelated($b->getId()))
    {
      RelatedArtworkPeer::addRelatedArtwork($a->getId(), $b->getId(), $userid);
    }
    if (!$b->isRelated($a->getId()))
    {
      RelatedArtworkPeer::addRelatedArtwork($b->getId(), $a->getId(), $userid);
    }

  }
  
  public function executeRemoveArtworkRelation()
  {
    $this->forward404Unless($this->getUser()->isAuthenticated());
    //Security: display if ajax, and the logged in user is admin or own the mypage
    if (!$this->getRequest()->isXmlHttpRequest())
    {
      //User shouldn't be here
      die();
    }
    
    $user     = $this->getUser();       
    $id1           = $this->getRequestParameter('viewartwork');
    $id2           = $this->getRequestParameter('relatedartwork');

    $this->forward404Unless($id1&&$id2);
        
    $artwork1 = new genericArtwork($id1);
    $artwork2 = new genericArtwork($id2);
    
    //Check if owner of artworks are the same user    
    $this->forward404Unless($artwork1->getUserId()==$artwork2->getUserId());
    
    //Check if user can edit
    $usercanedit = ($user->isAuthenticated() && 
                   ($user->getGuardUser()->getId() == $artwork1->getUserId() || 
                    $user->hasCredential('editusercontent')));   

    $this->forward404Unless($usercanedit);
    
    RelatedArtworkPeer::deleteRelation($id1, $id2);

    sfLoader::loadHelpers(array('Partial'));
        
    return $this->renderText(
      get_component('artwork', 'linkRelated', array(
      'artwork'     => $artwork1,
      'usercanedit' => $usercanedit,
      'editmode'    => 1
      )));
    
  }
 
  /**
   * Validation adding categories and subreaktors to articles.
   * 
   * If trying to remove a subreaktor from an already published article validation must fail. 
   *
   * @return boolean true if validation succeeds, false if not
   */
  public function validateCategoryAction()
  {
    if ($this->getRequestParameter('articleId') && $this->getRequestParameter("subreaktorClick"))
    {
      $article = ArticlePeer::retrieveByPK($this->getRequestParameter('articleId'));
      
      //Article is published and last subreaktor tried to be removed
      if ($article->isPublished() && !$this->getRequestParameter("subreaktorChecked"))
      {        
       return false;
      }             
    }
    return true;
  }
  
  /**
   * Handle error with adding subreaktors to articles 
   * 
   * User tried to remove a subreaktor from an already published article, thus validation failed.
   *
   * @return string Rendered html of component for subreaktor/format and categories selection (with error message set)
   */
  public function handleErrorCategoryAction()
  {
    $article = ArticlePeer::retrieveByPK($this->getRequestParameter('articleId'));
    sfLoader::loadHelpers(array('Partial'));
    
    return $this->renderText(get_component("artwork", "categorySelect", array(
      "article"    => $article, 
      "ajaxCall"   => true, 
      "error_msg"  => 1,
    )));
  }
  
   /**
   * Ajax function for handling category and subreaktor selections
   * 
   * @return Ajax output
   *
   */
  public function executeCategoryAction()
  {
    $this->forward404Unless($this->getUser()->isAuthenticated() && 
                            $this->getRequest()->getMethod() == sfRequest::POST);
                            
    //Subreaktor and categories can be added to artworks or articles                            
    $isArtwork = false;
    $isArticle = false;
    $object    = null;
    
    if ($this->getRequestParameter('artworkId')) //Create object and test for correct credentials
    {
	    $isArtwork = true;
	    $object    = new genericArtwork($this->getRequestParameter("artworkId"));	    
		    
	    $this->forward404Unless($this->getUser()->getGuardUser()->getId() == $object->getUserId() || 
	                            $this->getUser()->hasCredential("editcategories"));
    }
    elseif ($this->getRequestParameter('articleId'))
    {
      $isArticle = true;
    	$object    = ArticlePeer::retrieveByPK($this->getRequestParameter('articleId'));
    }
    
    // Are we working with subreaktors or categories?
    if ($this->getRequestParameter("subreaktorClick")) //Add/remove subreakors
    {
      $subreaktors   = $this->getRequestParameter("subreaktorChecked", array());
      $previousArray = $this->getRequestParameter("current", array());    
      $object->updateSubreaktors($subreaktors, $previousArray);        
      
      if ($isArtwork)
      {
	      // We should now reassign this to a new editorial team based on the click - but only if this artwork 
	      // has not been submitted already
	      if (!$object->isSubmitted())
	      {
	        $object->resetEditorialTeam();
	      }
	      
	      if ($object->getStatus() == 3 && !$this->getUser()->hasCredential("editcategories"))
	      {
	        //This makes sure the extract script will find it for translation	        
	        $translateMe = sfContext::getInstance()->geti18n()->__("Subreaktors modified");
	        $object->flagChanged($this->getUser(), "Subreaktors modified");
	      }
	      $object->save();
      }
      
      sfLoader::loadHelpers(array('Partial'));
      $params = $isArtwork ? array("artwork" => $object, "ajaxCall" => true) : array("article" => $object, "ajaxCall" => true);
      return $this->renderText(get_component("artwork", "categorySelect", $params));
          
    }
    else //Adding/removing categories
    {
      if ($this->getRequestParameter("add"))
      {
        if ($isArtwork)
        {
      	  $object->addCategory($this->getRequestParameter("add"), $this->getUser());
        }
        elseif ($isArticle)
        {
        	$object->addCategory($this->getRequestParameter("add"));
        }
      }
      elseif ($this->getRequestParameter("remove"))
      {
        $object->removeCategory($this->getRequestParameter("remove"));
      }

      if ($isArtwork)
      {
	      if ($object->getStatus() == 3 && !$this->getUser()->hasCredential("editcategories"))
	      {
	        //This makes sure the extract script will find it for translation
	        $translateMe = sfContext::getInstance()->getI18N()->__("Categories changed");
	        $object->flagChanged($this->getUser(), "Categories changed");
	        $object->save();
	      }
	      // We should now reassign this to a new editorial team based on the click, 
	      // since category changes may affect competition assignment. Onyl applies if has not been submitted already
	      if (!$object->isSubmitted())
	      {
	        $object->resetEditorialTeam();
	        $object->save();
	      }      
      }
	    
      sfLoader::loadHelpers(array('Partial'));
	    $params = $isArtwork ? array("artwork" => $object) : array("article" => $object);
	    return $this->renderText(get_component("artwork", "categoryList", $params));
    }
  }  

  public function executeRecommendations()
  {
    $this->forward404Unless($this->getUser()->isAuthenticated()&&$this->getUser()->hasCredential('recommendartwork'));
        
    $this->artwork = new genericArtwork($this->getRequestParameter('id'));    
  }
  
  /**
   * Handle validation errors when adding a recommendations
   *
   * @return void
   */
  public function handleErrorAddRecommendation()
  {
    $params = $this->getContext()->getController()->convertUrlStringToParameters($this->getRequestParameter('sf_comment_referer'));

    foreach ($params[1] as $param => $value)
    {
      $this->getRequest()->setParameter($param, $value);
    }
    $this->getResponse()->setStatusCode(500);

    $this->forward('artwork', 'recommendations');
  }
  
  /**
   * Recommend an artwork in a subreaktor
   *
   * @return void
   */
  public function executeAddRecommendation()
  {
    $this->forward404Unless($this->getUser()->isAuthenticated());
    
    //Security: display if ajax, and the logged in user is admin or owns the artwork
    if (!$this->getRequest()->isXmlHttpRequest())
    {
      //User shouldn't be here
      die();
    } 
    //Get the subreaktor or subreaktor:localreaktor the artwork is to be added
    $subreaktor = $this->getRequestParameter('recommend_in_subreaktor');
    
    //Check credentials
    $this->forward404Unless($this->getUser()->hasCredential('recommendartwork') && $subreaktor);   
     
    //Get artwork to be recommended and check that its approved 
    $artwork  = new genericArtwork($this->getRequestParameter('id'));

    //Should never happen
    $this->forward404Unless($artwork->getStatus(true)==3);
    
    //Subraktors and subreaktor:localreaktor needs to be treated differently
    $subreaktor_array = explode(':', $subreaktor);    
    if(count($subreaktor_array)>1)
    {
      $subreaktor     = $subreaktor_array[0];
      $lokalreaktor   = $subreaktor_array[1];
      $recommended_in = $subreaktor.':'.$lokalreaktor;
      RecommendedArtworkPeer::addRecommendation($this->getUser()->getGuardUser()->getId(), $artwork->getId(), $subreaktor, $lokalreaktor);
    }
    else
    {
      RecommendedArtworkPeer::addRecommendation($this->getUser()->getGuardUser()->getId(), $artwork->getId(), $subreaktor);
      $recommended_in = $subreaktor;
    }
    
    sfLoader::loadHelpers(array('Partial'));

    // Not nice solution but no other choice - Ticket 23736
    apc_clear_cache('user');
    
    //Render component and return it
    return $this->renderText( get_component('artwork', 'recommendArtwork', array(
      'artwork'     => $artwork,
      )));
  }
  
  function executeUpdateEditorialTeam()
  {
    $this->forward404Unless($this->getUser()->isAuthenticated());
    
    //Security: display if ajax, and the logged in user is admin or owns the artwork
    if (!$this->getRequest()->isXmlHttpRequest())
    {
      //User shouldn't be here
      die();
    } 
  	
    $artwork  = new genericArtwork($this->getRequestParameter('id'));
    $this->forward404Unless($artwork);
    
    $neweditorialteam = $this->getRequestParameter('new_editorialteam');
    
    $artwork->setEditorialTeam($neweditorialteam);
    $artwork->save();
    
    sfLoader::loadHelpers(array('Partial'));
    
    //Render component and return it
    return $this->renderText( get_component('artwork', 'editorialTeamArtwork', array(
      'artwork'     => $artwork,
      )));
  }

  /**
   * Trigger a transcode process
   * 
   * @return null
   */
  function executeReTranscode()
  {
    $this->forward404Unless($this->getUser()->hasCredential('reruntranscoding'));
    $this->id = $this->getRequestParameter('id');
    $file            = ReaktorFilePeer::retrieveByPK($this->id, null, true);

    if (file_exists($file->getFullFilePath("original")))
    {
      $transcoder      = new transcoder();
      $transcodingInfo = $transcoder->transcode($file->getFullFilePath("original"), $file->getRealPath());
      return $this->renderText(sfContext::getInstance()->getI18n()->__("Transcoding has started"));
    }
    else
    {
      return $this->renderText(sfContext::getInstance()->getI18n()->__("Original file not found - transcoding could not start")); 
    }
  }
  
  /**
   * Show the transcoder log for a specified file
   *
   * @return null Render the template
   */
  function executeTranscoderLog()
  {
    $this->forward404Unless($this->getUser()->hasCredential('reruntranscoding'));
    $this->file = ReaktorFilePeer::retrieveByPK($this->getRequestParameter('id'), null, true);
    $path = $this->file->getFullFilePath().".log";
    if (file_exists($path))
    {
      $this->data = file_get_contents($path);
    }
    else
    {
      $this->data = false;
    }
  }

  public function executeListArtworksPopup()
  {
    $this->forward404Unless($this->getUser()->hasCredential('staff'));
    $article = ArticlePeer::retrieveByPK($this->getRequestParameter('article_id'));
    $this->forward404Unless($article);

    $artworks = $this->processFilter("filter");
    if (!$artworks)
    {
      $artworks = ReaktorArtworkPeer::mostPopularArtworks();
    }
    $this->artworks = $artworks;
    $this->article  = $article;
    if ($this->getRequest()->isXmlHttpRequest())
    {
      sfLoader::loadHelpers(array('Partial'));
      return $this->renderText(get_partial("artwork/listArtworksPopupChoices", array("artworks" => $artworks, "article" => $article)));
    }
  }

  protected function processFilter($varname,$approved_only = true)
  {
    $artworks = array();
    if ($tag = $this->getRequestParameter($varname))
    {
      if ($approved_only)
      {
          $matching = TagPeer::getObjectsTaggedWith(array($tag), array("approved" => 1, "parent_approved" => 1), true);
      }
      else 
      {
          $matching = TagPeer::getObjectsTaggedWith(array($tag), array(), true);
      }
      foreach ($matching as $match)
      {
        if (!($match instanceof genericArtwork)) 
        {
          foreach ($match->getParentArtworks() as $artwork)
          {
            $artworks[] = $artwork;
          }
        }
        else
        {
          $artworks[] = $match;
        }
      }
    }
    return $artworks;
  }

  public function executeRelatedFilter()
  {
    if ($this->getRequest()->isXmlHttpRequest())
    {
      $current_artwork = new genericArtwork($this->getRequestParameter("id"));
      $artworks = $this->processFilter("filter",false);

      sfLoader::loadHelpers(array('Partial'));
      if ($artworks) {
        $allArtworks = $artworks;
        if ($this->getUser()->hasCredential("createcompositeartwork"))
        {
        	foreach($allArtworks as $key => $thisArtwork)
          {
            // Don't show already related artworks
            if ($current_artwork->isRelated($thisArtwork->getId()))
            {
              unset($artworks[$key]);
            }
          }
        }
        // If he asn't karma for composite artworks, only show his own
        else
        {
        	foreach($allArtworks as $key => $thisArtwork)
          {
            if (!($thisArtwork->getUserId() == $this->getUser()->getId()))
            {
              unset($artworks[$key]);
            }
            elseif ($current_artwork->isRelated($thisArtwork->getId()))
            {
              unset($artworks[$key]);
            }
          }
        }
        if ($this->getRequestParameter('autocompleter')=='false')
        {
          if ($artworks)
          {
            return $this->renderText(get_partial("artwork/linkRelatedChoices", array("artworks" => $artworks, "thisArtwork" => $current_artwork)));
          } else
          {
          	return $this->renderText("<ul><li>"  . sfContext::getInstance()->geti18n()->__("Can't find any unrelated artworks tagged with %tagname%", array("%tagname%" => $this->getRequestParameter("filter"))) . "</li></ul>" );
          }
        }
      }
      $hasNoTags = true;
      if ($this->getRequestParameter('autocompleter')=='true')
      {

      	$output = "<ul>";
        foreach(TagPeer::getTagsStartingWithString($this->getRequestParameter("filter"),0,$this->getUser()) as $tag)
        {
          $output .= "<li>".$tag->getName()."</li>";
          $hasNoTags = false;
        }
        $output .= "</ul>";
      } else
      {
        return $this->renderText("<ul><li>"  . sfContext::getInstance()->geti18n()->__("Can't find any unrelated artworks tagged with %tagname%", array("%tagname%" => $this->getRequestParameter("filter"))) . "</li></ul>" );
      }
    
      return $this->renderText($output);
    }
    $this->forward404();
  }

  public function executeResolveArtworkId()
  {
    $this->forward404Unless($this->getUser()->hasCredential('staff'));
    $artwork = ReaktorArtworkPeer::retrieveByPK($this->getRequestParameter("id"));

    sfLoader::loadHelpers(array('content')); 
    $retval = showMiniThumb(new genericArtwork($artwork), true);
    $output = json_encode(array($retval));

    //return $this->renderText($retval);
    $this->getResponse()->setHttpHeader("X-JSON", '('.$output.')');

    return sfView::HEADER_ONLY;
  }
  
  /**
   * Ajax action for refreshing the file list on an artwork edit page, once something has changed elsewhere
   * (such as tags)
   *
   * @return null
   */
  public function executeUpdateFileList()
  {
    $this->forward404Unless($this->getRequest()->isXmlHttpRequest() && $this->getUser()->isAuthenticated());
    
    try
    {
      $artwork = new genericArtwork($this->getRequestParameter("artworkId", 0));
    }
    catch (Exception $e)
    {
      $this->forward404();
    }
    
    $this->forward404Unless($this->getUser()->getId() == $artwork->getUserId() || $this->getUser()->hasCredential("viewallcontent"));
    $completeFuncs = "updateArtworkTagList(0, ".$artwork->getId().");";
    
    sfLoader::loadHelpers("Partial");
    return $this->renderText(get_partial("artwork/draganddroplist", array("artwork" => $artwork, "options" => array("completeFuncs" => $completeFuncs, "artworkList" => $artwork->getId()))));
  }
  
  /**
   * Ajax action for refreshing the tag list on an artwork edit page, once something has changed elsewhere
   * (such as tags on the file list) This only applies if the artwork has one file, in which case the artwork tag list
   * is the same as the list next to the file
   *
   * @return null
   */
  public function executeUpdateArtworkTagList()
  {
    $this->forward404Unless($this->getRequest()->isXmlHttpRequest() && $this->getUser()->isAuthenticated());
    
    try
    {
      $artwork = new genericArtwork($this->getRequestParameter("artworkId"));
      
      if ($this->getRequestParameter("fileId"))
      {
        $file = new artworkFile($this->getRequestParameter("fileId", 0));
      }
      else
      {
        $file = $artwork->getFirstFile();
      }
    }
    catch (Exception $e)
    {
      $this->forward404();
    }
    
    $this->forward404Unless($this->getUser()->getId() == $file->getUserId() || $this->getUser()->hasCredential("viewallcontent"));
    $completeFuncs = "updateFileList(".$artwork->getId().");";
    
    sfLoader::loadHelpers("Partial");
    return $this->renderText(get_component("tags", "tagEditList", array("taggableObject" => $artwork, "options" => array("completeFuncs" => $completeFuncs, "artworkList" => $this->getRequestParameter("artworkId")))));
  }
}

