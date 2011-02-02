<?php
/**
 * Present a list of common/popular RSS Feeds which will be displayed when the user clicks the link in the footer menu.
 * Lokal reaktor is automagically added to the route, not normal subreaktors as 
 * they are already looped through.
 * To add feeds to the page, you simply need
 * to add items to the array below this comment block, following the examples.
 * 
 * The slugs are the identifiers that point to the action that will control how the feed is rendered. Refer to the documentation
 * for a list of slugs, or check the switch($slug) block in feed/actions.class.php for a list of available slugs.
 * The routes refer to the routing.yml file, and will generally be "artworkfeed" or "articlefeed".
 * The descriptions will be the actual link text on the page, and also in the browser RSS headers. 
 *
 * PHP Version 5
 *
 * @author    Russ <russ@linpro.no>
 * @copyright 2008 Linpro AS
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 *
 */

$feeds = array(
  array("route" => "artworkfeed", "slug" => "latest_artworks" , "description" => __("Recently approved artwork")),
  array("route" => "artworkfeed", "slug" => "most_popular"    , "description" => __("Most popular")),
  //array("route" => "artworkfeed", "slug" => "latest_users"    , "description" => __("Latest registered users")),
  array("route" => "artworkfeed", "slug" => "latest_commented", "description" => __("Latest commented artwork")),
  array("route" => "artworkfeed", "slug" => "recommended_artwork" , "description" => __("Recommended artwork"))
);
?>
<h1>
<?php
if ($lokal = Subreaktor::getProvidedLokalreaktor())
{
  $lokal = $lokal->getReference() . "-";
  echo __("Subscribe to Reaktor RSS feeds in %LokalReaktor%", array("%LokalReaktor%" => Subreaktor::getProvidedLokalreaktor()->getName()));
}
else
{
  echo __("Subscribe to Reaktor RSS feeds");
}
?>
</h1>

<br />
<?php foreach(Subreaktor::getAll() as $subreaktor): ?>
  <?php if ($subreaktor->isLokalReaktor()) continue; ?>
  <?php if (!$subreaktor->getLive()) continue; ?>
  <h2><?php echo $subreaktor; ?></h2>
  <ul class = "rss_list">
  <?php foreach ($feeds as $feed): ?>
    <?php $route = "@subreaktor".$feed['route']."?slug=".$feed['slug']."&subreaktor=$lokal" .$subreaktor->getReference(); ?>
    <li><?php echo link_to($feed['description'], $route); ?></li>
    <?php $rss_headers[$feed['slug']]['url']   = url_for($route, true); ?>
    <?php $rss_headers[$feed['slug']]['title'] = $feed['description']; ?>
  <?php endforeach; ?>
  </ul>
<?php endforeach; ?>

<?php $sf_request->setAttribute('rss_head_meta', $rss_headers); ?>

