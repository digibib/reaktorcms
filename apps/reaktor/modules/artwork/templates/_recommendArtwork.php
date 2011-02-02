<?php
/**
 * The staff of Reaktor can recommend an artwork in a Subreaktor, or in a Subreaktor within a Lokalreaktor. This 
 * template displays which Subreaktors the artwork can be recommended in, and which Subreaktors it's the latest
 * recommended in. To use it:
 * 
 * include_component('artwork', 'recommendArtwork' , array('artwork' => $artwork))
 * 
 * Parameters passed:
 * 
 * $artwork - Object of an artwork
 * 
 * From the controller the following information is passed:
 * $recommendations - Array of recommendation objects
 * $subreaktor_array - An array of the subreaktors the artwork can be recommended in
 *
 * PHP version 5
 *
 * @author    juneih <juneih@linpro.no>
 * @copyright 2008 Linpro
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 */

use_helper('Javascript');
?>
<div id='recommend_artwork_tag'>
  <?php if (isset($recommendations)&&count($recommendations)>0): //Display if the artwork is recommended already ?>
          
     <h4> <?php echo __('Recommended in:') ?></h4>
     <ul>   
       <?php foreach ($recommendations as $recommendation): ?>      
         <li>
           <?php echo $recommendation->getSubreaktor()->getReference() ?>
           <?php if ($recommendation->getLocalsubreaktor()->getReference()): ?>
             <?php echo ': '.$recommendation->getLocalsubreaktor()->getReference() ?>
           <?php endif ?>         
           
                     
         </li>      
       <?php endforeach ?>
     </ul>
  <?php endif ?>
  
  <?php  if (isset($subreaktor_array) && count($subreaktor_array) > 0 && $sf_user->hasCredential('recommendartwork')): ?>
    <h4><?php echo __('Recommend this artwork in:') ?></h4>
    <?php echo form_tag('artwork/recommendArtwork', array(
        'class' => 'recommend_artwork_form', 
        'id'    => 'recommend_artwork_form', 
        'name'  => 'recommend_artwork_form'
    ))?>
        
    <?php echo form_error('recommend_in_subreaktor') ?>
    <?php echo select_tag("recommend_in_subreaktor", options_for_select($subreaktor_array, '', array(
      'include_custom' => __('--- Recommend in ---')
    ))) ?>
       
     
     <?php //Show spinning reaktor logo only when submitting ?>
    <div id = "recommend_artwork_ajax_indicator" style="display: none">
      &nbsp;
      <?php echo image_tag('spinning18x18.gif', 'alt=spinning18x18')?>
    </div>
          
    <?php echo submit_to_remote('recommend_artwork_ajax_submit', __('Recommend artwork'), array(
         'update'   => 'recommend_artwork_tag', 
         'url'      => '@addartworkrecommendation?id='.$artwork->getId(),
         'loading'  => "Element.show('recommend_artwork_ajax_indicator')",
         'complete' => "Element.hide('recommend_artwork_ajax_indicator')",
         'script'   => true), array(
         'class' => 'submit'
       )) ?>  
     </form>
       
  <?php endif ?>
</div>  
