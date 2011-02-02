<?php
/**
 * The staff of Reaktor can make composite artworks, combining work from many users into one artwork
 * This template displays a list of the such artworks
 * 
 * From the controller the following information is passed:
 * 
 * - $artworks : an array of all the artworks on the site that are composite/multi-user 
 * 
 *
 * PHP version 5
 *
 * @author    juneih <juneih@linpro.no>
 * @copyright 2008 Linpro
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 */
use_helper('content'); 

reaktor::setReaktorTitle(__('Admin galleries/composite artworks')); 
?>
<h1> <?php echo __('Composite artworks created by staff'); ?></h1>
<?php include_component('admin', 'adminArtworkList', array('artworks' => $artworks)); ?>
