<?php 
/**
 * Component to display the next system admin message to expire.
 * Should be used for delivering important messages for the user, 
 * i.e when the system is about to be taken down.  
 *
 * PHP version 5
 *
 * @author    juneih <juneih@linpro.no>
 * @copyright 2008 Linpro
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 *  
 */
?>
<?php if ($admin_message) :?>
<div class='admin_message'>
  <h4><?php echo __('NOTE: System message!') ?></h4>
  <b><?php echo $admin_message->getMessage() ?></b>
</div>
<br />
<?php endif ?>
