<?php
/**
 * The reaktor site divides it's content into sections called subReaktors and lokalReaktors, each subReaktor 
 * corresponds to a format or category. The lokalReaktors are mini Reaktor sites filtered by location. They
 * have the same subreaktors as the Reaktor sites.
 * 
 * This template is the frontpage for the groruddalen lokalReaktor: groruddalenReaktor
 *  
 * The controller, a common controller for all the subreaktor templates, passes the following information.
 * 
 * $subreaktor   - which subreaktor (not needed in this particular template)
 * $lokalreaktor - which lokalreaktor 
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

    <div id="recommend_block" class="big_artwork">
      <h1 id='recommend'><?php echo __("We recommend") ?> </h1>
      <?php include_component("artwork","recommended")?>       
    </div>
      
    <div id="top_block_center" class="big_artwork">
      <?php $aSubreaktor = array_splice($last, array_rand($last), 1); ?>
      <h1 id='latest'><?php echo __('Latest in %subReaktor_name%', array('%subReaktor_name%' => $aSubreaktor[0]['subreaktor']->getName())); ?></h1>
      <?php include_component('artwork','lastArtworks' ,array(
        'image'        => 'subreaktorthumb',
        'limit'        => 1,
        'last'         => $aSubreaktor[0],
        'show_username'=> true,
        'cache'        => 'sub_' . Subreaktor::getProvidedSubreaktorReference() . '_lok_' . Subreaktor::getProvidedLokalReference(),
      )) ?>
         
    </div>
      
    <div id="top_block_right" class="big_artwork">
      <h1><?php echo __('Categories'); ?></h1>
      <?php include_component('subreaktors','listLokalReaktorSubcategories' ,array(
        'subreaktor' => $lokalreaktor
      )) ?>
      
    </div>
  <div class="clearboth"></div>
  <div class="list_block_wrapper">
  
    <div class="list_block clearboth">
      <h2><?php echo __('Most popular'); ?></h2>
      <?php include_component('artwork','listReaktorsPopularArtworks')?>      
      <br />
      <h2><?php echo __('Latest comments'); ?></h2>  
      <?php include_component('sfComment','commentTitleList', array(
        'mode'         => 'reaktor',
      )) ?>
      <br />
      <h2><?php echo __('New users'); ?></h2>
      <?php include_component("profile","lastUsers")?>
    </div>

    <div class="list_block">
	    <?php foreach ($last as $aSubreaktor): ?>
		    <?php include_component('artwork','lastArtworks' ,array(
		      'subreaktor'   => $aSubreaktor['subreaktor'],
		      'image'        => 'subreaktorlist',
		      'limit'        => 1,
		      'last'         => $aSubreaktor,
          'cache'        => 'sub_' . Subreaktor::getProvidedSubreaktorReference() . '_lok_' . Subreaktor::getProvidedLokalReference(),
		    )) ?>
      <?php endforeach; ?>
    </div>
    
  </div>

  <div id="navigation_block_wrapper">
    <div class="tag_block">
      <?php include_partial("tags/showtags") ?>
    </div>
      <?php echo include_component('articles', 'frontPageArticles'); ?>
  </div>
  
  
  
</div>
