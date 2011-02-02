<?php

/**
 * Subclass for performing query and update operations on the 'reaktor_file' table.
 *
 * 
 *
 * @package lib.model
 */ 
class ReaktorFilePeer extends BaseReaktorFilePeer
{
  /**
   * Get paginated object of reported files
   *
   * @return sfPager paginated files object
   */
  public static function getReportedFilesPaginated()
  {
    $files = array();
    $c = new Criteria();

    $c->add(self::REPORTED, 0, Criteria::GREATER_THAN); 
    $c->add(self::MARKED_UNSUITABLE, 0, Criteria::EQUAL);

    $pager = new sfPropelPager('ReaktorFile', SfConfig::get('app_artwork_pagination',10));
    $pager->setCriteria($c);
    return $pager;
  }
  
  /**
   * Get a count of reported files
   *
   * @return integer The count
   */
  public static function getNumberofReportedFiles()
  {
    $c = new Criteria();

    $c->add(self::REPORTED, 0, Criteria::GREATER_THAN); 
    $c->add(self::MARKED_UNSUITABLE, 0, Criteria::EQUAL);
    
    return self::doCount($c);
  }
  
  /**
   * Return files that have been marked unsuitable
   *
   * @return sfPager the pager object with the unsuitable files
   */
  public static function getMarkedUnsuitableFilesPaginated()
  {
    $c = new Criteria();
    $c->add(self::MARKED_UNSUITABLE, 1);
    $c->add(FileMetadataPeer::META_ELEMENT, 'title');
    $c->addJoin(self::ID, FileMetadataPeer::FILE);
   
    $pager = new sfPropelPager('ReaktorFile', SfConfig::get('app_artwork_pagination', 10));
    $pager->setPeerMethod('doSelectJoinSfGuardUser');
    $pager->setCriteria($c);
    return $pager;
        
  }

  /** 
   * Get a count of files under discussion
   *
   * @return integer The count
   */
  public static function getNumberofFilesUnderDiscussion()
  {
    $c = new Criteria();

    $c->add(self::UNDER_DISCUSSION, 1);
    
    return self::doCount($c);
  }
  
  /**
   * Get all the files that are under discussion
   * 
   * @return array of artwork files
   */
  public static function getFilesUnderDiscussion()
  {
    $c = new Criteria();
    $c->add(self::UNDER_DISCUSSION, 1);
    
    $result      = self::doSelectJoinAll($c);
    $returnArray = array();
    
    foreach ($result as $reaktorFile)
    {
      $returnArray[$reaktorFile->getId()] = new artworkFile($reaktorFile);
    }
    
    return $returnArray;
  }
  
  /**
   * Returns all files by date
   *
   * @param timestamp $from_date
   * @param timestamp $to_date
   */
  public static function getByDate($from_date, $to_date)
  {
  	$crit = new Criteria();
  	$crit->add(self::DELETED, false);
  	$ctn = $crit->getNewCriterion(self::UPLOADED_AT, $from_date, Criteria::GREATER_EQUAL);
  	$ctn2 = $crit->getNewCriterion(self::UPLOADED_AT, $to_date, Criteria::LESS_EQUAL);
  	$ctn->addAnd($ctn2);
  	$crit->add($ctn);
  	
  	$returnfiles = array();
  	foreach (self::doSelectJoinAll($crit) as $reaktorfile)
  	{
  		$returnfiles[] = new artworkFile($reaktorfile);
  	}
  	
  	return $returnfiles;
  }
 
  /**
   * Return a count of the number of files a user has uploaded in total
   *
   * @param sfGuardUser|integer $user          The user object or ID
   * @param string              $type          The type of file (file identifier)
   * @param boolean             $orphaned      Whether to return only orphaned files (not in artworks)
   * @param boolean             $includeHidden Whether to return hidden files ("deleted" by user)
   * @param boolean             $unsuitable    Whether to filter on unsuitability flag
   * 
   * @return integer the count
   */
  public static function countFilesByUser($user, $type = null, $orphaned = false, $includeHidden = false, $unsuitable = null)
  {
    return self::getFilesByUser($user, $type, $orphaned, true, false, array(), $includeHidden, $unsuitable);    
  }
  
  /**
   * Return the files that are connected to a particular user
   * 
   * @param sfGuardUser|integer $user           The user object or ID
   * @param string|array        $type           The type of file (file identifier) or array of types
   * @param boolean             $orphaned       Whether to return only orphaned files (not in artworks)   
   * @param boolean             $count          Whether to just return a count, instead of the array of files
   * @param boolean             $dontGetParents Set true to choose not to populate parent artworks (saves queries if they are not going to be used)
   * @param array               $excludeIds     An array of IDs to exclude from the results
   * @param boolean             $includeHidden  Whether to include hidden files
   * @param boolean             $unsuitable     Whether to filter on unsuitability
   * 
   * @return integer|array count or array of files
   */
  public static function getFilesByUser($user, $type = null, $orphaned = false, $count = false, $dontGetParents = false, $excludeIds = array(), $includeHidden = false, $unsuitable = false)
  {
    if ($user instanceof sfGuardUser || $user instanceof myUser )
    {
      $user = $user->getId();
    }
    $c = new Criteria();
    $c->add(self::USER_ID, $user);
    
    if (!$includeHidden)
    {
      $c->add(self::HIDDEN, 0);
    }
    
    if (!is_null($unsuitable))
    {
      $c->add(self::MARKED_UNSUITABLE, $unsuitable);
    }
    
    if ($type)
    {
      if (is_array($type))
      {
        $c->add(self::IDENTIFIER, $type, Criteria::IN);
      }
      else
      {
        $c->add(self::IDENTIFIER, $type);
      }
    }
    
    if ($orphaned)
    {
      $c->addJoin(self::ID, ReaktorArtworkFilePeer::FILE_ID, Criteria::LEFT_JOIN);
      $c->add(ReaktorArtworkFilePeer::ARTWORK_ID, null);
    }
    
    if (!empty($excludeIds))
    {
      $c->add(self::ID, $excludeIds, Criteria::NOT_IN);
    }
    
    if ($count)
    {
      return self::doCount($c);
    }
    else
    {
      
      $rows        = self::doSelectJoinAll($c);
      $resultArray = array();

      foreach($rows as $row)
      {
        $resultArray[$row->getId()] = new artworkFile($row->getId(), null, $rows, $dontGetParents);
      }
      return $resultArray;
    }
  }
  
  /**
   * Overriding the retrieve by PK class so we can get artworkFile objects back 
   *
   * @param integer    $pk          The ID of the file we want
   * @param connection $con         Database connection
   * @param boolean    $artworkFile Whether to return an artworkFile object
   */
  public static function retrieveByPK($pk, $con = null, $artworkFile = false)
  {
    $fileObject = parent::retrieveByPK($pk);
    
    if ($fileObject && $artworkFile)
    {
      return new artworkFile($fileObject);
    }
    else
    {
      return $fileObject;
    }
  }
  
  /**
   * Get an array of files based on an artwork type
   *
   * @param string $type           for example "image" or "video" from the mimetype table
   * @param array  $excludeIds     an array of file ids not to include in the results
   * @param boolean $includeHidden Whether to include hidden files in results
   * 
   * @return array of artworkfile objects
   */
  public static function getFilesByType($type, $excludeIds = array(), $includeHidden = false, $unsuitable = null)
  {
    $c = new Criteria();
    
    $c->add(FileMimetypePeer::IDENTIFIER, $type);
    $c->addJoin(self::CONVERTED_MIMETYPE_ID, FileMimetypePeer::ID);
    
    if (!empty($excludeIds))
    {
      $c->add(self::ID, $excludeIds, Criteria::NOT_IN);
    }
    if (!$includeHidden)
    {
      $c->add(self::HIDDEN, 0);
    }
    if (!is_null($unsuitable))
    {
      $c->add(self::MARKED_UNSUITABLE);
    }
    
    $rows        = self::doSelectJoinAll($c);

    $resultArray = array();

    foreach($rows as $row)
    {
      $resultArray[$row->getId()] = new artworkFile($row->getId(), null, $rows);
    }
    return $resultArray;
  }
  
}
