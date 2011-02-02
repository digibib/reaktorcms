<?php
/**
 * Generated (Crud) file for editing category translations
 * Variables passed by the action:
 * - $edit_category : The category object based on the id passed in the query string
 *
 * PHP Version 5
 *
 * @author    Russ Flynn <russ@linpro.no>
 * @copyright 2008 Linpro AS
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 *
 */

reaktor::setReaktorTitle(__("Edit categories")); 
use_helper('Object', 'Javascript');

?>

<?php echo form_tag('@categoryupdate') ?>

<?php echo object_input_hidden_tag($edit_category, 'getId') ?>
<?php echo object_input_hidden_tag($edit_category, 'getName') ?>

<h2><?php echo __('Translating %item_name%', array('%item_name%' => $edit_category->getName())); ?></h2>
<table>
  <tbody>
    <tr>
      <th style="padding-right: 10px;"><?php echo __("Basname"); ?></th>
      <td><?php echo $edit_category->getBasename(); ?></td>
    </tr>
    <tr>
      <th><?php echo __("Translated (%language%) text", array("%language%" => $sf_user->getCultureName()));?></th>
      <td><?php echo object_input_tag($edit_category, 'getName', array (
      'disabled' => false,
    )) ?></td>
  	</tr>
  </tbody>
</table>
<hr />
<?php echo submit_tag(__('Save')) ?>
<?php echo button_to_function(__('Cancel'), "history.go(-1)"); ?>
<?php echo '</form>'; ?>