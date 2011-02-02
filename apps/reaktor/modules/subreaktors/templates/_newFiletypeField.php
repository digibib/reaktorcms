<?php
/**
 * 
 *  
 * PHP version 5
 * 
 * @author    Daniel Andre Eikeland <dae@linpro.no>
 * @copyright 2008 Linpro AS
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 */
?>
<?php echo select_tag('filetype', options_for_select($filetypes));?>
<?php echo submit_tag(__('Add')); ?>
<?php echo image_tag("spinning18x18.gif", array("style"  => "display: none; margin-left: 2px; margin-top: 2px;", "id" => "filetype_indicator")) ?>