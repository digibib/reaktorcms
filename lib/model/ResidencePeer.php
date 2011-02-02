<?php

/**
 * Subclass for performing query and update operations on the 'residence' table.
 *
 * 
 *
 * @package lib.model
 */ 
class ResidencePeer extends BaseResidencePeer
{
  /**
   * To get optgroups in residence drop-down we group by level in nested arrays. 
   *
   */
  public static function getResidenceLevel()
  {
    $c = new Criteria();
    
    $c->addAscendingOrderByColumn(ResidenceLevelPeer::LISTORDER);
    $c->addAscendingOrderByColumn(parent::NAME);
    
    $residences = parent::doSelectJoinAll($c);
    
    //Create nested array
    $residence_array = array(); 
    foreach($residences as $residence)
    {
      $residence_array[$residence->getResidenceLevel()->getName()][$residence->getId()] = $residence->getName();      
    }   
    return $residence_array;

        
  }
}
