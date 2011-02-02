<?php
/**
 * 
 *  
 * PHP version 5
 * 
 * @author    Daniel Andre Eikeland <dae@linpro.no>
 * @copyright 2008 Linpro AS
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 */
/**
 * Category component class used for Ajax category view
 *
 * PHP version 5
 * 
 * @author    Daniel Andre Eikeland <dae@linpro.no>
 * @copyright 2008 Linpro AS
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 */
class subreaktorsComponents extends sfComponents
{
  function executeCategoriesList()
  {
  }
  
  function executeNewFiletypeField()
  {
    $this->filetypes = sfConfig::get("app_files_location_identifiers");
  }
  
  function executeFiletypesList()
  {
  }

  /**
   * List all subcategories in a subreaktor, with number 
   * of artworks per category
   * 
   */
  function executeListSubcategories()
  {   
    if (!isset($this->subreaktor))
    {
    	$this->subreaktor = Subreaktor::getProvidedSubreaktor();
    	
    }
if($this->subreaktor)
  	$this->categories = Subreaktor::listSubcategories($this->subreaktor, sfConfig::get('app_subreaktors_subcategory_list_length', 7));  
  }

  function executeListLokalReaktorSubcategories()
  {

    $cache = reaktorCache::singleton(__METHOD__);
    if (!($serialized = $cache->get()))
    {
      $retval = array();
      $retval[] = Subreaktor::listLokalReaktorSubcategories($this->subreaktor, sfConfig::get('app_subreaktors_subcategory_list_length', 7));
      $retval[] = Subreaktor::listSubcategories($this->subreaktor, sfConfig::get('app_subreaktors_subcategory_list_length', 7));
      $cache->set(serialize($retval));
    }
    else {
      $retval = unserialize($serialized);
    }

    $this->subreaktorcategories = $retval[0];
    $this->categories = $retval[1];
  }

  /**
   * New category dropdown for edit page
   *
   * @return void
   */
  function executeNewCategoryField()
  {
    $this->categories = CategorySubreaktorPeer::getCategoriesNotUsedBySubreaktor($this->subreaktor);
  }
  
}
?>
