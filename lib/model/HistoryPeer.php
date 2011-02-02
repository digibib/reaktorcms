<?php

/**
 * Subclass for performing query and update operations on the 'history' table.
 *
 * 
 *
 * @package lib.model
 */ 
class HistoryPeer extends BaseHistoryPeer
{
  /**
   * Get the latest history entry given an action id and an object. For instance, when
   * a specific artwork was last marked for discussion.
   *
   * @param integer $action_id The action applied to an object
   * @param object $object  The object the action has been applied to
   */
  public static function getAction($action_id, $object)
  {
    $c = new Criteria();
    $c->add(self::ACTION_ID, $action_id);
    $c->add(self::OBJECT_ID, $object->getId());
    $c->addDescendingOrderByColumn(self::CREATED_AT);

    $c->setLimit(1);
    $history_array = parent::doSelectJoinAll($c);
    if($history_array)
    {
      return $history_array[0];      
    }
    else
    {
      return $history_array;
    }
  }
  
  /**
   * Get the number of times an object has been reported
   *
   * @param object $obj
   * 
   * @return integer
   */
  public static function countTimesReported($obj)
  {
    $c = new Criteria();
    $c->add(self::ACTION_ID,1); //File reported
    $c->add(self::OBJECT_ID, $obj->getId());
    $hist = self::doSelect($c);
    
    return count($hist);
  }
  
  /**
   * Get the history objects related to a particular object and action 
   *
   * @param object  $object   The object
   * @param integer $actionId The action id (optional)
   * @param integer $limit    Limit number of results (optional)
   */
  public static function getByObjectAndAction($object, $actionId = 0, $limit = 0)
  {
    $c = new Criteria();
    $c->add(self::OBJECT_ID, $object->getId());
    $c->add(self::EXTRA_DETAILS, $object->getTableName());
    $c->addDescendingOrderByColumn(self::CREATED_AT);

    if ($actionId)
    {
      $c->add(self::ACTION_ID, $actionId);
    }
    
    if ($limit)
    {
      $c->setLimit($limit);
    }
    
    return self::doSelectJoinAll($c);
  }
  
  /**
   * Logs an action of any type using action id from history_action table.
   * Example: $action was done to $object in table $extra_details by $user.
   *
   * @param int             $action       Id in history action table
   * @param int|sfGuardUser $user         Id in sf_guard_user table or user object
   * @param object          $object       The object if we are actioning one
   * @param string          $extraDetails Useful extra info, automatically set when object provided
   * 
   * @return void 
   */
  public static function logAction($action, $user, $object = null, $extraDetails = NULL)
  {
    if ($user instanceof sfGuardUser)
    {
      $user = $user->getId();
    }
    $history_row = new History();
    
    if (is_object($object))
    {
      $history_row->setObjectId($object->getId());
      $extraDetails = method_exists($object, "getTableName") ? $object->getTableName() : stringMagick::camelCaseToUnderscores(get_class($object));
    }

    $history_row->setActionId($action);
    $history_row->setUserId($user);
    
    $history_row->setExtraDetails($extraDetails);
    $history_row->save();
    
  }
}
