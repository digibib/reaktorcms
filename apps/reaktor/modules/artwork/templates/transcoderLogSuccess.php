<?php
/**
 * Show the transcoder log for a particular transcoded file
 *
 * PHP Version 5
 *
 * @author    Ole-Peter Wikene <olepw@linpro.no>
 * @author    Russ Flynn <russ@linpro.no>
 * @copyright 2008 Linpro AS
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 *
 */
?>
<div class="transcoder_panel">
  <p>
    <?php if ($data): ?>
      <?php echo nl2br($data); ?>
    <?php else: ?>
      <?php echo __("No log found"); ?>
    <?php endif; ?>
  <p>
</div>