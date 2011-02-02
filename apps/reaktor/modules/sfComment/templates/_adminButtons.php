<?php
/**
 * Admin buttons for comment administration
 *
 * PHP Version 5
 *
 * @author    Russ Flynn <russ@linpro.no>
 * @copyright 2008 Linpro AS
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 *
 */
use_helper("Javascript", "button");

if ($comment['Unsuitable'] == 2)
{
  $restoreText = __("Restore this comment");
}
else
{
  $restoreText = __("Mark comment ok");
}
$num_comments = isset($comment_pager)?$comment_pager->getNbResults()-1:0;
?>
<div id = "admin_buttons_<?php echo $comment["Id"]; ?>" style = "display: inline">
  <?php if ($comment['Unsuitable'] < 2): ?>
    <?php echo fake_button(__("Remove comment"), array(   
          'url' => 'sfComment/unsuitableToggle?mode=remove&id='.$comment['Id'], 
          'complete'=> "$('comment_header_total').innerHTML = '".__('Total %number_of_comments% comments', array('%number_of_comments%' => $num_comments))."'; Effect.BlindUp('sf_comment_".$comment['Id']."'); $('delete_button_".$comment['Id']."').value='".__("Restore comment")."'; ",
          'confirm' => __("Mark this comment unsuitable?"),
          'update'  => "admin_buttons_".$comment["Id"]
        ), array("id" => "delete_button_".$comment['Id']))?>
  <?php else: ?>
    <?php echo fake_button($restoreText, array(   
      'url' => 'sfComment/unsuitableToggle?mode=restore&id='.$comment['Id'], 
      'complete'=> "Effect.BlindDown('sf_comment_".$comment['Id']."'); 
       $('delete_button_".$comment['Id']."').value='".__("Remove comment")."';
       $('message_".$comment['Id']."').hide();",
      'confirm' => __("Restore this comment?"),
      'update'  => "admin_buttons_".$comment["Id"] 
), array("id" => "restore_button_".$comment['Id']))?>
  <?php endif; ?>
  <?php if ($comment["Unsuitable"] == 1): ?>
  	 <?php echo fake_button($restoreText, array(   
      'url' => 'sfComment/unsuitableToggle?mode=restore&id='.$comment['Id'], 
      'complete'=> "$('delete_button_".$comment['Id']."').value='".__("Remove comment")."';
       $('message_".$comment['Id']."').hide();",
      'confirm' => __("Remove the flag on this comment?"),
      'update'  => "admin_buttons_".$comment["Id"] 
), array("id" => "flagok_button_".$comment['Id']))?>

<?php endif ?>
</div>
