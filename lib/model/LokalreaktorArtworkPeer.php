<?php

/**
 * Subclass for performing query and update operations on the 'lokalreaktor_artwork' table.
 *
 * 
 *
 * @package lib.model
 */ 
class LokalreaktorArtworkPeer extends BaseLokalreaktorArtworkPeer
{
  
   /**
   * Get all localreaktors an artwork belongs to
   *
   * @param integer $id
   * @return array LokalreaktorArtwork
   */
  public static function getLokalreaktorsByArtwork($id)
  {
    $c = new Criteria();

    $c->add(parent::ARTWORK_ID, $id);

    return parent::doSelectJoinAllExceptReaktorArtwork($c);
  }
  
}
