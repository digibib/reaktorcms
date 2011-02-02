<?php $mail->setSubject(__('Your Reaktor useraccount: ') . $user->getUsername()) ?>

<?php echo __('sendActivationEmailAlternate %activation_url% %username%', array(
  "%activation_url%"  => "http://".$sf_request->getHost().url_for($url), 
  "%username%" => $user->getUsername(),
)) ?>
