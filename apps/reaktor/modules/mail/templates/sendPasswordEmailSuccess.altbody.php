<?php $mail->setSubject(__("Password request for your reaktor account, %%username%%.", array("%%username%%" => $username))); ?>

<?php echo __('sendPasswordEmailAlternate %username% %link% %fromname% %frommail%', array(
  "%link%"     =>  url_for('@changepassword?username=' .$username. '&key=' . $newpassKey, array("absolute" => true)),
  "%username%" => $username, 
  "%fromname%" => $fromName, 
  "%frommail%" => $fromMail,
)) ?>