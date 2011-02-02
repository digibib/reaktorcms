<?php
/**
 * Links to Facebook, digg etc
 *
 * PHP Version 5
 *
 * @author    Russ <russ@linpro.no>
 * @copyright 2008 Linpro AS
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 *
 */

use_helper("content");

$linkUrl = 'http://'.$sf_request->getHost().url_for($artwork->getLink());
$title   = $artwork->getTitle();
?>

<div id="socialBookmarks"> 
<h3><?php echo __("Share this artwork")?></h3> 
  <ul>
    <li class = "delicious"> 
      <?php echo link_to_function('Delicious', 'shareDelicious(\''.$linkUrl.'\', \''.$title.'\')', array("title" => __("Post this to Delicious"))); ?>  
    </li>
    <li class="digg"> 
      <?php echo link_to_function('Digg', 'shareDigg(\''.$linkUrl.'\', \''.$title.'\')', array("title" => __("Post this to Digg"))); ?> 
    </li>
    <li class="reddit"> 
      <?php echo link_to_function('Reddit', 'shareReddit(\''.$linkUrl.'\', \''.$title.'\')', array("title" => __("Post this to Reddit"))); ?>
    </li>
    <li class="facebook"> 
      <?php echo link_to_function('Facebook', 'shareFacebook(\''.$linkUrl.'\', \''.$title.'\')', array("title" => __("Post this to Facebook"))); ?>
    </li>
  </ul>
  <ul>
    <li class="stumbleupon"> 
      <?php echo link_to_function('Stumbleupon', 'shareStumbleupon(\''.$linkUrl.'\', \''.$title.'\')', array("title" => __("Post this to Stumbleupon"))); ?>
    </li>
    <li class="nettby"> 
      <?php echo link_to_function('Nettby', 'shareNettby(\''.$linkUrl.'\', \''.$title.'\')', array("title" => __("Post this to Nettby"))); ?>
    </li>
    <li class="print"> 
      <?php echo link_to_function(__('Print'), 'window.print()', array("title" => __("Show this artwork in print preview"))); ?>
    </li>
  </ul>
  <?php if ($artwork->canEmbed()): ?>
    <div id="embed_links"><br />
      <?php include_component('artwork', 'embedLink', array('file' => $thefile, 'artwork' => $artwork)); ?>
    </div>
  <?php endif; ?>
  
</div>

