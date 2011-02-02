<?php
/**
 * For easier administration of reported comments this template displays a list of reported or unsuitable comments, within 
 * a time period of a month. 
 * 
 * The controller passes the following information:
 * $namespace     - Which namespace are the comments in, either frontend or administrator
 * $comments      - An array of comments 
 * $date          - The date requested
 * $prev_month    - Previous month from requested date
 * $next_month    - Next month from requested date
 * $comment_pager - The pager
 * $route         - 
 *
 * PHP version 5
 * 
 * @author    juneih <juneih@linpro.no>
 * @copyright 2008 Linpro
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 */

use_helper('PagerNavigation');
reaktor::setReaktorTitle(__('List reported comments')); 

?>

<br />
<h1>
  <?php echo __('Reported comments')?>
</h1>
<br />
<?php echo pager_navigation($comment_pager, $route) ?>

<?php  include_partial('sfComment/commentList', array(
  'comments'      => $comments, 
  "adminlist"     => true, 
  'unsuitable'    => 1, 
  "overview"      => true,
  "comment_pager" => $comment_pager))?>

<?php echo pager_navigation($comment_pager, $route) ?>
