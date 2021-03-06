<?php
/**
 *
 * Each string in Reaktor can be translated. This template is used in the adminportal to display how a string
 * has been translated. The string in the code is the source, usually plain english and can be used directly as
 * an English version. Other times, the source is just a placeholder and must be translated to english as well. 
 * 
 * This template is the main template for the edit view of a string translation. The controller passes the following information:
 * 
 * $trans_unit - Trans unit object, which contains the source string to be translated
 * $labels     - The form labels 
 * 
 * 
 * auto-generated by sfPropelAdmin
 * date: 2008/08/14 12:20:44
 * 
 *
 * PHP version 5
 *
 * @author    juneih <juneih@linpro.no>
 * @copyright 2008 Linpro
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 */
?>
<?php use_helper('Object', 'Validation', 'ObjectAdmin', 'I18N', 'Date') ?>

<?php use_stylesheet('/sf/sf_admin/css/main') ?>

<div id="sf_admin_container">

<h1><?php echo __('Edit Translation', 
array()) ?></h1>

<div id="sf_admin_header">
<?php include_partial('sfTransUnit/edit_header', array('trans_unit' => $trans_unit)) ?>
</div>

<div id="sf_admin_content">
<?php include_partial('sfTransUnit/edit_messages', array('trans_unit' => $trans_unit, 'labels' => $labels)) ?>
<?php include_partial('sfTransUnit/edit_form', array('trans_unit' => $trans_unit, 'labels' => $labels)) ?>
</div>

<div id="sf_admin_footer">
<?php include_partial('sfTransUnit/edit_footer', array('trans_unit' => $trans_unit)) ?>
</div>

</div>
