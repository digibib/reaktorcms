<?php 
/**
 * In most the artwork administration lists you can perform actions on each of the
 * artworks. This admin buttons are not always the same, for instance you do not need to reject artworks
 * that are already rejected.  This template prints out the respective buttons for one artwork. 
 * 
 * Ex.:include_partial("artwork/adminButtons", array('artwork' => $artwork))
 * 
 * The parameters passed are:
 * $artwork - A reaktorArtwork object
 *  
 * PHP Version 5
 *
 * @author    June Henriksen <juneih@linpro.no>
 * @copyright 2008 Linpro AS
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 *
 */

use_helper("Javascript", "button");

$this_id = $object->getId();

?>
<div class='artwork_list_links adminbuttons' id="admin_buttons_<?php echo $this_id ?>" >
  <?php //echo reaktor_button_to(__('Show'), '@show_artwork?id=' . $art->getId() . '&title=' . $art->getTitle()) ?>
  <?php //replace the line below with the line above if you want the old show-button back ?>
  <?php if ($type == 'artwork'): ?>
    <?php echo fake_button(__('Show'), $object->getLink("edit_nodecor"), array(
      'class'  => "lightwindow page-options", 
      "closetext" => __("close"),
      'params' => "lightwindow_width=770,lightwindow_height=800,lightwindow_type=external", 
      'title'  => 'Showing artwork')) ?>
	  <?php if ($sf_user->hasCredential('approveartwork')): ?>
      
	  <?php // if ($object->getStatus() != 3):  //Artwork is not approved?>
      <?php //endif; ?>
      <?php if ($object->getStatus() == 3 && $object->getModifiedDate()): //Artwork is approved and modified?>
        <?php echo fake_button(__("Approve changes"), array(   
            'complete'=> "Effect.BlindUp('artwork_list_container_".$this_id."');",
            'url' => '@accept_artwork_modifications?id='.$this_id,
            'confirm' => __("Approve the changes made to this artwork?"),
            ), array("id" => "approve_artwork_modifications_button_".$this_id))?>
      <?php endif; ?>
	    <?php if ($sf_user->hasCredential('discussartwork')): ?>
        <?php $discussions = $object->getCommentCount('administrator'); ?>
		    <?php if (!$object->isUnderDiscussion()): ?>
		      <?php echo fake_button(__("Start discussion"), array(   
			        'complete'=> "window.location = '".reaktor_url_for('@show_discussion?id='.$this_id.'&type=artwork')."'",
			        'url' => '@artwork_mark_discussion?id='.$this_id.'&status=1',
			        'confirm' => __("Mark this artwork for discussion?"),
			        ), array("id" => "discussion_button_".$this_id))?>
          <?php if ($discussions > 0): ?>
            <?php echo fake_button(__('View archived discussion (').$object->getCommentCount('administrator').')', '@show_discussion?type=artwork&id=' . $this_id, array('class' => "lightwindow page-options","closetext" => __("close"), 'params' => "lightwindow_width=980,lightwindow_height=800,lightwindow_type=external", 'title' => __('View archived discussion'))) ?>
          <?php endif; ?>
        <?php else: ?>
          <?php echo fake_button(__('View discussion ('.$object->getCommentCount('administrator').')'), '@show_discussion?type=artwork&id=' . $this_id, array('class' => "lightwindow page-options","closetext" => __("close") , 'params' => "lightwindow_width=980,lightwindow_height=800,lightwindow_type=external", 'title' => __('View discussion'))) ?>
        <?php endif; ?>
      <?php endif; ?>        
      <?php if ($object->getStatus() != 4): ?>
	      <?php //echo fake_button(__('Reject'), '@rejectartwork?id='.$this_id) ?>
      <?php else: ?>
        <?php echo fake_button_function(__('Show rejection message'), "$('rejectionmsg_".$this_id."').toggle()"); ?>
      <?php endif; ?> 
      <div class="fakebutton"><?php echo link_to_function(__("Done"), "Effect.BlindUp('artwork_list_container_".$this_id."');", array("id" => "done_button_".$this_id)); ?></div>
	  <?php endif ?>
  <?php endif; ?>
  
  <?php if ($type == 'file'): //Files?>
	  <?php if ($object->isReported()||$object->isUnsuitable()): ?>

  <?php echo fake_button(__('Show'), '@content_server?id='.$object->getId().'&filename='.$object->getFilename(), array(
      'class'  => "lightwindow page-options",
      "closetext" => __("close"),
      'params' => "lightwindow_width=870,lightwindow_height=800,lightwindow_type=external",
      "author" => $object->getUser()->getUsername().' ',
      "caption" => $object->getMetadata('description', 'abstract').' ',
      "title"=>$object->getTitle().' ',
      "helptext"   => ' ',
      "author_by_text" => __("by"),

)) ?>



<?php if(!empty($showRejectionMsg)): ?>
        <?php echo fake_button_function(__('Show rejection message'), "$('".$showRejectionMsg."').toggle()"); ?>
      <?php  endif; ?>
 



	    <?php echo fake_button(__("Flag as ok"), array(   
	            'url' => '@flag_ok_file?id='.$this_id,
	            'complete'=> "Effect.BlindUp('artwork_list_container_".$this_id."');",
	            'confirm' => __("Flag this file as OK?"),
	          ), array("id" => "flag_ok_button_".$this_id)); ?>   
	    <?php if (!$object->isUnsuitable()): ?>
	      <?php echo fake_button(__("Remove from artwork(s)"), '@removefilemessage?id='.$this_id); ?>
	    <?php endif ?>
      <?php if (count($object->getParentArtworks()) == 1): ?>
        <?php  if ($object->isUnderDiscussion() && $sf_user->hasCredential('discussartwork')): ?>
          <?php echo fake_button(__('Continue discussion'), '@show_discussion?id='.$this_id.'&type=file'); ?>
        <?php elseif ($sf_user->hasCredential('discussartwork')): ?>
          <?php echo fake_button(__("Start discussion"), array(   
            'complete'=> "window.location = '".reaktor_url_for('@show_discussion?id='.$this_id.'&type=file')."'",
            'url' => '@file_mark_discussion?id='.$this_id.'&status=1',
            'confirm' => __("Mark this file for discussion?"),
            ), array("id" => "discussion_button_".$this_id))?>
        <?php endif; ?>  
      <?php endif; ?>
	  <?php endif ?>
  <?php endif; ?>
</div>

