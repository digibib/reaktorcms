<?php
/**
 * template for message inbox
 *  
 * PHP version 5
 * 
 * @author    Ole-Petter Wikene <olepw@linpro.no> 
 * @copyright 2008 Linpro AS
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 */

use_helper('Javascript', 'content', 'PagerNavigation');
reaktor::setReaktorTitle(__('Message history for %username%', array("%username%" => $sf_user->getUsername()))); 

?>

<h2><?php echo __('Message history for %username%', array("%username%" => $sf_user->getUsername())); ?></h2>
<?php foreach ($pager->getResults() as $message): ?>
  <?php $toMe = $message->getToUserId() == $sf_user->getGuardUser()->getId(); ?>
  <?php if ($toMe): ?>
    <?php $theOtherGuy = $message->getsfGuardUserRelatedByFromUserId(); ?>
    <div style="width: 360px; margin-top: 8px;border: 1px solid grey; overflow: auto;" id="msg_<?php echo $message->getId()?>">
  <?php else: ?>
    <?php $theOtherGuy = $message->getsfGuardUserRelatedByToUserId(); ?>
    <div style="margin-left: 370px; margin-top: 8px;border: 1px solid grey; overflow: auto;" id="msg_<?php echo $message->getId()?>">
  <?php endif; ?>
      <div>
        <?php echo image_tag('/uploads/profile_images/'.$theOtherGuy->getAvatarOrDefault(), array('size' => '16x16', 'alt' => $sf_user->getUsername())) ?>
        <strong>
          <?php if ($toMe): ?>
            <?php echo __('From: %username%', array("%username%" => $theOtherGuy->getUsername())) ?>
          <?php else: ?>
            <?php echo __('To: %username%', array("%username%" => $theOtherGuy->getUsername())) ?>
          <?php endif; ?>
        </strong>
  <?php echo timeToAgo($message->getTimestamp()) ?>
      </div>
      <div>
        <br />
  <?php echo htmlentities($message->getMessage(), ENT_QUOTES, 'UTF-8') ?>
        <br />&nbsp;
      </div>
  <?php echo link_to_remote(__('Delete'), array( 'url' => '@deletemessage?id='.$message->getId(),
                                                      'confirm' => __('Are you sure'),
                                                      'loading' => visual_effect('appear', 'msg_loading'),
                                                      'complete' => 'window.location.reload()',
                                                      )) ?>  
  <?php if ($toMe && !$message->isIgnored()): ?>
    <?php echo link_to_remote(__('Ignore this user'), array( 'url' => '@ignoreuser?id='.$theOtherGuy->getId().'&do=add',
                                                               'loading' => visual_effect('appear', 'msg_loading'),
                                                               'complete' => 'window.location.reload()',
                                                               'update' => 'ignoreuser_'.$message->getId()
                                                              )); ?>
  <?php elseif ($toMe): ?>
    <?php echo __('This user is ignored') ?>
  <?php endif; ?>

    </div>
<?php endforeach ?>


<?php echo pager_navigation($pager, '@messageinbox') ?>

