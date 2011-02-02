<?php
/**
 * template for user portifolio
 *  
 * PHP version 5
 * 
 * @author    Ole-Petter Wikene <olepw@linpro.no> 
 * @author    June Henriksen <juneih@linpro.no>
 * @copyright 2008 Linpro AS
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 */

use_helper('content','Javascript');
reaktor::setReaktorTitle(__('Portfolio for %username%', array("%username%" => $user->getUsername()))); 

?>

<?php if ($blocked_profile): ?>
  <p><?php echo __('This users portfolio has been blocked') ?></p>
<?php else: ?>
	<div class="portfolio_header_wrapper">
	  <div style="float:left; padding-top: 3px;">
	  <?php if($user->getAvatar()): ?>
	  <?php echo image_tag('/uploads/profile_images/'.$user->getAvatar(), array('size' => '48x48', 'alt' => $user->getUsername())) ?>
	  <?php else: ?>
	  <?php echo image_tag('/uploads/profile_images/default.gif', array('size' => '48x48', 'alt' => $user->getUsername())) ?>
	  <?php endif ?>
	  </div>
	  <div class="portfolio_header">
	  
	  
	  <div class="floatleft"><?php echo __("%username%'s portfolio", array('%username%'=>$user->getUsername()))?></div>
  <div class="favourite_user_portfolio" style="float: left;">
    <?php include_component('favourite','artworkListFavourites',array('artwork_id' => false, 'user_id' => $user->getId(), 'list' => 'user', 'nofavload' => 'true')); ?>
  </div>

	  <div style="float: right;">
	  <?php include_component('profile','getLoggedInStatus',array(
	           'userid' => $user->getId(),
             'user'   => $user,
	    )) ?>
	  </div>
	  </div>
	<div style="float:right; padding: 3px">
	  <?php echo __("Sort %username%'s artworks on:", array("%username%" => $user->getUsername())) ?>
	  <?php echo link_to_remote(__('date'), array('update' => 'portfolio_image_list',
	                                          'url' => Subreaktor::addProvidedLinkIfValid('artwork/lastArtworksFromUserAction?&orderBy=date&userid='.$user->getId(). '&page=' . $page),
	                                          )) ?> |
	<?php echo link_to_remote(__('rating'), array('update' => 'portfolio_image_list',
	                                          'url' => Subreaktor::addProvidedLinkIfValid('artwork/lastArtworksFromUserAction?orderBy=rating&userid='.$user->getId(). '&page=' . $page),
	                                          )) ?> |
	<?php echo link_to_remote(__('title'), array('update' => 'portfolio_image_list',
	                                          'url' => Subreaktor::addProvidedLinkIfValid('artwork/lastArtworksFromUserAction?orderBy=title&userid='.$user->getId(). '&page=' . $page),
	                                          )) ?> |
	 <?php echo link_to_function(__('subReaktor'), visual_effect('toggle_appear', 'format_selection')) ?>
	
	</div>

	  <div style="clear:both;"></div>
	  <div id="format_selection" style='display:none'>
    <?php $subreaktorlinks = array(); ?>
    <?php $first_subreaktor = true; ?>
    <?php foreach (SubreaktorPeer::getLiveReaktors() as $aSubreaktor): ?>
      <?php if (!$aSubreaktor->getLokalReaktor()): ?>
        <?php if (!$first_subreaktor): ?>
          | 
        <?php else: ?>
          <?php $first_subreaktor = false; ?>
        <?php endif; ?>
        <div id="user_content_subreaktor_<?php echo $aSubreaktor->getReference(); ?>" style="position: relative; display: inline;">
          <?php $slug = sprintf("%s&username=%s", $aSubreaktor->getReference(), $user->getUsername()); ?>
          <?php include_partial('feed/rssLink', array('description' => __("Artworks in %reaktor% by %username%", array("%reaktor%" => $aSubreaktor->getName(), "%username%" => $user)), 'slug' => $slug, 'route' => 'userfeed')); ?>
  	     <?php echo link_to_remote($aSubreaktor->getName(), array('update' => 'portfolio_image_list',
  	                                            'url' => Subreaktor::addProvidedLinkIfValid('artwork/lastArtworksFromUserAction?orderBy=' . $aSubreaktor->getReference() . '&userid='.$user->getId()),
  	                                            )) ?>
        </div>
      <?php endif; ?>
    <?php endforeach; ?>
	  </div>
	</div>
	
	
	<div id="portfoliopage_left">
	
	  <div id="portfolio_image_list" class='image_list'>
	  	<?php include_partial('feed/rssLink', array('description' => __("All artworks by %username%", array("%username%" => $user->getUsername())), 
	  	                                            'slug' => "all&username=".$user->getUsername(),
	  	                                            'route' => "userfeed")); ?>
	    <?php include_component('artwork','lastArtworksFromUser',array(
	           'id' => $user->getId(),
	           'portfolio' => true,
	           'user' => $user,
	           'orderBy' => $orderBy,
	    )) ?>
	            
	  </div>
	<div style="clear:both;"></div>   
	    
	  <div class='my_page_block_row'>  
	    <div id='favourite_with_block' class='portfolio_block'>
	      <div id="userfavourites">
	        <?php include_component('favourite','listFavourites',array(
	           'type' => 'user',
	           'artwork_or_user_id' => $user->getId(),
             'header' => __("Users who have marked %username% as favourite", array("%username%" => $user->getUsername())),
          )); ?>
	      </div>  

	    </div>  
	  </div>  
	  
	    <div id='latest_commented' class='portfolio_block'>
        <div class="latest_commented">
	        <?php include_component('sfComment','latestCommentedArtworksByUser',array(
                  'user_id' => $user->getId(),
                  'header'  => __("%username%'s latest commented artwork", array("%username%" => $user->getUsername())),
          )); ?>
	      </div>  
	    </div>  
	  </div>  
	
	
	  <div class='my_page_block_row'>
	    
	    <div id='my_favourite_users_block' class='portfolio_block'>
	      <div id="usermyfavourites">
	        <?php include_component('favourite','listFavourites',array(
	          'type' => 'user', 
	          'who' => 'Me',
	          'artwork_or_user_id' => $user->getId(),
            'header' => __("%username%'s favourite users", array("%username%" => $user->getUsername())),
          )); ?>
	      </div>         

	    </div>
	
	
	    <div id='my_favourite_artworks_block' class='portfolio_block'>
	       <div id="artworkmyfavourites">
	         <?php include_component('favourite','listFavourites',array(
	           'type' => 'artwork', 
	           'who' => 'Me',
	           'artwork_or_user_id' => $user->getId(),
             'header' => __("%username%'s favourite artwork", array("%username%" => $user->getUsername())),
	         )); ?>
	       </div>            
	    </div>  
	
	    <div class = "clearboth"></div>
	  
	  </div >
<?php endif; ?>
