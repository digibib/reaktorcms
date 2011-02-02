<?php
/**
 * Reaktor file class - the entry point for all actions regarding
 * an uploaded file on the system
 *  
 * PHP version 5
 * 
 * @author    Daniel Andre Eikeland <dae@linpro.no>
 * @author    Russ Flynn <russ@linpro.no>
 * @copyright 2008 Linpro AS
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 */

  require_once SF_ROOT_DIR . DIRECTORY_SEPARATOR . 'lib/model/om/BaseReaktorFilePeer.php';
  require_once SF_ROOT_DIR . DIRECTORY_SEPARATOR . 'lib/model/om/BaseFileMimetype.php';
  require_once SF_ROOT_DIR . DIRECTORY_SEPARATOR . 'lib/model/om/BaseFileMetadata.php';
  require_once SF_ROOT_DIR . DIRECTORY_SEPARATOR . 'lib/model/ReaktorFile.php';
  require_once SF_ROOT_DIR . DIRECTORY_SEPARATOR . 'lib/model/FileMimetype.php';
  require_once SF_ROOT_DIR . DIRECTORY_SEPARATOR . 'lib/model/FileMetadata.php';
  require_once SF_ROOT_DIR . DIRECTORY_SEPARATOR . 'lib/model/om/BaseReaktorFilePeer.php';
  require_once SF_ROOT_DIR . DIRECTORY_SEPARATOR . 'lib/model/om/BaseFileMimetypePeer.php';
  require_once SF_ROOT_DIR . DIRECTORY_SEPARATOR . 'lib/model/om/BaseFileMetadataPeer.php';
  require_once SF_ROOT_DIR . DIRECTORY_SEPARATOR . 'lib/model/ReaktorFilePeer.php';
  require_once SF_ROOT_DIR . DIRECTORY_SEPARATOR . 'lib/model/FileMimetypePeer.php';
  require_once SF_ROOT_DIR . DIRECTORY_SEPARATOR . 'lib/model/FileMetadataPeer.php';
  
/**
 * Artwork file class. Builds upon the ReaktorFile class, but doesn't extend it
 * 
 * @author    Daniel Andre Eikeland <dae@linpro.no>
 * @author    Russ Flynn <russ@linpro.no>
 * @copyright 2008 Linpro AS
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 * 
 */
class artworkFile
{
  /**
   * @var ReaktorFile
   */
  protected $_reaktorfile;
  
  /**
   * Parent artwork
   *
   * @var genericArtwork
   */
  protected $_parentartworks = array();

  /**
   * Backtrack which artwork requested this file
   * 
   * @var mixed
   */
  protected $_parentartworkid = null;
  
  /**
   * Whether the file is saved or not
   *
   * @var boolean
   */
  protected $_isunsaved = true;
  
  /**
   * An array of formats allowed when passed to the mimetype functions
   *
   * @var array
   */
  protected $_allowedFormatArray = array("converted", "thumbnail", "original");
  
  
  /**
   * If the file has been rejected, this variable can be set to hold the latest rejected message.
   * It is stored in the reaktor_history table, so it has to be set manually before retrieving it
   * from the object in a template.
   *
   * @var string
   */
  protected $_rejectedMessage = "";
  
  /**
   * The file title, use sparingly as this needs to be extracted from the metadata table
   *
   * @var string
   */
  protected $_title = null;

  /**
   * An array of all the file metadata, populated on the first request for any metadata
   *
   * @var array
   */
  protected $_metadata = null;
  
  /**
   * Whether or not this file has a static (non animated) thumbnail
   * This variable is populated on first request
   *
   * @var boolean
   */
  protected $_hasStaticThumbnail = null;
  
  /**
   * Returns a database resultset that can be used to retrieve one or more files, base on an
   * id, or an array of ids
   *
   * @param mixed $id An integer, or an array of integers
   * 
   * @return Resultset
   */
  static function getResultsetFromIDs($id)
  {
      $c = new Criteria();
      $c->add(ReaktorArtworkFilePeer::FILE_ID, $id, Criteria::IN);
      //$c->addJoin(ReaktorFilePeer::USER_ID, sfGuardUserPeer::ID);
      $res = ReaktorArtworkFilePeer::doSelectJoinAll($c);
      
      if (empty($res))
      {
	      $c = new Criteria();
	      $c->add(ReaktorFilePeer::ID, $id, Criteria::IN);
	      $res = ReaktorFilePeer::doSelectJoinAll($c);
      }
      return $res;
  }
  
  /**
   * Constructor function
   *
   * @param integer        $id             Id of the file object to retrieve, or null to create a new file
   * @param genericArtwork $parentArtwork  Single Parent artwork object if passed
   * @param array          $resultset      Results from a reaktorFile query
   * 
   * @throws Exception
   */
  function __construct($id = null, $parentArtwork = null, $resultset = null)
  {
    if ($id !== null)
    {
    	if (!$id instanceof ReaktorFile)
    	{
	    	sfContext::getInstance()->getLogger()->info("Id was not null");
	      if ($resultset === null)
	      {
	      	sfContext::getInstance()->getLogger()->info("Resultset was empty, asking database to retrieve files");
	      	sfContext::getInstance()->getLogger()->info(get_class($resultset));
	      	$resultset = self::getResultsetFromIDs($id);
	      }
	      if (!empty($resultset) || $id instanceof ReaktorFile)
	      {
	      	foreach ($resultset as $resultsetrow)
	        {
	        	if ($resultsetrow instanceof ReaktorArtworkFile)
	        	{
	        		sfContext::getInstance()->getLogger()->info("I was a ReaktorArtworkFile");
	        		$reaktorfile = $resultsetrow->getReaktorFile();
	        	}
	        	else
	        	{
	        		sfContext::getInstance()->getLogger()->info("No I wasn't");
	        		$reaktorfile = $resultsetrow;
	        	}
		        if ($reaktorfile->getId() == $id)
		        {
		        	break;
		        }
	        }
	      }
    	}
    	else
    	{
    		$reaktorfile = $id;
    	}
      $this->_reaktorfile   = $reaktorfile;
      
      if ($parentArtwork instanceof genericArtwork )
      {
          sfContext::getInstance()->getLogger()->info("I happened");
          $this->_parentartworks[$parentArtwork->getID()] = $parentArtwork;
          $this->setParentArtworkId($parentArtwork->getID());
      }
      elseif ($reaktorfile instanceof ReaktorFile)
      {
      	sfContext::getInstance()->getLogger()->info("Getting New artwork");
        foreach ($reaktorfile->getReaktorArtworkFiles() as $anArtworkFile)
      	{
      	  if ($anArtworkFile->getReaktorArtwork()->getStatus() != ReaktorArtwork::REMOVED)
      	  {
      	    $this->_parentartworks[$anArtworkFile->getReaktorArtwork()->getID()] = new genericArtwork($anArtworkFile->getReaktorArtwork(), null, array(), null, $this);
      	  }
      	}
      }
      else
      {
      	sfContext::getInstance()->getLogger()->info("Nothing happened");
      }
      
      if ($this->_reaktorfile instanceof ReaktorFile)
      {
        $this->_isunsaved  = false;
        $this->_identifier = $this->_reaktorfile->getIdentifier();
      }
      else
      {
        throw new Exception('This file does not exist');
      }
    }
    else
    {
      $this->_reaktorfile = new ReaktorFile();
    }
    
    // If this file format is "crop safe" then we can set it now
    if (in_array($this->getMimetype("thumbnail"), sfConfig::get("app_upload_crop_safe_mime", array())))
    {
      $this->_hasStaticThumbnail = true;
    }
    
    sfContext::getInstance()->getLogger()->info("Finished constructing Reaktorfile");  
  }
  
  /**
   * Saves the file to database
   *
   * @return void;
   */
  function save()
  {
    $this->_reaktorfile->save();
    $this->_isunsaved = false;
  }
  
  /**
   * Returns the current license of the file.
   *
   * @see getMetadata()
   * 
   * @return string
   */
  function getLicense()
  {
  	return $this->getMetadata('license');
  }
  
  /**
   * Get the reason why this file has been reported as unsuitable
   *
   * @return string The unsuitable message as it was sent to the user
   */
  function getRejectedMessage()
  {
    return $this->_rejectedMessage;
  }
  
  /**
   * Set the reason why this file has been reported as unsuitable
   *
   * @param string $message The unsuitable message as it was sent to the user
   * @return boolean
   */
  function setRejectedMessage($message)
  {
    $this->_rejectedMessage = $message;
    return true;
  }
  /**
   * Get subreaktors associated with this file
   *
   * @param boolean $ids Return an array of subreaktor IDs rather than objects
   * 
   * @return array subreaktor references (from subreaktor table)
   */
  function getSubreaktors($ids = false)
  {
    $c = new Criteria();
    $c->add(SubreaktorArtworkPeer::ARTWORK_ID, $this->getId());
   
    $results = SubreaktorArtworkPeer::doSelectJoinSubreaktor($c);
    
    $returnArray = array();
    foreach($results as $result)
    {
      if ($ids)
      {
        $returnArray[] = $result->getSubreaktorId();     
      }
      else
      {
        $returnArray[] = $result->getSubreaktor()->getReference();     
      }
    } 
    return $returnArray;
  }
  
  /**
   * Return the identifier of the file (image, pdf etc)
   *
   * @return string the identifier
   */
  function getIdentifier()
  {
    return $this->_reaktorfile->getIdentifier();
  }
  
  /**
   * Returns the file type, which is the identifier from the location table
   *
   * @return string
   */
  function getFiletype()
  {
    if (isset($this->_identifier))
    {
      $identifier = $this->_identifier;
    }
    else
    {
      $identifier = $this->_reaktorfile->getIdentifier();
    }
    return $identifier;
  }
  
  /**
   * Sets the file path and name
   *
   * @param string $path filename, on disk
   * 
   * @return void
   */
  function setPath($path)
  {
    $this->_reaktorfile->setRealpath($path);
    $this->_isunsaved = true;
  }
  
  /**
   * Marks the current file as unsuitable
   * 
   * @param integer $adminUserId The ID of the user making this change
   * 
   * @return void
   */
  function setUnsuitable($adminUserId, $comment)
  {
    $this->_reaktorfile->setReported(0);
    $this->_reaktorfile->setMarkedUnsuitable(1);
    $this->_reaktorfile->setReportedAt(time());
    TaggingPeer::setTaggingApproved(null, "ReaktorFile", $this, 0);
    ReaktorArtworkHistory::logAction($this->getId(), $adminUserId, $comment, 4, 0, 1);
    
    $this->_isunsaved = true;
  }

  /**
   * Marks the current file as suitable
   * 
   * @param integer $adminUserId The ID of the user making this change
   * 
   * @return void
   */
  function setSuitable($adminUserId)
  {
    $this->_reaktorfile->setMarkedUnsuitable(0);
    TaggingPeer::setTaggingApproved(null, "ReaktorFile", $this, 1);
    HistoryPeer::logAction(2, $adminUserId, $this);
    $this->_isunsaved = true;
  }

  /**
   * Return whether the files is marked as unsuitable or not.
   */
  function isUnsuitable()
  {
    return $this->_reaktorfile->getMarkedUnsuitable();
  }
  
  /**
   * Sets the Thumb name on the system
   *
   * @param string $thumb filename, on disk
   * 
   * @return void
   */
  function setThumbpath($thumb)
  {
    $this->_reaktorfile->setThumbpath($thumb);
    $this->_isunsaved = true;
  }
  
  /**
   * Sets the Original name on the system
   *
   * @param string $name filename, on disk
   * 
   * @return void
   */
  function setOriginalpath($name)
  {
    $this->_reaktorfile->setOriginalpath($name);
    $this->_isunsaved = true;
  }

  /**
   * Sets the file path and name
   *
   * @param string $filename Name of the file
   * 
   * @return void
   */
  function setFilename($filename)
  {
    $this->_reaktorfile->setFilename($filename);
    $this->_isunsaved = true;
  }
  
  /**
   * Returns the order number for this file
   *
   * @return integer
   */
  function getFileOrderPlacement()
  {
    return $this->_reaktorfile->getFileOrder();
  }

  
  /**
   * Set the title of the file
   *
   * @param string $title The title to set
   * 
   * @return void
   */
  function setTitle($title)
  {
    $this->_reaktorfile->setTitle($title);
    $this->_isunsaved = true;
  }
  
  /**
   * Set the "uploaded at" time
   *
   * @param mixed $uploaded_at The time to set
   * 
   * @return void
   */
  function setUploadedAt($uploaded_at)
  {
    $this->_reaktorfile->setUploadedAt($uploaded_at);
    $this->_isunsaved = true;
    
  }
  
    /**
   * Get the "uploaded at" time
   *
   * @param boolean $timestamp Returns a timestamp if true
   * 
   * @return string The date and time the file was uploaded
   */
  function getUploadedAt($timestamp = false)
  {
    if ($timestamp)
    {
      return strtotime($this->_reaktorfile->getUploadedAt());
    }
    else
    {
      return $this->_reaktorfile->getUploadedAt();
    }
  }
  
    /**
   * Get the "modified at" time
   *
   * @param boolean $timestamp Returns a timestamp if true
   * 
   * @return string The date and time the file was last modified
   */
  function getModifiedAt($timestamp = false)
  {
    if ($timestamp)
    {
      return strtotime($this->_reaktorfile->getmodifiedAt());
    }
    else
    {
      return $this->_reaktorfile->getModifiedAt();
    }
  }
  
  /**
   * Set the "modified at" time
   *
   * @param datetime $time the time to set - leave empty for now, uses strtotime
   * 
   * @return void
   */
  function setModifiedAt($time = false)
  {
    if ($time)
    {
      $this->_reaktorfile->setModifiedAt($time);
    }
    else
    {
      $this->_reaktorfile->setModifiedAt(time());
    }
    $this->_isunsaved = true;
  }  
  
  /**
   * Set the file identifier 
   * 
   * @param string $identifier identifier
   * 
   * @return void
   */
  function setIdentifier($identifier)
  { 
    if (!in_array($identifier, sfConfig::get("app_files_location_identifiers")))
    {
      throw new exception ("Unsupported Identifier: ".$identifier);
    }
    
    $this->_reaktorfile->setIdentifier($identifier);
    $this->_isunsaved = true;
  }

  /**
   * Set the file mimetype, based on the mimetype from the file mimetype table
   *
   * @param string $mimetype The mimetype of the file
   * @param string $format   The format we are setting for (converted (d), thumbnail, original)
   * 
   * @return void
   */
  function setMimetype($mimetype, $format = "converted")
  {
    $crit = new Criteria();
    $crit->add(FileMimetypePeer::MIMETYPE, $mimetype);
    $themimetype = FileMimetypePeer::doSelectOne($crit);
    
    if (!$themimetype)
    {
      $themimetype = new FileMimetype();
      $themimetype->setMimetype($mimetype);
      if (!$this->getIdentifier())
      {
        throw new Exception("You must set the identifier before setting a mime type that does not yet exist in the database");
      }
      $themimetype->setIdentifier($this->getIdentifier());
      $themimetype->save();
    }
    
    if ($themimetype instanceof FileMimetype)
    {
      if (in_array(strtolower($format), $this->_allowedFormatArray))
      { 
        $funcToCall = "set".ucfirst($format)."MimetypeId";
      }
      else
      {
        throw new Exception("Invalid format specified");
      }
      $this->_reaktorfile->$funcToCall($themimetype->getId());
    }
    else 
    {
      if (sfContext::getInstance()->getUser()->hasCredential("viewdetailederrors"))
      {
        throw new Exception("Failed when trying to set mime type on file record: Invalid mime type: ".$mimetype);
      }
      throw new Exception("Invalid file type, the upload failed");
    }
    $this->_isunsaved = true;
  }
  
  /**
   * Returns the mimetype of the file
   *
   * @param string $format converted (default), thumb or original
   * 
   * @return string
   */
  function getMimetype($format = "converted")
  {
    if (in_array(strtolower($format), $this->_allowedFormatArray))
    { 
      $funcToCall = "get".ucfirst($format)."MimetypeId";
    }
    else
    {
      throw new Exception("Invalid format specified");
    }
    $mimetype = FileMimetypePeer::retrieveByPK($this->_reaktorfile->$funcToCall());
    return $mimetype instanceof FileMimetype ? $mimetype->getMimetype() : "";
  }
  
  /**
   * Returns the artwork file id
   *
   * @return integer
   */
  function getId()
  {
    return $this->_reaktorfile->getId();
  }
  
  /**
   * Set the user id of the file, to define who uploaded it
   *
   * @param integer $uid The user id to save
   * 
   * @return void
   */
  function setUserId($uid)
  {
    $this->_reaktorfile->setUserId($uid);
  }
  
  /**
   * Returns the user id of the user who submitted the file
   *
   * @return integer
   */
  function getUserId()
  {
    return $this->_reaktorfile->getUserId();
  }
  
  /**
   * Returns the user who submitted the file
   *
   * @return sfGuardUser
   */
  function getUser()
  {
    return $this->_reaktorfile->getSfGuardUser();  
  }
  
  /**
   * Saves the user of the file, to define who uploaded it
   *
   * @param sfGuardUser $user The user to save
   * 
   * @return void
   */
  function setUser($user)
  {
    $this->_reaktorfile->setUserId($user->getId());
  }
  
  /**
   * Stores the given metadata as a tag for the current object
   *
   * @param string $element   The metadata element to save
   * @param string $qualifier The metadata qualifier to save, or null to nut specify qualifier
   * @param mixed  $value     The metadata value to save
   *
   * @return nothing
   * 
   * @throws Exception
   */
  function addMetadata($element, $qualifier = null, $value)
  {
    $element   = strtolower($element);

    $qualifier = !$qualifier ? null : strtolower($qualifier);
    if ($this->_isunsaved)
    {
      throw new Exception('You cannot add metadata to an unsaved file. Please save the file first.');
    }
    try
    {
      if ($this->getMetadata($element, $qualifier) !== false )
      {
        $crit = new Criteria();
        $crit->add(FileMetadataPeer::META_ELEMENT, $element);
        $crit->add(FileMetadataPeer::FILE, $this->getId());
        if ($qualifier != null)
        {
          $crit->add(FileMetadataPeer::META_QUALIFIER, $qualifier);
        }
        $updatedMetadata = FileMetadataPeer::doSelectOne($crit);
        $updatedMetadata->setMetaValue($value);
        $updatedMetadata->save();
        if($this->_metadata)
        {
          $this->_metadata[$element][$qualifier] = $value;
        }
      }
      else
      {
        $newMetadata = new FileMetadata();
        $newMetadata->setFile($this->_reaktorfile->getId());
        $newMetadata->setMetaElement($element);
        if ($qualifier != null)
        {
          $newMetadata->setMetaQualifier($qualifier);
        }
        $newMetadata->setMetaValue($value);
        $newMetadata->save();
      }
    }
    catch (Exception $e)
    {
      throw $e;
    }
    // The data has changes so let's update the holder
  }
  
  /**
   * Returns an array of FileMetadata objects of all metadata associated with that file
   * Also populates the metadata array so we can access the values later if loaded
   *
   * @param $returnArray            Returns an array, rather then objects, of metadatas
   * @return array|FileMetadata
   */
  function getMetadatas($returnArray = true)
  {
    $c = new Criteria();
    $c->addAscendingOrderByColumn(FileMetadataPeer::META_ELEMENT);
    $c->addAscendingOrderByColumn(FileMetadataPeer::META_QUALIFIER);
    
    if (!$returnArray)
    {
      return $this->_reaktorfile->getFileMetadatas($c);
    }
    elseif (!$this->_metadata)
    {
      foreach($this->_reaktorfile->getFileMetadatas($c) as $metadataObject)
      {
        $this->_metadata[$metadataObject->getMetaElement()][$metadataObject->getMetaQualifier()] = $metadataObject->getMetaValue();
      }
    }

    return $this->_metadata;
  }
  
  /**
   * Returns a FileMetadata object which has the specified $element and $qualifier
   *
   * @param string $element   The element item to get
   * @param string $qualifier The qualifier to get or empty string if none is set
   * 
   * @return string
   */
  function getMetadata($element, $qualifier = "")
  {
    $element   = strtolower($element);
    $qualifier = ($qualifier == null) ? null : strtolower($qualifier);
    
    if (is_null($this->_metadata))
    {     
      $this->getMetadatas(); 
    }
    
    if (isset($this->_metadata[$element][$qualifier]))
    {
      return $this->_metadata[$element][$qualifier];
    }
    
    return false;
  }
  
  /**
   * Set/Return the title from the metadata table
   *
   * @return string
   */
  public function getTitle()
  {
    if (is_null($this->_title))
    {
      $this->_title = $this->getMetadata("title");
    }
    return $this->_title;
  }
  
  /**
   * Returns whether the file has been reported as unsuitable or not
   *
   * @return boolean
   */
  function isReported()
  {
    return ($this->_reaktorfile->getReported() == 0) ? false : true;
  }

  /**
   * Get embed link to the current file.
   *
   * @param int|artworkFile $file The file or file id
   * 
   * @return string  $url 
   */
  function getEmbedLink()
  {
    return $this->_reaktorfile->getEmbedLink($this);
  }
  
  /**
   * Return the tally for the number of times this has been reported
   * since the last time it was marked ok
   *
   * @return integer
   */
  function getReportedCount()
  {
    return $this->_reaktorfile->getReported();
  }
  
  /**
   * Return the tally for the number of times this has even been reported
   *
   * @return integer
   */
  function getTotalReportedCountEver()
  {
    return $this->_reaktorfile->getTotalReportedEver();
  }
  
  /**
   * Return when the file was last reported
   *
   * @return date
   */
  function getReportedAt()
  {
    return date("d/m/y H:i", strtotime($this->_reaktorfile->getReportedAt()));
  }
  
  /**
   * Reports the file as unsuitable (User does this not admin)
   *
   * @param integer|sfGuardUser $user The user reporting the file
   * 
   * @return void
   */
  function reportAsUnsuitable($user)
  {
    $this->_reaktorfile->setReported($this->_reaktorfile->getReported() + 1);
    $this->_reaktorfile->setTotalReportedEver($this->_reaktorfile->getTotalReportedEver() + 1);
    $this->_reaktorfile->setReportedAt(time());
    $this->_reaktorfile->save();
    
    HistoryPeer::logAction(1, $user, $this);
  }
  
  /**
   * Restores the file to a clean state (unreported)
   *
   * @param integer|sfGuardUser $user User id or object
   * 
   * @return void
   */
  function reportAsSuitable($user)
  {
    $this->_reaktorfile->setReported(0);
    $this->_reaktorfile->setMarkedUnsuitable(0);
    $this->_reaktorfile->save();
    
    HistoryPeer::logAction(2, $user, $this);      
  }
  
  /**
   * Marks the file as unsuitable (not just reporting it)
   *
   * @param integer|sfGuardUser $user User id or object
   */
  function markAsUnsuitable($user)
  {
    $this->_reaktorfile->setMarkedUnsuitable(1);
    $this->_reaktorfile->save();
    
    HistoryPeer::logAction(3, $user, $this);      
  }
    
  /**
   * Tags the artwork with the given tag
   *
   * @param string $tag The tag to add
   * 
   * @return void
   */
  function addTag($tag)
  {
    return $this->addOrRemoveTag($tag, "add");
  }
  
  /**
   * Remove the given tag from the file and (optional) linked files
   * If they are category tags only, since it will affect the whole artwork
   *
   * @param string  $tag The tag to remove
   *  
   * @return void
   */
  function removeTag($tag)
  {
    return $this->addOrRemoveTag($tag, "remove");
  }
  
  /**
   * The add and remove tag functions are very similar, so created this to prevent code duplication
   *
   * @param string  $tag             The tag to add
   * @param boolean $recursive       If true adds to linked files also
   * @param boolean $approve         Instantly approve the tag/tagging
   * @param array   $categoryMatches Used in recursive functions to save queries
   * @param string  $mode            Called internally, add or remove
   * 
   * @return void just does the job
   */
  protected function addOrRemoveTag($tag, $mode)
  {
    switch ($mode)
    {
      case "add":
        sfContext::getInstance()->getLogger()->info("Adding tag: ".$tag);
        $this->_reaktorfile->addTag($tag);
        TagPeer::setTagWidthByName($tag);
        break;
      case "remove":
        sfContext::getInstance()->getLogger()->info("Removing tag: ".$tag." from ".$this->getId());
        $this->_reaktorfile->removeTag($tag);
        break;
      default:
        throw new exception ("Mode not handled");
        break;
    }    
    $this->_reaktorfile->save();
    $this->updateTagMetadata();
  }
  
  /**
   * Function to update the "subject" meta element of a file's metadata
   * for Dublin core purposes - should be run every time tags on a file are changed or tags are
   * approved/unapproved, in which case all files with those tags will need to be updated. This will only
   * ever affect a small number of files so is not a problem.
   * 
   * @return null
   */
  public function updateTagMetadata()
  {
    $tagArray  = $this->getTags(false);
    $tagString = !empty($tagArray) ? implode(", ", $tagArray) : "";
    $this->addMetadata("subject", null, $tagString);
    
    // We need to clear the tag lists of all the parent artworks since they have just changed
    foreach ($this->getParentArtworks() as $artwork)
    {
      reaktorCache::delete("artwork_tag_list_".$artwork->getId());
    }
  }
  
  /**
   * Removes all tags from the file
   * 
   * @return void
   */
  function removeAllTags()
  {
    $this->_reaktorfile->removeAllTags();
    $this->updateTagMetadata();
  }

  /**
   * Returns the number of tags
   *
   * @param bool $include_unapproved
   * @return int
   */
  public function countTags($include_unapproved = true)
  {
    return count($this->getTags($include_unapproved));
  }
  
  /** Returns all the tags attached to this file
   * 
   * @param boolean $includeUnapproved show unapproved also
   * @param boolean $returnObjects     return tag objects instead of tag names
   * 
   * @return array the name field from tag entry
   */ 
  function getTags($includeUnapproved = false, $returnObjects = false)
  {
    $tags_arr = array();
    
    $c = new Criteria();
    if ($includeUnapproved == false)
    {
      $c->add(TagPeer::APPROVED, 1);
    }
    $c->add(TaggingPeer::TAGGABLE_ID, $this->getId());
    $c->add(TaggingPeer::TAGGABLE_MODEL, "ReaktorFile");
    $c->addJoin(TagPeer::ID, TaggingPeer::TAG_ID);
    
    $tagObjectArray = TagPeer::doSelect($c);
    if ($returnObjects)
    {
      return $tagObjectArray;
    }
    
    foreach ($tagObjectArray as $tagObject)
    {
      $tags_arr[] = $tagObject->getName();
    }
   
    return $tags_arr;
  }
  
  /**
   * Returns the filename
   *
   * @return string
   */
  function getFilename()
  {
    return $this->_reaktorfile->getFilename();
  }
  
  /**
   * Returns the filename on the hard disk
   *
   * @return string
   */
  function getRealpath()
  {
    return $this->_reaktorfile->getRealpath();
  }

  /**
   * Returns the thumbnail filename on the hard disk or the complete path
   *
   * @param boolean $absolute if true, return the full path to the file on disk
   * 
   * @return string
   */
  function getThumbpath($absolute = false)
  {
    if ($absolute)
    {
      $path  = sfConfig::get('sf_root_dir')."/".sfConfig::get('app_upload_upload_dir')."/";
      $path .= $this->getIdentifier()."/thumbnail/".$this->_reaktorfile->getThumbPath();
    }
    else
    {
      $path = $this->_reaktorfile->getThumbPath();
    }
    return $path;
  }
  
  /**
   * Returns the original filename on the hard disk
   *
   * @return string
   */
  function getOriginalpath()
  {
    return $this->_reaktorfile->getOriginalPath();
  }
  
  /**
   * Returns the path to the real file on the filesystem
   *
   * @param string  $type    The type to return default is normal (thumb, full, etc)
   * @param boolean $dirOnly Set trur to return just the directory and not the file name
   */
  function getFullFilePath($type = "normal", $dirOnly = false)
  {
    $basePath = sfConfig::get("sf_root_dir")."/".sfConfig::get("app_upload_upload_dir")."/".$this->getIdentifier()."/";
 
    switch ($type)
    {
      case "normal":
        $subdirs = "";
        $filename = $this->getRealpath();
        break;
      case "thumb":
        $subdirs = "thumbnail/";
        $filename = $this->getThumbpath();
        break;
      case "mini":
        $subdirs = "thumbnail/mini/";
        $filename = $this->getThumbpath();
        break;
      case "original":
        $subdirs = "original/";
        $filename = $this->getOriginalpath();
        break;
      default:
        throw new Exception("Unsupported type");
        break;
    }
    if ($dirOnly)
    {
      return $basePath.$subdirs;
    }
    else
    {
      return $basePath.$subdirs.$filename;      
    }
  }
  
  /**
   * Checks whether this file is linked to any artwork already
   *
   * @return boolean
   */
  function hasArtwork()
  {
    if (!empty($this->_parentartworks))
    {     
      return true;
    }
    else
    {
      return false;
    }
  }
  
  /**
   * Returns the artwork objects that are parents to this file
   * It may be possible to use files with more than one artwork at
   * some point
   * 
   * @param boolean $ids Whether to return just an array of IDs
   * 
   * @return genericArtwork
   */
  function getParentArtworks($ids = false)
  {
    if (!is_array($this->_parentartworks))
    {
      throw new Exception("Artwork array does not exist");
    }
    if ($ids)
    {
      $resultArray = array();
      foreach ($this->_parentartworks as $artwork)
      {
        $resultArray[] = $artwork->getId();
      }
      return $resultArray;
    }
    return $this->_parentartworks;
  }
  
  /**
   * Return how many artworks this file is part of
   *
   * @return integer
   */
  public function countParentArtworks()
  {
    return count($this->_parentartworks);
  }
  
  /**
   * Temporary function so things don't break during refactoring
   * 
   * @return genericArtwork
   */
  function getParentArtwork()
  {
    if (!is_array($this->_parentartworks))
    {
      throw new Exception("Artwork array does not exist");
    }
    else
    {
      // Return first element only
      reset($this->_parentartworks);
      return current($this->_parentartworks);
    }
  }

  /**
   * Make it possible to backtrack which artwork is working with the file
   * 
   * @param mixed $id The parent artwork ID
   * @return void
   */
  function setParentArtworkId($id)
  {
    $this->_parentartworkid = (int)$id;
  }

  /**
   * Completely delete a file from the database, along with it's hard copies
   *
   * @return void
   */
  public function deleteFile()
  {
    $baseDir  = $this->getFullFilePath();
    $file     = $baseDir.$this->getRealpath();
    $thumb    = $baseDir."thumbnail/".$this->getThumbpath();
    $mini     = $baseDir."thumbnail/mini/".$this->getThumbpath();
    $original = $baseDir."original/".$this->getOriginalpath();
    
    // Check for related artwork, is this the only file?
    if ($this->hasArtwork())
    {
      try
      {
        $parentArtworks = $this->getParentArtworks();
        
        // Remove this file from the artwork
        foreach ($parentArtworks as $parentArtwork)
        {
          $parentArtwork->removeFile($this);
        }
      }
      catch (Exception $e)
      {
        throw new exception($e->getMessage());
      }
    }
    try
    {
      $this->_reaktorfile->delete();
      $this->removeAllTags();
    }
    catch (Exception $e)
    {
      throw new exception($e->getMessage());
    }
    
    if (file_exists($file))
    {
      unlink($file);
    }
    if (file_exists($thumb))
    {
      unlink($thumb);
    }
    if (file_exists($mini))
    {
      unlink($mini);
    }
    if (file_exists($original))
    {
      unlink($original);
    }
    
    // Clean up metadata
    $this->removeAllMeta();
  }

  /**
   * Remove all meta data attached to file as part of clean up process
   *
   * @return void
   */
  public function removeAllMeta()
  {
    $c = new Criteria();
    $c->add(FileMetadataPeer::FILE, $this->getId());
    FileMetadataPeer::doDelete($c);
  }
  
  /**
   * Returns true if this is an image file
   *
   * @return void
   */
  public function isImage()
  {
    if ($this->_reaktorfile->getIdentifier() == "image")
    {
      return true;
    }
    return false;
  }
  
  /**
   * Return the taggable model string to use in the tagging table
   *
   * @return string
   */
  public function getTaggableModel()
  {
    return "ReaktorFile";
  }
  
  /**
   * Return whether the file is under discussion or not
   *
   * @return boolean Typecast in case caller is using strict checks
   */
  public function isUnderDiscussion()
  {
    return (bool)$this->_reaktorfile->getUnderDiscussion();
  }
  
  /**
   * Mark this file as under discussion
   *
   * @return void
   */
  public function markUnderDiscussion()
  {
    $this->_reaktorfile->setUnderDiscussion(1);
    $this->_reaktorfile->save();
    HistoryPeer::logAction(6, sfContext::getInstance()->getUser()->getId(), $this);
  }
  
  public function markNotUnderDiscussion()
  {
    $this->_reaktorfile->setUnderDiscussion(0);
    $this->_reaktorfile->save();
    HistoryPeer::logAction(7, sfContext::getInstance()->getUser()->getId(), $this);
  }
  
 /**
   * Get by who and when the file was marked for discussion last.
   *
   * @return History 
   */
  public function getDiscussionInfo()
  {
    return HistoryPeer::getAction(6, $this);
  }
  
  
  /**
   * Get number of comments an file has
   *
   * @param unknown_type $namespace
   * @return unknown
   */
  public function getCommentCount($namespace)
  {
    return $this->_reaktorfile->getCommentCount($namespace);
  }
  
  /**
   * Return the reaktor file object that we are working with
   *
   * @return reaktorFile
   */
  public function getBaseObject()
  {
    return $this->_reaktorfile;
  }
  
  /**
   * This is required by the RSS plugin to generate the correct artwork route automatically
   * Since sf_culture is a required parameter, the feed parameter looks for this function in the object automatically
   * 
   * @return string the culture provided in the url (if any)
   */
  public function getFeedSfCulture()
  {
    return sfContext::getInstance()->getRequest()->getParameter('sf_culture', 'no');      
  }
  
  /**
   * Return the parent artwork Id rather than the comment Id
   * This is so the link back to the artwork is correct
   *
   * @return integer the artwork ID
   */
  public function getFeedId()
  {
    return $this->getParentArtwork()->getId();
  }

  /**
   * For the Artwork file feed
   *
   * Returning null lets the sfFeed classess create an IRI so we don't have to 
   * do magic stuff here.
   * 
   * @return void
   */
  public function getUniqueId() {
    return null;
  }
  
  /**
   * Return the feed description for use in the RSS body
   *
   * @return string description from parent artwork object
   */
  public function getFeedDescription()
  {
    return $this->getMetadata('description', 'abstract');
  }
  
  /**
   * Return the file title for use in the RSS
   *
   * @return string dash separated title of parent artwork and current title
   */
  public function getFeedTitle()
  {
    $parentTitle = $this->getParentArtwork()->getTitle();
    if ($parentTitle != $this->getTitle())
    {
      return $parentTitle.' - '.$this->getTitle(); 
    }
    
    return $parentTitle;
  }

  /**
   * Returns the link to the current artworkfile under correct artwork
   * 
   * @return void
   */
  public function getFeedLink()
  {
    foreach($this->getParentArtworks() as $parent)
    {
      if ($parent->getId() == $this->_parentartworkid)
      {
        //return "@show_artwork_file?id={$parent->getId()}&file={$this->getId()}&title={$parent->getTitle()}";
      }
    }
    // Fallback to the last parent
    return "@show_artwork_file?id={$parent->getId()}&file={$this->getId()}&title={$parent->getTitle()}";
  }
  
  /**
   * The ID required for the routing
   *
   * @return integer the file id
   */
  public function getFeedFile()
  {
    return $this->getId();
  }
  
  /**
   * Get the provided subreaktor for Feed generator
   *
   * @return subreaktor|null
   */
  public function getFeedSubreaktor()
  {
    if (subreaktor::isValid())
    {
      return Subreaktor::getProvided();
    }
  }

  /**
   * Generate url to a thumbnail
   * 
   * @return void
   */
  public function getUrl()
  {
    return sfContext::getInstance()->getController()->genUrl("@content_thumb?id={$this->getId()}&filename={$this->getFilename()}", true);
  }
  public function getLength()
  {
  }
  
  /**
   * Whether the file has been hidden or not
   *
   * @return boolean true if the file has been hidden by the user (they think it has been deleted)
   */
  public function isHidden()
  {
    return (bool) $this->_reaktorfile->getHidden();
  }
  
  /**
   * Sets a file as hidden (user deleted)
   * 
   * @return null
   */
  public function setHidden()
  {
    $this->_reaktorfile->setHidden(1);
    // We need to check artworks that this file is associated with, and disable the ones that have no files now
    foreach($this->getParentArtworks() as $artwork)
    {
      $artwork->removeFile($this);
    }
  }
  
  /**
   * Unhide a file
   * 
   * @return null
   */
  public function setUnhidden()
  {
    $this->_reaktorfile->setHidden(0);
  }


  public function isDeleted(){
	return $this->_reaktorfile->getDeleted();
  }


  /**
   * Fill inn metadataholder but do not store in database. Useful when update form
   * errs, and we need to display the already entered values, but do not want to store it yet.
   *
   * @param string $element
   * @param string $qualifier
   * @param mixed $value
   */
  public function fillinMetaData($element, $qualifier = null, $value)
  {
    if (!$this->_metadata)
    {
      $this->getMetadatas();
    }
      $this->_metadata[$element][$qualifier] = $value;
  }
  
  /**
   * Get the people who have reported the artwork
   *
   * @return array an array of user objects
   */
  public function getReportHistory()
  {
    if (!$this->isReported())
    {
      return array();
    }
    return HistoryPeer::getByObjectAndAction($this, 1, $this->getReportedCount());
  }
  
  /**
   * Return the name of the database table where these objects are stored
   *
   * @return string
   */
  public function getTableName()
  {
    return "reaktor_file";
  }

  public function getFeedPubdate() {
      return strtotime($this->_reaktorfile->getModifiedAt());
  }
  
  /**
   * Returns true if the thumbnail for this file is NOT animated
   * this is safer than the opposite, since we want to err on the side of caution
   *
   * return boolean
   */
  public function hasStaticThumbnail()
  {
    if (is_bool($this->_hasStaticThumbnail))
    {
      return $this->_hasStaticThumbnail;
    }
    else
    {
      $framesInThumb = exec("identify -format '%n' ".$this->getThumbpath(true), $output, $code);
      if (!empty($output))
      {
        if (is_numeric($output[0]))
        {
          $allTheFrames[0] = $output[0];
        }
        else
        {
          $allTheFrames = explode("'", substr($output[0], 1));
        }
        if ($allTheFrames[0] == 1)
        {
          $this->_hasStaticThumbnail = true;
          return true;
        }
        $this->_hasStaticThumbnail = false;
        return false;
      }
    }
  }
}

