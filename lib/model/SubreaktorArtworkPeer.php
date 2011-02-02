<?php

/**
 * Subclass for performing query and update operations on the 'subreaktor_artwork' table.
 *
 * 
 *
 * @package lib.model
 */ 
class SubreaktorArtworkPeer extends BaseSubreaktorArtworkPeer
{
  /**
   * Add a new subreaktor/artwork link
   * 
   * @param genericArtwork|integer $artwork    The artwork ID or object
   * @param subreaktor|integer     $subreaktor The subreaktor ID or object
   * 
   * @return void
   */
  public static function addSubreaktorArtwork($artwork, $subreaktor)
  {
    if ($subreaktor instanceof Subreaktor )
    {
      $subreaktor = $subreaktor->getId();
    }
    if ($artwork instanceof genericArtwork or $artwork instanceof ReaktorArtwork )
    {
      $artwork = $artwork->getId();
    }
    
    if (intval($artwork) < 1)
    {
      throw new exception ("Need an artwork ID");
    }
    
    
    $c = new Criteria();
    $c->add(self::SUBREAKTOR_ID, $subreaktor);
    $c->add(self::ARTWORK_ID, $artwork);
    
    if (!self::doSelectOne($c))
    {
      $subreaktorartworkitem = new SubreaktorArtwork();
      $subreaktorartworkitem->setArtworkId($artwork);
      $subreaktorartworkitem->setSubreaktorId($subreaktor);
      $subreaktorartworkitem->save();
    }
  }


   /**
   * Get all subreaktors an artwork belongs to
   *
   * @param integer $id
   * @return array SubreaktorArtwork
   */
  public static function getSubreaktorsByArtwork($id)
  {
    $c = new Criteria();

    $c->add(parent::ARTWORK_ID, $id);

    return parent::doSelectJoinAll($c);
  }
  
  
}
