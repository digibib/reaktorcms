<?php

/**
 * Subclass for representing a row from the 'article' table.
 *
 * 
 *
 * @package lib.model
 */ 
class Article extends BaseArticle
{
  private $_year, $_month;

  
  /**
   * Get related articles
   *
   * @param  bool     Only published articles
   * @return array of related article
   */
  public function getRelatedArticles($pub = false)
  {
    return ArticleArticleRelationPeer::getRelatedArticles($this->getId(), $pub);
  }
  
  public function getParsedContent()
  {
  	$content = $this->getContent();
  	$content = preg_replace('/(?<!\\\\)\[feed(?::\w+)?=(.*?)?\](.*?)\[\/feed(?::\w+)?\]/sie',
												  	"get_component('feed', 'foreignReader', array('feedurl' => '\\1', 'items' => '\\2', 'source' => 'article'))",
												  	$content);
		return $content;
  }
  
  /**
   * Returns the ingress/intro text
   *
   * @return string
   */
  public function getIntro()
  {
  	return $this->getIngress();
  }
  
  public function getParsedIngress()
  {
  	$ingress = parent::getIngress();
  	$ingress = preg_replace('/(?<!\\\\)\[feed(?::\w+)?=(.*?)?\](.*?)\[\/feed(?::\w+)?\]/sie',
												  	"get_component('feed', 'foreignReader', array('feedurl' => '\\1', 'items' => '\\2', 'source' => 'article'))",
												  	$ingress);
	return $ingress;
  }
  
  /**
   * Returns the number of tags
   *
   * @param bool $include_unapproved
   * @return int
   */
  public function countTags()
  {
    return count($this->getTags());
  }

  /**
   * Create an array of arrays
   */
  public function getUnrelatedArticles()
  {
     //Find the related articles
    $related_articles = $this->getRelatedArticles();
    
    //Get the id's of the related artworks
    $related = array();
    $related_help_articles = array();
    foreach($related_articles as $related_article)
    {

      $related_help_articles = array();
    }
    
    //Include the artwork itself
    $related[] = $this->getId();

    //Get the unrelated artworks
    $c = new Criteria();
    $c->add(ArticlePeer::ID, $related, Criteria::NOT_IN);

    // Not all article types can relate to mypage and internal articles
    switch($this->getArticleType())
    {
      case ArticlePeer::HELP_ARTICLE:
      case ArticlePeer::REGULAR_ARTICLE:
      case ArticlePeer::THEME_ARTICLE:
      case ArticlePeer::FOOTER_ARTICLE:
      case ArticlePeer::SPECIAL_ARTICLE:
        $critA = $c->getNewCriterion(ArticlePeer::ARTICLE_TYPE, ArticlePeer::MY_PAGE_ARTICLE, Criteria::NOT_EQUAL);
        $critB = $c->getNewCriterion(ArticlePeer::ARTICLE_TYPE, ArticlePeer::INTERNAL_ARTICLE, Criteria::NOT_EQUAL);
        $critA->addAnd($critB);
        $c->add($critA);
        break; 
      case ArticlePeer::MY_PAGE_ARTICLE:
        $c->add(ArticlePeer::ARTICLE_TYPE, ArticlePeer::INTERNAL_ARTICLE, Criteria::NOT_EQUAL);
        break;      
    }

// List only published articles - Ticket 22105
    $c->add(ArticlePeer::STATUS, ArticlePeer::PUBLISHED);
    $articles = ArticlePeer::doSelect($c);

    $c->add(ArticlePeer::ARTICLE_TYPE,ArticlePeer::HELP_ARTICLE);
    $c->addJoin(ArticlePeer::ID, ArticleSubreaktorPeer::ARTICLE_ID);
    $c->addAscendingOrderByColumn(ArticlePeer::BASE_TITLE);

    $help_articles = ArticlePeer::doSelect($c);


    $article_types = ArticlePeer::getArticleTypes();
    
    $unrelated_articles = array();

    foreach($articles as $article)
    {
    	if ($article->getArticleType()   )
    	{

    	if($article->getArticleType()!=ArticlePeer::HELP_ARTICLE) {
    	  $unrelated_articles[$article_types[$article->getArticleType()]][$article->getId()] = $article->getTitle();
    	  } else {
    	  
    	  
    	  
    	  }
    	}
    }
    
    $related_help_articles = array();

if(is_array($help_articles))
    	  foreach($help_articles as $article){
    	  
$sb=$article->getSubReaktors(true,true);
    	    	  $unrelated_articles[$article_types[ArticlePeer::HELP_ARTICLE].' - '.current  ( $sb) ][$article->getId()] = $article->getTitle();
      	 

}
    return $unrelated_articles;
    
  }
  
  /**
   * Publishes an article
   * 
   * @return void
   */
  public function publish()
  {
    $this->setStatus(ArticlePeer::PUBLISHED);
  }

  /**
   * Link to article's view page
   *
   * @return Link to article's view page
   */
  public function getLink()
  {
  if(sfConfig::get("admin_mode")){
    return '@article_admin?permalink='.urlencode($this->getPermalink());
} else {
    return '@article?permalink='.urlencode($this->getPermalink()) ;
    }

  }
  
  /**
   * Relates the article to an artwork
   *
   * @param genericArtwork|reaktorArtwork|integer $artwork
   */
  public function relateToArtwork($artwork)
  {
    $artwork_id = null;
    if (!is_int($artwork))
    {
      $artwork_id = $artwork->getId();
    }
    else
    {
      $artwork_id = $artwork;
    }
    $crit = new Criteria();
    $crit->add(ArticleArtworkRelationPeer::ARTICLE_ID, $this->getId());
    $crit->add(ArticleArtworkRelationPeer::ARTWORK_ID, $artwork_id);
    ArticleArtworkRelationPeer::doInsert($crit);
  }
  
  /**
   * Returns an array of related artworks
   *
   * @return array|genericArtwork
   */
  public function getRelatedArtwork()
  {
    $artwork = array();
    foreach ($this->getArticleArtworkRelations() as $anAARelation)
    {
      $artwork[$anAARelation->getReaktorArtwork()->getId()] = new genericArtwork($anAARelation->getReaktorArtwork());
    }
    return $artwork;
  }
  
  /**
   * Removes an artwork from the list of related artworks
   *
   * @param genericArtwork|reaktorArtwork|integer $artwork
   */
  public function removeRelatedArtwork($artwork)
  {
    $artwork_id = null;
    if (!is_int($artwork))
    {
      $artwork_id = $artwork->getId();
    }
    else
    {
      $artwork_id = $artwork;
    }
    $crit = new Criteria();
    $crit->add(ArticleArtworkRelationPeer::ARTICLE_ID, $this->getId());
    $crit->add(ArticleArtworkRelationPeer::ARTWORK_ID, $artwork_id);
    ArticleArtworkRelationPeer::doDelete($crit);
  }

  /**

   * Return the taggable model string to use in the tagging table
   *
   * @return string
   */
  public function getTaggableModel()
  {
    return "Article";
  }  
  
  /**
   * Get all the articles a subreaktor is connected to.
   *
   * @param boolean $reference Return reference if true, id if false
   * @return array Of either subreaktor references (string) or id's (integer)
   */
  public function getSubreaktors($reference = false,$name=false)
  {
  	$crit = new Criteria();
  	$crit->add(ArticleSubreaktorPeer::ARTICLE_ID, $this->getId());

  	$subreaktors = array();
  	if($reference)
  	{
  	  $res = ArticleSubreaktorPeer::doSelectJoinSubreaktor($crit);
  	  foreach ($res as $row)
      {
      if($name){
        $subreaktors[$row->getSubreaktorId()] = $row->getSubreaktor()->getName();
      }else{
        $subreaktors[$row->getSubreaktorId()] = $row->getSubreaktor()->getReference();
      }
      }
  	}
  	else
  	{
  	  $res = ArticleSubreaktorPeer::doSelect($crit);
    	foreach ($res as $row)
    	{
    		$subreaktors[$row->getSubreaktorId()] = $row->getSubreaktorId();
    	}
  	}
  	return $subreaktors;
  }
  
  public function getLokalReaktors()
  {
  	$retarr = array();
  	foreach ($this->getSubreaktors() as $subreaktor_id => $subreaktor)
  	{
  		if (Subreaktor::getById($subreaktor)->isLokalReaktor())
  		{
  			$retarr[$subreaktor_id] = $subreaktor; 
  		}
  	}
  	return $retarr;
  }
  
  public function getCategories()
  {
  	$crit = new Criteria();
  	$crit->add(ArticleCategoryPeer::ARTICLE_ID, $this->getId());
  	$res = ArticleCategoryPeer::doSelectJoinCategory($crit);
  	$categories = array();
  	foreach ($res as $row)
  	{
  		$categories[$row->getCategory()->getId()] = $row->getCategory()->getName();
  	}
  	return $categories;
  }
  
  protected function _addSubreaktor($subreaktor)
  {
  	$as = new ArticleSubreaktor();
  	$as->setArticle($this);
  	$as->setSubreaktor($subreaktor);
  	$as->save();
  }
  
  /**
   * Add subreaktor to the article
   *
   * @param integer|string $subreaktor ID or reference string
   */
  function addSubreaktor($subreaktor)
  {
    if (is_numeric($subreaktor))
    {
     $subreaktor = Subreaktor::getById($subreaktor);
    }
    else
    {
      $subreaktor = Subreaktor::getByName($subreaktor);
    }
    
    $this->_addSubreaktor($subreaktor);
  }
  
  /**
   * Compare the new list of subreaktors to the old one, if there are differences, 
   * add or delete to make sure the database is updated.
   * 
   * This is useful when using checkboxes in forms to keep score. 
   *
   * @param array $newSubreaktors
   * @param array $oldSubreaktors
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
   * Remove subreaktor from the article
   *
   * @param integer $subreaktor_id
   */
  function removeSubreaktor($subreaktor_id)
  {
    $c = new Criteria();
    $c->add(ArticleSubreaktorPeer::SUBREAKTOR_ID, $subreaktor_id);
    $c->add(ArticleSubreaktorPeer::ARTICLE_ID, $this->getId());
    ArticleSubreaktorPeer::doDelete($c);
    
    ArticleCategoryPeer::removeAllInSubreaktor($this, $subreaktor_id);
  }
  
  /**
   * Adds a category to the article
   *
   * @param integer $categoryId
   */
  function addCategory($categoryId)
  {
  	$ac = new ArticleCategory();
  	$ac->setArticle($this);
  	$ac->setCategoryId($categoryId);
  	$ac->save();
  }
  
  /**
   * Removes a category from the article
   *
   * @param integer $categoryId
   */
  function removeCategory($categoryId)
  {
  	$crit = new Criteria();
  	$crit->add(ArticleCategoryPeer::CATEGORY_ID, $categoryId);
  	$crit->add(ArticleCategoryPeer::ARTICLE_ID, $this->getId());
  	$res = ArticleCategoryPeer::doDelete($crit);
  }
  
  public function getBannerFile()
  {
    return ArticleFilePeer::retrieveByPK($this->getBannerFileId());
  }

  /**
   * Returns a article teaser of $max length
   * 
   * @param int $max        Default to app_articles_teaser_len
   * @param int &$txt_len   Will be set to the entire article length
   * @param int &$cut_len   Will be set to the teaser length
   * @return string         The html tag stripped teaser
   */
  public function getTeaser($max = 0, &$txt_len = 0, &$cut_len = 0, $introOrContent = ArticlePeer::CONTENT)
  {
    if ($introOrContent == ArticlePeer::INGRESS)
    {
      $txt = $this->getIngress();
    }
    else//if($introOrContent == ArticlePeer::CONTENT)
    {
      $txt = $this->getContent();
    }
    if (!$max)
    {
      $max = sfConfig::get('app_articles_teaser_len', 80);
    }

    $txt = strip_tags($txt);
    $txt_len = strlen($txt);

    return stringMagick::chop($txt, $max, $txt_len, $cut_len);
  }

  public function setCustom($row)
  {
    self::setID($row[3]);
    self::setDate($row[0], $row[1]);
    self::setArticleType($row[2]);
    self::setPermalink($row[5]);
    if (!is_null($row[6]) && in_array($row[2], ArticlePeer::getTranslatableTypes()))
    {
      self::setTitle($row[6]);
    }
    else
    {
      self::setTitle($row[4]);
    }
  }
  private function setDate($year, $month)
  {
    $this->_year = $year;
    $this->_month = $month;
  }
  public function getYear()
  {
    return $this->_year ? $this->_year : date("Y", strtotime(self::getCreatedAt()));
  }
  public function getMonth()
  {
    return $this->_month ? $this->_month : date("n", strtotime(self::getCreatedAt()));
  }
  public function getId()
  {
    $id = parent::getId();
    return $id ? $id : 0;
  }

  /**
   * Required by the Feed plugin to generate routes automatically
   *
   * @return string The culture in question, "no" if none specified
   */
  public function getFeedSfCulture()
  {
    return sfContext::getInstance()->getRequest()->getParameter('sf_culture', 'no');
  }

  /**
   * Returns whether or not the article is in draft stage
   * 
   * @return bool
   */
  public function isDraft()
  {
    return parent::getStatus() == ArticlePeer::DRAFT;
  }

  /**
   * Returns whether or not the article has been published
   *
   * @return boolean
   */

  public function isPublished()
  {
    return parent::getStatus() == ArticlePeer::PUBLISHED;
  }

  /**
   * Returns whether or not the article has been archived
   * 
   * @return bool
   */
  public function isArchived()
  {
    return parent::getStatus() == ArticlePeer::ARCHIVED;
  }

  /**
   * Returns whether or not the article has been archived
   * 
   * @return void
   */
  public function isDeleted()
  {
    return parent::getStatus() == ArticlePeer::DELETED;
  }

  /**
   * Changes the status of the article to be in draft mode
   * 
   * @return $this
   */
  public function setDraft()
  {
    $this->setStatus(ArticlePeer::DRAFT);
    return $this;
  }

  /**
   * Changes the status of the article to be published
   * 
   * @return $this
   */
  public function setPublished()
  {
    $this->setStatus(ArticlePeer::PUBLISHED);
    parent::setStatus(ArticlePeer::PUBLISHED);
    TaggingPeer::setAllTaggingsApproved($this);

    return $this;
  }

  /**
   * Changes the status of the article to be archived
   * 
   * @return $this
   */
  public function setArchived()
  {
    $this->setStatus(ArticlePeer::ARCHIVED);
    return $this;
  }

  /**
   * FAIL. Propel owns this method name so we have to take argument.
   * Just pass anything, it will be ignored.
   * 
   * @param mixed $arg 
   * @return void
   */
  public function setDeleted($arg)
  {
    $this->setStatus(ArticlePeer::DELETED);
    return $this;
  }
  
  /**
   * Return translated title for footer articles or base title for the others
   *
   * @return string the title
   */
  public function getTitle($lang = null)
  {
    if (!$lang && (!$this->hasTranslatableTitle() || !parent::getTitle()))
    {
      return $this->getBaseTitle() != "" ? $this->getBaseTitle() : sfContext::getInstance()->getI18n()->__("No title");
    }
    else
    {
      if ($lang)
      {
        $this->setCulture($lang);
      }
      return parent::getTitle();
    }
    $this->setCulture(sfContext::getInstance()->getUser()->getCulture());
  }
  
  /**
   * Set the non-translated (backup) title
   *
   * @param unknown_type $title
   */
  public function setTitle($title)
  {
    $this->setBaseTitle($title);
  }
  
  /**
   * Set the translated titles
   *
   * @param array $titles an array of culture=>title pairs
   */
  public function setI18nTitles($titles = array())
  {
    foreach ($titles as $culture => $title)
    {
      $this->setCulture($culture);
      parent::setTitle($title);
    }
    $this->setCulture(sfContext::getInstance()->getUser()->getCulture());
  }
  
  /**
   * Check if an article has a translatable title or not
   * Moved this here so new ones can be added/removed from a single location
   *
   * @return boolean true if article is one of the allowed translatable types
   */
  public function hasTranslatableTitle()
  {
    if (in_array($this->getArticleType(), ArticlePeer::getTranslatableTypes()))
    {
      return true;
    }
    return false;
  }
  
  public function getStatus()
  {

    $status_types = ArticlePeer::getStatusTypes();
    return parent::getStatus() ? $status_types[parent::getStatus()] :  $status_types[ArticlePeer::DRAFT]; 
    //return $status_types[parent::getStatus()];
  }

  /**
   * Return the integer status value
   * 
   * @return void
   */
  public function getArticleStatus()
  {
    return parent::getStatus();
  }
  
  /**
   * Overriding the hydrate method so we don't need to set the culture before calling getters
   *
   * @param ResultSet $rs
   * @param integer $startcol
   */
  public function hydrate(ResultSet $rs, $startcol = 1)
  {
    parent::hydrate($rs, $startcol);
    $this->setCulture(sfContext::getInstance()->getUser()->getCulture());
  }
  
  /**
   * Returns the author id
   *
   * @return int
   */
  public function getUserId()
  {
  	return $this->getAuthorId();
  }
  
  
  public function getFeedPermalink()
  {
    return $this->getLink();
  }

  public function getCustomFeedTitle()
  {
    return $this->getTitle();
  }
}

sfPropelBehavior::add('Article', array('sfPropelActAsTaggableBehavior'));

