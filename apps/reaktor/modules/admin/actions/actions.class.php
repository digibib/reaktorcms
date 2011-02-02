<?php
/**
 * Admin home page
 *
 * PHP Version 5
 *
 * @author    Russ Flynn <russ@linpro.no>
 * @author    June <juneih@linpro.no>
 * @copyright 2008 Linpro AS
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 *
 */

/**
 * Admin home page
 *
 * PHP Version 5
 *
 * @author    Russ Flynn <russ@linpro.no>
 * @author    June <juneih@linpro.no>
 * @copyright 2008 Linpro AS
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 *
 */
class adminActions extends sfActions
{
  /**
   * Login to PHPMyAdmin with a read only user
   *
   * @return void
   */
  public function executePMA()
  {
    //Check credentials
    $this->forward404Unless($this->getUser()->isAuthenticated()); 
    $this->forward404Unless($this->getUser()->hasCredential('phpmyadmin'));
    
    //Get info on db read-only user 
    $pma_user     =  sfConfig::get("app_admin_pma_readonly_user");
    $pma_password =  sfConfig::get("app_admin_pma_password");

    // Apparently symfony is highly dependent upon cookies so we don't have to 
    // do any sanitychecks here as symfony would have already bailed out
    if (!isset($_COOKIE["pmaCookieVer"])) {
      // phpMyAdmin clears all cookies unless it gets a version cookie
      setcookie("pmaCookieVer", "5", null, "/");
      $this->redirect("@pma");
    }
    
    //Create session info, when logging out these will be deleted
    $_SESSION['PMA_single_signon_user'] = $pma_user;
    $_SESSION['PMA_single_signon_password'] = $pma_password;

    //get reaktor root from config and redirect to phpmyadmin
    $this->redirect('http://'.$this->getRequest()->getHost().'/phpmyadmin/');
  }
  
  public function executeAdminFunctions()
  {
    $messages = array();
    $mode     = $this->getRequestParameter("mode");
    
    if ($mode == "clearhtml" || $mode == "clearall")
    {
      exec(sfConfig::get("sf_root_dir").DIRECTORY_SEPARATOR."symfony clear-cache reaktor template", &$output, &$returnVar);
      if ($returnVar == 0)
      {
        $messages[] = sfContext::getInstance()->getI18n()->__("Html cache cleared successfully");
      }
      else
      {
        $messages[] = sfContext::getInstance()->getI18n()->__("The command to clear the html cache failed!");
      }
    }
    if ($mode == "clearconfig"  || $mode == "clearall")
    {
      exec(sfConfig::get("sf_root_dir").DIRECTORY_SEPARATOR."symfony clear-cache reaktor config", &$output, &$returnVar);
      if ($returnVar == 0)
      {
        $messages[] = sfContext::getInstance()->getI18n()->__("Configuration cache cleared successfully");
      }
      else
      {
        $messages[] = sfContext::getInstance()->getI18n()->__("The command to clear the configuration cache failed!");
      }
    }
    if ($mode == "clearmemory"  || $mode == "clearall")
    {
      sfProcessCache::clear();
      $messages[] = sfContext::getInstance()->getI18n()->__("Memory cache cleared successfully");
    }
    $appYmlCacheFile = sfConfig::get("sf_root_dir").DIRECTORY_SEPARATOR."cache".DIRECTORY_SEPARATOR."reaktor".DIRECTORY_SEPARATOR.
                                           "prod".DIRECTORY_SEPARATOR."config".DIRECTORY_SEPARATOR."config_app.yml.php";
    if (file_exists($appYmlCacheFile))
    {
      $this->configCacheTimestamp = filemtime($appYmlCacheFile);
    }
    else
    {
      // Shouldn't happen, but this will do as a backup
      $this->configCacheTimestamp = time();
    }
    $this->messages = $messages;
  }
  
  /**
   * Executes before the action
   * 
   * @return void
   */
  public function preExecute()
  {   
  }
  
  /**
   * Executes index action
   *
   * @return void
   */
  public function executeIndex()
  {
  	$this->editorialteams = array();
  	foreach ($this->getUser()->getGuardUser()->getEditorialTeams() as $aTeam)
  	{
  		$this->editorialteams[$aTeam->getId()] = $aTeam;
  	}
  	if (sfContext::getInstance()->getUser()->hasCredential('viewothereditorialteams'))
  	{
	  	$this->othereditorialteams = array();
	  	foreach (sfGuardGroupPeer::getActiveEditorialTeams() as $aTeam)
	  	{
	  		if (!isset($this->editorialteams[$aTeam->getId()]))
	  		{
	  			$this->othereditorialteams[$aTeam->getId()] = $aTeam;
	  		}
	  	}
  	}
  	$this->editorialteamartworks = ReaktorArtworkPeer::getNumberofArtworksByEditorialTeam($this->editorialteams, 2, true);
  	$this->modifiedartworks = ReaktorArtworkPeer::getNumberOfArtworkByStatusAndCredentials(3, $this->getUser()->listCredentials(), null, null, true);
  	$this->othereditorialteamartworks = ReaktorArtworkPeer::getNumberofArtworksByEditorialTeam($this->othereditorialteams, 2, true);
  	$this->discussionFiles = ReaktorFilePeer::getNumberofFilesUnderDiscussion();
  	$this->discussionArtworks = ReaktorArtworkPeer::getNumberOfArtworksUnderDiscussion();
  	$this->reportedfiles = ReaktorFilePeer::getNumberofReportedFiles();
  	$this->reportedcomments = sfCommentPeer::getNumberofCommentsByUnsuitableStatus();
  	$this->unapprovedtags = TagPeer::getNumberofTagsByApprovedStatus();
  }
 
  /**
   * Show list of artwork flagged for discussion 
   *
   * @return void
   */
  public function executeListDiscussion()
  { 
    $this->forward('artwork', 'listDiscussion');    	
  }
  
  /**
   * Show list of unapproved artwork 
   *
   * @return void
   */
  public function executeListUnapproved()
  {
    $this->forward('artwork', 'listUnapproved');
  }
  
  /**
   * Show list of rejected artwork
   * 
   * @return void
   */
  public function executeListRejected()
  {
    $this->forward('artwork', 'listRejected');
  }
  
 /**
   * Show list of unsuitable files 
   * 
   * @return void
   */
  public function executeListRejectedFiles()
  {
    $this->forward('artwork', 'listRejectedFiles');
  }
  
  /**
   * Show list of subreaktors
   *
   * @return void 
   */
  public function executeListSubreaktors()
  {
  	$this->forward('subreaktors', 'listSubreaktors');
  }
  
  /**
   * Show list of comments within a time period
   *
   * @return void
   */
  public function executeListComments()
  {    
    $this->forward('sfComment', 'listComments');
  }
  
  /**
   * Show calendar with links to comments
   *
   * @return void
   */
  public function executeCommentsCalendar()
  {    
    $this->forward('sfComment', 'commentsCalendar');
  }
  
  /**
   * Return description of the chosen rejection type, used in ajax call. 
   *
   * @return void
   */
  public function executeRejectionTypeChosen()
  {   
    if (!$this->getRequest()->isXmlHttpRequest())
    {
      //The user should not be here
      die();
    }
    $id             = $this->getRequestParameter('rejectiontype');    
    $rejection_type = $id?RejectionTypePeer::retrieveByPK($id):'';
    $output         = $rejection_type?$rejection_type->getDescription():'';
    return $this->renderText($output);    
    
  }
  
  /**
   * Display list of rejection types
   *
   * @return forward
   */
  public function executeRejectionType()
  {
    return $this->forward('admin', 'rejectionTypeList');
  }

  /**
   * Display list of rejection types
   *
   * @return void
   */
  public function executeRejectionTypeList()
  {
    $this->rejection_types = RejectionTypePeer::doSelect(new Criteria());
  }

  /**
   * Show rejection type and attributes
   *
   * @return void
   */
  public function executeRejectionTypeShow()
  {
    $this->rejection_type = RejectionTypePeer::retrieveByPk($this->getRequestParameter('id'));
    $this->forward404Unless($this->rejection_type);
  }

  /**
   * Show rejection type form
   *  
   * @return void
   */
  public function executeRejectionTypeCreate()
  {
    $this->rejection_type = new RejectionType();

    $this->setTemplate('rejectionTypeEdit');
  }

  /**
   * Show rejection type form
   *
   * @return void
   */
  public function executeRejectionTypeEdit()
  {
    $this->rejection_type = RejectionTypePeer::retrieveByPk($this->getRequestParameter('id'));
    $this->forward404Unless($this->rejection_type);
  }

  /**
   * Save/update rejection type
   *
   * @return redirect 
   */
  public function executeRejectionTypeUpdate()
  {
    if (!$this->getRequestParameter('id'))
    {
      $rejection_type = new RejectionType();
    }
    else
    {
      $rejection_type = RejectionTypePeer::retrieveByPk($this->getRequestParameter('id'));
      $this->forward404Unless($rejection_type);
    }

    $rejection_type->setId($this->getRequestParameter('id'));
    $rejection_type->setName($this->getRequestParameter('name'));
    $rejection_type->setDescription($this->getRequestParameter('description'));

    $rejection_type->save();

    return $this->redirect('@rejectiontypeshow?id='.$rejection_type->getId());
  }
  
  /**
  * Delete entry from rejection type table
  *
  * @return redirect
  */
  public function executeRejectionTypeDelete()
  {       
    $rejection_type = RejectionTypePeer::retrieveByPk($this->getRequestParameter('id'));

    $this->forward404Unless($rejection_type);

    $rejection_type->delete();

    return $this->redirect('@rejectiontypes');
  }

  /**
   * List reported comments
   *
   * @return void
   */
  public function executeListReportedComments()
  {
    $this->forward('sfComment', 'listReportedComments');
  }

  /**
   * List unsuitable comments
   *
   * @return void
   */
  public function executeListUnsuitableComments()
  {
    $this->forward('sfComment', 'listUnsuitableComments');
  }

  /**
   * List artwork where the content has been reported
   *
   * @return void
   */
  public function executeListReportedContent()
  {
    $this->forward('artwork', 'listReportedContent');
  }

  /**
   * List all users who would like to receive promotional e-mails
   *
   * @return void
   */
  public function executeListPromotionalEmailRecipients()
  {
     $this->emails = sfGuardUserPeer::retrieveOptInEmails();    
  }
  
  /**
   * Display list of artwork statuses
   *
   * @return forward
   */
  public function executeArtworkStatus()
  {
    return $this->forward('admin', 'artworkStatusList');
  }

  /**
   * Display list of artwork statuses
   *
   * @return void
   */
  public function executeArtworkStatusList()
  {
    $this->artwork_statuses = ArtworkStatusPeer::doSelect(new Criteria());
  }

  /**
   * Show artwork status form
   *
   * @return void
   */
  public function executeArtworkStatusEdit()
  {
    $this->artwork_status = ArtworkStatusPeer::retrieveByPk($this->getRequestParameter('id'));
    $this->forward404Unless($this->artwork_status);
  }

  /**
   * Save/update artwork status
   *
   * @return redirect 
   */
  public function executeArtworkStatusUpdate()
  {
    $artwork_status = ArtworkStatusPeer::retrieveByPk($this->getRequestParameter('id'));
    $this->forward404Unless($artwork_status);

    $artwork_status->setDescription($this->getRequestParameter('description'));

    $artwork_status->save();

    return $this->redirect('@artworkstatuses');
  }
  
  /**
   * Display list of artwork statuses
   *
   * @return forward
   */
  public function executeHistoryActions()
  {
    return $this->forward('admin', 'historyActionList');
  }

  /**
   * Display list of artwork statuses
   *
   * @return void
   */
  public function executeHistoryActionList()
  {
    $this->history_actions = HistoryActionPeer::doSelect(new Criteria());
  }

  /**
   * Show artwork status form
   *
   * @return void
   */
  public function executeHistoryActionEdit()
  {
    $this->history_action = HistoryActionPeer::retrieveByPk($this->getRequestParameter('id'));
    $this->forward404Unless($this->history_action);
  }

  /**
   * Save/update artwork status
   *
   * @return redirect 
   */
  public function executeHistoryActionUpdate()
  {
    $history_action = HistoryActionPeer::retrieveByPk($this->getRequestParameter('id'));
    $this->forward404Unless($history_action);

    $history_action->setDescription($this->getRequestParameter('description'));

    $history_action->save();

    return $this->redirect('@historyactions');
  }
  
  /**
   * Display list of subreaktors
   *
   * @return forward
   */
  public function executeSubreaktorNames()
  {
    return $this->forward('admin', 'subreaktorNameList');
  }

  /**
   * Display list of subreaktors
   *
   * @return void
   */
  public function executeSubreaktorNameList()
  {
    $this->subreaktor_names = SubreaktorPeer::doSelectWithI18n(new Criteria());
  }

  /**
   * List categories for editing
   *
   * @return void
   */
  public function executeCategoryList()
  {
    $c = new Criteria();
    $c->addAscendingOrderByColumn(CategoryPeer::BASENAME);
    $this->categories = CategoryPeer::doSelectWithI18n($c);
  }
  
  /**
   * Show subreaktor name edit form
   *
   * @return void
   */
  public function executeSubreaktorNameEdit()
  {
    $this->edit_subreaktor = SubreaktorPeer::retrieveByPk($this->getRequestParameter('id'));
    $this->forward404Unless($this->edit_subreaktor);
  }
  
  /**
   * Show the edit category i18n form
   * 
   * @return void render the temlate
   */
  public function executeCategoryEdit()
  {
    // For some reason the correct method for doing this is not working - so the long way round we go
    $c = new Criteria();
    $c->add(CategoryPeer::ID, $this->getRequestParameter("id"));
    $result = CategoryPeer::doSelectWithI18n($c);
    if (!$result)
    {
      $this->forward404();
    }
    $this->edit_category = current($result); 
    $this->forward404Unless($this->edit_category);
  }
  
  /**
   * Execute the category i18n update form
   *
   * @return void - the success template
   */
  public function executeCategoryUpdate()
  {
    // This is also not working as intended, but ok the long way round
    $edit_category = CategoryI18nPeer::retrieveByPK($this->getRequestParameter('id'), $this->getUser()->getCulture());
    $this->forward404Unless($edit_category);

    $edit_category->setName($this->getRequestParameter('name'));

    $edit_category->save();

    return $this->redirect('@listcategories');
  }

  /**
   * Save/update subreaktor name
   *
   * @return redirect 
   */
  public function executeSubreaktorNameUpdate()
  {
    $edit_subreaktor = SubreaktorPeer::retrieveByPk($this->getRequestParameter('id'));
    $this->forward404Unless($edit_subreaktor);

    $edit_subreaktor->setName($this->getRequestParameter('name'));

    $edit_subreaktor->save();

    return $this->redirect('@subreaktornames');
  }

  /**
   * List all recommended artworks across the site
   *
   * @return void
   */
  public function executeListRecommended()
  {
    $this->artworks = array();
    
    //Get all the latest recommended artworks in each subreaktor/lokalreaktor
    $this->recommended_artworks = RecommendedArtworkPeer::doSelectAllRecommendedArtwork(new Criteria());    
    foreach ($this->recommended_artworks as $recommendedartwork)
    {
      //Create a list of artworks, and where they are recommended
    	$this->artworks[$recommendedartwork->getId()] = array(
    	  'artwork'    => new genericArtwork($recommendedartwork->getArtwork(), null, array()), 
    	  'subreaktor' => $recommendedartwork->getSubreaktor(), 
    	  'lokalreaktor' => $recommendedartwork->getLocalsubreaktor(),
        'updatedat'    => $recommendedartwork->getUpdatedAt(),
    	);
    }
  }
  
  /**
   * List composite artworks
   *
   * @return null
   */
  public function executeListComposite()
  {
    $this->artworks = array();
    
    //Get all the composite artworks
    $this->artworks = ReaktorArtworkPeer::getCompositeArtworks();
  }
  
  
  public function executeListApproved()
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
  		$this->months[] = array('month' => $cc, 'artworkcount' => ReaktorArtworkPeer::countArtworksByDateAndStatus(3, $this->selected_year, $cc));
  	}
  	$this->artworks = array();
  	$this->page = $this->getRequestParameter('page', 1); 
  	$this->pager = ReaktorArtworkPeer::getArtworksByDateAndStatus(3, $this->selected_year, $this->selected_month);
  	$this->pager->setPage($this->page);
  	$this->pager->init();
  	foreach ($this->pager->getResults() as $reaktor_artwork)
  	{
  		$this->artworks[] = new genericArtwork($reaktor_artwork, null, null);
  	}
  	$this->route = '@approvedartwork_month?year='.$this->selected_year.'&month='.$this->selected_month;
  }
  
  public function executeListIgnoredUsers()
  {
  	$this->countlimit = 3;
  	if ($this->getRequestParameter('min_count') != '')
  	{
  		$this->countlimit = $this->getRequestParameter('min_count');
  	}
  	$c = new Criteria();
  	$c->clearSelectColumns();
  	$c->addSelectColumn(MessagesIgnoredUserPeer::IGNORES_USER_ID);
  	$c->addSelectColumn(sfGuardUserPeer::USERNAME);
  	$c->addSelectColumn(sfGuardUserPeer::NAME);
  	$c->addSelectColumn('count('.MessagesIgnoredUserPeer::IGNORES_USER_ID.') as countusers');
  	$c->addDescendingOrderByColumn('countusers');
  	$c->addGroupByColumn(MessagesIgnoredUserPeer::IGNORES_USER_ID);
    $having = $c->getNewCriterion(MessagesIgnoredUserPeer::IGNORES_USER_ID, ' countusers >= ' . $this->countlimit, Criteria::CUSTOM);
  	//$having = $c->getNewCriterion(MessagesIgnoredUserPeer::COUNT, $this->countlimit, Criteria::GREATER_EQUAL);
  	$c->addHaving($having);
  	$c->addJoin(MessagesIgnoredUserPeer::IGNORES_USER_ID, sfGuardUserPeer::ID);
  	$res = MessagesIgnoredUserPeer::doSelectRS($c);
  	
  	$this->users = array();
  	
  	while ($res->next())
  	{
  		$this->users[$res->getInt(1)] = array('id' => $res->getInt(1), 'username' => $res->getString(2), 'realname' => $res->getString(3), 'count' => $res->getInt(4));
  	}
  }
  
  public function executeNewCategory()
  {
  }
  
  public function executeEditorialTeams()
  {
 
    $this->forward404Unless(
	$this->getUser()->hasCredential('approveartwork') && 	    
	// Allow users to modify thier own notifications
	( $this->getUser()->hasCredential('managenotifications') || ($this->getRequestParameter('user_id')==sfContext::getInstance()->getUser()->getGuardUser()->getId() ) )
	);

    if ($this->getRequest()->isXmlHttpRequest())
    {
      $user_id = $this->getRequestParameter('user_id');
      $notify_value = $this->getRequestParameter('notify_value');
      $user = sfGuardUserPeer::retrieveByPK($user_id);
      $user->setEditorialNotification($notify_value);
      $user->save();
      return $this->renderText(sfcontext::getInstance()->getI18N()->__('Saved successfully!'));
    }
  	$this->teams = sfGuardGroupPeer::getEditorialTeams(false);
  	if ($this->getRequestParameter('team'))
  	{
  		$this->theteam = sfGuardGroupPeer::retrieveByPK($this->getRequestParameter('team'));
  		$this->members = sfGuardUserGroupPeer::getMembersofEditorialTeam($this->getRequestParameter('team'), true);
  	}
  	else
  	{
  		$this->members = null;
  	}
  }
  
  public function executeOnlineNow()
  {
    $this->onlineCount = sfGuardUserPeer::getOnlineCount();
    $this->usersOnline = sfGuardUserPeer::getOnlineUsers();
    $this->anonUsers   = $this->onlineCount - count($this->usersOnline);
  }
  
  public function executeCreateCompositeArtwork()
  {
  	$this->from_date = ($this->getRequestParameter('from_date')) ? $this->getRequestParameter('from_date') : '';
  	$this->to_date   = ($this->getRequestParameter('to_date')) ? $this->getRequestParameter('to_date') : '';
  	$this->filetypes = array('image' => sfContext::getInstance()->getI18n()->__('Images'),
  	                         'video' => sfContext::getInstance()->getI18n()->__('Videos'),
                             'audio' => sfContext::getInstance()->getI18n()->__('Audio'),
                             'pdf' => sfContext::getInstance()->getI18n()->__('PDFs'),
  	                         'text' => sfContext::getInstance()->getI18n()->__('Text'));

    // Sanitycheck the date, if provided
  	if ($this->getRequestParameter('date_check'))
  	{
  	  if ($this->from_date['year'] == 0 || $this->from_date['month'] == 0 || $this->from_date['year'] == 0)
  	  {
  	  	$this->getRequest()->setError('date', sfContext::getInstance()->getI18n()->__('Please specify a valid date'));
  	  }
  	  elseif ($this->to_date['year'] == 0 || $this->to_date['month'] == 0 || $this->to_date['year'] == 0)
      {
        $this->getRequest()->setError('date', sfContext::getInstance()->getI18n()->__('Please specify a valid date'));
      }
      else 
      {
        $fromdate     = $this->from_date['year'].'-'.$this->from_date['month'].'-'.$this->from_date['day'].' 00:00:00';
        $unixfromdate = strtotime($fromdate);
        $todate       = $this->to_date['year'].'-'.$this->to_date['month'].'-'.$this->to_date['day'].' 00:00:00';
        $unixtodate   = strtotime($todate);

        if (!$unixfromdate || !$unixtodate)
        {
          $this->getRequest()->setError('date', sfContext::getInstance()->getI18n()->__('Please specify a valid date'));
        }
        elseif ($unixfromdate > $unixtodate)
        {
          $this->getRequest()->setError('date', sfContext::getInstance()->getI18n()->__('The from-date must be before the to-date'));
        }

      }
  	}
  	
    // Sanitycheck the tags, if provided
  	if ($this->getRequestParameter('tags_check'))
  	{
  		if (trim($this->getRequestParameter('tags')) == '')
  		{
  			$this->getRequest()->setError('tags', sfContext::getInstance()->getI18n()->__('Please specify some tags'));
  		}
  	}

    // Bail out if we found any errors, or we are just visiting the page
    if ($this->getRequest()->hasErrors() || $this->getRequest()->getMethod() != sfRequest::POST)
    {
      return;
    }
  	
  	if ($this->getRequestParameter('docreate'))
  	{
  		if (is_array($this->getRequestParameter('include_file')) && count($this->getRequestParameter('include_file')) > 0)
  		{
        $files = array();
  			foreach ($this->getRequestParameter('include_file') as $file_id => $unimportant_value)
	      {
	        $files[] = new artworkFile($file_id);
	      }
	      $artwork = new genericArtwork('New composite ' . $files[0]->getFiletype() . ' artwork', $files[0]->getFiletype());
	      $artwork->setDescription('Artwork description goes here');
	      $artwork->setMultiUser(true);
	      $artwork->setUser($this->getUser()->getGuardUser());
	      $artwork->save();
	      
	      $artwork->addFiles($files);
	      $artwork->resetFirstFile();
	      return $this->redirect($artwork->getLink('edit'));
  		}
      else
      {
  			$this->getRequest()->setError('nofiles', sfContext::getInstance()->getI18n()->__('Cannot create artwork: no files selected'));
        return;
      }
  	}

    $files = array();
    // Tags search
    if ($this->getRequestParameter('tags_check'))
    {
      $files = TagPeer::getFilesTaggedWith($this->getRequestParameter('tags'));
    }
    // Only date search
    elseif ($this->getRequestParameter('date_check'))
    {
      $files = ReaktorFilePeer::getByDate($fromdate, $todate);
    }

    $allfiles = array();
    // Now filter the files by the type the user requested
    foreach ((array)$files as $file)
    {
      if ($file instanceof genericArtwork)
      {
        foreach($file->getFiles() as $file)
        {
          if ($file->getFiletype() == $this->getRequestParameter('filetype'))
          {
	$artworkExists = false;
        foreach($allfiles as $f)
                if($file->getId()==$f->getId())
                        $artworkExists = true;
	if(!$artworkExists && !$file->isDeleted() && $file->getParentArtwork()!=null && $file->getParentArtwork()->getStatus()==3 && !$file->getParentArtwork()->isDeleted())
            $allfiles[] = $file;
          }
        }
      }
      elseif ($file instanceof artworkFile)
      {
        if ($file->getFiletype() == $this->getRequestParameter('filetype'))
        {
	$artworkExists = false;
	
	foreach($allfiles as $f)
		if($file->getId()==$f->getId())
			$artworkExists = true;

	if(!$artworkExists && !$file->isDeleted() && $file->getParentArtwork()!=null && $file->getParentArtwork()->getStatus()==3 && !$file->getParentArtwork()->isDeleted())
          $allfiles[] = $file;
        }
      }
    }
    
    // Date search too, remove files that fall out of range
    if ($this->getRequestParameter('date_check'))
    {
      foreach ($allfiles as $key => $aFile)
      {
        if (!(strtotime($aFile->getUploadedAt()) >= $unixfromdate &&
            strtotime($aFile->getUploadedAt()) <= $unixtodate))
        {
          unset($allfiles[$key]);
        }
      }
    }
    
    $this->files = $allfiles;
  }

  /**
   * Display list of permission descriptions
   *
   * @return void
   */
  public function executePermissionDescriptionsList()
  {
    $this->permissions = sfGuardPermissionPeer::doSelect(new Criteria());
  }

  /**
   * Show permission description edit form
   *
   * @return void
   */
  public function executePermissionDescriptionEdit()
  {
    $this->edit_permission = sfGuardPermissionPeer::retrieveByPk($this->getRequestParameter('id'));
    $this->forward404Unless($this->edit_permission);
  }
  
  /**
   * Save/update permission description
   *
   * @return redirect 
   */
  public function executePermissionDescriptionUpdate()
  {
    $edit_permission = sfGuardPermissionPeer::retrieveByPk($this->getRequestParameter('id'));
    $this->forward404Unless($edit_permission);

    $edit_permission->setDescription($this->getRequestParameter('description'));

    $edit_permission->save();

    return $this->redirect('@sfguardpermissiondescriptionlist');
  }

    public function executeCategoryRename()
    {
      $artworks = CategoryArtwork::getArtworkIdFromCategoryId($this->getRequestParameter('id'));
      $oldCat = Category::getByBasename($this->getRequestParameter('basename'));
      $newCat = Category::getByBasename($this->getRequestParameter('new_cat'));
      if (count($artworks) == 0)
      {
      	//we should be able to merge categories even though there are no artworks connected to it.
      	$artwork = array();
      	//return $this->renderText(sfContext::getInstance()->getI18n()->__("This category does not exist"));
      }
      if (!$newCat)
      {
        return $this->renderText(sfContext::getInstance()->getI18n()->__("Failed,category doesn't exist"));
      } 
      //the "new" category exitst and we have to merge wit existing tag
      $artworkObjs = array();
      foreach ($artworks as $artwork)
      {
        $tmpArtworkObj = new genericArtwork($artwork->getArtworkId());
        $tmpArtworkObj->addCategory( $newCat->getId(), $this->getUser() );
        $tmpArtworkObj->removeCategory( $oldCat->getId() );
        $tmpArtworkObj->save();
      }
      //if we want to delete the category afterwards, uncomment this
      $oldCat->delete();
      $output = json_encode(array("success" => true));
      $this->getResponse()->setHttpHeader("X-JSON", '('.$output.')');
      return sfView::HEADER_ONLY;
    }
  
    public function executeCategoryAutocomplete()
    {
    	$this->categories = Category::getByBasenameLike($this->getRequestParameter('new_cat'));
    	
    }
    
    public function executeGetMostActiveUsers() {
    	$this->forward404Unless($this->getUser()->hasCredential('viewreports'));
    }
}

   
