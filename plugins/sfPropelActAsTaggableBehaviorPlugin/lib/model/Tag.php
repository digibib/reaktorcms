<?php

/**
 * Subclass for representing a row from the 'tag' table.
 *
 * 
 *
 * @package plugins.sfPropelActAsTaggableBehaviorPlugin.lib.model
 */ 
class Tag extends BaseTag
{
  public function getModelsTaggedWith()
  {
    
  }

  public function getRelated($options = array())
  {
    
  }

  public function getTaggedWith($options = array())
  {
    
  }
  public function __toString()
  {
    return $this->getName();
  }
}
