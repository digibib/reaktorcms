<?php
/**
 * embed link for artwork page
 *  
 * PHP version 5
 * 
 * @author    Daniel Andre Eikeland <dae@linpro.no>
 * @author    Russ Flynn <russ@linpro.no>
 * @copyright 2008 Linpro AS
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 */
?>

<?php echo link_to_function(__('Embed this artwork on other sites'), visual_effect('toggle_slide', 'embed_slider')); ?>

<div id = "embed_slider" style = "display: none;">
  <?php if (isset($link)): ?>
    <p><?php echo __('To embed this artwork on another web site, copy and paste the link below'); ?></p>
    <?php echo input_tag('embed_link', $link, array("class" => "wide_input", "id" => 'embed_link', "onclick" => "this.select()")); ?>
  <?php endif; ?>
  
  <?php if (isset($bb_link)): ?>
    <p><?php echo __('BB code for popular forum software'); ?></p>
    <?php echo input_tag('embed_link_bb', $bb_link, array("class" => "wide_input", "onclick" => "this.select()")); ?>
  <?php endif; ?>

  <?php if (isset($file_path)): ?>
    <p><?php echo __('Direct path to this artwork content'); ?></p>
    <?php echo input_tag('file_path', $file_path, array("class" => "wide_input", "onclick" => "this.select()")); ?>
  <?php endif; ?>


</div>
