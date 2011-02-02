<?php
/**
 * Tag component used for Ajax tag view
 * Rendered by initial calling template and also the Ajax call 
 *
 * PHP version 5
 * 
 * @author    Russ Flynn <russ@linpro.no>
 * @copyright 2008 Linpro AS
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 */

/**
 * Tag component class used for Ajax tag view
 *
 * PHP version 5
 * 
 * @author    Russ Flynn <russ@linpro.no>
 * @copyright 2008 Linpro AS
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 */
class tagsComponents extends sfComponents
{
  /**
   * Generate an array of tags for the tag edit template
   * Based on an object that has been tagged
   * 
   * @return void
   */
  function executeTagEditList()
  {
    $c = new Criteria();
    $c->addAscendingOrderByColumn(TagPeer::NAME);
    $this->options =  isset($this->options) ? $this->options : array();
    
    if (isset($this->taggableObject))
    {
      if ($this->taggableObject instanceof artworkFile)
      {
        $c->add(TaggingPeer::TAGGABLE_MODEL, "ReaktorFile");
        $this->taggable = "reaktorFile";  
        if (isset($this->options["artworkList"]) && $this->options["artworkList"])
        {
          $this->options["extraId"] = "_artwork".$this->options["artworkList"];
        }
        else
        {
          $this->options["extraId"] = "_file".$this->taggableObject->getId();
        }
        
      }
      elseif ($this->taggableObject instanceof genericArtwork)
      {
        $c->add(TaggingPeer::TAGGABLE_MODEL, "ReaktorArtwork");
        $this->taggable           = "genericArtwork";
        $this->options["extraId"] = "_artwork".$this->taggableObject->getId();
      }
      elseif ($this->taggableObject instanceof Article)
      {
        $c->add(TaggingPeer::TAGGABLE_MODEL, "Article");
        $this->taggable           = "Article";
        $this->options["extraId"] = "_article".$this->taggableObject->getId();
      }
      else
      {
        throw new exception ("Unsupported object");
      }
      
      $c->add(TaggingPeer::TAGGABLE_ID, $this->taggableObject->getId());
      $c->addJoin(TaggingPeer::TAG_ID, TagPeer::ID);
      $c->addDescendingOrderByColumn(TaggingPeer::ID);
      $this->objectId     = $this->taggableObject->getId(); 
    }
    
    if (isset($this->page) && $this->page != "ALL")
    {
      $c->add(TagPeer::NAME, $this->page."%", Criteria::LIKE);
    }
    
    if (isset($this->unapproved) && $this->unapproved == 1)
    {
      $c->add(TagPeer::APPROVED, 0);
    }

    $this->tags = TagPeer::doSelect($c);
  }
  
  function executeTagSearchBox()
  {
  	
  }
  
  /**
   * Show intelligent tag cloud
   *
   * @return void - generate the intellitags component
   */
  function executeShowintellitags()
  {
    $tags = $this->tags;

    // Get related tags
    $first_tags = TagPeer::getRelatedTags($tags, array('limit' => 100, 'parent_approved' => 1));

    // uncomment the following if-block to do a second pass
    /*
    if (count($first_tags) <= 10)
    {
	    $second_tags = array_keys($first_tags);
	    $second_tags = TagPeer::getRelatedTags($second_tags, array('limit' => 100, 'parent_approved' => 1));
	
	    $second_tags = array_merge($first_tags, $second_tags);
	    
      // uncomment the following three lines to do a third pass
	    /*
	    $third_tags = array_keys($second_tags);
	    $third_tags = TagPeer::getRelatedTags($third_tags, array('limit' => 100, 'parent_approved' => 1));
      $second_tags = array_merge($first_tags, $third_tags);
	    */
	    
	    //$first_tags = array_merge($first_tags, $second_tags);
    //}
    
    // Checking to see if the artworks tags is in the tag cloud and merging them if not
    foreach ($tags as $arrtag)
    {
      foreach((array)$arrtag as $atag)
      {
        if (!isset($first_tags[$atag]))
        {
          $first_tags[$atag] = -1;
        }
      }
    }
    
    $cloud_tags = $first_tags;
    
    // Sort the tags so the artwork tags don't appear at the end or in the beginning
    ksort($cloud_tags);
    ksort($tags);
    
    // Send the required values to the template
    $this->cloud_tags = $cloud_tags;
    if (count(array_keys($cloud_tags)) == count(array_keys($tags)))
    {
    	$this->cloud_tags = TagPeer::getPopulars(null, array('limit' => 20, 'parent_approved' => 1));    
	    foreach ($tags as $atag)
	    {
	      if (!isset($this->cloud_tags[$atag]))
	      {
	        $this->cloud_tags[$atag] = -1;
	      }
	    }
	    ksort($this->cloud_tags);
    }
    while (count($this->cloud_tags) > sfConfig::get('app_home_max_tags', 100))
    {
    	array_splice($this->cloud_tags, rand(0, count($this->cloud_tags)), 1);
    }
  }

  /**
   * Component for showing a list of tags with coloured status
   * 
   * @return null
   */
  function executeViewTagsWithStatus()
  {
    // Get all the tags
    $this->tagStatusArray = $this->artwork->getTags(true, true);
  }
}


?>
