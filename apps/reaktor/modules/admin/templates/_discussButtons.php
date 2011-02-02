<?php
/**
 * Many of the administration tasks have a list as a starting point, some of them look quite similar with only 
 * the buttons differing from list to list. This template displays buttons related to disussing artwork and files.
 *  
 * Example on usage:
 * include_partial($buttonPartial, array('object' => $artwork))
 * 
 * The paramenters sent are:
 * - $object     : a genericArtwork or a ReaktorFile
 * - $type       : file or artwork
 * - $update_div : the div that should be updated when a button has carried out its action
 * 
 * PHP Version 5
 *
 * @author    Russ <russ@linpro.no>
 * @author    June Henriksen <juneih@linpro.no>
 * @copyright 2008 Linpro AS
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 *
 */
?>
<div class='artwork_list_links'>

  <?php $url = ($type == 'artwork') ? 
                 '@artwork_mark_discussion?id='.$object->getId().'&status=0' : 
                 '@file_mark_discussion?id='.$object->getId().'&status=0' //url to stop discussion?>
                 
  <?php if($sf_params->get('action') == 'listDiscussion'): //View discussion button only in list view?>
    <?php echo button_to(__('View discussion (').$object->getCommentCount('administrator').')', 
                            '@show_discussion?type='.$type.'&id='.$object->getId()); ?>
  <?php endif ?>                         
                     
  <?php if ($sf_user->hasCredential('discussartwork')): //Has proper credentials?>
                                             
    <?php if($sf_params->get('action') == 'listDiscussion'): //List view?>                                             
      <?php echo button_to_remote(__('Stop discussion'), array(   
        'url'         => $url,
        'complete'    => "Effect.BlindUp('".$update_div."');",
        'confirm'     => __('Remove marked for discussion flag'),
        ), array('id' => 'discussion_button_'.$type.'_'.$object->getId())) ?>
    <?php elseif ($sf_params->get('action') == 'discuss' && $object->isUnderDiscussion()): //Discussion view?>
         <?php echo button_to(__('Stop discussion'), $url) ?>
    <?php endif ?>
                
  <?php endif ?>
  
    <?php $link = ($type == 'artwork') ? $object->getLink() : $object->getParentArtwork()->getLink('show', $object->getId()); ?>
    <?php echo link_to('<input type="button" value="' . __('Show') . '" />', $link, array(
      'class'  => "lightwindow page-options", 
      "closetext" => __("close"),
      'params' => "lightwindow_width=980,lightwindow_height=800,lightwindow_type=external", 
      'title'  => 'Showing artwork')) ?>
</div>