<?php

/**
 * Subclass for representing a row from the 'reaktor_file' table.
 *
 * 
 *
 * @package lib.model
 */ 
class ReaktorFile extends BaseReaktorFile
{
	
  public function getEmbedLink($artworkfile)
  {
    return 'http://' . sfContext::getInstance()->getRequest()->getHost() . contentPath($artworkfile, 'normal');
  }
	
  /**
   * Get the number of comments a file has in an environment 
   * 
   * @return int Number of comments
   */
  public function getCommentCount($namespace)
  {
    $c = new Criteria();
    
    $c->add(sfCommentPeer::COMMENTABLE_MODEL, get_class($this));
    $c->add(sfCommentPeer::COMMENTABLE_ID, $this->getId());
    $c->add(sfCommentPeer::NAMESPACE, $namespace);
    
    return sfCommentPeer::doCount($c);
  }
}

sfPropelBehavior::add('ReaktorFile', array('sfPropelActAsTaggableBehavior'));
sfPropelBehavior::add('ReaktorFile', array('sfPropelActAsCommentableBehavior'));