<?php
/**
 * Artworks are what the Reaktor site is all about, and this template is one of the most important 
 * relating to artworks - it is the template to view an artwork. 
 * 
 * The controller passes the following information:
 * $artwork     - A genericArtwork object
 * $thefile     - Artworks with more than one file can decide which file to be displayed on the artwork page
 * $usercanedit - Passed to partials/components to inform about the logged in users credentials
 * $editmode    - Passed to partials/components that need to know if in editmode or not
 *  
 * PHP version 5
 * 
 * @author    Kjell-Magne Oierud <kjellm@linpro.no>
 * @author    Russ Flynn <russ@linpro.no>
 * @author    Daniel Andre Eikeland <dae@linpro.no>
 * @author    June Henriksen <juneih@linpro.no>
 * @copyright 2008 Linpro AS
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 */

reaktor::setReaktorTitle($artwork->getTitle()); 
use_helper('content', 'Javascript');

?>

<div id="artwork_main_container">
  <div id="artwork_info_header">
  <?php // Show the username, see ticket#476 ?>
    <?php $displayname = $artwork->getUser()->getUsername() ?>
    <?php if (!$artwork->isMultiUser()):  //Display title and username?> 
      <?php echo __('%artwork_title% by %username%', array(
        '%artwork_title% ' => '<h2 style="margin-right: 6px;">' . $artwork->getTitle() . '</h2>', 
        '%username%'       => '<b>' . reaktor_link_to($displayname, 
                                                      '@portfolio?user=' . $artwork->getUser()->getUsername()) . '</b>'
      ))?>
    <?php else: ?>
      <?php echo '<h2>' . $artwork->getTitle() . '</h2>'; ?>
    <?php endif; ?>
	  <?php if ($sf_user->hasCredential("editusercontent") || $sf_user->getId() == $artwork->getUserId()): ?>
	      <b>&nbsp;[<?php echo reaktor_link_to(__("Edit"), "@edit_artwork?id=".$artwork->getId()); ?>]</b>
	  <?php endif; ?>
  </div>
  <?php if ($sf_user->hasCredential('staff')): ?>
  	<br class = "clearboth" />
  	<p	class = "admin_message"><?php include_partial("artwork/statusRow", array(
      "artwork" => $artwork, 
      "break"   => true, 
      "show_id" => true)); ?></p>
  <?php elseif ($artwork->getArtworkType() == genericArtwork::TEXT): ?>
    <br class="clearboth" />
    <br class="clearboth" />
  <?php endif; ?>
  
  <?php if ($artwork->getFilesCount() > 1): ?>
  <div id="artwork_rss">
  <?php include_partial('feed/rssLink', array('description' => $artwork->getTitle(), 'slug' => "artwork", "route" => "showfilefeed?id=".$artwork->getId())); ?>
  </div>
  <?php endif ?>
  
  <div id="artwork_div">
    <?php if ($artwork->getArtworkType() == genericArtwork::TEXT): //Big thumbnail and rating for ?>
      
      <div id="textartwork_rating_and_thumb">
        <?php if ($thefile->getThumbpath() != '' && is_file(sfConfig::get('sf_root_dir') . "/content/" . $thefile->getIdentifier() . "/thumbnail/" .$thefile->getThumbPath())): ?>
	        <div id="artwork_thumbnail_text">
	          <?php echo image_tag(contentPath($thefile, 'thumb')) ?>
	        </div>
        <?php endif; ?>
	      <div id="artwork_rating" <?php if (!$sf_user->isAuthenticated()): ?> title="<?php echo __('Please login to vote'); ?>" <?php endif;?>>
	        <?php include_partial('artworkRating', array('artwork' => $artwork, 'usercanedit' => $usercanedit)); ?>        
	      </div>
      </div>
    <?php endif; ?>
    
    <?php //The artwork itself ?>
    <?php include_partial('artworkDisplay', array('artwork' => $artwork, 'thefile' => $thefile)) ?>
  </div>

  <div id="artwork_info_footer" class="clearboth">
    <div id="artwork_time_and_report">
      <span id="artwork_uploaded_at" class="small_text faded_text"><?php echo __('Uploaded %date_uploaded% at %time_uploaded%', array('%date_uploaded%' => date("d/m/y", strtotime($artwork->getSubmittedAt())), '%time_uploaded%' => date("H:i", strtotime($artwork->getCreatedAt())))); ?></span>
      
    </div>
    <?php if ($artwork->getArtworkType() != "text"): ?>
        <div id="artwork_rating" <?php if (!$sf_user->isAuthenticated()): ?> title="<?php echo __('Please login to vote'); ?>" <?php endif; ?>>
          <?php include_partial('artworkRating', array('artwork' => $artwork, 'usercanedit' => $usercanedit)); ?>
        </div>
      <div id="artwork_rating_print"><?php echo showScore($artwork->getAverageRating()); ?></div>
    <?php endif; ?>
  </div>
  
  <br class="clearboth" />
  <?php if ($artwork->getArtworkType() != 'text'): ?>
	  <div id="artwork_description">
	    <h4><?php echo __('Artwork description') ?></h4>
	    <?php if ($artwork->getFilesCount() > 1): ?>
	      <?php echo trim($artwork->getDescription()) != "" ? nl2br($artwork->getDescription()) : __("No description"); ?>
	    <?php else: ?>
	     <?php if ($thefile->getMetadata('description', 'abstract')): ?>
	       <?php echo nl2br($thefile->getMetadata('description', 'abstract')) ?>
	       <?php else: ?>
	         <?php echo trim($artwork->getDescription()) != "" ? nl2br($artwork->getDescription()) : __("No description"); ?>
	       <?php endif; ?>
	    <?php endif; ?>
	  </div>
  <?php endif; ?>






  <?php if ($artwork->getFilesCount() == 1 && $thefile->getMetadata('relation', 'references') && !stristr($thefile->getMetadata('relation', 'references'), 'http')===FALSE): ?>

<?php    $links=split("\n",$thefile->getMetadata('relation', 'references')); ?>

    <?php if (is_array($links)): ?>

	  <div id="artwork_description">
	    <h4><?php echo __('Artwork relations') ?></h4>
	       <?php
	        $links=split("\n",$thefile->getMetadata('relation', 'references'));
	        
	        foreach($links as $link) if(!stristr($link, 'http')===FALSE)
	                echo link_to($link, $link).'<br>';
	        
	        
	         ?>
	  </div>
    <?php endif; ?>

  <?php endif; ?>



  <div id="artwork_tags">
    <h4><?php echo __('Tags') ?></h4>
    <?php $tags = $artwork->getTags(); ?>
    <?php if ($tags): ?>
      <?php include_partial('tags/viewTagsWithLinks', array("tags" => $tags, 'subreaktor' => $artwork->getSubreaktors(true))) ?>
    <?php else: ?>
      <?php if (count($artwork->getTags(false, true)) > 0): ?>
        <?php echo __('This artwork has no approved tags'); ?>
      <?php else: ?>
        <?php echo __('This artwork has no tags'); ?>
      <?php endif; ?>
    <?php endif; ?>
  </div>
  
  <div id="artwork_copyright">
    <?php include_partial("licenseinfo", array('thefile' => $thefile)) ?>
  </div>
  
	<div id='relate_artwork_see_also'>
	  <?php // include_component('artwork', 'linkRelated', array('artwork' => $artwork, 'usercanedit' =>$usercanedit, 'editmode' => $editmode)) ?>
    <?php include_component('artwork', 'seeAlso', array(
      'artwork'     => $artwork, 
      'update'      => 'relate_artwork_tag',
      'editmode'    => $editmode, 
      'usercanedit' => $usercanedit)); ?>
	</div>
	
  <?php if (!$stripmode): ?>
    <?php include_partial('artwork/socialBookmarks', array('artwork' => $artwork, 'thefile' => $thefile)); ?>
	  <div id="artwork_comments">
	    <div id="all_sf_comments_list">
	      <?php include_partial('artwork/displayComments', array('object' => $artwork->getBaseObject(), 'namespace' => 'frontend', 'adminlist' => false)) ?>
	    </div>
	  </div>
  <?php endif; ?>  
  
</div>


<div id="artwork_right_container">
  <div class="artwork_tag_block">
    <?php include_component("tags", "showintellitags", array('tags' => $artwork->getTags())) ?>
  </div>
  <div id="artwork_actions_and_favourites">
    <?php include_component('favourite', 'artworkListFavourites', array('artwork_id' => $artwork->getId(), 'user_id' => $artwork->getUser()->getId(), "checkAndDeleteNode" => "artwork_actions_and_favourites")); ?>
    <div id="artwork_reportunsuitable"><?php include_partial('reportunsuitable', array('artwork' => $artwork, 'thefile' => $thefile, 'partial' => true)); ?></div>
  </div>
  
  <?php if ($artwork->showNavigationOnDisplay() && $artwork->getFilesCount() > 1): ?>
    <div class='colored_article_container'>
      <h4><?php echo __("Files in this collection:"); ?></h4> 
      <br />
      <?php echo __("Current: %artwork_title%", array("%artwork_title%" => $thefile->getTitle())); ?>
      <br /><br />
      <?php include_partial("artworkNavLinks", array("class" => "artwork_nav_links", "artwork" => $artwork, "thefile" => $thefile)); ?>
    </div>    
  <?php endif; ?>
  
  <?php include_partial('metadataList', array('artwork' => $artwork, 'file' => $thefile)); ?>
  
  <?php if ($articles): ?>    
    <div class='colored_article_container'>
    	<h4> <?php echo __('Learn more') ?></h4>
      <?php include_partial("articles/articleList", array("articles" => $articles))?>
    </div>
  <?php endif; ?>
  
  
  <?php if ($sf_user->hasCredential('staff')): ?>
    <div class='moderator_block'>
      <?php include_partial('moderatorlinks', array(
        'artwork' => $artwork,
        'thefile' => $thefile)) ?>

      <?php include_component('artwork', 'editorialTeamArtwork' , array(
        'artwork' => $artwork)) ?>
      <?php if($artwork->getStatus() == 3): ?>
        <?php include_component('artwork', 'recommendArtwork' , array(
          'artwork' => $artwork)) ?>
      <?php endif ?>

    </div>
  <?php endif; ?>
  
</div>
