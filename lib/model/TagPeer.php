<?php
/*
 * This file is part of the sfPropelActAsTaggableBehavior package.
 * 
 * (c) 2007 Xavier Lacot <xavier@lacot.org>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * Subclass for performing query and update operations on the 'tag' table.
 * 
 * @package plugins.sfPropelActAsTaggableBehaviorPlugin.lib.model
 */ 
class TagPeer extends BaseTagPeer
{ 
  /**
   * Returns all tags, eventually with a limit option.
   * The first optional parameter permits to add some restrictions on the 
   * objects the selected tags are related to.
   * The second optionnal parameter permits to restrict the tag selection with
   * different criterias
   * 
   * @param      Criteria    $c
   * @param      array       $options
   * @return     array
   */
  public static function getAll(Criteria $c = null, $options = array())
  {
    if ($c == null)
    {
      $c = new Criteria();
    }

    if (isset($options['limit']))
    {
      $c->setLimit($options['limit']);
    }

    if (isset($options['like']))
    {
      $c->add(TagPeer::NAME, $options['like'], Criteria::LIKE);
    }

    self::addReaktorsToCriteria($c);
    
    return TagPeer::doSelect($c);
  }
  
  /**
   * Returns weighted popular tags with number of hits
   *
   * @return array
   */
  public static function getPopularTagsWithCount($limit = 50, $maxchars = 2000)
  {
    $c = new Criteria();
    $c->setLimit($limit);
    $popular_tags = array();
    
    $popular_tags_with_widths = TagPeer::getAllWithCount($c, array("return_widths" => true));

    /**
     * Since we added widths to this, it breaks the normalisation function, so we need to strip them out first
     */ 
    foreach ($popular_tags_with_widths as $tagName => $valuesArray)
    {
      $popular_tags[$tagName] = $valuesArray["count"];
    }
    
    $normalized_popular_tags = sfPropelActAsTaggableToolkit::normalize($popular_tags);
    
    $poptags   = array();
    $charCount = 0; 
    
    foreach ($normalized_popular_tags as $poptag => $value)
    {
      $charCount += $popular_tags_with_widths[$poptag]["width"];
      if ($charCount > $maxchars)
      {
        break;
      }

      $displayName = $poptag;

      $poptags[$poptag] = array('emphasisValue' => $value, 'count' => $popular_tags[$poptag], 'displayName' => $displayName);
    }
    
    return $poptags;
  }
  
  /**
   * Returns all tags, sorted by name, with their number of occurencies.
   * The first optionnal parameter permits to add some restrictions on the 
   * objects the selected tags are related to.
   * The second optionnal parameter permits to restrict the tag selection with
   * different criterias
   * 
   * @param      Criteria    $c
   * @param      array       $options
   * @return     array
   */
  public static function getAllWithCount(Criteria $c = null, $options = array())
  {
    $tags = array();

    foreach(array('ReaktorArtwork', 'ReaktorFile', 'Article') as $taggable_obj)
    {
	    $c = new Criteria();
	
	    $c->addJoin(TagPeer::ID, TaggingPeer::TAG_ID);
	    $c->add(TagPeer::APPROVED, 1);
	    $c->add(TaggingPeer::PARENT_APPROVED, 1);

	    $c->add(TaggingPeer::TAGGABLE_MODEL, $taggable_obj);
	    
	    if (isset($options['like']))
	    {
	      $c->add(TagPeer::NAME, $options['like'], Criteria::LIKE);
	    }
	    self::addReaktorsToCriteria($c, $taggable_obj, $options);
    
	    $c->addSelectColumn(TagPeer::NAME);
	    $c->addSelectColumn(TagPeer::WIDTH);
	    $c->addSelectColumn(TaggingPeer::COUNT);
			
	    $c->addGroupByColumn(TaggingPeer::TAG_ID);
	    $c->addDescendingOrderByColumn(TaggingPeer::COUNT);
	    $c->addAscendingOrderByColumn(TagPeer::NAME);
	
	    $c->addJoin(TaggingPeer::PARENT_USER_ID, sfGuardUserPeer::ID, Criteria::JOIN);
	    if (!sfContext::getInstance()->getUser()->hasCredential('viewallcontent'))
	    {
	      $c->add(sfGuardUserPeer::SHOW_CONTENT, true);
	    }
	    
	    $rs = TagPeer::doSelectRS($c);
	 
	    while ($rs->next())
	    {
	      if (isset($options["return_widths"]))
	      {
	        //$tags[$rs->getString(1)]["count"]        += $rs->getInt(3);
	        (isset($tags[$rs->getString(1)]["count"])) ? $tags[$rs->getString(1)]["count"] += $rs->getInt(3) : $tags[$rs->getString(1)]["count"] = $rs->getInt(3);
	        $tags[$rs->getString(1)]["width"]        = $rs->getInt(2);
				}
	      else
	      {
	        (isset($tags[$rs->getString(1)])) ? $tags[$rs->getString(1)] += $rs->getInt(3) : $tags[$rs->getString(1)] = $rs->getInt(3);
	      }
	    }
    }
    
    arsort($tags);
    if (count($tags) > 30)
    {
    	$tags = array_slice($tags, 0, 30);
    }
    
    $ret_tags = array();
    
    while (count($ret_tags) <= 30 && count($tags) > 0)
    {
    	$rand_key = array_rand($tags);
    	$ret_tags[$rand_key] = $tags[$rand_key];
    	unset($tags[$rand_key]);
    }
    
    return $ret_tags;
  }

  /**
   * Returns the names of the models that have instances tagged with one or 
   * several tags. The optionnal parameter might be a string, an array, or a 
   * comma separated string
   * 
   * @param      mixed       $tags
   * @return     array
   */
  public static function getModelsTaggedWith($tags = array())
  {
    if (is_string($tags))
    {
      if (false !== strpos($tags, ','))
      {
        $tags = explode(',', $tags);
      }
      else
      {
        $tags = array($tags);
      }
    }

    $c = new Criteria();
    $c->addJoin(TagPeer::ID, TaggingPeer::TAG_ID);
    $crit0 = $c->add(TagPeer::NAME, $tags, Criteria::IN);
  
    $crit0->addOr($crit0);
    $c->add($crit0);
   
    $c->addGroupByColumn(TaggingPeer::TAGGABLE_ID);
    $having = $c->getNewCriterion(TagPeer::COUNT, count($tags), Criteria::GREATER_EQUAL);
    $c->addHaving($having);
    $c->clearSelectColumns();
    $c->addSelectColumn(TaggingPeer::TAGGABLE_MODEL);
    $c->addSelectColumn(TaggingPeer::TAGGABLE_ID);

    $sql = BasePeer::createSelectSql($c, array());
    $con = Propel::getConnection();
    $stmt = $con->prepareStatement($sql);
    $position = 1;

    foreach ($tags as $tag)
    {
      $stmt->setString($position, $tag);
      $position++;
    }

    $stmt->setString($position, count($tags));
    $rs = $stmt->executeQuery(ResultSet::FETCHMODE_NUM);
    $models = array();

    while ($rs->next())
    {
      $models[] = $rs->getString(1);
    }

    return $models;
  }

  /**
   * Returns the most popular tags with their associated weight. See 
   * sfPropelActAsTaggableToolkit::normalize for more details.
   * 
   * The first optionnal parameter permits to add some restrictions on the 
   * objects the selected tags are related to.
   * The second optionnal parameter permits to restrict the tag selection with
   * different criterias
   * 
   * @param      Criteria    $c
   * @param      array       $options
   * @return     array
   */
  public static function getPopulars($c = null, $options = array())
  {
    if ($c == null)
    {
      $c = new Criteria();
    }

    if (!$c->getLimit())
    {
      $c->setLimit(sfConfig::get('app_home_max_tags', 100));
    }

    $all_tags = TagPeer::getAllWithCount($c, $options);
    return sfPropelActAsTaggableToolkit::normalize($all_tags);
  }

  /**
   * Returns the tags that are related to one or more other tags, with their 
   * associated weight (see sfPropelActAsTaggableToolkit::normalize for more 
   * details).
   * The "related tags" of one tag are the ones which have at least one 
   * taggable object in common.
   * 
   * The first optionnal parameter permits to add some restrictions on the 
   * objects the selected tags are related to.
   * The second optionnal parameter permits to restrict the tag selection with
   * different criterias
   * 
   * @param      mixed       $tags
   * @param      array       $options
   * @return     array
   */
  public static function getRelatedTags($tags = array(), $options = array())
  {
  	$tags = sfPropelActAsTaggableToolkit::explodeTagString($tags);

    if (is_string($tags))
    {
      $tags = array($tags);
    }

    $tagging_options = $options;

    if (isset($tagging_options['limit']))
    {
      unset($tagging_options['limit']);
    }

    $taggings = self::getTaggings($tags, $tagging_options);
    $result = array();

    foreach ($taggings as $key => $tagging)
    {
      $c = new Criteria();
      $c->add(TagPeer::NAME, $tags, Criteria::NOT_IN);
      $c->add(TagPeer::APPROVED, 1);
      $c->add(TaggingPeer::TAGGABLE_ID, $tagging, Criteria::IN);
      $c->add(TaggingPeer::TAGGABLE_MODEL, $key);
      $c->addJoin(TaggingPeer::TAG_ID, TagPeer::ID);
      
      if (isset($options['parent_approved']))
      {
      	$c->add(TaggingPeer::PARENT_APPROVED, $options['parent_approved']);
      }

      self::addReaktorsToCriteria($c, $key);
      
      $tags = TagPeer::doSelect($c);

      foreach ($tags as $tag)
      {
        if (!isset($result[$tag->getName()]))
        {
          $result[$tag->getName()] = 0;
        }

        $result[$tag->getName()]++;
      }
    }

    if (isset($options['limit']))
    {
      arsort($result);
      $result = array_slice($result, 0, $options['limit'], true);
    }

    ksort($result);
    return sfPropelActAsTaggableToolkit::normalize($result);
  }

  /**
   * Retrieves the objects tagged with one or several tags.
   * 
   * The second optionnal parameter permits to restrict the tag selection with
   * different criterias
   * 
   * @param      mixed       $tags
   * @param      array       $options
   * @return     array
   */
  public static function getTaggedWith($tags = array(), $options = array())
  {
  	$taggings = self::getTaggings($tags, $options);
    $result = array();

    foreach ($taggings as $key => $tagging)
    {
      $c = new Criteria();
      $peer = get_class(call_user_func(array(new $key, 'getPeer')));
      $objects = call_user_func(array($peer, 'retrieveByPKs'), $tagging);

      foreach ($objects as $object)
      { 
        if ($object instanceof ReaktorArtwork )
        {
          $tmp_artwork = new genericArtwork($object);
          if ($tmp_artwork->isViewable())
          {
          	$result[] = $tmp_artwork;
          }
        }
        elseif ($object instanceof ReaktorFile )
        {
          $result[] = new artworkFile($object);
        }
        elseif ($object instanceof Article )
        {
          $result[] = $object;
        }
        else
        {
          throw new Exception("Unhandled object type: ".get_class($object));
        }
      }
    }

    return $result;
  }
  
  public static function getObjectsTaggedWith($tags = array(), $options = array(), $artworks_only = false)
  {
  	$taggings    = self::getTaggings($tags, $options);
  	$result      = array();
  	$artworks    = false;
    $artwork_ids = array();
    $ids         = array();

    foreach ($taggings as $key => $tagging)
    {
      if ($key == "ReaktorFile" || $key == "ReaktorArtwork")
      {
	      if ($key == "ReaktorFile")
	      {
	        $objects = genericArtwork::getResultsetFromIDs($tagging, array('isfileid' => true));
	      }
	      else
	      {
	      	$objects = genericArtwork::getResultsetFromIDs($tagging);
	      }
      	foreach ($objects as $object)
	    	{
          try
          {
            $artwork = new genericArtwork($object);
            if ($artwork->isViewable())
            {
              $artwork_ids[$artwork->getId()] = $artwork->getId();
              $result[$artwork->getId()] = $artwork;
            }
          }
          catch (Exception $e) { } // ignore artwork if exception thrown
	    	}
      }
      elseif(!$artworks_only)
      {
        try
    	  {
  	      // We can try to get the object anyway - this works for articles, and should work for future things
	  	     foreach ($tagging as $id) 
	  	     {
	      	      $object = call_user_func($key . 'Peer::retrieveByPk', $id); 
	              $result[$object->getId()] = $object;
	  	     }
    	 }
    	  catch (exception $e) { print_r($e);} // We can't process this tag for whatever reason, so we wont
      }
    }

  	if (isset($options['return_ids']))
  	{
  		return $artwork_ids;
  	}
  	else
  	{
  		return $result;
  	}
  }

  public static function addReaktorsToCriteria(&$c, $model = null, $options = array())
  {
      $taggable_obj = $model;
      $subr_value = null;
      $lokr_value = null;
      
  	  if (Subreaktor::getProvidedSubreaktor() instanceof Subreaktor || 
          Subreaktor::getProvidedLokalreaktor() instanceof Subreaktor ||
          isset($options['subreaktor']) ||
          isset($options['lokalreaktor']))
      {
        if ($taggable_obj == 'ReaktorFile')
        {
          $c->addJoin(TaggingPeer::TAGGABLE_ID, ReaktorArtworkFilePeer::FILE_ID, Criteria::LEFT_JOIN);
        }
      }

      if (isset($options['subreaktor']))
      {
        $subr_value = $options['subreaktor']->getId();
      }
      elseif (Subreaktor::getProvidedSubreaktor() instanceof Subreaktor)
      {
        $subr_value = Subreaktor::getProvidedSubreaktor()->getId();
      }
      if ($subr_value !== null)
      {
        switch ($taggable_obj)
        {
          case 'ReaktorArtwork':
            $c->addJoin(TaggingPeer::TAGGABLE_ID, SubreaktorArtworkPeer::ARTWORK_ID, Criteria::LEFT_JOIN);
            $c->add(SubreaktorArtworkPeer::SUBREAKTOR_ID, $subr_value);
            break;
          case 'ReaktorFile':
            $c->addJoin(ReaktorArtworkFilePeer::ARTWORK_ID, SubreaktorArtworkPeer::ARTWORK_ID, Criteria::LEFT_JOIN);
            $c->add(SubreaktorArtworkPeer::SUBREAKTOR_ID, $subr_value);
            break;
          case 'Article':
            $c->addJoin(TaggingPeer::TAGGABLE_ID, ArticleSubreaktorPeer::ARTICLE_ID, Criteria::LEFT_JOIN);
            $c->add(ArticleSubreaktorPeer::SUBREAKTOR_ID, $subr_value);
            break;
        }
      }
      
      if (isset($options['lokalreaktor']))
      {
        $lokr_value = $options['lokalreaktor']->getId();
        $lokr_residences = $options['lokalreaktor']->getResidences();
      }
      elseif (Subreaktor::getProvidedLokalreaktor() instanceof Subreaktor)
      {
        $lokr_value = Subreaktor::getProvidedLokalreaktor()->getId();
        $lokr_residences = Subreaktor::getProvidedLokalreaktor()->getResidences();
      }
      if ($lokr_value !== null)
      {
        switch ($taggable_obj)
        {
          case 'ReaktorArtwork':
            $c->addJoin(TaggingPeer::TAGGABLE_ID, LokalreaktorArtworkPeer::ARTWORK_ID, Criteria::LEFT_JOIN);
            $c->addJoin(LokalreaktorArtworkPeer::SUBREAKTOR_ID, LokalreaktorResidencePeer::SUBREAKTOR_ID, Criteria::LEFT_JOIN);
            $ctn = $c->getNewCriterion(LokalreaktorArtworkPeer::SUBREAKTOR_ID, $lokr_value);
//        Ticket 25014 - Limited search result
//            $ctn2 = $c->getNewCriterion(sfGuardUserPeer::RESIDENCE_ID, $lokr_residences, Criteria::IN);
//            $ctn->addOr($ctn2);
            $c->add($ctn);
            break;
          case 'ReaktorFile':
            $c->addJoin(ReaktorArtworkFilePeer::ARTWORK_ID, LokalreaktorArtworkPeer::ARTWORK_ID, Criteria::LEFT_JOIN);
            $c->addJoin(LokalreaktorArtworkPeer::SUBREAKTOR_ID, LokalreaktorResidencePeer::SUBREAKTOR_ID, Criteria::LEFT_JOIN);
            $ctn = $c->getNewCriterion(LokalreaktorArtworkPeer::SUBREAKTOR_ID, $lokr_value);
//        Ticket 25014 - Limited search result
//            $ctn2 = $c->getNewCriterion(sfGuardUserPeer::RESIDENCE_ID, $lokr_residences, Criteria::IN);
//            $ctn->addOr($ctn2);
            $c->add($ctn);
            break;
        }
      }
  	return $c;
  }
  
  /**
   * Returns the taggings associated to one tag or a set of tags.
   * 
   * The second optionnal parameter permits to restrict the results with
   * different criterias
   * 
   * @param      mixed       $tags
   * @param      array       $options
   * @return     array
   */
  private static function getTaggings($tags = array(), $options = array())
  {
    $tags = sfPropelActAsTaggableToolkit::explodeTagString($tags);
    
    $vals = array();
    if (is_string($tags))
    {
      $tags = array($tags);
    }
     
    $taggings = array();
  
    foreach(array('ReaktorArtwork', 'ReaktorFile', 'Article') as $taggable_obj)
    {
    	
	    $c = new Criteria();
	    $c->addJoin(TagPeer::ID, TaggingPeer::TAG_ID);
	    $c->add(TagPeer::NAME, $tags, Criteria::IN);
	    
	    /**
	     * loop through the different options
	     */
      if (isset($options['parent_approved']) && $taggable_obj !== 'Article' )
      {
        // Users should see their own unapproved artworks too
        if ($user = sfContext::getInstance()->getUser())
        {
          $approved = $c->getNewCriterion(TaggingPeer::PARENT_APPROVED, $options['parent_approved']);
          $mytags = $c->getNewCriterion(TaggingPeer::PARENT_USER_ID, $user->getId());
          $approved->addOr($mytags);
          $c->add($approved);
        }
        else
        {
          $c->add(TaggingPeer::PARENT_APPROVED, $options['parent_approved']);
        }
      }
	    
      $c->add(TaggingPeer::TAGGABLE_MODEL, $taggable_obj);
      
	    if (isset($options["approved"]))
	    {
	      $c->add(TagPeer::APPROVED, 1);
	    }
	    
	    self::addReaktorsToCriteria($c, $taggable_obj, $options);
	    $c->add(TaggingPeer::TAGGABLE_MODEL, $taggable_obj);
	    $c->addGroupByColumn(TaggingPeer::TAGGABLE_ID);
	    $having = $c->getNewCriterion(TagPeer::ID, ' COUNT(tag.ID) >= ' . 1, Criteria::CUSTOM);
	    $c->addHaving($having);
	    
	    $c->addDescendingOrderByColumn(TaggingPeer::TAGGABLE_ID);
	    
	    $res = TaggingPeer::doSelect($c);
	    foreach ($res as $row)
	    {
	    	$model = $row->getTaggableModel();
	
	      if (!isset($taggings[$model]))
	      {
	        $taggings[$model] = array();
	      }
	
	      $taggings[$model][] = $row->getTaggableId();
	    }
    }
   
   return $taggings;
  }

  /**
   * Retrives a tag object by it's name.
   * 
   * @param      String      $tagname
   * @return     Tag
   */
  public static function retrieveByTagname($tagname,$binary=false)
  {
    $c = new Criteria();
    if ($binary)
    {
    	$c->add(TagPeer::NAME, "BINARY CONVERT(name USING utf8)='$tagname'",Criteria::CUSTOM);
    } else
    {
    	$c->add(TagPeer::NAME, $tagname);
    }
    return TagPeer::doSelectOne($c);
  }
  
  /**
   * Approve a tag
   *
   * @param string  $tagname The tag to approve
   * @param integer $userId  The id of the user approving 
   */
  public static function approveTagByName($tagname, $userId)
  {
    $tagObject = TagPeer::retrieveByTagname($tagname);
    
    $tagObject->setApproved(1);
    $tagObject->setApprovedAt(time());
    $tagObject->setApprovedBy($userId);
    $tagObject->save();

    // We also need to approve any links between files and tags
    $taggedObjects = self::getTaggedWith(array($tagname));
    
    foreach($taggedObjects as $taggedObject)
    {
      $model = false;
      
      if ($taggedObject instanceof genericArtwork )
      {
        reaktorCache::delete("artwork_tag_list_".$taggedObject->getId());
        if ($taggedObject->getStatus() == 3)
        {
          TaggingPeer::setTaggingApproved($tagObject, "ReaktorArtwork", $taggedObject->getId());
        }
      }
      elseif ($taggedObject instanceof artworkFile )
      {
        if ($taggedObject->hasArtwork())
        {
          foreach($taggedObject->getParentArtworks() as $artwork)
          {
            reaktorCache::delete("artwork_tag_list_".$artwork->getId());
            if ($artwork->getStatus() == 3)
            {
              TaggingPeer::setTaggingApproved($tagObject, "ReaktorFile", $taggedObject->getId());
            }
          }
        }
        $taggedObject->updateTagMetaData();
      }
      elseif ($taggedObject instanceof Article )
      {
        if ($taggedObject->isPublished())
        {
          TaggingPeer::setTaggingApproved($tagObject, "Article", $taggedObject->getId());
        }
      }
      else
      {
        sfContext::getInstance()->getLogger()->info("Unsupported object passed in tagpeer: ".get_class($taggedObject));
        continue;
      }
    }
  }
  
  public static function getNumberofTagsByApprovedStatus($status = 0)
  {
    $c = new Criteria();
    $c->add(TagPeer::APPROVED, $status);
    return TagPeer::doCount($c);
  }
  
  /**
   * Set the tag width for speedier checking of tag clouds
   *
   * @param string $tagname
   */
  public static function setTagWidthByName($tagname)
  {
    $tagObject = TagPeer::retrieveByTagname($tagname);
    
    if ($tagObject)
    {
      $tagObject->setWidth(mb_strlen($tagname, 'UTF-8'));
      $tagObject->save();
    }
  }

  /**
   * Set the tag status
   *
   * @param string  $tagname The name of the tag
   * @param integer $status  The group id to set
   */
  public static function setTagGroupByName($tagname, $groupId)
  {
    $tagObject = TagPeer::retrieveByTagname($tagname);
    
    $tagObject->setTagGroupId($groupId);
    $tagObject->save(); 
  }
  
   /** Unapprove a tag (effectively deletes it)
   *
   * @param string  $tagname The tag to unapprove
   * 
   * @return null
   */
  public static function unapproveTagByName($tagname)
  {
    // We need to remove the tag from Dublin Core metadata in all the files that have it
    $taggedObjects = self::getTaggedWith($tagname);
    
    $tagObject = TagPeer::retrieveByTagname($tagname);
    TaggingPeer::deleteLinks($tagObject->getId());
    $tagObject->delete();
    
    foreach ($taggedObjects as $taggedObject)
    {
      if ($taggedObject instanceof artworkFile )
      {
        $taggedObject->updateTagMetaData();
        foreach ($taggedObject->getParentArtworks() as $parent)
        {
          reaktorCache::delete("artwork_tag_list_".$parent->getId());
        }
      }
      elseif ($taggedObject instanceof genericArtwork )
      {
        reaktorCache::delete("artwork_tag_list_".$taggedObject->getId());
      }
    }
  }
  
  /**
   * Retrieves a tag by his name. If it does not exist, creates it (but does not
   * save it)
   * 
   * @param      String      $tagname
   * @return     Tag
    */
  public static function retrieveOrCreateByTagname($tagname)
  {
    // retrieve or create the tag
    $tag = TagPeer::retrieveByTagName($tagname);

    if (!$tag)
    {
      $tag = new Tag();
      $tag->setName($tagname);
    }

    return $tag;
  }

  /**
   * Adds a new, approved, normal tag
   *
   * @param string  $name       tag to add
   * @param integer $approvedby Id of the sf_guard_user who approved it
   */
  public static function addNewApprovedTag($name, $approvedby = null)
  {
    $c = new Criteria();
    $c->add(TagPeer::NAME, $name);
    $tag = TagPeer::doSelect($c);
    if (!$tag)
    {
      $tag = new Tag();
      if ($approvedby !== null)
      {
        $tag->setApproved(true);
        $tag->setApprovedBy($approvedby);
        $tag->setApprovedAt(time());
      }
      $tag->setName($name);
      $tag->setWidth(strlen($name));
      $tag->save();

      return $tag;
    }
    else
    {
      return true;
    }
  }
  
/**
   * Get tags 
   *
   * @param object   $object tagged object
   * @param boolean  $list   whether to return an array of tag names instead of array of objects 
   * @param criteria $c      criteria to use if needed
   */
  public static function getTagsByObject($object, $list = false, $c = null)
  {
    if (is_null($c))
    {
      $c = new Criteria();
    }
    
    if ($object instanceof genericArtwork )
    {
      $taggable = "ReaktorArtwork";
    }
    elseif ($object instanceof artworkFile )
    {
      $taggable = "ReaktorFile";
    }
    else
    {
      $taggable = get_class($object);
    }
    
    $objectId = $object->getId();
    
    $c->add(TaggingPeer::TAGGABLE_MODEL, $taggable);
    $c->add(TaggingPeer::TAGGABLE_ID, $objectId);
    $c->addJoin(self::ID, TaggingPeer::TAG_ID);
    
    $tags = self::doSelect($c);
    
    if (!$list)
    {
      return $tags;
    }
    else
    {
      $returnArray = array();
      foreach($tags as $tag)
      {
        $returnArray[$tag->getId()] = $tag->getName();
      }
      return $returnArray;
    }
  }

/**
 * Get tags for ajax drop down list
 *
 * @param string  $tagStart The  entered characters for filtering
 * @param array   $files         Files to exclude from the results (existing tags on the files)
 * @param string  $taggableModel The taggable model of the above files/artworks/etc
 * @param integer $approved      The approval status, or null to ignore
 * @param integer $limit         limit on rows to return
 */
  public static function getTagsStartingwithStringExludingTaggables($tagStart, $files = array(), $taggableModel = "ReaktorFile", $approved = 1, $limit = 10)
  {
    $c = new Criteria();
    
    if (!is_null($approved))
    {
      $c->add(TagPeer::APPROVED, $approved);
    }
    $c->add(self::NAME, "$tagStart%", Criteria::LIKE);
    
    $approved = $c->getNewCriterion(self::APPROVED, 1);
    $mytags = $c->getNewCriterion(TaggingPeer::PARENT_USER_ID, sfContext::getInstance()->getUser()->getId());
    $approved->addOr($mytags);
    $c->add($approved);
    $c->addJoin(self::ID, TaggingPeer::TAG_ID, Criteria::LEFT_JOIN);

    $c->add(TagPeer::ID, TagPeer::ID. " NOT IN (
      SELECT tag_id
      FROM tagging
      WHERE (taggable_id IN (".implode(",", $files) . ")
      AND taggable_model = '".$taggableModel ."'))", Criteria::CUSTOM);

    $c->setLimit($limit);
    $c->setDistinct();
    return self::getAll($c); 
  }

  /**
   * Get all $approved tags starting with $tagStart
   * 
   * @param string $tagStart 
   * @param int $approved 
   * @return Tags
   */
  public static function getTagsStartingWithString($tagStart, $approved = 1, $user = false)
  {
    $c = new Criteria();
    
    $c->add(self::NAME, "$tagStart%", Criteria::LIKE);
    if ($user !== false && !$user->hasCredential("createcompositeartwork"))
    {
		
    	$c->addJoin(TaggingPeer::TAG_ID,TagPeer::ID);
		$c->add(TaggingPeer::TAGGABLE_MODEL,'ReaktorArtwork');
		$c->add(TaggingPeer::PARENT_USER_ID,$user->getId());
    } else 
    {
    	$c->add(TagPeer::APPROVED, $approved);
    }
    $c->setLimit(10);
    return self::getAll($c); 
  }
  
  public static function getFilesTaggedWith($tags)
  {
  	// ZOID: Somebody has changed this function to return all types of object - the "model" option is ignored
    $objects = self::getTaggedWith($tags, array('model' => 'ReaktorFile'));
  	return $objects;
  }
  
  /**
   * Function for normalising tags, will rename a tag or merge it if the new tag already exists
   * Effectively all objects lose the old tag and gain the new one
   *
   * @param string|Tag $oldTag The original tag name or object that will be removed/renamed
   * @param string|Tag $newTag The new tag name or object that will be the replacement
   * 
   * @return boolean true on success, exception on errors or null on no result
   */
  public static function renameOrMergeTag($oldTag, $newTag)
  {
   if (!$oldTag instanceof Tag)
   {
     $oldTag = self::retrieveByTagname($oldTag);
   }
   $originalNewTag = $newTag;
   // Lets see if the new one already exists, then we are merging
   if ($newTag instanceof Tag || $newTag = self::retrieveByTagname($newTag,true))
   {
   	$taggedObjects = self::getTaggedWith($oldTag);
   	
     foreach ($taggedObjects as $taggedObject)
     {
       $taggedObject->addTag($newTag->getName());
       $taggedObject->save();
       if ($taggedObject instanceof artworkFile )
       {
         $taggedObject->updateTagMetadata();
       }
     }
     $oldTag->delete();
   }
   // If the new tag didn't exist, this is a simple rename operation
   else
   {

     $oldTag->setName($originalNewTag);
     $oldTag->Save();
   }
   return true;
  }
}

