<?php $mail->setSubject(__('Your Reaktor useraccount:') . $user->getUsername()) ?>


<?php echo __('sendProfileRegisteredByAdminHTML %username% %password%', array(
  "%password%" => $password, 
  "%username%" => $user->getUsername() ,
)) ?>