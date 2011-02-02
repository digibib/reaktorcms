<?php
/**
 * Artworks are what the Reaktor site is all about, and this template is one of the most important 
 * relating to artworks - it is the template to edit an artwork. 
 * 
 * Once a file is submitted, the user/admin user gets a streamlined view of the artwork page
 * with the necessary fields for editing their artwork, assigning categories, etc.
 * 
 * The controller passes the following information:
 * $artwork     - A genericArtwork object
 * $firstfile   - Artworks with more than one file can decide which file to be displayed on the artwork page
 * $objectToTag - Which object to tag, either a file or an artwork 
 *  
 * PHP version 5
 * 
 * @author    Russ Flynn <russ@linpro.no>
 * @author    Daniel Andre Eikeland <dae@linpro.no>
 * @author    June Henriksen <juneih@linpro.no>
 * @copyright 2008 Linpro AS
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 */

use_helper('content', 'Javascript', 'Object'); 
reaktor::setReaktorTitle(__('Artwork edit')); 

include_partial('submit_box',array('artwork' => $artwork));
  ?>
<?php if ($sf_request->hasErrors()): ?>
  <p><b><?php echo image_tag('cancel.png')." ".__('The artwork was not submitted!'); ?>&nbsp;<?php echo __('Please correct the errors below'); ?>.</b></p>
<?php endif; ?>
<div id="artwork_main_container" class = "short_top_margin">
    <h2>
      <?php echo __('Editing: %artwork_title%', array('%artwork_title%' => $artwork->getTitle())) ?>
    </h2>
    <?php echo form_remote_tag(array('url' => '@artworkupdatefield?id='.$artwork->getId().'&field=title',
                                     'update' => 'title_message',
                                     'loading'  => "$('title_waiting').show();",
                                     'success' => "$('title_message').show();$('title_waiting').hide();",
    )); ?>
    <span id="title_waiting" style="display: none;">&nbsp;<?php echo image_tag("spinning18x18.gif") ?></span>&nbsp;<span id="title_message" style="display: none;"> </span>
    <br />
    <?php echo input_tag('value', $artwork->getTitle(), array('id' => 'title_value')); ?>
    <?php echo submit_tag(__('Update title'), array('style' => 'margin: 0px; margin-bottom: 5px;')); ?>
    <br class="clearboth" />
    <?php echo __("Note: Title must be between %min% and %max% characters (numbers, letters, spaces and dashes allowed).", array(
                   "%min%" => sfConfig::get("app_artwork_min_title_length"), 
                   "%max%" => sfConfig::get("app_artwork_max_title_length"),
                   ' (' => '<br />(')); ?>
    <br class="clearboth" />
    <br class="clearboth" />
    <?php echo '</form>'; ?>
    <?php if (!$artwork->isMultiUser()): //Print username only if artwork has single author/owner?>
  
      <?php // Show the username, not fullname, see ticket#476
	  	$displayname = $artwork->getUser()->getUsername();
        
      echo __('Author: %username%', array(
        '%username%' => '<b>'.reaktor_link_to($displayname, '@portfolio?user='.$artwork->getUser()->getUsername()).'</b>'
      ))?>
    <?php endif ?>  
    
    <b>&nbsp;[<?php echo reaktor_link_to(__('View mode'),$artwork->getLink('show', null, false, true)); ?>]</b><br />
  <div id="artwork_div">
	  <?php if ($artwork->getArtworkType() == "text"): ?>
      <br />
      <?php echo __('To edit the text in the artwork, click the corresponding file below') ?>
      <br />
	  <?php else: ?>
	    <?php include_partial('artworkDisplay', array('artwork' => $artwork, 'thefile' => $artwork->getFirstFile())) ?>
      <div style="padding-top: 5px;">
	      <?php if ($artwork->getArtworkType() != "image"): ?>
	        <?php echo reaktor_link_to(__('Change the thumbnail displayed on the frontpage'), "@edit_upload?fileId=".$firstfile->getId()); ?>
	      <?php elseif ($firstfile->hasStaticThumbnail()): ?>
	        <?php echo reaktor_link_to(__('Change the thumbnail displayed on the frontpage'), "@cropImage?fileId=".$firstfile->getId()); ?>
	      <?php endif; ?>
      </div>
	  <?php endif; ?>
  </div>
  
  <?php  if ($artwork->getFilesCount() > 1): ?>
      <h2><?php echo __("Artwork description"); ?></h2>
      <?php echo form_remote_tag(array('url' => '@artworkupdatefield?id='.$artwork->getId().'&field=description',
                                       'update' => 'description_message',
                                       'loading'  => "$('description_waiting').show();",
                                       'success' => "$('description_message').show();$('description_waiting').hide();",
      )); ?>
      <span id="description_waiting" style="display: none;">&nbsp;<?php echo image_tag("spinning18x18.gif") ?></span>&nbsp;<span id="description_message" style="display: none;"> </span>
      <br />
      <?php echo textarea_tag('value', $artwork->getDescription(), array('id' => 'description_value', 'style' => 'width: 520px;')); ?><br />
      <?php echo submit_tag(__('Update description'), array('style' => 'margin: 0px; margin-bottom: 5px; float: right;')); ?>
      <br class="clearboth" />
      <?php echo '</form>'; ?>
  <?php endif; ?>
  
  <div id = "filelist">
    <?php include_partial('artwork/draganddroplist', array('artwork' => $artwork)) ?>
  </div>
  
  <br />
  <?php if ($artwork->getUser()->getArtworkCount() > 1): ?>
    <h3><?php echo __("Other artworks related to this one"); ?></h3>
    <?php echo __('Remember, you can relate to artworks that have not been approved yet.') ?>
    <div id='relate_artwork_see_also'>
      <?php include_component('artwork', 'linkRelated', array('artwork' => $artwork, 'usercanedit' => true, 'editmode' => true)); ?>
    </div>
  <?php endif; ?>
  
</div>


<div id="artwork_right_container" class = "short_top_margin">
  <div id = "categorySelect">
    <?php include_component("artwork", "categorySelect", array("artwork" => $artwork)); ?>
  </div>
  <br />
  <h2><?php echo __("Artwork tags")?></h2>
  <?php $completeFuncs = $objectToTag instanceof artworkFile ? "updateFileList(".$artwork->getId().");" : ""; ?>
  <?php include_partial("tags/tagWrapper", array("thisObject" => $objectToTag, "artworkList" => $artwork->getId(), "completeFuncs" => $completeFuncs)); ?>
  <?php if ($sf_user->hasCredential('staff')): ?>
    <div class='moderator_block'>
      <?php include_partial('moderatorlinks', array(
        'artwork' => $artwork)) ?>

      <?php include_component('artwork', 'editorialTeamArtwork' , array(
        'artwork' => $artwork)) ?>
      <?php if($artwork->isApproved()): ?>
        <?php include_component('artwork', 'recommendArtwork' , array(
          'artwork' => $artwork)) ?>
      <?php endif ?>
    </div>
  <?php endif; ?>
  
</div>
<div class="clearboth">
<?php include_partial('submit_box',array('artwork' => $artwork)); ?>
</div>

