<?php
/**
 * The staff of Reaktor can recommend an artwork in a Subreaktor, or in a Subreaktor within a Lokalreaktor. 
 * This template displays a list of the latest recommended artworks across the site.
 * 
 * From the controller the following information is passed:
 * 
 * $artworks - a list of recommended artworks and where they are recommended
 * $artworks[x]['artwork']= genericArtwork Object
 * $artworks[x]['subreaktor'] = Subreaktor Object
 * $artworks[x]['lokalreaktor'] = Subreaktor Object  
 * 
 *
 * PHP version 5
 *
 * @author    juneih <juneih@linpro.no>
 * @copyright 2008 Linpro
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 */
use_helper('content'); 

reaktor::setReaktorTitle(__('Recommended artworks')); 
?>
<h1> <?php echo __('Recommended artworks across the site') ?></h1>
<?php include_component('admin', 'adminArtworkList', array('artworks' => $artworks, 'show_recommended' => true)); ?>
