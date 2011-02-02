<?php
/**
 * When users first arrive at the reaktor site their first meeting will be with this page.
 * This is the front page template for the main home page of reaktor.  Many components on 
 * the home page will be derived from the main layout.php file and from various blocks and 
 * modules. So many in facts, that there are no information being passed from the controller.
 * 
 * PHP version 5
 * 
 * @author    Russ Flynn <russ@linpro.no>
 * @author    June Henriksen <juneih@linpro.no>
 * @copyright 2008 Linpro AS
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 */

reaktor::setReaktorTitle(__('Homepage'));
use_helper('home', 'content'); 

?>

<div id="home_content">
  <div id ="home_top_row">
    <div id="recommend_block" class="big_artwork">
      <h1 id='recommend'><?php echo __("We recommend") ?> </h1>
      <?php include_component("artwork","recommended")?>       
    </div>
      
    <div id="popular_block" class="big_artwork">
      <h1 id='toprated'><?php echo __("Most popular") ?> </h1>
      <?php include_component('artwork','listReaktorsPopularArtworks' ,array(
        'image' => 'thumb',
        'limit' => 1,       
      )); ?> 
    </div>
  
    <div id="latest_block" class="big_artwork">

      <h1 id='latest'><?php echo __("Latest") ?> </h1>
      <?php include_component('artwork','lastArtworks' ,array(
        'image'  => 'thumb',
        'limit'  => 1,
        'cache'  => 'sub' .Subreaktor::getProvidedSubreaktorReference() . 'lok' .Subreaktor::getProvidedLokalReference(),
// Ticket 25288  ?
'last'   => array(array_shift($last)),
//        'last'   => $last,
      )); ?>
    </div>
	</div>  
  <div class="list_block_wrapper clearboth">
  
    <div class='list_row'>
      <div class="list_block">      
        <h2><?php echo __("Latest commented") ?></h2>
        <?php include_component("artwork","latestCommented")?>   
      </div>
      <div class="list_block">
        <h2><?php echo __("Latest artwork") ?></h2>
        <?php include_component('artwork', 'lastArtworks', array(
          'culture'       => $sf_user->getCulture(),
          'last'          => $last,
          )) ?>
      </div>          
    </div>
    <br class = "clearboth" />


    <div class='list_row'>
      <div class="list_block">
        <h2><?php echo __("Top photos") ?></h2>
        <?php include_component('artwork','listReaktorsPopularArtworks' ,array(
            'subreaktor' => Subreaktor::getByReference('foto'),
            'feed_slug' => 'popular_foto',
            'feed_description' => "top photos"
        )); ?>      

      </div>  

      <div class="list_block">
        <h2><?php echo __("New users") ?></h2>
        <?php include_component("profile","lastUsers")?>      
      </div>       
      <br class = "clearboth" />
    </div>

    <div class='list_row'>
    <?php
      // do *not* cache the random component
      if (sfConfig::get('sf_environment') != 'test')
      {
        sfContext::getInstance()->getViewCacheManager()->addCache(
          "artwork", '_lastArtworks', array('withLayout' => false, 'lifeTime' => -1, 'clientLifeTime' => 86400, 'contextual' => false, 'vary' => array ())
        );
      }
      include_component('artwork', 'lastArtworks', array(
        'image' => 'mini',
        'limit' => 6,
        'random'=> true,
      )) ?>
    </div>
  </div>
  <div id="navigation_block_wrapper">
    <div class="tag_block">
      <?php include_partial("tags/showtags")?>
    </div>
    <?php echo include_component('articles', 'frontPageArticles'); ?>
  </div>
  
</div>

