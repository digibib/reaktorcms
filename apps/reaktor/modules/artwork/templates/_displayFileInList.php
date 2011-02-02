<?php
/**
 * Many of the administration tasks have a list of files as a starting point, some of them look quite similar with only 
 * the buttons differing from list to list.
 
 * This is a partial to display a file in an admin list, which buttons to display is passed as a parameter.
 * 
 * Example on how to use it:
 *  include_partial('artwork','displayArtworkInList', array(
 *   'file'       => $file,
 *   'buttonPartial' => 'admin/discussButtons'))
 * 
 * The possible buttonPartials are 
 *  - admin/discussButtons
 * 
 * PHP version 5
 *
 * @author    juneih <juneih@linpro.no>
 * @copyright 2008 Linpro
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 */
 ?>
<?php use_helper('content') ?>

<div class='artwork_list_image'>
  <a href="<?php echo contentPath($file) ?>" 
    class="lightwindow" 
    author="<?php echo $file->getUser()->getUsername() ?>" 
    helptext = " "
    closetext="<?php echo __("close") ?>"
    author_by_text="<?php echo __('by')?>"
    caption="<?php echo $file->getMetadata('description', 'abstract') ?>" title="<?php echo $file->getTitle() ?>">
    <?php echo image_tag(contentPath($file, 'mini'), array(
      'height' => 65, 
      'width'  => 78
    )) ?>
  </a>
</div>
<div class = 'artwork_list_info'>
 
    <?php if (count($file->getParentArtworks()) > 0): //File belongs to one or more artwork ?>    
      <h4 class='artwork_list_header'>
  	    <?php echo __('%file_title% by %user%', array(
  	      '%file_title%' => reaktor_link_to($file->getTitle(), '@show_artwork_file?id='.$file->getParentArtwork()->getId().
                                           '&file='.$file->getId().'&title='.$file->getParentArtwork()->getTitle()), 
  	      '%user%'       => reaktor_link_to($file->getUser()->getUsername(), '@portfolio?user='.$file->getUser()->getUsername())
  	    )) ?>
  	  </h4>
  	  <?php echo __('File uploaded by %user_name% at %date%', array(
        '%user_name%'   => $file->getUser()->getUsername(),
        '%date%'        => $file->getUploadedAt()
      ))?><br />  	  
  	  <?php echo __('This file is a part of').': ' ?>
      <?php $artworklinks = array() ?>
      <?php foreach ($file->getParentArtworks() as $anArtwork): ?>
        <?php $artworklinks[] = link_to($anArtwork->getTitle(), $anArtwork->getLink()) ?>
      <?php endforeach; ?>
      <?php echo join(', ', $artworklinks); ?>
      
    <?php else: //File does not have parent artwork?>    
      <h4 class='artwork_list_header'>
        <?php echo __('%file_title% by %user%', 
             array('%file_title%' => reaktor_link_to($file->getTitle(), 
                                                     '@edit_upload?fileId='.$file->getId()),
                   '%user%' => reaktor_link_to($file->getUser()->getUsername(), '@portfolio?user='.$file->getUser()->getUsername()))); ?>
      </h4> 
      <?php echo __('This file is not part of any artworks') ?>                 
    <?php endif; ?>
    <?php include_partial('artwork/reportunsuitable', array('thefile' => $file)); ?>
    <?php if($file->isUnderDiscussion()): ?>
      <br />
      <?php if($file->getDiscussionInfo()): ?>
         <?php $info     = $file->getDiscussionInfo() ?>
         <?php $username = $info->getsfGuardUser()->getName() ?>
         <?php $date     = date('d.m.y', strtotime($file->getDiscussionInfo()->getCreatedAt())).', '.
                           date('H.i',   strtotime($file->getDiscussionInfo()->getCreatedAt())) ?>
      <?php else: ?>
        <?php $username  = __('Unknown') ?>
        <?php $date      = __('Unknown') ?>
      <?php endif ?>                           
      <?php echo __('File marked for disccusion by %user_name% at %date%', array(
        '%user_name%'   => $username,
        '%date%'        => $date
      ))?>
    <?php endif ?>
  
  <br />
</div>

<?php if (isset($buttonPartial)): //Add buttons to list row?>
  <?php $update_div = isset($update_div) ? $update_div : '' ?>
  <?php include_partial($buttonPartial, array(
    'object'     => $file, 
    "type"       => "file", 
    "update_div" => $update_div,
  )) ?>
<?php endif; ?>