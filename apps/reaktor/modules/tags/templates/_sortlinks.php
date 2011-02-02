<?php
/**
 * Sort tag results
 * 
 * This partial is used on the tag find (search results) page to sort the results
 * - $mode          : "tag" or "category" depending on the type of results we are sorting
 * - $sortmode      : "date", "title", "username" or "rating" - the sort option that has been clicked
 * - $sortdirection : "asc" or "desc" - the sort direction that has been applied
 * - $tags          : The original search parameters (tags we are searching for) - only useful when $mode = "tag"
 * - $categories    : The original search parameters (categories we are searching for) - only useful when $mode = "category"
 * - $results       : The result set which we can use to inspect and decide whether to show certain links  
 * 
 * PHP version 5
 * 
 * @author    Daniel Andre Eikeland <dae@linpro.no>
 * @author    Russ Flynn <russ@linpro.no>
 * @copyright 2008 Linpro AS
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 */

  $sortdirection_date = ($sortmode == 'date') ? (($sortdirection == 'asc') ? 'desc' : 'asc') : 'desc';
  $sortdirection_title = ($sortmode == 'title') ? (($sortdirection == 'asc') ? 'desc' : 'asc') : 'asc';
  $sortdirection_rating = ($sortmode == 'rating') ? (($sortdirection == 'asc') ? 'desc' : 'asc') : 'desc';
  $sortdirection_username = ($sortmode == 'username') ? (($sortdirection == 'asc') ? 'desc' : 'asc') : 'asc';
  
  if (isset($tags) && is_array($tags))
  {
    $tags = implode(",", $tags);
  }

  $route = ($mode == 'tag') ? '@findtags?tag='.$tags : '@findcategory?category='.$categories;
  
?>
<div id="tagresultsortlinks"><b><?php echo __('Sort results by:'); ?>&nbsp;</b>
  <span class="<?php if ($sortmode == 'date') echo 'selected'; ?>"><?php echo reaktor_link_to(__('%sort_results_by% date', array('%sort_results_by% ' => '')), $route.'&sortby=date&sortdirection='.$sortdirection_date); ?><?php if ($sortmode == 'date') echo image_tag('sort_' . $sortdirection . '.png'); ?></span> 
  | <span class="<?php if ($sortmode == 'title') echo 'selected'; ?>"><?php echo reaktor_link_to(__('%sort_results_by% title', array('%sort_results_by% ' => '')), $route.'&sortby=title&sortdirection='.$sortdirection_title); ?><?php if ($sortmode == 'title') echo image_tag('sort_' . $sortdirection . '.png'); ?></span> 
  <?php if (isset($results["genericArtwork"])): ?>
    | <span class="<?php if ($sortmode == 'rating') echo 'selected'; ?>"><?php echo reaktor_link_to(__('%sort_results_by% rating', array('%sort_results_by% ' => '')), $route.'&sortby=rating&sortdirection='.$sortdirection_rating); ?><?php if ($sortmode == 'rating') echo image_tag('sort_' . $sortdirection . '.png'); ?></span> 
    | <span class="<?php if ($sortmode == 'username') echo 'selected'; ?>"><?php echo reaktor_link_to(__('%sort_results_by% username', array('%sort_results_by% ' => '')), $route.'&sortby=username&sortdirection='.$sortdirection_username); ?><?php if ($sortmode == 'username') echo image_tag('sort_' . $sortdirection . '.png'); ?></span>
  <?php endif; ?>
</div>
