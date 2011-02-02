<?php

/**
 * Admin buttons for artwork administration
 *
 * PHP Version 5
 *
 * @author    June Henriksen <juneih@linpro.no>
 * @copyright 2008 Linpro AS
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 *
 */

use_helper('Javascript', 'Object', 'wai'); 
reaktor::setReaktorTitle(__('Remove %file_title% from artworks', array("%file_title%" => $artwork_file->getTitle()))); 

?>
<h1><?php echo __('Remove file') ?></h1>

<div class='single_list_artwork'>

  <div class='artwork_list_image'>
      <?php echo image_tag(url_for('@content_thumb?id='.$artwork_file->getId().'&filename='.$artwork_file->getFilename())) ?>
  </div>
  
  <div class='artwork_list_links'>
    <h2 class='artwork_list_header'>
      <?php if($artwork_file->hasArtwork()): ?>          
		  <?php $artworklinks = array(); ?>
		  <?php foreach ($artwork_file->getParentArtworks() as $anArtwork): ?>
		    <?php $artworklinks[] = __('%artwork_title% by %username%', array('%artwork_title%' => link_to($anArtwork->getTitle(), $anArtwork->getLink()), '%username%' => $artwork_file->getUser()->getUsername())) ?>
		  <?php endforeach; ?>
		  <?php echo __("This file is a part of: %list_of_artworks%", array('%list_of_artworks%' => '')); ?><br />
      <?php echo join(', ', $artworklinks); ?>
        <?php //echo __("Part of: '").$artwork_file->getParentArtwork()->getTitle()."'" ?> <br />
      <?php endif ?>
      <?php //echo __('by ').$artwork_file->getUser()->getUsername() ?>
    </h2> <br />  
  </div>
    
<?php //include_partial('displayArtworkInList', array('artwork' => $artwork)); ?>
</div>

<div class='warning'>
<?php echo __('Note! You are about to remove this file from the artwork and send an e-mail to ').$artwork_file->getUser()->getUsername()?>
</div>

<div id='rejection_form'>
<?php echo form_tag('artwork/removeFile') ?>
<dl>
   <dd>
   <?php echo input_hidden_tag('id', $artwork_file->getId()) ?>
   </dd>
   <dd>
   <?php echo input_hidden_tag('status', sfContext::getInstance()->getRequest()->getParameter('status')) ?>
   </dd>

  <dt>
  <?php echo wai_label_for('from', __('From'))?>
  </dt>
  <dd>
  <?php echo form_error('from') ?>
  </dd>
  <dd>
  <?php /*ZOID: Use mail template for this?*/ ?>
  <?php echo input_tag('from', sfConfig::get('app_artwork_sender_email'))?>
  </dd>
  
  <dt>
  <?php echo wai_label_for('to', __('To'))?>
  </dt>
  <dd>
  <?php echo form_error('to') ?>
  </dd>
  <dd>
  <?php echo input_tag('to', $artwork_file->getUser()->getEmail()) ?>
  </dd>
  
  <dt>
  <?php echo wai_label_for('cc', __('Cc'))?>
  </dt>
  <dd>
  <?php echo form_error('cc') ?>
  </dd>
  <dd>
  <?php echo input_tag('cc') ?>
  </dd>
  
  <dt>
  <?php echo wai_label_for('subject', __('Subject'))?>
  </dt>
  <dd>
  <?php echo form_error('subject') ?>
  </dd>
  <dd>
  <?php echo input_tag('subject', __('"%filename%" removed from artwork(s)', array('%filename%' => $artwork_file->getFilename()))) ?>
  </dd>
  
  <dt>
  <?php echo wai_label_for('rejectiontype', __('Rejection type'))?>
  </dt>
  <dd>
  <?php echo form_error('rejectiontype') ?>
  </dd>
  <dd>
  <?php echo select_tag('rejectiontype', objects_for_select($rejectiontypes, 'getId', 'getName', null, 
    array('include_custom'=>'--'.__('Choose removetemplate').'--')))?>
  </dd>
  
  <dt>
  <?php echo wai_label_for('rejectionmsg', __('Remove file message'))?>
  </dt>
  <dd>
  <?php echo form_error('rejectionmsg') ?>
  </dd>
  <dd>
  <?php echo textarea_tag('rejectionmsg', null, array('id'=>'rejectionmsg')) ?>
  </dd>
</dl>
  
<?php echo submit_tag('Remove', array('confirm'=> __('Are you sure?')))  ?>
<?php echo button_to(__('Cancel'), '@listreportedcontent', array('confirm'=> __('Are you sure?'))) ?>
<?php echo observe_field('rejectiontype', array(
  'update'=>'rejectionmsg', 
  'url'=>'@rejection_type_chosen',
  'with' => "'rejectiontype='+value"
))?>
</div>
