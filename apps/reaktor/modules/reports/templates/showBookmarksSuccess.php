<?php
/**
 * Administrative users are able to document the success of the site, as well as work out how the site is used by it's visitors
 * and members, by using the reports section in the backend. This template contains a list of bookmarked reports. 
 * 
 * The controller passes the following information:
 * - $groupedReports - Array of reports, dividied by groups (array of arrays) 
 *
 * PHP Version 5
 *
 * @author    Russ <russ@linpro.no>
 * @author    June Henriksen <juneih@linpro.no>
 * @copyright 2008 Linpro AS
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 *
 */

use_helper("Javascript");

?>
<div id = "savedReportsBox">
  <h2><?php echo __('Quick links') ?></h2>
  <ul> 
    <li><?php echo link_to(__('Generate artwork report'), '@artworkreports') ?></li> 
    <li><?php echo link_to(__('Generate user report'), '@userreports') ?></li>
  </ul>
</div>

<div id = "show_bookmarks">
  <h1><?php echo __("All bookmarked reports"); ?></h1>
  <p>
    <?php echo __("Drag the reports to order them"); ?>
  </p>
  <br />
  <?php foreach ($groupedReports as $groupName => $reportGroup): ?>
<?php switch($groupName): ?>
<?php case 'artwork':?>
    <h2><?php echo __("Artwork reports"); ?></h2>
<?php break; ?>
<?php case 'user': ?>
    <h2><?php echo __("User reports"); ?></h2>
<?php break; ?>
<?php default: ?>
  <?php __('artwork'); ?>
    <h2><?php echo __("%report_type% reports", array("%report_type%" => ucfirst(__($groupName)))); ?></h2>
<?php break; ?>
<?php endswitch; ?>
    <ul id = "sort_<?php echo $groupName ?>">
      <?php foreach ($reportGroup as $report): ?>
        <li id = "report_<?php echo $report->getId(); ?>" class="linkpointer bottomborder">
          <h3><?php echo $report->getTitle(); ?></h3>
          <p><?php echo $report->getDescription(); ?></p>
        <span class = "float_right">
            <?php echo " [ ".content_tag("a", __("Stats") , array(
              "href" => url_for("@".$groupName."reports").$report->getArgs()."/commit/generate_report/report_type/1",
              "label"  => $report->getTitle()." stats"
            )); ?>
            <?php echo " | ".content_tag("a", __("List") , array(
              "href" => url_for("@".$groupName."reports").$report->getArgs()."/commit/generate_report/report_type/2",
              "label"  => $report->getTitle()." list"
              )); ?>
            <?php echo " | ".link_to_remote(__("Delete"), 
                  array('url' => '@deletereport?id='.$report->getId(),
                        'success' => "$('report_".$report->getId()."').hide();".visual_effect('highlight', 'sort_'.$groupName),
                         "confirm" => __("Delete '%report_title%'?", array("%report_title%" => $report->getTitle()))))." ]"; ?>
          </span>
        </li>
      <?php endforeach; ?>
    </ul>
    <?php echo sortable_element('sort_'.$groupName, array(
      'url'    => 'reports/updateBookmarkOrder',
      'success'  => visual_effect('highlight', 'sort_'.$groupName)
    )); ?>
  <?php endforeach; ?>
</div>
