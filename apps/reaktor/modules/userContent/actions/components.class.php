<?php
/**
 * Components for user content
 *
 * PHP Version 5
 *
 * @author    Russ Flynn <russ@linpro.no>
 * @copyright 2008 Linpro AS
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 *
 */

/**
 * Components for user content
 *
 * PHP Version 5
 *
 * @author    Russ Flynn <russ@linpro.no>
 * @copyright 2008 Linpro AS
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 *
 */
class userContentComponents extends sfComponents
{
  /**
   * Select dropdown for making composite artworks
   *
   * @return null
   */
  function executeArtworkCompositeSelect()
  {
    // Get the list of eligible artworks
    $this->thisUser = sfGuardUserPeer::getByUsername($this->getRequestParameter("user"));
    $this->artworks = ReaktorArtworkPeer::getArtworksByType($this->file->getIdentifier(), null, true, true, $this->file->getParentArtworks(true));
  }
  
  /**
   * The sidebar menu for content management
   * 
   * @returm null
   */
  public function executeContentManagerSidebarAjaxblock()
  {
    if ($this->getRequestParameter("user"))
    {
      $this->thisUser = sfGuardUserPeer::getByUsername($this->getRequestParameter("user"));
      $this->route = "@user_content";
    }
    else
    {
      $this->thisUser = $this->getUser()->getGuardUser();
      $this->route = "@my_content";
    }

    $c = new Criteria();
    if ($this->getUser()->hasCredential("viewallcontent"))
    {
      $includeHidden = true;
    }
    else
    {
      $includeHidden = false;
      $c->add(ReaktorArtworkPeer::STATUS, ReaktorArtwork::REMOVED, Criteria::NOT_EQUAL);
    }
    
    $artworkCount          = ReaktorArtworkPeer::countUserArtworks($this->thisUser, null, null, true, $c);
    $this->fileCount       = ReaktorFilePeer::countFilesByUser($this->thisUser, null, false, $includeHidden);
    $this->unusedCount     = ReaktorFilePeer::countFilesByUser($this->thisUser, null, true, $includeHidden);
    $this->unsuitableCount = ReaktorFilePeer::countFilesByUser($this->thisUser, null, false, $includeHidden, true);
    
    // If an artwork is status 6, then it can show up with the approved artworks so we'll just lump them all together
    if (isset($artworkCount [ReaktorArtwork::APPROVED]) && isset($artworkCount [ReaktorArtwork::APPROVED_HIDDEN]))
    {
      foreach ($artworkCount [ReaktorArtwork::APPROVED_HIDDEN] as $year => $count)
      {
        if (isset($artworkCount [ReaktorArtwork::APPROVED][$year]))
        {
          $artworkCount [ReaktorArtwork::APPROVED][$year] += $count;
        }
        else
        {
          $artworkCount [ReaktorArtwork::APPROVED][$year] = $count;
        }
      }
    }
    elseif (!isset($artworkCount [ReaktorArtwork::APPROVED]) && isset($artworkCount [ReaktorArtwork::APPROVED_HIDDEN]))
    {
      $artworkCount [ReaktorArtwork::APPROVED] = $artworkCount [ReaktorArtwork::APPROVED_HIDDEN];
    }
    $this->artworkCount = $artworkCount;
    $this->total        = 0;
    
    foreach($artworkCount as $status => $item)
    {
      if ($status != ReaktorArtwork::REMOVED || $this->getUser()->hasCredential("viewallcontent"))
      {
        $this->total += array_sum($item);
      }
    }
  }
}



   