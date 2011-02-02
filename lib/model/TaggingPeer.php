<?php

/**
 * Subclass for performing query and update operations on the 'tagging' table.
 *
 * @package plugins.sfPropelActAsTaggableBehaviorPlugin.lib.model
 */ 
class TaggingPeer extends BaseTaggingPeer
{
  /**
   * Function for approving a tagging - this is the most efficient way to stop tags appearing in
   * search results and tag clouds. When a "parent" object is approved, this function should be called
   * to approve the tag relationship and then it will show.
   *
   * @param Tag|Tagging|integer                $tag        The tag/tagging object or tag ID or null for all
   * @param string                             $model      The model (ReaktorFile for example)
   * @param ReaktorFile|GenericArtwork|integer $taggableId The tagged object or it's id
   * @param integer                            $approved   The value to set 1 or 0 (1 is default)
   */  
  public static function setTaggingApproved($tag, $model, $taggable, $approved = 1)
  {
    $tagId = 0;
    
    if ($tag instanceof Tagging)
    {
      $tag->setParentApproved(1);
      if ($tag->getParentUserId() == 0)
      {
        $tag->setParentUserId(sfContext::getInstance()->getUser()->getId());
      }
      $tag->save();
      return;
    }
    elseif ($tag instanceof Tag)
    {
      $tagId = $tag->getID();
    }
    elseif (is_numeric($tag) && $tag != 0)
    {
      $tagId = $tag;     
    }
    elseif (!is_null($tag))
    {
      $tagObject = TagPeer::retrieveByTagname($tag);
      $tagId     = $tagObject->getID();
    }
  
    
    
    if (is_object($taggable))
    {
      $taggableId = $taggable->getId();
    }
    elseif (!is_int($taggable))
    {
      throw new Exception ("Not a valid object or ID");
    }
    else
    {
      $taggableId = $taggable;
    }
    
    $c = new Criteria();
    
    if ($tagId > 0)
    {
      $c->add(TaggingPeer::TAG_ID, $tagId);
    }
    $c->add(TaggingPeer::TAGGABLE_MODEL, $model);
    $c->add(TaggingPeer::TAGGABLE_ID, $taggableId);
    
    $taggingObjects = TaggingPeer::doSelect($c);
    foreach ($taggingObjects as $taggingObject)
    {
      $taggingObject->setParentApproved($approved);
      if ($taggingObject->getParentUserId() == 0)
      {
        $taggingObject->setParentUserId(sfContext::getInstance()->getUser()->getId());
      }
      $taggingObject->save(); 
    }
  }

  public static function setAllTaggingsApproved($taggable, $approved = 1)
  {
    $tags = TagPeer::getTagsByObject($taggable);
    foreach($tags as $tag)
    {
      TaggingPeer::setTaggingApproved($tag, "Article", $taggable);
    }
  }

  /**
   * Set the User ID of the parent tagged object in the tagging table
   *
   * @param string|tag  $tag      the tag name or object
   * @param string  $model    the taggable model
   * @param integer $taggable the taggable id
   * @param integer $userId   the user id to set
   */
  public static function setParentUserId($tag, $model, $taggable, $userId)
  {
    if ($tag instanceof tag)
    {
      $tag = $tag->getName();
    }
    
    $c = new Criteria();
    $c->add(self::TAGGABLE_MODEL, $model);
    $c->add(self::TAGGABLE_ID, $taggable);
    $c->add(TagPeer::NAME, $tag);
    $c->addJoin(self::TAG_ID, TagPeer::ID);
    
    $taggableObject = self::doSelectOne($c);
    
    if ($taggableObject)
    {
      $taggableObject->setParentUserId($userId);
      $taggableObject->save();
    }
    else
    {
      throw new exception ("Couldn't find that tagging instance");
    }
  }
  /**
   * Remove tagged rows based on a tag ID
   *
   * @param integer $tagId The tag id to use when deleting
   */
  public static function deleteLinks($tagId)
  {
    $c = new Criteria();
    $c->add(TaggingPeer::TAG_ID, $tagId);
    TaggingPeer::doDelete($c);
  }
}
