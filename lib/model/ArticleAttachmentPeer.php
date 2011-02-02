<?php

/**
 * Subclass for performing query and update operations on the 'article_attachment' table.
 *
 * 
 *
 * @package lib.model
 */ 
class ArticleAttachmentPeer extends BaseArticleAttachmentPeer
{
  public static function getAll()
  {
    $c = new Criteria;
    return parent::doSelect($c);
  }

  public static function retrieveById($id)
  {
    $c = new Criteria;
    $c->add(ArticleAttachmentPeer::ID, $id);
    return parent::doSelectOne($c);
  }
}
