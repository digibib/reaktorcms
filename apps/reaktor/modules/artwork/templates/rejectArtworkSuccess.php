<?php
/**
 * Component template that prints the 5 last registered users
 * Query is created and executed from profileComponents class, 
 * function executeLastUsers()
 *  
 * PHP version 5
 * 
 * @author    June Henriksen <juneih@linpro.no> 
 * @copyright 2008 Linpro AS
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 */

reaktor::setReaktorTitle(__('Reject artwork (%artwork_title%)', array("%artwork_title%" => $artwork->getTitle())));
use_helper('content', 'Validation', 'Object', 'Javascript', 'wai'); ?>
<h1>
<?php echo __('Reject artwork') ?>
</h1>
<div class='single_list_artwork'>
<?php include_partial('displayArtworkInList', array('artwork' => $artwork)); ?>
</div>
<div class='warning'>
<?php echo __('Note! You are about to reject an artwork and send an e-mail to ').$artwork->getUser()->getUsername()?>
</div>

<div id='rejection_form'>
<?php echo form_tag('artwork/reject') ?>
<dl>
   <dd>
   <?php echo input_hidden_tag('id', $artwork->getId()) ?>
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
  <?php echo input_tag('to', $artwork->getUser()->getEmail()) ?>
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
  <?php echo input_tag('subject', __('"%artwork_title%" rejected', array('%artwork_title%' => $artwork->getTitle()))) ?>
  </dd>
  
  <dt>
  <?php echo wai_label_for('rejectiontype', __('Rejection type'))?>
  </dt>
  <dd>
  <?php echo form_error('rejectiontype') ?>
  </dd>
  <dd>
  <?php echo select_tag('rejectiontype', objects_for_select($rejectiontypes, 'getId', 'getName', null, 
    array('include_custom'=>'--'.__('Choose rejectiontype').'--')))?>
  </dd>

  <dt>
  <?php echo wai_label_for('rejectionmsg', __('Rejection message'))?>
  </dt>
  <dd>
  <?php echo form_error('rejectionmsg') ?>
  </dd>
  <dd>
  <?php echo textarea_tag('rejectionmsg', null, array('id'=>'rejectionmsg')) ?>
  </dd>
</dl>
  
<?php echo submit_tag(__('Reject artwork'), array('confirm'=> __('Are you sure?')))  ?>
<?php echo button_to(__('Cancel'),'',array('onClick'=>'history.go(-1)')) ?>
<?php echo observe_field('rejectiontype', array(
  'update'=>'rejectionmsg', 
  'url'=>'@rejection_type_chosen',
  'with' => "'rejectiontype='+value"
))?>
</div>
