<?php

/**
 * Subclass for performing query and update operations on the 'reaktor_artwork_history' table.
 *
 * 
 *
 * @package lib.model
 */ 
class ReaktorArtworkHistoryPeer extends BaseReaktorArtworkHistoryPeer
{

  /**
   * When a file is marked as unsuitable, a message is also sent to the owner explaining
   * the reason why. This message is also stored in the reaktor_artwork_history table. 
   * This function retrieves the latest message from the file. 
   *
   * @param integer $id
   * @param boolean $message_only
   * @param boolean  $is_file
   * @return ReaktorArtworkHistory|string
   */
  public static function getLatestRejectionMessage($id, $message_only = false, $is_file = 0)
  {
    $c = new Criteria();
    if($is_file)
    {
      $c->add(self::FILE_ID, $id, Criteria::EQUAL);
    }
    else
    {
      $c->add(self::ARTWORK_ID, $id, Criteria::EQUAL);
    }
    
    $c->addDescendingOrderByColumn(self::CREATED_AT);
    $history_entry = self::doSelectOne($c);
    if($message_only&&$history_entry)
    {
      return $history_entry->getComment();
    }
    else
    {
      return $history_entry;
    }
  }
    
}
