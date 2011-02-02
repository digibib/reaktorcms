<?php

/**
 * Subclass for performing query and update operations on the 'category_subreaktor' table.
 *
 * 
 *
 * @package lib.model
 */ 
class CategorySubreaktorPeer extends BaseCategorySubreaktorPeer
{
  /**
   * Get categories that are linked to a subreaktor
   *
   * @param subreaktor|integer|array $subreaktor  subreaktor object, id or array of such
   * @param boolean                  $byReference whether ids or references have been passed
   * @param boolean                  $get_all     whether to return all or just used categories
   *
   * @return array of categories
   */
  public static function getCategoriesUsedBySubreaktor($subreaktor = 0, $byReference = false)
  {
    return self::_getSubreaktorCategories($subreaktor, $byReference, false);
  }
  
  /**
   * Get cateogries that are not assigned to a subreaktor
   *
   * @param Subreaktor|integer $subreaktor  subreaktor object or ID
   * @param boolean            $byReference true if references are passed rather than IDs
   */
  public static function getCategoriesNotUsedBySubreaktor($subreaktor = 0, $byReference = false)
  {
    return self::_getSubreaktorCategories($subreaktor, $byReference, true);
  }
  
  /**
   * A category is connected to a subreaktor, this function get all categories that belong to a set of subReaktors,
   * or categories that are not used by a set of subReaktors. This depends on the $exclude parameter. 
   *
   * @param mixed $subreaktor 
   * @param boolean $byReference If true, match on reference not id. 
   * @param boolean $exclude If true, exclude all categories connected to given subreaktor.
   * @return array Categories list, ready to be used in a dropdown.
   */
  private final static function _getSubreaktorCategories($subreaktor = 0, $byReference = false, $exclude = false)
  {
    $subreaktors = array();
    
    if ($subreaktor instanceof Subreaktor )  //Get subreaktor ids 
    {
      $subreaktors[] = $subreaktor->getId();
    }
    elseif (is_array($subreaktor))
    {
      foreach($subreaktor as $thisItem)
      {
        if ($thisItem instanceof Subreaktor ) 
        {
          $subreaktors[] = $thisItem->getId();
        }
        else
        {
          $subreaktors[] = $thisItem;
        }
      }
    }
    
    $categoryArray = array();
    $c             = new Criteria();
    
    if ($exclude) //Exclude categories used by subreaktor(s)  
    {
      $d = new criteria();
      if($subreaktor) //exclude categories used by a given subreaktor 
      {
        $d->add(CategorySubreaktorPeer::SUBREAKTOR_ID, $subreaktors, Criteria::IN);
      }
      else //exlude categories used by any of the subreaktors
      {
        $d->setDistinct();
      }
      $excludeResults = CategorySubreaktorPeer::doSelect($d);
      $excludeArray   = array();
      foreach ($excludeResults as $excludeResult)
      {
        $excludeArray[] = $excludeResult->getCategoryId();
      }
      $c->add(CategoryPeer::ID, $excludeArray, Criteria::NOT_IN);
    }
    else //Get categories that belong to subReaktor
    {
      if ($byReference)
      {
        $c->add(SubreaktorPeer::REFERENCE, $subreaktors, Criteria::IN);
        $c->addJoin(SubreaktorPeer::ID, CategorySubreaktorPeer::SUBREAKTOR_ID);
      }
      else
      {
        $c->add(CategorySubreaktorPeer::SUBREAKTOR_ID, $subreaktors, Criteria::IN);
      }
    }
    
    if (!$exclude)
    {
      $c->addJoin(CategoryPeer::ID, CategorySubreaktorPeer::CATEGORY_ID);
    }

    $c->addAscendingOrderByColumn(CategoryI18nPeer::NAME);
    
    $categories = CategoryPeer::doSelectWithI18n($c);
    
    foreach ($categories as $category) //Arrange result into an array to be used in drop-down
    {
      $categoryArray[$category->getId()] = $category->getName();
    }
    
    return $categoryArray;
  }
}
