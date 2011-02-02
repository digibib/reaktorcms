<?php

/**
 * Subclass for performing query and update operations on the 'reaktor_artwork' table.
 *
 * 
 *
 * @package lib.model
 */ 
class ReaktorArtworkPeer extends BaseReaktorArtworkPeer
{

  /**
   * Collect all artworks with a certain status in an array. 
   *
   * @param string $status
   * @param string $orderby
   * @param boolean $do_select_one
   * @return mixed false or artwork object(s)
   */
  public static function getArtworkByStatus($status, $orderby = "", $do_select_one = false, $count = false, $show_content_flag = false)
  {
    $artworks = array();
    $c = new Criteria();  
    $c->setDistinct();  
    $c->add(self::STATUS, $status);

    // Only show valid content - unless I have the permission to view blocked 
    // and explicitly ask for it
    if (!(sfContext::getInstance()->getUser()->hasCredential('viewallcontent') && !$show_content_flag))
    {
      $c->add(sfGuardUserPeer::SHOW_CONTENT, true);
    }
    if($do_select_one)
    {
      $c->setLimit(1);     
    }
    if($orderby)
    {   
      $c->addDescendingOrderByColumn($orderby);
    }
    if ($count)
    {
      return self::doCount($c);
    }
    foreach (self::doSelectJoinsfGuardUser($c) as $artwork)
    {
      try
      {
        $artworks[] = new genericArtwork($artwork);
      }
      catch (Exception $e)
      {
        // ignore artwork with errors
      }
    }
    if(!$artworks)
    {
      //if no match return null
      return null;
    }
    if($do_select_one)
    {
      return $artworks[0];
    }  
    else
    {
      return $artworks; 
    }
  }
  
  /**
   * Returns the number of artworks with the selected status
   *
   * @param string $status
   * 
   * @return integer
   */
  public static function getNumberofArtworksByStatus($status)
  {
    return self::getArtworkByStatus($status, '', false, true);
  }
  
  /**
   * Returns the number of artworks with the selected status
   *
   * @param string  $teams
   * @param integer $status         Status ID of the artworks
   * @param boolean $hideDiscussion Whether to exclude artworks under discussion
   * 
   * @return integer
   */
  public static function getNumberofArtworksByEditorialTeam($teams, $status = null, $hideDiscussion = false)
  {
    return self::getArtworksByEditorialTeam($teams, true, $status, $hideDiscussion);
  }
  
  /**
   * Returns the number of artworks with the selected status
   *
   * @param string $status
   * @param boolean $hideDiscussion Whether to exclude artworks under discussion
   *
   * @return integer
   */  
  public static function getArtworksByEditorialTeam($teams, $docount = false, $status = null, $hideDiscussion = false)
  {
    $artworks = array();
    $c = new Criteria();  
    $c->setDistinct();
    $editorialteams = array();
    if (is_array($teams))
    {
	    foreach ($teams as $key => $val)
	    {
	      $editorialteams[] = $key;
	    }
    }
    else
    {
    	$editorialteams[] = $teams;
    }
    if ($status)
    {
      $c->add(self::STATUS, $status);
    }
    
    if ($hideDiscussion)
    {
      $c->add(self::UNDER_DISCUSSION, '');
    }
    
    $c->add(self::TEAM_ID, $editorialteams, Criteria::IN);
    $c->addAscendingOrderByColumn(self::SUBMITTED_AT);
    if ($docount)
    {
      return self::doCount($c);
    }
    foreach (self::doSelectJoinAllExceptsfGuardGroup($c) as $artwork)
    {
      try
      {
        $artworks[] = new genericArtwork($artwork);
      }
      catch (Exception $e)
      {
        // ignore artwork with errors
      }
    }
    if(!$artworks)
    {
      //if no match return null
      return null;
    }
    return $artworks; 
  }

  /**
   * count all artworks with a certain status in an array. 
   *
   * @param string  $status          The staus ID to filter on
   * @param array   $credentials     An array of credentials to filter on (from the user accessing this function) 
   * @param integer $userId          A user ID to filter on if required
   * @param array   $teams           Array of editorial teams
   * @param boolean $only_modified   Whether to only return artwork that has been modified  
   * @param boolean $hideDiscussions Whether to hide artworks under discussion
   * 
   * @return integer the count
   */
  public static function getNumberOfArtworkByStatusAndCredentials($status, $credentials, $userId = null, $teams = null, $only_modified = false, $hideDiscussions = false)
  {
  	return self::getArtworkByStatusAndCredentialsPaginated($status, $credentials, $userId, $teams, $only_modified, $hideDiscussions, true);
  }
  
  /**
   * Collect all artworks with a certain status in an array. 
   *
   * @param string  $status          The staus ID to filter on
   * @param array   $credentials     An array of credentials to filter on (from the user accessing this function) 
   * @param integer $userId          A user ID to filter on if required
   * @param array   $teams           Array of editorial teams
   * @param boolean $only_modified   Whether to only return artwork that has been modified  
   * @param boolean $hideDiscussions Whether to hide artworks under discussion
   * 
   * @return sfPager the pager object containing the results
   */
  public static function getArtworkByStatusAndCredentialsPaginated($status, $credentials, $userId = null, $teams = null, $only_modified = false, $hideDiscussions = false, $returncount = false)
  {
    $artworks = array();
    $c = new Criteria();
    
    if ($hideDiscussions)
    {
      $c->add(self::UNDER_DISCUSSION, 0);
    }
    
    if ($userId)
    {
      $c->add(self::USER_ID,$userId);
    }
    elseif($teams)
    {
      $c->add(self::TEAM_ID, $teams, Criteria::IN);
      //$c->add(self::STATUS, $status);
    }
    if ($only_modified)
    {
    	$c->add(ReaktorArtworkPeer::MODIFIED_FLAG, '', Criteria::NOT_EQUAL);
    	//$c->add(self::STATUS, $status);
    }
    if ($status)
    {
    	$c->add(self::STATUS, $status);
    }
    if ($returncount)
    {
      return ReaktorArtworkPeer::doCount($c);
    }
    $pager = new sfPropelPager('ReaktorArtwork', SfConfig::get('app_artwork_pagination',10));
    $pager->setCriteria($c);
    return $pager;
     
  }
  
  /**
   * Return an array of unapproved genericArtworks that belong to the subreaktors
   * the (logged in) user belongs to. 
   *
   * @param sfGuardUser $user
   * 
   * @return array 
   */
  public static function getUnapprovedArtworksByUser($user)
  {
    $artworks = array();
    $c = new Criteria();    
    $c->add(ArtworkStatusPeer::NAME, 'Ready for approval');
    $c->setLimit(1);
    $ready = ArtworkStatusPeer::doSelect($c);
    
    $crit = new Criteria();
    $crit->add(self::STATUS, $ready[0]->getId() ); //ready
    if (!$user->hasCredential('approveartwork'))
    {
      $crit->add(self::USER_ID, $user->getGuardUser()->getId());
      foreach (self::doSelect($crit) as $artwork)
      {
      $artworks[] = new genericArtwork($artwork);
      }
    } else 
    {
      foreach (self::doSelect($crit) as $artwork)
      {
        try
        {
          $tmp = new genericArtwork($artwork);
          $subreaktors = $tmp->getSubreaktors();
          foreach ($subreaktors as $subreaktor)
          {
            if ($user->hasCredential('approve'.$subreaktor.'artwork'))
            {
              $artworks[] = $tmp;
              break;
            }
          }
        }
        catch (Exception $e)
        {
          // ignore artwork with errors
        }
      }
    }
    return $artworks;
  }
  
  /**
   * Get artwork statys by description 
   *
   * @param string $desc
   * @return mixed false if artwork id
   */
  public static function getStatusIdByDescription($desc)
  {
    $c = new Criteria();    
    $c->add(ArtworkStatusPeer::NAME, $desc);
    $c->setLimit(1);
    $id = ArtworkStatusPeer::doSelect($c);
    return (isset($id[0]))?$id[0]->getId():0;
  }
  
  /**
   * Return an array of latest commented reaktorArtworks.
   *
   * @param integer $count
   * @return array reaktorArtworkObjects
   */
  public static function getLatestCommented($count = 5)
  {
    if (Subreaktor::isValid())
    {
      // FIXME: uhh?
      //echo Subreaktor::getProvided();
    }
    $c = new Criteria();
    $c->clearSelectColumns();        
    self::addSelectColumns($c);    
    $c->addSelectColumn(sfCommentPeer::COMMENTABLE_ID);
    $c->addSelectColumn('max('.sfCommentPeer::CREATED_AT.') as max_date');    
    $c->add(sfCommentPeer::COMMENTABLE_MODEL, 'ReaktorArtwork', Criteria::LIKE);
    $c->add(sfCommentPeer::NAMESPACE, 'frontend', Criteria::LIKE);
    $c->add(sfCommentPeer::UNSUITABLE, false);
    $c->addGroupByColumn(sfCommentPeer::COMMENTABLE_ID);
    $c->addJoin(self::ID, sfCommentPeer::COMMENTABLE_ID, Criteria::LEFT_JOIN);
    $c->addJoin(self::USER_ID, sfGuardUserPeer::ID, Criteria::LEFT_JOIN);
    $c->add(sfGuardUserPeer::SHOW_CONTENT, true);
    
    $c->add(self::STATUS, 3);    
    $c->addDescendingOrderByColumn('max_date');
    $c->setLimit($count);
    
    $artworkObjects = self::doSelect($c);
    $returnArray    = array();
    $tmpArray    = array();


    
    foreach ($artworkObjects as $artworkObject)
    { 
      $tmpArray[$artworkObject->getArtworkIdentifier()][$artworkObject->getId()] = new genericArtwork($artworkObject);
    }

    foreach ($tmpArray as $item)
    { 
	$returnArray=array_merge($returnArray,$item);
    }
    
    
    return $returnArray;
  }
  
  /**
   * Get the latests artworks from user, subreaktor, or entire reaktor
   *
   * @param integer $count Return $count number of artworks
   * @param integer $filter Userid to get user's artwork,
   * @param boolean $random Instead of latest approved, get random 
   * @param mixed $subreaktor Filter on artworks belonging to a subreaktor
   * @param mixed $lokalreaktor Filter on artworks belonging to lokalreaktor
   * @param boolean $show_blocked_content Should the artwork display blocked artworks or not
   * @param boolean $reaktor_filter if true filter on subreaktors, if false turn filters off
   * @return array
   */
  public static function getLatestSubmittedApproved($count = 5, $filter = null, $random = null, $subreaktor = null, $lokalreaktor = null, $show_blocked_content = null, $reaktor_filter = true)
  {
    $c = new Criteria();
    if($random)
    {
      //TODO: This is not a good way to do it if the table grows..
  	  $c->addDescendingOrderByColumn('rand(now())');
    }
    else
    {
      $c->addDescendingOrderByColumn(parent::ACTIONED_AT);
    }
    $c->add(parent::STATUS, 3);
    $c->addJoin(parent::ID, ReaktorArtworkFilePeer::ARTWORK_ID, Criteria::LEFT_JOIN);
    $c->addJoin(ReaktorArtworkFilePeer::FILE_ID, ReaktorFilePeer::ID, Criteria::LEFT_JOIN);
    $c->addJoin(parent::USER_ID, sfGuardUserPeer::ID, Criteria::LEFT_JOIN);
    $c->setDistinct();
    
    if(is_int($filter))
    {
      $c->add(parent::USER_ID, $filter);
    }
   
    if ($reaktor_filter)
    {
      if ($subreaktor instanceof Subreaktor)
      {
        $c->addJoin(parent::ID, SubreaktorArtworkPeer::ARTWORK_ID, Criteria::LEFT_JOIN);
        $c->add(SubreaktorArtworkPeer::SUBREAKTOR_ID, $subreaktor->getId());
      }
      elseif (Subreaktor::getProvidedSubreaktor() instanceof Subreaktor)
      {
        $c->addJoin(parent::ID, SubreaktorArtworkPeer::ARTWORK_ID, Criteria::LEFT_JOIN);
        $c->add(SubreaktorArtworkPeer::SUBREAKTOR_ID, Subreaktor::getProvidedSubreaktor()->getId());
      }
  
      if ($lokalreaktor instanceof Subreaktor)
      {
        $c->addJoin(parent::ID, LokalreaktorArtworkPeer::ARTWORK_ID, Criteria::LEFT_JOIN);
        $c->addJoin(LokalreaktorArtworkPeer::SUBREAKTOR_ID, LokalreaktorResidencePeer::SUBREAKTOR_ID, Criteria::LEFT_JOIN);
        $ctn = $c->getNewCriterion(LokalreaktorArtworkPeer::SUBREAKTOR_ID, $lokalreaktor->getId());
        $ctn2 = $c->getNewCriterion(sfGuardUserPeer::RESIDENCE_ID, $lokalreaktor->getResidences(), Criteria::IN);
        $ctn->addOr($ctn2);
        $c->add($ctn);      
      }
      elseif (Subreaktor::getProvidedLokalreaktor() instanceof Subreaktor)
      {
        $c->addJoin(parent::ID, LokalreaktorArtworkPeer::ARTWORK_ID, Criteria::LEFT_JOIN);
        $c->addJoin(LokalreaktorArtworkPeer::SUBREAKTOR_ID, LokalreaktorResidencePeer::SUBREAKTOR_ID, Criteria::LEFT_JOIN);
        $ctn = $c->getNewCriterion(LokalreaktorArtworkPeer::SUBREAKTOR_ID, Subreaktor::getProvidedLokalreaktor()->getId());
        $ctn2 = $c->getNewCriterion(sfGuardUserPeer::RESIDENCE_ID, Subreaktor::getProvidedLokalreaktor()->getResidences(), Criteria::IN);
        $ctn->addOr($ctn2);
        $c->add($ctn);
      }
    }
    
    $c->setLimit($count);
    if (!$show_blocked_content)
    {
      $c->add(sfGuardUserPeer::SHOW_CONTENT, true);
    }
    
    $res = parent::doSelect($c);
    $artworks = array();
    foreach ($res as $r)
    {
      $artworks[] = new genericArtwork($r);
    }
    return $artworks;
    
  }
    
  public static function getArtworkById($id)
  {
    $c = new Criteria();
    $c->add(self::ID, $id);
    return self::doSelect($c);
    
  }
  
  protected static function getLatestSubmittedApprovedCriteria($user = 0, $sortBy = null)
  {
    $c = new Criteria();
    
    $c->add(parent::STATUS, 3);
    $c->addJoin(self::ID,ReaktorArtworkFilePeer::ARTWORK_ID);
    $c->addJoin(ReaktorFilePeer::ID,ReaktorArtworkFilePeer::FILE_ID);
    
    $c->setDistinct();
    
    $c->addAscendingOrderByColumn(self::ARTWORK_ORDER);
    
    if($user)
    {
      $c->add(parent::USER_ID, $user);
    }
    switch ($sortBy)
    {
      case $sortBy == 'date':
        $c->addDescendingOrderByColumn(self::CREATED_AT);
        break;
      case $sortBy == 'rating':
        $c->addDescendingOrderByColumn(self::AVERAGE_RATING);
        break;
      case $sortBy == 'title':
        $c->addAscendingOrderByColumn(self::TITLE);
        break;
      case $sortBy == 'format':
        $c->addDescendingOrderByColumn(self::ARTWORK_IDENTIFIER);
        break;
      case in_array($sortBy, Subreaktor::getAllAsReferences()):
      	$c->addJoin(ReaktorArtworkPeer::ID, SubreaktorArtworkPeer::ARTWORK_ID);
      	$c->add(SubreaktorArtworkPeer::SUBREAKTOR_ID, Subreaktor::getByReference($sortBy)->getId());
      	break;
      case is_numeric($sortBy):
      	$c->addJoin(ReaktorArtworkPeer::ID, SubreaktorArtworkPeer::ARTWORK_ID);
      	$c->add(SubreaktorArtworkPeer::SUBREAKTOR_ID, (int)$sortBy);
      default:
        $c->addDescendingOrderByColumn(parent::ACTIONED_AT);
        break;
    }
    return $c;
  }

  public static function getLatestSubmittedApprovedNotPaginated($count = 5, $user = 0, $sortBy = null)
  {
    $c = self::getLatestSubmittedApprovedCriteria($user, $sortBy);
    if ($count)
    {
      $c->setLimit($count);
    }
    return parent::doSelectJoinAll($c);
  }

  public static function getLatestSubmittedApprovedPaginated($count = 5, $user = 0, $sortBy = null)
  {
    $c = self::getLatestSubmittedApprovedCriteria($user, $sortBy);
    $pager = new sfPropelPager('ReaktorArtwork', $count);
    $pager->setCriteria($c);
    return $pager;
  }
  
  /**
   * Get most popular artworks, using current ratings, (falls back on rating_average column),
   * either filter by user or reaktor.
   *
   * @param mixed $filter_id String if reaktor int if user
   * @param integer $count
   * @return array
   */
  public static function mostPopularArtworks($subreaktor = '', $count = 5, $lokalreaktor = null, $user = null)
  {
    $c = new Criteria();
    $c->setDistinct();
    $c->addJoin(parent::ID, ReaktorArtworkFilePeer::ARTWORK_ID, Criteria::LEFT_JOIN);      
    if ($user)
    {    
      $c->add(parent::USER_ID, $user);
    }
    elseif (is_object($subreaktor))
    {
      $c->addJoin(parent::ID, SubreaktorArtworkPeer::ARTWORK_ID, Criteria::LEFT_JOIN);
      $c->add(SubreaktorArtworkPeer::SUBREAKTOR_ID, $subreaktor->getId());
    }
    elseif (Subreaktor::getProvidedSubreaktor() instanceof Subreaktor)
    {
      $c->addJoin(parent::ID, SubreaktorArtworkPeer::ARTWORK_ID, Criteria::LEFT_JOIN);
      $c->add(SubreaktorArtworkPeer::SUBREAKTOR_ID, Subreaktor::getProvidedSubreaktor()->getId());
    }
    
    if ($lokalreaktor instanceof Subreaktor)
    {
      $c->addJoin(parent::ID, LokalreaktorArtworkPeer::ARTWORK_ID, Criteria::LEFT_JOIN);
      $c->addJoin(LokalreaktorArtworkPeer::SUBREAKTOR_ID, LokalreaktorResidencePeer::SUBREAKTOR_ID, Criteria::LEFT_JOIN);
      $ctn = $c->getNewCriterion(LokalreaktorArtworkPeer::SUBREAKTOR_ID, $lokalreaktor->getId());
      $ctn2 = $c->getNewCriterion(sfGuardUserPeer::RESIDENCE_ID, $lokalreaktor->getResidences(), Criteria::IN);
      $ctn->addOr($ctn2);
      $c->add($ctn);      
    }
    elseif (Subreaktor::getProvidedLokalreaktor() instanceof Subreaktor)
    {
      $c->addJoin(parent::ID, LokalreaktorArtworkPeer::ARTWORK_ID, Criteria::LEFT_JOIN);
      $c->addJoin(LokalreaktorArtworkPeer::SUBREAKTOR_ID, LokalreaktorResidencePeer::SUBREAKTOR_ID, Criteria::LEFT_JOIN);
      $ctn = $c->getNewCriterion(LokalreaktorArtworkPeer::SUBREAKTOR_ID, Subreaktor::getProvidedLokalreaktor()->getId());
      $ctn2 = $c->getNewCriterion(sfGuardUserPeer::RESIDENCE_ID, Subreaktor::getProvidedLokalreaktor()->getResidences(), Criteria::IN);
      $ctn->addOr($ctn2);
      $c->add($ctn);      
    }
    
    $c->add(parent::STATUS, 3);
    $c->setLimit($count);
    //if (!sfContext::getInstance()->getUser()->hasCredential('viewallcontent'))
    //{
    $c->add(sfGuardUserPeer::SHOW_CONTENT, true);
    //}
    //$c2 = clone $c;
    $c->addJoin(ReaktorArtworkFilePeer::ARTWORK_ID, sfRatingPeer::RATABLE_ID);
    $c->addAsColumn('sumrating', 'AVG(' . sfRatingPeer::RATING . ')');
    $c->addAsColumn('numvotes', 'COUNT(' . sfRatingPeer::ID . ')');
    $c->add(sfRatingPeer::RATABLE_MODEL, 'ReaktorArtwork');
    $c->addDescendingOrderByColumn('sumrating');
    $c->addDescendingOrderByColumn('numvotes');
    $c->addGroupByColumn(ReaktorArtworkFilePeer::ARTWORK_ID);
    
    $c2 = clone $c;
    $c->add(sfRatingPeer::RATED_AT, time() - (60*86400), Criteria::GREATER_EQUAL);
    $reaktorartworks = parent::doSelectJoinsfGuardUser($c);
    
    $returnval = array();
    if (empty($reaktorartworks))
    {
      sfContext::getInstance()->getLogger()->info("Could not find any ratings for last two months in this subreaktor");
      sfContext::getInstance()->getLogger()->info("PEBKAC!");
      sfContext::getInstance()->getLogger()->info("Falling back to retrieving artworks by average rating");
      //$c2->addDescendingOrderByColumn(self::AVERAGE_RATING);
      $reaktorartworks = parent::doSelectJoinsfGuardUser($c2);
    }
    foreach ($reaktorartworks as $aReaktorArtwork)
    {
      $returnval[] = new genericArtwork($aReaktorArtwork);
    }
    return $returnval;
  }
  
  /**
   * Get a selection of artworks based on user/user id
   *
   * @param sfGuardUser|int $user             User ID or object
   * @param int             $limit            Limit for resultset
   * @param boolean         $random           True to return random results, default is date order
   * @param array           $exclude          array of artworks/ids to exclude from results
   * @param integer|array   $status           Status to filter on (default is 3 (approved)) 
   * @param array           $statusExclude    Array of statuses not to return in results
   * @param Criteria        $criteria         Extra criteria if needed
   * 
   * @return array Of generic artwork objects 
   */
  public static function getArtworksByUser($user, $limit = 0, $random = false, $exclude = array(), $status = 3, $statusExclude = array(), $c = null)
  {
    if ($user instanceof sfGuardUser)
    {
      $user = $user->getId();
    }
    $resultArray = array();
    
    if (!$c)
    {
      $c = new Criteria();
    }
    
    $c->add(self::USER_ID, $user);
    
    if ($limit > 0)
    {
      $c->setLimit($limit);
    }
    
    if ($random)
    {
      $c->addAscendingOrderByColumn('RAND()');
    }
    else
    {
      $c->addAscendingOrderByColumn(self::ARTWORK_ORDER);
      $c->addAscendingOrderByColumn(self::CREATED_AT);
    }
    
    foreach ($exclude as $item)
    {
      if ($item instanceof genericArtwork)
      {
        $item = $item->getId();
      }
      $c->add(self::ID, $item, Criteria::NOT_EQUAL);
    }
    
    if (!is_null($status))
    {
      if (is_array($status))
      {
        $c->add(self::STATUS, $status, Criteria::IN);
      }
      else
      {
        $c->add(self::STATUS, $status);
      }
    }
    elseif (!empty($statusExclude))
    {
      $c->add(self::STATUS, $statusExclude, Criteria::NOT_IN);
    }
    
    if (!sfContext::getInstance()->getUser()->hasCredential('viewallcontent'))
    {
      if (sfContext::getInstance()->getUser()->getGuardUser()) 
      {
        $c->add(sfGuardUserPeer::SHOW_CONTENT,"(sf_guard_user.SHOW_CONTENT=1 OR reaktor_artwork.USER_ID=" . sfContext::getInstance()->getUser()->getGuardUser()->getId() . ")", Criteria::CUSTOM);
      }
    }
    sfContext::getInstance()->getLogger()->info("foo1");
    $artworkArray = self::doSelectJoinAll($c);
    sfContext::getInstance()->getLogger()->info("foo2");
    foreach ($artworkArray as $artworkObject)
    {
    	sfContext::getInstance()->getLogger()->info("getting related artwork with id ".$artworkObject->getId());
    	$resultArray[] = new genericArtwork($artworkObject);
    }
    
    return $resultArray;
    
  }
  
  /**
   * Given an artwork, get title and id of artworks not already related to it. Designed to be used in dropdowns.
   *
   * @param int     $user_id 
   * @param int     $artwork_id
   * @param array   $related
   * @param boolean $onlyApproved Whether to return just approved artworks 
   * 
   * @return array $artworks
   */
  public static function getUnrelatedArtworks($userId = null, $artworkId = null, $related, $onlyApproved = true, $max = -1)
  {
    $c = new Criteria();
    $c->clearSelectColumns();
    $c->addSelectColumn(parent::ID);
    $c->addSelectColumn(parent::TITLE);
    $c->addJoin(self::USER_ID, sfGuardUserPeer::ID);
    $c->addSelectColumn(sfGuardUserPeer::USERNAME);
    $c->addSelectColumn(self::ARTWORK_IDENTIFIER);
    
    if ($onlyApproved)
    {
      $c->add(parent::STATUS, 3);
    }
    if ($userId)
    {
      $c->add(parent::USER_ID, $userId);
    }
    if ($artworkId)
    {
      $c->add(parent::ID, $artworkId, Criteria::NOT_EQUAL);
    }
    
    $c->add(parent::ID, $related, Criteria::NOT_IN);
    if ($max > 0)
    {
      $c->setLimit($max);
    }
    
    $rs = parent::doSelectRS($c);
    $artworks = array();
    
    while($rs->next())
    {
      $artworks[$rs->getInt(1)] = $rs->getString(2);
      if (is_null($artworkId))
      {
        $artworks[$rs->getInt(1)] = $rs->getString(2)." (".$rs->getString(4).") - ".$rs->getString(3);
      }
    }
    
    return $artworks;
    
  }

  /**
   * Count the number of artworks in the database that a user has submitted
   *
   * @param sfGuardUser|myUser|id $user          id or user object
   * @param string                $type          The type of artwork to count
   * @param integer               $statusId      The status to filter on, or all if not set
   * @param criteria              $c             Criteria object if custom criteria are needed
   * @param boolean               $groupByStatus Return an array of counts by status
   * 
   * @return integer|array a count or array of counts grouped by status
   */
  public static function countUserArtworks($user, $type = null, $statusId = null, $groupByStatus = false, $c = null)
  {
    if ($user instanceof myUser)
    {
      $user = $user->getGuardUser()->getId();
    }
    elseif ($user instanceof sfGuardUser )
    {
      $user = $user->getId();
    }
    else
    {
      $user = intval($user);
    }
    
    if (!$c)
    {
      $c = new Criteria();
    }
    
    $c->add(self::USER_ID, $user);
    
    if ($statusId)
    {
      $c->add(self::STATUS, $statusId);
    }
    
    if ($type)
    {
      $c->add(self::ARTWORK_IDENTIFIER, $type);
    }
    
    if ($groupByStatus)
    {
      $c->clearSelectColumns();
      $c->addSelectColumn(self::STATUS);
      $c->addSelectColumn(self::ACTIONED_AT);
      
      $results     = self::doSelectRS($c);
      $resultArray = array(1 => array(), 2 => array(), 3 => array(), 4 => array(), 5 => array());
      while ($results->next())
      {
        $year = $results->getString(2);
        if ($year)
        {
          $year = date("Y", strtotime($year));
        }
        else
        {
          $year = 0;
        }
        
        if (!isset($resultArray[$results->getInt(1)][$year]))
        {
          $resultArray[$results->getInt(1)][$year] = 0;
        }
        $resultArray[$results->getInt(1)][$year]++;
      }
      return $resultArray;
    }
    
    return self::doCount($c);
  }
  
  /**
   * Get a count of the artworks by year and month
   *
   * @param integer $year  The year to check
   * @param integer $month The month (optional)
   * 
   * @return integer the requested count
   */
  public static function countArtworksByDateAndStatus($status, $year, $month = 0)
  {
    $c = new Criteria();
    if ($month != 0)
    {
      $ctn = $c->getNewCriterion(self::ACTIONED_AT, mktime(null, null, null, $month, 1, $year), Criteria::GREATER_EQUAL);
      $ctn2 = $c->getNewCriterion(self::ACTIONED_AT, mktime(null, null, null, $month + 1, 1, $year), Criteria::LESS_THAN);
    }
    else
    {
      $ctn = $c->getNewCriterion(self::ACTIONED_AT, mktime(null, null, null, 1, 1, $year), Criteria::GREATER_EQUAL);
      $ctn2 = $c->getNewCriterion(self::ACTIONED_AT, mktime(null, null, null, 12, 31, $year), Criteria::LESS_THAN);
    }
    $ctn->addAnd($ctn2);
    $c->add($ctn);
    
    $c->add(self::STATUS, $status);
    return self::doCount($c);
  }

  /**
   * Get artworks by date (year and month)
   *
   * @param integer $year  The year to check
   * @param integer $month The month (optional)
   * 
   * @return sfPropelPager
   */
  public static function getArtworksByDateAndStatus($status, $year, $month = 0)
  {
    $c = new Criteria();
    if ($month != 0)
    {
      $ctn = $c->getNewCriterion(self::ACTIONED_AT, mktime(null, null, null, $month, 1, $year), Criteria::GREATER_EQUAL);
      $ctn2 = $c->getNewCriterion(self::ACTIONED_AT, mktime(null, null, null, $month + 1, 1, $year), Criteria::LESS_THAN);
    }
    else
    {
      $ctn = $c->getNewCriterion(self::ACTIONED_AT, mktime(null, null, null, 1, 1, $year), Criteria::GREATER_EQUAL);
      $ctn2 = $c->getNewCriterion(self::ACTIONED_AT, mktime(null, null, null, 12, 31, $year), Criteria::LESS_THAN);
    }
    
    $ctn->addAnd($ctn2);
    $c->addDescendingOrderByColumn(self::ACTIONED_AT);
    $c->add($ctn);
        
    $c->add(self::STATUS, $status);

    $pager = new sfPropelPager('ReaktorArtwork', SfConfig::get('app_artwork_pagination',10));
    $pager->setCriteria($c);
    return $pager;
    
    //return self::doSelectJoinAll($c);
  }
  
  /**
   * Return a count for the number of artworks currently under discussion
   *
   * @return integer the count
   */
  public static function getNumberOfArtworksUnderDiscussion()
  {
    $c = new Criteria();
    $c->add(self::UNDER_DISCUSSION, 1);
    
    return self::doCount($c);
  }
  
  /**
   * Get the artworks that are marked for discussion
   * 
   * @return array the artworks
   */
  public static function getArtworksUnderDiscussion()
  {
    $c = new Criteria();
    $c->add(self::UNDER_DISCUSSION, 1);
    
    $result = self::doSelectJoinAll($c);
    
    $returnArray = array();
    foreach ($result as $artworkObject)
    {
      $returnArray[$artworkObject->getId()] = new genericArtwork($artworkObject);
    }
    return $returnArray;
  }
  
  /**
   * Get an array of artwork objects based on type
   *
   * @param integer $type          The type of artwork we are after
   * @param integer $status        status to filter on, or null not to apply it
   * @param boolean $multiUserOnly Whether to show results from multi_user artworks only
   * @param boolean $indexedArray  Whether to return an indexed array instead of array of objects
   * @param array   $excludeArray  An array of artwork ids to exclude from the results
   * 
   * @return array
   */
  public static function getArtworksByType($type, $status = null, $multiUserOnly = false, $indexedArray = false, $excludeArray = array())
  {
    $c = new criteria();
    $c->add(self::ARTWORK_IDENTIFIER, $type);
    $c->addDescendingOrderByColumn(self::CREATED_AT);
    
    if ($status)
    {
      $c->add(self::STATUS, $status);
    }
    
    if ($multiUserOnly)
    {
      $c->add(self::MULTI_USER, 1);
    }
    
    if (!empty($excludeArray))
    {
      $c->add(self::ID, $excludeArray, Criteria::NOT_IN);
    }
    
    $rows =  self::doSelectJoinsfGuardUser($c);
    
    if ($indexedArray)
    {
      $resultArray = array();
      foreach ($rows as $row)
      {
        $resultArray[$row->getId()] = $row->getTitle();;
      }
      return $resultArray;
    }
    else
    {
      return $rows;
    }
    
  }
  
  /**
   * Get all the multi user/composite/admin created galleries
   * 
   * @return array of artwork objects
   */
  public static function getCompositeArtworks()
  {
    $c = new Criteria();
    $c->add(self::MULTI_USER, true);
    
    $result = self::doSelectJoinAll($c);
    
    $returnArray = array();
    foreach ($result as $artworkObject)
    {
      $returnArray[$artworkObject->getId()] = new genericArtwork($artworkObject);
    }
    return $returnArray;
  }
  
  /**
   * Show artworks that are possible to link to this file, based on a file object
   *
   * @param artworkFile $file
   * 
   * @return array of artworks
   */
  public static function getLinkableArtworks($file)
  {
    $alreadyLinked = $file->getParentArtworks(true);
    
    $c = new Criteria();
    $c->add(self::STATUS, 5, Criteria::NOT_EQUAL); // Don't show deleted artworks
    
    $allowedTypes = array($file->getIdentifier());
    
    // See if we have any defined additional types other than the one for this file
    $additionalTypesArray = sfConfig::get("app_artwork_additional_file_types", array());
    if (isset($additionalTypesArray[$file->getIdentifier()]))
    {
      $allowedTypes = array_merge($allowedTypes, $additionalTypesArray[$file->getIdentifier()]);
    }

    $c->add(ReaktorArtworkPeer::ARTWORK_IDENTIFIER, $allowedTypes, Criteria::IN);
    
    $c->add(ReaktorArtworkPeer::USER_ID, $file->getUserId());
    if (!empty($alreadyLinked))
    {
      $c->add(ReaktorArtworkPeer::ID, $alreadyLinked, Criteria::NOT_IN);
    }
    return ReaktorArtworkPeer::doSelect($c); 
  }
}
