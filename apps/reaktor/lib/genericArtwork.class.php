<?php
/**
 * Generic artwork class, the entry point for actions relating to
 * a piece of artwork on the system
 *  
 * PHP version 5
 * 
 * @package   Reaktor
 * @author    Daniel Andre Eikeland <dae@linpro.no>
 * @author    Russ Flynn <russ@linpro.no>
 * @copyright 2008 Linpro AS
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 */

  require_once SF_ROOT_DIR . DIRECTORY_SEPARATOR . 'lib/model/om/BaseReaktorArtworkFile.php';
  require_once SF_ROOT_DIR . DIRECTORY_SEPARATOR . 'lib/model/om/BaseArtworkStatus.php';
  require_once SF_ROOT_DIR . DIRECTORY_SEPARATOR . 'lib/model/ReaktorArtworkFile.php';
  require_once SF_ROOT_DIR . DIRECTORY_SEPARATOR . 'lib/model/ArtworkStatus.php';
  require_once SF_ROOT_DIR . DIRECTORY_SEPARATOR . 'lib/model/om/BaseReaktorArtworkFilePeer.php';
  require_once SF_ROOT_DIR . DIRECTORY_SEPARATOR . 'lib/model/om/BaseArtworkStatusPeer.php';
  require_once SF_ROOT_DIR . DIRECTORY_SEPARATOR . 'lib/model/ReaktorArtworkFilePeer.php';
  require_once SF_ROOT_DIR . DIRECTORY_SEPARATOR . 'lib/model/ArtworkStatusPeer.php';
  require_once SF_ROOT_DIR . DIRECTORY_SEPARATOR . 'lib/model/TaggingPeer.php';
  
/**
 * Generic artwork class
 * 
 * To use this class, instantiate a new instance of this class, with either 
 * a numeric $id to load an existing artwork, or a title to create a new one 
 * 
 * Loading an existing artwork:
 * $example_artwork = new genericArtwork(1);
 * 
 * Creating a new artwork:
 * $example_artwork = new genericArtwork(null, genericArtwork::IMAGE);
 * or
 * $example_artwork = new genericArtwork('My fine artwork', genericArtwork::IMAGE);
 *  
 * Set the user id on the new artwork, either by ID
 * $example_artwork->setUserId(1);
 * or by pointing to the sfUser object
 * $example_artwork->setUser($sf_user->getGuardUser());
 * 
 * Set the title of the artwork (can be ommited if used in the constructor)
 * $example_artwork->setTitle('My fine artwork');
 * 
 * Now, save the artwork so that it is stored
 * $example_artwork->save();
 * 
 * Now you can add metadata or files to it. Format metadata is a stupid example, since this should be stored
 * with the artwork in the database, but you should still get how it works from this example
 * $example_artwork->addMetadata('format', 'jpg');
 * 
 * @package    Reaktor
 * @subpackage Artwork
 * @author     Daniel Andre Eikeland <dae@linpro.no>
 * @author     Russ Flynn <russ@linpro.no>
 * @copyright  2008 Linpro AS
 * @license    http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 *  
 */

class genericArtwork
{
  /**
   * Attribute to define which kind of artwork this is
   *
   * @var integer
   */
  protected $_artworkType;
  
  /**
   * Filename of the stored artwork, relative to the media folder
   *
   * @var string
   */
  protected $_realfilename;
  
  /**
   * Filename of the file as accessible from the web, could be different from the 
   * actual file path on disk
   *
   * @var string
   */
  protected $_downloadablefilename;
  
  /**
   * Link to artwork
   *
   * @var unknown_type
   */
  protected $_link;
  
  /**
   * The item id used when retreiving related data, such as metadata
   *
   * @var integer
   */
  protected $_itemid = 0;
  
  /**
   * Points to the artwork stored in the artwork table
   *
   * @var ReaktorArtwork
   */
  protected $_artwork;
  
  protected $_tags_arr = null;
  
  public $_artworkUserObject;
  
  /**
   * Points to the history table
   *
   * @var ReaktorArtwork
   */
 //protected $_history;
  
  
  /**
   * Checks whether or not this artwork exists in the database
   *
   * @var boolean
   */
  protected $_isunsaved = true;
  
  /**
   * Array of all the files in the artwork
   *
   * @var array
   */
  protected $_files = array();
  protected $_numfiles = 0;
  
  /**
   * Array of under discussion files - set in populatefiles function
   *
   * @var array Array of the files under discussion
   */
  protected $_filesUnderDiscussion = array();
  
  /**
   * Whether all the files in this artwork are transcoded or not, saved to prevent multiple requests since
   * this hits the hard disk
   *
   * @var boolean
   */
  protected $_isTranscoded = null;
  
  const IMAGE           = 'image';
  const VIDEO           = 'video';
  const AUDIO           = 'audio';
  const TEXT            = 'text';
  const GALLERY         = 'gallery';
  const COLLECTION      = 'collection';
  const PDF             = 'pdf';
  const FLASH_ANIMATION = 'flash_animation';
  
  /**
   * Creates a constructor connection object that can be used to load multiple images
   *
   * @param unknown_type $id
   * @param unknown_type $options
   */
  static function getResultsetFromIDs($id, $options = array())
  {
    $crit = new Criteria();
    if (isset($options['isfileid']))
    {
    	$crit->add(ReaktorArtworkFilePeer::FILE_ID, $id, Criteria::IN);
    	$crit->addAscendingOrderByColumn(ReaktorArtworkFilePeer::FILE_ORDER);
	    if (!sfContext::getInstance()->getUser()->hasCredential("editusercontent"))
	    {
	      $crit->add(ReaktorFilePeer::HIDDEN, 0);
	    }
      $resultset = ReaktorArtworkFilePeer::doSelectJoinAll($crit);
      $id = array();
      foreach ($resultset as $result)
      {
      	$id[] = $result->getReaktorArtwork()->getId();
      }
    }
    $crit = new Criteria();
    $crit->add(ReaktorArtworkPeer::ID, $id, Criteria::IN);
    $resultset = ReaktorArtworkPeer::doSelectJoinAll($crit);
    
    return $resultset;
  }
  
  /**
   * Initializes the artwork and loads the necessary data
   *
   * @param integer|string|reaktorArtwork $id ID of the artwork to load, or the title of the new 
   *                                          artwork that will be created. If empty, you must set the title later
   * @param string         $type The artwork type, defined by constant in this class
   * 
   * @throws Exception
   */
  function __construct($id = null, $type = null, $options = array(), $resultset = null, $passedFile = null)
  {
  	if ($id instanceof genericArtwork)
  	{
  		throw new Exception('Why would you pass a genericartwork to a genericartwork constructor?? That doesn\'t make sense ...!');
  	}
  	if (is_numeric($id) || $id instanceof ReaktorArtwork)
    {
    	$itemid = ($id instanceof ReaktorArtwork) ? $id->getId() : $id;
      sfContext::getInstance()->getLogger()->info("Constructing artwork with ID: ".$itemid);
    	if ($resultset === null && !$id instanceof ReaktorArtwork)
    	{
    		$resultset = self::getResultsetFromIDs($id, $options);
    	}
      $cc  = 0;
      if (!$resultset && !$id instanceof ReaktorArtwork)
      {
        sfContext::getInstance()->getLogger()->info("Artwork with ID: ".$itemid." does not exist");
      	throw new exception ("Artwork does not exist");
      }
      if ($id instanceof ReaktorArtwork)
      {
      	$this->_artwork = $id;
      }
      elseif (is_array($resultset))
      {
	      foreach ($resultset as $r)
	      {
	        if (!$r instanceof ReaktorArtwork)
	        {
	        	throw new Exception('If you\'re passing a resultset to the genericArtwork constructor, it needs to be an array of results from reaktorartworkfile::doSelect...()');
	        }
	        if ($r->getId() == $id)
	        {
		      	$cc++;
	          if (!$this->_artwork instanceof ReaktorArtwork)
	          {
	            $this->_artwork = $r;
	          }
		      	/*$this->_files[$r->getFileId()] = $r->getFileId(); // new artworkFile($r->getReaktorFile(), $this);
		        $this->_numfiles = $cc;*/
	        }
	      }
      }
      else
      {
      	sfContext::getInstance()->getLogger()->info("Cannot use " . get_class($resultset) . " as resultset");
        throw new Exception("Unhandled result set: ".get_class($resultset));
      }
      
      if ($this->_numfiles == 0 && $passedFile instanceof ReaktorFile)
      {
      	$this->_numfiles = 1;
      	$this->_files[$passedFile->getId()] = $passedFile;
      }
      
      if (count($this->_files) > 0)
      {
        sfContext::getInstance()->getLogger()->info("Found Lots of files: ".count($this->_files));
	      if ($resultset instanceof ReaktorArtworkFile)
	      {
	        $fileconn = $resultset;
	      }
	      else
	      {
	      	$fileconn = artworkFile::getResultsetFromIDs($this->_files);
	      }
      	foreach ($this->_files as &$file)
	      {
	      	if ($passedFile instanceof artworkFile && $file == $passedFile->getId())
	      	{
	      	  sfContext::getInstance()->getLogger()->info("Found passed file: ".$passedFile->getId());
	      	  $file = $passedFile;
	      	}
	      	else
	      	{
  	        sfContext::getInstance()->getLogger()->info("Looping with File: ".$file);      
  	      	$file = new artworkFile($file, $this, $fileconn);
	      	}
	      }
      }
      $this->_itemid    = $this->_artwork->getId();
      $this->_isunsaved = false;
    }
    else
    {
    	sfContext::getInstance()->getLogger()->info("Constructing brand new artwork");
      $this->_artwork = new ReaktorArtwork();
      if ($id != null)
      {
        $this->_artwork->setTitle($id);
      }

      if ($type) 
      {
        $this->setArtworktype($type);
      }
      $this->_artwork->setStatus(ReaktorArtwork::DRAFT);
      $this->_artwork->setCreatedAt(time());
      $defaultTeam = sfGuardGroupPeer::retrieveByName(sfConfig::get("app_editorial_team_default", "deichman_redaksjon"));
      $this->setEditorialTeam($defaultTeam);
      sfContext::getInstance()->getLogger()->info("Created artwork with ID: ".$this->_artwork->getId());
    }
    
    if (!$this->_artwork instanceof ReaktorArtwork)
    {
      sfContext::getInstance()->getLogger()->info("An unknown error occured");
    	$error_msg = (is_numeric($id)) ? 'This artwork does not exist' : 'Error creating new artwork';
      throw new Exception($error_msg);
    }
    $this->_artworkType       = $this->_artwork->getArtworkIdentifier();
    $this->_artworkUserObject = $this->_artwork->getUserId(); // s fGuardUser(); // sfGuardUserRelatedByUserId(); //sfGuardUserPeer::retrieveByPK($this->_artwork->getUserId());
  }

  /**
   * Get link to artwork.
   * Which file in the artwork that is be displayed on top can be sent in
   * as a parameter. Useful in artworks with more than one file.
   *
   * @param string  $mode    The mode
   * @param integer $file_id The file ID
   * @param boolean $external Format the URL correctly, useful for functional testing 
   * 
   * @return string  $url 
   */
  function getLink($mode = 'show', $file_id = null, $external = false, $nocache = false)
  {
    $cachekey = 'artwork_link_' . $this->getId() . '_' .$file_id.'_'.$external.'_'.$mode . '_' .Subreaktor::getProvidedIfValid();
    $cache = reaktorCache::singleton($cachekey);
    if (!($linkstring = $cache->get()) || $nocache)
    {
	  	$subreaktorlinktext = '';
	  	if (Subreaktor::isValid())
	    {
	      if (Subreaktor::getProvidedLokalreaktor() instanceof Subreaktor)
	      {
	        if (!in_array(Subreaktor::getProvidedLokalReference(), $this->getLokalreaktors()))
	        {
	        	$lr = $this->getLokalreaktors(true);
	        	$lr = array_shift($lr);
	        	$subreaktorlinktext = $lr;
	        }
	      }
	      if (Subreaktor::getProvidedSubreaktor() instanceof Subreaktor)
	      {
	        if (!in_array(Subreaktor::getProvidedSubreaktorReference(), $this->getSubreaktors()))
	        {
	          $sr = $this->getSubreaktors(true, array('subreaktor'));
	          $sr = array_shift($sr);
	          if ($subreaktorlinktext != '') $subreaktorlinktext .= '-';
	          $subreaktorlinktext .= $sr;
	        }
	      }
	    }
	    if ($subreaktorlinktext != '') $subreaktorlinktext = '&subreaktor=' . $subreaktorlinktext;
	  	$linkstring = $this->_artwork->getLink($mode, $file_id, $external) . $subreaktorlinktext;
	  	$cache->set($linkstring);
    }
  	
  	return $linkstring;
  }
  
  /**
   * Returns true if the artwork is one of the allowed text based artwork types
   * Useful when making collections that can allow different types of text file (pdf/text for example) 
   *
   * @return boolean true if artwork is text based
   */
  function isTextBased()
  {
    $textBasedTypes = array(self::TEXT, self::PDF);
    
    return (bool) (in_array($this->getArtworkType(), $textBasedTypes));
  }
  
  function clearLinkCache()
  {
  	$cachekey = 'artwork_link_' . $this->getId() . '_';
  	reaktorCache::deleteSimilar($cachekey);
  }
  
  /**
   * Set the time for when the artwork was submitted
   *
   * @param timestamp $time The time it was created
   * 
   * @return void The created time is set
   */
  function setCreatedAt($time = null)
  {
    $time = ($time == null) ? time() : $time;
    $this->_artwork->setCreatedAt($time);
  }
  
  /**
   * Returns the time when the artwork was created
   *
   * @return string
   */
  function getCreatedAt()
  {
    return $this->_artwork->getCreatedAt();
  }
  
  /**
   * Returns the average rating
   *
   * @return float
   */
  function getAverageRating()
  {
  	return $this->_artwork->getAverageRating();
  }

  /**
   * Return who changed the status of the artwork last
   *
   * @param boolean $return_id Return the user if of approving user
   * 
   * @return string Approved by name
   */
  function getActionedBy($return_id = true)
  {
    static $usernames = array();
    if ($return_id)
    {
      return $this->_artwork->getActionedBy();
    }

    $id = $this->_artwork->getActionedBy();
    if (isset($usernames[$id]))
    {
      return $usernames[$id];
    }
    $user = sfGuardUserPeer::retrieveByPK($id);

    if ($user)
    {
      $usernames[$id] = reaktorQuickStorage::set("USERNAME_$id", $user->__toString());
      return $usernames[$id];
    }
    return __('none');
  }
  
  /**
   * Return date and time when the artwork status last changed.
   *
   * @return date Status change date
   */
  function getActionedAt()
  {
  
    return $this->_artwork->getActionedAt();    
  }
  
  /**
   * Set the time for when the artwork was submitted
   *
   * @param timestamp $time The time it was submitted
   * 
   * @return void Sets the submitted at time
   */
  function setSubmittedAt($time = null)
  {
    $time = ($time == null) ? time() : $time;
    $this->_artwork->setSubmittedAt($time);
  }

   /**
   * Returns the time when the artwork was submitted
   *
   * @return string
   */
  function getSubmittedAt()
  {
    return $this->_artwork->getSubmittedAt();
  }
    
  /**
   * Returns the artwork status
   * 
   * @param boolean $return_id Return ID rather than object
   * 
   * @return mixed id or description of status
   */
  function getStatus($return_id = true)
  {
    if ($return_id)
    {
      return $this->_artwork->getStatus();
    }
    else
    {
      $statusId      = $this->_artwork->getStatus();
      $artworkStatus = artworkStatusPeer::retrieveByPK($statusId);
      
      if ($artworkStatus)
      {
        return $artworkStatus->__toString();
      }
      else
      {
        throw new Exception('Cant get status for artwork object - tried to get status '.$statusId);
      }
    }
  }
  
  /**
   * Simple function to check if an artwork is in "ready for approval" status
   *
   * @return boolean true if submitted or false if not
   */
  public function isSubmitted()
  {
    if ($this->getStatus() == ReaktorArtwork::SUBMITTED)
    {
      return true;
    }
    return false;
  }
  
  /**
   * Simple function to check if an artwork is in "draft" status
   *
   * @return boolean true if draft or false if not
   */
  public function isDraft()
  {
    if ($this->getStatus() == ReaktorArtwork::DRAFT)
    {
      return true;
    }
    return false;
  }
  
  /**
   * Simple function to check if an artwork is in "rejected" status
   *
   * @return boolean true if rejected or false
   */
  public function isRejected()
  {
    if ($this->getStatus() == ReaktorArtwork::REJECTED)
    {
      return true;
    }
    return false;
  }
  
  /**
   * Simple function to check if an artwork is in "user removed" status
   *
   * @return boolean true if the user has removed this artwork
   */
  public function isRemoved()
  {
    if ($this->getStatus() == ReaktorArtwork::REMOVED)
    {
      return true;
    }
    return false;
  }
  
  /**
   * Simple function to check if an artwork is in "approved" status
   *
   * @return boolean true if approved or false
   */
  public function isApproved()
  {
    if ($this->getStatus() == ReaktorArtwork::APPROVED)
    {
      return true;
    }
    return false;
  }
  
  /**
   * Simple function to check if an artwork is in "approved hidden" status
   *
   * @return boolean true if approved and hidden by user or false
   */
  public function isApprovedHidden()
  {
    if ($this->getStatus() == ReaktorArtwork::APPROVED_HIDDEN)
    {
      return true;
    }
    return false;
  }
  
  /**
   * Returns whether or not the artwork has more than one image in it
   *
   * @return boolean
   */
  function isSlideshow()
  {
    $ic = 0;
    if (count($this->_files) == 0)
    {
      $this->populateFiles();
    }
    foreach ($this->_files as $afile)
    {
      ($afile->getFiletype() == 'image') ? $ic++ : '';
      if ($ic > 1)
      { 
        return true;
      }
    }
    return false;
  }
  
  /**
   * Add a file to the artwork
   *
   * @param artworkFile|integer $file The file or file id to add
   * 
   * @return void
   */
  function addFile($file)
  {
    // Save the relation between the file and the artwork
    if ($this->_itemid == 0)
    {
      throw new Exception('The artwork is not saved yet. Please call the save() function before adding a file to the artwork.');
    }
    $reaktorArtworkFile = new ReaktorArtworkFile();
    $reaktorArtworkFile->setArtworkId($this->_itemid);
    
    if (is_numeric($file))
    {
      $file = ReaktorFilePeer::retrieveByPK($file, null, true);
    }
    
    $reaktorArtworkFile->setFileId($file->getId());
    
    $reaktorArtworkFile->setFileOrder($this->_numfiles + 1);
    $reaktorArtworkFile->save();
    
    // If the file is from a different user to the artwork, we must be creating a multi-user artwork!
    if ($file->getUserId() != $this->getUserId())
    {
      $this->setMultiUser();
      $this->save();
    }
    
    // Add the new file to the internal $_files collection
    if ($file instanceof artworkFile)
    {
      $this->_files[$file->getId()] = $file;
    }

    $this->_numfiles = count($this->_files);
  }
  
  /**
   * Adds an array of files to the artwork
   * The array can be either file_ids or file objects
   *
   * @param array $files
   */
  function addFiles($files)
  {
  	foreach ($files as $file)
  	{
  		$this->addFile($file);
  	}
  }
  
  
  /**
   * Remove a file from the artwork
   *
   * @param artworkFile|integer $file The file or file id to remove
   * 
   * @return void
   */
  function removeFile($file)
  {
    if ($this->_itemid == 0)
    {
      throw new Exception('Somehow this artwork does not exist');
    }
    if ($file instanceof artworkFile)
    {
      $fileId = $file->getId(); 
    }
    elseif (is_numeric($file))
    {
      $fileId = $file;
    }
    else
    {
      throw new Exception ("Cant find file");
    }
    
    if ($this->getFilesCount() == 1)
    {
      $this->userRemoveArtwork(sfContext::getInstance()->getUser(), "No files left");
      return false;
    }
    
    if ($thisFileLink = ReaktorArtworkFilePeer::retrieveByPK($this->getId(), $fileId))
    {
      $thisFileLink->Delete();
    }
   // Remove the file from the internal $_files collection
    if (isset($this->_files[$fileId]))
    {
      unset($this->_files[$fileId]);
    }
    $this->_numfiles = count($this->_files);
    
    $this->resetFirstFile();
    return true;
  }
  
  /**
   * Returns an array with all the files attached to this artwork
   *
   * @param boolean $ids If true return just the file IDs and not the objects
   * 
   * @return array
   */
  function getFiles($ids = false)
  {
    if (count($this->_files) == 0)
    {
      $this->populateFiles();
    }
    
    if ($ids)
    {
      $returnArray = array();
      foreach ($this->_files as $file)
      {
        $returnArray[] = $file->getId();
      }
      return $returnArray;
    }
    return $this->_files;
  }

  /**
   * Counts the files attached to the artwork
   * 
   * @return void
   */
  protected function _countFiles()
  { 
    $crit = new Criteria();
    $crit->add(ReaktorArtworkFilePeer::ARTWORK_ID, $this->_itemid);
    $crit->add(ReaktorFilePeer::HIDDEN, 0);
    $crit->addJoin(ReaktorArtworkFilePeer::FILE_ID, ReaktorFilePeer::ID);
    $this->_numfiles = ReaktorArtworkFilePeer::doCount($crit);
  }
  
  /**
   * Returns the number of files attached to this artwork
   * 
   * @param boolean $force Whether to force a recount from the db
   * 
   * @return integer
   */
  function getFilesCount($force = false)
  {
    if ($force || $this->_numfiles == 0)
    {
      $this->_countFiles();
    }
    return $this->_numfiles; 
  }
  
  /**
   * returns id of first file
   *
   */
  function getFeedFile()
  {
  	return $this->getFirstFile()->getId();
  }
  
  /**
   * Get the file with the id specified
   *
   * @param integer $id The id of the file to retrieve
   * 
   * @return artworkFile
   * 
   * @throws Exception
   */
  function getFile($id)
  {
    if (count($this->_files) == 0)
    {
      $this->populateFiles();
    }
    if (isset($this->_files[$id]))
    {
      return $this->_files[$id];
    }
    else
    {
      throw new Exception('This file does not exist, or is not a part of this artwork. Fileid: ' . $id);
    }
  }
  
  /**
   * Move the selected file up or down in the order
   * (only needs to be called on the file that is moved)
   *
   * @param artworkFile $file      The file to move
   * @param string      $direction "up" or "down"
   * 
   * @return void Sets the file order
   */
  function changeFileOrder($file, $direction)
  {
    if ($direction == 'up')
    {
      $switchfile = $this->getNextFile($file->getId());
    }
    else
    {
      $switchfile = $this->getPreviousFile($file->getId());
    }
    if ($switchfile instanceof artworkFile)
    {
      $this->switchFileOrderPlacement($file, $switchfile);
    }
    $this->resetFirstFile();
  }
  
  /**
   * Switch order placement between two files
   *
   * @param artworkFile $file1 The first file
   * @param artworkFile $file2 The second file
   * 
   * @return void Switches file order
   */
  function switchFileOrderPlacement($file1, $file2)
  {
    $file1_placement = $file1->getFileOrderPlacement();
    $file2_placement = $file2->getFileOrderPlacement();
    ReaktorArtworkFilePeer::setFileOrderPlacement($file2_placement, $file1->getId(), $this->getId());
    ReaktorArtworkFilePeer::setFileOrderPlacement($file1_placement, $file2->getId(), $this->getId());
  }
  
  
  /**
   * Returns the next file in the artwork
   *
   * @param integer $id The id of the current file
   * 
   * @return artworkFile
   */
  function getNextFile($id)
  {
    $next = false;
    foreach ($this->_files as $afile)
    {
      if ($afile->getId() == $id)
      {
        $next = true;
      }
      elseif ($next)
      {
        return $afile;
      }
    }
    return false;
  }
  
  /**
   * Returns the previous file in the artwork
   *
   * @param integer $id The ID of the file we're at
   * 
   * @return artworkFile
   */
  function getPreviousFile($id)
  {
    $rfiles = array_reverse($this->_files, true);
    $next = false;
    
    foreach ($rfiles as $afile)
    {
      if ($afile->getId() == $id)
      {
        $next = true;
      }
      elseif ($next)
      {
        return $afile;
      }
    }
    return false;
  }

  /**
   * Return the first file object attached to the artwork
   *
   * @return object reaktorFile
   */
  function getFirstFile()
  {
    if ($this->_artwork->getReaktorFile())
    {
      return new artworkFile($this->_artwork->getReaktorFile(), $this);
    }
    else
    {
      return $this->resetFirstFile();
    }
  }

  /**
   * Return the last element of the file array
   *
   * @return artworkFile object
   */
  public function getLastFile()
  {
    return end($this->_files);
  }
  
  /**
   * This function resets the first file value stored in the artwork table
   * It should always be populated as artworks must have at least one file, and if it's null
   * a lot of the "join all" queries will fail
   * 
   * @return artworkFile The artworkfile that was set as the first file
   */
  function resetFirstFile()
  {
    $this->populateFiles();
    $file = current($this->_files);
    
    $this->_artwork->setFirstFileId($file->getId());
    $this->save();
    
    return $file;
  }
  
  /**
   * Loads all files attached to this artwork into the $_files array
   * 
   * @return unknown
   */
  protected function populateFiles()
  {
    $this->_files = array();
    $c = new Criteria();

    if (sfContext::getInstance()->getUser()->isAuthenticated() && 
        sfContext::getInstance()->getUser()->hasCredential("viewallcontent"))
    {
      $c->addAscendingOrderByColumn(ReaktorFilePeer::HIDDEN);
    }
    else
    {
      $c->add(ReaktorFilePeer::HIDDEN, 0);
    }
    
    $c->addAscendingOrderByColumn(ReaktorArtworkFilePeer::FILE_ORDER);
    $c->addJoin(ReaktorArtworkFilePeer::FILE_ID, ReaktorFilePeer::ID);
    
    $resultset = $this->_artwork->getReaktorArtworkFilesJoinReaktorFile($c);
    
    foreach ($resultset as $artfile)
    {
      $this->_files[$artfile->getFileId()] = new artworkFile($artfile->getReaktorFile(), $this, $resultset);
      
      // For efficiency, we can check for discussed files now and add them to a seperate array
      if ($artfile->getReaktorFile()->getUnderDiscussion())
      {
        $this->_filesUnderDiscussion[$artfile->getFileId()] = $this->_files[$artfile->getFileId()]; 
      }
    }
    $this->_numfiles = count($this->_files);
  }
  
  /**
   * Saves the artwork with all its associated data and stuff
   *
   * @throws PropelException
   * @return boolean
   */
  function save()
  {
    try
    {
      $this->_artwork->save();
      $this->_itemid    = $this->_artwork->getId();
      $this->_isunsaved = false;
    }
    catch (PropelException $e)
    {
      throw $e;
    }
    return true;
  }
  
  /**
   * Sets the user id on the artwork
   *
   * @param integer $uid The user id of the user who saved the artwork
   * 
   * @return boolean
   */
  function setUserId($uid)
  {
    $this->_artwork->setUserId($uid);
    return true;
  }
  
  /**
   * Returns the user id for the user who saved the artwork
   *
   * @return integer
   */
  function getUserId()
  {
    return $this->_artwork->getUserId();
  }
  
  /**
   * Set the user for this artwork
   *
   * @param sfGuardUser $user The sfGuardUser object of the user who saved the artwork
   * 
   * @throws Exception
   * 
   * @return boolean
   */
  function setUser($user)
  {
    if ($user instanceof sfGuardUser)
    {
      $this->_artwork->setsfGuardUser($user);
    }
    else
    {
      throw new Exception('The user parameter has to be an sfGuardUser object');
    }
    return true;
  }
  
  /**
   * Returns the sfGuardUser object for the user who created the artwork
   *
   * @return sfGuardUser
   */
  function getUser()
  {
    if (!$this->_artworkUserObject instanceof sfGuardUser)
    {
      $this->_artworkUserObject = $this->_artwork->getsfGuardUser();
    }
  	return $this->_artworkUserObject;
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
    reaktorCache::deleteSimilar("artwork_tag_list_".$this->getId());
    $this->_artwork->addTag($tag);
  }
  
  /**
   * Remove the given tag from the artwork
   *
   * @param string $tag The tag to remove
   * 
   * @return void
   */
  function removeTag($tag)
  {
    reaktorCache::deleteSimilar("artwork_tag_list_".$this->getId());
    $this->_artwork->removeTag($tag);
  }

  /**
   * Returns the number of tags
   *
   * @param bool $include_unapproved
   * @return int
   */
  public function countTags($include_unapproved = true)
  {
    return count($this->getTags(false, false, $include_unapproved));
  }
  
  /**
   * Returns all tags attached to this artwork
   *
   * @param boolean $include_files Whether to include filetags or just return tags attached to the artwork itself
   * @param boolean $groupByStatus Whether to include the status in the returned array - implies unapproved tags can be shown
   * 
   * @return array
   */
  function getTags($include_files = true, $groupByStatus = false, $include_unapproved = false)
  {    
  	// See if we have this list in the APC cache
  	$key   = "artwork_tag_list_".$this->getId()."if{$include_files}gBS{$groupByStatus}iu{$include_unapproved}";
    $cache = reaktorCache::singleton($key);
    
    if (!($tags_arr = $cache->get()))
    {
      $tags_arr = array();
      
      $c = new Criteria();
      
      $ctn1 = $c->getNewCriterion(TaggingPeer::TAGGABLE_ID, "(" . TaggingPeer::TAGGABLE_ID. " = ".$this->getId()." AND ".TaggingPeer::TAGGABLE_MODEL." = 'ReaktorArtwork')", Criteria::CUSTOM);
      $c->setDistinct();
  
      if (!$groupByStatus && !$include_unapproved)
      {
        $c->add(TagPeer::APPROVED, 1);
      }
      
      if ($include_files)
      {
        $ctn2 = $c->getNewCriterion(TaggingPeer::TAGGABLE_MODEL, "(" . TaggingPeer::TAGGABLE_MODEL." = 'ReaktorFile' AND ".ReaktorArtworkFilePeer::ARTWORK_ID." = ".$this->getId() . ')', Criteria::CUSTOM);
        $ctn1->addOr($ctn2);
      }
      $c->add($ctn1);
    
      $c->addJoin(TagPeer::ID, TaggingPeer::TAG_ID);
      $c->addJoin(TaggingPeer::TAGGABLE_ID, ReaktorArtworkFilePeer::FILE_ID, Criteria::LEFT_JOIN);
      $tagObjectArray = TagPeer::doSelect($c);
      
      foreach ($tagObjectArray as $tagObject)
      {
        if ($groupByStatus)
        {
          $tags_arr[$tagObject->getApproved()][$tagObject->getId()] = $tagObject->getName(); 
        }
        else
        {
          $tags_arr[] = $tagObject->getName();
        }
      }
      asort($tags_arr);
      $cache->set($tags_arr, 10000);
    }
    return $tags_arr;
  }

  /**
   * Returns categories this artwork belongs to
   * 
   * @return array of categories with category_id as key
   */
  function getCategories()
  {    
    return CategoryArtworkPeer::getCategoriesFromArtwork($this);
  }
  
  /**
   * Add a new category to this artwork
   * 
   * @param integer             $categoryId Category Id
   * @param integer|sfGuardUser $user       The user adding the category
   * 
   * @return void
   */
  function addCategory($categoryId, $user)
  {
    CategoryArtworkPeer::addArtworkCategory($this, $categoryId, $user);
  }
  
  /**
   * Remove a category from artwork
   *
   * @param integer $categoryId the ID of the category to remove
   */
  function removeCategory($categoryId)
  {
    CategoryArtworkPeer::removeArtworkCategory($this, $categoryId);
  }
  
  /**
   * Set the artwork title
   *
   * @param string $title The title to set
   * 
   * @return void 
   */
  function setTitle($title)
  {
    $this->_artwork->setTitle($title);
    $this->clearLinkCache();
  }
  
  /**
   * Returns the artwork title
   *
   * @return string
   */
  function getTitle()
  {
    return $this->_artwork->getTitle();
  }

  /**
   * Smart title handling, cuts the title at $max if necessary on spaces, dots, 
   * questionmarks...
   * 
   * @param int $max 
   * @return chopped string
   */
  function getShortTitle($max = 0)
  {
    if (!$max)
    {
      $max = sfConfig::get('app_artwork_teaser_len', 80);
    }
    return stringMagick::chop($this->getTitle(), $max);
  }

  /**
   * Returns the artwork description
   *
   * @return string
   */
  function getDescription()
  {
    return $this->_artwork->getDescription();
  }
  
  /**
   * Set the artwork description
   *
   * @param string $description The description to set
   * 
   * @return void
   */
  function setDescription($description)
  {
    return $this->_artwork->setDescription($description);
  }
  
  /**
   * Returns the id of the artwork
   *
   * @return integer
   */
  function getId()
  {
    return $this->_artwork->getId();
  }
  
  /**
   * Returns the primary key of the artwork
   *
   * @return integer
   */
  function getPrimaryKey()
  {
    return $this->_artwork->getPrimaryKey();
  }
  
  /**
   * Returns the artwork type - see the constants defined in this class
   *
   * @return string
   */
  function getArtworkType()
  {
    return $this->_artworkType;
  }
  
  /**
   * Returns an array of file types that this artwork can contain
   * Normally this is the same as the artwork type (identifier) but if the app.yml has
   * specified other types are allowed (like text/pdf) then they will be returned here
   *
   * @return array The array of eligible types as strings
   */
  function getEligbleFileTypes()
  {
    $returnArray        = array($this->getArtworkType());
    $additionalFileTypes = sfConfig::get("app_artwork_additional_file_types", array());

    if (isset($additionalFileTypes[$this->getArtworkType()]))
    {
      return array_merge($returnArray, $additionalFileTypes[$this->getArtworkType()]);
    }
    return $returnArray;
  }
  
  /**
   * Set the artwork type - use the constants defined in this class
   *
   * @param string $type The artwork type to set
   * 
   * @return void
   */
  function setArtworkType($type)
  {
    $this->_artwork->setArtworkIdentifier($type);
    $this->_artworkType = $type;
  }

  /**
   * Flag to show an artwork has been modified, so the admin can check it in a list
   *
   * @param object $user    The user object for checking credentials
   * @param string $message A message to add to the admin comments field
   * 
   * @return void sets modified note in DB
   */
  function flagChanged($user, $message = "unknown")
  {
    // Only need to flag it if user is not admin
    if (!$user->hasCredential("editusercontent"))
    {
      $message = $this->_artwork->getModifiedNote().$message."\n";
      $this->_artwork->setModifiedNote($message);
      $this->_artwork->setModifiedFlag(time());
    }
  }
  
  /**
   * Clear the modified flag (after admin is happy)
   *
   * @return void Clears modified flag in DB
   */
  function flagCleared()
  {
    $this->_artwork->setModifiedFlag(null);
  }
  
  /**
   * Returns true if $user is athorized to view the artwork.
   *
   * @return bool  true when $user are allowed to view the artwork
   */
  function isViewable()
  {
    
    if (sfContext::getInstance()->getUser()->hasCredential("viewallcontent"))
    {       
    	sfContext::getInstance()->getLogger()->info("You have the fu, you can see me.");
    	return true;
    } 

    // Access to approved artork is for anyone
    if ($this->isApproved()) 
    {
      sfContext::getInstance()->getLogger()->info("This artwork is approved, so it is viewable");
    	return true;
    }

    // Access to removed artwork is only for admin (returned true above)
    if ($this->isRemoved())
    {
      sfContext::getInstance()->getLogger()->info("This artwork is removed, and cannot be seen");
    	return false;
    }
    
    // also allow access to owner of artwork - unless they have removed it
    if (sfContext::getInstance()->getUser()->isAuthenticated()
        && $this->getUserId() == sfContext::getInstance()->getUser()->getGuardUser()->getId())
    {
      sfContext::getInstance()->getLogger()->info("You can see this artwork since you are the owner");
    	return true;
    }

    sfContext::getInstance()->getLogger()->info("This artwork is not approved, and cannot be seen");
    return false;
  }
  
  /**
   * Delete the artwork from the database
   *
   * @return void Deletes the artwork
   */
  function deleteArtwork()
  {
    $this->_artwork->delete();
  }
 
  function isDeleted()
  {
    $this->_artwork->getDeleted();
  }



 
  /**
   * Non destructive artwork removal from a user perspective
   * The artwork will effectively disappear, but will still be available for admin users
   * for historical reasons (and possible future recovery)
   *
   * @param myUser $user    The user actioning the change
   * @param string $comment A comment for the history table
   * 
   * @return boolean true on success, exception on failure
   */
  public function userRemoveArtwork($user, $comment)
  {
  	return $this->changeStatus($user, ReaktorArtwork::REMOVED, $comment);
  }

  /**
   * Change the status of an artwork
   *
   * @param integer $user    The user changing the status
   * @param integer $status  The status id to set
   * @param string  $comment Comment to add to history
   * @param boolean $quiet   If true then no action timestamp is applied
   * 
   * @return void Sets status
   */
  function changeStatus($user, $status, $comment = null, $quiet = false)
  { 
    $oldStatus = $this->getStatus();
    if ($user instanceof sfGuardUser || $user instanceof myUser )
    {
      $user = $user->getId();
    }
    
    if (!$quiet)
    {
      $this->_artwork->setActionedAt(time("Y-m-d H:i:s"));
      $this->_artwork->setActionedBy($user);
    }
    $this->_artwork->setStatus($status);
    $this->_artwork->save();       
    ReaktorArtworkHistory::logAction($this->getId(), $user, $comment, $status);
    
    switch($status)
    {
      case ReaktorArtwork::APPROVED:
        $this->flagCleared();
		
	// User did something, change his status
		$this->setStatus($status) ;
        break;
      case ReaktorArtwork::REJECTED:
        if ($status == ReaktorArtwork::REJECTED)
        {
          foreach($this->getFiles() as $file)
          {
            foreach($file->getParentArtworks() as $partwork)
            {
              if ($partwork->isApproved())
              {
                // Back to ->getFiles()
                continue 2;
              }
            }
            // Found no approved parents, disable all tags from this file
            TaggingPeer::setTaggingApproved(null, "ReaktorFile", $file->getId(), 0);
          }

          // Disable all tags by this artwork
          TaggingPeer::setTaggingApproved(null, "ReaktorArtwork", $this->getId(), 0);
        }

        return 'rejectArtwork';
        break;
      case ReaktorArtwork::DRAFT:
        // If the artwork was previously removed we should resurrect it's files when restoring it
        if ($oldStatus == ReaktorArtwork::REMOVED)
        {
          $this->unHideFiles();
        }
      break;
      default:              
        break; 
    }
    $tagging_status = ($status == ReaktorArtwork::APPROVED ? 1 : 0);

    TaggingPeer::setTaggingApproved(null, "ReaktorArtwork", $this, $tagging_status);
    
    $files = $this->getFiles();
    foreach ($files as $fileObject)
    {
      TaggingPeer::setTaggingApproved(null, "ReaktorFile", $fileObject, $tagging_status);
    }
    return true;
  }
  
  /**
   * Go through all the artwork's files and unhide them
   * Since you need credentials to do this, the internal file list
   * should already be populated with hidden files (if any exist) along with the
   * other (regular) files
   *
   * @return null
   */
  protected function unHideFiles()
  {
    foreach($this->getFiles() as $file)
    {
      if ($file->isHidden())
      {
        $file->setUnHidden();
        $file->save();
      }
    }
  }
  
  /**
   * Returns the artwork modified date if it was since it was approved
   *
   * @return date or null if not modified
   */
  function getModifiedDate()
  {
  	return $this->_artwork->getModifiedFlag();
  }
  
  /**
   * Get the notes that are linked to a modified artwork
   *
   * @param $translate Whether to run each line through translator
   * 
   * @return string
   */
  function getModifiedNote($translate = true)
  {
    if ($translate)
    {
      $note      = $this->_artwork->getModifiedNote();
      $noteLines = preg_split('/[\n\r]+/', $note, -1, PREG_SPLIT_NO_EMPTY);
      $newText   = "";
      
      foreach($noteLines as $line)
      {
        $newText .= sfContext::getInstance()->getI18n()->__($line)."\n";
      }
      
      return $newText;
    }
    
    return $this->_artwork->getModifiedNote();
  }
  
  /**
  * Get a list of lokalreaktors for this artwork
  * 
  * @param boolean $references  Return references only instead of objects
  * 
  * @return array Subreaktors (lokalreaktors) that are linked to this artwork
  * 
  */
  function getLokalreaktors($references = false)
  {
  	return $this->getSubreaktors($references, array('lokalreaktor'));
  }
  
  /**
  * Get subreaktors
  * 
  * @param boolean $references  Return references only instead of objects
  * @param array   $returnTypes The type of reaktors to return (subreaktor, lokalreaktor)
  * 
  * @return array Subreaktors that are linked to this artwork
  */
  function getSubreaktors($references = false, $returnTypes = array("subreaktor", "lokalreaktor"))
  {
  	$returnArray = array();
    
    if (in_array("subreaktor", $returnTypes))
    {
      $c = new Criteria();
      $c->addJoin(SubreaktorArtworkPeer::SUBREAKTOR_ID, SubreaktorPeer::ID);
      $c->add(SubreaktorArtworkPeer::ARTWORK_ID, $this->getId());
      $c->addAscendingOrderByColumn(SubreaktorPeer::SUBREAKTOR_ORDER);
      
      $subreaktors = SubreaktorArtworkPeer::doSelectJoinSubreaktor($c);
      
      foreach($subreaktors as $asubreaktor)
      {
        $returnArray[$asubreaktor->getSubreaktor()->getId()] = $references ? $asubreaktor->getSubreaktor()->getReference() : $asubreaktor->getSubreaktor();     
      }
    }

    if (in_array("lokalreaktor", $returnTypes))
    {
      $c = new Criteria();
      $c->addJoin(LokalreaktorArtworkPeer::SUBREAKTOR_ID, SubreaktorPeer::ID);
      $c->add(LokalreaktorArtworkPeer::ARTWORK_ID, $this->getId());
      $c->addAscendingOrderByColumn(SubreaktorPeer::SUBREAKTOR_ORDER);
      
      $lokalreaktors = LokalreaktorArtworkPeer::doSelectJoinSubreaktor($c);
      
      foreach($lokalreaktors as $alokalreaktor)
      {
        $returnArray[$alokalreaktor->getSubreaktor()->getId()] = $references ? $alokalreaktor->getSubreaktor()->getReference() : $alokalreaktor->getSubreaktor();     
      } 
    }
        
    return $returnArray;
  }
  
  function getSubreaktorNames()
  {
  	$subreaktornames = array();
  	$subreaktors = $this->getSubreaktors();
  	foreach ($subreaktors as $aSubreaktor)
  	{
  		$subreaktornames[] = $aSubreaktor->getName();
  	}
  	return $subreaktornames;
  }
  
  /**
   * Add subreaktor to artwork
   *
   * @param integer|string $subreaktor ID or reference string
   */
  function addSubreaktor($subreaktor)
  {
    if ($this->_isunsaved)
    {
      throw new Exception("Must save artwork first or it won't have a DB ID");
    }
    
  	if (is_numeric($subreaktor))
  	{
  	 $res = SubreaktorPeer::retrieveByPK($subreaktor);
  	}
  	else
  	{
  	  $res        = SubreaktorPeer::retrieveByReference($subreaktor);
  	  $subreaktor = $res->getId();
  	  
  	}
  	
  	if ($res->getLokalreaktor())
  	{
  		$this->_addLokalreaktor($subreaktor);
  	}
  	else
  	{
  	  // Check that this is a relevant subreaktor
  	  $eligible = SubreaktorIdentifierPeer::getEligibleSubreaktors($this, true);
  	  if (is_numeric($subreaktor))
  	  {
  	    $eligible = array_keys($eligible);
  	  }
  	  if (in_array($subreaktor, $eligible))
  	  {
  	    $this->_addSubreaktor($subreaktor);
  	  }
  	}
  	$this->clearLinkCache();
  }
  
  /**
   * Get a list of eligible categories for this artwork
   *
   * @return array
   */
  function getEligibleCategories()
  {
    return CategorySubreaktorPeer::getCategoriesUsedBySubreaktor($this->artwork->getSubreaktors(), false);
  }
  
  /**
   * Compare the new list of subreaktors to the old one, if there are differences, 
   * add or delete to make sure the database is updated.
   * 
   * This is useful when using checkboxes in forms to keep score. 
   *
   * @param array $newSubreaktors The new Subreaktors
   * @param array $oldSubreaktors The old subreaktors
   */
  function updateSubreaktors($newSubreaktors, $oldSubreaktors)
  {
    //Add all new subreaktors that haven't already been added
    foreach($newSubreaktors as $subreaktor)
    {
      if (!in_array($subreaktor, $oldSubreaktors))
      {
        $this->addSubreaktor($subreaktor);
      }
    }
    //Remove all old subreaktors that aren't in the new list
    foreach($oldSubreaktors as $subreaktor)
    {
      if (!in_array($subreaktor, $newSubreaktors))
      {
        $this->removeSubreaktor($subreaktor);
      }
    }    
  }
  
  /**
   * Remove subreaktor from artwork
   *
   * @param integer $subreaktor_id
   */
  function removeSubreaktor($subreaktor_id)
  {
    $c = new Criteria();
  	$c->add(SubreaktorArtworkPeer::SUBREAKTOR_ID, $subreaktor_id);
  	$c->add(SubreaktorArtworkPeer::ARTWORK_ID, $this->getId());
  	SubreaktorArtworkPeer::doDelete($c);
  	
  	CategoryArtworkPeer::removeAllInSubreaktor($this, $subreaktor_id);
  	
    $c = new Criteria();
    $c->add(LokalreaktorArtworkPeer::SUBREAKTOR_ID, $subreaktor_id);
    $c->add(LokalreaktorArtworkPeer::ARTWORK_ID, $this->getId());
    LokalreaktorArtworkPeer::doDelete($c);
    $this->clearLinkCache();
  }
  
  protected function _addSubreaktor($subreaktorId)
  {
    SubreaktorArtworkPeer::addSubreaktorArtwork($this, $subreaktorId);
  }
  
  protected function _addLokalreaktor($lokalreaktor_id)
  {
    $lokalreaktorartworkitem = new LokalreaktorArtwork();
    $lokalreaktorartworkitem->setArtworkId($this->getId());
    $lokalreaktorartworkitem->setSubreaktorId($lokalreaktor_id);
    $lokalreaktorartworkitem->save();
  }
  
  /**
   * Return true if logged in user can administer this artwork, 
   * false if not. 
   *
   * @return boolean 
   */
  function canApprove()
  {
    $subreaktors = $this->getSubreaktors();
    $canApprove  = false;
    foreach ($subreaktors as $subreaktor)
    {
      if (sfContext::getInstance()->getUser()->hasGroup($subreaktor->getReference().'_redaksjon'))
      {
        $canApprove = true;
        break;
      }
    }
    
    return $canApprove;
  }
  
  
  /**
   * Get the rejection comment
   *
   * @return string The comment linked to the rejection
   */
  function getRejectionMsg()
  {
    $c = new Criteria();
    $c->add(ReaktorArtworkHistoryPeer::ARTWORK_ID, $this->getId());
    $c->add(ReaktorArtworkPeer::STATUS, 4);
    $c->addDescendingOrderByColumn(ReaktorArtworkHistoryPeer::CREATED_AT);    
    $history_entry = ReaktorArtworkHistoryPeer::doSelectOne($c);
    if ($history_entry)
    {
      return $history_entry->getComment();
    }
    else
    {
    	return '';
    }
  }
  
  /**
   * Get array of related artworks as linked by the user and stored in related_artwork table
   * 
   * @param integer $limit    How many results to return (null to get all)
   * @param boolean $approved Whether to return only approved artworks
   * 
   * @return array of Artwork objects
   */
  function getRelatedArtworks($limit = 6, $approved = true)
  {
    sfContext::getInstance()->getLogger()->info("Getting all related artworks");
  	return RelatedArtworkPeer::getRelatedArtworkObjects($this->getId(), $limit, $approved); 
  }
  
  function isRelated($id)
  {    
    return RelatedArtworkPeer::isRelated($this->getId(), $id); 
  }
  
  /**
   * Return the editorial team (group) object assigned to this artwork
   * 
   * @return sfGuardGroup The guard group object
   */  
  function getEditorialTeam()
  {
  	if ($this->_artwork->getTeamId())
  	{
  	  return $this->_artwork->getsfGuardGroup();
  	}
  	else
  	{
  	  throw new exception ("No editorial team assigned");
  	}
  }
  
  /**
   * Set the editorial team based on the group ID or group object
   *
   * @param integer|sfGuardGroup $teamId
   */
  function setEditorialTeam($teamId)
  {
    if ($teamId instanceof sfGuardGroup)
    {
      $teamId = $teamId->getId();
    }
    
  	$this->_artwork->setTeamId($teamId);
  	$this->_isunsaved = true;
  	
  	return true;
  }
  
  
  /**
   * Initially set or reset the editorial team based on the artwork subreaktors etc
   * Returns the team that was set based on the decision making process
   * 
   * @return sfGuardGroup The chosen team
   */
  function resetEditorialTeam()
  {
    // Get all the subreaktors and lokal reaktors
    $subreaktorArray          = $this->getSubreaktors();
    $subreaktorReferenceArray = $this->getSubreaktors(true); 
    // First we check if this artwork matches a competition that has been set in app.yml
    $competitionsArray = sfConfig::get("app_editorial_team_competitions", array());
    foreach ($competitionsArray as $competition)
    {
      if (time() > strtotime($competition["start"]) && time() < strtotime($competition["end"])
          && count(array_diff($subreaktorReferenceArray, $competition["subreaktors"])) < count($subreaktorReferenceArray))
      {
        // We matched a subreaktor, now we need to see if any categories match
        $categories = array_keys($this->getCategories());
        if (count(array_diff($categories, $competition["categories"])) < count($categories))
        {
          // We matched a subreaktor and a category, assign the team if it exists in the database
          if ($team = sfGuardGroupPeer::retrieveByName($competition["team"]))
          {
            $this->setEditorialTeam($team);
            return $competition["team"];
          }
        }
      }
    }

    // Next we check for lokalreaktors as they will always be chosen over normal subreaktors if set
    if ($result = $this->_checkSubreaktorForTeams($subreaktorArray, true))
    {
      $this->setEditorialTeam($result);
      return $result;
    }
    // Now check the rest of the normal subreaktors
    elseif ($result = $this->_checkSubreaktorForTeams($subreaktorArray, false))
    {
      $this->setEditorialTeam($result);
      return $result;
    }
    // Ok no hits - must be some teams on holiday or the app.yml hasn't been set very well
    $defaultTeam = sfGuardGroupPeer::getGroupByName(sfConfig::get("app_editorial_team_default", "deichman_redaksjon"));
    $this->setEditorialTeam($defaultTeam);
    return $defaultTeam;
  }

   /**
   * This function called twice by the reset editorial team function so moved here to promote code reuse 
   *
   * @param array $subreaktorArray The array of subreaktors to check
   * @param boolean $lokal whether we are checking lokal reaktors or not
   *
   * @return sfGuardgroup or false
   */
  protected function _checkSubreaktorForTeams($subreaktorArray = array(), $lokal = false)
  {
    foreach($subreaktorArray as $subreaktor)
    {
      if ($subreaktor instanceof SubreaktorArtwork)
      {
        $subreaktorObject = $subreaktor->getSubreaktor();
      } 
      else
      {
        $subreaktorObject = $subreaktor;
      }
      
      // Only check lokalreaktors if we have the $lokal parameter set true & normal Subreaktors if false
      if ($subreaktorObject->getLokalreaktor() == $lokal)
      {
      // See if this subreaktor/lokalreaktor has any editorial teams in it's list
        if (sfConfig::get("app_editorial_team_assignment_".$subreaktorObject->getReference()))
        {
          // We need to check through the list and find the first one that is enabled, preserving the yml file order
          foreach (sfConfig::get("app_editorial_team_assignment_".$subreaktorObject->getReference()) as $ref)
          {
            // Special residence list hit?
            if ($ref == "assign_by_residence")
            {
              $residenceId = $this->getUser()->getResidenceId();
              foreach(sfConfig::get("app_editorial_team_assign_by_residence", array()) as $team => $residenceArray)
              {
                if (in_array($residenceId, $residenceArray))
                {
                  $residenceTeam = sfGuardGroupPeer::retrieveByName($team);
                  if ($residenceTeam->isEnabled())
                  {
                    return $residenceTeam;
                  }
                  // If we got a hit but the team is not enabled, we go to the backup team
                  elseif (sfConfig::get("app_editorial_team_backup_teams_".$team))
                  {
                    foreach (sfConfig::get("app_editorial_team_backup_teams_".$team) as $backupTeamName)
                    {
                      $backupTeam = sfGuardGroupPeer::retrieveByName($backupTeamName);
                      if ($backupTeam->isEnabled())
                      {
                        return $backupTeam;
                      }
                    }
                  }
                }
              }
            }
            else
            {
              $team = sfGuardGroupPeer::retrieveByName($ref);
              if ($team->isEnabled())
              {
                return $team;
              }
            }  
          }
        }
      }
    }
    // No hits, not a problem because the calling function will set a default
    return false;
  }
  
  /**
   * This function will return editorial users when new artwork is submitted
   * 
   *
   * @param team string, name of team
   *
   * @return sfGuardgroup array
   */
  public function getEditorialTeamMembers($team)
  {
  	$group = sfGuardGroupPeer::getGroupByName($team);
  	$numUnapprovedArtworksInEditorialTeam = ReaktorArtworkPeer::getNumberofArtworksByEditorialTeam(array($group->getId() => $team), 2);
  	
  	return $group->getMembers($numUnapprovedArtworksInEditorialTeam);
  	
  }
  
  /**

   * Return the taggable model string to use in the tagging table
   *
   * @return string
   */
  public function getTaggableModel()
  {
    return "ReaktorArtwork";
  }
  
  /**
   * Check whether this artwork has files under discussion
   *
   * @return unknown
   */
  public function hasFilesUnderDiscussion()
  {
    // Should check that there are some files first or this won't return an accurate value
    if (count($this->_files) == 0)
    {
      $this->populateFiles();
    }
    
    if (count($this->_filesUnderDiscussion) > 0)
    {
      return true;
    }
    
    return false;
  }

  /**
   * Return the files under discussion
   *
   * @return array of file objects that are under discussion
   */
  public function getFilesUnderDiscussion()
  {
    // Should check that there are some files first or this won't return an accurate value
    if (count($this->_files) == 0)
    {
      $this->populateFiles();
    }
   
    return $this->_filesUnderDiscussion;
  }
  
  /**
   * Return whether this artwork is under discussion or not
   *
   * @return boolean whether under discussion or not
   */
  public function isUnderDiscussion()
  {
    return (bool)$this->_artwork->getUnderDiscussion();
  }
  
  /**
   * Set this artwork under discussion
   *
   * @return null
   */
  public function markUnderDiscussion()
  {
    $this->_artwork->setUnderDiscussion(1);
    $this->_artwork->save();
    HistoryPeer::logAction(8, sfContext::getInstance()->getUser()->getId(), $this);
  }
  
  /**
   * Get by who and when the artwork was marked for discussion last.
   *
   * @return History 
   */
  public function getDiscussionInfo()
  {
    if (HistoryPeer::getAction(8, $this))
    {
      return HistoryPeer::getAction(8, $this);
    }
    else
    {
      throw new Exception("Article discussion has no history");
    }
  }
  
  /**
   * Mark this artwork as not under discussion
   *
   * @return null
   */
  public function markNotUnderDiscussion()
  {
    $this->_artwork->setUnderDiscussion(0);
    $this->_artwork->save();
    HistoryPeer::logAction(9, sfContext::getInstance()->getUser()->getId(), $this);
  }
  
  public function getCommentCount($namespace)
  {
    return $this->_artwork->getCommentCount($namespace);
  }
  /**
   * Return the artwork object that we are working with
   *
   * @return reaktorArtwork
   */
  public function getBaseObject()
  {
    return $this->_artwork;
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
   * Return the publish date of this artwork for the feed generator
   * If this function is not here, the plugin looks for getCreatedAt() which exists above but returns
   * A formatted date which I don't think the feed generator likes too much...
   * 
   * @return 
   */
  public function getFeedPubDate()
  {
    return strtotime($this->_artwork->getCreatedAt());
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
   * Custom title for RSS feeds which includes the username of the owner
   *
   * @return string the i18n title/username combo
   */
  public function getCustomFeedTitle()
  {
    return sfContext::getInstance()->getI18N()->__("%title% by %username%", 
           array("%title%" => $this->getTitle(), 
                 "%username%" => $this->getUser()->getUsername()));
  }

  /**
   * Include the first file in the artwork as a feed enclosure
   * 
   * @return void
   */
  public function getFeedEnclosure()
  {
    return $this->getFirstFile();
  }

  // Used by the feed plugin to generate content, see bug#425
  public function getContent()
  {
    sfLoader::loadHelpers(array("Url", "content", "Asset", "Tag"));
    return showMiniThumb($this, true, false, false);
  }


  public function getLicense()
  {
    return new ccLicense($this->getFirstFile()->getMetadata('license'));
  }

  /**
   * Generate valid absolute url for Atom IDs
   * 
   * @return void
   */
  public function getFeedUniqueId()
  {
    return sfContext::getInstance()->getController()->genUrl($this->getLink(), true);
  }

  /**
   * Return details of whether this is a multi-user artwork
   *
   * @return boolean true if this is an admin created multi-user artwork
   */
  public function isMultiUser()
  {
    return (bool)$this->_artwork->getMultiUser();
  }
  
  /**
   * Set the multi user flag for composite artworks
   *
   * @param boolean $setting true if this is a multi user artwork
   */
  public function setMultiUser($setting = true)
  {
    $this->_artwork->setMultiUser($setting);
    $this->_isunsaved = true;
  }
  
  /**
   * Return whether an artwork can be embedded in other sites based on the file type
   * At present, the only criteria is that it is not a flash animation, but this function
   * allows for better flexibility in future
   *
   * @return boolean true if it can be embedded in other sites
   */
  public function canEmbed()
  {
    if ($this->getArtworkType() != "flash_animation")
    {
      return true;
    }
    return false;
  }

  /**
   * Returns true if all the elements are present and have finished transcoding
   *
   * @return boolean
   */
  public function isTranscoded()
  {
    if (!is_null($this->_isTranscoded))
    {
      return $this->_isTranscoded;
    }
    
    foreach ($this->getFiles() as $file)
    {
      switch ($file->getIdentifier())
      {
        case "audio":
          if (file_exists($file->getFullFilePath().".temp.mp3"))
          {
            $this->_isTranscoded = false;
            return false;
          }
        case "video":
          if (file_exists($file->getFullFilePath().".temp.flv"))
          {
            $this->_isTranscoded = false;
            return false;
          }
        default:
          break;
      }
    }
    $this->_isTranscoded = true;
    return true;
  }

  /**
   * Get list of relevant help articles by matching article and artwork categories and subreaktors.
   *
   */
  public function getHelpArticles()
  {
    
    //echo implode(',', array_keys($this->getCategories())).'<br />';
    //echo implode(',', array_keys($this->getSubreaktors(true))).'<br />';
    
    return $this->_artwork->getHelpArticles($this->getSubreaktors(true), $this->getCategories());
    
  }

  public function getFeedAuthorName()
  {
    $user = $this->getUser();
    return $user->getNamePrivate() ? $user->getUsername() : $user->getName();
  }
  public function getFeedAuthorEmail()
  {
    $user = $this->getUser();
    return $user->getEmailPrivate() ? null : $user->getEmail();
  }

  public function setStatus($status) 
  {
    // New approved artwork, clear the count cache
    if ($status == ReaktorArtwork::APPROVED) 
	    {
      if (!$artworkUser =  $this->getUser())
      {
        throw new Exception("You must set the user ID of the artwork before changing the status");
      }
      
      //Update last action flag for owner of artwork 
      $artworkUser->setLastActive(date('Y-m-d H:i:s'));
      $artworkUser->save();    
		
      reaktorCache::delete("artworkCount");


    }


  }

  /**
   * Whether this artwork should show next/previous links
   * Based on app.yml configuration
   *
   * @return boolean true if this artwork should display navigation links
   */
  public function showNavigationOnDisplay()
  {
    return (in_array($this->getArtworkType(), sfConfig::get("app_artwork_show_navigation", array())));
  }
  
  /**
   * Return the name of the database table where these objects are stored
   *
   * @return string
   */
  public function getTableName()
  {
    return "reaktor_artwork";
  }
}
