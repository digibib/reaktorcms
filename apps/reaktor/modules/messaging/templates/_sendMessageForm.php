<?php
/**
 * Send message form
 *
 * PHP Version 5
 *
 * @author    Ole-Petter Wikene <olepw@linpro.no>
 * @copyright 2008 Linpro AS
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 *
 */
use_helper('Javascript', 'wai');
?>

<?php if ($sf_user->hasCredential('sendmessages')): ?>
<div class="send_message">
<div id="reply_message"></div>
  <?php echo form_tag('@sendmessage', 
                  array('class' => 'message_form', 
                        'id'    => 'message_form', 
                        'name'  => 'message_form'));
     ?>
     <?php echo input_hidden_tag('reply_to'); ?>
  <?php //echo __('Subject') ?>
  <?php //echo input_tag('message_subject','', 'style="display:none;"'); ?>
  <?php //echo wai_label_for('message_subject', __('Message')) ?>
  <?php echo textarea_tag('message_body', '', array("rows" => 8, "cols" => 40)); ?>
  <div class="message_to_row">
    <span><?php echo wai_label_for('message_to',__('To')) ?></span> 
    <?php echo input_auto_complete_tag('message_to', '', '@userlist', null, array('frequency' => 0.2,)) ?>
  </div>

  <div>
      
  <?php if ($sf_user->hasCredential('sendcommentstoall')): ?>      
    <?php echo wai_label_for('send_to_all', __('Send to all')) ?>
    <?php echo checkbox_tag('send_to_all', 1, false) ?>
  <?php endif ?>
  </div>
  <div style="text-align: right;">
  <?php echo input_tag('message_reply_id','', array('style' => 'display: none;')); ?>
  <?php echo submit_to_remote('message_ajax_submit',
                             __('Send message'),
                             array('update'   => array('success' => 'message_status', 'failure' => 'message_status'),
                                   'url'      => '@sendmessage',
                                   'loading'  => visual_effect('appear', 'msg_loading'),
                                   'complete' => visual_effect('toggle_slide', 'send_message_form').visual_effect('fade', 'msg_loading')."$('message_form').reset();",
                                   'script'   => true),
                             array('class' => 'submit'));
        ?>
  </div>
  </form>
</div>
<?php endif; ?>
