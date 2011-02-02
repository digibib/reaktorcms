<?php
/**
 * This template displays the report results for user queries
 * Requires parameter: $resultset
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

<div class="user_report_result" id="result_div">
  <?php if ($sf_params->get("report_type") == 1): ?>
    <?php echo __('Number of hits') ?>: <?php echo count($resultset['query']) ?>
  <?php else: ?>
    <?php foreach ($resultset['query'] as $res): ?>
      <?php echo reaktor_link_to($res->getUsername(),'@portfolio?user='.$res->getUsername()) ?><br />
    <?php endforeach?>
  <?php endif ?>
  <?php if (isset($resultset['graphData'])): ?>
    <?php include_component('reports', 'resultGraph',array('graphData' => $resultset['graphData'], 'dateData' => $resultset['dateData'])); ?>
  <?php endif; ?>  
</div>