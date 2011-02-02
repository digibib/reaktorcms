<?
/**
 * This template is a dummy needed to be able to display validation errors in a component. All it does is 
 * include a component. 
 * 
 * Passed from the controller:
 * $artwork - a genericArtwork object  
 *
 * PHP version 5
 *
 * @author    juneih <juneih@linpro.no>
 * @copyright 2008 Linpro
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 */

?>

<?php reaktor::setReaktorTitle(__('Artwork recommendation')); ?>

<?php
/**
 * We need this to be able to display validation errors in a component.
 */

include_component('artwork', 'recommendArtwork' , array(
        'artwork' => $artwork)) 

?>