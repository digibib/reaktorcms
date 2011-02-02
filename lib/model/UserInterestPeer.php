<?php

/**
 * Subclass for performing query and update operations on the 'user_interest' table.
 *
 * 
 *
 * @package lib.model
 */ 
class UserInterestPeer extends BaseUserInterestPeer
{
	/**
	 * Retrieve all interests of a user.
	 *
	 * @param integer $user_id
	 * @param array $con
	 * @return mixed
	 */
  public static function retrieveByUser($user_id, $con=null)
  {
    if ($con === null) {
      $con = Propel::getConnection(self::DATABASE_NAME);
    }
    $criteria = new Criteria();
    $criteria->add(UserInterestPeer::USER_ID, $user_id);
    //$criteria->add(UserInterestPeer::SUBREAKTOR_ID, $subreaktor_id);
    $v = UserInterestPeer::doSelect($criteria, $con);

    return !empty($v) ? $v : null;
  }
  public static function retrieveUsersIdLiking($interest)
  {
    $criteria = new Criteria();
    $criteria->add(UserInterestPeer::SUBREAKTOR_ID, $interest);
    return UserInterestPeer::doSelect($criteria);
  }
	
  public static function deleteByUser($user_id, $con=null)
  {
  	if ($con === null) {
      $con = Propel::getConnection(self::DATABASE_NAME);
    }
 
    $criteria = new Criteria(self::DATABASE_NAME);

    $criteria->add(UserInterestPeer::USER_ID, $user_id, Criteria::IN);
    $criteria->setDbName(self::DATABASE_NAME);

    $affectedRows = 0; 
    try {
                  $con->begin();
      
      $affectedRows += BasePeer::doDelete($criteria, $con);
      $con->commit();
      return $affectedRows;
    } catch (PropelException $e) {
      $con->rollback();
      throw $e;
    }
/*
    $criteria = new Criteria();
    $criteria->add(UserInterestPeer::USER_ID, $user_id);
    //$criteria->add(UserInterestPeer::SUBREAKTOR_ID, $subreaktor_id);
    $v = UserInterestPeer::doSelect($criteria, $con);

    return !empty($v) ? $v : null;
    */
  }
}
