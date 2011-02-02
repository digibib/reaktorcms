<?php
/**
 * Generated (Crud) file for translating artwork statuses
 * Variables passed by the action:
 *  - $artwork_status : The artwork status object, based on the passed ID in the query string
 * 
 * PHP Version 5
 *
 * @author    Ole-Peter Wikene <olepw@linpro.no>
 * @author    Russ <russ@linpro.no>
 * @copyright 2008 Linpro AS
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 *
 */

reaktor::setReaktorTitle(__("Edit artwork status"));
use_helper('Object'); 

?>

<?php echo form_tag('@artworkstatusupdate'); ?>
  <?php echo object_input_hidden_tag($artwork_status, 'getId'); ?>
  <?php echo object_input_hidden_tag($artwork_status, 'getName'); ?>
  
  <h2><?php echo __('Translating %item_name%', array('%item_name%' => $artwork_status->getName())); ?></h2>
  <table>
    <tbody>
      <tr>
        <th style="padding-right: 10px;"><?php echo __('Untranslated text') ?>:</th>
        <td><?php echo $artwork_status->getName(); ?></td>
      </tr>
      <tr>
        <th><?php echo __("Translated (%language%) text", array("%language%" => $sf_user->getCultureName()));?></th>
        <td><?php echo object_input_tag($artwork_status, 'getDescription', array (
        'disabled' => false,
      )) ?></td>
      </tr>
    </tbody>
  </table>
  <hr />
  <?php echo submit_tag(__('Save')); ?>
&nbsp;<div class="fakebutton"><?php echo link_to(__('Cancel'), '@artworkstatuses'); ?></div>
<?php echo '</form>'; ?>
