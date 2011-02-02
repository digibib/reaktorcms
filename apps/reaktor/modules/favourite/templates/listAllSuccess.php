<?php
/**
 * helper template for listing all favourites
 *  
 * PHP version 5
 * 
 * @author    Ole-Petter Wikene <olepw@linpro.no> 
 * @copyright 2008 Linpro AS
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 */

?>
<?php if ($type == 'user'): ?>
	<?php if ($who): ?>
	  <?php include_component('favourite','listFavourites', array('type' => $type, 'artwork_or_user_id' => $artwork_or_user_id,'favourites' => $favourites, 'who' => 'Me', 'header' => $header, 'listOwner' => $listOwner)); ?>
	<?php else: ?>
	  <?php include_component('favourite','listFavourites', array('type' => $type, 'artwork_or_user_id' => $artwork_or_user_id,'favourites' => $favourites, 'header' => $header, 'listOwner' => $listOwner)); ?>
	<?php endif ?>
<?php else: ?>
	<?php if (!$who): ?> 
	<?php include_component('favourite','artworkListFavourites', array('artwork_id' => $artwork->getId() , 'user_id' => $artwork->getUser()->getId(), 'all' => true)); ?>
	<?php else: ?>
      <?php include_component('favourite','listFavourites', array('type' => $type, 'artwork_or_user_id' => $artwork_or_user_id,'favourites' => $favourites, 'who' => 'Me', 'header' => $header, 'listOwner' => $listOwner)); ?>
    <?php endif ?>
<?php endif; ?>


