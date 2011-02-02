<?php

/**
 * Subclass for performing query and update operations on the 'reaktor_artwork_file' table.
 *
 * 
 *
 * @package lib.model
 */ 
class ReaktorArtworkFilePeer extends BaseReaktorArtworkFilePeer
{
  /**
   * Set the artwork order placement of this file
   * This function should usually not be used unless called via the artwork class 
   *
   * @param integer $fileorder The integer of the order
   * 
   * @return void The file order is set in the DB
   */
  public static function setFileOrderPlacement($fileorder, $fileId, $artworkId)
  {
    if ($artworkId instanceof genericArtwork)
    {
      $artworkId = $artworkId->getId();
    }
    
    if ($fileId instanceof artworkFile )
    {
      $fileId = $fileId->getId();
    }
    
    $crit = new Criteria();
    $crit->add(self::ARTWORK_ID, $artworkId);
    $crit->add(self::FILE_ID, $fileId);
    $res = self::doSelectOne($crit);
    
    if ($res)
    {
      $res->setFileOrder($fileorder);
      $res->save();
    }
    else
    {
      // throw new exception ("Cannot set order as no artwork_file relationship exists");
      // Changed mind about this one - some ajax functions have items dynamically removed, 
      // safe just ignore this if the relationship doesn't exist for now.
    }
    
  }
  
  /**
   * Return an array of files in a certain artwork
   *
   * @param genericArtwork $artwork The artwork object
   */
  public static function getFilesInArtwork($artwork)
  {
    $c = new Criteria();
    $c->add(self::ARTWORK_ID, $artwork->getId());
    
    $rows    = self::doSelectJoinAll($c);
    $results = array();
    foreach ($rows as $row)
    {
      $results[$row->getReaktorFile()->getId()] = new artworkFile($row->getReaktorFile()->getId(), null, $rows);
    }
    return $results;
  }
}
