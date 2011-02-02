<?php
/**
 * Used on report pages - shows a list of popular saved/bookmarked reports
 * Required parameter - report type ($type = 'artwork' or 'user') which corresponds to the type of report
 * as stored when saving a report bookmark.
 * 
 * The reports displayed by this partial have two links - one will show the report as a count, the other as a list
 * 
 * The component class will send back an array of bookmark objects which can be iterated below
 * The variable $savedReport will be false if the current report is unsaved, or will contain the report object
 */

/** PHP Version 5
 *
 * @author    Russ <russ@linpro.no>
 * @copyright 2008 Linpro AS
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 *
 */

use_helper("Javascript");
?>

<div id = "savedReportsBox">
  <h2><?php echo __('Top saved %reportType% reports', array("%reportType%" => $report_type)); ?></h2>
  <?php if (count($bookmarks) > 0): ?>
    <ul>
      <?php foreach ($bookmarks as $bookmark): ?>
        <li>
          <?php echo $bookmark->getTitle(); ?>
          <?php echo " [ ".content_tag("a", __("Stats") , array(
            "href" => url_for("@".$type."reports").$bookmark->getArgs()."/commit/generate_report/report_type/1",
            "label"  => __("This report - %report_title% (stats view)", array("%report_title%" => htmlentities($bookmark->getTitle())))
          )); ?>
          <?php echo " | ".content_tag("a", __("List") , array(
            "href" => url_for("@".$type."reports").$bookmark->getArgs()."/commit/generate_report/report_type/2",
            "label"  => __("This report - %report_title% (list view)", array("%report_title%" => htmlentities($bookmark->getTitle())))
            ))." ]"; ?>    
        </li>
      <?php endforeach; ?>
    </ul>
  <?php endif; ?>
    <p class = "position_right">
      <?php echo link_to(__("Show all / edit"), "@showReportBookmarks"); ?>
    </p>
  <?php if ($sf_params->get("commit")): ?>
    <div id = "report_save_box">
      <?php include_partial("savedReportBlock", array("savedReport" => $savedReport, "type" => $type)); ?>
    </div>
  <?php endif; ?>
</div>
