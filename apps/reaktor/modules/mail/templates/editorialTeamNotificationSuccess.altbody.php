<?php $mail->setSubject(__('A new artwork has been submitted')) ?>

<?php echo __('editorialTeamNotificationAlternate %host%', array(
  "%host%"  => $sf_request->getHost() , 
)) ?>
