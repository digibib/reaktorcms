<?php
/**
 * Graphs for reports
 * Requires parameters: $graphData, $dateData
 *
 * PHP Version 5
 *
 * @author    Olepw <olepw@linpro.no>
 * @author    Russ Flynn <russ@linpro.no>
 * @copyright 2008 Linpro AS
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 *
 */

?>

<?php if (isset($graphData) && count($graphData)): ?>
  <?php 
  $min =  min($graphData);
  $max =  max($graphData);
  $count = 0;
  ?>
  <div class="report_graph">
    <h2><?php echo __("Result graph:"); ?></h2>
    <ul>
      <?php foreach ($graphData as $key => $data): ?>
        <li class="report_bar" style="height:<?php echo (($data / $max) * 200) ?>px; left:<?php echo (65 * $count) ?>px;">
          <?php echo ($data)?$data."<br />":"&nbsp;" ?>
          <?php echo ($data)?date("d-m-Y",$dateData[$key]['start'])."<br />".__('to')."<br />":"" ?>
          <?php echo ($data)?date("d-m-Y",$dateData[$key]['end'])."<br />":"" ?>
        </li>
        <?php $count++; ?>
      <?php endforeach ?>
    </ul>
  </div>
<?php endif ?>
