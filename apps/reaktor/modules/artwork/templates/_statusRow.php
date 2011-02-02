<?php
/**
 * Shows the artwork status in a simple row format
 * - $artwork : The artwork object
 * - $break   : If set, breaks the status up into two lines
 * PHP Version 5
 *
 * @author    Russ <russ@linpro.no>
 * @copyright 2008 Linpro AS
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 *
 */
?>
<?php if($sf_user->hasCredential('staff') && isset($show_id)): ?>
  <?php echo __("Artwork ID: ".$artwork->getId()) ?> <br />
<?php endif ?>

<?php echo __("%action% on %on_date% at %at_time%", 
            array("%on_date%" => date("d/m/Y", $t = strtotime($artwork->getCreatedAt(), $_SERVER["REQUEST_TIME"])), 
                  "%at_time%" => date("H:i", $t),
                  "%action%" => __("Created"))); ?>
<?php if (isset($break) && $break === true): ?>
	<br />
<?php else: ?>
	<?php echo " "; ?>
<?php endif; ?>
                  
<?php if ($artwork->isSubmitted()): ?>
  <?php echo __("%action% on %on_date% at %at_time%", 
          array("%on_date%" => date("d/m/Y", $t = strtotime($artwork->getSubmittedAt(), $_SERVER["REQUEST_TIME"])), 
                "%at_time%" => date("H:i", $t),
                "%action%" => "<span class='draft'>".__("Awaiting approval")."</span>")); ?>
<?php elseif ($artwork->isRejected()): ?>
  <?php echo __("%action% on %on_date% at %at_time%" . ($sf_user->hasCredential('staff')?" by %username%":""), 
          array("%on_date%" => date("d/m/Y", $t = strtotime($artwork->getActionedAt(), $_SERVER["REQUEST_TIME"])), 
                "%at_time%" => date("H:i", $t),
                "%action%" => "<span class='rejected'>".__("Rejected")."</span>",
                "%username%" => $artwork->getActionedBy(false),
                )); ?>
<?php elseif ($artwork->isDraft()): ?>
  <?php echo "<span class = 'draft'>".__("Not submitted").'</span>'; ?>
<?php elseif ($artwork->isApproved()): ?>
  <?php echo __("%action% on %on_date% at %at_time%" . ($sf_user->hasCredential('staff')?" by %username%":""), 
          array("%on_date%" => date("d/m/Y", $t = strtotime($artwork->getActionedAt(), $_SERVER["REQUEST_TIME"])), 
                "%at_time%" => date("H:i", $t),
                "%username%" => $artwork->getActionedBy(false),
                "%action%" => "<span class='approved'>".__("Approved")."</span>")); ?>
<?php elseif ($artwork->isRemoved()): ?>
  <?php echo __("%action% on %on_date% at %at_time%",
          array("%on_date%" => date("d/m/Y", $t = strtotime($artwork->getActionedAt(), $_SERVER["REQUEST_TIME"])), 
                "%at_time%" => date("H:i", $t),
                "%username%" => $artwork->getActionedBy(false),
                "%action%" => "<span class='rejected'>".__("Removed by %staff_or_user% %username%", 
                    array("%staff_or_user%" => ($artwork->getActionedBy() == $artwork->getUserId() ? __("user") : __("staff")),
                          "%username%"      => $sf_user->hasCredential('staff') ? "(".$artwork->getActionedBy(false).")" : ""))."</span>")); ?>
<?php elseif ($artwork->isApprovedHidden()): ?>
  <?php echo __("%action% on %on_date% at %at_time%",
          array("%on_date%" => date("d/m/Y", $t = strtotime($artwork->getActionedAt(), $_SERVER["REQUEST_TIME"])), 
                "%at_time%" => date("H:i", $t),
           			"%username%" => $artwork->getActionedBy(false),
                "%action%" => "<span class='draft'>".__("Approved but was hidden by %staff_or_user% %username%", 
                    array("%staff_or_user%" => ($artwork->getActionedBy() == $artwork->getUserId() ? __("user") : __("staff")),
                          "%username%"      => $sf_user->hasCredential('staff') ? "(".$artwork->getActionedBy(false).")" : ""))."</span>")); ?>
<?php endif; ?>

