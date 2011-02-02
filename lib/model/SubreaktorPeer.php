<?php

/**
 * Subclass for performing query and update operations on the 'subreaktor' table.
 *
 * 
 *
 * @package lib.model
 */ 
class SubreaktorPeer extends BaseSubreaktorPeer
{
  public static function retrieveByReference($reference)
  {
    $c = new Criteria();
    $c->add(SubreaktorPeer::REFERENCE, $reference);
    return parent::doSelectOne($c);
  }

  /**
   * Add all of a table's columns to a query, using the given alias as table name.
   *
   * @param string $alias
   * @param Criteria $criteria
   */
  public static function addAliasSelectColumns( $alias, Criteria $criteria)
  {
    $criteria->addSelectColumn($alias.'.ID');

    $criteria->addSelectColumn($alias.'.REFERENCE');

    $criteria->addSelectColumn($alias.'.LOKALREAKTOR');

    $criteria->addSelectColumn($alias.'.LIVE');

    $criteria->addSelectColumn($alias.'.SUBREAKTOR_ORDER');
  }




  /**
   * Get all the local and sub Reaktors
   *
   * @param boolean $referenceArray if true return array of references not objects
   */
  public static function getAllReaktors($referenceArray = false,$active_only=false)
  {
    $c = new Criteria();


     if ($active_only)
    {
      $c->add(SubreaktorPeer::LIVE,1);
    }

    $result = self::doSelect($c);
    if ($referenceArray)
    {
      $returnArray = array();
      foreach ($result as $resultRow)
      {
        $returnArray[$resultRow->getId()] = $resultRow->getReference();
      }
      return $returnArray;
    }

    return $result;
  }






  /**
   * Get all the local Reaktors
   *
   * @param boolean $referenceArray if true return array of references not objects
   */
  public static function getLokalReaktors($referenceArray = false,$active_only=false)
  {
    $c = new Criteria();
    $c->add(self::LOKALREAKTOR, 1);
    

     if ($active_only)
    {
      $c->add(SubreaktorPeer::LIVE,1);
    }

    $result = self::doSelect($c);
    if ($referenceArray)
    {
      $returnArray = array();
      foreach ($result as $resultRow)
      {
        $returnArray[$resultRow->getId()] = $resultRow->getReference();
      }
      return $returnArray;
    }
    
    return $result;
  }

  /**
   * Get all the local Reaktors
   *
   * @param boolean $referenceArray if true return array of references not objects
   */
  public static function getSubReaktors($referenceArray = false,$active_only=false)
  {
    $c = new Criteria();
    $c->add(self::LOKALREAKTOR, 0);
    $c->addAscendingOrderByColumn(parent::SUBREAKTOR_ORDER);
    if ($active_only)
    {
      $c->add(SubreaktorPeer::LIVE,1);
    }
    $result = self::doSelect($c);
    
    if ($referenceArray)
    {
      $returnArray = array();
      foreach ($result as $resultRow)
      {
        $returnArray[$resultRow->getId()] = $resultRow->getReference();
      }
      return $returnArray;
    }
    
    return $result;
  }

  
  /**
   * Get eligable the local Reaktors
   *
   * @param boolean $referenceArray if true return array of references not objects
   */
  public static function getEligibleLokalReaktors($artwork)
  {
    $c = new Criteria();
    $c->add(self::LOKALREAKTOR, 1);
    $c->addJoin(LokalreaktorResidencePeer::SUBREAKTOR_ID,self::ID);
    $c->add(LokalreaktorResidencePeer::RESIDENCE_ID, $artwork->getUser()->getResidenceId());
    $result = self::doSelect($c);
    
    return $result;
  }
  
  public static function doSelectLokalReaktors()                         
  {
    $c = new Criteria();
    $c->add(self::LOKALREAKTOR, 1);
    
    return parent::doSelect($c);
  }

  /**
   * Get live reaktors
   *
   * @param string $mode all|LokalReaktor|subReaktor
   * @return array SubReaktor Objects - Query result
   */
  public static function getLiveReaktors($mode = 'all',$order = 'asc')
  {
    $c = new Criteria();
    
    $c->add(parent::LIVE, 1, Criteria::EQUAL);
    
    if ($mode == 'LokalReaktor')
    {
      $c->add(parent::LOKALREAKTOR, 1, Criteria::EQUAL);
    }
    elseif ( $mode == 'subReaktor')
    {
      $c->add(parent::LOKALREAKTOR, 0, Criteria::EQUAL);
    }
    if ( $order == 'asc' )
    {
      $c->addAscendingOrderByColumn(parent::SUBREAKTOR_ORDER);
    } else 
    {
      $c->addDescendingOrderByColumn(parent::SUBREAKTOR_ORDER);
    }
    return parent::doSelect($c);
  }
  
  /**
   * Get live reaktors
   *
   * @param string $mode all|LokalReaktor|subReaktor
   * @return array SubReaktor Objects - Query result
   */
  public static function getNotLiveReaktors($mode = 'all')
  {
    $c = new Criteria();
    
    $c->add(parent::LIVE, 0, Criteria::EQUAL);
    
    if ($mode == 'LokalReaktor')
    {
      $c->add(parent::LOKALREAKTOR, 1, Criteria::EQUAL);
    }
    elseif ( $mode == 'subReaktor')
    {
      $c->add(parent::LOKALREAKTOR, 0, Criteria::EQUAL);
    }
    return parent::doSelect($c);
  }
}
