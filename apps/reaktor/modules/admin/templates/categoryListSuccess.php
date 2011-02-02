<?php
/**
 * Category list admin page
 * This template displays all the current categories with a link to translate each one
 * Variables passed by the action:
 * - $categories : An array of category objects, containing all the categories the site is currently using
 *
 * PHP Version 5
 *
 * @author    Russ Flynn <russ@linpro.no>
 * @copyright 2008 Linpro AS
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 *
 */

reaktor::setReaktorTitle(__('List categories')); 
use_helper('Javascript');
?>

<h1><?php echo __('Category list');?> [ <?php echo reaktor_link_to(__("Create new"), "@newCategory") ?> ]</h1>
<br />

<table>
  <thead>
  <tr>
    <th>ID</th>
    <th><?php echo __('Base name') ?></th>
    <th><?php echo __('Display name')." ( ".$sf_user->getCulture()." )"; ?></th>
    <th colspan="2"><?php echo __('Actions') ?></th>
  </tr>
  </thead>
  <tbody>
    <?php foreach ($categories as $category): ?>
    	<tr>
    	    <td style="padding-right: 10px;"><?php echo $category->getId(); ?></td>
    	    <td style="padding-right: 10px;"><?php echo $category->getBasename(); ?>
    	        
    	        <?php include_partial('renameComponent', array('category' => $category)); ?>
    	        

    	    </td>
    			<td style="padding-right: 10px;"><?php echo $category->getName(); ?></td>
          <td><?php echo reaktor_link_to(__('Edit'), '@editCategory?id='.$category->getId()); ?></td>
          <td><?php echo link_to_function(image_tag("/sf/sf_admin/images/edit_icon.png", array("width" => 10)), 
            	              "Effect.toggle('categoryeditor_".$category->getId()."','appear')"); ?></td>
          
      </tr>
    <?php endforeach; ?>
	</tbody>
</table>