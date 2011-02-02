<?php
/**
 * template for messages
 *  
 * PHP version 5
 * 
 * @author    Ole-Petter Wikene <olepw@linpro.no> 
 * @author    Daniel Andre Eikeland <dae@linpro.no> 
 * @copyright 2008 Linpro AS
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 */
?>

<?php use_helper('Javascript');?> 

  <div class="message_header">
  <div class="message_header_left"><?php echo __('Messages'). ":" ?></div>
  <div class="message_header_right">
    <?php echo image_tag('beskjed.gif', ''); ?>
    <span id="message_count_sidebar">
      <?php include_component("messaging","messageCounter",array('count' => $newMessagesCount)); ?>
    </span>
    </div>
  </div>
  <div class="message_menu">
	  <div id="msg_loading" style="display:none;">
	    <?php echo image_tag('spinning18x18.gif', '') ?>
	  </div>

    <?php if ($sf_user->hasCredential('sendmessages')): ?>	
	    <?php echo link_to_function(__('Write new'), visual_effect('toggle_slide', 'send_message_form'). "$('message_to').value = ''") ?> 
    <?php endif; ?> 

	  <?php //if ($readMessagesCount > 0): ?>
	    <?php //echo link_to_function(__('Archive'), visual_effect('toggle_slide', 'message_subject_holder_read') . visual_effect('blind_up', 'message_subject_holder_archive') .visual_effect('blind_up', 'message_subject_holder') ) ?>
	  <?php //else: ?>
	    <div class="messages_grey"><?php //echo __('Archive') ?></div>
	  <?php //endif ?>
	  <?php //if ($archiveMessagesCount > 0): ?>
	    <?php //echo link_to_function(__('Trash'), visual_effect('toggle_slide', 'message_subject_holder_archive') . visual_effect('blind_up', 'message_subject_holder_read') . visual_effect('blind_up', 'message_subject_holder')) ?>
	  <?php //else: ?>
	    <div class="messages_grey"><?php //echo __('Trash') ?></div>
	  <?php //endif ?>
		| <?php echo link_to(__('History'), '@messageinbox');?>  
	  <?php if ($hasignored): ?> 
	    | <?php echo link_to_function(__('Ignored users'), visual_effect('toggle_slide', 'ignored_users_list')) ?>
	  <?php endif; ?> 
	  <div id="message_status"></div>
  </div>

  <div id="send_message_form" style="display:none;">
    <?php include_partial("messaging/sendMessageForm") ?>
  </div>

  <?php if ($hasignored): ?>
    <div id="ignored_users_list" style="display: none; padding: 0px 3px 0px 3px;">
	    <b><?php echo __('Ignored users:') ?></b><br />
	    <ul>
	    <?php foreach ($ignoredusers as $anignoreduser): ?>
	      <li id="ignored_user_<?php echo $anignoreduser['id'] ?>">
	      <?php echo $anignoreduser['username']; ?> (<?php echo link_to_remote(__('Remove'), array( 'url' => '@ignoreuser?id='.$anignoreduser['id'].'&do=remove',
                                                                                                  'complete' => visual_effect('toggle_slide', 'ignored_user_' .$anignoreduser['id']),
	        )); ?>)</li>
	    <?php endforeach; ?>
	    </ul>
    </div>
  <?php endif; ?>

  <div id="message_subject_holder" style="display: block; width: auto; padding: 0px 3px 5px 3px; ">
  <?php foreach ($messages as $message): ?>
    <?php if ($message->getIsRead()) continue; ?>
    <?php include_partial('messaging/messageContent', array('message' => $message, 'maxlen' => sfConfig::get("app_message_max_length", 500))); ?>
  <?php endforeach ?>
  </div>
  <div id="message_subject_holder_archive" style="display: none; width: auto; padding: 0px 3px 5px 3px;"></div>
<?php /*
  <div id="message_subject_holder_archive" style="display: none; width: auto; padding: 0px 3px 5px 3px;">
	  <?php foreach ($messages as $message): ?>
      <?php if (!$message->getIsDeleted()) continue; ?>
      <?php include_partial('messaging/messageContent', array('message' => $message)); ?>
	  <?php endforeach ?>
  </div>
  <div id="message_subject_holder_read" style="display:none;padding: 0px 3px 0px 3px;">
    <?php foreach ($messages as $message): ?>
      <?php if (!$message->getIsRead()) continue; ?>
      <?php include_partial('messaging/messageContent', array('message' => $message)); ?>
    <?php endforeach ?>
    </div>
    
    */?>
