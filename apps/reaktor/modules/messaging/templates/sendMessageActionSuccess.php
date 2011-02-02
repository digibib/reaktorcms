<?php if($to && !$duplicated): ?>
  <?php echo __('Message sent') ?>
<?php else: ?>

  <?php if ($duplicated): ?>
    <?php echo __('Message already sent to this user') ?>
  <?php else: ?>
    <?php echo __('The user does not exist') ?>
  <?php endif ?>
<?php endif ?>