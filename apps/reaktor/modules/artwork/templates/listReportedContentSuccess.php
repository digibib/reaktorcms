<?php
/**
 * Component template that prints the 5 last registered users
 * Query is created and executed from profileComponents class, 
 * function executeLastUsers()
 *  
 * PHP version 5
 * 
 * @author    June Henriksen <juneih@linpro.no>
 * @copyright 2008 Linpro AS
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 */

use_helper('Javascript', 'PagerNavigation');
reaktor::setReaktorTitle(__('Reported content')); 

?>

<h1><?php echo __('Reported files') ?></h1>
<hr class = "bottom_line" />
<?php include_component('admin', 'adminArtworkList', array('files' => $reported_files)); ?>
<?php echo pager_navigation($pager, '/artwork/listReportedContent') ?>
