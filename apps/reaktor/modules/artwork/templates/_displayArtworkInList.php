<?php
/**
 * Many of the administration tasks have a list as a starting point, some of them look quite similar with only 
 * the buttons differing from list to list.
 
 * This is a partial to display an artwork in an admin list, which buttons to display is passed as a parameter.
 * 
 * Example on how to use it:
 *  include_partial('artwork','displayArtworkInList', array(
 *   'artwork'       => $artwork,
 *   'buttonPartial' => 'admin/discussButtons'))
 * 
 * The possible buttonPartials are 
 *  - admin/discussButtons
 *  - artwork/adminButtons
 *  
 * 
 * PHP version 5
 *
 * @author    juneih <juneih@linpro.no>
 * @author    Daniel Andre Eikeland <dae@linpro.no>
 * @copyright 2008 Linpro
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 */

use_helper('content') 
?>

<div class='artwork_list_image'>
  <?php echo image_tag(contentPath($artwork->getFirstFile(), 'mini'), array(
    'title'  => $artwork->getTitle(), 
    'alt'    => $artwork->getTitle(), 
    'height' => 65, 
    'width'  => 78,
  )); ?>
</div>
<div class = 'artwork_list_info'>
  <h4 class='artwork_list_header'>
    <?php echo __('%artwork_title% by %user%', array(
      '%artwork_title%' => link_to($artwork->getTitle(), $artwork->getLink()), 
      '%user%'          => link_to($artwork->getUser()->getUsername(), '@portfolio?user='.$artwork->getUser()->getUsername())
    )); ?>
    <?php if (isset($show_recommended_at) && $show_recommended_at): ?>
      <?php echo __('at %date%', array("%date%" => $show_recommended_at)); ?>
    <?php endif; ?>
    <?php echo " [".reaktor_link_to(__("edit"), "@edit_artwork?id=".$artwork->getId())." ]"; ?>
    <?php if (!$artwork->isTranscoded()): ?>
      <span class = "message">*<?php echo __("This artwork is still transcoding"); ?>*</span>
    <?php endif; ?>
  </h4>
  <ul style = "margin:0px;">  
    <li>
    	<?php include_partial("artwork/statusRow", array("artwork" => $artwork)); ?>
    </li>
    <?php if ($artwork->getStatus() == 2): //Assigned to editorial team ?>
       <li><?php echo __('Awaiting approval by %editorial_team%', array(
      '%editorial_team%' => $artwork->getEditorialTeam()->getDescription(),
      )); ?></li>
    <?php endif ?>
    <?php if ($artwork->isUnderDiscussion()): ?>
      <li><?php echo __('Artwork marked for discussion by %user_name% on %date% at %time%', array(
        '%user_name%'   => $artwork->getDiscussionInfo()->getsfGuardUser()->getNameOrUsername(), 
        '%date%' =>  date('d/m/Y', strtotime($artwork->getDiscussionInfo()->getCreatedAt())),
        '%time%' =>  date('H.i',   strtotime($artwork->getDiscussionInfo()->getCreatedAt()))
        )); ?></li>
    <?php endif; ?>
    <?php if ($artwork->getModifiedDate()): ?>
    	<li><?php echo __('Artwork modified by user on %date% at %time%', array(
                        '%date%' =>  date('d/m/Y', strtotime($artwork->getModifiedDate())),
                        '%time%' =>  date('H.i', strtotime($artwork->getModifiedDate()))
        )); ?>
	<?php if(!(isset($showDetails) && $showDetails)): ?>
      	<?php echo " [ ".link_to_function(__("show/hide details"), "$('modified_details_".$artwork->getId()."').toggle();")." ]"; ?>
        <?php endif ?>

      	<div class ="message_box" id="modified_details_<?php echo $artwork->getId(); ?>" <?php if(!(isset($showDetails) && $showDetails)) echo 'style="display:none"'; ?>  >

      		<h2><?php echo __("Modification log"); ?></h2>
      		<p><?php echo nl2br($artwork->getModifiedNote()); ?></p>
      	</div>  
      </li>
    <?php endif; ?>
    <li><?php include_component("tags", "viewTagsWithStatus", array("artwork" => $artwork)); ?></li>
    <?php if ($artwork->getFilesCount() > 1): //Artwork with more than one file?>
      <li><?php echo __('This artwork contains %number_of_files% files', array(
        '%number_of_files%' => $artwork->getFilesCount()
      )); ?></li> 
    <?php endif; ?>
    <li id="rejectionmsg_<?php echo $artwork->getId(); ?>" style="display: none;"> 
      <?php echo $artwork->getRejectionMsg(); ?>
    </li>
	</ul>  
</div>

<?php if (isset($buttonPartial)): //Add buttons to list row?>
	<div class ="clear_both">
    <?php $update_div = isset($update_div) ? $update_div : '' ?>
    <?php include_partial($buttonPartial, array(
      'object'     => $artwork, 
      "type"       => "artwork", 
      "update_div" => $update_div,
    )); ?>
  </div>
<?php endif; ?>
