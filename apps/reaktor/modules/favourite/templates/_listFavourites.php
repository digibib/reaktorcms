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

?>
<?php use_helper('Javascript');?>

<h2><?php echo isset($header) ? $header : __('My favourite') ?></h2>
<?php if (isset($favourites) && !empty($favourites)): ?>
  <?php
  if (isset($who)):
    $user = current($favourites)->getSfGuardUserRelatedByUserId()->getUsername();
    $slug = $user. '_favourite_' . current($favourites)->getFavType();
  else:
    if ($type == 'user'):
        $user = current($favourites)->getSfGuardUserRelatedByFriendId()->getUsername();
     else:
        $userObj = sfGuardUserPeer::retrieveByPK(current($favourites)->getUserId());
        $user = $userObj->getUsername();
     endif;
    $slug = 'favourite_' . current($favourites)->getFavType(). '_' . $user;
  endif;
  include_partial('feed/rssLink', array('description' => isset($header) ? $header : __('Favourites'), 'slug' => $slug));
  $header = isset($header) ? $header : null;

  
  ?>
  <ul>
  <?php foreach ($favourites as $favourite): ?>
  
    <?php if ($favourite->getFavType() == 'artwork' || !isset($who)): ?>
    
      <?php if (isset($who)): ?>
        <?php $title = $favourite->getReaktorArtwork()->getTitle() ?>
        <?php $artId = $favourite->getReaktorArtwork()->getId() ?>
        <?php $url = '@show_artwork?id='.$artId.'&title='.$title ?>
        <li><?php echo reaktor_link_to($title,$url); ?>
        <?php if ($sf_user->isAuthenticated() && $sf_user->getUsername() === $favourite->getSfGuardUserRelatedByUserId()->getUsername()): ?>
            <?php echo link_to_remote(image_tag('/images/delete.png','width="10" height="10"'),
                                       array( 'url' => '/favourite/remove?id=' .$artId. '&who=Me&type='.$type.'&user='.@$listOwner,
                                              'update' => $type.'myfavourites',
                                              'confirm' => __('Are you sure you want to remove this artwork from your list of favourite artworks?'),
                                              'loading' => visual_effect('appear', 'fav_loading'),
                                              'complete' => visual_effect('highlight', 'myfavourites')));?>
            <?php endif ?>
        </li>

      <?php else: ?>
        <?php $username = $favourite->getSfGuardUserRelatedByUserId()->getUsername() ?>
        <li><?php echo reaktor_link_to($username,'@portfolio?user='.$username); ?></li>
      <?php endif ?>
      
    <?php elseif($favourite->getFavType() == "article"): ?>
      <li>
        <?php echo reaktor_link_to($favourite->getArticle()->getTitle(), $favourite->getArticle()->getLink()) ?>
        
        <?php if ($sf_user->isAuthenticated() && $sf_user->getUsername() === $listOwner): ?>
          <?php echo link_to_remote(image_tag('/images/delete.png','width="10" height="10"'),
                                      array( 'url' => '/favourite/remove?id='.$favourite->getArticleId().'&who=Me&type='.$type.'&user='.$listOwner,
                                            'update' => $type.'myfavourites',
                                            'confirm' => __('Are you sure you want to remove this article from your list af favourite articles?'),
                                            'loading' => visual_effect('appear', 'fav_loading'),
                                            'complete' => visual_effect('highlight', 'myfavourites')));?>
        <?php endif ?>
      </li>
    <?php else: ?>
        <?php $user = $favourite->getSfGuardUserRelatedByFriendId() ?>
      <li>
        <?php echo reaktor_link_to($user->getUsername(),'@portfolio?user='.$user->getUsername()); ?>
        <?php if (sfGuardUserPeer::isUserOnline($user->getId())): ?>
          <?php echo ("(Online now!)"); ?>
        <?php endif ?>
        
        <?php if($sf_user->isAuthenticated()): ?>
          <?php use_helper('Javascript') ?>
          <?php $userId = $favourite->getSfGuardUserRelatedByFriendId()->getId() ?>
          
          
          <?php if($sf_user->getUsername() == $listOwner): ?>
            <?php echo link_to_remote(image_tag('/images/delete.png','width="10" height="10"'),
                                       array( 'url' => '/favourite/remove?id='.$userId.'&who=Me&type='.$type.'&user='.$listOwner,
                                              'update' => $type.'myfavourites',
                                              'confirm' => __('Are you sure you want to remove this user from your list of favourite users?'),
                                              'loading' => visual_effect('appear', 'fav_loading'),
                                              'complete' => visual_effect('highlight', 'myfavourites')));?>
            <?php endif; ?>
          <?php endif; ?>
      </li>
    <?php endif ?>
  <?php endforeach ?>
  <?php if (count($favourites) <= 5): ?>
    <?php if (count($favourites) == 5 && $hasMoreFavorites): ?>
      <li><b>
      <?php if (!isset($who)): ?>
	      <?php echo link_to_remote(__('Show all'), array(
	                                                 'update' => $type.'favourites',
	                                                  'url' => '/favourite/listAll?id='.$artwork_or_user_id.'&type='.$type."&header=$header",
	                                                  'loading' => visual_effect('appear', 'fav_loading'),
	                                                  'complete' => visual_effect('fade', 'fav_loading').
	                                                                visual_effect('highlight', 'favourites')
	      )
	                                ); ?>
      <?php else: ?>
	      <?php echo link_to_remote(__('Show all'), array(
	                                                'update' => $type.'myfavourites',
	                                                'url' => '/favourite/listAll?id='.$artwork_or_user_id.'&who=Me&type='.$type."&header=$header",
	                                                'loading' => visual_effect('appear', 'fav_loading'),
	                                                'complete' => visual_effect('fade', 'fav_loading').
	                                                            visual_effect('highlight', 'myfavourites')
	    )
	                              ); ?>
	    <?php endif; ?>
    </b></li>
    <?php endif; ?>
  <?php else: ?>
    <li><b>
    <?php if (!isset($who)): ?>
	    <?php echo link_to_remote(__('Show last 5'), array(
	                                                'update' => $type.'favourites',
	                                                'url' => '/favourite/listLast?id='.$artwork_or_user_id.'&type='.$type."&header=$header",
	                                                'loading' => visual_effect('appear', 'fav_loading'),
	                                                'complete' => visual_effect('fade', 'fav_loading').
	                                                              visual_effect('highlight', 'favourites')
	    )
	                              ); ?>
    <?php else: ?>
	    <?php echo link_to_remote(__('Show last') . ' 5', array(
	                                              'update' => $type.'myfavourites',
	                                              'url' => '/favourite/listLast?id='.$artwork_or_user_id.'&who=Me&type='.$type."&header=$header",
	                                              'loading' => visual_effect('appear', 'fav_loading'),
	                                              'complete' => visual_effect('fade', 'fav_loading').
	                                                            visual_effect('highlight', 'myfavourites')
	  )
	                            ); ?>
    <?php endif; ?>
    </b></li>
  <?php endif ?>
  
</ul>
<?php endif; ?>

<?php if (!count($favourites)): ?>
  <?php echo __('There are no favourites in this list') ?>
<?php endif ?>

