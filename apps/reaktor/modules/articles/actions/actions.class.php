<?php

/**
 * articles actions.
 *
 * @package    reaktor
 * @subpackage articles
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 2692 2006-11-15 21:03:55Z fabien $
 */
class articlesActions extends sfActions
{
  private $hasErrors = false;
  /**
   * Executes index action
   *
   */
  public function executeIndex()
  {
    //$this->forward('default', 'module');
  }
  
  public function executeCalendar()
  {
    $this->forward404Unless($this->getRequest()->isXmlHttpRequest());
    sfLoader::loadHelpers('Partial');
    return $this->renderText(get_component('articles', 'articleCalendar', array(
                        'year'          => $this->getRequestParameter('year'),
                        'article_type'  => $this->getRequestParameter('article_type'),
                        'month'         => $this->getRequestParameter('month'),
                        'article_id'    => $this->getRequestParameter('article_id'),
                        'only'          => $this->getRequestParameter('only'),
                        'edit'          => $this->getRequestParameter('edit'),
                        'chosen_format' => $this->getRequestParameter('chosen_format'),
                        'status'        => $this->getRequestParameter('status', 'all'),
                        'live'          => $this->getRequestParameter('live'),    
                        )));
  }
  
  /**
   * List helparticles divided into format/subReaktor sections 
   */
  public function executeHelpArticlesBrowser()
  {
    $this->forward404Unless($this->getRequest()->isXmlHttpRequest());
    sfLoader::loadHelpers('Partial');
    return $this->renderText(get_component('articles', 'browseTypes', array(
      'view_article'  => $this->getRequestParameter('view_article'),
      'chosen_format' => $this->getRequestParameter('chosen_format'),
    )));
  }
  
  public function executeSetExpirationDate()
  {
  	$article = ArticlePeer::retrieveByPK($this->getRequestParameter('article_id'));
  	$this->forward404Unless($article instanceof Article);
  	$this->error = '';
  	try
  	{
	  	$v = $this->getRequestParameter('expiry_date');
	  	$article->setExpiresAt($v['year'].'-'.$v['month'].'-'.$v['day']);
	  	$article->save();
  	}
  	catch (Exception $e)
  	{
  		$this->getRequest()->setError('expiry_date', sfContext::getInstance()->getI18N()->__('Could not save this expiry date'));
  	}
  	
  	sfLoader::loadHelpers('Partial');
  	return $this->renderText(get_component('articles', 'expirationDate', array('article' => $article)));
  }
  
  public function validateEdit()
  {
    $i18n = sfContext::getInstance()->getI18N();
    $this->article_type                        = $this->getRequestParameter('article_type');
    $this->year                                = $this->getRequestParameter('year');
    $this->month                               = $this->getRequestParameter('month');
    $article_id                                = $this->getRequestParameter('article_id');
    $subreaktors                               = $this->getRequestParameter('subreaktorChecked');
    $article = null;
    $new = false;
    
    if ($this->getRequest()->getMethod() != sfRequest::POST)
    {
      return true;
    }
    
    if ($article_id)
    {
      $article = ArticlePeer::retrieveByPK($article_id);
    }
    if (!$article)
    {
      // Make sure we have an article
      $article = new Article;
      $new = true;
    }
    
    $article_types = ArticlePeer::getArticleTypes();
    if (!isset($article_types[$this->getRequestParameter('article_type', 0)]))
    {
      $this->getRequest()->setError("article_type", $i18n->__("Unknown article type"));
    }

    // Check for internationalised title
    if ($this->getRequestParameter('article_title_i18n') && $article->hasTranslatableTitle())
    {
      $titleArray = (array)$this->getRequestParameter("article_title_i18n");
      if (!isset($titleArray["no"]) || !trim($titleArray["no"]))
      {
        $this->getRequest()->setError('article_title', $i18n->__('You must enter a Bokmål title'));
      }
      else
      {
        $title = $titleArray["no"];
      }

      foreach(CataloguePeer::getCatalogues(true) as $lang => $desc)
      {
        if (empty($titleArray[$lang]))
        {
          $titleArray[$lang] = $title;
        }
      }
      $this->getRequest()->getParameterHolder()->set('article_title_i18n', $titleArray);
    }
    // Regular title
    else
    {
      if (!trim($this->getRequestParameter('article_title')))
      {
        $this->getRequest()->setError("article_title", $i18n->__('You must enter a title'));
      }
      else
      {
        $title = $this->getRequestParameter('article_title');
      }
    }


    // Check the permlink
    if (!$article->getPermalink() || $this->getRequestParameter("reset_permalink"))
    {
      $permalink = ArticlePeer::sanitizePermlink(trim($title));
      
      $crit = new Criteria();
      
      $ctn = $crit->getNewCriterion(ArticlePeer::BASE_TITLE, $title);
      $ctn2 = $crit->getNewCriterion(ArticlePeer::PERMALINK, $permalink);
      $ctn->addOr($ctn2);
      $crit->add($ctn);
      
      $crit->add(ArticlePeer::ID, $article->getId(), Criteria::NOT_EQUAL);
      $crit->addAscendingOrderByColumn(ArticlePeer::BASE_TITLE);
      
      if (ArticlePeer::doCount($crit) > 0)
      {
        $this->getRequest()->setError('article_title', $i18n->__('Please enter a unique title'));
      }
    }

    // Check the article content
    if (!($this->getRequestParameter("article_ingress") || $this->getRequestParameter("article_content")))
    {
      $this->getRequest()->setError('article_content', $i18n->__('Article should atleast have either intro or content'));
    }
    if (!$new) {
	    switch($this->getRequestParameter("article_type")) {
	    // Theme articles must expire and have a banner
	    case ArticlePeer::THEME_ARTICLE:
	      if (!$article->getExpiresAt() || !$article->getBannerFileId())
	     {
	        if (!$article->getExpiresAt())
	        {
	          $this->getRequest()->setError('expiry_date', $i18n->__('Theme articles must expire sometime'));
	        }
	        if (!$article->getBannerFileId())
	        {
	          $this->getRequest()->setError('banner_error', $i18n->__('Theme articles must have a banner'));
	        }
	      }
	      break;
	      //There must be at least one subreaktor on the article when it's published
	      case ArticlePeer::HELP_ARTICLE:
	      	
	        if(!$article->getSubreaktors())
	        {
	          $this->getRequest()->setError('subreaktors', sfContext::getInstance()->getI18N()->__('Help articles must have at least one subReaktor'));
	        }
	      break;
	    }
    }
    return !$this->getRequest()->hasErrors();
  }

  public function executeEdit()
  {
    $this->forward404Unless($this->getUser()->isAuthenticated() && $this->getUser()->hasCredential('staff'));
    $access = ArticlePeer::getArticleTypesByPermission($this->getUser());

    $this->show_subreaktor_and_categories_edit = false;
    $this->show_tags_edit                      = false;
    $this->show_attachments_edit               = false;
    $this->show_related_artworks_edit          = false;
    $this->show_related_edit                   = false;
    $this->show_banner                         = false;
    $this->show_expiry_date                    = false;
    $isSaved                                   = false;
    $this->article_type                        = $this->getRequestParameter('article_type');
    $this->year                                = $this->getRequestParameter('year');
    $this->month                               = $this->getRequestParameter('month');
    $article_id                                = $this->getRequestParameter('article_id');
    $article                                   = null;

    $this->forward404If($this->article_type && !isset($access[$this->article_type]));
    
    if ($article_id && $article = ArticlePeer::retrieveByPK($article_id))
    {
      //Edit article
      $this->show_related_edit                 = true;
      $this->show_attachments_edit             = true;
      $this->show_related_artworks_edit        = true;
      $this->show_tags_edit                    = true;
      
      $this->year  = date('Y', strtotime($article->getCreatedAt()));
      $this->month = date('n', strtotime($article->getCreatedAt()));
      $this->article_type = $article->getArticleType();
    }
    else
    {
      // New article
      $article = new Article();
    }
    
    
    if ($this->getRequest()->getMethod() == sfRequest::POST && !$this->getRequest()->hasErrors())
    {
      $article->setArticleType($this->getRequestParameter('article_type'));
      
      // Set internationalised titles if set
      if ($this->getRequestParameter('article_title_i18n') && $article->hasTranslatableTitle())
      {
        $titleArray = $this->getRequestParameter("article_title_i18n");
        $article->setI18nTitles($titleArray);
        $article->setTitle($titleArray["no"]);
      }
      else
      {
        $article->setTitle(trim($this->getRequestParameter('article_title', $article->getBaseTitle())));
        if ($article->hasTranslatableTitle())
        {
          $article->setI18nTitles(array(sfContext::getInstance()->getUser()->getCulture() => $this->getRequestParameter("article_title")));
        }
      }
      if (!$article->getPermalink() || $this->getRequestParameter("reset_permalink"))
      {
        $title = ArticlePeer::sanitizePermlink($article->getBaseTitle());
        $article->setPermalink($title);
      }
      	
      $this->month = date('n', $_SERVER['REQUEST_TIME']);
      
     
      $article->setIngress($this->getRequestParameter('article_ingress'));
      $article->setContent($this->getRequestParameter('article_content'));

      if ($article_id)
      {
        $article->setUpdatedAt($_SERVER["REQUEST_TIME"]);
        $article->setUpdatedBy($this->getUser()->getId());

        $frontpage=0;
        if((bool)$this->getRequestParameter("frontpage")) $frontpage|=ArticlePeer::REAKTOR_FRONTPAGE;
        if((bool)$this->getRequestParameter("subfrontpage")) $frontpage|=ArticlePeer::SUBREAKTOR_FRONTPAGE;

        $article->setFrontpage($frontpage);

        $article->setStatus($this->getRequestParameter("status"));
      }
      else
      {
        $article->setCreatedAt($_SERVER["REQUEST_TIME"]);
        $article->setAuthorId($this->getUser()->getId());
      }
      $this->article_type = $article->getArticleType();
      
      $article->save();
      HistoryPeer::logAction(10, $this->getUser()->getId(), $article);
      $isSaved  = true; 

      $this->redirect("@editarticle?article_id=".$article->getId());
    }
    if ($article->getId())
    {
      $this->show_related_edit                 = true;
      $this->show_attachments_edit             = true;
      $this->show_related_artworks_edit        = true;
      $this->show_tags_edit                    = true;
        
      //Provide order option for selected articles
      $this->order = ArticlePeer::ArticleCount($this->article_type)>1 &&
                     ($this->article_type == ArticlePeer::REGULAR_ARTICLE ||
                     $this->article_type == ArticlePeer::MY_PAGE_ARTICLE  ||
                     $this->article_type == ArticlePeer::FOOTER_ARTICLE   ||
                     $this->article_type == ArticlePeer::INTERNAL_ARTICLE) ? true : false;
  
      if (in_array($article->getArticleType(), array(ArticlePeer::HELP_ARTICLE, ArticlePeer::REGULAR_ARTICLE, ArticlePeer::THEME_ARTICLE)))
      {
        $this->show_subreaktor_and_categories_edit = true;
      }
      
      if ($this->getRequestParameter('article_type', $article->getArticleType()) == ArticlePeer::THEME_ARTICLE)
      {
        $this->show_expiry_date = true;
        $this->show_banner      = true;
      }
    }
      
    $this->article = $article;
  }
  
  public function executeList()
  {
    $this->article = new Article;
    $this->status = $this->getRequestParameter("status", "all");
    $this->year  = date('Y', $_SERVER["REQUEST_TIME"]);
    $this->month = date('n', $_SERVER["REQUEST_TIME"]);
    $this->article_type = $this->getRequestParameter("article_type", $this->article->getArticleType());

  }
  
  public function handleErrorEdit()
  {
    $this->getRequest()->setError("fred", "fail");
    $this->executeEdit();
    return sfView::SUCCESS;
  }

   /**
   * Display article relations component. This is needed to display error messsages. Validation doesn't
   * work with components.
   *
   * @return void
   */
  public function executeArticleRelations()
  {
    $this->article = ArticlePeer::retrieveByPK($this->getRequestParameter('id'));
  }
  
  /**
   * Handle validation errors when relating articles
   *
   * @return void
   */
  public function handleErrorRelateArticle()
  {   
    $this->getResponse()->setStatusCode(500);
    $this->forward('articles', 'articleRelations');
  }
  
  /**
   * Ajax request to add relation
   *
   * @return Rendered updated component
   */
  public function executeRelateArticle()
  {
    //Get request parameters
    $first_article  = $this->getRequestParameter('id');
    $second_article = $this->getRequestParameter('relate_article_select');   
    
    //Check credentials and paramters
    $this->forward404Unless($this->getRequest()->isXmlHttpRequest());
    $this->forward404Unless($this->getUser()->isAuthenticated()&&$this->getuser()->hasCredential('staff'));
    $this->forward404Unless($first_article&&$second_article);    
    $user           = $this->getUser()->getGuardUser()->getId();
    
    //Add relation
    ArticleArticleRelationPeer::addRelatedArticle($first_article, $second_article, $user);

    //Return updated relateArticles Component
    sfLoader::loadHelpers('Partial');    
    $article = ArticlePeer::retrieveByPK($first_article);
    
    return $this->renderText(get_component('articles', 'articleRelations', array('article'=> $article)));
  }
  
  /**
   * Ajax request to delete relation
   *
   * @return Rendedered updated component
   */
  public function executeUnrelateArticle()
  {
    //Get request parameters
    $first_article  = $this->getRequestParameter('article1');
    $second_article = $this->getRequestParameter('article2');
    
    //Check credentials and parameters
    $this->forward404Unless($this->getRequest()->isXmlHttpRequest());
    $this->forward404Unless($this->getUser()->isAuthenticated()&&$this->getuser()->hasCredential('staff'));
    $this->forward404Unless($first_article&&$second_article);
    
    //Delete relation
    ArticleArticleRelationPeer::deleteRelation($first_article,$second_article);
    
    //Return updated relateArticles Component
    sfLoader::loadHelpers('Partial');   
    $article = ArticlePeer::retrieveByPK($first_article);
    
    return $this->renderText(get_component('articles', 'articleRelations', array('article'=> $article)));
  }

  public function executeRelateToArtwork()
  {
    $this->forward404Unless($this->getRequest()->isXmlHttpRequest());
    $this->forward404Unless($this->getUser()->isAuthenticated()&&$this->getuser()->hasCredential('staff'));

    $id = $this->getRequestParameter("article_id");
    $artwork  = $this->getRequestParameter("artwork_id");

    $this->forward404Unless(is_numeric($id) && is_numeric($artwork));

    $article = ArticlePeer::retrieveByPK($id);
    $article->relateToArtwork((int)$artwork);
    return $this->renderText("OK");
  }

  /**
   * Execute the article view template
   *
   * @return null
   */
  public function executeView()
  {
    $staff = $this->getUser()->isAuthenticated() && $this->getuser()->hasCredential('staff');
    $permalink = $this->getRequestParameter('permalink');

    if ($type = $this->getRequestParameter("latest"))
    {
      $this->article = $article = ArticlePeer::retrieveLatestByType($this->getRequestParameter("type"));
    }
    else
    {
      $this->article = $article = ArticlePeer::retrieveByPermalink($permalink, $staff);
    }
    
    $this->forward404Unless($article);

    if ($this->article->getArticleType() == ArticlePeer::INTERNAL_ARTICLE)
    {
      $this->forward404Unless($staff);
    }
  }

  public function executeShowArticleAttachments()
  {
    $id = $this->getRequestParameter("article_id");
    $this->article = ArticlePeer::retrieveByPK($id);
    $this->forward404Unless($this->article);
    sfLoader::loadHelpers(array('Partial'));
    return $this->renderText(get_component('articles', 'articleAttachments', array("article" => $this->article)));
  }

  public function executeAttachToArticle()
  {
    $user = $this->getUser();
    $this->forward404Unless($this->getRequest()->isXmlHttpRequest());
    $this->forward404Unless($user->isAuthenticated());

    $access = ArticlePeer::getArticleTypesByPermission($user);
    $article_id = $this->getRequestParameter("article_id");
    $file_id    = $this->getRequestParameter("file_id");

    $this->forward404Unless($article_id && $file_id);

    $article = ArticlePeer::retrieveByPK($article_id);
    $this->forward404Unless(isset($access[$article->getArticleType()]));


    $file    = ArticleFilePeer::retrieveByPK($file_id);

    $this->forward404Unless($article && $file);

    $attachment = new ArticleAttachment;
    $attachment->setArticleFile($file);
    $article->addArticleAttachment($attachment);
    $article->setBannerFileId($file->getId());
    $attachment->save();
    $article->save();

    return $this->renderText("");
  }

  public function executeAttachBannerToArticle()
  {
    $this->forward404Unless($this->getRequest()->isXmlHttpRequest());
    $this->forward404Unless($this->getUser()->isAuthenticated());

    $access = ArticlePeer::getArticleTypesByPermission($this->getUser());
    $article_id = $this->getRequestParameter("article_id");
    $file_id    = $this->getRequestParameter("banner");

    $this->forward404Unless($article_id && $file_id);

    $access = ArticlePeer::getArticleTypesByPermission($this->getUser());
    $article = ArticlePeer::retrieveByPK($article_id);
    $attachment = ArticleAttachmentPeer::retrieveByPK($file_id);
    $file    = $attachment->getArticleFile();

    $this->forward404Unless($article && $file);
    $this->forward404Unless(isset($access[$article->getArticleType()]));

    $article->setBannerFileId($file->getId());
    $article->save();

    $this->forward("articles", "showArticleAttachments");
  }

  public function executeNukeAttachment()
  {
    $article_id    = $this->getRequestParameter("article_id");
    $attachment_id = $this->getRequestParameter("attachment_id");

    $this->forward404Unless($article_id && $attachment_id);
    $this->forward404Unless($this->getUser()->isAuthenticated());

    $access = ArticlePeer::getArticleTypesByPermission($this->getUser());
    $article = ArticlePeer::retrieveByPK($article_id);
    $this->forward404Unless(isset($access[$article->getArticleType()]));

    $attachment = ArticleAttachmentPeer::retrieveByPK($attachment_id);
    if ($attachment->getArticleId() != $article_id)
    {
      // H4x0R alert, just ignore him
      return;
    }
    $attachment->delete();

    $this->forward("articles", "showArticleAttachments");
  }

  public function executeNukeArtworkRelation()
  {
    $article_id    = $this->getRequestParameter("article_id");
    $artwork_id = $this->getRequestParameter("artwork_id");

    $this->forward404Unless($article_id && $artwork_id);
    $this->forward404Unless($this->getUser()->isAuthenticated());

    $access = ArticlePeer::getArticleTypesByPermission($this->getUser());
    $article = ArticlePeer::retrieveByPK($article_id);
    $this->forward404Unless(isset($access[$article->getArticleType()]));

    $artwork = ArticleArtworkRelationPeer::retrieveByPK($artwork_id);
    if ($artwork->getArticleId() != $article_id)
    {
      // H4x0R alert, just ignore him
      return;
    }
    $artwork->delete();

    $this->forward("articles", "showArticleArtworkRelations");
  }

  public function executeShowArticleArtworkRelations()
  {
    $id = $this->getRequestParameter("article_id");
    $this->article = ArticlePeer::retrieveByPK($id);
    $this->forward404Unless($this->article);
    sfLoader::loadHelpers(array('Partial'));
    return $this->renderText(get_component('articles', 'articleRelatedArtworks', array("article" => $this->article)));
  }
  
  /**
   * Drag-and-drop list to order articles. 
   *
   */
  public function executeOrderArticles()
  {
    $this->forward404Unless($this->getUser()->isAuthenticated() && 
                            $this->getUser()->hasCredential('staff'));
    //If article type isn't set, choose regular
    $this->article_type   = $this->getRequestParameter('status') ? 
                            $this->getRequestParameter('status') : 
                            ArticlePeer::REGULAR_ARTICLE;
                            
    //If article id is given, this article should have a different background in the list     
    $this->article_id     = $this->getRequestParameter('article') ? 
                            $this->getRequestParameter('article') :
                            null;
                            
    //Return an array of matching articles
    $this->articles = ArticlePeer::getAllByOrder($this->article_type);

  }
  
  public function executeOrderArticlesUpdate()
  {
    $this->forward404Unless($this->getUser()->isAuthenticated() && 
                            $this->getUser()->hasCredential('staff'));
  
    $theorder    = 1;

    //Add order to articles as array is traversed
    try
    {
      foreach ($this->getRequestParameter('article_ordered_list', array()) as $article)
      {
        ArticlePeer::setArticleOrder($theorder, $article);
        $theorder++;
      }
    }
    catch(Exception $e){
       return $this->renderText("Rekkefølgen er ikke lagret [Error].");      
    }       
    return $this->renderText('Ny rekkefølge på artikler er lagret.');
  }
}

