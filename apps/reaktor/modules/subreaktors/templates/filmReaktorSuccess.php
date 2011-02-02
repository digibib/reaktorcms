<?php
/**
 * The reaktor site divides it's content into sections called subReaktors and lokalReaktors, each subReaktor 
 * corresponds to a format or category. The lokalReaktors are mini Reaktor sites filtered by location. They
 * have the same subreaktors as the Reaktor sites.
 * 
 * This template is the frontpage for the film subReaktor: filmReaktor
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
 * @author    Ole Petter Wikene <olepw@linpro.no>
 * @author    June Henriksen <juneih@linpro.no>
 * @copyright 2008 Linpro AS
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 */

use_helper('home', 'content'); 

?>

<div id="home_content">
  
    <div id="recommend_block" class="big_artwork">
      <h1 id='recommend'><?php echo __("We recommend") ?> </h1>
      <?php include_component("artwork","recommended")?>       
    </div>

      
    <div id="top_block_center" class="big_artwork block">
      <h1 id='latest'><?php echo __("Latest") ?> </h1>
      <?php include_component('artwork','lastArtworks' ,array(
        'image'        => 'thumb',
        'limit'        => 1,
        'cache'        => 'sub_' . Subreaktor::getProvidedSubreaktorReference() . '_lok_' . Subreaktor::getProvidedLokalReference(),
      )) ?>
        
    </div>
  
    <div id="top_block_right" class="big_artwork">
      <?php include_component('subreaktors','listSubcategories'); ?>
    </div>
  <div class="clearboth"></div>
  <div class="list_block_wrapper">
  
    <div class='list_row clearboth'>
       <?php include_component('artwork','lastArtworks' ,array(
      'image'        => 'mini',
      'limit'        => 6,
      'exclude_first' => true,
      'cache'        => 'sub_' . Subreaktor::getProvidedSubreaktorReference() . '_lok_' . Subreaktor::getProvidedLokalReference(),
    )) ?>
    </div>

    <div class='list_row clearboth'>
      <br class = "clearboth" />
      <br class = "clearboth" />
    </div>
    
    <div class='list_row clearboth'>
      <div class="list_block_medium">
        <h2><?php echo __('Most popular'); ?></h2>
        <?php include_component('artwork','listReaktorsPopularArtworks'); ?>      
      </div>
      
      <div class="list_block_medium">
        <h2><?php echo __('Latest comments'); ?></h2>
        <?php include_component('sfComment','commentTitleList',array(         
         'mode'         => 'reaktor',
        )) ?>       
      </div>
      
      <div class="list_block_small">
        <h2> <?php echo __("Latest published") ?></h2>
        <?php include_component("artwork","lastArtworks", array(
          'exclude_first' => false,
          'limit'         => 5,
          'cache'        => 'sub_' . Subreaktor::getProvidedSubreaktorReference() . '_lok_' . Subreaktor::getProvidedLokalReference(),
        ))?> 
      </div>       
    </div>
    
  </div>
  <div id="navigation_block_wrapper">
    <div class="tag_block">
      <?php include_partial("tags/showtags", array('subreaktor' => $subreaktor, 'lokalreaktor' => $lokalreaktor)) ?>
    </div>
      <?php echo include_component('articles', 'frontPageArticles'); ?>
  </div>
  
</div>
