<?php
/**
 * Edit page for uploaded files and text editing
 * This is the template loaded when the user has uploaded a file, chosen to edit a file, or selected to 
 * create/edit a text artwork. This is NOT for editing artworks, however this page does have the necessary buttons
 * for creating new artworks and linking artworks.
 * 
 * Variables available to this template provided by the action:
 * 
 *  - $thisFile     : The file object that we are editing - it will always exist, either as an existing file or a new one
 *  - $successful   : This is set as true if the save was successful
 *  - $mce_data     : If set, contains the contents of the TinyMCE field (for text artworks)
 *  - $artworkArray : Contains an array of eligible artworks that this file can link to (or an empty array if none)
 *  
 *
 * PHP Version 5
 *
 * @author    Russ Flynn <russ@linpro.no>
 * @copyright 2008 Linpro AS
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 *
 */

use_helper('content', 'Javascript', 'Debug', 'wai');
reaktor::setReaktorTitle(__('Upload artwork')); 

?>

<?php log_message('Start rendering Upload edit page', 'info'); ?> 
<div>
	<div id = "thumbnail_editpage" <?php if (!$thisFile->isImage()) echo "class='leaveagap'"; ?>>
    <?php if (!$thisFile->isImage()): ?>
      <?php $videoPath = sfConfig::get('sf_root_dir')."/".sfConfig::get('app_upload_upload_dir')."/video/" ?>
      <?php if ($thisFile->getIdentifier() == 'video' && !$thisFile->getThumbpath() && file_exists($videoPath. $thisFile->getRealpath().".temp.flv")): ?>
        <?php echo __('The video is currently transcoding. A thumbnail image will be generated after transcoding.') ?>
      <?php endif; ?>
    <?php else: ?>
      <?php echo image_tag(contentPath($sf_params->get('fileId'), 'thumb')); ?>
      <?php if ($thisFile->hasStaticthumbnail()): ?>
      	<div style="padding-top: 5px;">
          <?php echo reaktor_link_to(__('Click here to change the thumbnail'), 
                      '@cropImage?fileId='.$thisFile->getId(), 
                      array("confirm" => "If you have made any changes on this page, click cancel then save your 
                                          changes before continuing")); ?>
      	</div>
      <?php endif; ?>
    <?php endif; ?>
    <br />
    <h5><?php echo __('Metadata extracted from the file') ?></h5>
    <?php $metacc = 0; ?>
 		<ul>
      <?php foreach ($thisFile->getMetadatas() as $metaElement => $aMetadata): ?>
        <?php foreach ($aMetadata as $metaKey => $metaValue): ?>
          <?php if (
                       !($metaElement == 'creator' && $metaKey == "") 
                    && $metaKey != 'creation'
                    && !($metaElement == 'description' && $metaKey == 'abstract')
                    && $metaElement != 'license'
                    && $metaElement != 'title'
                    && !($metaElement == 'relation' && $metaKey == 'references')
                    && $metaElement != 'subject'
                    && $metaElement != 'type'): ?>
            <?php echo '<li><span class="meta_label">', ucfirst($metaElement . ' - ' . $metaKey), '</span>: ', $metaValue; ?></li>
            <?php $metacc++; ?>
          <?php endif; ?>
        <?php endforeach; ?>
      <?php endforeach; ?>
      <?php if ($metacc == 0): ?>
        <li><?php echo __('This file did not contain any extractable metadata'); ?></li>
      <?php endif; ?>
    </ul>
    <?php // Will not show if no tags are required at this stage ?>
    <?php if (sfconfig::get("app_tagging_minimum_tags") || $thisFile->hasArtwork()): ?>
      <h2><?php echo __("Tags")?></h2>
      <?php include_partial("tags/tagWrapper", array("thisObject" => $thisFile, "completeFuncs" => "doSubmit();")); ?>
    <?php endif; ?>   
  </div>
  <div id = "editpage_form">
    <?php echo reaktor_form_tag('@edit_upload?fileId='.$sf_params->get('fileId'), 'name=edit_upload_form'); ?>
      <h1><?php echo __('Modify upload details')?></h1>
      <p style ="margin-top:0px;"><?php echo __('Required fields are marked with a red star'); ?></p>
      <?php if ($thisFile->hasArtwork()): ?>
      	<?php $parentArtworks = $thisFile->getParentArtworks(); ?>
      	<h2>
      		<?php $firstArtwork = array_pop($parentArtworks); ?>
      	  <?php echo __('Part of %link_to_artwork_with_title% artwork [ %link_to_edit% ]', 
      	                array('%link_to_artwork_with_title%' => reaktor_link_to($firstArtwork->getTitle(), 
    	                        '@show_artwork_file?id='.$firstArtwork->getId().'&file='.$thisFile->getId().'&title='.$firstArtwork->getTitle()), 
    	                        '%link_to_edit%' => reaktor_link_to(__('edit'), 
    	                        '@edit_artwork?id='.$firstArtwork->getId()))); ?>
    	  
    	 	<?php if (!empty($parentArtworks)): ?>
    	 		<span style ="font-size:0.8em">
    	 		  <?php echo link_to_function(__("more").image_tag("arrow_down.png", array("height" => 12)), "$('all_artworks').toggle();"); ?>
    	 		</span>
    	 		</h2>
    	 		<div style="display:none;" id="all_artworks">	
    	 			<?php foreach ($parentArtworks as $parentArtwork): ?>
    	 				<h2>
      	 			  <?php echo __('Part of %link_to_artwork_with_title% artwork [ %link_to_edit% ]', 
        	                array('%link_to_artwork_with_title%' => reaktor_link_to($parentArtwork->getTitle(), 
      	                        '@show_artwork_file?id='.$parentArtwork->getId().'&file='.$thisFile->getId().'&title='.$parentArtwork->getTitle()), 
      	                        '%link_to_edit%' => reaktor_link_to(__('edit'), 
      	                        '@edit_artwork?id='.$parentArtwork->getId()))); ?>
    	        </h2>
    	 			<?php endforeach; ?>
    	 		</div>
    	 	<?php else: ?>
    	 		</h2>
    	 	<?php endif; ?>
      <?php endif; ?>
      <?php if ($sf_request->hasErrors()): ?>
        <p id = 'errormsg'><?php echo image_tag('cancel.png')." ".__('The data was not saved!'); ?></p>
      	<p id = 'errormsg'><?php echo __('Please correct the errors below'); ?></p>
      <?php elseif (isset($successful)): ?>
        <p id = 'errormsg'><?php echo image_tag('accept.png')." ".__('Save successful'); ?></p>
      <?php endif; ?>
      <dl>
        <dt>
          <?php echo wai_label_for('title', __('Enter a title for this upload:')); ?><span class="required_star">*</span>
        </dt>
        <dd>
          <?php echo form_error('title'); ?>
          <?php echo input_tag('title', $thisFile->getMetadata('title'), array("class"=>"mediuminput", "maxlength"=>40)); ?>
        </dd>
        <dt>
          <?php echo wai_label_for('author', __('Enter the author/creator of this piece:')); ?><span class="required_star">*</span>
        </dt>
        <dd>
          <?php echo form_error('author'); ?>
          <?php echo input_tag('author', $thisFile->getMetadata('creator'), array("class"=>"mediuminput", "maxlength"=>40)); ?>
        </dd>
  
        <?php if ($thisFile->getIdentifier() == "text"): ?>
  	      <dt>
  		      <dd>
  		        <?php echo form_error('mce_data'); ?>
  		        <?php if (isset($mce_data)): ?>
  		          <?php include_partial('tinymce', array('mce_data' => $mce_data)); ?>
  		        <?php else: ?>
  		          <?php include_partial('tinymce'); ?>
  		        <?php endif ?>
  		      </dd>
  	      </dt>
        <?php else: ?>
          <dt>
            <?php echo wai_label_for('description', __('Enter a description for this piece:')); ?><span class="required_star">*</span>
          </dt>
          <dd>
            <?php echo form_error('description'); ?>
            <?php echo textarea_tag('description', $thisFile->getMetadata('description', 'abstract'), "size=40x8"); ?>
          </dd>
          <dt>
            <?php echo wai_label_for('production', __('Please describe the method of production:')); ?>
          </dt>
          <dd>
            <?php echo form_error('production'); ?>
            <?php echo textarea_tag('production', $thisFile->getMetadata('description', 'creation'), "size=40x8"); ?>
          </dd>
        <?php endif ?>
        <dt>
          <?php echo wai_label_for('resources', __('Add hyperlinks (one per line) related to this upload:')); ?>
        </dt>
        <dd>
          <?php echo form_error('resources'); ?>
          <?php echo textarea_tag('resources', $thisFile->getMetadata('relation', 'references'), "size=40x8"); ?>
        </dd>
        <dt>
        	<b><?php echo wai_label_for('meta_license', __('License')); ?></b><span class="required_star">*</span>
        </dt>
        <dd>
          <?php if (in_array($thisFile->getLicense(), array('no_allow', 'contact', 'free_use', 'non_commercial', ''))): ?>
            <?php //echo __('Nye Reaktor benytter Creative Commons-lisenser for alle verk. %linjeskift%For å bedre verne om dine opphavsrettigheter, vennligst velg en CC lisens.', array('%linjeskift%' => '<br />')) . '<br />'; ?>
            <?php echo __('The new Reaktor uses Creative Common lisences for all artworks') . '.<br />'; ?>
            <?php echo "<a href=".__('http://www.creativecommons.no/info/omcc.shtml#ltyper') ." target='_new'>".__('Read more about the different licenses')."</a>" ?>
            <?php echo __('and pick the one that suits you'); ?>.
          <?php endif; ?>
          <?php echo form_error('meta_license'); ?>
          <?php echo select_tag('meta_license', options_for_select(array(
                      '' => __('--- please select a license ---'),
                      'by' => 'CC: Navngivelse (by)',
                      'by-sa' => 'CC: Navngivelse - Del på samme vilkår (by-sa)',
                      'by-nd' => 'CC: Navngivelse - Ingen bearbeidelse (by-nd)',
                      'by-nc' => 'CC: Navngivelse - Ikke-kommersiell (by-nc)',
                      'by-nc-sa' => 'CC: Navngivelse ‑ Ikke‑kommersiell ‑ Del på samme vilkår (by‑nc‑sa)',
                      'by-nc-nd' => 'CC: Navngivelse ‑ Ikke‑kommersiell ‑ Ingen Bearbeidelse (by‑nc‑nd)'),
                      /*'free_use' => 'Allow free use for other users',
                      'contact' => 'Contact me for further use',
                      'no_allow' => 'Do not allow any non-private use'),*/
                      $thisFile->getMetadata('license'))); ?>
          <?php //echo link_to(__('Read more about Creative Commons\' licenses'), 'http://creativecommons.org/about/license/', 'target="_new"'); ?>
        </dd>
          <dd>
          <?php #NOTE: The link should be "translated", for the english version: http://creativecommons.org/about/license/ ?>
          <?php //echo link_to(__('Read more about Creative Commons\' licenses'), __('http://www.creativecommons.no/info/omcc.shtml#ltyper'), 'target="_new"'); ?>
        </dd>
      </dl>
      <?php if (count($artworkArray) > 1 && is_numeric($sf_params->get("link"))): // The first item is the default value set in the action?>	
      <?php include_partial("saveAndAttach", array("artworkArray" => $artworkArray)); ?>
      <?php endif; ?>
      <?php if (!$thisFile->hasArtwork()): ?>
      	<div id = "new_file_save" class ="status_approved">
        	<h2 style = "float:left;"><?php echo __("Save and create new artwork"); ?></h2>
        	<p class = "artwork_select">
        	  <?php echo submit_tag(__('Save as new artwork'), array("name" => "new_artwork", "class" => "status_approve")); ?>
        	</p>
        	<p style = "width: 100%;text-align: right;">
        	  <?php $helpText =  __("If you are creating a collection (for example a gallery)")."<br />"; ?>
        	  <?php $helpText .= __("check this box to upload another file and link it to this artwork"); ?>
        	  <?php echo __("Upload another file: "); ?>
        		<input type = "checkbox" name = "upload_another">
        		<br />
        	  <?php echo link_to_function(__("what's this?"), "javascript:void(0)", 
        	                    array("onMouseover" => "Tip('".$helpText."');",
        	                          "onMouseOut" => "UnTip();")); ?>
        	</p>
      	</div>
      <?php endif; ?>
      <?php if (!$thisFile->hasArtwork()): ?>
      	<div id = "save_file_draft" class="status_draft">
        	<h2 class = "floatleft"><?php echo __("Save but do not submit yet"); ?></h2>
        	<p class = "artwork_select" id="savedraftbutton">
            <?php echo submit_tag(__('Save as draft'), array("name" => "save_draft", "class" => "status_draft")); ?>
        	  <?php if ($sf_user->hasCredential("deletecontent")): ?>
        	    <?php //echo reaktor_button_to(__("Delete this file"), "@delete_file?fileId=".$thisFile->getId(), array("method"=> "post", "class" => "cancel", "confirm" => __("The file will be completely removed, are you sure?"))); ?>
        	  <?php endif; ?>
        	</p>
     		</div>
      <?php else: ?>
      	<div id = "save_file_edit" class ="status_draft">
        	<h2><?php echo __("Submit changes"); ?></h2>
          <?php echo __("Apply changes to file details").","?> 
          <br />
          <p class = "artwork_select">
            <?php echo submit_tag(__('Save changes'), array("name" => "save_edit",  "class" => "status_draft")); ?>
            <?php echo reaktor_button_to(__("Cancel"), "@my_content?mode=allfiles", array("class" => "", "confirm" => __("All changes will be lost, are you sure?"))); ?>
            <?php if ($sf_user->hasCredential("deletecontent")): ?> 
              <?php  echo reaktor_button_to(__("Delete this file"), "@delete_file?fileId=".$thisFile->getId(), array("method"=> "post", "class" => "cancel", "confirm" => __("The file will be completely removed, are you sure?"))); ?>
            <?php endif; ?>
          </p>
        </div>
      <?php endif; ?>
      <?php if (count($artworkArray) > 1 && !is_numeric($sf_params->get("link"))): // The first item is the default value set in the action?>
        <?php 
        if(!$thisFile->isUnsuitable())
            include_partial("saveAndAttach", array("artworkArray" => $artworkArray));
         ?> 
      <?php endif; ?>
      <?php if ($sf_params->get("link")): ?>
        <?php echo input_hidden_tag("link", $sf_params->get("link")); ?>
      <?php endif; ?>
    </form>
  </div>
  <?php if (!$thisFile->isImage()): ?>
    <div id ="inline_upload">
    	<?php // Because of the nature of this, it is best last on the page (at least after other forms ?>
      <h2><?php echo __("Thumbnail image")?>:</h2>
    	<?php echo include_partial('inlineUpload', array("fileId" => $thisFile->getId(), "imgTag" => image_tag(contentPath($sf_params->get('fileId'), 'thumb', false, true)))); ?>
    </div>
  <?php endif; ?>
</div>
