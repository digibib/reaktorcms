<?php

/**
 * Subclass for performing query and update operations on the 'article_file' table.
 *
 * 
 *
 * @package lib.model
 */ 
class ArticleFilePeer extends BaseArticleFilePeer
{
  public static function getAll()
  {
    $c = new Criteria;
    return parent::doSelect($c);
  }

}
