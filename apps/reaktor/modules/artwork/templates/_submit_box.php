<?php
 switch (true)
  {
    case $artwork->isDraft():
      ?>
      <div class="message status_draft short_top_margin">
      <h2><?php echo __('Artwork status'); ?>:</h2>&nbsp;
      <h2 class="status_draft"><?php echo __('Draft'); ?></h2>
      <br class="clearboth" />
      <p><?php echo __("This artwork has not yet been submitted for approval"); ?></p>
      <p><?php echo __('Before you submit this artwork for approval, make sure that you have selected at least one subreaktor, one category and added at least one tag'); ?>.</p>
      <?php include_partial("statusButtons", array("artwork" => $artwork, 'nostatus' => true)); ?>
      </div>
      <?php
      break;
    case $artwork->isSubmitted():
      ?>
      <div class="message status_submitted short_top_margin">
      <h2><?php echo __('Artwork status'); ?>:</h2>&nbsp;
      <h2 class="status_submitted"><?php echo __('Awaiting approval'); ?></h2>
      <br class="clearboth" />
      <p><?php echo __("This artwork has been submitted for approval"); ?>. <?php echo __('A member of an editorial team will have a look at it shortly'); ?>.</p>
      <?php include_partial("statusButtons", array("artwork" => $artwork, 'nostatus' => true)); ?>
      </div>
      <?php
      break;
    case $artwork->isApproved():
      ?>
      <div class="message status_approved short_top_margin">
      <h2><?php echo __('Artwork status'); ?>:</h2>&nbsp;
      <h2 class="status_approved"><?php echo __('Approved'); ?></h2>
      <br class="clearboth" />
      <p><?php echo __("This artwork has been approved, and is visible to all users"); ?>.</p>
      <?php include_partial("statusButtons", array("artwork" => $artwork, 'nostatus' => true)); ?>
      </div>
      <?php
      break;
    case $artwork->isRejected():
      ?>
      <div class="message status_rejected short_top_margin">
      <h2><?php echo __('Artwork status'); ?>:</h2>&nbsp;
      <h2 class="status_rejected"><?php echo __('Rejected'); ?></h2>
      <br class="clearboth" />
      <p><?php echo __("This artwork has been rejected by a member of the editorial team for this reason"); ?>:</p>
      <p><?php echo $artwork->getRejectionMsg(); ?>&nbsp;</p>
      <?php include_partial("statusButtons", array("artwork" => $artwork, 'nostatus' => true)); ?>
      </div>
      <?php
      break;
  }
?>