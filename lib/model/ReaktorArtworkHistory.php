<?php

/**
 * Subclass for representing a row from the 'reaktor_artwork_history' table.
 *
 * 
 *
 * @package lib.model
 */ 
class ReaktorArtworkHistory extends BaseReaktorArtworkHistory
{
  
  /**
   * Enter description here...
   *
   * @param integer $id
   * @param int|sfGuardUser $user
   * @param string $comment
   * @param int $status
   * @param int $modified_flag If the artwork is modified when approved, this flag i set the the time it was last modified
   * @param boolean $is_file
   */
  public static function logAction($id, $user, $comment, $status = 0, $modified_flag = 0,  $is_file = 0)
  {    
    if ($user instanceof sfGuardUser)
    {
      $user = $user->getId();
    }
    
    $history_row = new ReaktorArtworkHistory();
    if($is_file)
    { 
      $history_row->setFileId($id);
    }
    else
    {
      $history_row->setArtworkId($id);
    }
//    $history_row->setApprovedAt(time("Y-m-d H:i:s"));
    $history_row->setUserId($user);
    $history_row->setComment($comment);
    $history_row->setStatus($status);
    if ($modified_flag)
    {
      $history_row->setModifiedFlag($modified_flag);
    }  
    $history_row->save();
  }
}
