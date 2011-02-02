<?php
/**
 * 
 *  
 * PHP version 5
 * 
 * @author    Daniel Andre Eikeland <dae@linpro.no>
 * @copyright 2008 Linpro AS
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 */
?>
<div id="list_<?php echo substr(md5($user->getId()), 0, 5); ?>">
  <?php echo form_remote_tag(array('url' => '@listmyteams',
                                   'update' => "message_".substr(md5($user->getId()), 0, 5),
                                   'success' => visual_effect('highlight', "list_".substr(md5($user->getId()), 0, 5)))); ?>
    <?php echo input_hidden_tag('user_id', $user->getId()); ?>
    <?php echo select_tag('notify_value', options_for_select(array(__('No email'),
                                                                           __('Email on first incoming artwork'),
                                                                           __('Email on all incoming artworks')), 
                          $user->getEditorialNotification()),
                          array("onchange" => "$('message_".substr(md5($user->getId()), 0, 5)."').innerHTML='';")); ?>
    <?php echo submit_tag(__('Save')); ?>
    <span id="message_<?php echo substr(md5($user->getId()), 0, 5); ?>"></span>
  <?php echo '</form>'; ?>
</div>