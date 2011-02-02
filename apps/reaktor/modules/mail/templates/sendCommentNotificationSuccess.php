<?php $mail->setSubject(__('Notice: Your comment was replied to')) ?>

<?php echo __('sendCommentNotificationHTML %artwork_title% %commenter% %comment_title% %comment% %url_comment%', array(
  "%artwork_title%"  => $artwork->getTitle(), 
  "%commenter%"      => $comment->getsfGuardUser()->getUsername(),
  "%comment_title%"  => $comment->getTitle(),
  "%comment%"        => $comment->getText(),
  "%url_comment%"    => url_for("@show_artwork?id=".$artwork->getId()."&title=".$artwork->getTitle()."#message_".$comment->getId(), true),
)) ?>
