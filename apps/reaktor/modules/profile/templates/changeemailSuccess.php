<?php
/**
 * Started out as a test file for secure actions
 *
 * PHP Version 5
 *
 * @author    Ole-Petter <olepw@linpro.no>
 * @copyright 2008 Linpro AS
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 *
 */

reaktor::setReaktorTitle(__('Change email')); 

?>

<?php if ($changed_email): ?>
  <?php echo __("Your email address has been changed."); ?>
<?php else: ?>
  <?php if ($already_changed): ?>
    <?php echo __("The email address has already been verified."); ?>
  <?php else: ?>
    <?php echo __("Your email address was not changed. Please use the link from the email you received."); ?>
  <?php endif; ?>
<?php endif; ?>

