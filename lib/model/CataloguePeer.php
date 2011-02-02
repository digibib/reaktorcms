<?php

/**
 * Subclass for performing query and update operations on the 'catalogue' table.
 *
 * 
 *
 * @package lib.model
 */ 
class CataloguePeer extends BaseCataloguePeer
{
  public static function getCatalogues($returnArray = false)
  {

    $c       = new Criteria();
    $results = CataloguePeer::doSelect($c);
    
    if ($returnArray)
    {
      foreach ($results as $result)
      {
        $resultArray[$result->getTargetLang()] = $result->getDescription();
      }
      return $resultArray;
    }
    else
    {
      return $results;  
    }
  }
  
  public static function getSelectArr()
  {
    $tmp = array();
    $cat = self::getCatalogues();
    foreach ($cat as $acat)
    {
      $tmp[$acat->getTargetLang()] = $acat->getDescription();
    }
    return $tmp;
  }
}
