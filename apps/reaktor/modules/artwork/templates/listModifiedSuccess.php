<?php
/**
 * Component template that displays rejected artworks. 
 *  
 * PHP version 5
 * 
 * @author    Ole-Petter Wiknene <olepw@linpro.no>
 * @author    June Henriksen <juneih@linpro.no>
 * @copyright 2008 Linpro AS
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 * TODO: Slide the rejection comments
 */

reaktor::setReaktorTitle(__('Modified artwork')); 

?>

<?php use_helper('content', 'Javascript', 'PagerNavigation')?>

<h1><?php echo __('Modified artworks') ?></h1>
<hr class = "bottom_line" />
<?php include_component('admin', 'adminArtworkList', array('artworks' => $arts)); ?>
<?php echo pager_navigation($pager, '@artworkslistmodified') ?>