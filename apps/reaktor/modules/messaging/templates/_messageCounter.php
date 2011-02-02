<?php if ($newMessagesCount == 1): ?>
  <?php echo link_to_function(__('%number_of_messages% new', array('%number_of_messages%' => $newMessagesCount)), visual_effect('toggle_slide', 'message_subject_holder')) ?> 
<?php elseif ($newMessagesCount > 0): ?>
  <?php echo link_to_function(__('%number_of_messages% new', array('%number_of_messages%' => $newMessagesCount)), visual_effect('toggle_slide', 'message_subject_holder')) ?>
<?php else: ?>
    <div class="messages_grey"><?php echo __('%number_of_messages% new', array('%number_of_messages%' => $newMessagesCount)) ?></div>
<?php endif ?>