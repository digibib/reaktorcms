<?php $mail->setSubject(__("Password request for your reaktor account, %%username%%.", array("%%username%%" => $username))); ?>

<?php echo __('sendPasswordEmailHTML %username% %link% %fromname% %frommail%', array(
  "%link%"     =>  link_to("", '@changepassword?username=' .$username. '&key=' . $newpassKey, array("absolute" => true)),
  "%username%" => $username,
  "%fromname%" => $fromName, 
  "%frommail%" => $fromMail,
)) ?>
