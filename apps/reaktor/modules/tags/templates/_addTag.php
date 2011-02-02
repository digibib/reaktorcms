<?php
/**
 * Provides an ajax interface to quickly add an approved tag
 * 
 * Displayed in the filter box on the tag list/administration page
 *
 * PHP Version 5
 *
 * @author    Daniel André Eikeland <dae@linpro.no>
 * @copyright 2008 Linpro AS
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 *
 */

?>

<h2><?php echo __("Add a new tag"); ?></h2>
<br />
<?php echo form_remote_tag(array('url' => '@admin_addtag', 'update' => 'tag_add_status')); ?>
<dl>
  <dt><?php echo __('Tag name'); ?></dt>
  <dd><?php echo input_tag('tag_name', '', array('class' => 'short')); ?></dd>
</dl>
<?php echo submit_tag(__('Add tag')); ?>
<?php echo '</form>'; ?>
<div id="tag_add_status"> </div>