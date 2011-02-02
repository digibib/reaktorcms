<?php

/**
 * Subclass for performing query and update operations on the 'article_subreaktor' table.
 *
 * 
 *
 * @package lib.model
 */ 
class ArticleSubreaktorPeer extends BaseArticleSubreaktorPeer
{
  /**
   * Get all articles to be displayed in help article archive.
   * 
   * Divide articles by subreaktors, in a two dimensional array. 
   *
   */
  public static function getHelpArticleArchive($subreaktor, $status = 0)
  {
    $c = new Criteria();
    
    $c->add(ArticlePeer::ARTICLE_TYPE, ArticlePeer::HELP_ARTICLE, Criteria::EQUAL);
    $c->add(ArticleSubreaktorPeer::SUBREAKTOR_ID, Subreaktor::getByReference($subreaktor)->getId());
    ArticlePeer::resolveAndAddStatus($status, $c);
    $c->addDescendingOrderByColumn(ArticlePeer::BASE_TITLE);
    $c->setDistinct();
    
    $article_subreaktors = ArticleSubreaktorPeer::doSelectJoinAll($c);
    
    $result = array();
    foreach ($article_subreaktors as $article_subreaktor)
    {
      $result[] = $article_subreaktor->getArticle(); 
    }
    return $result;
  }
}
