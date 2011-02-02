<?php
/**
 * A template to display a list of categories that are connected to a given subReaktor. Example of use:
 * 
 * get_component('subreaktors', 'categoriesList', array('subreaktor' => $this->subreaktor))
 * 
 * The controller does not pass any information.
 * 
 * PHP version 5
 * 
 * @author    Daniel Andre Eikeland <dae@linpro.no>
 * @copyright 2008 Linpro AS
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 */
?>

<?php include_component("subreaktors", "newCategoryField", array("subreaktor" => $subreaktor)); ?>
<br />
<div id = "categoryList">
  <h4> <?php echo __('Categories in this subReaktor'); ?></h4>
  <?php foreach ($subreaktor->getCategories() as $categoryId => $category): ?>
    <?php echo reaktor_link_to(image_tag("edit.png", array("width" => "10")),"@editCategory?id=".$categoryId); ?>  
    <?php echo link_to_remote(image_tag("delete.png", array("width" => "10")), array(
        'update'   => 'subreaktorCategories',
        'url'      => 'subreaktors/categoryAction',
        'with'     => "'category=".$categoryId."&mode=delete&subreaktor=".$subreaktor->getId()."'",
        'loading'  => "Element.show('category_indicator')",
        'complete' => "setTimeout('Element.hide(\'category_indicator\')', 500)",
        'confirm'  => __('Are you sure you wish to remove this category (%category%) from this Subreaktor?', array('%category%'=> $category))
      )) ?>
    <?php echo $category; ?><br />
  <?php endforeach; ?>
  <?php if (count($subreaktor->getCategories()) == 0): ?>
    <?php echo __('This subReaktor has no categories'); ?>
    <br />
  <?php endif; ?>
</div>
<br />
