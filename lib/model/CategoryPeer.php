<?php

/**
 * Subclass for performing query and update operations on the 'category' table.
 *
 * 
 *
 * @package lib.model
 */ 
class CategoryPeer extends BaseCategoryPeer
{
	
  public function hydrate(ResultSet $rs, $startcol = 1)
  {
    parent::hydrate($rs, $startcol);
    $this->setCulture(sfContext::getInstance()->getUser()->getCulture());
  }
	
  static public function getAll()
  {
  	$crit = new Criteria();
  	$crit->addAscendingOrderByColumn(CategoryI18nPeer::NAME);
  	return self::doSelectWithI18n($crit);
  }
  
  static public function getAllAsIndexedArray()
  {
  	$categories = self::getAll();
  	$arr = array();
  	foreach ($categories as $category)
  	{
  		$arr[$category->getId()] = $category->getName();
  	}
  	return $arr;
  }
  
}
