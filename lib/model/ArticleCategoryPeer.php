<?php

/**
 * Subclass for performing query and update operations on the 'article_category' table.
 *
 * 
 *
 * @package lib.model
 */ 
class ArticleCategoryPeer extends BaseArticleCategoryPeer
{
	
	/**
	 * Removes all categories in a subreaktor from the article
	 *
	 * @param Article $article
	 * @param integer $subreaktor_id
	 */
	public static function removeAllInSubreaktor($article, $subreaktor_id)
	{
		$crit = new Criteria();
		$crit->add(self::ARTICLE_ID, $article->getId());
		$crit->addjoin(self::CATEGORY_ID, CategorySubreaktorPeer::CATEGORY_ID);
		$res = self::doDelete($crit);
	}
	
	/**
	 * Get all the article objects that are in the specified category
	 *
	 * @return array of artciles
	 */
	public static function getArticlesInCategory($category, $published = true)
	{
	  $resultsArray = array();
    $c            = new Criteria();
    
    $c->add(CategoryI18nPeer::NAME, $category);
    $c->addJoin(CategoryI18nPeer::ID, self::CATEGORY_ID);
    $c->addGroupByColumn(self::ARTICLE_ID);
    
    if ($published)
    {
      $c->add(ArticlePeer::STATUS, ArticlePeer::PUBLISHED);
    }

    $c->addJoin(ArticlePeer::AUTHOR_ID, sfGuardUserPeer::ID, Criteria::LEFT_JOIN);
    $c->addJoin(self::ARTICLE_ID, ArticlePeer::ID);
    
    if (!sfContext::getInstance()->getUser()->hasCredential('viewallcontent'))
    {
      $c->add(sfGuardUserPeer::SHOW_CONTENT, true);
    }
    
    $results = self::doSelectJoinAll($c);
    
    foreach ($results as $result)
    {
      $resultsArray[$result->getId()] = $result->getArticle();
    }
    return $resultsArray;
	}
}
