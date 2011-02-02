<?php
/**
 * Partial for handling inline uploads in an iframe
 * Needs prototype (available by default) and inlineupload js (configured in view.yml)
 * The image tag is passed to this partial as it is updated and rendered again by the remote script
 * The partial can handle normal image uploads for files, or avatars depending on the parameters passed.
 * 
 * - $imgTag : The full html image tag that will display the current and new image
 * - $fileId or $avatarUserId depending on which type of object Is being updated. 
 * 
 * Partial must not be loaded inside <form> tags as this will create a nested form
 * and break the script. Must also be placed AFTER existing page forms or Symfony
 * messes something up with the params.
 *
 * PHP Version 5
 *
 * @author    Russ Flynn <russ@linpro.no>
 * @copyright 2008 Linpro AS
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 *
 */
use_helper('Javascript');

?>

<?php $spinning_img = isset($avatarUserId) ? 'spinning18x18.gif'  : 'spinning50x50.gif' ?>
<?php $loading_room = isset($avatarUserId) ? 'avatar_loading_room': 'upload_loading_room' ?>
<?php $route        = isset($route)        ? $route               : '@inline_upload' ?>
<?php $button_text  = isset($button_text)  ? $button_text         : __('Set new image') ?>
<?php $extra_button  = isset($extra_button)  ? $extra_button         : '' ?>
<?php $upload_id    = isset($upload_id)    ? $upload_id           : 'newimage' ?>
<?php $completeCallback    = isset($completeCallback)    ? $completeCallback           : 'completeCallback' ?>

<?php echo javascript_tag("
function startCallback() 
{
    // make something useful before submit (onStart)
    $('image_block').innerHTML = '".image_tag($spinning_img, array('id' => $loading_room))."'; 
    return true;
}

function completeCallback(response) 
{
    // make something useful after (onComplete)
    $('image_block').innerHTML = response;
    $('$upload_id').value = '';
}"); ?>

<?php echo form_tag($route, array(
  "multipart" => "true",
  "name"      => "image_upload_form",
  "onsubmit"  => "return AIM.submit(this, {'onStart' : startCallback, 'onComplete' : ".$completeCallback." })")); ?>

  <div id = "image_block">
    <?php echo $imgTag ?>
    <?php if (isset($avatarUserId)): ?>
      <div class="avatar_help"><p><?php echo __('**help-text for avatar**'); ?></p></div>
    <?php endif; ?>
  </div>
  <p>
  <div>
    <?php echo input_file_tag($upload_id); ?>
  </div>
  </p>
  <div>
  	<?php echo submit_tag($button_text, array(
  	  "id" => "newimagebutton",
  	  "onclick" => "if($('$upload_id').value=='') 
  	    { alert('".__('Please choose a file first')."');return false; }" ));
  	    echo $extra_button;
  	?>
  </div>
  
  <?php if (isset($fileId)): ?>
   <?php echo input_hidden_tag("fileId", $fileId) ?>
  <?php endif; ?>
  <?php if (isset($avatarUserId)): ?>
    <?php echo input_hidden_tag("avatarUserId", $avatarUserId) ?>
  <?php endif; ?>
  <?php echo input_hidden_tag("imgTag", $imgTag) ?>
</form>

