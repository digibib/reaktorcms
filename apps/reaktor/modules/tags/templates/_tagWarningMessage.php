<?php
/**
 * Tag warning message for if no tags are yet supplied
 * No parameters are required
 * 
 * Only edit the text below if you need to significantly change the layout
 * otherwise you can edit the text by modifying the translations. Editing the text below will only alter the "fallback" English text
 * which is used when no translation is found.
 *
 * PHP Version 5
 *
 * @author    Russ <russ@linpro.no>
 * @copyright 2008 Linpro AS
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 *
 */

?>
<?php if ($object instanceof reaktorFile || $object instanceof artworkFile): ?>
  <div class = 'warning_box'>
    <div class="file_warning" <?php echo isset($options["nomargin"]) ? "style='margin-left:0px'" : ""; ?>>
      <?php echo __('This file has no tags. Tags makes your files easier to find.'); ?>
      <?php /*
      <li><?php echo __('Enter one at a time, or use a comma seperated list.'); ?></li>
      <li><?php echo __('New tags (Red) will be approved by a moderator before they are made live.'); ?></li> */ ?>
    </div>
  </div>
<?php elseif ($object instanceof genericArtwork ): ?>
  <div class = 'warning_box'>
    <ul <?php echo isset($options["nomargin"]) ? "style='margin-left:0px'" : ""; ?>>
      <li><?php echo __('This artwork has no tags. Tags makes your artworks easier to find.'); ?></li>
      <?php /* 
      <li><?php echo __('Enter one at a time, or use a comma seperated list.'); ?></li>
      <li><?php echo __('New tags (Red) will be approved by a moderator before they are made live.'); ?></li> */ ?>
    </ul>
  </div>
<?php endif; ?>