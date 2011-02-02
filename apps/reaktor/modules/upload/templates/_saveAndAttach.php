<?php
/**
 * Div block for save and attach to previous artwork
 * Created to provide flexibility with placement on page as this option is placed near the top if a user has selected
 * an artowrk to link to, or at the bottom of the page if not. This partial is thus used only on the upload/edit page
 * and is unlikely to be reused.
 * 
 * This partial will not be displayed at all (decision made on the upload page) if there are no eligible artworks that can
 * be linked to this one. ($artworkArray is empty)
 * 
 * - $artworkArray : Passed from the action to the calling template and then on to this partial, this is the array of
 *                   artworks that are eligible for linking.
 * 
 * PHP Version 5
 *
 * @author    Russ Flynn <russ@linpro.no>
 * @copyright 2008 Linpro AS
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 *
 */

?>

<div id = "link_file_save" class = "clearboth">
	<h2><?php echo __("Save and attach an existing artwork (gallery/collection)") ?></h2>
  <p class = "artwork_select">
    <?php $artworkArray[0] = __('--- Select the artwork to attach this file to ---'); ?>
    <?php echo select_tag("artwork_select", options_for_select($artworkArray, $sf_params->get("link"))); ?>
    <?php echo submit_tag(__('Link to selected artwork'), array("name" => "link_artwork", "class" => "", "style" => "margin-left: 5px;")); ?>
	</p>
	<div id = "uploadanothercheck">
        	  <?php $helpText = __("Check this box to upload another file and link it to the selected artwork"); ?>
        	  <?php echo __("Upload another file: "); ?>
  	<input type = "checkbox" name = "link_another">
  	<br />
        	  <?php echo link_to_function(__("what's this?"), "javascript:void(0)", 
        	                    array("onMouseover" => "Tip('".$helpText."');",
        	                          "onMouseOut" => "UnTip();")); ?>
  </div>
</div>