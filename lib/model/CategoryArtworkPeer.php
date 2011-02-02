<?php

/**
 * Subclass for performing query and update operations on the 'category_artwork' table.
 *
 * 
 *
 * @package lib.model
 */ 
class CategoryArtworkPeer extends BaseCategoryArtworkPeer
{
  /**
   * Find artworks based on categories
   *
   * @param string  $category The category to search for (any language ok)
   * @param boolean $approved Whether to return only approved artworks (default true)
   * 
   * @return array of genericArtwork objects
   */
  public static function getArtworksInCategory($category, $approved = true)
  {
    $resultsArray = array();
    $c            = new Criteria();
    
    $c->add(CategoryI18nPeer::NAME, $category);
    $c->addJoin(CategoryI18nPeer::ID, CategoryArtworkPeer::CATEGORY_ID);
    $c->addGroupByColumn(CategoryArtworkPeer::ARTWORK_ID);
    if ($approved)
    {
      $c->add(ReaktorArtworkPeer::STATUS, 3);
    }

    if (Subreaktor::getProvidedSubreaktor() instanceof Subreaktor || 
        Subreaktor::getProvidedLokalreaktor() instanceof Subreaktor ||
        isset($options['subreaktor']) ||
        isset($options['lokalreaktor']))
    {
      $c->addJoin(CategoryArtworkPeer::ARTWORK_ID, ReaktorArtworkPeer::ID, Criteria::LEFT_JOIN);
    }
      
    if (isset($options['subreaktor']))
    {
      $c->addJoin(ReaktorArtworkPeer::ID, SubreaktorArtworkPeer::ARTWORK_ID, Criteria::LEFT_JOIN);
      $c->add(SubreaktorArtworkPeer::SUBREAKTOR_ID, $options['subreaktor']->getId());
    }
    elseif (Subreaktor::getProvidedSubreaktor() instanceof Subreaktor)
    {
      $c->addJoin(ReaktorArtworkPeer::ID, SubreaktorArtworkPeer::ARTWORK_ID, Criteria::LEFT_JOIN);
      $c->add(SubreaktorArtworkPeer::SUBREAKTOR_ID, Subreaktor::getProvidedSubreaktor()->getId());
    }
    
    if (isset($options['lokalreaktor']))
    {
      $c->addJoin(ReaktorArtworkPeer::ID, LokalreaktorArtworkPeer::ARTWORK_ID, Criteria::LEFT_JOIN);
      $c->addJoin(LokalreaktorArtworkPeer::SUBREAKTOR_ID, LokalreaktorResidencePeer::SUBREAKTOR_ID, Criteria::LEFT_JOIN);
      $ctn = $c->getNewCriterion(LokalreaktorArtworkPeer::SUBREAKTOR_ID, $options['lokalreaktor']->getId());
      $ctn2 = $c->getNewCriterion(sfGuardUserPeer::RESIDENCE_ID, $options['lokalreaktor']->getResidences(), Criteria::IN);
      $ctn->addOr($ctn2);
      $c->add($ctn);
    }
    elseif (Subreaktor::getProvidedLokalreaktor() instanceof Subreaktor)
    {
      $c->addJoin(ReaktorArtworkPeer::ID, LokalreaktorArtworkPeer::ARTWORK_ID, Criteria::LEFT_JOIN);
      $c->addJoin(LokalreaktorArtworkPeer::SUBREAKTOR_ID, LokalreaktorResidencePeer::SUBREAKTOR_ID, Criteria::LEFT_JOIN);
      $ctn = $c->getNewCriterion(LokalreaktorArtworkPeer::SUBREAKTOR_ID, Subreaktor::getProvidedLokalreaktor()->getId());
      $ctn2 = $c->getNewCriterion(sfGuardUserPeer::RESIDENCE_ID, Subreaktor::getProvidedLokalreaktor()->getResidences(), Criteria::IN);
      $ctn->addOr($ctn2);
      $c->add($ctn);
    }
    
    $c->addJoin(ReaktorArtworkPeer::USER_ID, sfGuardUserPeer::ID, Criteria::LEFT_JOIN);
    if (!sfContext::getInstance()->getUser()->hasCredential('viewallcontent'))
    {
    	$c->add(sfGuardUserPeer::SHOW_CONTENT, true);
    }
    
    foreach (CategoryArtworkPeer::doSelectJoinReaktorArtwork($c) as $resultObject)
    {
      $resultsArray[] = new genericArtwork($resultObject->getReaktorArtwork(), null, array());
    }
    
    return $resultsArray;
  }
  
  /**
   * Return all the categories an artwork is attached to
   *
   * @param genericArtwork|integer $artwork object or id
   * 
   * @return array of categories with id as key and the name (using i18n)
   */
  public static function getCategoriesFromArtwork($artwork)
  {
    if ($artwork instanceof genericArtwork )
    {
      $artwork = $artwork->getId();
    }
    
    $categories = array();
    
    $c = new Criteria();
    $c->add(CategoryArtworkPeer::ARTWORK_ID, $artwork);
    $c->addJoin(CategoryPeer::ID, CategoryArtworkPeer::CATEGORY_ID);
    
    $categoryObjects = CategoryPeer::doSelectWithI18n($c);
    
    foreach ($categoryObjects as $categoryObject)
    {
    	$categories[$categoryObject->getId()] = $categoryObject->getName();
    }
    return $categories;
    
  }
  
  /**
   * Add a new artwork/category relationship
   * 
   * @param genericArtwork|integer $artwork  The artwork object or ID
   * @param integer                $category The category ID
   * @param sfGuardUser|integer    $user     User object or ID
   * 
   * @return void updates the DB
   */
  public static function addArtworkCategory($artwork, $categoryId, $user)
  {
    if ($artwork instanceof genericArtwork )
    {
      $artwork = $artwork->getId();
    }
    if ($user instanceof myUser )
    {
      $user = $user->getGuardUser()->getId();
    }
    elseif ($user instanceof sfGuardUser )
    {
      $user = $user->getId();
    }
        
    // Lets check it doesn't already exist
    $c = new Criteria();
    $c->add(self::CATEGORY_ID, $categoryId);
    $c->add(self::ARTWORK_ID, $artwork);
    
    $thisCAP = self::doSelectOne($c);
    
    if (!$thisCAP)
    {
      $newCAP = new CategoryArtwork();
      $newCAP->setCategoryId($categoryId);
      $newCAP->setArtworkId($artwork);
      $newCAP->setAddedBy($user);
      $newCAP->save();
    }
  }
  
  /**
   * Remove a category/artwork link
   *
   * @param genericArtwork|integer $artwork  The artwork object or ID
   * @param integer                $category The category ID
   * 
   * @return void
   */
  public static function removeArtworkCategory($artwork, $categoryId)
  {
    if ($artwork instanceof genericArtwork )
    {
      $artwork = $artwork->getId();
    }
    
    $c = new Criteria();
    $c->add(self::CATEGORY_ID, $categoryId);
    $c->add(self::ARTWORK_ID, $artwork);
    
    $thisCAP = self::doSelectOne($c);
    if ($thisCAP)
    {
      $thisCAP->delete();
      return true;
    }
    else
    {
      return false;
    }
  }
  
  /**
   * Removes all categories from the artwork which are linked to a subreaktor
   * 
   * @param genericArtwork|integer $artwork    The artwork object or ID
   * @param subreaktor|integer     $subreaktor The subreaktor object or ID
   * 
   * @return void
   */
  public static function removeAllInSubreaktor($artwork, $subreaktor)
  {
    if ($artwork instanceof genericArtwork )
    {
      $artwork = $artwork->getId();
    }
    if ($subreaktor instanceof Subreaktor )
    {
      $subreaktor = $subreaktor->getId();
    }
    
    $c = new criteria();
    $c->add(self::ARTWORK_ID, $artwork);
    $c->add(CategorySubreaktorPeer::SUBREAKTOR_ID, $subreaktor);
    $c->addjoin(self::CATEGORY_ID, CategorySubreaktorPeer::CATEGORY_ID);
    
    $rowsToDelete = self::doSelect($c);
    foreach ($rowsToDelete as $row)
    {
      $row->delete();
    }
  }
}
