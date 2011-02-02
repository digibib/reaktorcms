<?php
/**
 * message content helper
 *  
 * PHP version 5
 * 
 * @author    Daniel Andre Eikeland <dae@linpro.no>
 * @copyright 2008 Linpro AS
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 */
use_helper('content');
if (!isset($maxlen))
{
  $maxlen = 0;
}
?>

<div id="message_<?php echo $message->getId(); ?>" style="width: auto; border-top: 3px solid white; overflow: auto;background:#d0e2e4;">
  <div style="float:left;"><?php //echo __('From %1%:', array('%1%' => $message->getsfGuardUserRelatedByFromUserId()->getUsername())) ?> <?php //echo link_to_remote($message->getSubject(), array( 'url' => '@markmessageread?id='.$message->getId(),
             //                                                     'loading' => visual_effect('toggle_slide','message_body_holder_'.$message->getId()),
    //)); ?>
  </div>
  <div id="message_body_holder_<?php echo $message->getId() ?>"  style="display: block;   padding: 6px 3px 6px 3px; border-top: 4px solid white;">
    <div  style="text-align: right;">
    	<div>
        <?php if ($sf_user->hasCredential("sendmessages")): ?>
        <?php echo link_to_remote('Reply', array( 'url' => '@markmessageread?id='.$message->getId(),
                                                  'update' => 'message_count_sidebar',
                                                  'loading' =>  visual_effect('toggle_slide', 'send_message_form') .visual_effect('blind_up', 'message_subject_holder_archive') . visual_effect('blind_up', 'message_subject_holder_read') . visual_effect('blind_up', 'message_subject_holder') . ";$('message_to').value = '" . $message->getsfGuardUserRelatedByFromUserId()->getUsername() ."';$('reply_message').innerHTML = $('message_body_holder_" . $message->getId() . "').innerHTML;$('reply_to').value = '".$message->getId()."'",
                                                  'complete' => remote_function(array('update'=>'message_subject_holder','url'=>'@updateMessageContentAjax','complete'=>""))
        )); ?> |  
        <?php endif; ?>
        <?php $msgid = 'message_'.$message->getId();?>
        <?php echo link_to_remote('x', array( 'url' => '@markmessageread?id='.$message->getId(),
                                              'update' => 'message_count_sidebar',
                                              'loading' => "$('$msgid').setAttribute('style', 'background-color: #fff');" . visual_effect('toggle_slide', $msgid),
                                            ), array("title" => __("Close message"))); ?>
      </div>
 	  </div>

  	<div class="message_body">
      <br /><?php echo $message->getPartialMessage($maxlen, $cropped) ?>
      <?php if($cropped):?>
        <?php echo "...<br />", link_to(__('read the rest'), '@messageinbox#msg_' . $message->getId()) ?>
      <?php endif; ?>
      <br /><br />
  	</div>
    <?php if($message->getsfGuardUserRelatedByFromUserId()->getAvatar()): ?>
      <?php echo image_tag('/uploads/profile_images/'.$message->getsfGuardUserRelatedByFromUserId()->getAvatar(), array('size' => '16x16', 'alt' => $message->getsfGuardUserRelatedByFromUserId()->getUsername())) ?>
    <?php else: ?>
      <?php echo image_tag('/uploads/profile_images/default16x16.gif', array('size' => '16x16', 'alt' => $message->getsfGuardUserRelatedByFromUserId()->getUsername())) ?>
    <?php endif ?>
    <?php echo $message->getsfGuardUserRelatedByFromUserId()->getUsername() ?>,<br />
      
    <div class="messages_info">
      <?php echo timeToAgo($message->getTimestamp()) ?>
    </div>
    <br />

    <?php if ($message->getIsDeleted($message->getToUserId())): ?> 
	    <?php /*echo link_to_remote(__('Restore'), array( 'url' => '@restoremessage?id='.$message->getId(),
	                                                    'loading' => visual_effect('appear', 'msg_loading'),
	                                                    'complete' => visual_effect('fade', 'message_'.$message->getId()).visual_effect('fade', 'msg_loading')
	                                                    ))*/ ?>  
    <?php else: ?>
      <?php echo link_to_remote(__('Delete'), array( 'url' => '@deletemessage?id='.$message->getId(),
                                                      'confirm' => __('Are you sure'),
                                                      'loading' => visual_effect('appear', 'msg_loading'),
                                                      'complete' => visual_effect('fade', 'message_'.$message->getId()).visual_effect('fade', 'msg_loading')
                                                      )) ?>  
    <?php endif; ?>
    <?php if (!$message->isIgnored()): ?>
      <div id="ignoreuser_<?php echo $message->getId() ?>">
        <?php echo link_to_remote(__('Ignore this user'), array( 'url' => '@ignoreuser?id='.$message->getsfGuardUserRelatedByFromUserId()->getId().'&do=add&read='.$message->getId(),
                                                               'loading' => visual_effect('toggle_slide','message_body_holder_'.$message->getId()),
                                                               'update' => 'message_summary' 
                                                              )); ?>
    <?php else: ?>
      <div>
        <?php echo __('This user is ignored') ?>
    <?php endif; ?>

    </div>
  </div>
</div>
