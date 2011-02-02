<?php

/**
 * Subclass for performing query and update operations on the 'article_article_relation' table.
 *
 * 
 *
 * @package lib.model
 */ 
class ArticleArticleRelationPeer extends BaseArticleArticleRelationPeer
{
  /**
   * Get all related articles to an article 
   *
   * @param int|Article $article
   * @param bool        $only_published
   * 
   * @return array $related_articles Array of Article object 
   */
  public static function getRelatedArticles($article, $published = false)
  {    
    $article_id = $article instanceof Article ? $article->getId() : $article; 
    $article    = $article instanceof Article ? $article : ArticlePeer::retrieveByPK($article_id);  
    $c          = new Criteria();   
    // Bug #611, 603, 434 Customer doesn't want this, they want one way only 
    /*
    // First lets get the IDs of the related objects - we can't do a mega join here with Propel because of
    // The double foreign key (Propel does not support table aliases yet)
     
    $critA = $c->getNewCriterion(parent::FIRST_ARTICLE, $article);
    $critB = $c->getNewCriterion(parent::SECOND_ARTICLE, $article);
    $critA->addOr($critB);
    
    $c->add($critA);
    */
    $c->add(parent::FIRST_ARTICLE, $article_id, Criteria::EQUAL);
    
    $relatedRows = parent::doSelect($c);
    
    if (!$relatedRows)
    {
      return array();
    }    
    foreach($relatedRows as $relatedRow)
    {      
      $relatedIds[] = $relatedRow->getSecondarticle(); 
      // ($relatedRow->getFirstArticle() != $article) ? $relatedRow->getFirstArticle() : $relatedRow->getSecondarticle(); 
    }
   
    // Now we have all the article IDs, we just need to retreive them
    $c = new Criteria();
    $c->setDistinct();
    $c->add(ArticlePeer::ID, $relatedIds, Criteria::IN);
    $c->addJoin(ArticlePeer::ID, parent::FIRST_ARTICLE, Criteria::LEFT_JOIN);
    
    if ($published)
    {
      $c->add(ArticlePeer::STATUS, ArticlePeer::PUBLISHED);
    }
    
    //In case some articles have changed article_type make sure no relations that aren't allowed are shown    
    switch($article->getArticleType())
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
    return ArticlePeer::doSelect($c);
  }

  /**
   * Get the relation given two articles
   *
   * @param unknown_type $first_article
   * @param unknown_type $second_article
   * @return unknown
   */
  public static function getRelation($first_article, $second_article)
  {
    $first_article  = $first_article instanceof Article ? $first_article->getId() : $first_article;
    $second_article = $second_article instanceof Article ? $second_article->getId() : $second_article;
    
    $c = new Criteria();
    
    // Bug #611, 603, 434 Customer doesn't want this, they want one way only
    /*$critA = $c->getNewCriterion(parent::FIRST_ARTICLE, $first_article);
    $critB = $c->getNewCriterion(parent::SECOND_ARTICLE, $second_article);
    $critA->addAnd($critB);
    
    $critC = $c->getNewCriterion(parent::FIRST_ARTICLE, $second_article);
    $critD = $c->getNewCriterion(parent::SECOND_ARTICLE, $first_article);
    $critC->addAnd($critD);
        
    $critA->addOr($critC);
    $c->add($critA);*/
    $c->add(parent::FIRST_ARTICLE, $first_article);
    $c->add(parent::SECOND_ARTICLE, $second_article);
    
    $c->addDescendingOrderByColumn(parent::CREATED_AT);

    return parent::doSelectOne($c);
  }
    
  /**
   * Delete a relation given two articles
   *
   * @param unknown_type $first_article
   * @param unknown_type $second_article
   */
  public static function deleteRelation($first_article, $second_article)
  {
    $relation = ArticleArticleRelationPeer::getRelation($first_article, $second_article);
    if ($relation)
    {
      //delete relation
      //$c = new Criteria();
      //$c->add(parent::ID, $relation->getId());
      //parent::doDelete($c); 
      parent::doDelete($relation->getId());
    }    
    
  }
  
  /**
   * Add a relation between to articles, where relations work both ways (i.e there is no hierarchical structure)
   *
   * @param int $first_article Article to relate to
   * @param int $second_article Article to relate to
   * @param int $user sfGuardUser User creating the relation
   */
  public static function addRelatedArticle($first_article, $second_article, $user)
  {
    //Get id's if necessary
    $first_article  = $first_article instanceof Article ? $first_article->getId() : $first_article;
    $second_article = $second_article instanceof Article ? $second_article->getId() : $second_article;
    $user           = $user instanceof sfGuardUser ? $user->getId() : $user ;
    
    //We don't want more than one relation between two given articles, so we delete in case it already exist
    //even though this should never happen 
    ArticleArticleRelationPeer::deleteRelation($first_article, $second_article);
    
    //Create and save a new relation between articles
    $relatedarticle = new ArticleArticleRelation();    
    $relatedarticle->setFirstarticle($first_article);
    $relatedarticle->setSecondarticle($second_article);
    $relatedarticle->setCreatedBy($user);
    $relatedarticle->save();
    
  }
}

