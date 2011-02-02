<?php
/**
 * This template displays the report results for user activity queries
 * Requires parameter: $res
 *
 * PHP Version 5
 *
 * @author    Olepw <olepw@linpro.no>
 * @author    Russ Flynn <russ@linpro.no>
 * @copyright 2008 Linpro AS
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 *
 */

reaktor::setReaktorTitle(__('User activity reports'));
?>

<?php if (isset($res['query']) && count($res['query'])): ?>
  <ul>
    <?php foreach($res['query'] as $result): ?>
      <li><?php echo reaktor_link_to($result['username'], '@portfolio?user='.$result['username'])." ( ".$result['occurence']." )"; ?></li>
    <?php endforeach ?>
  </ul>
<?php endif ?>

<?php if (isset($res["graphData"])): ?>
  <?php include_component('reports', 'resultGraph', array('graphData' => $res['graphData'], 'dateData' => $res['dateData'])); ?>
<?php endif; ?>