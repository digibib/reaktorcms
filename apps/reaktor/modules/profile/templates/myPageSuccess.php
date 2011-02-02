<?php
/**
 * Every registered user of Reaktor have their own page they can call 'home'. That's the myPage, 
 * and this is the template for it. The template mostly includes other components. 
 * 
 * The controller passes the following information:
 * $user - An sfGuardUser object
 *  
 * PHP version 5
 * 
 * @author    Ole-Petter Wikene <olepw@linpro.no> 
 * @author    June Henriksen <juneih@linpro.no>
 * @copyright 2008 Linpro AS
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 */

use_helper('content');
reaktor::setReaktorTitle(__('My page - %username%', array("%username%" => $user->getUsername())));

?>

<h1><?php echo __('My artwork')?></h1>

<div id="mypage_left">

  <div class='image_list'>
    <?php include_component('artwork','lastArtworksFromUser', array(
           'id' => $user->getId(),
    )); ?>   
  </div>
  <?php if (count(ReaktorArtworkPeer::getLatestSubmittedApproved(1, $user->getId())) > 0): ?>
	  <div id='my_artwork_link'>
	    <h2><?php echo link_to(__('All my artworks'),'@'.$contentRoute.'?mode=allartwork&user='.$sf_params->get("user")); ?></h2>    
	  </div>
  <?php endif; ?>
    
  <div class='top_box_grey'>
   
    <div id='latest_comments_block' class='my_page_block'>
      <h2><?php echo __('Recieved comments'); ?></h2>
       <?php include_component('sfComment','commentTitleList',array(
         'user_id' => $user->getId(),
         'mode'    => 'received',
         'username' => $user->getUsername(),
         'header'   => __("Received comments"),
      )) ?> 
    </div>
    <div id='latest_commented_artworks_block' class='my_page_block' >
       <div id="latestcommented">
        <?php include_component('sfComment','latestCommentedArtworksByUser', array(
          'user_id' => $user->getId(), 
          'header' => __('My latest commented artworks')
        )); ?>
      </div>        
    </div>
        
  </div>
  <br class = "clear_both" />
  <div class='my_page_block_row'>
  
    <div id='favourite_with_block' class='my_page_block'>
      <div id="userfavourites">
        <?php include_component('favourite','listFavourites',array(
           'type'               => 'user',
           'artwork_or_user_id' => $user->getId(),
           'header'             => __("I'm a favourite with"),
        )); ?>
      </div>  
    </div>  
    <div id='my_favourite_users_block' class='my_page_block'>
      <div id="usermyfavourites">
        <?php include_component('favourite','listFavourites',array(
          'type'               => 'user', 
          'who'                => 'Me',
          'artwork_or_user_id' => $user->getId(),
          'header'             => __("My favourite users"),
        )); ?>
      </div>         
    </div>
    <br class = "clearboth" />
    
  </div>  
  
  <div class='my_page_block_row'>
    
    <div id='my_favourite_artworks_block' class='my_page_block'>
       <div id="artworkmyfavourites" class="relative">
         <?php include_component('favourite','listFavourites',array(
           'type' => 'artwork', 
           'who' => 'Me',
           'artwork_or_user_id' => $user->getId(),
           'header' => __("My favourite artworks"),
         )); ?>
       </div>            
    </div>  
    
    <div id='shared_interests_block' class='my_page_block relative'>
      <h2><?php echo __('Users with shared interests')?></h2>
      <?php include_component('profile', 'matchingInterests', array(
           'user_id'  => $user->getId(),
           'username' => $user->getUsername(),
           'all'      => false,
         )); ?>
    </div>    
    <br class = "clearboth" />
  
  </div >
  
  <div class='my_page_block_row'>
    <div id='my_comments_block' class='my_page_block'>
      <h2><?php echo __('Written comments'); ?></h2> 
      <?php include_component('sfComment','commentTitleList',array(
        'user_id' => $user->getId(),
        'mode'    => 'written',
        'username' => $user->getUsername(),
        'header'   => __("Written comments"),
      )); ?> 
      <?php if (count(sfComment::getLatestWrittenComments($user->getId())) > 0): ?>
	      <div class="list_bottom">
	      <?php echo link_to(__('All comments'), '@myusercomments?username='.$user->getUsername()) ?>
	      </div>
      <?php endif; ?>
    </div>
  </div>

</div>


<div id="mypage_right">

  <div id='administer_work_block' >
  <?php if (count($sf_user->getGuardUser()->getEditorialTeams()) > 0): ?>
    <h2><?php echo __('My editorial teams'); ?></h2>
    <ul class="editorialteamlist">
      <?php foreach ($sf_user->getGuardUser()->getEditorialTeams() as $ateam): ?>
        <li><?php echo $ateam->getDescription(); ?></li>
      <?php endforeach; ?>
    </ul>
  <?php endif; ?>
    <h2><?php echo __('Manage my artworks'); ?></h2>
    <ul>
      <li><?php echo  reaktor_link_to(__('Overview'), "@".$contentRoute."?mode=menu&user=".$sf_params->get("user")); ?></li>
      <li><?php echo  reaktor_link_to(__("manage and order artwork"), "@".$contentRoute."?mode=allartwork&user=".$sf_params->get("user")); ?></li>
      <li><?php echo  reaktor_link_to(__("create slide shows/playlists"), "@".$contentRoute."?mode=menu&user=".$sf_params->get("user")); ?></li>
    </ul>
  </div>
  
  <div id='my_resources_block' >
    <?php include_component('profile','resources' ,array(
    'user' => $user->getId()
    )); ?>      
  </div>

  <div id='my_articles_block' >
    <div id='my_favourite_article_block' class='my_page_block'>
      <div id="articlemyfavourites">
        <?php include_component('favourite','listFavourites',array(
          'type'               => 'article', 
          'who'                => 'Me',
          'artwork_or_user_id' => $user->getId(),
          'header'             => __("My favourite articles"),
        )); ?>
      </div>
    </div>
  </div>

  <div id='popular_artworks_block' >    
    <?php include_component('artwork','listUsersPopularArtworks' ,array(
      'user' => $user->getId()
    )); ?>   
  </div>
</div>

