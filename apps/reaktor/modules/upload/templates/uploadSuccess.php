<?php
/**
 * The main file upload page, where content is added to Reaktor
 * When linking files files to existing artwork (for example in galleries) there is extra checking to ensure matching file type.
 * If the file type of the upload does not match, a special error (link_error) is returned which contains the file type
 * that was mistakenly uploaded.
 * 
 * Variables passed from the action to this template:
 * 
 *  - $artwork   : The artwork object if one has been passed for artwork linking, if set the user will see additional information
 *                 regarding the artwork linking, if not set then it will continue as a normal upload
 *
 * PHP Version 5
 *
 * @author    Russ Flynn <russ@linpro.no>
 * @author    Ole-Peter Wikene <olepw@linpro.no>
 * @copyright 2008 Linpro AS
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 *
 */

use_helper('Javascript', 'wai', 'content');
reaktor::setReaktorTitle(__('Upload content')); 
$adminWarning = "";

if ($sf_user->hasCredential("editusercontent") && isset($artwork) && $artwork->getUserId() != $sf_user->getId())
{
  $adminWarning = "return confirm('".__("You are about to upload a file and link it to an artwork on behalf of a user, ".
                                        "the user will take ownership of the file as soon as it is uploaded, are you sure?")."');";
}
$submitRoute = $sf_params->get("link_artwork_id") ? "artwork_link?link_artwork_id=".$sf_params->get("link_artwork_id") : "upload_content";

?>
<h1><?php echo __('Upload Content'); ?></h1>
<div id = "upload_wrapper">
      <?php if (!isset($artwork)): ?>
<div class="big_gray_upload" id="big_gray_upload">
1
</div>
      <?php endif; ?>
  <div id = "upload_box">
    <h1>
      <?php if (isset($artwork)): ?>
      <?php echo __("Add content to ").
              reaktor_link_to("\"".$artwork->getTitle()."\"", "@show_artwork?id=".$artwork->getId()."&title=".$artwork->getTitle()); ?>
      <?php else: ?>
        <?php echo __('Upload a file'); ?>
      <?php endif; ?>
    </h1>
    <br />
    <div>   
      <?php echo reaktor_form_tag('@'.$submitRoute, 'class=float-left id=upload_form name=upload_form multipart=true') ?>
        <?php echo form_error('file') ?>
        
        <fieldset>
        <div class="form-row">
            <?php echo wai_label_for('file', __('Add a file:'), '') ?>
            <?php echo input_file_tag('file') ?>
        </div>
        </fieldset>
        <ul style="width: 320px;">
        <li><?php echo submit_tag(__('Add'), array (
          'name'    => 'add',
          'class'   => '',
          'onclick' => $adminWarning."if($('file').value=='') { alert('".__('Please choose a file first')."');return false; } 
             else { uploadStatusShow(); 
               if ($('upload_error')) 
                 { $('upload_error').hide(); } 
               if ($('upload_right_box'))
                 { $('upload_right_box').hide(); }
               setTimeout(\"$('progressbar').src = '/images/progressbar.gif'\", 10); }",
          )) ?></li>
        </ul>
        <?php echo input_hidden_tag("link_artwork_id", $sf_params->get("link_artwork_id")); ?>
      </form>
    </div>
  </div>

  <div id = "upload_status_box" style ="position:absolute; left: -9999px;">  
      <p><h2><?php echo __("Upload in progress"); ?></h2></p>
      <p><?php echo __("This may take several minutes, please be patient") ?></p>
      <br /><?php echo image_tag("progressbar.gif", array('width' => 330, 'height' => 25, 'id' => 'progressbar')); ?>
  </div>

<script type="text/javascript">
  //<![CDATA[
  function upload_progressbar_callback() {
    $('upload_status_box').setStyle({
    display: 'none',
    position: 'static'
    });
}

setTimeout("upload_progressbar_callback()",10);
//]]>
  
  </script>


  <div id = "upload_right_box">   
  <?php if (form_has_error("link_error")): ?>
    <div id = "upload_error">
      <h2><?php echo __("You must use the same file type"); ?></h2>
      <p>
      	<?php $allowedList = ""; ?>
        <?php foreach ($artwork->getEligbleFileTypes() as $eligbleType): ?>
          <?php if ($allowedList) $allowedList .= "<span style ='font-weight:normal;'> ".__("or")." </span>"; ?>
          <?php $allowedList .= collectionType($eligbleType, false, true); ?> 
        <?php endforeach; ?>
        <?php echo __("It looks like you uploaded a file of type: <strong>%upload_type%</strong>, 
                       however this artwork requires type: <strong>%allowed_types%</strong>", 
                   array("%upload_type%" => collectionType($sf_request->getError("link_error"), false, true),
                         "%allowed_types%" => $allowedList)); ?>
      </p>
      <p>
        <?php echo __("When creating a multiple-file artwork, all files should be of the same type").".<br />"; ?>
        <?php echo __("For example, in a gallery all the files must be images")."</p>"; ?>
      <p>
        <?php echo __("Please try again, or %link_to_create%, or link this file to a different artwork later.", 
                      array("%link_to_create%" => reaktor_link_to(__("click here if you wish to create a new artwork"), "@upload_content")));  ?>
    	</p>
    </div>
  <?php elseif (form_has_error("file")): ?>
    <div id = "upload_error">
    	<h2><?php echo __("Error").": ".form_error("file", array("prefix" => "", "class"=> "", "suffix"=> "")); ?></h2>
    </div>
  <?php elseif ($sf_params->get("link_artwork_id")): ?>
  		<h2><?php echo __("Add file to artwork") ?></h2>
  		<p><?php echo __("Please upload a file of type").": <b>".collectionType($artwork, false, true)."</b>";?></p>
  		<p>
    		<?php echo __("You will be able to edit of the details of the artwork including the title 
    		               once you have finished uploading files."); ?>
    	</p>
    	<p>
    	 <?php echo reaktor_link_to(__("Click to add a file you have already uploaded"), "@link_existing_file?artworkId=".$sf_params->get("link_artwork_id")); ?>
      </p>
  <?php endif; ?>
      <?php if (!isset($artwork)): ?>
        <h2><?php echo __("Step 1: File upload") ?></h2>
        <p>
        	<?php echo __("Please upload the file you wish to add to Reaktor."); ?>
        </p>
        <p>
        	<?php echo __("Uploading and converting of files can take time, please be patient while the upload process completes."); ?>
        </p>
      <?php endif; ?>
</div>
<div style="clear: both;"></div>
<div id="upload_text_box">
      <?php if (!isset($artwork)): ?>
<div class="big_gray_upload">
<?php echo __("or"); ?>
</div>
<div style="clear: both;"></div>
<div class="upload_box_text_wrapper">
<?php if(!isset($artwork) || $artwork->isTextBased()): ?>
<div class="big_gray_upload">
2
</div>
            <?php endif; ?>                                  

        <div class="upload_box_text">
        <h1><?php echo __("Create a text artwork") ?></h1>
          <?php echo reaktor_form_tag('@new_text', array("class" => "float-left", 
                                                 "id" => "upload_form", 
                                                 "name" => "upload_form", 
                                                 "multipart" => "true")); ?>
            <?php echo submit_tag(__('Type a text artwork online'), 
                                     array ('name'    => 'add', 'class'   => 'add_file')
                                  ); ?>
            <?php if (isset($artwork)): ?>
              <?php echo input_hidden_tag("link_artwork_id", $artwork->getId()); ?>
            <?php endif; ?>                                  
          </form>
          </div>
          </fieldset>
        </p>
      
    </div>
    <div style="width:320px; float: right;">
          
        <h2><?php echo __("Or create a text artwork") ?></h2>
        <p>
          <?php echo __("If you wish to submit a poem or other text based work, please click the button below"); ?>
        </p>
    </div>
    <?php endif; ?>
</div>
</div>
