<?php
/**
 * Thumbnail editing page for a selected file, based on crop area
 * Styles for this are contained in cropper.css, as defined in view.yml
 * 
 * Variables passed from the action are:
 * 
 *  - $file : The file object this thumbnail is connected to
 * 
 * PHP Version 5
 *
 * @author    Russ <russ@linpro.no>
 * @copyright 2008 Linpro AS
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 *
 */

use_helper("content", "Javascript");
reaktor::setReaktorTitle(__('Thumbnail crop')); 

?>

<div id="testWrap">
  <h2><?php echo __('Changing thumbnail for %filetitle%', array('%filetitle%' => $file->getTitle())); ?></h2>
  <span><?php echo image_tag(contentPath($file), array("id" => "testImage")); ?></span>
</div>
<div style="clear: both;">
  <br />
  <div id="previewOuterWrap">
    <h4><?php echo __('Live preview'); ?></h4>
    <div id="previewWrap"></div>
    <p>
      <?php echo __('Your new thumbnail will look like this'); ?>
    </p>
  </div>
  <div id="help_text">
    <?php echo __('Drag the selection box around the area you want to use as a thumbnail image, and press "Save thumbnail" when you are done.'); ?>
    <br />
    <?php echo reaktor_form_tag('@uploadcropimage?file='.$file->getId()); ?>
      <input type="hidden" name="x1" id="x1" size="4" />
      <input type="hidden" name="y1" id="y1" size="4" />
      <input type="hidden" name="x2" id="x2" size="4" />
      <input type="hidden" name="y2" id="y2" size="4" />
      <input type="hidden" name="width" id="width" size="4" />
      <input type="hidden" name="height" id="height" size="4" />
      <?php if (!$file->hasStaticThumbnail()): ?>
      	<p><b><?php echo __('You cannot create a new thumbnail from an animated file'); ?></b></p>
      <?php else: ?>
        <?php echo submit_tag(__('Save thumbnail')) ?>
      <?php endif; ?>
    <?php echo '</form>' ?>
    <br />
    <br />
    <b><?php echo reaktor_link_to(__("&lt;&lt; Back to file edit"), "@edit_upload?fileId=".$file->getId()); ?></b>
  </div>
</div>  

<script type="text/javascript">
//<![CDATA[
  
  function onEndCrop( coords, dimensions ) {
      $( 'x1' ).value = coords.x1;
      $( 'y1' ).value = coords.y1;
      $( 'x2' ).value = coords.x2;
      $( 'y2' ).value = coords.y2;
      $( 'width' ).value = dimensions.width;
      $( 'height' ).value = dimensions.height;
    }

  Event.observe( window, 'load', function() {
    new Cropper.ImgWithPreview(
      'testImage',
      {
        previewWrap: 'previewWrap',
        minWidth: 240,
        minHeight: 160,
        ratioDim: { x: 240, y: 160 },
        onEndCrop: onEndCrop
      }
    );
  } );
//]]>
</script>