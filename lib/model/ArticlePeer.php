<?php

/**
 * Subclass for performing query and update operations on the 'article' table.
 *
 * 
 *
 * @package lib.model
 */ 
class ArticlePeer extends BaseArticlePeer
{
	
  const HELP_ARTICLE     = 1;
  const THEME_ARTICLE    = 2;
  const INTERNAL_ARTICLE = 3;
  const FOOTER_ARTICLE   = 4;
  const MY_PAGE_ARTICLE  = 5;
  const REGULAR_ARTICLE  = 6;
  const SPECIAL_ARTICLE  = 7;


  const DRAFT            = 1;
  const PUBLISHED        = 2;
  const ARCHIVED         = 3;
  const DELETED          = 4;

  const REAKTOR_FRONTPAGE         = 0x00FF;
  const SUBREAKTOR_FRONTPAGE      = 0xFF00;

	
  /**
   * All the article types that are translatable (just titles at present)
   *
   * @var array of type IDs
   */
  protected static $_translatableTypes = array(ArticlePeer::FOOTER_ARTICLE);


  /**
   *  Returns an array of ArticlePeer::*_ARTICLE
   *
   *  @return array
   */
  public static function getTranslatableTypes()
  {
    return self::$_translatableTypes;
  }

  /**
   * Returns an array of article types
   *
   * @return array
   */
  public static function getArticleTypes()
  {
    $i18n = sfContext::getInstance()->getI18N();
    $article_types = array(
      self::HELP_ARTICLE     => $i18n->__('Help articles'),
      self::THEME_ARTICLE    => $i18n->__('Theme articles'),
      self::INTERNAL_ARTICLE => $i18n->__('Internal articles'),
      self::FOOTER_ARTICLE   => $i18n->__('Footer articles'),
      self::MY_PAGE_ARTICLE  => $i18n->__('My page articles'),
      self::REGULAR_ARTICLE  => $i18n->__('Regular articles'),
      self::SPECIAL_ARTICLE  => $i18n->__('Special articles'),
    );
    
    return $article_types;
  }
  
  public static function getStatusTypes()
  {
    $i18n = sfContext::getInstance()->getI18N();
    $status_types = array(
      self::DRAFT     => $i18n->__('Kladd'),
      self::PUBLISHED => $i18n->__('Publisert'),
      self::ARCHIVED  => $i18n->__('Arkivert'),
      self::DELETED   => $i18n->__('Slettet'),      
    );
    
    return $status_types;
  }
  
  /**
   * Returns the article type name of an article type, translated
   *
   * @param integer $article_type
   * 
   * @return string
   */
  public static function getArticleTypeName($article_type)
  {
  	$article_types = self::getArticleTypes();
  	return $article_types[$article_type];
  }

  public static function getArticleTypesByPermission($user)
  {
    $permission_map = array(
      self::HELP_ARTICLE     => "createhelparticle",
      self::THEME_ARTICLE    => "createthemearticle",
      self::INTERNAL_ARTICLE => "createinternalarticle",
      self::FOOTER_ARTICLE   => "createfooterarticle",
      self::MY_PAGE_ARTICLE  => "createmypagearticle",
      self::REGULAR_ARTICLE  => "createregulararticle",
      self::SPECIAL_ARTICLE  => "createspecialarticle",
    );
	
    $types = self::getArticleTypes();
    foreach($types as $type => $text)
    {
      if (!$user->hasCredential($permission_map[$type]))
      {
        unset($types[$type]);
      }
    }
    return $types;
  }
  
  /**
   * Retrieves all articles of a given type (see constants in ArticlePeer for list of types)
   * and date
   * 
   * @param integer $article_type
   * @param integer $year
   * @param integer $month
   * @param boolean $published
   * @param integer $num
   * @param string $page If set, then then this list if for the frontpage
   * @return object theme article
   */
  public static function getByFieldAndOrType($article_type, $field, $year = null, $month = null, $status = false, $num = null, $page = null)
  { 
    $crit = new Criteria();
    $crit->setDistinct();
    if ($article_type != self::FOOTER_ARTICLE)
    {
	    if (Subreaktor::getProvidedSubreaktor() instanceof Subreaktor || 
	        Subreaktor::getProvidedLokalreaktor() instanceof Subreaktor)
	        

	    {

	            if($page == 'frontpage')
		    { 
		      $crit->add(self::FRONTPAGE, array(self::REAKTOR_FRONTPAGE,0), Criteria::NOT_IN);
		    }

	      if ($article_type != ArticlePeer::INTERNAL_ARTICLE)
	      {
	    	  $crit->addJoin(self::ID, ArticleSubreaktorPeer::ARTICLE_ID);
	      }
	      if (Subreaktor::getProvidedSubreaktor() instanceof Subreaktor)
	      {
	        if (Subreaktor::getProvidedLokalreaktor() instanceof Subreaktor)
	        {
	          $crit->add(ArticleSubreaktorPeer::SUBREAKTOR_ID, array(Subreaktor::getProvidedSubreaktor()->getId(), Subreaktor::getProvidedSubreaktor()->getId()), Criteria::IN);
	        }
	        else
	        {
	          $crit->add(ArticleSubreaktorPeer::SUBREAKTOR_ID, Subreaktor::getProvidedSubreaktor()->getId());
	        }
	      }
	      if (Subreaktor::getProvidedLokalreaktor() instanceof Subreaktor)
	      {
	        $crit->add(ArticleSubreaktorPeer::SUBREAKTOR_ID, Subreaktor::getProvidedLokalreaktor()->getId());
	      }
	    }
	    
	      else {
	            if($page == 'frontpage')
		    { 
		      $crit->add(self::FRONTPAGE, array(self::SUBREAKTOR_FRONTPAGE,0), Criteria::NOT_IN);
		    }


	    
	    }

	    
	    
    }



    
    
    if ($field == 'date')
    {
	    if ($year !== null && $month !== null)
	    {
		    $startdate = mktime(null, null, null, $month, 1, $year);
		    $enddate = mktime(null, null, null, $month, date('t', mktime(null, null, null, $month, 1, $year)), $year);
		    
		    $ctn = $crit->getNewCriterion(self::CREATED_AT, $startdate, Criteria::GREATER_EQUAL);
		    $ctn2 = $crit->getNewCriterion(self::CREATED_AT, $enddate, Criteria::LESS_EQUAL);
		    
		    $ctn->addAnd($ctn2);
		    $crit->add($ctn);
	    }
    }

    $crit->add(self::ARTICLE_TYPE, $article_type, Criteria::IN);
    self::resolveAndAddStatus($status, $crit);
    
    if ($num)
    {
    	$crit->setLimit($num);
    }
    
    //Order by article_order then date 
    if ( $article_type == self::FOOTER_ARTICLE   ||
         $article_type == self::INTERNAL_ARTICLE || 
         $article_type == self::REGULAR_ARTICLE  ||
         $article_type == self::MY_PAGE_ARTICLE  ||
         $article_type == self::SPECIAL_ARTICLE)
    {      
      $crit->addAscendingOrderByColumn( self::ARTICLE_ORDER);
      $crit->addDescendingOrderByColumn(self::CREATED_AT); //If no order, use creation date
      if (in_array($article_type, self::getTranslatableTypes()))
      {
        $res = self::doSelectWithI18n($crit);
      }
      else
      {
        $res = self::doSelect($crit);
      }
    }
    else if ( $field == 'date' ) //only order by date
    {
      $crit->addDescendingOrderByColumn(self::CREATED_AT);
      $res = self::doSelectWithI18n($crit);
    }
    else //order by title
    {
      $crit->addAscendingOrderByColumn(ArticleI18nPeer::TITLE);
      $res = self::doSelectWithI18n($crit);
    }
    return $res;
  }
  
  /**
   * Return a ordered list of all articles within an article type. Useful for 
   * sorting lists.
   *
   * @param integer $article_type
   * @return array Article objects
   */
  public static function getAllByOrder($article_type = ArticlePeer::REGULAR_ARTICLE)
  {
    $c = new Criteria();
    
    $c->add(self::ARTICLE_TYPE, $article_type, Criteria::EQUAL);
    $c->add(self::STATUS, ArticlePeer::DELETED, Criteria::NOT_EQUAL);
    
    $c->addAscendingOrderByColumn(self::ARTICLE_ORDER);
    $c->addDescendingOrderByColumn(self::CREATED_AT);
    
    return self::doSelect($c);
      
  }

  public static function resolveAndAddStatus($status, Criteria $crit)
  {
    if ($status)
    {
      if (!is_numeric($status))
      {
        switch(strtolower($status))
        {
          case "draft":
            $status = ArticlePeer::DRAFT;
          break;
          case "published":
            $status = ArticlePeer::PUBLISHED;
          break;
          case "archived":
            $status = ArticlePeer::ARCHIVED;
          break;
          case "all":
          // All
          default:
            $status = 0;
        }
      }
    }
    if ($status)
    {
      $crit->add(self::STATUS, sfContext::getInstance()->getUser()->hasCredential('staff') ? $status : ArticlePeer::PUBLISHED);
    }
    elseif(!sfContext::getInstance()->getUser()->hasCredential('staff'))
    {
      $crit->add(self::STATUS, ArticlePeer::PUBLISHED);
    }

  }
    

  /**
   * Retrieves an article by its permalink
   *
   * @param string $permalink
   * 
   * @return Article
   */
  public static function retrieveByPermalink($permalink, $draft = false)
  {
    $c = new Criteria();
    $c->add(self::PERMALINK, $permalink);
    if (!$draft)
    {
      $c->add(self::STATUS, ArticlePeer::PUBLISHED);
    }
    return self::doSelectOne($c);
  }
  
  /**
   * Retrieve the latest article of a particular type
   *
   * @param $type      The type ID or string 
   * @param $published Only return published articles
   * 
   * @return article An article object
   */
  public static function retrieveLatestByType($type, $published = true)
  {
    if (is_integer($type))
    {
      $typeId = $type;
    }
    else
    {
      $type = strtoupper($type);
      if (defined("ArticlePeer::{$type}_ARTICLE"))
      {
        $typeId = constant("ArticlePeer::{$type}_ARTICLE");
      }
      else
      {
        throw new Exception("Article type does not exist");
      }
    }
    
    $c = new Criteria();
    $c->add(self::ARTICLE_TYPE, $typeId);

    if ($published)
    {
      $c->add(self::STATUS, self::PUBLISHED);
    }
           
    $c->addDescendingOrderByColumn(self::PUBLISHED_AT);
    
    return self::doSelectOne($c);
  }
  
  public static function getThemeArticle($page)
  {
  	$crit = new Criteria();
  	$crit->add(self::ARTICLE_TYPE, self::THEME_ARTICLE);
  	$crit->add(self::EXPIRES_AT, time(), Criteria::GREATER_EQUAL);
  	$crit->add(self::STATUS, ArticlePeer::PUBLISHED);
  	
  	
  	if (Subreaktor::getProvidedSubreaktor() instanceof Subreaktor || 
  	    Subreaktor::getProvidedLokalreaktor() instanceof Subreaktor)
    {

  	if($page == 'frontpage')
  	{ 
          $crit->add(self::FRONTPAGE, array(self::REAKTOR_FRONTPAGE,0), Criteria::NOT_IN);
  	}

  	  $crit->addJoin(self::ID, ArticleSubreaktorPeer::ARTICLE_ID);
  	  if (Subreaktor::getProvidedSubreaktor() instanceof Subreaktor)
  	  {
  	  	if (Subreaktor::getProvidedLokalreaktor() instanceof Subreaktor)
  	  	{
  	  		$crit->add(ArticleSubreaktorPeer::SUBREAKTOR_ID, array(Subreaktor::getProvidedSubreaktor()->getId(), Subreaktor::getProvidedSubreaktor()->getId()), Criteria::IN);
  	  	}
  	  	else
  	  	{
  	  		$crit->add(ArticleSubreaktorPeer::SUBREAKTOR_ID, Subreaktor::getProvidedSubreaktor()->getId());
  	  	}
  	  }
  	  if (Subreaktor::getProvidedLokalreaktor() instanceof Subreaktor)
  	  {
  	  	$crit->add(ArticleSubreaktorPeer::SUBREAKTOR_ID, Subreaktor::getProvidedLokalreaktor()->getId());
  	  }
  	} else {
  	if($page == 'frontpage')
  	{ 
          $crit->add(self::FRONTPAGE, array(self::SUBREAKTOR_FRONTPAGE,0), Criteria::NOT_IN);
  	}
  	
  	}
  	$crit->addDescendingOrderByColumn(self::PUBLISHED_AT);
  	$crit->setLimit(5);
  	return self::doSelectJoinAll($crit);
  }
	
  /**
   * Enter description here...
   *
   * @param unknown_type $type
   * @return unknown
   */
  public static function retrieveAllSortedByTypeYearAndMonth($type = null, $status = 0)
  {
    /*SELECT YEAR(`created_at`) AS year, MONTH(`created_at`) AS month, `article_type`, `permalink` FROM `article` ORDER BY article_type, year, month */
    $c = new Criteria;
    $c->clearSelectColumns();
    $c->addSelectColumn('YEAR(' .self::CREATED_AT. ') AS year');    # 0
    $c->addSelectColumn('MONTH(' .self::CREATED_AT. ') AS month');  # 1

    $c->addSelectColumn(self::ARTICLE_TYPE);                        # 2
    $c->addSelectColumn(self::ID);                                  # 3
    $c->addSelectColumn(ArticlePeer::BASE_TITLE);                   # 4
    $c->addSelectColumn(self::PERMALINK);                           # 5
    $c->addSelectColumn(ArticleI18nPeer::TITLE);                    # 6
   
    $c->addJoin(self::ID, ArticleI18nPeer::ID.' AND '.ArticleI18nPeer::CULTURE." = '".sfContext::getInstance()->getUser()->getCulture()."'", Criteria::LEFT_JOIN);
    
    if ($type)
    {
      $c->add(self::ARTICLE_TYPE, $type, Criteria::IN);
    }
    self::resolveAndAddStatus($status, $c);

    $c->addDescendingOrderByColumn(self::ARTICLE_TYPE);
    $c->addDescendingOrderByColumn('year');
    $c->addDescendingOrderByColumn('month');

    $retval = array_fill(0, 10, array());
    foreach(parent::doSelectRs($c) as $row)
    {
      $a = new Article();
      $a->setCustom($row);
      $retval[$row[2]][$row[0]][$row[1]][] = $a;
    }
    return $retval;
  }

  /**
   * Returns the YML settings for how many articles should be shown in the list 
   * of articles for that specific type
   * 
   * @param  int $type   Article type
   * @return int          Max char count
   */
  public static function getShowCountFor($type)
  {
    $fallback_count = 5;
    switch($type) {
      case self::HELP_ARTICLE:
        return sfConfig::get('app_articles_help_max_count', $fallback_count);

      case self::INTERNAL_ARTICLE:
        return sfConfig::get('app_articles_internal_max_count', $fallback_count);

      case self::FOOTER_ARTICLE:
        return sfConfig::get('app_articles_footer_max_count', $fallback_count);

      case self::MY_PAGE_ARTICLE:
        return sfConfig::get('app_articles_my_page_max_count', $fallback_count);

      case self::REGULAR_ARTICLE:
        return sfConfig::get('app_articles_regular_max_count', $fallback_count);
    }
    return $fallback_count;
  }

  /**
   * Retrieves help articles in the same category as $artwork_id
   * 
   * @param int $artwork_id     The artwork ID
   * @return array   Articles
   */
  public static function getByCategoryFromArtworkID($artwork_id)
  {
    $c = new Criteria;
    $c->setDistinct();
    $c->addJoin(ArticleCategoryPeer::ARTICLE_ID, ArticlePeer::ID);
    $c->addJoin(CategoryArtworkPeer::CATEGORY_ID, ArticleCategoryPeer::CATEGORY_ID);
    $c->add(CategoryArtworkPeer::ARTWORK_ID, $artwork_id);
    $c->add(ArticlePeer::ARTICLE_TYPE, ArticlePeer::HELP_ARTICLE);
    return parent::doSelect($c);
  }

  /**
   * Sanitizes the permanent link
   * 
   * @param string $title 
   * @return string
   */
  public static function sanitizePermlink($title)
  {
    $permalink = strtr($title, array("ø" => "oe", "å" => "aa", "æ" => "ae", "Ø" => "OE", "Å" => "AA", "Æ" => "AE"));
    $permalink = preg_replace('/[^a-zA-Z0-9\-]/i', '_' , $permalink);
    return $permalink;
  }

  public static function setArticleOrder($order, $article)
  {
    if ($article instanceof Article)
    {
      $article = $article->getId();
    }
    
    $c = new Criteria();
    $c->add(self::ID, $article);
    $res = self::doSelectOne($c);
    
    if ($res)
    {
      $res->setArticleOrder($order);
      $res->save();
    }
  }

  /**
   * Count articles of the same type.
   *
   * @param integer $article_type
   * @return integer The number of article of type $article_type
   */
  public static function articleCount($article_type)
  {
    $c = new Criteria();
    $c->add(parent::ARTICLE_TYPE, $article_type, Criteria::EQUAL);
    return parent::doCount($c);
  }
  
}

