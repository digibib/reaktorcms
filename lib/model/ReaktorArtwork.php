<?php

/**
 * Subclass for representing a row from the 'reaktor_artwork' table.
 *
 * 
 *
 * @package lib.model
 */ 
class ReaktorArtwork extends BaseReaktorArtwork
{
  const DRAFT           = 1;
  const SUBMITTED       = 2;
  const APPROVED        = 3;
  const REJECTED        = 4;
  const REMOVED         = 5;
  const APPROVED_HIDDEN = 6;
  
  /**
   * Get link to artwork.
   * Which file in the artwork that is be displayed on top can be sent in
   * as a parameter. Only useful in artworks with more than one file.
   *
   * @param string $mode
   * @param integer $file_id which file should be on top
   * @param boolean $external
   *  
   * @return string
   */
  function getLink($mode = 'show', $file_id = null, $external= false)
  {
    $file = '';
    $param_key = '';
    if($file_id)
    {     
      $param_key  = ($mode == 'remove') ? '&remove=' : '&file=';
      $param_key .= $file_id;     
      $file       = '_file';
      //For the external urls      
      $file_id    = $external ? $file_id : ''; 
    }    
    
    $modestring = $mode.'_artwork';
    if ($mode == 'xml')
    {
    	$modestring = 'show_artwork_xml';
    }
    
    if (!$external)
    {
      $linkstring = '@'.$modestring.$file.'?id='.$this->getId().$param_key;
      if ($mode != 'xml')
      {
        if ($file_id) $linkstring .= $file_id;
      	$linkstring .= '&title='.$this->getTitle();
      }
    } 
    else
    {
      $linkstring = '/'.sfContext::getInstance()->getUser()->getCulture().'/artwork/'.$mode.'/'.$this->getId();
      if ($mode != 'xml')
      {
        if ($file_id) $linkstring .= '/'.$file_id;
        $linkstring .= '/'.$this->getTitle();
      }
    }
    /*$linkstring = !$external ? 
                  '@'.$modestring.$file.'?id='.$this->getId().$param_key.'&title='.$this->getTitle() :
                  '/'.sfContext::getInstance()->getUser()->getCulture().'/artwork/'.$mode.'/'.$this->getId().'/'.$file_id.$this->getTitle();
     */
    return $linkstring;
 
    //return Subreaktor::addProvidedLinkIfValid($linkstring);
  }
  
  public function getFirstFile() 
  {
    $tmp = $this->getReaktorArtworkFiles();
    return $tmp;
  }
  
  public function __toString()
  {
  	return '';
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

  // Let the Feed plugin generate the ID
  public function getUniqueId() {
      return null;
  }

  /**
   * Get the number of comments an artwork has in an environment 
   * 
   * @return int Number of comments
   */
  public function getCommentCount($namespace)
  {
    $c = new Criteria();
    
    $c->add(sfCommentPeer::COMMENTABLE_MODEL, get_class($this));
    $c->add(sfCommentPeer::COMMENTABLE_ID, $this->getId());
    $c->add(sfCommentPeer::NAMESPACE, $namespace);
    $c->addJoin(sfCommentPeer::AUTHOR_ID, sfGuardUserPeer::ID);
    
    return sfCommentPeer::doCount($c);
  }

  /**
   * Update logged in user's last active flag after adding comment
   *     
   * @param array $comment 
   * @return result from parent in plugin
   */
  public function addComment($comment)
  {

    //We want to call the current function's parent, but since that addComment function is in a propel behaviour class 
    //in the plugin sfactsascommentablebehaviour it cannot be done conventionally by inheriting. So we call it directly
    //instead.
    $behaviour = new sfPropelActAsCommentableBehavior();
    $ret       = $behaviour->addComment($this, $comment);
    
    if ($comment['namespace'] == 'frontend')
    {
      sfContext::getInstance()->getUser()->getGuardUser()->setLastActive(date('Y-m-d H:i:s'));
      sfContext::getInstance()->getUser()->getGuardUser()->save();
    }
    
    return $ret;
  }

  /**
   * Get list of relevant help articles by matching article and artwork's categories and subreaktors.
   * 
   * @param array $subreaktors The artwork belongs to these subreaktors
   * @param array $categories The categories this artwork is marked with
   * @return array Article objects
   */
  public function getHelpArticles($subreaktors, $categories = null)
  {
    $crit = new Criteria();
    $crit->addSelectColumn('article.*');
    $crit->addSelectColumn('if(article_category.category_id is null, 1,0) as isnull');
    
    $crit->add(ArticlePeer::ARTICLE_TYPE, ArticlePeer::HELP_ARTICLE, Criteria::EQUAL);    
    $crit->setLimit(sfConfig::get('app_articles_my_page_max_count', 5));
    
    $crit->addJoin(ArticlePeer::ID, ArticleCategoryPeer::ARTICLE_ID, Criteria::LEFT_JOIN);
    $crit->addJoin(ArticlePeer::ID, ArticleSubreaktorPeer::ARTICLE_ID, Criteria::LEFT_JOIN);

    //Only select articles which are marked with the same subreaktor as the artwork, and if article has a category it has to match
    //one of the artwork's categories  
    $crit->add(ArticleSubreaktorPeer::SUBREAKTOR_ID, array_keys($subreaktors), Criteria::IN);  
    if($categories) 
    {
      $cton1 = $crit->getNewCriterion(ArticleCategoryPeer::CATEGORY_ID, null , Criteria::EQUAL);
      $cton2 = $crit->getNewCriterion(ArticleCategoryPeer::CATEGORY_ID, array_keys($categories), Criteria::IN);
      $cton1->addOr($cton2);
      
      $crit->add($cton1);
    } 
    else //The artwork has no categories, get articles with no categories
    {
      $crit->add(ArticleCategoryPeer::CATEGORY_ID, null , Criteria::EQUAL);
    }
    
    //$crit->addDescendingOrderByColumn(ArticlePeer::IS_STICKY);
           
    $crit->add(ArticlePeer::STATUS,2);
    $crit->addAscendingOrderByColumn('isnull');
    $crit->addDescendingOrderByColumn(ArticlePeer::UPDATED_AT);
    
    //This query works because distinct seeds out the multiple entries created from the left joins. If select is altered
    //to include other objects/tables (i.e by using doselectjoin), this query will not work as intended. 
    $crit->setDistinct();
    return ArticlePeer::doSelect($crit);
  }

  public function getShortTitle($max = 0)
  {
    return stringMagick::chop($this->getTitle(), $max ? $max : sfConfig::get("app_artwork_teaser_len", 40));
  }
}

sfPropelBehavior::add('ReaktorArtwork', array('sfPropelActAsTaggableBehavior'));
sfPropelBehavior::add('ReaktorArtwork', array('sfPropelActAsCommentableBehavior'));
sfPropelBehavior::add('ReaktorArtwork', array('sfPropelActAsRatableBehavior' =>
        array('max_rating'      => 6, 
              'rating_field'    => 'AverageRating')));
