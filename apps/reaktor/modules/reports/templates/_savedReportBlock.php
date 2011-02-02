<?php
/**
 * Partial for showing the current bookmarked report or the form for saving a new one
 * In a partial so we can use it to update the ajax response
 * 
 * Expected parameters: $savedReport and $type - loaded and passed from the calling template
 *
 * PHP Version 5
 *
 * @author    Russ <russ@linpro.no>
 * @copyright 2008 Linpro AS
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 *
 */

use_helper("Javascript", 'wai');
?>

<?php if ($savedReport): ?>
  <h2><?php echo __("This report") ?></h2>
  <p>
    <?php echo $savedReport->getTitle(); ?>
    <?php echo " [ ".content_tag("a", __("Stats") , array(
      "href" => url_for("@".$type."reports").$savedReport->getArgs()."/commit/generate_report/report_type/1")) ?>
    <?php echo " | ".content_tag("a", __("List") , array(
      "href" => url_for("@".$type."reports").$savedReport->getArgs()."/commit/generate_report/report_type/2"))." ]" ?>
  </p>
<?php else: ?>
  <?php echo form_remote_tag(array(
           'update'   => 'report_save_box', 
           'url'      => '@reportBookmarkSave')); ?> 
    <h2><?php echo __("Save this report"); ?></h2>
    <fieldset>
      <?php echo wai_label_for("title", __("Title:")); ?>
      <?php echo input_tag("title"); ?>
      <br />
      <?php echo wai_label_for("description", __("Description:")) ?>
      <?php echo textarea_tag("description", null, array("size" => "20x3")); ?>
      <br />
      <p class = "position_right">
        <?php echo submit_tag(__('Bookmark report')) ?>
      </p>
    </fieldset>
  <?php echo input_hidden_tag("url", sfRouting::getInstance()->getCurrentInternalUri())?>
  <?php echo input_hidden_tag("type", $type); ?>
  </form>
<?php endif; ?>
