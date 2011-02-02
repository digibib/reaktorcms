<?php
/**
 * Partial for New tags text field with autocomplete
 * 
 * This partial contains the text area which is used by the new tag process, it shows an autocomplete dropdown when the user
 * enters a new tag, or list of tags seperated by commas.
 * 
 * - $taggableModel : The taggable model which this tagging is affecting (for example reaktorFile or reaktorArtwork)
 * - $id            : The id of the taggable object that we are tagging
 * 
 * PHP Version 5
 *
 * @author    Russ Flynn <russ@linpro.no>
 * @copyright 2008 Linpro AS
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 *
 */
?>

<?php echo form_error('tags') ?>
<?php echo input_auto_complete_tag('tags', '',
  'tags/autocomplete',
  array("class" => 'short_input','style'=>"width: 140px;"),
  array('use_style' => false,
  'indicator' => 'tag_indicator',
  'tokens' => ',',
  'frequency' => 0.3,
  'with' => "value+'&taggableModel=".$taggableModel."&id=".$id."'")
  );?>
<?php echo submit_tag(__('Add'), array(
  "onclick" => "$('error_for_tags').hide();" 
  )); ?>

<div id = "tag_indicator" style = "display: none;">
  <?php echo image_tag('spinning18x18.gif') ?>
</div>
