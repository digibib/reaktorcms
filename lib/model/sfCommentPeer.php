<?php

/**
 * Subclass for performing query and update operations on the 'sf_comment' table.
 *
 * 
 *
 * @package plugins.sfPropelActAsCommentableBehaviorPlugin.lib.model
 */ 
class sfCommentPeer extends BasesfCommentPeer
{

	/**
	 * Get list of comments on a date
	 *
	 * @param string $comment_model
	 * @param string $namespace
	 * @param string $date yyyy-mm-dd or yyyy-mm
	 * @return array $comments
	 */
  public static function getCommentsByDate($comment_model, $namespace, $date = null, $page, $unsuitable= null)
  {
    if(!$date)
    {
      $date = date('Y-m-d');
    }

    $pager = new sfPropelPager('sfComment', sfConfig::get("app_admin_commentlistmax", 3));
    $c     = new Criteria();   

    $c->add(sfCommentPeer::COMMENTABLE_MODEL, $comment_model);

    $date_array = explode('-', $date);
    
    if(count($date_array) == 3)
    {
      $from = $date.' 00:00:00';
      $to   = $date.' 23:59:59';     
    }
    else
    {
      $from = $date.'-01 00:00:00';
      $to   = $date.'-'.date('t', strtotime($date)).' 23:59:59';
    }
    $crit1 = $c->getNewCriterion( sfCommentPeer::CREATED_AT, $from, Criteria::GREATER_EQUAL);
    $crit2 = $c->getNewCriterion( sfCommentPeer::CREATED_AT, $to, Criteria::LESS_EQUAL);
    $crit1->addAnd( $crit2 );
    $c->add( $crit1 );

    if($unsuitable)
    {
      $c->add(sfCommentPeer::UNSUITABLE, $unsuitable);
    }
    
    $c->add(sfCommentPeer::NAMESPACE, $namespace);
    $c->addDescendingOrderByColumn(sfCommentPeer::CREATED_AT);
    $c->addDescendingOrderByColumn(sfCommentPeer::ID);
    
    $pager->setCriteria($c);
    $pager->setPage($page);
    $pager->setPeerMethod('doSelectJoinUserAndArtwork');
    $pager->init();
    
    return $pager;
    
  }
  
  public static function getCommentsByUnsuitableStatus($comment_model, $namespace, $page, $status = 1)
  {
    $pager = new sfPropelPager('sfComment', sfConfig::get("app_admin_commentlistmax", 3));
    $c     = new Criteria();   

    $c->add(sfCommentPeer::COMMENTABLE_MODEL, $comment_model);

    $c->add(sfCommentPeer::UNSUITABLE, $status);
    
    $c->add(sfCommentPeer::NAMESPACE, $namespace);
    $c->addDescendingOrderByColumn(sfCommentPeer::CREATED_AT);
    $c->addDescendingOrderByColumn(sfCommentPeer::ID);
    
    $pager->setCriteria($c);
    $pager->setPage($page);
    $pager->setPeerMethod('doSelectJoinUserAndArtwork');
    $pager->init();
    
    return $pager;
  }
  
  public static function getUnsuitableComments($comment_model, $namespace, $page)
  {
    return self::getCommentsByUnsuitableStatus($comment_model, $namespace, $page, 2);
  }

  public static function getReportedComments($comment_model, $namespace, $page)
  {
    return self::getCommentsByUnsuitableStatus($comment_model, $namespace, $page, 1);
  }
  
  public static function getNumberofCommentsByUnsuitableStatus($status = 1)
  {
  	$c = new Criteria();
  	$c->add(sfCommentPeer::UNSUITABLE, $status);
    $c->addJoin(sfCommentPeer::AUTHOR_ID, sfGuardUserPeer::ID);
  	return sfCommentPeer::doCount($c);
  }
  
/**
   * Get comments that a user has made
   *
   * @param sfGuardUser|integer $user the user object or id
   * @param string         $comment_model the model used by the comment engine
   * @param string         $namespace     the namespace used by the comment engine
   */
  public static function getCommentsByUser($user, $comment_model, $namespace, $page)
  {
    if ($user instanceof sfGuardUser)
    {
      $userId = $user->getId();
    }
    else
    {
      $userId = intval($user);
    }
    
    $pager = new sfPropelPager('sfComment', sfConfig::get("app_admin_commentlistmax", 3));
    $c = new Criteria();
     
    $c->add(sfCommentPeer::COMMENTABLE_MODEL, $comment_model);
    $c->add(sfCommentPeer::NAMESPACE, $namespace);
    $c->add(sfCommentPeer::AUTHOR_ID, $userId);
    $c->addDescendingOrderByColumn(sfCommentPeer::CREATED_AT);
    
    $pager->setCriteria($c);
    $pager->setPage($page);
    $pager->setPeerMethod('doSelectJoinUserAndArtwork');
    $pager->init();
    
    return $pager;
    
  }
  
  /**
   * Count comments per date between $from and $to, and return in array.
   *
   * @param string $comment_model
   * @param string $namespace
   * @param string $type
   * @param string $from
   * @param string $to
   * 
   * @return array $comments Comment counts per date between $from and $to
   */
  public static function getCommentCountInTimePeriod($comment_model, $namespace, $type, $from, $to)
  {
   
    $c = new Criteria();
    $c->addSelectColumn('date('.sfCommentPeer::CREATED_AT.')');

    $c->addSelectColumn(sfCommentPeer::COUNT);
    $c->add(sfCommentPeer::COMMENTABLE_MODEL, $comment_model);
    $c->add(sfCommentPeer::NAMESPACE, $namespace);
    
    $crit1 = $c->getNewCriterion( sfCommentPeer::CREATED_AT,$from.' 00:00:00', Criteria::GREATER_EQUAL);
    $crit2 = $c->getNewCriterion( sfCommentPeer::CREATED_AT, $to.' 23:59:59', Criteria::LESS_EQUAL);
    $crit1->addAnd( $crit2 );
    $c->add( $crit1 );
    
    $c->addGroupByColumn('date(sf_comment.CREATED_AT)');
    
    $rs = self::doSelectRS($c);
     
    $comments= array();
    while ($rs->next()) {
    	$comments[$rs->getString(1)] = $rs->getString(2);
    }
    
    return $comments;  
  }
  
  /**
   * Returns the list of the comments attached to the object. The options array
   * can contain several options :
   * - order : order of the comments
   * 
   * @param      BaseObject  $object
   * @param      Array       $options
   * @param      Criteria    $criteria
   * 
   * @return     Array
   */
  public static function getComments(BaseObject $object, $options = array(), Criteria $criteria = null)
  {
    $c = sfCommentPeer::getCommentsCriteria($object, $options, $criteria);
    $comment_objects = sfCommentPeer::doSelectJoinSfGuardUser($c);
    
    $comments = array();
    
    foreach ($comment_objects as $comment_object)
    {
      $comment = $comment_object->toArray();
      $comment_user = $comment_object->getSfGuardUser();
      $comment['AuthorName'] = $comment_user->getUsername();
      $comment['AuthorVisible'] = $comment_user->getShowContent();
      $comments[] = $comment;
    }
    return $comments;
  }

  /**
   * Query to hydrate and join the User object and artwork object to the
   * comment results so you don't have to use extra queries when looking up
   * related data
   *
   * @return array full of sfComment objects
   */
  public static function doSelectJoinUserAndArtwork(Criteria $c, $con = null)
  {
    $c = clone $c;

    // Set the correct dbName if it has not been overridden
    if ($c->getDbName() == Propel::getDefaultDB()) {
        $c->setDbName(self::DATABASE_NAME);
    }

    // Add select columns for sfComment
    sfCommentPeer::addSelectColumns($c);
    $startcol2 = (sfCommentPeer::NUM_COLUMNS - sfCommentPeer::NUM_LAZY_LOAD_COLUMNS) + 1;

    // Add select columns for Artwork
    ReaktorArtworkPeer::addSelectColumns($c);
    $startcol3 = $startcol2 + ReaktorArtworkPeer::NUM_COLUMNS ;

    // Add select columns for sfGuardUser
    sfGuardUserPeer::addSelectColumns($c);

    // [NOTE 1]
    $c->addJoin(sfCommentPeer::COMMENTABLE_ID, ReaktorArtworkPeer::ID);
    $c->addJoin(sfCommentPeer::AUTHOR_ID, sfGuardUserPeer::ID);

    $rs = BasePeer::doSelect($c, $con);
    $results = array();

    while($rs->next())
    {
      // Hydrate the sfComment object
      $omClass = sfCommentPeer::getOMClass();

      $cls = Propel::import($omClass);
      $obj1 = new $cls();
      $obj1->hydrate($rs);

      // Hydrate the Artwork object
      $omClass = ReaktorArtworkPeer::getOMClass();

      $cls = Propel::import($omClass);
      $obj2 = new $cls();
      $obj2->hydrate($rs, $startcol2);

      // Hydrate the sfGuardUser object
      $omClass = sfGuardUserPeer::getOMClass();

      $cls = Propel::import($omClass);
      $obj3 = new $cls();
      $obj3->hydrate($rs, $startcol3);

      // [NOTE 2]
      $obj1->setArtwork($obj2);
      $obj1->setUser($obj3); 
      $results[] = $obj1;
    }
		
    return $results;
  }
  
  /**
   * Returns a criteria for comments selection. The options array
   * can contain several options :
   * - order : order of the comments
   * 
   * @param      BaseObject  $object
   * @param      Array       $options
   * @param      Criteria    $criteria
   * 
   * @return     Array
   */
  protected static function getCommentsCriteria(BaseObject $object, $options = array(), Criteria $criteria = null)
  {
    if ($criteria != null)
    {
      $c = clone $criteria;
    }
    else
    {
      $c = new Criteria();
    }

    $c->add(sfCommentPeer::COMMENTABLE_ID, $object->getPrimaryKey());
    $c->add(sfCommentPeer::COMMENTABLE_MODEL, get_class($object));

    if (isset($options['namespace']))
    {
      $c->add(sfCommentPeer::NAMESPACE, $options['namespace']);
    }
    else
    {
      $c->add(sfCommentPeer::NAMESPACE, '');
    }

    if (isset($options['order']) && ($options['order'] == 'desc'))
    {
      $c->addDescendingOrderByColumn(sfCommentPeer::CREATED_AT);
      $c->addDescendingOrderByColumn(sfCommentPeer::ID);
    }
    else
    {
      $c->addAscendingOrderByColumn(sfCommentPeer::CREATED_AT);
      $c->addAscendingOrderByColumn(sfCommentPeer::ID);
    }

    return $c;
  }
  
}
