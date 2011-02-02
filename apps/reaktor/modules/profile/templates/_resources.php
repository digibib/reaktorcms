<?php
/**
 * A user can add and remove resources - links to other web sites they think are useful. This
 * template consist of a list of resources, a form to add it, and links to remove as well.
 *
 * Example of usage:
 * include_component('profile','resources' ,array('user' => $user->getId()))
 * 
 * The paramters needed:
 * $user - the id of the user  
 * 
 * The controller passes the following information:
 * $resources - The already added resources belonging to this user
 *  
 * PHP version 5
 * 
 * @author    June Henriksen <juneih@linpro.no>
 * @copyright 2008 Linpro AS
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 */


use_helper('Javascript', 'Validation', 'wai') 
?>
<div id='all_resources_block'>

  <h2>
    <?php echo __('My resources') ?>
  </h2>
  <ul>
  <?php foreach ($resources as $resource): ?>
    <li>
      <?php echo link_to($resource->getUrl(), $resource->getUrl(), array("target" => "_new")) ?>
      <?php echo link_to_remote(image_tag('delete.png', 'alt=delete.png size=10x10'), array(
        'update'   => 'all_resources_block', 
        'url'      => '@removeresource?user='.$user.'&resourceid='.$resource->getId(),
        //'loading'  => "Element.show('resource_ajax_indicator')",
        //'complete' => "Element.hide('resource_ajax_indicator')",
        'script'   => true,
      )) ?>
    </li>
  <?php endforeach ?>
  </ul>
  
  <?php echo form_remote_tag(array(
      'update'   => 'all_resources_block',
      'url'      => '@addresource?user='.$user,
      'loading'  => "Element.show('resource_ajax_indicator')",
      'complete' => "Element.hide('resource_ajax_indicator')",
      'script'   => true), array(
	    'class' => 'add_resource_form', 
	    'id'    => 'add_resource_form', 
	    'name'  => 'add_resource_form'
  )) ?>

    <h2>
      <?php echo wai_label_for('resource_url', __('Add a resource')) ?>
    </h2>
    
    <div id="resource_ajax_indicator" style="display: none">
      &nbsp;
      <?php echo image_tag('spinning18x18.gif', 'alt=spinning18x18')?>
    </div>
    
    <?php echo form_error('resource_url') ?>
    <?php echo input_tag('resource_url', 'http://', array(
      'class'=> 'width_shorter')) ?>
  
    <?php echo submit_tag(__('Save resource'), array(
       'class' => 'submit'
     )) ?>
  
  </form>
  
</div>

