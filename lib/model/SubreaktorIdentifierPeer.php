<?php

/**
 * Subclass for performing query and update operations on the 'subreaktor_identifier' table.
 *
 * 
 *
 * @package lib.model
 */ 
class SubreaktorIdentifierPeer extends BaseSubreaktorIdentifierPeer
{
  /**
   * Does what it says on the tin, pass artwork id or object and possible subreaktors are returned
   * At the moment artworks generally have only one file type attached, but this method assumes that
   * there may be artworks with multiple file types.
   *
   * @param integer|genericArtwork|reaktorArtwork $artwork          the artwork object
   * @param boolean                               $returnReferences true if you want refs instead of objects
   * 
   * @return array of subreaktor objects, references (key will be ID) or empty array
   */
  public static function getEligibleSubreaktors($artwork, $returnReferences = false,$hasCredential=false)
  {
    if ($artwork instanceof reaktorArtwork || $artwork instanceof genericArtwork)
    {
      $files = $artwork->getFiles();
      if (empty($files))
      {
        throw new exception ("Somehow this artwork has no files");
      }
    }
    else
    {
      if (is_object($artwork))
      {
        throw new Exception ("Unsupported: ".get_class($artwork));
      }
      throw new Exception ("Unsupported: ".$artwork);
    }
    
    $identifiers = array();
    
    // Check all the file types in this artwork
    foreach ($files as $file)
    {
      if (!in_array($file->getIdentifier(), $identifiers))
      {
        $identifiers[] = $file->getIdentifier();
      }
    }
    $c = new Criteria();
    $c->addJoin(SubreaktorIdentifierPeer::SUBREAKTOR_ID, SubreaktorPeer::ID);
// Exception for animated gifs 
if(($file->getMimetype() == "image/gif") ){
    $c1=$c->getNewCriterion(SubreaktorIdentifierPeer::IDENTIFIER, $identifiers, Criteria::IN);
    $c2=$c->getNewCriterion(SubreaktorPeer::REFERENCE, 'film');

    $c1->addOr($c2);
    $c->add($c1);

    } else {
    $c->add(SubreaktorIdentifierPeer::IDENTIFIER, $identifiers, Criteria::IN);
    
    }

    $c->setDistinct();
    $c->add(SubreaktorPeer::LOKALREAKTOR, false);
    $c->add(SubreaktorPeer::LIVE, true);

    $subreaktors = SubreaktorPeer::doSelectWithI18n($c);

    if ($returnReferences)
    {
      $referencesResult = array();
      foreach ($subreaktors as $subreaktor)
      {
        $referencesResult[$subreaktor->getId()] = $subreaktor->getReference();  
      }
      return $referencesResult;
    }
   
    return $subreaktors; 
  }
}
