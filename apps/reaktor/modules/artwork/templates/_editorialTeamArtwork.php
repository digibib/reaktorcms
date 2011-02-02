<?php
/**
 * 
 *  
 * PHP version 5
 * 
 * @author    Daniel Andre Eikeland <dae@linpro.no>
 * @copyright 2008 Linpro AS
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 */
use_helper('Javascript');
//print_r($recommendations);
?>
<div id='artwork_editorialteam_tag'>
  <?php if ($artwork->getStatus() != 3): ?>
    <?php echo form_tag('@updateartworkeditorialteam?id='.$artwork->getId(), array(
        'class' => 'artwork_editorialteam_form', 
        'id'    => 'artwork_editorialteam_form', 
        'name'  => 'artwork_editorialteam_form'
    ))?>
        
   <h4> <?php echo __('Awaiting approval by:') ?></h4>
   <p> 
    <?php
    $hasteam = false;
    try
    {
      $editorial_desc = $artwork->getEditorialTeam()->getDescription();
      $hasteam = true;
    } catch(Exception $e)
    {
      $editorial_desc = "No team";
    }
    echo $editorial_desc;
  ?>
  </p>
    <h4> <?php echo __('Select new team:') ?></h4>
    <?php echo select_tag("new_editorialteam", options_for_select($available_teams, $hasteam ? $artwork->getEditorialTeam()->getId() : -1)) ?>
     
     <?php //Show spinning reaktor logo only when submitting ?>
    <div id="editorialteam_ajax_indicator" style="display: none">
      &nbsp;
      <?php echo image_tag('spinning18x18.gif', 'alt=spinning18x18')?>
    </div>
          
    <?php echo submit_to_remote('editorialteam_artwork_ajax_submit', __('Change'), array(
         'update'   => 'artwork_editorialteam_tag', 
         'url'      => '@updateartworkeditorialteam?id='.$artwork->getId(),
         'loading'  => "Element.show('editorialteam_artwork_ajax_indicator')",
         'complete' => "Element.hide('editorialteam_artwork_ajax_indicator')",
         'script'   => true), array(
         'class' => 'submit'
       )) ?>  
     <?php echo '</form>'; ?>
   <?php else: ?>
     <br />
     <?php echo __('Approved in %editorial_team% by %user% on %on_date% at %at_time%', array("%on_date%" => date("d/m/Y", strtotime($artwork->getActionedAt())), "%at_time%" => date("H:i", strtotime($artwork->getActionedAt())), '%editorial_team%' => $artwork->getEditorialTeam()->getDescription(), '%user%' => $artwork->getActionedBy(false))) ?>
     <br />
     <br />
   <?php endif; ?>
</div>  
