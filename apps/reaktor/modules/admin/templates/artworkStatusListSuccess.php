<?php
/**
 * 
 * PHP Version 5
 *
 * @author    Ole-Peter Wikene <olepw@linpro.no>
 * @author    Russ <russ@linpro.no>
 * @copyright 2008 Linpro AS
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 *
 */

?>

<?php sfContext::getInstance()->getResponse()->setTitle(__('Reaktor - Admin - List artworks')); ?>
<h1><?php echo __('Artwork status list') ?></h1>

<table>
<thead>
<tr>
  <th><?php echo __('Description') ?></th>
  <th><?php echo __('Actions') ?></th>
</tr>
</thead>
<tbody>
<?php foreach ($artwork_statuses as $artwork_status): ?>
<tr>
      <td style="padding-right: 10px;"><?php echo $artwork_status->getDescription() ?></td>
      <td><?php echo link_to(__('Edit'), 'admin/artworkStatusEdit?id='.$artwork_status->getId()) ?></td>
  </tr>
<?php endforeach; ?>
</tbody>
</table>
