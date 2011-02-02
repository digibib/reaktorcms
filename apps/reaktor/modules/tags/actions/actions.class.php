<?php
/**
 * tags actions
 *
 * PHP version 5
 *
 * @author    Daniel Andre Eikeland <dae@linpro.no>
 * @author    Russ Flynn <russ@linpro.no>
 * @copyright 2008 Linpro AS
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 */

/**
 * The main class for tags actions
 *
 * PHP version 5
 *
 * @author    Daniel Andre Eikeland <dae@linpro.no>
 * @author    Russ Flynn <russ@linpro.no>
 * @copyright 2008 Linpro AS
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 */
class tagsActions extends sfActions
{
  /**
   * Executes index action
   *
   * @return void
   */
  public function executeIndex()
  {
    // This has no route so should not happen
    $this->forward404();
  }

  /**
   * Executes find actions
   *
   * @return void
   */
  public function executeFind()
  {
    $results = array();
    if ($this->getRequestParameter('findtype') == 'user')
    {
      $c = new Criteria();
      $c->add(sfGuardUserPeer::USERNAME, strtolower(trim($this->getRequestParameter('tag'))));
      $thisuser = sfGuardUserPeer::doSelectOne($c);
      if ($thisuser instanceof sfGuardUser && strtolower(trim($this->getRequestParameter('tag'))) != 'admin')
      {
        $this->redirect(Subreaktor::addSubreaktorToRoute('@portfolio?user='.$thisuser->getUsername()));
      }
      else
      {
        $this->forward('sfGuardUser', 'listUsers');
      }
    }
    else
    {
      $tags    = explode(',', urldecode($this->getRequestParameter("tag")));
      foreach ($tags as &$tag)
      {
        $tag = trim($tag);
      }
      
      //sort($tags);
      // Commented out since the customer didn't want tags sorted alphabetically before presented
      
      $this->sortmode = ($this->getRequestParameter('sortby')) ? $this->getRequestParameter('sortby') : 'date';
      $this->sortdirection = ($this->getRequestParameter('sortdirection')) ? $this->getRequestParameter('sortdirection') : 'desc';
      $this->results = $this->processResults($tags);
      $this->tags = $tags;
    }
    $this->mode = 'tag';
    return sfView::SUCCESS;
  }

  /**
   * Shared functionality for processing tags or categories
   *
   * @param array  $searchArray The array of strings to search for
   * @param string $type        The type of search (tag/category)
   *
   * @return array of reaktorFile objects
   */
  protected function processResults($searchArray = array(), $type = "tag")
  {
    // Initialise the arrays we know about
    $results     = array();
    $matchingSet = array();
    
    foreach ($searchArray as $item)
    {
      
    	switch ($type)
      {
        
        case "tag":
          if ($this->getUser()->hasCredential("viewallcontent")) {
            // Staff members are allowed to see everything
            $matchingSet["All"] = TagPeer::getObjectsTaggedWith(trim($item));
          }
          else 
          {
            $matchingSet["All"] = TagPeer::getObjectsTaggedWith(trim($item), array("approved" => 1, "parent_approved" => 1));
          }
          break;
        case "category":
          $matchingSet["genericArtwork"] = CategoryArtworkPeer::getArtworksInCategory(trim($item));
          $matchingSet["Article"]        = ArticleCategoryPeer::getArticlesInCategory(trim($item));
          break;
        default:
          throw new exception ("Unsupported type");
          break;
      }
      
      $matching = array();
      foreach ($matchingSet as $matching)
      {
        foreach ($matching as $match)
        {
          // If it is a file we have matched, we need to extract the artworks
          if ($match instanceof reaktorFile )
          {
            foreach ($match->getParentArtworks() as $artwork)
            {
            	if ($artwork->isViewable())
              {
            	  $results[get_class($artwork)][$item][$artwork->getId()] = $artwork;
              }
            }
          }
          else
          {
            // Skip internal articles, unless you have the staff credentials
            if ($match instanceof Article) 
            {
            	if ($match->getArticleType() == ArticlePeer::INTERNAL_ARTICLE && !$this->getUser()->hasCredential("staff"))
              {
              	continue;
              }
              else
              {
	            	if (Subreaktor::getProvidedLokalreaktor() instanceof Subreaktor)
	              {
	              	if ((!in_array(Subreaktor::getProvidedLokalreaktor()->getId(), $match->getLokalReaktors())) && count($match->getLokalReaktors()) > 0)
	              	{
	              		continue;
	              	}
	              }
	              if (Subreaktor::getProvidedSubreaktor() instanceof Subreaktor)
	              {
	                if (!in_array(Subreaktor::getProvidedSubreaktorReference(), $match->getSubreaktors(true)))
	                {
	                  continue;
	                }
	              }
              }
            }
            $results[get_class($match)][$item][$match->getId()] = $match;
          }
        }
      }
      foreach($results as &$resultItem)
      {
        if (!empty($resultItem[$item]))
        {
          usort($resultItem[$item], array($this, '_sortResults'));
        }
      }
    }
    return $results;
  }

  /**
   * Sorts artworks in a results array
   *
   * @param genericArtwork $a
   * @param genericArtwork $b
   */
  protected function _sortResults($a, $b)
  {
    $match_a = '';
    $match_b = '';
    switch ($this->sortmode)
    {
      case 'title':
        $match_a = strtolower($a->getTitle());
        $match_b = strtolower($b->getTitle());
        break;
      case 'rating':
        if ($a instanceof genericArtwork)
        {  
          $match_a = strtolower($a->getAverageRating());
          $match_b = strtolower($b->getAverageRating());
        }
        break;
      case 'username':
        $match_a = strtolower($a->getUser()->getUsername());
        $match_b = strtolower($b->getUser()->getUsername());
        break;
      case 'date':
      default:
        $match_a = strtolower($a->getCreatedAt());
        $match_b = strtolower($b->getCreatedAt());
        break;
    }
    if ($match_a == $match_b)
    {
      return 0;
    }
    if ($this->sortdirection == 'desc')
    {
      return ($match_a > $match_b) ? -1 : 1;
    }
    else
    {
      return ($match_a < $match_b) ? -1 : 1;
    }
  }

  /**
   * Find category rather than tag
   *
   * @return void
   */
  public function executeFindcategory()
  {
    if ($this->getRequest()->getMethod() == sfRequest::GET)
    {
      $categories = explode(',', urldecode($this->getRequestParameter("category")));
      $this->sortmode = ($this->getRequestParameter('sortby')) ? $this->getRequestParameter('sortby') : 'date';
      $this->sortdirection = ($this->getRequestParameter('sortdirection')) ? $this->getRequestParameter('sortdirection') : 'desc';

      $this->categories = $this->getRequestParameter("category");

      $this->results = $this->processResults($categories, "category");
      $this->setTemplate("find");
      $this->mode = 'category';
      return sfView::SUCCESS;
    }
  }

  /**
   * Used for ajax calls to return a suggest list
   * of tags for tag input form field
   *
   * @return void
   */
  public function executeAutocomplete()
  {
    if (!$this->getRequest()->isXmlHttpRequest())
    {
      die();
    }
    
    $tagStart         = $this->getRequestParameter('tags');
    $excludeFirstLine = false;
    $suggestions      = "";
    
    $suggestedTagArray = TagPeer::getTagsStartingwithStringExludingTaggables($tagStart, 
       array($this->getRequestParameter("id", 0)), 
       $this->getRequestParameter("taggableModel"), null, $this->getRequestParameter("limit"));
    foreach ($suggestedTagArray as $tagObject)
    {
      if (strtolower($tagObject->getName()) == strtolower($tagStart))
      {
        $excludeFirstLine = true;
      }
      $suggestions .= "<li>".$tagObject->getName()."</li>\n";
    }
    
    if (!$excludeFirstLine)
    {
      $suggestions = "<li><span class='informal'>".
                     sfContext::getInstance()->getI18n()->__("New tag (%tag%)", 
                                   array("%tag%" => "</span>".$tagStart."<span class='informal'>")).
                     "</span></li>\n".$suggestions;
    }
    $output = "<ul>\n".$suggestions."</ul>\n";
    
    return $this->renderText($output);
  }

  public function executeAutocompletetag()
  {
    if (!$this->getRequest()->isXmlHttpRequest())
    {
      exit;
    }

    $output = "<ul>\n";
    $s = $this->getRequestParameter('tags');
    $tags = TagPeer::getTagsStartingWithString($s);
    foreach((array)$tags as $tag)
    {
      $output .= "<li>" .$tag->getName(). "</li>\n";
    }
    $output .= "</ul>\n";
    return $this->renderText($output);
  }

  /**
   * adds a tag (ajax call from admin interface)
   *
   * @return void
   */
  public function executeAddTag()
  {
  	$new_tag_name = $this->getRequestParameter('tag_name');
  	if (trim($new_tag_name) != '')
  	{
  		$tag = TagPeer::addNewApprovedTag($new_tag_name, $this->getUser()->getId());
  		if ($tag instanceof Tag)
  		{
  			$retval = sfContext::getInstance()->getI18n()->__('The tag has been added!');
  		}
  		else
  		{
  			$retval = sfContext::getInstance()->getI18n()->__('This tag already exists');
  		}
  	}
  	else
  	{
  		$retval = sfContext::getInstance()->getI18n()->__('Please enter a tag name');
  	}
  	return $this->renderText($retval);
  }
  

  /**
   * Used for adding a tag (Just Ajax calls at present)
   *
   * @return void
   */
  public function executeTagAction()
  {
    if (!$this->getRequest()->isXmlHttpRequest() && sfConfig::get('sf_environment') != 'test')
    {
      die();
    }
    $taggableObject = null;
    $options  = $this->getRequestParameter("options",array());
    switch($this->getRequestParameter("taggable"))
    {
      case "genericArtwork":
      case "reaktorArtwork":
        try
        {
          $taggableObject     = new genericArtwork($this->getRequestParameter("file"));
          $taggableModel      = "ReaktorArtwork";
          $options["extraId"] = "_artwork".$taggableObject->getId();
        }
        catch (Exception $e)
        {
          return $this->renderText($e->getMessage());
        }
        break;
      case "reaktorFile":
      case "artworkFile":
        try
        {
          $taggableObject     = new artworkFile($this->getRequestParameter("file"));
          $taggableModel      = "ReaktorFile";

          if (isset($options["artworkList"]) && $options["artworkList"])
          {
            $options["extraId"] = "_artwork".$options["artworkList"];
          }
          else
          {
            $options["extraId"] = "_file".$taggableObject->getId();
          }
        }
        catch (Exception $e)
        {
          return $this->renderText($e->getMessage());
        }
        break;
      case "Article":
        try
        {
          $taggableObject     = ArticlePeer::retrieveByPK($this->getRequestParameter("file"));
          $taggableModel      = "Article";
          $options["extraId"] = "_article".$taggableObject->getId();
        }
        catch (Exception $e)
        {
          return $this->renderText($e->getMessage());
        }
        break;
      default:
        // There can be cases where we are doing actions without a taggable object, these cases are checked and caught below
        break;
    }

    $tag    = urldecode($this->getRequestParameter("tag"));
    try
    {
 if(function_exists('apc_clear_cache')) apc_clear_cache('user');
      switch($this->getRequestParameter("mode"))
      {
        case "edittagname":
          // Shares tag adding functions so is called "tags" even though this time there is only one
          // So we should treat it as such - any commas this time will cause an error
          $cleanTagArray = stringMagick::cleanTag($this->getRequestParameter("tags"));

          if (!isset($cleanTagArray["error"]))
          {
            if (TagPeer::renameOrMergeTag($tag, $cleanTagArray["cleantag"]))
            {
              $output = json_encode(array("success" => true));
            }
          }
          else
          {
            $output = json_encode(array("error" => $cleanTagArray["error"]));
          }
          
          $this->getResponse()->setHttpHeader("X-JSON", '('.$output.')');
          return sfView::HEADER_ONLY;
          break;
        case "approveall":
          if ($this->getUser()->hasCredential("approvetags"))
          {
            foreach($this->getRequestParameter("unapprovedTags", array()) as $tag)
            {
              $tag = urldecode($tag);
              TagPeer::approveTagByName($tag, $this->getUser()->getGuardUser()->getId());
              HistoryPeer::logAction(6, $this->getUser()->getGuarduser(), TagPeer::retrieveByTagname($tag));
            }
          }
          break;
        case "approve":
          if ($this->getUser()->hasCredential("approvetags"))
          {
            TagPeer::approveTagByName($tag, $this->getUser()->getGuardUser()->getId());
            HistoryPeer::logAction(6, $this->getUser()->getGuarduser(), TagPeer::retrieveByTagname($tag));
          }
          break;
        // Unapprove effectively deletes the tag from the system
        case "unapproveall":
          if ($this->getUser()->hasCredential("tagadministrator"))
          {
            foreach($this->getRequestParameter("unapprovedTags", array()) as $tag)
            {
              TagPeer::unapproveTagByName(urldecode($tag), $this->getUser()->getGuardUser()->getId());
            }
          }
          break;
        case "unapprove":
          if ($this->getUser()->hasCredential("tagadministrator"))
          {
            TagPeer::unapproveTagByName($tag, $this->getUser()->getGuardUser()->getId());
          }
          break;
        case "deleteall":
          if (!$taggableObject)
          {
            throw new Exception("Cannot remove a tag from a non-object");
          }
          elseif ($this->getUser()->hasCredential("approvetags"))
          {
            foreach ($this->getRequestParameter("unapprovedTags", array()) as $tag)
            {
              $taggableObject->removeTag(urldecode($tag));
            }
          }
        break;
        case "delete":
          if (!$taggableObject)
          {
            throw new Exception("Cannot remove a tag from a non-object");
          }
          elseif ($this->getUser()->hasCredential("approvetags") || ($this->getUser()->getGuardUser()->getId() == $taggableObject->getUserId() && $taggableObject->countTags() > 1))
          {
            $taggableObject->removeTag($tag);
          }
          else
          {
            $this->tag_error = sfContext::getInstance()->getI18n()->__('You cannot remove the last tag, it needs to have at least one tag') . "\\n\\n"; 
          }
          break;
        case "add":
          if (!$taggableObject)
          {
            throw new Exception("Cannot add a tag without a taggable object to tag");
          }
          elseif ($this->getUser()->hasCredential("approvetags") || $this->getUser()->hasCredential("tagadministrator") || $this->getUser()->getGuardUser()->getId() == $taggableObject->getUserId())
          {
            //If it contains commas then it is multiple tags
            $tagArray = explode(',', $this->getRequestParameter("tags"));

            //Add the tag
        // Don't do anything if there is no tag
        if( !$this->getRequestParameter("tags")===false )
            foreach ($tagArray as $thisTag)
            {
              $thisTagCleanArray = stringMagick::cleanTag($thisTag);
              if (!isset($thisTagCleanArray["error"]))
              {
                $thisTag = $thisTagCleanArray["cleantag"];
                
                $taggableObject->addTag($thisTag);
                $taggableObject->save();

                // If this is an approved file and tag then we can approve this relationship straight away
                $tagObject = TagPeer::retrieveByTagname($thisTag);

                if ($tagObject)
                {
                  if ($taggableObject instanceof artworkFile && $taggableObject->hasArtwork() && $taggableObject->getParentArtwork()->getStatus() == 3 && $tagObject->getApproved() == 1)
                  {
                    TaggingPeer::setTaggingApproved($tagObject, "ReaktorFile", $taggableObject->getId());
                  }
                  elseif ($taggableObject instanceof genericArtwork && $taggableObject->getStatus() == 3 && $tagObject->getApproved() == 1)
                  {
                    TaggingPeer::setTaggingApproved($tagObject, "ReaktorArtwork", $taggableObject->getId());
                  }
                  elseif ($taggableObject instanceof Article && $taggableObject->isPublished() && $tagObject->getApproved() == 1)
                  {
                    TaggingPeer::setTaggingApproved($tagObject, "Article", $taggableObject->getId());
                  }
                  if ($taggableObject instanceof Article || $taggableObject instanceof genericArtwork || $taggableObject instanceof artworkFile)
                  {
                  	TaggingPeer::setParentUserId($tagObject, $taggableModel, $taggableObject->getId(), $taggableObject->getUserId());
                  }
                }
              }
              else
              {
                $this->tag_error .= $thisTagCleanArray["error"]."\\n\\n";
              }
            }
          }
          break;
        default:
          return $this->renderText("");
          break;
      }
    }
    catch (Exception $e)
    {
      throw $e;
    }

    sfLoader::loadHelpers(array('Partial'));
    if (isset($taggableObject))
    {
      $taggableObject->save();
      return $this->renderText(get_component('tags', 'tagEditList', array("taggableObject"=>$taggableObject, 'tag_error'=>$this->tag_error, 'options' => $options)));
    }
    else
    {
      return $this->renderText(get_component('tags', 'tagEditList', array('options' => $options, "page" => $this->getRequestParameter("page"), "unapproved" => $this->getRequestParameter("unapproved"))));
    }

  }

  /**
   * Alphabetised list of all the tags for approval
   *
   * @return void
   */
  public function executeListTags()
  {
    $c = new Criteria();
    $c->addAscendingOrderByColumn(TagPeer::NAME);
    if ($this->getRequestParameter("unapproved"))
    {
      $c->add(TagPeer::APPROVED, 0);
    }
    $tags = TagPeer::doSelect($c);
     
    //now we need an array of all the first letters.
    $pageLetter          = strtoupper($this->getRequestParameter('page', ''));
    $arrayOfFirstLetters = array();
    $thisList            = array();
    $x                   = 0;
    $y                   = 0;

    foreach ($tags as $entry)
    {
      $firstLetter               = mb_strtoupper(mb_substr($entry->getName(), 0, 1, 'UTF-8'), 'UTF-8');
      $arrayOfFirstLetters[$x++] = $firstLetter;

      if ($this->getRequestParameter("page") == "ALL" || $pageLetter == $firstLetter)
      {
        if (!($this->getRequestParameter("unapproved") && $entry->getApproved() == 1))
        {
          $thisList[$y++] = $entry;
        }
      }
    }
    $arrayOfFirstLetters = array_unique($arrayOfFirstLetters);
    sort($arrayOfFirstLetters);
     
    //Go to the first page that has results, if this one doesn't
    if (!$this->getRequestParameter("page") == "ALL" && !in_array($pageLetter, $arrayOfFirstLetters))
    {
      if ($this->getRequestParameter("unapproved"))
      {
        $this->redirect("@taglist_unapproved?page=".$arrayOfFirstLetters[0]);
      }
      elseif(!empty($arrayOfFirstLetters))
      {
        $this->redirect("@taglist?page=".$arrayOfFirstLetters[0]);
      }
    }
    $this->page      = $pageLetter;
    $this->pageLinks = $arrayOfFirstLetters;
    $this->tags      = $thisList;
  }
}
