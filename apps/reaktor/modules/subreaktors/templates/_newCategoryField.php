<?php
/**
 * When new Reaktors are created, subReaktors in particular, they should have a set of categories
 * connected to them. This template provides a category dropdown, it should show currently unnasigned 
 * categories, but also a link for adding new categories. Example of use: 
 * 
 * include_component("subreaktors", "newCategoryField")
 * 
 * The controller passes the following information:
 * $categories
 *  
 * PHP version 5
 * 
 * @author    Daniel Andre Eikeland <dae@linpro.no>
 * @author    Russ Flynn <russ@linpro.no>
 * @author    June Henriksen <juneih@linpro.no>
 * @copyright 2008 Linpro AS
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 */
?>

<div style = "position: relative;">
  <?php 
  if($categories): 
    echo select_tag('category', options_for_select($categories));
    echo submit_tag(__('Add')); 
  else:?>
    <p>
    <?php echo __('All categories are already in use. If you want to add more categories, 
            you have to create one first.');?>
    </p> 
  <?php endif;?>
  <?php echo reaktor_link_to(__("Create new category"), "@newCategory", array("style" => "position:absolute;right:10px;bottom:-10px;")); ?>
</div>