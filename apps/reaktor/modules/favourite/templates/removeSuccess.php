<?php
/**
 * helper template for adding favourite
 *  
 * PHP version 5
 * 
 * @author    Ole-Petter Wikene <olepw@linpro.no> 
 * @copyright 2008 Linpro AS
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 */

?>
<?php if (!isset($both)): ?>
	<?php if ($who): ?>
	   <?php $var_arr = array('type' => $type, 'artwork_or_user_id' => $artwork_or_user_id,'favourites' => $favourites, 'who' => 'Me')?>
	<?php else: ?>
	  <?php $var_arr = array('type' => $type, 'artwork_or_user_id' => $artwork_or_user_id,'favourites' => $favourites)?>
	<?php endif ?>
	<?php include_component('favourite','listFavourites',$var_arr); ?>
<?php else: ?>
  <?php include_component('favourite','artworkListFavourites',array('artwork_id' => $artwork_id, 'user_id' => $user_id, 'article_id' => $article_id, 'list' => $article_id ? "article" : null)); ?>
<?php endif; ?>

