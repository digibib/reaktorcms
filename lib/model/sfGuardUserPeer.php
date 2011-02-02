<?php
/**
 * 
 * This file started out as a copy of the file in plugin. We don't want to 
 * make changes to plugin files, so we copied the file to lib/model to
 * be able to override it. 
 * 
 * PHP 5 version 5
 *
 * @author juneih
 * @license http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 * @copyright 2008 Linpro
 *
 */

/**
 * The static functions for sfguarduser.
 * 
 * PHP 5 version 5
 *
 * @author juneih
 * @license http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 * @copyright 2008 Linpro
 * 
 */
class sfGuardUserPeer extends PluginsfGuardUserPeer
{
  /**
   * We need to make sure sfGuardUser.php runs from /lib/model not plugin if we
   * want to override the model and add extra functions. 
   *
   * @return string
   */
  public static function getOMClass()
  {
    //return 'lib.model.sfGuardPlugin.sfGuardUser';
    return 'lib.model.sfGuardUser';
  }
  
  /**
   * Retrive user by salt
   *
   * @param unknown_type $salt
   * @return unknown
   */
  public static function retrieveBySalt($salt)
  {
    $c = new Criteria();
    $c->add(self::SALT, $salt);
    
    return self::doSelectOne($c);     
  }
  
  /**
   * Get all emails from all users who ticket the opt in e-mail box
   *
   * @return array $emails String array of e-mails
   */
  public static function retrieveOptInEmails()
  {
    $c = new Criteria();
    $c->addSelectColumn(sfGuardUserPeer::EMAIL);
    $c->add(sfGuardUserPeer::OPT_IN, 1, Criteria::EQUAL);
    
    $rs = sfGuardUserPeer::doSelectRS($c);
    $emails = array();
    while($rs->next())
    {
      $emails[] = $rs->getString(1);
    }    
    return $emails;
  }
  
  public static function retrieveByEmail($email)
  {
    $c = new Criteria();
    $c->add(self::EMAIL, $email);
    
    return self::doSelectOne($c);
  }
  
  /**
   * Returns a user with that username
   *
   * @param string $username
   * 
   * @return sfGuardUser
   */
  public static function getByUsername($username)
  {
    $c = new Criteria();
    $c->add(self::USERNAME, $username);
    
    return self::doSelectOne($c);
  }

  /**
   * Returns an array of users whose username starts with the provided phrase
   *
   * @param string $starting_with
   * 
   * @return array
   */
  public static function getByUsernameStartingWith($starting_with)
  {
    $c = new Criteria();
    $c->add(self::USERNAME, $username . '%', Criteria::LIKE);
    $c->add(self::IS_ACTIVE, true);
    $c->add(self::IS_VERIFIED, true);
    
    return self::doSelectOne($c);
  }
  
  public static function getUsersByMatchingInterests($user_id, $count = null)
  {
    $c = new Criteria();
    $c->add(UserInterestPeer::USER_ID, $user_id);
    $user_interests = UserInterestPeer::doSelect($c);
    
    $interests = array();
    
    foreach($user_interests as $user_interest)
    {
      $interests[] = $user_interest->getSubreaktorId();
    }
    
    $uc = new Criteria();
    $uc->add(UserInterestPeer::SUBREAKTOR_ID, $interests, Criteria::IN);
    $uc->addJoin(parent::ID, UserInterestPeer::USER_ID, Criteria::LEFT_JOIN);
    $uc->add(parent::ID, $user_id, Criteria::NOT_EQUAL);
    $uc->setDistinct();
    $uc->add(parent::IS_ACTIVE, 1);    
    $uc->addDescendingOrderByColumn('rand(now())');
    $uc->addDescendingOrderByColumn(parent::CREATED_AT);
    if($count)
    {
      $uc->setLimit($count);
    }
    
    return parent::doSelect($uc);
  }

  public static function getAllActiveUsers()
  {
    $c = new Criteria();
    
    $c->add(parent::IS_ACTIVE, 1);
    
    return parent::doSelect($c);
  }


  /**
   * Retrieve all users with usernames starting with $chars
   * 
   * @param string $chars 
   * @return array
   */
  public static function getUsernamesStartingWith($chars, $limit = 0)
  {
    $c = new Criteria();
    
    $c->add(parent::IS_ACTIVE, 1);
    $c->add(parent::IS_VERIFIED, 1);
    $c->add(parent::USERNAME, "$chars%", Criteria::LIKE);
    if ($limit > 0)
    {
      $c->setLimit($limit);
    }
    
    return parent::doSelect($c);
  }

  /**
   * Retrive all active&verified users
   * 
   * @param mixed $limit 
   * @param mixed $showcontent 
   * @param mixed $subreaktor 
   * @param mixed $lokalreaktor 
   * @return array
   */
  public static function getLastUsers($limit, $showcontent, $subreaktor, $lokalreaktor, $active = false)
  {
    $c = new Criteria();
    $c->addDescendingOrderByColumn(sfGuardUserPeer::ID);
    $c->add(parent::IS_ACTIVE, 1);
    $c->add(parent::IS_VERIFIED, 1);

    if ($showcontent)
    {
      $c->add(sfGuardUserPeer::SHOW_CONTENT, true);
    }
    
    if ($active) 
    {
      $c->add(sfGuardUserPeer::LAST_ACTIVE, null, Criteria::NOT_EQUAL);
    }

    $c->setLimit($limit);
    if ($subreaktor || $lokalreaktor || Subreaktor::isValid())
    {
      $c->addJoin(parent::ID, UserInterestPeer::USER_ID, Criteria::LEFT_JOIN);
      $c->addJoin(UserInterestPeer::SUBREAKTOR_ID, SubreaktorPeer::ID);
      
      if ($subreaktor)
      {
        $reference = $subreaktor instanceof Subreaktor ? $subreaktor->getReference() : $subreaktor;
        $c->add(SubreaktorPeer::REFERENCE, $reference, Criteria::EQUAL);
      }
      elseif (Subreaktor::getProvidedSubreaktor() instanceof Subreaktor)
      {
      	$c->add(SubreaktorPeer::REFERENCE, Subreaktor::getProvidedSubreaktor()->getReference(), Criteria::EQUAL);
      }
    
      if ($lokalreaktor)
      {
        $reference = $lokalreaktor instanceof Subreaktor ? $lokalreaktor->getReference() : $lokalreaktor;
        $c->add(SubreaktorPeer::REFERENCE, $reference, Criteria::EQUAL);
      }
      elseif (Subreaktor::getProvidedLokalreaktor() instanceof Subreaktor)
      {
        $c->add(SubreaktorPeer::REFERENCE, Subreaktor::getProvidedLokalreaktor()->getReference(), Criteria::EQUAL);
      }
      
    }
    
    return parent::doSelect($c);
  }
  
  /**
   * Execute report query
   * 
   * @param array $args An array of all the possible arguments
   * 
   * @return array
   */
  public static function reportQuery($args)
  {
  	
  	$c = new Criteria();
    
    if (isset($args["interest"]))
    {
      $c->addJoin(parent::ID, UserInterestPeer::USER_ID, Criteria::LEFT_JOIN);
      $c->add(UserInterestPeer::SUBREAKTOR_ID, $args["interest"]);
    }

    if (isset($args["residence"]))
    {
      $c->add(sfGuardUserPeer::RESIDENCE_ID, $args["residence"]);
    }
    
    if (isset($args["sex"]))
    {
      $c->add(sfGuardUserPeer::SEX, $args["sex"]);
    }
    

    if (isset($args["activated"]))
    {
      $c->add(sfGuardUserPeer::IS_ACTIVE, $args["activated"]);
    }


    if (isset($args["verified"]))
    {
      $c->add(sfGuardUserPeer::IS_VERIFIED, $args["verified"]);
    }


    if (isset($args["showContent"]))
    {
      $c->add(sfGuardUserPeer::SHOW_CONTENT, $args["showContent"]);
    }




    
    $user_ids1 = array();
    $user_ids2 = array();
    $user_ids3 = array();
    
    if (isset($args["publishedArtwork"]) || isset($args["notPublishedArtwork"]))
    {
      $d = new Criteria();
      $d->addJoin(parent::ID, ReaktorArtworkPeer::USER_ID, Criteria::LEFT_JOIN);
      $d->addGroupByColumn(ReaktorArtworkPeer::USER_ID);
      
      $users = sfGuardUserPeer::doSelect($d);
      
      foreach ($users as $user)
      {
        $user_ids1[] = $user->getId();
      }
      if (isset($args["publishedArtwork"]) || isset($args["notPublishedArtwork"]))
      {
        $c->add(self::ID, $user_ids1, Criteria::IN);
      }
      if (isset($args["notPublishedArtwork"]))
      {
        $c->add(self::ID, $user_ids1, Criteria::NOT_IN);
      }
    }
    
    if (isset($args["commentedArtwork"]) || isset($args["notCommentedArtwork"]))
    {
       $d = new Criteria();
       $d->addJoin(parent::ID, sfCommentPeer::AUTHOR_ID, Criteria::LEFT_JOIN);
       $d->addGroupByColumn(sfCommentPeer::AUTHOR_ID);
       
       $users = sfGuardUserPeer::doSelect($d);
       
       foreach ($users as $user)
       {
         
          $user_ids2[] = $user->getId();
       }
       
       if (isset($args["commentAndOr"]) /*&& isset($args["publishedArtwork"])*/)
      {
        if(isset($args["commentedArtwork"]))
        {
          $c->addAnd(self::ID, $user_ids2, Criteria::IN);
        }
        if(isset($args["notCommentedArtwork"]))
        {
          $c->addAnd(self::ID, $user_ids2, Criteria::NOT_IN);
        }
      }
      else
      {
      	if (isset($args["commentedArtwork"]))
        {
          $c->addOr(self::ID, $user_ids2, Criteria::IN);
        }
        if (!isset($args["commentedArtwork"]))
        {
          $c->addOr(self::ID, $user_ids2, Criteria::NOT_IN);
        }
      }
    }
    
    if (isset($args["voted"]) || isset($args["notVoted"]))
    {
       $d = new Criteria();
       $d->addJoin(parent::ID, sfRatingPeer::USER_ID, Criteria::LEFT_JOIN);
       $d->addGroupByColumn(sfRatingPeer::USER_ID);

       $users = sfGuardUserPeer::doSelect($d);
       $user_ids = array();
       foreach ($users as $user)
       {
         $user_ids3[] = $user->getId();
       }
       if (isset($args["voteAndOr"]) && (isset($args["publishedArtwork"]) 
           || isset($args["commentedArtwork"]) || isset($args["notPublishedArtwork"]) || isset($args["notCommentedArtwork"])))
       {
          if (isset($args["voted"]))
          {
            $c->addAnd(self::ID, $user_ids3, Criteria::IN);
          }
          if (isset($args["notVoted"]))
          {
            $c->addAnd(self::ID, $user_ids3, Criteria::NOT_IN);
          }
       }
       else
       {
          if (isset($args["voted"]))
          {
            $c->addOr(self::ID, $user_ids3, Criteria::IN);
          }
          if (isset($args["notVoted"]))
          {
            $c->addOr(self::ID, $user_ids3, Criteria::NOT_IN);
          }
       }
      
    }
    
    $c->setDistinct();
    $c_copy = clone($c);

    if (isset($args["startDate"]))
    {
       $critA = $c->getNewCriterion(sfGuardUserPeer::CREATED_AT, $args["startDate"], Criteria::GREATER_EQUAL);
       $c->addAnd($critA);
    }
    
    
    if (isset($args["endDate"]))
    {
       $critB = $c->getNewCriterion(sfGuardUserPeer::CREATED_AT, $args["endDate"], Criteria::LESS_EQUAL);
       $c->addAnd($critB);
    }
    $res['query'] =  self::doSelectJoinAll($c);
    if (isset($args["startDate"]) && isset($args["endDate"]))
    {
      $steps    = 10;
      $timeDiff = strtotime($args["endDate"]) - strtotime($args["startDate"]);
      $step     = $timeDiff / $steps;
      for ($i = 0 ; $i <= $steps ; $i++)
      {
        $c = clone($c_copy);
        $c->add($c->getNewCriterion(sfGuardUserPeer::CREATED_AT, date("Y-m-d", strtotime($args["startDate"]) + $step * $i), Criteria::GREATER_THAN));
        $c->addAnd($c->getNewCriterion(sfGuardUserPeer::CREATED_AT, date("Y-m-d", strtotime($args["startDate"]) + $step * ($i+1)), Criteria::LESS_THAN));
       
        $tmp = self::doSelectJoinAll($c);
        unset($c);
        $res['graphData'][]                = count($tmp);
        $res['dateData'][] = array(
            "start"                        => strtotime($args["startDate"]) + $step * ($i-1),
            "end"                          => strtotime($args["startDate"]) + $step * $i,
        );
      }
    }
    return $res;
  }
  
  /**
   * Get the most active users in different ways. like uploads
   *  Used for reports
   *
   * @param int $limit
   * @param date string $start
   * @param sate string $end
   * @param int $subreaktor
   * @param int $sex
   * @return array
   */
  public static function getMostActiveUsers($limit = 20, $start = null, $end = null, $subreaktor = null, $sex = null)
  {
    $extraWhereClause = "";
    $extraTables      = "";
    $endWhereClause   = "";
    $timeDiff         = strtotime($end) - strtotime($start);
    $steps            = 10;
    $step             = $timeDiff / $steps;
    
    if ($start)
    {
      $extraWhereClause .= "AND submitted_at >= '$start' ";
    }
    if ($end)
    {
      $endWhereClause .= "AND submitted_at <= '$end' ";
    }
    if ($subreaktor)
    {
      $extraWhereClause .= "AND subreaktor_artwork.artwork_id = reaktor_artwork.id ".
                           "AND subreaktor_artwork.subreaktor_id = subreaktor.id ".
                           "AND subreaktor.id = $subreaktor";
      $extraTables = ",subreaktor_artwork,subreaktor ";
    }
    if ($sex)
    {
      $extraWhereClause .= "AND sf_guard_user.sex = $sex ";
    }
    $query = "SELECT user_id,username,COUNT(*) as cnt FROM reaktor_artwork,sf_guard_user $extraTables ".
             "WHERE reaktor_artwork.user_id = sf_guard_user.id $extraWhereClause $endWhereClause GROUP BY user_id ORDER BY cnt DESC LIMIT $limit";
    
    $graphQueries = array();
    $allRes = array();
    if ($start && $end)
    {  
      for ($i = 0 ; $i <= $steps ; $i++)
      {
        $endWhereClause = "AND submitted_at < '".date("Y-m-d",strtotime($start) + $step * $i)."' " . 
                          "AND submitted_at > '".date("Y-m-d",strtotime($start) + $step * ($i-1))."' ";;
        //print $endWhereClause.'<br />';
        $graphQueries[] = "SELECT user_id,username,COUNT(*) as cnt FROM reaktor_artwork,sf_guard_user $extraTables ".
               "WHERE reaktor_artwork.user_id = sf_guard_user.id $extraWhereClause $endWhereClause GROUP BY user_id ORDER BY cnt DESC"; 
        
        $allRes['dateData'][]['start']  = strtotime($start)+ $step * ($i-1);
        $allRes['dateData'][count($allRes['dateData'])-1]['end']    = strtotime($start)+ $step * $i;
      }
    }
    
    return self::reportCreoleQuery($query, $graphQueries,$allRes);
    
  }
  
  /**
   * Get the users with most comments'used for reports
   *
   * @param int $limit
   * @param date string $start
   * @param date string $end
   * @param int $subreaktor
   * @param int $sex
   * @return array
   */
  public static function getMostCommentingUsers($limit = 20, $start = null, $end = null, $subreaktor = null, $sex = null)
  {
    $extraWhereClause = "";
    $extraTables = "";
    $timeDiff = strtotime($end) - strtotime($start);
    $steps = 10;
    $step = $timeDiff/$steps;
    $endWhereClause = "";
    if ($start)
    {
      $extraWhereClause .= "AND sf_comment.created_at >= '$start' ";
    }
    if ($end)
    {
      $endWhereClause .= "AND sf_comment.created_at <= '$end' ";
    }
    if ($subreaktor)
    {
      $extraWhereClause .= "AND sf_comment.commentable_id = reaktor_artwork.id ".
                            "AND subreaktor_artwork.artwork_id = reaktor_artwork.id ".
                           "AND subreaktor_artwork.subreaktor_id = subreaktor.id ".
                           "AND subreaktor.id = $subreaktor";
      $extraTables = ",reaktor_artwork,subreaktor_artwork,subreaktor ";
    }
    if ($sex)
    {
      $extraWhereClause .= "AND sf_guard_user.sex = $sex ";
    }
    $query = "SELECT author_id,username,COUNT(*) as cnt FROM sf_comment,sf_guard_user $extraTables".
             "WHERE sf_comment.author_id = sf_guard_user.id $extraWhereClause $endWhereClause GROUP BY author_id ORDER BY cnt DESC LIMIT $limit";
    
    $graphQueries = array();
    $allRes = array();
    if ($start && $end)
    {
      for ($i = 0 ; $i <= $steps ; $i++)
      {
        $endWhereClause = "AND sf_comment.created_at < '".date("Y-m-d",strtotime($start) + $step * $i)."' " . 
                          "AND sf_comment.created_at > '".date("Y-m-d",strtotime($start) + $step * ($i-1))."' ";
        $graphQueries[] = "SELECT author_id,username,COUNT(*) as cnt FROM sf_comment,sf_guard_user $extraTables".
               "WHERE sf_comment.author_id = sf_guard_user.id $extraWhereClause $endWhereClause GROUP BY author_id ORDER BY cnt DESC";
  
         $allRes['dateData'][]['start']  = strtotime($start)+ $step * ($i-1);
         $allRes['dateData'][count($allRes['dateData'])-1]['end']    = strtotime($start)+ $step * $i;
      }  
    }
    
    return self::reportCreoleQuery($query,$graphQueries,$allRes);
  }
  
  /**
   * Generic function for executing the custom queries needed for the reports
   *
   * @param string $query the mysql query string
   * @return array
   */
  public static function reportCreoleQuery($query,$graphQueries,$allRes = array())
  {
    $c = Propel::getConnection();
    $statement = $c->prepareStatement($query);
    $resultset = $statement->executeQuery();
    $result = array();
    
    while ($resultset->next())
    {
      
      $tmp['username'] = $resultset->getString('username');
      $tmp['occurence'] = $resultset->getInt('cnt');
      $result[] = $tmp;
    }
    $allRes['query'] = $result;
    if (count($graphQueries))
    {
      foreach($graphQueries as $query)
      {
        //print $query."<br />";
        
      $statement = $c->prepareStatement($query);
      $resultset = $statement->executeQuery();
      $counter = 0;
      while ($resultset->next())
      {
       $counter++;
      }
       $allRes['graphData'][] = $counter;
       
      } 
    }
    return $allRes;
    
  }
  
  /**
   * Return the number of users currently logged in
   *
   * @return integer
   */
  public static function getOnlineCount()
  {
    $count_this_sess=0;
    
    if (!function_exists("apc_store")) {
      return self::getOnlineUsers(true);
    }
    if (! ($online = sfProcessCache::get("onlineCount")) ) {
      $online = array();
    } 
    $user = sfContext::getInstance()->getUser();
    if ($user->isAuthenticated()) {
      $user_id = $user->getId();
    } else {
      $user_id = 0;
    }

// Avoid robots counting [they dont accept cookies]
if(isset($_COOKIE["reaktor"])){
    $online[session_id()] = array("time" => $_SERVER["REQUEST_TIME"], "user" => $user_id);
    } else {
// Count user when site is refreshed for the first time and we can't get cookie
    $count_this_sess=1;
    }

    // Remove idling sessions from the cache
    $past = $_SERVER["REQUEST_TIME"] - sfConfig::get('logged_in_time', 1800);
    foreach($online as $id => $info) {
      if ($info["time"] < $past) {
        unset($online[$id]);
      }
    }

    sfProcessCache::set("onlineCount", $online);
    return count($online)+$count_this_sess;
  }
  
  /**
   * Return the users that are currently logged in
   *
   * @param boolean $count Whether to return just a count
   * 
   * @return array
   */
  public static function getOnlineUsers($count = false)
  {
    if (!$onlineUserArray = sfProcessCache::get("onlineCount"))
    {
      return;
    }
    $ids = array();
    foreach ($onlineUserArray as $onlineUser)
    {
      $ids[] = $onlineUser["user"];
    }
    $c = new Criteria();
    $c->add(self::ID, $ids, Criteria::IN);

    if ($count)
    {
      return self::doCount($c);
    }
    else
    {
      return self::doSelect($c);
    }
  }

  /**
   * Returns whether or not $user_id is logged in
   * 
   * @param int $user_id 
   * @return bool
   */
  public static function isUserOnline($user_id)
  {
    if (!function_exists("apc_store") || !($online = sfProcessCache::get("onlineCount"))) {
      $c = new Criteria();
      $c->add(sfGuardUserPeer::ID,$user_id);
      $c->add(sfGuardUserPeer::SHOW_LOGIN_STATUS, 1);
      $c->add(sfGuardUserPeer::LAST_LOGIN,microtime(true)-sfConfig::get('logged_in_time', 1800),Criteria::GREATER_THAN);
      $res = sfGuardUserPeer::doSelect($c);
      return (bool)count($res);
    }

    foreach($online as $id => $info)
    {
      if ($info["user"] == $user_id)
      {
        return true;
      }
    }
    return false;
  }

  /**
   * Returns whether or not $user_id is a member of the group "Staff"
   * 
   * @param int $user_id 
   * @return bool
   */
  public static function isUserStaffMember($user_id)
  {
   	$c = new Criteria();
  	$c->addJoin(sfGuardUserPeer::ID, sfGuardUserGroupPeer::USER_ID);
  	$c->add(sfGuardUserPeer::ID, $user_id);
    $c->add(sfGuardUserGroupPeer::GROUP_ID, 3); // the group staff has id = 3
    $res = sfGuardUserPeer::doSelect($c);
    if (count($res) > 0) 
    {
    	return true;
    } 
    else 
    {
    	return false;
    }
  }
  
  
  public static function getMostActiveSince($time,$actions,$limit=20)
  {
    $c = new Criteria();
    $qry = "SELECT count(*) as cnt, username FROM history,sf_guard_user WHERE history.USER_ID=sf_guard_user.ID AND history.CREATED_AT>'".date('Y-m-d', $time)."' AND history.ACTION_ID IN (";
    foreach ($actions as $key => $action)
    {
      if ($key != 0)
        $qry .= ",";
      $qry .= $action;
    }
    $qry .= ") GROUP BY history.USER_ID order by cnt DESC LIMIT $limit";
    return self::reportCreoleQuery($qry,array());
  }
}
