<?php
/**
 * Subclass for performing query and update operations on the 'related_artwork' table.
 *
 * PHP version 5
 * 
 * @package   Reaktor
 * @author    Russ Flynn <russ@linpro.no>
 * @copyright 2008 Linpro AS
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 *
 * @package lib.model
 */
class RelatedArtworkPeer extends BaseRelatedArtworkPeer
{
  /**
   * Get Artworks related to an artwork
   *
   * @param genericArtwork|integer $artwork  the artwork object or id
   * @param integer                $limit    limit max results
   * @param boolean                $approved Whether to limit to approved only
   * 
   * @return array Artwork objects
   */
  public static function getRelatedArtworkObjects($artwork, $limit = 6, $approved = true)
  {
    if ($artwork instanceof genericArtwork || $artwork instanceof ReaktorArtwork )
    {
      $artworkId = $artwork->getId();
    }
    else
    {
      $artworkId = $artwork;
    }
    
    $resultArray = array();
    
    // First lets get the IDs of the related objects - we can't do a mega join here with Propel because of
    // The double foreign key (Propel does not support table aliases yet)
    $c = new Criteria();
    $critA = $c->getNewCriterion(RelatedArtworkPeer::FIRST_ARTWORK, $artworkId);
    $critB = $c->getNewCriterion(RelatedArtworkPeer::SECOND_ARTWORK, $artworkId);
    $critA->addOr($critB);
    
    $c->add($critA);
    $relatedRows = RelatedArtworkPeer::doSelect($c);
    
    if (!$relatedRows)
    {
      return $resultArray;
    }
    
    foreach($relatedRows as $relatedRow)
    {
      if ($relatedRow->getFirstArtwork() != $artworkId)
      {
        $relatedIds[] = $relatedRow->getFirstArtwork();
      }
      else
      {
        $relatedIds[] = $relatedRow->getSecondArtwork();
      } 
    }
   
    // Now we have all the artwork IDs, we just need to retreive them
    $c = new Criteria();
    $c->add(ReaktorArtworkPeer::ID, $relatedIds, Criteria::IN);
    if ($limit !== null)
    {
      $c->setLimit($limit);
    }
    if ($approved)
    {
      $c->add(ReaktorArtworkPeer::STATUS, 3);
    }
    
    $artworksArray = ReaktorArtworkPeer::doSelectJoinAll($c);

    sfContext::getInstance()->getLogger()->info("constructing a bunch of related artworks");
    foreach($artworksArray as $artwork)
    {
    	$resultArray[] = new genericArtwork($artwork, null, array()); 
    }   
    return $resultArray;
  }

  /**
   * Returns $limit amount of artworks that other people who like $artworkId 
   * like too
   * 
   * @param int $artworkId 
   * @param int $limit 
   * @return array(genericArtwork)
   */
  public static function getOtherRelatedArtworkObjects($artworkId, $limit = 5)
  {
    $retval = $artworkIds = array();
    $favusers = new Favourite();

    // Get the users who like the $artwork artwork
    $favs = $favusers->getLastFavs("artwork", $artworkId, $limit);

    foreach($favs as $fav)
    {
      // This shouldn't actually ever not happen
      if ($fav->getFavType() == 'artwork')
      {
        $userid = $fav->getSfGuardUserRelatedByUserId()->getId();
        // And then figure out which artworks $userid likes
        foreach((array)$fav->getMyLastFavs("artwork", $userid, $limit) as $artwork)
        {
          $artworkIds[] = $artwork->getArtworkId();
        }
      }
    }

    // Nuke duped favourites
    $artworkIds = array_unique($artworkIds);

    // _other_ related artworks does not include ourself
    $k = array_search($artworkId, $artworkIds);
    unset($artworkIds[$k]);
 
    $count = count($artworkIds);
    if ($count == 0)
    {
      return $retval;
    }

    // Do a little dance and get a random artworks
    foreach((array)array_rand($artworkIds, $count > $limit ? $limit : $count) as $key) {
      $retval[] = new genericArtwork($artworkIds[$key], null, array());
    }

    return $retval;
  }
 
  /**
   * Check if two artworks are related already
   *
   * @param int $artwork_id_1
   * @param int $artwork_id_2
   * @return boolean $relations True if they are related false if not
   */
  public static function isRelated($artwork_id_1, $artwork_id_2)
  {
    if($artwork_id_1 == $artwork_id_2) //They are related if they are the same artwork
    {
      $is_related = true;
    }
    else 
    {
      $relations = RelatedArtworkPeer::getRelation($artwork_id_1, $artwork_id_2);
      
      $is_related = $relations ? true : false;
    }
    return $is_related;
    
  }
  
  /**
   * Get artwork relation given two id's  
   *
   * @param int $artwork_id_1
   * @param int $artwork_id_2
   * 
   * @return array of related artwork objects
   */
  public static function getRelation($artwork_id_1, $artwork_id_2)
  {
    $c = new Criteria();
    
    $critA = $c->getNewCriterion(RelatedArtworkPeer::FIRST_ARTWORK, $artwork_id_1);
    $critB = $c->getNewCriterion(RelatedArtworkPeer::SECOND_ARTWORK, $artwork_id_2);
    $critA->addAnd($critB);
    
    $critC = $c->getNewCriterion(RelatedArtworkPeer::FIRST_ARTWORK, $artwork_id_2);
    $critD = $c->getNewCriterion(RelatedArtworkPeer::SECOND_ARTWORK, $artwork_id_1);
    $critC->addAnd($critD);
    
    $critA->addOr($critC);
    $c->add($critA);

    return parent::doSelect($c);
  }
  
  /**
   * Delete relation(s) between two artworks, there should always
   * be only one, but just in case..
   *
   * @param int $artwork_id_1
   * @param int $artwork_id_2
   */
  public static function deleteRelation($artwork_id_1, $artwork_id_2)
  {
    $relations = RelatedArtworkPeer::getRelation($artwork_id_1, $artwork_id_2);
    
    foreach ($relations as $relation)
    {
      //delete relation
      $c = new Criteria();
      $c->add(parent::ID, $relation->getId());
      UserResourcePeer::doDelete($c); 
    }
    
  }
    
    /**
     * Add a relation between to artworks
     *
     * @param int $first_artwork reaktor_artwork.id
     * @param int $second_artwork reaktor_artwork.id
     * @param int $user sfGuardUser id
   */
  public static function addRelatedArtwork($first_artwork, $second_artwork, $user)
  {
    $relatedartwork = new RelatedArtwork();    
    $relatedartwork->setFirstArtwork($first_artwork);
    $relatedartwork->setSecondArtwork($second_artwork);
    $relatedartwork->setCreatedBy($user);
    $relatedartwork->save();
    
  }
  

  
}
