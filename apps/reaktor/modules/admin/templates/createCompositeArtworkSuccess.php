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

use_helper('content', 'Javascript', 'wai');
  reaktor::setReaktorTitle(__('Create composite artwork'));
  
?>
  <div id="composite_generator">
    <h1><?php echo __('Create a new composite artwork') ?></h1>
    <p><?php echo __('Check the boxes to find the files you want to include in your composition, then click the "Find files" button to continue'); ?></p>
    <h3><?php echo __('Find files with the following criteria'); ?></h3>
    <?php echo form_tag('@createcompositeartwork', array("method" => "post")); ?>
      <fieldset>
        <div>
          <?php echo checkbox_tag('tags_check', '1', $sf_params->get('tags_check')); ?>
          <?php echo wai_label_for("tags_check", __('Find files with tags')); ?>
          <p><?php echo __('Separate tags with commas to find more files - ex: (car, flag, honey)', array('(' => '(<i>', ')' => '</i>)')); ?></p>
          <p><?php echo form_error('tags'); ?></p>
        </div>
        <?php echo input_auto_complete_tag('tags', $sf_params->get('tags'), 'tags/autocompletetag', null, array('use_style' => false, 'tokens' => ',', 'frequency' => 0.1)); ?>
        <div>
          <p><?php echo checkbox_tag('date_check', '1', $sf_params->get('date_check')); ?>
          <?php echo wai_label_for("date_check", __('Find files based on date')); ?>
          <?php echo form_error('date'); ?></p>
        </div>
        <p><?php echo __('From: %date%, to %date%', array(' %date%' => '', ', to %date%' => '')); ?>
        <?php echo input_date_tag('from_date', $from_date, array(
                              'rich'           => false, 
                              'culture'        => $sf_user->getCulture(),  
                              'year_end'       => date('Y'), 
                              'year_start'     => 2004,
                              'date_seperator' => ' ',
                              'include_custom' => array('day'=>__('Day'), 'month'=>__('Month'), 'year'=>__('Year'))
        )); ?>
        <?php echo __('From: %date%, to %date%', array('From: %date%' => '', '%date%' => '')); ?>
        <?php echo input_date_tag('to_date', $to_date, array(
                              'rich'           => false, 
                              'culture'        => $sf_user->getCulture(),  
                              'year_end'       => date('Y'), 
                              'year_start'     => 2004,
                              'date_seperator' => ' ',
                              'include_custom' => array('day'=>__('Day'), 'month'=>__('Month'), 'year'=>__('Year'))
        )); ?>
        </p>
        <p><b><?php echo __('Select file type') ?></b></p>
        <p><?php echo select_tag('filetype', options_for_select($filetypes, $sf_params->get('filetype'))); ?></p>
        <?php echo submit_tag(__('Find files')); ?>
      </fieldset>
    <?php echo __('</form>'); ?>
  </div>
  <p><?php echo form_error('nofiles'); ?></p>
  <?php if (isset($files)): ?>
    <div id="composite_file_list">
	    <h2><?php echo __('Files found') ?></h2>
      <?php if (!empty($files)): ?>
	      <p><?php echo __('Check the files that you want to add to the composite artwork, then press the "Create composite artwork" button, which will create the artwork and take you to the "artwork edit" page'); ?></p>
        <?php echo form_tag('@createcompositeartwork', array("id" => "listform", "name" => "listform")); ?>
	      <ul id="composite_artwork_filelist">
			    <?php foreach ($files as $file): ?>
		        <li id="file_<?php echo $file->getId() ?>">
		        <?php include_partial('artwork/displayFileInList', array('file' => $file)) //Display file ?>
            <div class='artwork_list_links'>
			        <?php echo checkbox_tag('include_file[' . $file->getId() . ']', '1', true); ?>
	            <?php echo __('Include this file in the composite artwork'); ?>
            </div>
            </li>
			    <?php endforeach; ?>
        </ul>
        <?php echo input_hidden_tag('docreate', 'true'); ?>
        <div class="clearboth">
          <p style = "text-align:right;">
          	[ <?php echo link_to_function(__("select all"), "checkAllinform('listform', true)"); ?> 
          	/ <?php echo link_to_function(__("de-select all"), "checkAllinform('listform', false)"); ?> ]
          </p>
          <p>
            <?php echo __('Check the files that you want to add to the composite artwork, then press the "Create composite artwork" button, which will create the artwork and take you to the "artwork edit" page'); ?>
          </p>
          <p style = "text-align:right;">
          	<?php echo submit_tag(__('Create composite artwork')); ?>
          </p>
        </div>
        <?php echo '</form>'; ?>
      <?php else: ?>
        <p><?php echo __('Could not find any files based on your criteria'); ?></p>
      <?php endif; ?>
	  </div>
  <?php endif; ?>
