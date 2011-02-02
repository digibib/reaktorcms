<?php
/**
 * Components used for artwork lists
 * 
 * PHP version 5
 *
 * @author    juneih <juneih@linpro.no>
 * @copyright 2008 Linpro
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 */
class artworkComponents extends sfComponents
{
  /**
   * Display the last created artworks
   *
   * @return void
   */
  function executeLastArtworks()
  {    

    $cache = reaktorCache::singleton($this->genExcludeKey());

// Ticket 25288 
    if ($this->last )
    {
      $list = (array)$cache->get();
      foreach($this->last as $art)
      {
        if ($art instanceof genericArtwork)
        {
          $list[] = $art->getId();
        }
      }
      $list = array_unique($list);
      $cache->update($list);
    }
    else 
    
    { 
      if(!$this->limit)//If limit isn't set, use configuration instead
      {  
        $this->limit = sfConfig::get('app_home_list_length', 5);
      }
      $exclude = $cache->get();

      //The first artwork could be displayed another place on the site, and should be excluded in the list,
      //thus to keep the limit we add one more to the list 
      $count = ($this->exclude_first) ? ($this->limit+$this->exclude_first) : $this->limit;


    if (!$this->last )
      $this->last = ReaktorArtworkPeer::getLatestSubmittedApproved($count+count($exclude), null, $this->random, $this->subreaktor, $this->lokalreaktor);

      //Remove first if parameter is set
      if($this->exclude_first)
      {
        array_shift($this->last);
      }

      if ($exclude)
      {
        $last = $this->last;
        foreach($last as $key => $artwork)
        {
          if (in_array($artwork->getId(), $exclude))
          {
            unset($this->last[$key]);
          }
        }
      }

      // Make sure we don't return more then requested
      if (count($this->last) > $this->limit)
      {
        $this->last = array_slice($this->last, 0, $this->limit);
      }
    }

    $this->image = (isset($this->image)) ? $this->image : '';
    $this->tags = (isset($this->tags)) ? $this->tags : '';
    $this->subreaktor = (isset($this->subreaktor)) ? $this->subreaktor : '';
    $this->lokalreaktor = (isset($this->lokalreaktor)) ? $this->lokalreaktor : '';
    $this->feed_description = sfContext::getInstance()->getI18N()->__('Latest artworks');
    $this->feed_slug = 'latest_artworks';
  }
  
  function executeListPresentation()
  {
  	
  }
  
  /**
   * Display the latest commented artwork
   *
   * @return void
   */
  function executeLatestCommented()
  {
    $this->latestCommented = ReaktorArtworkPeer::getLatestCommented(sfConfig::get('app_home_list_length', 5));
  }

  /**
   * Display images of last artworks from user
   *
   * @return void
   */
  function executeLastArtworksFromUser()
  {
    if (isset($this->portfolio))
    {
      if (!$this->orderBy)
      {
        $this->orderBy = $this->getRequestParameter('orderBy');
      }
      $artworks = ReaktorArtworkPeer::getLatestSubmittedApprovedPaginated(SfConfig::get('app_profile_portfolio_pagination', 21), $this->id, $this->orderBy);
      $artworks->setPage($this->getRequestParameter('page', 1));
      $artworks->init();
      $this->last = $artworks->getResults();
      $this->artworks = $artworks;
      
    } else {     
      $this->last = ReaktorArtworkPeer::getLatestSubmittedApproved(6, $this->id, null, null, null, true, false);
      $this->mypage = true;
    }
    $this->viewingMyOwnPage = $this->getUser()->getId() == $this->id;
  }
  
  /**
   * List a users most popular artworks
   * 
   * @return void
   */
  function executeListUsersPopularArtworks()
  { 
    $count = $this->limit ? $this->limit : sfConfig::get('app_home_list_length', 5);
    $this->artworks = ReaktorArtworkPeer::mostPopularArtworks($this->subreaktor, $count, $this->lokalreaktor, $this->user);
  }
  
  /**
   * List a users most popular artworks
   * 
   * @return void
   */
  function executeListReaktorsLatestArtworks()
  {    
    $this->artworks = ReaktorArtworkPeer::getLatestSubmittedApproved(6, null, null, $this->subreaktor);
    array_shift($this->artworks);
  }
  
  /**
   * List a subreaktors most popular artworks
   * 
   * @return void
   */
  function executeListReaktorsPopularArtworks()
  {
    //If limit isn't set, use configuration instead
    $count = $this->limit ? $this->limit : sfConfig::get('app_home_list_length', 6);
    $this->subreaktor = (isset($this->subreaktor)) ? $this->subreaktor : '';
    $this->lokalreaktor = (isset($this->lokalreaktor)) ? $this->lokalreaktor : '';
    $this->artworks = ReaktorArtworkPeer::mostPopularArtworks($this->subreaktor, $count, $this->lokalreaktor);

    // Throw these artworks into a "don't show these artworks again on this page" list
    $cache = reaktorCache::singleton($this->genExcludeKey());
    $list = (array)$cache->get();
    foreach((array)$this->artworks as $artwork)
    {
      $list[] = $artwork->getId();
    }
    $list = array_unique($list);
    $cache->update($list);

    $this->text_or_artwork = (isset($this->text_or_artwork)) ? $this->text_or_artwork : '';
    $this->image = (isset($this->image)) ? $this->image : '';
    $this->feed_description = (isset($this->feed_description)) ? $this->feed_description : sfContext::getInstance()->getI18N()->__('Most popular');
    $this->feed_slug = (isset($this->feed_slug)) ? $this->feed_slug : 'most_popular';
  }

  private function genExcludeKey()
  {
    static $key = null;

    if ($key === null)
    {
      $key = "exclude_artwork_ids";
      $sub = Subreaktor::getProvidedSubreaktorReference();
      $lok = Subreaktor::getProvidedLokalReference();
      $key = "{$key}_sub{$sub}_lok{$lok}";
    }
    return $key;
  }
  
  /**
   * Lists related artworks
   * 
   * @return void Renders the seeAlso component template 
   */
  function executeSeeAlso()  
  {
    $onlyApproved          = !$this->editmode;
    $this->relatedArtworks = $this->artwork->getRelatedArtworks(0, $onlyApproved);
    $this->otherpeoplelike = array();
    $this->otherArtworks   = array();
    $this->otherpeoplelike = RelatedArtworkPeer::getOtherRelatedArtworkObjects($this->artwork->getId(),  sfConfig::get("app_artwork_other_usrs_also_like", 6));
    
    if (count($this->relatedArtworks) == 0)
    {
    	$this->otherArtworks = ReaktorArtworkPeer::getArtworksByUser($this->artwork->getUser(), sfConfig::get("app_artwork_other_by_user", 6), true, array($this->artwork));
    }
  }

  /**
   * Display the link to artworks dropdown, and the see also list. When an artwork is
   * linked to another artwork, this adds to the see also list. 
   *
   * @return void
   */
  function executeLinkRelated()
  {
    if ($this->editmode)
    {
      $onlyApproved = false;
    }
    else
    {
      $onlyApproved = true;
    }
    
    //Find the related artworks
    $related_artworks = $this->artwork->getRelatedArtworks(null, $onlyApproved);
    
    //Get the id's of the related artworks
    $related = array();
    foreach($related_artworks as $related_artwork)
    {
      $related[] = $related_artwork->getId();
    }
    //Include the artwork itself
    $related[] = $this->artwork->getId(); 
        
                 
    //Find all artworks that aren't related 
    if ($this->getUser()->hasCredential("createcompositeartwork"))
    {
      $this->artworks = ReaktorArtworkPeer::getUnrelatedArtworks(null, null, $related, $onlyApproved, 5);
    }
    else
    {
      $this->artworks = ReaktorArtworkPeer::getUnrelatedArtworks($this->artwork->getUser()->getId(), $this->artwork->getId(), $related, $onlyApproved, 5);
    }
    
  }

  /**
   * Display recommended artwork given a subreaktor
   *
   * @return void
   */
  function executeRecommended()
  { 
    static $cache = null;
    if ($cache === null && $cache = reaktorCache::singleton($this->genExcludeKey()));

    $recommended_artwork = RecommendedArtworkPeer::getRecommendedArtwork($this->subreaktor, $this->lokalreaktor, true);
    $this->artwork       = $recommended_artwork ? new genericArtwork($recommended_artwork->getArtwork()) : null ;

    if ($recommended_artwork)
    {
      // Throw these artworks into a "don't show these artworks again on this page" list
      $list = (array)$cache->get();
      $list[] = $this->artwork->getId();
      $list = array_unique($list);
      $cache->update($list);
    }
  }

  /**
   * Show the category and subreaktor/format selections
   * 
   * @return void
   */
  function executeCategorySelect()
  {
    $eligibleLokalReaktors = array();
    if(!($this->article && $this->article->getArticleType() == ArticlePeer::HELP_ARTICLE)) //Don't display lokalreaktor on help articles
    {
      if ($this->getUser()->hasCredential("editusercontent")) //Allow admin users to add additional lokalreaktors to artwork
      {
    	  $eligibleLokalReaktors = SubreaktorPeer::getLokalReaktors();
      }
      elseif ($this->artwork)
      {
        $eligibleLokalReaktors = $this->artwork->getLokalreaktors();
      }
    }
    
    // First we need a list of eligible subreaktors and categories for this file
    if ($this->artwork)
    {
      $eligibleSubreaktors = SubreaktorIdentifierPeer::getEligibleSubreaktors($this->artwork);
    }
    else
    {
    	$eligibleSubreaktors = SubreaktorPeer::getSubReaktors(false,true);
    }
    
    // The first result should never be empty, but if admin are being silly, we should return something
    // for the user if there are no linked subreaktors - we'll give them the whole list to choose from.
    if (empty($eligibleSubreaktors))
    {
     $eligibleSubreaktors = SubreaktorPeer::doSelectWithI18n(new Criteria());
    }
    elseif(count($eligibleSubreaktors) == 1)
    {
      $subreaktor = current($eligibleSubreaktors);
      $this->artwork->addSubreaktor($subreaktor->getId());
      
      // If there is only one eligible subreaktor, the checkboxes will never be checked, so we should set the editorial team now
      if ($this->artwork->isDraft())
      {
        $this->artwork->resetEditorialTeam();
        $this->artwork->save();    
      }
    }
    
    // Get the subreaktors already associated with this file/artwork
    // This function returns references (film, lyd, etc) from subreaktor table
    if ($this->artwork)
    { 
      $artworkSubreaktors = $this->artwork->getSubreaktors(true);
    }
    elseif ($this->article)
    {
    	$artworkSubreaktors = $this->article->getSubreaktors(true);
    }
       
    // Ok, lets pass the arrays to the template for parsing
    $this->eligibleSubreaktors   = $eligibleSubreaktors;
    $this->eligibleLokalReaktors = $eligibleLokalReaktors;
    $this->artworkSubreaktors    = array_keys($artworkSubreaktors);
    
  } 
 
  /**
   * Show the list of currently selected categories
   * 
   * @return void
   */
  function executeCategoryList()
  {
    if ($this->artwork)
    {
	  	$artworkSubreaktors = $this->artwork->getSubreaktors();
	    $artworkCategories   = $this->artwork->getCategories(); // Returns array of cats with id as key
    }
    elseif ($this->article)
    {
      $artworkSubreaktors = $this->article->getSubreaktors();
      $artworkCategories  = $this->article->getCategories(); // Returns array of cats with id as key
    }
    $eligibleCategories  = CategorySubreaktorPeer::getCategoriesUsedBySubreaktor($artworkSubreaktors, false);
    $otherCategories     = array_diff($artworkCategories, $eligibleCategories);
    
    $this->eligibleCategories  = $eligibleCategories;
    $this->artworkCategories   = array_keys($artworkCategories);

    $this->otherCategories     = $otherCategories;
  }
 
  /**
   * Display artwork recommendation information, i.e which subreaktors an artwork
   * is recommended in, and where it can be recommended
   * 
   * @return void
   */
  function executeRecommendArtwork()
  {
    //First we find all the recommendations an artwork has 
    $this->recommendations  = RecommendedArtworkPeer::getArtworkRecommendations($this->artwork->getId());
    
    //We now check which subreaktors the artwork belongs to, both in subreaktors and lokalreaktor:subreaktor
    //because we want to display the possible subreaktors an artwork can be recommended in

    $subreaktors      = SubreaktorArtworkPeer::getSubreaktorsByArtwork($this->artwork->getId());
    $subreaktor_array = array();

    if (sfContext::getInstance()->getUser()->hasCredential('viewothereditorialteams'))
        foreach ($subreaktors as $subreaktor)
        {
          $subreaktor_array[$subreaktor->getSubreaktor()->getId()] =  $subreaktor->getSubreaktor()->getReference();
        }      

    $lokalreaktors       = LokalreaktorArtworkPeer::getLokalreaktorsByArtwork($this->artwork->getId());
    foreach ($lokalreaktors as $lokalreaktor)
    {

    $canRecommend=false;
    foreach (sfContext::getInstance()->getUser()->getGuardUser()->getEditorialTeams() as $aTeam)
        if($this->artwork->getEditorialTeam()->getId()==$aTeam->getId()) $canRecommend=true;

if (sfContext::getInstance()->getUser()->hasCredential('viewothereditorialteams') || $canRecommend)
              foreach ($subreaktors as $subreaktor)
              {
                $subreaktor_array[$lokalreaktor->getSubreaktor()->getId().':'.$subreaktor->getSubreaktor()->getId()] = 
                $lokalreaktor->getSubreaktor()->getReference().':'.$subreaktor->getSubreaktor()->getReference();
              }
    }
    
    //We don't want the user to recommend an artwork in a subreaktor where it's already recommended, so
    //we remove those reaktors from the dropdown
    foreach ($this->recommendations as $recommendation)
    {
      if ($recommendation->getLocalsubreaktor()->getId())
      {
        unset($subreaktor_array[$recommendation->getSubreaktor()->getId().':'.$recommendation->getLocalsubreaktor()->getId()]);
      }
      else
      {
        unset($subreaktor_array[$recommendation->getSubreaktor()->getId()]);
      }
    }

    $this->subreaktor_array = $subreaktor_array;
  }
  
  function executeEditorialTeamArtwork()
  {
  	$crit = new Criteria();
  	$crit->add(sfGuardGroupPeer::IS_ENABLED, true);
  	$crit->add(sfGuardGroupPeer::IS_EDITORIAL_TEAM, true);
  	$available_teams = SfGuardGroupPeer::doSelect($crit);
  	$this->available_teams = array();
  	foreach ($available_teams as $aTeam)
  	{
  		$this->available_teams[$aTeam->getId()] = $aTeam->getDescription();
  	}
  }
    
  /**
   * Embed link component for correctly displaying links to embed artwork in another site
   *
   * @return void the component is rendered
   */
  function executeEmbedLink()
  {
  	$options = array();
  	
  	if (isset($this->options)) $options = $this->options;

  	//sfLoader::loadHelpers('Javascript');

    switch ($this->file->getIdentifier())
    {
      case 'image':
		    $img_title = $this->getRequest()->getHost() . ' - ' . $this->file->getTitle();
		    $this->link = link_to(image_tag('http://' . $this->getRequest()->getHost() . contentPath($this->file), 
		                          array('title' => $img_title, 
		                                'alt' => $this->img_title)), 
		                                'http://' . $this->getRequest()->getHost() . url_for($this->artwork->getLink()), 
		                          array('title' => $this->file->getTitle(), 
		                                'alt' => $this->file->getTitle()));
		    $this->bb_link   = '[url=' . 'http://' . $this->getRequest()->getHost() . url_for($this->artwork->getLink()) . '][img]' . 'http://' . $this->getRequest()->getHost() . contentPath($this->file) . '[/img][/url]';
      	$this->file_path = 'http://'.$this->getRequest()->getHost().contentPath($this->file);
		    break;
      case 'pdf':
        $img_title = $this->getRequest()->getHost().' - '.$this->file->getTitle();
        //Added .jpg to the end of this as forums and some sites don't like image extensions they don't recognise! Updated content server to allow it.
        $this->link = link_to(image_tag('http://'.$this->getRequest()->getHost() . contentPath($this->file, 'thumb').'.jpg', 
                              array('title' => $img_title, 
                                    'alt' => $this->img_title)), 
                                    'http://' . $this->getRequest()->getHost().url_for($this->artwork->getLink()), 
                              array('title' => $this->file->getTitle(), 
                                    'alt' => $this->file->getTitle()));
        $this->bb_link   = '[url=' . 'http://' . $this->getRequest()->getHost().url_for($this->artwork->getLink()).'][img]'.'http://' . $this->getRequest()->getHost() . contentPath($this->file, 'thumb') . '.jpg[/img][/url]';
        $this->file_path = 'http://'.$this->getRequest()->getHost().contentPath($this->file);
        break;
      case 'video':
        $this->link  = "<embed src=\"http://".$this->getRequest()->getHost()."/flowplayer/FlowPlayerLight.swf?config={embedded:true,";
        $this->link .= "autoRewind:true, loop:false, videoFile:'".contentPath($this->file)."', ";
        $this->link .= "baseURL:'http://".$this->getRequest()->getHost()."/'} \" ";
        $this->link .= "width=\"480\" height=\"360\" ></embed>";
        $this->link .= '<br />'.link_to('http://'.$this->getRequest()->getHost().' - '.$this->artwork->getTitle().' '.sfContext::getInstance()->getI18N()->__('by').' '.$this->artwork->getUser()->getUsername(), 
                                    'http://' . $this->getRequest()->getHost() . url_for($this->artwork->getLink()), 
                              array('title' => $this->file->getTitle(), 
                                    'alt' => $this->file->getTitle()));
        break;
      case 'text':
        $img_title = $this->getRequest()->getHost().' - '.$this->file->getTitle();
        $this->link = link_to(image_tag('http://' . $this->getRequest()->getHost().contentPath($this->file), 
                              array('title' => $img_title, 
                                     'alt' => $this->img_title)), 
                                     'http://' . $this->getRequest()->getHost().url_for($this->artwork->getLink()), 
                              array('title' => $this->file->getTitle(), 
                                    'alt' => $this->file->getTitle()));
        $this->bb_link = '[url=' . 'http://' . $this->getRequest()->getHost() . url_for($this->artwork->getLink()) . '][img]' . 'http://' . $this->getRequest()->getHost() . contentPath($this->file, 'thumb') . '.jpg[/img][/url]';
        $this->file_path = 'http://'.$this->getRequest()->getHost().contentPath($this->file);
        break;
      case 'audio':
        $this->link  = '<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" ';
        $this->link .= 'codebase="http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,0,0" ';
        $this->link .= 'width="400" height="168">';
        $this->link .= '<param name="allowScriptAccess" value="sameDomain" />';
        $this->link .= '<param name="quality" value="high"/>';
        $this->link .= '<param name="bgcolor" value="#E6E6E6"/>';
        $this->link .= '<embed src="http://'.$this->getRequest()->getHost().'/xspf_player/xspf_player.swf?playlist_url=http://'.$this->getRequest()->getHost().url_for($this->artwork->getLink('xml').'&format=xspf"').'"';
        $this->link .= 'quality="high" bgcolor="#E6E6E6" ';
        $this->link .= 'name="xspf_player" allowscriptaccess="sameDomain" ';
        $this->link .= 'type="application/x-shockwave-flash" ';
        $this->link .= 'pluginspage="http://www.macromedia.com/go/getflashplayer" ';
        $this->link .= 'align="center" height="168" width="400"></embed>';
        $this->link .= '</object>';
        $this->link .= '<br />'.link_to('http://'.$this->getRequest()->getHost().' - '.$this->artwork->getTitle().' '.sfContext::getInstance()->getI18N()->__('by').' '.$this->artwork->getUser()->getUsername(), 
                                    'http://' . $this->getRequest()->getHost() . url_for($this->artwork->getLink()), 
                              array('title' => $this->file->getTitle(), 
                                    'alt' => $this->file->getTitle()));
        break;
    }
    
  }
  
  public function executeUserArtworkListElement()
  {
  }
  
}

