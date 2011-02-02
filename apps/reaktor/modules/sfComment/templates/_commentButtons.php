<?php if ($sf_user->isAuthenticated()): ?>
    <?php $class = "fakebutton"; ?>
<?php else: ?>
    <?php $class = "fakebutton_disabled"; ?>
<?php endif; ?>
    <?php if($sf_user->hasCredential('postnewcomments')): ?>
      <?php echo fake_button_function(__('Reply'), visual_effect('toggle_slide', 'comments_'.$comment['Id']), array(), '#sf_comment_'.$comment['Id'],"fakebutton",$sf_user->isAuthenticated()) ?>
      <?php echo fake_button(__("New comment"), "#_newcomment",array(),$sf_user->isAuthenticated()) ?></a>
    <?php else: ?>
      <?php echo fake_button(__('Reply'),'#',array(),$sf_user->isAuthenticated()); ?>
      <?php echo fake_button(__("New comment"),'#',array(),$sf_user->isAuthenticated()); ?>
    <?php endif; ?>

    <?php if($namespace == 'frontend'):?>
      <?php echo fake_button(__("Report"), array(   
'url'=>'sfComment/report?id='.$comment['Id'], 
'complete'=> "$('report_button_".$comment['Id']."').value='reported';$('report_button_".$comment['Id']."').disable();",
'confirm' => __("Report this comment to a moderator?")),
      array("id" => "report_button_".$comment['Id']),$sf_user->isAuthenticated())?>   
    <?php endif ?>
