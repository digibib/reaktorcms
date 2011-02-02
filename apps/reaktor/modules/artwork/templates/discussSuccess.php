<?php
/**
 * Before an artwork is displayed on the Reaktor site, it has to be evaluated by a staff member, 
 * who either approves or rejects the artwork. In order to help with this decision making the 
 * staff has the opportunity to invite other members to discuss the artwork. 
 * 
 * This template displays an artwork's discussion so far, and a form to add comments to the discussion.
 * 
 * The controller passes the following information:
 * $type - The object type of object discussed 
 * $object - The object dicussed, either a genericArtwork or a ReaktorFile
 *  
 * PHP version 5
 * 
 * @author    June Henriksen <juneih@linpro.no> 
 * @copyright 2008 Linpro AS
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 */

use_helper('Javascript');
reaktor::setReaktorTitle(__('Artwork discussion'));

?>
<br />
<ul class= 'inline'> 
  <li class='mediumrightpad'><?php echo link_to(__('<< Discussion list'), '@listdiscussion') ?></li> 
  <li class='mediumrightpad'><?php echo link_to(__('<< Unapproved list'), '@unapproved_listmyteams') ?></li>
  <li class='mediumrightpad'><?php echo link_to(__('<< Unapproved list (other teams)'), '@unapproved_listotherteams') ?></li>
</ul>

<div class='clear_both'>&nbsp;</div>

<?php if ($type == "artwork"): //Print titles ?>
  <h1><?php echo __('Discuss artwork'); ?></h1>
<?php else:?>
  <h1><?php echo __('Discuss artwork file'); ?></h1>
<?php endif; ?>

<div id='artwork_list_container' class="artwork_list">
  <?php if ($type == "artwork"):  //Display thumbnail, info, and buttons ?>
    <?php include_partial('displayArtworkInList', array(
      'artwork'       => $object, 
      'buttonPartial' => 'admin/discussButtons'
    )) ?>
  <?php elseif ($type == "file"): ?>
    <?php include_partial('displayFileInList', array(
      'file'          => $object, 
      'buttonPartial' => 'admin/discussButtons')); ?>
  <?php endif ?>
</div>

<div>
  <h1><?php echo __("Comments in this discussion") ?></h1>
  <p><?php echo __('As a member of editorial staff, you can discuss this artwork. Do you see any reasons why it should or should not be approved?'); ?></p>
  <p>&nbsp;</p>
</div>
<div id="all_sf_comments_list">
  <?php include_partial('artwork/displayComments', array(
    'object'    => $object->getBaseObject(), 
    'namespace' => 'administrator',
    'adminlist' => true))?>
</div>