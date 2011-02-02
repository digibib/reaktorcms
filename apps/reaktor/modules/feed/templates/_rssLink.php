<?php
/**
 * Display rss Image and correct link in any positioned element
 * Default positioning is inside top right, but a custom class can be passed to this partial if desired
 * This partial should always be used when adding the Orange RSS icon on the page for a specific list, as it
 * automatically handles the RSS headers in the browser, and show/hide link in the footer menu.
 * 
 * When mousing over a "feed block", which is the element containing this partial, the "rss_hover" class will be temporarily
 * applied. By default, this gives the element (normally a list) a light yellow background to indicate which list
 * the feed icon is related to.
 * 
 * Arguments that can be passed to this template:
 * 
 * - $class       : The css class to use, if not set then "rss_link_top_tight" is used
 * - $route       : The route from routing.yml that will be used in the feed link, if not set "artworkfeed" is used
 * - $description : Adds text to the tooltip following - "Subscribe to ". If not set, "this list" is used
 * - $url         : If set, is used instead of route (supply a relative url with a leading slash) for the feed url
 * - $caption     : If set, this text will appear before the orange RSS icon
 * - $slug        : The unique identifier for this feed, which relates to the action and appears in the feed url
 *
 * PHP Version 5
 *
 * @author    Russ <russ@linpro.no>
 * @copyright 2008 Linpro AS
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 *
 */

$class       = isset($class) ? $class : 'rss_link_top_right';
$route       = isset($route) ? $route : 'artworkfeed';
$description = isset($description) ? $description   : __('this list');
$url         = isset($url)   ? $url   : null;
$caption     = isset($caption) ? $caption : '';
$route       .= strpos($route, "?") !== false ? "&slug=$slug" : "?slug=$slug";

$tip         = '<div class = \"tool_tip_internal\">'.__('Subscribe to %rss_description%', array('%rss_description%' => $description)).'</div>';

$rss_headers                 = $sf_request->getAttribute('rss_head_meta', array());
$rss_headers[$slug]['title'] = $description;
$newId                       = md5(microtime().$class.$route);

use_helper("Javascript");

?>
<div id = 'id_<?php echo $newId ?>' class='<?php echo $class; ?> rss_link' style='display: none'>
  <?php if ($url): ?>
    <?php echo content_tag("a", $caption.' '.image_tag("RSSfeed.png"), 
          array("href" => "/" . $sf_user->getCulture() . $url, 
                'onmouseover' => 'Tip("'.$tip.'"); $(this).up("div", 1).addClassName("rss_hover"); ', 
                'onmouseout' => 'UnTip(); $(this).up("div", 1).removeClassName("rss_hover");'));
                $rss_headers[$slug]['url']   = 'http://'.$sf_request->getHost().'/'.$sf_user->getCulture().$url;  ?>
  <?php else: ?>
    <?php echo reaktor_link_to($caption.' '.image_tag('RSSfeed.png'), '@'.$route, 
          array('onmouseover' => 'Tip("'.$tip.'"); $(this).up("div", 1).addClassName("rss_hover");', 
                'onmouseout' => 'UnTip(); $(this).up("div", 1).removeClassName("rss_hover");')); 
                $rss_headers[$slug]['url']   = reaktor_url_for('@'.$route, true);
           ?>
  <?php endif ?>
</div>

<?php $sf_request->setAttribute('rss_head_meta', $rss_headers); ?>

<?php echo javascript_tag("
  if (!rss_links) {
  	var rss_links = ['".$newId."'];
  }
 	else {
 		rss_links.push('".$newId."');
 	}
"); ?>