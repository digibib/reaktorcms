<?php
/**
 * This template generates a list of all files marked as unsuitable. It does so by including another partial. 
 * 
 * Passed from the controller:
 * $files - An array of artworkfile objects, with the rejected file message set. 
 *  
 */

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
reaktor::setReaktorTitle('Rejected files'); 

?>

<h1><?php echo __('Unsuitable files') ?></h1>
<hr class = "bottom_line" />
<?php include_partial('admin/adminArtworkList', array('files' => $files))?>
<?php echo pager_navigation($pager, '/artwork/listReportedContent') ?>
