<?php
/**
 * Show the user's uploaded files, and whether they are attached to artwork or not
 * If admin give the opportunity to see any files
 * 
 * Very basic for now as this is NOT covered in the current task, I just needed something
 * to work with when testing the upload process
 * 
 * Possibly to be updated when workfolow issues are resolved
 *
 * PHP Version 5
 *
 * @author    Russ Flynn <russ@linpro.no>
 * @copyright 2008 Linpro AS
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 *
 */

use_helper("content");
reaktor::setReaktorTitle(__('My files')); 

?>

<h1><?php echo __("My uploaded content")?></h1>
<br />

<?php if (isset($userFiles)): ?>
  <?php foreach ($userFiles as $fileObject):?>
    <div class='artwork_list_image'>
      <?php echo link_to(image_tag(contentPath($fileObject, 'thumb')), "@edit_upload?fileId=".$fileObject->getId()); ?>
    </div>
    <div class = 'artwork_list_info'>
    	<h2 class='artwork_list_header'>
        <?php echo  $fileObject->getMetadata('title') != "" ? $fileObject->getMetadata('title') : __("unnamed"); ?><br />
      </h2> 
      <?php if ($fileObject->hasArtwork()): ?>
    		<h3><?php echo __('(Part of %link_to_artwork_with_title% artwork)', array('%link_to_artwork_with_title%' => reaktor_link_to($fileObject->getParentArtwork()->getTitle(), '@show_artwork_file?id='.$fileObject->getParentArtwork()->getId().'&file='.$fileObject->getId().'&title='.$fileObject->getParentArtwork()->getTitle()))); ?></h3>
    	<?php else: ?>
    	  <br />
    	  <?php echo __('This file has not been submitted for approval') ?><br /> 
    	  <?php echo link_to(__("click here to submit or link to an existing artwork"), "@edit_upload?fileId=".$fileObject->getId()); ?><br />
      <?php endif; ?>
      <br />
      <?php echo __('Uploaded: %date_uploaded%', array('%date_uploaded%' => date('d/m/y', $fileObject->getUploadedAt(true)).', '.date('H.i', $fileObject->getUploadedAt(true)))); ?>
      <br />
      <?php echo __('Last modified: %date_modified%', array('%date_modified%' => date('d/m/y', $fileObject->getModifiedAt(true)).', '.date('H.i', $fileObject->getModifiedAt(true)))); ?>
      <br />
      <?php echo __('Type: %file_type%', array('%file_type%' => $fileObject->getFiletype())); ?>
    </div>
    <br style = "clear: both"/> 
  <?php endforeach; ?>
<?php else: ?>
  <?php echo __("You haven't uploaded anything yet, %link_to_upload_artwork_now%", array('%link_to_upload_artwork_now%' => link_to(__("Upload artwork now"), "@upload_content"))); ?>
<?php endif; ?>