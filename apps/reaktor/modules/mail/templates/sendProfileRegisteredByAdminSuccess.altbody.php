<?php $mail->setSubject(__('Your Reaktor useraccount:') . $user->getUsername()) ?>

<?php echo __('sendProfileRegisteredByAdminAlternate %username% %password%', array(
  "%password%" => $password, 
  "%username%" => $user->getUsername() ,
)) ?>