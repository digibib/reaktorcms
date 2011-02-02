<?php
/**
 * Article components
 *  
 * PHP version 5
 * 
 * @author    Daniel Andre Eikeland <dae@linpro.no>
 * @author    June Henriksen  <juneih@linpro.no>
 * @copyright 2008 Linpro AS
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 */

class articlesComponents extends sfComponents 
{
  /**
   * Show article relations
   *
   */
  function executeArticleRelations()
  {
    $this->related_articles = ArticleArticleRelationPeer::getRelatedArticles($this->article);
    $this->unrelatedArticles = $this->article->getUnrelatedArticles();
  }
  
  /**
   * Show (and edit) article expiration date
   *
   */
  function executeExpirationDate()
  {
  	$this->date = '';
  	if ($this->article->getExpiresAt())
  	{
  	  $this->date = $this->article->getExpiresAt();
  	}
  }
  
  /**
   * Shows the article calendar in the sidebar 
   *
   */
  function executeArticleCalendar()
  {
  	$this->only          = (isset($this->only)) ? $this->only : 0;
  	$this->edit          = (isset($this->edit)) ? $this->edit : 0;
    $this->article_id    = (isset($this->article_id)) ? $this->article_id : 0;
    $this->status        = (isset($this->status)) ? $this->status : "all";
    $this->live          = (isset($this->live) ? $this->live : 1);
    $this->chosen_format = (isset($this->chosen_format)) ? $this->chosen_format : 0;  
    $this->article       = ($this->article_id) ? ArticlePeer::retrieveByPK($this->article_id) : new Article();
    
    if ($this->article_type == ArticlePeer::HELP_ARTICLE)
    {
      $this->formats = array();
      if (!$this->chosen_format && $this->article_id)
      {
      	$formats             = $this->article->getSubreaktors(true);
      	$this->chosen_format = array_shift($formats);
      }
      $subreaktors = $this->live ? SubreaktorPeer::getLiveReaktors('subReaktor') : SubreaktorPeer::getSubReaktors();
    	foreach ($subreaktors as $areaktor)
      {
	      if ($this->chosen_format && $this->chosen_format == $areaktor->getReference())
	      {
	        $format = array('name' => $areaktor->getName(), 'articles' => ArticleSubreaktorPeer::getHelpArticleArchive($this->chosen_format, $this->status));
	      }
	      else
	      {
	      	$format = array('name' => $areaktor->getName(), 'articles' => array());
	      }
      	$this->formats[] = array($areaktor->getReference() => $format);
      }
        
    }
    elseif (in_array($this->article_type, array(ArticlePeer::INTERNAL_ARTICLE, ArticlePeer::FOOTER_ARTICLE, ArticlePeer::SPECIAL_ARTICLE)))
    {
    	$this->articles = array((int) $this->article_type => ArticlePeer::getByFieldAndOrType($this->article_type, 'title', null, null, $this->status));
      uasort($this->articles[$this->article_type], array($this, 'sortArticleByTitle'));
    }
    else
    {
      $this->articles = ArticlePeer::retrieveAllSortedByTypeYearAndMonth($this->only, $this->status);
    }
  }
  
  /**
   * shows a list of articles for a given month
   *
   */
  function executeMonthlist()
  {
    $this->articles = ArticlePeer::getByFieldAndOrType($this->article_type, 'date', $this->year, $this->month, !$this->edit ? ArticlePeer::PUBLISHED : 0);
  }

  /**
   * Shows created&updated by and dates
   * 
   */
  function executeListCreators()
  {
    $created_by = null;
    $created_at = null;
    $updated_by = null;
    $updated_at = null;

    if (isset($this->article) && $this->article instanceof Article)
    {
      $article    = $this->article;
      $created_by = sfGuardUserPeer::retrieveByPK($article->getAuthorId());
      $created_at = $article->getCreatedAt();
      if ($updated_at = $article->getUpdatedAt())
      {
        $updated_by = sfGuardUserPeer::retrieveByPK($article->getUpdatedBy());
      }
    }

    $this->created_by = $created_by;
    $this->created_at = $created_at;
    $this->updated_by = $updated_by;
    $this->updated_at = $updated_at;

  }
  
  /**
   * Display my page articles (slot)
   *
   */
  function executeMyPageArticles()
  {
  	$this->articles = ArticlePeer::getByFieldAndOrType(ArticlePeer::MY_PAGE_ARTICLE, 'date', null, null, ArticlePeer::PUBLISHED, 3);
  	
  }

  public function executeArticleAttachments()
  {
    $tfiles = $this->article->getArticleAttachments();
    $files = array();
    foreach($tfiles as $file)    {   
      $files[$file->getId()] = $file->getArticleFile();
    }   
    $this->files = $files;
    $this->banner = $this->article->getArticleType() == ArticlePeer::THEME_ARTICLE || $this->getRequestParameter("article_type") == ArticlePeer::THEME_ARTICLE;
    $this->bannerid = $this->article->getBannerFileId();
  }

  public function executeArticleRelatedArtworks()
  {
    $tfiles = $this->article->getArticleArtworkRelations();
    $files = array();
    foreach($tfiles as $artwork)
    {
      $files[$artwork->getId()] = $artwork->getReaktorArtwork();
    }
    $this->files = $files;
  }
  
  public function executeFrontPageArticles()
  {
  	$this->theme_article = ArticlePeer::getThemeArticle('frontpage');
  	if (!$this->theme_article instanceof Article)
  	{
  		$this->articles = ArticlePeer::getByFieldAndOrType(ArticlePeer::REGULAR_ARTICLE, 'date', null, null, ArticlePeer::PUBLISHED, 2, 'frontpage');
  	}
  }

  public function executeArticleBanner()
  {
    $this->banner = null;
    $banner_id = $this->article->getBannerFileId();
    if ($banner_id) {
      $this->banner = ArticleFilePeer::retrieveByPK($banner_id);
    }
  }

  /**
   * Sorts articles by translated title if exists
   *
   * @param Article $article_a
   * @param Article $article_b
   * 
   * @returns array
   */
  public function sortArticleByTitle($article_a, $article_b)
  {
    return (strcmp ($article_a->getTitle(),$article_b->getTitle()));  	
  }
  
}

