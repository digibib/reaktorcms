<?php
/**
 * template for listing favourites
 *  
 * PHP version 5
 * 
 * @author    Ole-Petter Wikene <olepw@linpro.no> 
 * @copyright 2008 Linpro AS
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 */

use_helper('Javascript');

if (!isset($types)):
  $types = array('user', 'artwork',);
endif;

if (isset($list) && in_array($list, $types)):
  $types = array($list);
endif;

?>

<div id="artwork_actions_and_favourites_js">
<div class="list_bottom" id="artwork_favourite_links_container">
<?php if ($sf_user->hasCredential('markfavourite')):  //user is logged in?>
	<?php foreach ($types as $type): ?>
	  <?php if ($type == 'artwork'): ?>
	    <?php $artwork_or_user_id = $artwork_id; ?>
    <?php elseif ($type == 'article'): ?>
      <?php $artwork_or_user_id = $article_id; ?>
	  <?php elseif ($type == 'user'): ?>
	    <?php $artwork_or_user_id = $user_id; ?>
	  <?php endif; ?>
	    <?php if (isset($isFavourite[$type]) && $isFavourite[$type]):?>
	        <?php echo image_tag('favourite.gif', array('align' => 'left')); ?>
	        <?php if ($type == 'artwork'): ?>
	          <?php echo __('You like this artwork') ?>
	        <?php elseif ($type == 'user'): ?>
	          <?php echo __('You like this user') ?>
          <?php elseif ($type == 'article'): ?>
            <?php echo __('You like this article') ?>
	        <?php endif; ?>
	      (<?php echo link_to_remote(__('Remove'), array( 'update' => 'artwork_actions_and_favourites_js',
                                                        'url' => '@remove_favourite?id='.$artwork_or_user_id.'&both=true&artwork_id='.$artwork_id.'&user_id='.$user_id.'&type='.$type,
                                                        'confirm' => __('Are you sure you want to remove this from your list of favourites?'),
                                                        'loading' => visual_effect('appear', 'fav_loading'),
                                                        'complete' => visual_effect('fade', 'fav_loading').visual_effect('highlight', 'favourites')
                                                         )) ?>)<br style="clear: both;" />
	    <?php else: ?>
	      <?php if($sf_user->getUsername() != $listOwner): //Prevent user from adding themselves?>
          <?php echo image_tag('addfavourite.gif', array('align' => 'left')); ?>        
          <?php if ($type == 'artwork'): ?>
            <?php $linktext = __('Mark this artwork as favourite') ?>
          <?php elseif ($type == 'user'): ?>
            <?php $linktext = __('Mark this user as favourite') ?>
          <?php elseif ($type == 'article'): ?>
            <?php $linktext = __('Mark article as favourite') ?>
          <?php endif ?>       
          <?php echo link_to_remote($linktext, array( 'update' => 'artwork_actions_and_favourites_js',
                                                            'url' => '@add_favourite?id='.$artwork_or_user_id.'&both=true&artwork_id='.$artwork_id.'&user_id='.$user_id.'&type='.$type,
                                                              'loading' => visual_effect('appear', 'fav_loading'),
                                                              'complete' => visual_effect('fade', 'fav_loading').visual_effect('highlight', 'favourites')
                                                              )) ?><br style="clear: both;" />
        <?php else: ?>
          <?php // My own work and noone likes it. Intentionally not showing anything ?>
        <?php endif; ?>
		<!--  ######## -->
		<?php endif ?>
	<?php endforeach; ?>
<?php elseif ($sf_user->isAuthenticated()):  //user is logged in but does not have access to marking favourites ?>
  <?php echo image_tag('addfavourite.gif', array('align' => 'left')); ?><?php echo __('You can not mark favourites') ?>
<?php else: //user isn't logged in ?>
  <?php echo image_tag('addfavourite.gif', array('align' => 'left')); ?><?php echo __('Log in to mark as favourite') ?>
<?php endif ?>
</div>
<?php if ($showUsers): ?>
<?php $type = 'artwork'; ?>
<?php if (!empty($favourites[$type])): ?>
  <?php if (count($favourites[$type]) < 2) $user_string = __('user'); else $user_string = __('users'); ?>
  <h4>
  <?php if (count($favourites[$type]) == 5 && $hasMoreFavourites) echo __('At least') . "&nbsp;";?>
  <?php echo __('%number% %users% like this artwork', array('%number%' => count($favourites[$type]), '%users%' => $user_string)) ?></h4>
  <ul>
  <?php foreach ($favourites[$type] as $favourite): ?>
  
    <?php if ($favourite->getFavType() == 'artwork'): ?>
    
        <?php $username = $favourite->getSfGuardUserRelatedByUserId()->getUsername() ?>
        <li><?php echo reaktor_link_to($username,'@portfolio?user='.$username); ?></li>
      
    <?php elseif ($favourite->getFavType() == 'article'): ?>
    FIXME
    <?php elseif ($favourite->getFavType() == 'user'): ?>
    
        <?php $username = $favourite->getSfGuardUserRelatedByFriendId()->getUsername() ?>
      <li>
        <?php echo reaktor_link_to($username,'@portfolio?user='.$username); ?>
        
        <?php if($sf_user->isAuthenticated()): ?>
          <?php $userId = $favourite->getSfGuardUserRelatedByFriendId()->getId() ?>
          <?php if($sf_user->getUsername() === $listOwner): ?>
            <?php echo link_to_remote(image_tag('/images/delete.png','width="10" height="10"'),
                                       array( 'url' => '/favourite/remove?id='.$userId.'&who=Me&both=true&artwork_id='.$artwork_id.'&user_id='.$user_id.'&type='.$type.'&user='.$listOwner,
                                              'update' => 'artwork_actions_and_favourites_js',
                                              'confirm' => __('Are you sure you want to remove this user from your list of favourite users?'),
                                              'loading' => visual_effect('appear', 'fav_loading'),
                                              'complete' => visual_effect('highlight', 'myfavourites')));?>
            <?php endif; ?>
          <?php endif; ?>
      </li>
    <?php endif ?>
  <?php endforeach ?>
  <?php if (count($favourites[$type]) <= 5): ?>
    <?php if (count($favourites[$type]) == 5 && $hasMoreFavourites):?>

      <li><b>
      <?php if ($sf_user->isAuthenticated() && !isset($who)): ?>
	      <?php echo link_to_remote(__('Show all'), array(
	                                                 'update' => 'artwork_actions_and_favourites_js',
	                                                 'url' => '/favourite/listAll?id='.$artwork_or_user_id.'&both=true&artwork_id='.$artwork_id.'&user_id='.$user_id.'&type='.$type,
	                                                 'loading' => visual_effect('appear', 'fav_loading'),
	                                                 'complete' => visual_effect('fade', 'fav_loading').visual_effect('highlight', 'favourites')
	                                                )); ?>
	    <?php endif; ?>
    </b></li>
    <?php endif; ?>
  <?php else: ?>
    <li><b>
    <?php if ($sf_user->isAuthenticated() && !isset($who)): ?>
	    <?php echo link_to_remote(__('Show last 5'), array(
	                                                'update' => 'artwork_actions_and_favourites_js',
	                                                'url' => '/favourite/listLast?id='.$artwork_or_user_id.'&both=true&artwork_id='.$artwork_id.'&user_id='.$user_id.'&type='.$type,
	                                                'loading' => visual_effect('appear', 'fav_loading'),
	                                                'complete' => visual_effect('fade', 'fav_loading').visual_effect('highlight', 'favourites')
	                                                 )); ?>
    <?php endif; ?>
    </b></li>
  <?php endif ?>
  
</ul>
<?php endif; ?>
<?php endif; // showUsers ?>

<?php if (!isset($nofavload)): ?>
<div id="fav_loading" style="display:none;">
  <?php echo image_tag('/images/ajax-loading.gif', '') ?>
</div>
<?php endif ?>
</div>

<?php if (isset($checkAndDeleteNode) && $checkAndDeleteNode): ?>
  <?php reaktor::addJsToFooter(sprintf('setTimeout("deleteEmptyNode(\'%s\')", 200);', $checkAndDeleteNode)) ?>
<?php endif; ?>

