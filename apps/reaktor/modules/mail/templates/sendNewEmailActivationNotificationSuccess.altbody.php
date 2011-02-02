<?php $mail->setSubject(__('Changed email on your reaktor account')) ?>
<?php echo __('sendNewEmailActivationNotificationAlternate %oldemail% %newemail% %username%', array(
  "%oldemail%" => $oldemail, 
  "%newemail%" => $newemail,
  "%username%" => $sf_user->getUsername(),
)) ?>
