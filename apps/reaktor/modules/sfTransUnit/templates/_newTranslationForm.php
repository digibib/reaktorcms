<?php
/**
 * Form for adding a new database item to translate, based on passed object name
 * See admin/newCategorySuccess for example useage
 * 
 * Must pass translateObject and translateField
 * Preferable to pass redirect value also to send user somewhere sensible after success
 * 
 * PHP Version 5
 *
 * @author    Russ <russ@linpro.no>
 * @copyright 2008 Linpro AS
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 *
 */

use_helper("subreaktor", 'wai');

$referer        = sfRouting::getInstance()->getCurrentInternalUri();
$redirect       = isset($redirect) ? $redirect : $referer;
$referingModule = $sf_params->get("referingModule", $sf_params->get('module')); 
$referingAction = $sf_params->get("referingAction", $sf_params->get('action'));

?>
<h1><?php echo __("Add a new %1%", array("%1%" => $translateObject)); ?></h1>
<br />
<div id = "new_lang_item">
  <?php echo reaktor_form_tag("@translateFormAction"); ?>
    <?php echo form_error("basename"); ?>
    <?php echo wai_label_for("basename", __("Base name"))?>
      <?php echo input_tag("basename"); ?>
      <br /><br />
    <?php foreach ($languages as $key => $language): ?>
      <br />
      <?php echo form_error($key); ?>
      <?php echo wai_label_for($key, __($language));?>
      <?php echo input_tag($key); ?>
    <?php endforeach; ?>
    <br />
    <?php echo submit_tag("submit"); ?>
    <?php echo input_hidden_tag("redirect", $redirect); ?>
    <?php echo input_hidden_tag("referingModule", $referingModule); ?>
    <?php echo input_hidden_tag("referingAction", $referingAction); ?>
    <?php echo input_hidden_tag("translateObject", $translateObject); ?>
    <?php echo input_hidden_tag("translateField", $translateField); ?>
  </form>
</div>
