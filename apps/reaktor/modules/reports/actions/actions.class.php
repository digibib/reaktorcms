<?php
/**
 * Reports to get useful statistics on artwork and users.  
 * 
 * PHP Version 5
 *
 * @author    Russ Flynn <russ@linpro.no>
 * @author     dae@linpro.no
 * @author     olepw@linpro.no 
 * @author     juneh@linpro.no
 * @copyright 2008 Linpro AS
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 * 
 */

/**
 * Reports to get useful statistics on artwork and users.  
 * 
 * PHP Version 5
 *
 * @author    Russ Flynn <russ@linpro.no>
 * @author     dae@linpro.no
 * @author     olepw@linpro.no 
 * @author     juneh@linpro.no
 * @copyright 2008 Linpro AS
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 * 
 */
class reportsActions extends sfActions
{
    
  /**
   * Execute the artwork report template
   *
   * @return null
   */
  public function executeArtworkReports()
  {
  	$this->subreaktor_id               = $this->getRequestParameter('subreaktor_id');
  	$this->subreaktor_check            = ($this->getRequestParameter('subreaktor_check') != '') ? true : false;
    $this->category_id                 = $this->getRequestParameter('category_id');
    $this->category_check              = ($this->getRequestParameter('category_check') != '') ? true : false;
    $this->tags                        = $this->getRequestParameter('tags');
    $this->tags_check                  = ($this->getRequestParameter('tags_check') != '') ? true : false;
    $this->editorial_team_id           = $this->getRequestParameter('editorial_team_id');
    $this->editorial_team_check        = ($this->getRequestParameter('editorial_team_check') != '') ? true : false;
    $this->editorial_team_member_id    = $this->getRequestParameter('editorial_team_member_id');
    $this->editorial_team_member_check = ($this->getRequestParameter('editorial_team_member_check') != '') ? true : false;
    $this->status_value                = $this->getRequestParameter('status_value');
    $this->status_check                = ($this->getRequestParameter('status_check') != '') ? true : false;
    $this->under_discussion_check      = ($this->getRequestParameter('under_discussion_check') != '') ? true : false;
    $this->from_date_check             = $this->getRequestParameter('from_date_check');
    $this->from_date                   = $this->getRequestParameter('from_date');
    $this->from_date                   = ($this->from_date_check) ? $this->from_date : date('');
    $this->to_date_check               = $this->getRequestParameter('to_date_check');
    $this->to_date                     = $this->getRequestParameter('to_date');
    $this->to_date                     = ($this->to_date_check) ? $this->to_date : date('');
    $this->num_artworks                = 0;
    // If current month is checked we can generate the dates automatically
    if ($this->getRequestParameter("current_month_check"))
    {
      $this->from_date["year"]  = date("Y");
      $this->from_date["month"] = date("m");
      $this->from_date["day"]   = 1;
      $this->to_date["year"]    = date("Y");
      $this->to_date["month"]   = date("m");
      $this->to_date["day"]     = date("t");
    }
    
    $crit                              = new Criteria();
  	if ($this->subreaktor_check)
  	{
  		$crit->addJoin(ReaktorArtworkPeer::ID, SubreaktorArtworkPeer::ARTWORK_ID, Criteria::LEFT_JOIN);
  		$crit->addJoin(ReaktorArtworkPeer::ID, LokalreaktorArtworkPeer::ARTWORK_ID, Criteria::LEFT_JOIN);
  		$ctn  = $crit->getNewCriterion(SubreaktorArtworkPeer::SUBREAKTOR_ID, $this->subreaktor_id);
  		$ctn2 = $crit->getNewCriterion(LokalreaktorArtworkPeer::SUBREAKTOR_ID, $this->subreaktor_id);
  		$ctn->addOr($ctn2);
  		$crit->add($ctn);
  	}
    if ($this->category_check)
    {
      $crit->addJoin(ReaktorArtworkPeer::ID, CategoryArtworkPeer::ARTWORK_ID, Criteria::LEFT_JOIN);
      $crit->add(CategoryArtworkPeer::CATEGORY_ID, $this->category_id);
    }
    if ($this->tags_check)
    {
      $artwork_ids = TagPeer::getObjectsTaggedWith($this->tags, array('return_ids' => true));
      $crit->add(ReaktorArtworkPeer::ID, $artwork_ids, Criteria::IN);
    }
    if ($this->editorial_team_check)
    {
      $crit->add(ReaktorArtworkPeer::TEAM_ID, $this->editorial_team_id);
    }
    if ($this->editorial_team_member_check)
    {
      $crit->add(ReaktorArtworkPeer::ACTIONED_BY, $this->editorial_team_member_id);
    }
    if ($this->status_check)
    {
      $crit->add(ReaktorArtworkPeer::STATUS, $this->status_value);
    }
    if ($this->under_discussion_check)
    {
      $crit->add(ReaktorArtworkPeer::UNDER_DISCUSSION, true);
    }
    if (($this->from_date_check && $this->to_date_check) || $this->getRequestParameter("current_month_check"))
    {
    	$ctn = $crit->getNewCriterion(ReaktorArtworkPeer::ACTIONED_AT, $this->from_date['year'].'-'.$this->from_date['month'].'-'.$this->from_date['day'].' 00:00:00', Criteria::GREATER_EQUAL);
    	$ctn2 = $crit->getNewCriterion(ReaktorArtworkPeer::ACTIONED_AT, $this->to_date['year'].'-'.$this->to_date['month'].'-'.$this->to_date['day'].' 00:00:00', Criteria::LESS_EQUAL);
    	$ctn->addAnd($ctn2);
    	$crit->add($ctn);
    }
    elseif ($this->from_date_check)
    {
      $crit->add(ReaktorArtworkPeer::ACTIONED_AT, $this->from_date['year'].'-'.$this->from_date['month'].'-'.$this->from_date['day'].' 00:00:00', Criteria::GREATER_EQUAL);
    }
    elseif ($this->to_date_check)
    {
      $crit->add(ReaktorArtworkPeer::ACTIONED_AT, $this->to_date['year'].'-'.$this->to_date['month'].'-'.$this->to_date['day'].' 00:00:00', Criteria::LESS_EQUAL);
    }
    $this->report_type = $this->getRequestParameter('report_type');
  	if ($this->getRequest()->getMethod() == sfRequest::GET)
  	{
   	  $artworks_res = ReaktorArtworkPeer::doSelect($crit);
   	  if ($artworks_res && $this->report_type == 1)
   	  {
   	  	$this->num_artworks = count($artworks_res);
   	  	$this->diff = 0;
        foreach ($artworks_res as $artwork)
        {
          $artwork = new genericArtwork($artwork);
          if ($artwork->getActionedBy(true) != 0)
          {
            $this->diff += (strtotime($artwork->getActionedAt()) - strtotime($artwork->getSubmittedAt()));
          }
        }
        $this->diff = ($this->diff / $this->num_artworks);
   	  }
   	  else
   	  {
   	  	$this->artworks = array();
   	  	foreach ($artworks_res as $artwork)
   	  	{
   	  	  $this->artworks[] = new genericArtwork($artwork);
   	  	}
   	  }
  	}
  }  
  
  /**
   * executes user report page
   * 
   * @return null
   */
  public function executeUserReports()
  {  
    $interests = Subreaktor::getAll();
    $this->interests = array(0 => sfContext::getInstance()->getI18n()->__("Any"));
    
    foreach ($interests as $interest)
    {
      $this->interests[$interest->getId()] = $interest->getName();
    }
    
    $residences = ResidencePeer::doSelect(new Criteria());
    $this->residences = array();
    
    foreach ($residences as $residence)
    {
      $this->residences[$residence->getId()] = $residence->getName();
    }
    
    $this->report_types = array(0 => $this->getContext()->getI18n()->__('Most active users uploading'),
                                1 => $this->getContext()->getI18n()->__('Most active users commenting'));
    
     // Has a report been submitted?
    switch ($this->getRequestParameter("execute"))
    {
      case "userReport":
        $this->_executeUserReportsQuery();
        break;
      case "activityReport":
        $this->_executeUserActivityReportsQuery();
        break;
      default:
        //Nothing to process
        break;
    }
  }
  
  /**
   * Show a list of bookmarked reports
   *
   * @return null - render the template
   */
  public function executeShowBookmarks()
  {
    // Get all the bookmarked reports
    $this->groupedReports = ReportBookmarkPeer::getAllGroupedByType();
  }
  
  /**
   * executes user report query
   * 
   * @return null - just passes the required output to the template
   */  
  protected function _executeUserReportsQuery()
  { 
    $args = array();
    
    $args["startDateArr"] = $this->getRequestParameter('startDateArr');
  	$args["endDateArr"]   = $this->getRequestParameter('endDateArr');
    $args["interest"]     = $this->getRequestParameter('interest');
    $args["residence"]    = $this->getRequestParameter('residence');
    $args["sex"]          = $this->getRequestParameter('sex');
    if($this->getRequestParameter('activated_check')=='1')
        $args["activated"]         = ($this->getRequestParameter('activatedYesNo')=='0' ? false : true  );
    if($this->getRequestParameter('verified_check')=='1')
        $args["verified"]          =  ($this->getRequestParameter('verifiedYesNo')=='0' ? false : true  );
    if($this->getRequestParameter('showContent_check')=='1')
        $args["showContent"]       = ($this->getRequestParameter('showContentYesNo')=='0' ? false : true  );
    // Check the above to see if we should process them (have their corresponding checkboxes been checked?)
    foreach ($args as $key => $arg)
    {
      if (!$this->getRequestParameter($key."_check"))
      {
        unset ($args[$key]);
      }
    }
    
    $args["publishedArtwork"]    = $this->getRequestParameter('publishedArtwork');
    $args["notPublishedArtwork"] = $this->getRequestParameter('notPublishedArtwork');
    $args["commentedArtwork"]    = $this->getRequestParameter('commentedArtwork');
    $args["notCommentedArtwork"] = $this->getRequestParameter('notCommentedArtwork');
    $args["voted"]               = $this->getRequestParameter('voted');
    $args["notVoted"]            = $this->getRequestParameter('notVoted');
    $args["commentAndOr"]        = $this->getRequestParameter('commentAndOr');
    $args["voteAndOr"]           = $this->getRequestParameter('voteAndOr');
    
    // If current month is checked we can generate the start and end dates automatically
    if ($this->getRequestParameter("current_month_check"))
    {
      $args["startDateArr"]["year"] = date("Y");
      $args["startDateArr"]["month"]= date("m");
      $args["startDateArr"]["day"]  = "01";
      $args["endDateArr"]["year"]   = date("Y");
      $args["endDateArr"]["month"]  = date("m");
      $args["endDateArr"]["day"]    = date("t");
    }
    
    // Strip out null and empty data
    foreach ($args as $key => $arg)
    {
      if (!$arg && !is_bool($arg))
      {
        unset ($args[$key]);
      }
    }
    
    if   (isset($args["startDateArr"]) && isset($args["startDateArr"]['day']) 
          && isset($args["startDateArr"]['month']) && isset($args["startDateArr"]['year'])) 
    {
      $args['startDate'] = $args["startDateArr"]['year']."-".$args["startDateArr"]['month']."-".$args["startDateArr"]['day'];
    }
    
   if   (isset($args["endDateArr"]) && isset($args["endDateArr"]['day']) && isset($args["endDateArr"]['month']) 
          && isset($args["endDateArr"]['year'])) 
    {
      $args['endDate']   = $args["endDateArr"]['year']."-".$args["endDateArr"]['month']."-".$args["endDateArr"]['day'];
    }
    $this->resultset = sfGuardUserPeer::reportQuery($args);
  }
  
  /**
   * Execute the user activity report query
   * 
   * @return null - just passes the required output to the template
   */
  protected function _executeUserActivityReportsQuery()
  {
    $startActivityDateArr = $this->getRequestParameter('startActivityDate');
    $endActivityDateArr   = $this->getRequestParameter('endActivityDate');
    $startActivityDate    = "";
    $endActivityDate      = "";
    $sex                  = $this->getRequestParameter('sex');
    $subreaktor           = $this->getRequestParameter('subreaktor');
    
   // If current month is checked we can generate the start and end dates automatically
    if ($this->getRequestParameter("current_month_activity_check"))
    {
      $startActivityDateArr["year"] = date("Y");
      $startActivityDateArr["month"]= date("m");
      $startActivityDateArr["day"]  = "01";
      $endActivityDateArr["year"]   = date("Y");
      $endActivityDateArr["month"]  = date("m");
      $endActivityDateArr["day"]    = date("t");
    }
    
    if ($startActivityDateArr['day'] && $startActivityDateArr['month'] && $startActivityDateArr['year'])
    {
      $startActivityDate = $startActivityDateArr['year']."-".$startActivityDateArr['month']."-".$startActivityDateArr['day'];
    }
    if ($endActivityDateArr['day'] && $endActivityDateArr['month'] && $endActivityDateArr['year'])
    {
      $endActivityDate = $endActivityDateArr['year']."-".$endActivityDateArr['month']."-".$endActivityDateArr['day'];
    }
    switch ($this->getRequestParameter('reportType'))
    {
      case 0:
        $this->res = sfGuardUserPeer::getMostActiveUsers(20, $startActivityDate, $endActivityDate, $subreaktor, $sex);
        break;
      case 1:
        $this->res = sfGuardUserPeer::getMostCommentingUsers(20, $startActivityDate, $endActivityDate, $subreaktor, $sex);
        break;
      default:
        $this->res = array();
        break;
    }
  }
  
  /**
   * Ajax function for saving new bookmark
   *
   * @return null - renders the ajax response
   */
  public function executeSaveNewBookmark()
  {
    $this->forward404Unless($this->getRequest()->isXmlHttpRequest() && $this->getUser()->hasCredential("viewreports"));
    $queryArray  = explode("?", $this->getRequestParameter("url"));
    
    $this->forward404Unless(isset($queryArray[1]));
    $queryString = $queryArray[1];

    //Create a restful URI
    $url_parameters = $this->getController()->convertUrlStringToParameters('admin/reports?'.$queryString);

    $url = '';
    foreach ($url_parameters[1] as $key => $value)
    {
      if($value && $key != 'action' && $key != 'module' 
                && $key != 'sf_culture' && $key != 'commit' 
                && $key != 'report_type' && $value != '0')
      {
        $url.= '/'.$key.'/'.$value;        
      }
        
    }
    $queryString = $url;
    
    // Time to create the new report bookmark
    $newReport = new ReportBookmark();
    $newReport->setTitle($this->getRequestParameter("title"));
    $newReport->setDescription($this->getRequestParameter("description"));
    $newReport->setArgs($queryString);
    $newReport->setType($this->getRequestParameter("type"));
    $newReport->save();
    
    // Don't want to spend time on validation, so we'll go for a default title instead
    if (!trim($newReport->getTitle()))
    {
      $newReport->setTitle(sfContext::getInstance()->getI18N()->__("Untitled report %report_id%", array("%report_id%" => $newReport->getId())));
      $newReport->save();
    }
    
    sfLoader::loadHelpers(array('Partial'));
    return $this->renderText(get_partial("reports/savedReportBlock", array("savedReport" => $newReport, "type" => $this->getRequestParameter("type"))));
  }
  
  /**
   * Ajax function to update the priority order of bookmarked reports
   *
   * @return null - renders an appropriate response
   */
  public function executeUpdateBookmarkOrder()
  {
    $this->forward404Unless($this->getRequest()->isXmlHttpRequest() && $this->getUser()->hasCredential("viewreports"));
    
    // Loop through all the posted data to find any sort lists
    // This means we can potentially sort any type of report and handle it automatically
    // There are multiple sorted lists on the same page which all use this action, so they have different IDs
    foreach ($this->getRequest()->getParameterHolder()->getNames() as $param)
    {
      if (strpos($param, "sort_") !== false)
      {
        $sortValues = $this->getRequestParameter($param);
      }
    }
    foreach ($sortValues as $sortOrder => $reportId)
    {
      $reportBookmark = ReportBookmarkPeer::retrieveByPK($reportId);
      $reportBookmark->setListOrder($sortOrder);
      $reportBookmark->save();
    }
    return true;
  }
  
  /**
   * Delete a report via ajax
   *
   * @return null
   */
  public function executeDeleteReport()
  {
    $this->forward404Unless($this->getRequest()->isXmlHttpRequest() && $this->getUser()->hasCredential("viewreports"));
    
    $bookmarkToDelete = ReportBookmarkPeer::retrieveByPK($this->getRequestParameter("id"));
    if ($bookmarkToDelete)
    {
      $bookmarkToDelete->Delete();
    }
    
    //For debug if someone is looking at the ajax response
    return $this->renderText("deleted report ".($this->getRequestParameter("id") ? $this->getRequestParameter("id") : "none"));
  }
}
