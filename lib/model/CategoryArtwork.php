<?php

/**
 * Subclass for representing a row from the 'category_artwork' table.
 *
 * 
 *
 * @package lib.model
 */ 
class CategoryArtwork extends BaseCategoryArtwork
{
	/*
	 * Retrieves a list of artworks from a categoryid
	 * 
	 */
	public static function getArtworkIdFromCategoryId($id)
	{
		$c = new Criteria();
		$c->add(CategoryArtworkPeer::CATEGORY_ID,$id);
		return CategoryArtworkPeer::doSelect($c);
	}
}
