<?php
/**
 * Bottom menu partial included in home/index 
 * This partial includes links to the articles that are marked as type "footer article", or traditionally "about reaktor"
 * for example: about, help, privacy, contact, etc. The links to RSS feeds are also shown on the right side.
 * 
 * PHP version 5
 *
 * @author    juneih <juneih@linpro.no>
 * @copyright 2008 Linpro
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 * 
 */

use_helper('Javascript');
?>

<div class='footer_left_links'>
  <?php include_partial('articles/articleList', array('articles' => ArticlePeer::getByFieldAndOrType(ArticlePeer::FOOTER_ARTICLE, 'date', null, null, ArticlePeer::PUBLISHED), 'mode' => 'footer')); ?>
  <?php /*echo link_to(__('Help'), '@home'); ?>
  <?php echo link_to(__('About Reaktor'), '@home'); ?>
  <?php echo link_to(__('Contact'), '@home'); */?>
</div>
<div class='footer_right_links'>     
  <span id="rss_toggle_wrap">
    <?php echo link_to_function(image_tag('RSSfeed.png').' <span id="rss_toggle">'.__("Show page feeds")."</span>", 'showHideRss("'.__("Show page feeds").'", "'.__("Hide page feeds").'");'); ?>
  </span>
  <span>
    <?php echo " / "; ?>
    <?php echo reaktor_link_to(__("Common feeds"), "@feedindex"); ?>
  </span>
</div>
  
<?php //we need the clear fix so the bottom_line will respect the floats ?> 
<br class = "clearboth" />

<?php
// Alternative link set by Javascript if no rss feeds are found on the page
echo javascript_tag('
  if (checkForRss() == false) { 
    $("rss_toggle_wrap").innerHTML="'.addslashes(image_tag('RSSfeedGrey.png')).' '.__('Page feeds').'"; }
'); ?>
