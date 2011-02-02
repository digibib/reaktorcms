<?php $mail->setSubject(__('Changed email on your reaktor account')) ?>
<?php echo __('newEmailActivationAlternate %oldemail% %newemail% %username% %verifylink%', array(
  "%oldemail%" => $oldemail, 
  "%newemail%" => $newemail,
  "%username%" => $sf_user->getUsername(),
  "%verifylink%" => "http://".$sf_request->getHost().url_for($url), 
)); ?>

