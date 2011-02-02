<?php
/**
 * favourite action links
 *  
 * PHP version 5
 * 
 * @author    Daniel Andre Eikeland <dae@linpro.no>
 * @copyright 2008 Linpro AS
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 */
?>
<?php if ($sf_user->isAuthenticated() && !isset($who)): ?>
  <div class="list_bottom">
	  <?php if (isset($isFavourite) && $isFavourite):?>
	    <?php //echo __('You are a fan of this artwork') ?>
	    <?php use_helper('Javascript') ?>
	    <?php echo link_to_remote(__('Remove %1% from favourites', array('%1%' => $type)), array( 'update' => $type.'favourites',
	                                                          'url' => '/favourite/remove?id='.$artwork_or_user_id.'&type='.$type,
	                                                          'confirm' => __('Are you sure you want to remove this from your list of favourites?'),
	                                                          'loading' => visual_effect('appear', 'fav_loading'),
	                                                          'complete' => visual_effect('fade', 'fav_loading').
	                                                                      visual_effect('highlight', 'favourites')
	
	                                                          )) ?><br />
	  <?php else: ?>
	    <?php use_helper('Javascript') ?>
	    <?php if (!$isMyPage): ?>
	      <?php echo link_to_remote(__('Mark %1% as favourite', array('%1%' => $type)) . "&nbsp;&nbsp;", array( 'update' => $type.'favourites',
	                                                          'url' => '/favourite/add?id='.$artwork_or_user_id.'&type='.$type,
	                                                            'loading' => visual_effect('appear', 'fav_loading'),
	                                                            'complete' => visual_effect('fade', 'fav_loading').
	                                                                          visual_effect('highlight', 'favourites')
	                                                            )) ?><br />
	    <?php endif ?>
	  <?php endif ?>
  </div>
<!--  ######## -->
<?php endif ?>