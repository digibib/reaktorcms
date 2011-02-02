<?php
/**
 * The reaktor site divides it's content into sections called subReaktors and lokalReaktors, each subReaktor 
 * corresponds to a format or category. The lokalReaktors are mini Reaktor sites filtered by location. They
 * have the same subreaktors as the Reaktor sites.
 * 
 * This template is the frontpage for the tekst/text subReaktor: tekstReaktor
 *  
 * The controller, a common controller for all the subreaktor templates, passes the following information.
 * 
 * $subreaktor   - which subreaktor (not needed in this particular template)
 * $lokalreaktor - which lokalreaktor (not needed in this particular template)
 * $bannerfarge  - string, randomly chosen colour to display banner.
 *  
 * PHP version 5
 * 
 * @author    Daniel Andre Eikeland <dae@linpro.no>
 * @author    Russ Flynn <russ@linpro.no>
 * @copyright 2008 Linpro AS
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 */

use_helper('home', 'content'); 

?>

<div id="home_content">
 
  <div id="top_block_left" class="big_artwork">
    <h1><?php echo __("Most popular"); ?></h1>
      <?php include_component('artwork','listReaktorsPopularArtworks', array(
      'text_or_artwork' => 1,
      'show_username'   => true,
    )) ?>
    
  </div>
    
  <div id="top_block_center" class="big_artwork">
    <h1 id='toprated'><?php echo __("Latest published") ?></h1>
      <?php include_component('artwork','lastArtworks', array(
      'limit'         => 5,
      'tags'          => 1,
      'show_username' => true,
      'cache'        => 'sub_' . Subreaktor::getProvidedSubreaktorReference() . '_lok_' . Subreaktor::getProvidedLokalReference(),
    )); ?>

  </div>

  <div id="top_block_right" class="big_artwork">
    <?php include_component('subreaktors','listSubcategories'); ?>
    
  </div>
  
  <div class="list_block_wrapper">
  
    <div class='list_row clearboth'>
      <br class = "clearboth" />
      <br class = "clearboth" />
      <?php echo image_tag('tekst_' . $bannerfarge . '.png', 'size=450x120') ?>
    </div>
    
    <div class='list_row clearboth'>
      <div class="list_block_medium">
        <h2><?php echo __('Latest comments'); ?></h2>
        <?php include_component('sfComment','commentTitleList',array(         
         'mode'         => 'reaktor',
        )); ?>
      </div>
      
      <div class="list_block_small">
        <h2><?php echo __('New users'); ?></h2>
        <?php include_component("profile","lastUsers"); ?>
      </div>
    </div>
    
    <div class='list_row clearboth'>
      <br class = "clearboth" />
      <br class = "clearboth" />
      <br class = "clearboth" />
      <br class = "clearboth" />
    </div>
    
  </div>
  <div id="navigation_block_wrapper">
    <div class="tag_block">
      <?php include_partial("tags/showtags") ?>
    </div>
      <?php echo include_component('articles', 'frontPageArticles'); ?>
  </div>
  
</div>
