<?php
/**
 * Display list of comments within a time period
 *
 * PHP version 5
 *
 * @author juneih <juneih@linpro.no>
 * @copyright 2008 Linpro
 * @license http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 */

use_helper('PagerNavigation');
reaktor::setReaktorTitle(__('List comments')); 

?>

<br />
<h2>
<?php  ?>

<?php if (isset($date)): ?>
  <?php echo __('Comments made on ').$date ?> ( <?php echo link_to(__("change date"), "@commentscalendar"); ?> )
<?php elseif ($sf_params->get('user_id')): ?>
  <?php echo __('Comments made by ').$thisUser ; ?>
<?php endif; ?>
</h2>
<br />
<?php echo pager_navigation($comment_pager, $route) ?>
<br />
<?php  include_partial('sfComment/commentList', array('comments' => $comments, "adminlist" => true, 'unsuitable' => $unsuitable, 'namespace' => $namespace))?>

<br />
<?php echo pager_navigation($comment_pager, $route) ?>