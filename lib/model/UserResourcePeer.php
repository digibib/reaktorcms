<?php

/**
 * Subclass for performing query and update operations on the 'user_resource' table.
 *
 * 
 *
 * @package lib.model
 */ 
class UserResourcePeer extends BaseUserResourcePeer
{
  
  /**
   * Add resource to the table
   *
   * @param int $user
   * @param string $url
   * 
   * @return void
   */
  public static function addResource($user, $url)
  {
    $resource = new UserResource();
    $resource->setUserId($user);
    $resource->setUrl($url);
    $resource->save();
       
  }
    
}
