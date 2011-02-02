<?php

/**
 * Subclass for representing a row from the 'category' table.
 *
 * 
 *
 * @package lib.model
 */ 
class Category extends BaseCategory
{
	
	public static function getByBasename($baseName)
	{
		$c = new Criteria();
		$c->add(CategoryPeer::BASENAME,$baseName);
		return CategoryPeer::doSelectOne($c);
	}

	public static function getByBasenameLike($baseName)
	{
		$c = new Criteria();
		$c->add(CategoryPeer::BASENAME,$baseName.'%',Criteria::LIKE);
		return CategoryPeer::doSelect($c);
	}
	
}
