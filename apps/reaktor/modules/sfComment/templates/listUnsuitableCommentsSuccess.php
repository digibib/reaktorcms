<?php
/**
 * Display list of unsuitable comments within a time period
 *
 * PHP version 5
 * 
 * @author    juneih <juneih@linpro.no>
 * @copyright 2008 Linpro
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 */

use_helper("PagerNavigation");
reaktor::setReaktorTitle(__('Unsuitable comments')); 

?>

<br />
<h1>
  <?php echo __('Unsuitable comments')?>
</h1>

<?php
/*
<ul class='month_links'>

	<li><?php echo link_to_if(isset($prev_month), __(date('F', strtotime($prev_month))), '@unsuitablecomments?date='.$prev_month)?></li>

	<li><h2><?php echo __(date('F', strtotime($date))) ?></h2></li>

	<li><?php echo link_to_if(isset($next_month),  __(date('F', strtotime($next_month))), '@unsuitablecomments?date='.$next_month)?></li>
</ul>
*/
?>
<br />
<?php echo pager_navigation($comment_pager, $route) ?>

<?php  include_partial('sfComment/commentList', array('comments' => $comments, "adminlist" => true, 'unsuitable'=>2, "comment_pager" => $comment_pager))?>

<?php echo pager_navigation($comment_pager, $route) ?>
