<?php

/**
 * Subclass for performing query and update operations on the 'recommended_artwork' table.
 *
 * 
 *
 * @package lib.model
 */ 
class RecommendedArtworkPeer extends BaseRecommendedArtworkPeer
{
  
  /**
   * Get all related artworks. 
   * 
   */
  public static function doSelectAllRecommendedArtwork(Criteria $c, $con = null)
  {
    $c = clone $c;
    
    //Get the latest recommended artwork ids from each subreaktor and localreaktor
    $c2 = new Criteria(); 
    $c2->addAlias('ra2', parent::TABLE_NAME);
    
    //Muliple conditions when joining must be hacked in propel...
    $c2->addJoin(parent::SUBREAKTOR, parent::alias('ra2', parent::SUBREAKTOR).
                                    ' AND '.parent::UPDATED_AT.' < '.parent::alias('ra2', parent::UPDATED_AT).
                                    ' AND ('.parent::LOCALSUBREAKTOR.' = '.parent::alias('ra2', parent::LOCALSUBREAKTOR).
                                      ' OR ('.parent::LOCALSUBREAKTOR .' is null AND '.
                                              parent::alias('ra2', parent::LOCALSUBREAKTOR). ' is NULL ))', Criteria::LEFT_JOIN);                                                  
       
    $c2->add(parent::alias('ra2', parent::UPDATED_AT), null , Criteria::EQUAL);
        
    $recommended_artworks = parent::doSelect($c2);
    $recommended_ids = array();
    $results = array();
    //We need the id's 
    foreach ($recommended_artworks as $ra)
    {
      $recommended_ids[] =  $ra->getId();
    }
    
    if ($c->getDbName() == Propel::getDefaultDB()) 
    {
      $c->setDbName(self::DATABASE_NAME);
    }

    /* We need to manually join all the tables, and later hydrate them to get the object, 
     * because two of the columns (subreaktor, localreaktor) have the same table as foreign key.
     * The next steps are done to calculate the hydration. 
     *  
     * Add all (normal) columns of each table to the query and calculate positions in the result set.
     * Since all colums are numered in the result set, we have to calculate the offset for each table.
     * Assuming Table1 has 2 columns, Table2 5 and Table3 4, the first Table1 column is at result_column 0,
     * the first Table2 column is located 2 columns later and the first Table3 column is located
     * at offset 2+5=7.
     */
    
    // First: Table Trade. Offset is not calculated because it is always 0. There is also no need for a 
    //join since we start with this table.
    
    if (!empty($recommended_ids))
    {
	    parent::addSelectColumns($c);    
	    $c->add(parent::ID, $recommended_ids, Criteria::IN);
	    $c->add(ReaktorArtworkPeer::STATUS, 3, Criteria::EQUAL);
	    $c->add(sfGuardUserPeer::SHOW_CONTENT, true, Criteria::EQUAL);
	    
	    //Seond table - artworks
	    ReaktorArtworkPeer::addSelectColumns($c);
	    $startcol_reaktorartwork = (parent::NUM_COLUMNS - parent::NUM_LAZY_LOAD_COLUMNS) + 1;    
	    $c->addJoin(parent::ARTWORK, ReaktorArtworkPeer::ID, Criteria::LEFT_JOIN);
	
	    //Third table - subreaktor
	    SubreaktorPeer::addSelectColumns($c);
	    $startcol_subreaktor = $startcol_reaktorartwork + ReaktorArtworkPeer::NUM_COLUMNS;
	    $c->addJoin(parent::SUBREAKTOR, SubreaktorPeer::ID, Criteria::LEFT_JOIN);
	    
	    //Fourth table localsubreaktor (second join with subreaktor)
	    $c->addAlias('local_subreaktor', SubreaktorPeer::TABLE_NAME);
	    SubreaktorPeer::addAliasSelectColumns('local_subreaktor',$c);
	    $startcol_local_subreaktor = $startcol_subreaktor + SubreaktorPeer::NUM_COLUMNS;
	    $c->addJoin(parent::LOCALSUBREAKTOR, SubreaktorPeer::alias('local_subreaktor', SubreaktorPeer::ID), Criteria::LEFT_JOIN);
	  
	    //Fifth table - user
	    sfGuardUserPeer::addSelectColumns($c);
	    $startcol_user = $startcol_local_subreaktor + SubreaktorPeer::alias('local_subreaktor', SubreaktorPeer::NUM_COLUMNS);
	    $c->addJoin(parent::UPDATED_BY, sfGuardUserPeer::ID, Criteria::LEFT_JOIN);
	    if (!sfContext::getInstance()->getUser()->hasCredential('viewallcontent'))
	    {
	      $c->add(sfGuardUserPeer::SHOW_CONTENT, true);
	    }
	    
	    $rs = BasePeer::doSelect($c, $con);
	    
	    while($rs->next())
	    {
	      // Hydrate the sfComment object
	      $omClass = RecommendedArtworkPeer::getOMClass();
	
	      $cls = Propel::import($omClass);
	      $obj1 = new $cls();
	      $obj1->hydrate($rs);
	
	      // Hydrate the Artwork object
	      $omClass = ReaktorArtworkPeer::getOMClass();
	
	      $cls = Propel::import($omClass);
	      $obj2 = new $cls();
	      $obj2->hydrate($rs, $startcol_reaktorartwork);
	
	      // Hydrate the subreaktor object
	      $omClass = SubreaktorPeer::getOMClass();
	
	      $cls = Propel::import($omClass);
	      $obj3 = new $cls();
	      $obj3->hydrate($rs, $startcol_subreaktor);
	      
	      // Hydrate the localsubreaktor object
	      $omClass = SubreaktorPeer::getOMClass();
	
	      $cls = Propel::import($omClass);
	      $obj4 = new $cls();
	      $obj4->hydrate($rs, $startcol_local_subreaktor);
	      
	      // Hydrate the sfGuardUser object
	      $omClass = sfGuardUserPeer::getOMClass();
	
	      $cls = Propel::import($omClass);
	      $obj5 = new $cls();
	      $obj5->hydrate($rs, $startcol_user);
	
	      //Update main object with external objects 
	      $obj1->setArtwork($obj2);
	      $obj1->setSubreaktor($obj3);
	      $obj1->setLocalsubreaktor($obj4);
	      $obj1->setUpdatedBy($obj5); 
	      $results[] = $obj1;
	    }
    }
    
    return $results;
   
  }

  /**
   * Get the recommended artwork in a specific subreaktor
   *
   * @param integer $subreaktor
   */
  public static function getRecommendedArtwork($subreaktor = null, $lokalreaktor = null, $show_content_flag = true, $limit = 0)
  {
    $c = new Criteria();
    $c->addDescendingOrderByColumn(parent::UPDATED_AT);
    $c->add(ReaktorArtworkPeer::STATUS, 3, Criteria::EQUAL);
    $c->addJoin(RecommendedArtworkPeer::ARTWORK, ReaktorArtworkPeer::ID, Criteria::LEFT_JOIN);
    $c->addJoin(ReaktorArtworkPeer::USER_ID, sfGuardUserPeer::ID, Criteria::LEFT_JOIN);

    // Only show valid content - unless I have the permission to view blocked 
    // and explicitly ask for it
    // ZOID: This logic should not really be here
    if (!(sfContext::getInstance()->getUser()->hasCredential('viewallcontent') && !$show_content_flag))
    {
      $c->add(sfGuardUserPeer::SHOW_CONTENT, true);
    }
    
    /*  
     * An artwork belonging to a subreaktor(ex. photo) and a lokalreaktor (ex. Groruddalen) can be recommended in each of them, but also
     * in a combination of them. The following list describes the combinations and how they are stored in the recommended artwork table:
     * Recommended in photo - subreaktor is set to photo
     * Recommended in groruddalen - subreaktor is set to groruddalen
     * Recommended in groruddalen:photo - subreaktor is set to groruddalen and localsubreaktor to photo
     */
    //Check if lokalreaktor is set
    $lokalreaktor_id = $lokalreaktor instanceof Subreaktor ? $lokalreaktor->getId() : null;
    $lokalreaktor_id = (!$lokalreaktor_id && Subreaktor::getProvidedLokalreaktor() instanceof Subreaktor) ?
                     Subreaktor::getProvidedLokalreaktor()->getId() : null;
                     
    if ($lokalreaktor_id && $lokalreaktor != 'ignore')// Lokalreaktor is set
    {
      $c->add(parent::SUBREAKTOR, $lokalreaktor_id);     
      
      //Look for subreaktor, and add as local subreaktor. A user shouldn't be able to recommended an artwork in a lokalreaktor 
      //alone so a subreaktor should always be found here
      if ($subreaktor instanceof Subreaktor)
      {
        $c->add(parent::LOCALSUBREAKTOR, $subreaktor->getId());
      }
      elseif (Subreaktor::getProvidedSubreaktor() instanceof Subreaktor)
      {
        $c->add(parent::LOCALSUBREAKTOR, Subreaktor::getProvidedSubreaktor()->getId());        
      }       
    }
    elseif($subreaktor != 'ignore') //Lokalreaktor isn't set, which means we're trying to get the recommendation for a subreaktor
    {    
      if ($subreaktor instanceof Subreaktor)
      {
        $c->add(parent::SUBREAKTOR, $subreaktor->getId());
      }
      elseif (Subreaktor::getProvidedSubreaktor() instanceof Subreaktor)
      {
        $c->add(parent::SUBREAKTOR, Subreaktor::getProvidedSubreaktor()->getId());
      }
    }

    if ($limit) 
    {
      $c->setLimit($limit);
      $hash = spl_object_hash($c) . 'sub' .Subreaktor::getProvidedSubreaktorReference() . 'lok' .Subreaktor::getProvidedLokalReference();
      $cache = reaktorCache::singleton($hash);
      $retval = $cache->get();
      
      if (!$retval || is_null(current($retval)))
      {
        $retval = self::doSelectJoinReaktorArtwork($c);
        $cache->set($retval);
      }
      return $retval;
    }
    else
    {
      $c->setLimit(1);

      $hash = spl_object_hash($c) . 'sub' .Subreaktor::getProvidedSubreaktorReference() . 'lok' .Subreaktor::getProvidedLokalReference();
      $cache = reaktorCache::singleton($hash);
      $retval = $cache->get();
      
      if (!$retval || is_null(current($retval)))
      {
        $retval = current(self::doSelectJoinReaktorArtwork($c));
        $cache->set($retval);
      }
      return $retval;
    }
  }

  /**
   * Get an artworks recommendations
   *
   * @param integer $id
   * @return array RecommendedArtwork
   */
  public static function getArtworkRecommendations($id)
  {

    $c = new Criteria();

    $c->add(parent::ARTWORK, $id);

    return RecommendedArtworkPeer::doSelectAllRecommendedArtwork($c);

  }
  
  /**
   * Get a subreaktor's recommendation 
   * (should only be one per subreaktor, and lokalreaktor/subreaktor combination )
   * And it has to be approved
   *
   * @param int $subreaktor
   * @param int $localsubreaktor
   * @return array RecommendedArtwork 
   */
  public static function getSubreaktorRecommendation($subreaktor, $localsubreaktor = null)
  {
    $c = new Criteria();
    
    $c->add(ReaktorArtworkPeer::STATUS, 3, Criteria::EQUAL);
    $c->add(sfGuardUserPeer::SHOW_CONTENT, true, Criteria::EQUAL);
    $c->add(parent::SUBREAKTOR, $subreaktor);
    if($localsubreaktor)
    {
      $c->add(parent::LOCALSUBREAKTOR, $localsubreaktor); 
    }
    return parent::doSelectJoinAll($c);
    
  }
  
  /**
   * Add/update an artwork recommendation
   *
   * @param int $id
   * @param int $subreaktor
   * @param int $localsubreaktor
   */
  public static function addRecommendation($user, $artwork, $subreaktor, $localsubreaktor = null)
  {
    //Create the new recommendation
    $recommendation = new RecommendedArtwork(); 

    $recommendation->setUpdatedBy($user);
    $recommendation->setArtwork($artwork);
    $recommendation->setSubreaktor($subreaktor);
    $recommendation->setLocalsubreaktor($localsubreaktor);
    $recommendation->save();    
    
  }
  
}
