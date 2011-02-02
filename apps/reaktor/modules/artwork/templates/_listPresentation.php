<?php
/**
 * One of the important ways of achieving a dynamic site, includes having lists like these
 * which are continously updated. This component template lists a reaktors latest
 * approved artworks. To include this 
 * component, see the example below:
 * 
 *  include_component('artwork','lastArtworks', array(
 *   'image'         => 'mini',
 *   'limit'         => 6, 
 *   'subreaktor'    => $subreaktor, 
 *   'lokalreaktor'  => $lokalreaktor,
 *   'random'        => true,    
 *   'exclude_first' => 1))
 * 
 * None of these parameters are required. The default limit is retrieved from configuration,
 * exclude_first will exclude the n latest artworks from the list (say you've displayed the 
 * latest artwork as a thumbnail on top of the page, and you want a list of smaller thumbnails
 * on a different part of the page, you don't want the latest artwork to be displayed again, so 
 * exclude_first = 1). If $image (thumb|subreaktorthumb|mini) isn't passed then text is 
 * used(??). $subreaktor and $lokalreaktor are only needed if they should display something 
 * from a different reaktor than the site belongs to. For instance, on the frontpage of 
 * groruddalenreaktor, you might want to show a list of the most popular reaktors in foto:
 * 
 * include_component('artwork', 'lastArtworks', array('subreaktor' => 'foto')
 * 
 * The information passed from the controller are the following:
 * - $artworks : If not passed from a lokalreaktor: An array of artwork objects
 * - $artworks : If passed from a lokalreaktor: An array with:
 *                                          'last' => an array of artworks, 
 *                                          'subreaktor' = the subreaktor object for the subreaktor it was passed from
 * 
 * The image type "subreaktorthumb" and "subreaktorlist" can only be called from a lokalreaktor 
 * frontpage. This is used when this list is called more than once on the same page, to make sure 
 * the same image doesn't appear more than once.
 * 
 * PHP version 5
 *
 * @author    Daniel Andre Eikeland <dae@linpro.no>
 * @author    Hannes Magnusson <bjori@linpro.no>
 * @author    June Henriksen <juneih@linpro.no>
 * @copyright 2008 Linpro
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 * 
 */

use_helper('content');

// Generate the RSS links for everything except for subreaktlists, those are 
// dealt with later in this file
if (!isset($image) || (isset($image) && $image != "subreaktorlist")) 
{
  include_partial('feed/rssLink', array('description' => $feed_description, 'slug' => $feed_slug));
}
?>
<?php if (isset($image) && $image != '') : // Display list with images?>
  <?php if ($image == 'thumb') : // Display big thumbnails, with title and score?>
    <?php if(count($artworks) > 0): ?>
      <?php foreach ($artworks as $artwork):?>
      	<?php if ($artwork instanceof genericArtwork): ?>
          <?php $file = $artwork->getFirstFile(); ?>
          <div class='big_thumbnail'>
            <?php echo reaktor_link_to(image_tag(url_for('@content_thumb?id='.$file->getId().'&filename='.$file->getFilename()), 
                                                 'size=240x160 alt="'.$artwork->getTitle().'" title="'.$artwork->getTitle().'"'), 
                                       $artwork->getLink()); ?>
            </div>
            <div class="artwork_link">
              <?php $tmp_artwork_title = reaktor_link_to($artwork->getShortTitle(), 
                                         '@show_artwork?id='.$artwork->getId().'&title='.$artwork->getTitle()); ?> 
              <?php $tmp_username = reaktor_link_to($artwork->getUser()->getUsername(), 
                                         '@portfolio?user='.$artwork->getUser()->getUsername()); ?>
              <?php if(!$artwork->isMultiUser()): ?>
  	            <?php echo __('%artwork_title% by %username%', array('%artwork_title%' => $tmp_artwork_title . '<br />', 
                                                                   '%username%' => $tmp_username)); ?>
              <?php else: ?>
                <?php echo $tmp_artwork_title; ?>
              <?php endif; ?>
              
            </div>
            <div class="score"><?php echo showScore($artwork->getAverageRating()); ?></div>
        <?php endif; ?>
      <?php endforeach ?>
    <?php else: // no artworks - display default, empty placeholder image ?>
      <div class='big_thumbnail'>
        <?php echo image_tag('old_default.gif', 'size=240x160'); ?>
      </div>
      <div>
        <?php echo __('No artworks published yet.'); ?>
        <br />
        <?php echo __('Maybe you can be the first one?'); ?>
      </div>
    <?php endif ?>
  <?php elseif ($image == 'subreaktorthumb') : // Display big thumbnails, with title and score ?>
    <?php if(count($artworks['last']) > 0): ?>
      <?php foreach ($artworks['last'] as $artwork):?>
      	<?php if ($artwork instanceof genericArtwork): ?>
          <div class="big_artwork">
            <?php $file = $artwork->getFirstFile(); ?>
            <div class='big_thumbnail'>
              <?php echo reaktor_link_to(image_tag(url_for('@content_thumb?id='.$file->getId().
                                                           '&filename='.$file->getFilename()), 
                                                   'size=240x160 alt="'.$artwork->getTitle().'" title="'.$artwork->getTitle().'"'), 
                                         $artwork->getLink()); ?>
            </div>
            <div  class="artwork_link">       
              <?php $tmp_artwork_title = reaktor_link_to($artwork->getShortTitle(), 
                                         '@show_artwork?id='.$artwork->getId().'&title='.$artwork->getTitle()); ?> 
              <?php $tmp_username      = reaktor_link_to($artwork->getUser()->getUsername(), 
                                         '@portfolio?user='.$artwork->getUser()->getUsername()); ?>
              <?php echo __('%artwork_title% by %username%', array('%artwork_title%' => $tmp_artwork_title . '<br />', 
                                                                   '%username%' => $tmp_username)); ?>
            </div>
          </div>
        <?php endif; ?>
      <?php endforeach ?>
    <?php else: // no artworks - display default, empty placeholder image ?>
      <div class='big_thumbnail'>
        <?php echo image_tag('old_default.gif', 'size=240x160'); ?>
      </div>
      <div>       
        <?php echo __('No artworks published yet.'); ?>
        <br />
        <?php echo __('Maybe you can be the first one?'); ?>
      </div>
    <?php endif ?>
  <?php elseif ($image == 'subreaktorlist') : // Display text list ?>
    <div class="relative">
	    <h2><?php echo __('Latest in %subReaktor_name%', array('%subReaktor_name%' => $artworks['subreaktor']->getName())); ?></h2>
	    <?php include_partial('feed/rssLink', array('description' => __($artworks['subreaktor']->getName()),
															                    'slug' => $feed_slug,
															                    'url' => '/' . (($lokalreaktor) ? $lokalreaktor->getReference() . '-' : '') . $subreaktor->getReference() . '/feed/' . $feed_slug) //latest_artworks")
	                          ); ?>
	    <ul>
	    <?php if(count($artworks['last']) > 0): ?>
	      <?php foreach ($artworks['last'] as $artwork):?>
	        <?php if ($artwork instanceof genericArtwork): ?>
	          <li class="subcategorylist">
	          <?php $tmp_artwork_title = reaktor_link_to($artwork->getShortTitle(), $artwork->getLink()) ?>
            <?php $tmp_username = reaktor_link_to($artwork->getUser()->getUsername(), '@portfolio?user='.$artwork->getUser()->getUsername()) ?>
	          <?php echo __('%artwork_title% by %username%', array('%artwork_title%' => $tmp_artwork_title,
	                                                               '%username%' => $tmp_username)) ?>
            <br />
	          <?php if (count($artwork->getCategories()) > 0): ?>
		          <?php $tmp_category_list = array(); ?>
		          <?php foreach($artwork->getCategories() as $category): ?>
		            <?php $tmp_category_list[] = reaktor_link_to(ucfirst($category), '@findcategory?category='.$category); ?>
		          <?php endforeach; ?>
              <?php $tmp_category_list = join(', ', array_slice($tmp_category_list, 0, sfConfig::get("app_category_max_count_on_reaktors", 4))); ?>
              <b class='green'><?php echo __('Categories').':'?></b>
              <?php echo $tmp_category_list?>
	          <?php endif; ?>
	          </li>
	        <?php endif; ?>
	      <?php endforeach ?>
	    <?php else: // no artworks, display default placeholder text ?>
	      <li class="subcategorylist"><?php echo __('There are no published artworks in this subReaktor'); ?></li>
	    <?php endif ?>
	    </ul>
    </div>
  <?php else: // Display mini thumbnails ?>
	  <?php if (count($artworks) > 0): ?>
	    <ul class='my_page_image_list' id="minithumbs">
	      <?php foreach ($artworks as $artwork): ?>
	        <li class='floatleft smallrightpad clearnone'><?php echo showMiniThumb($artwork); ?></li>
	      <?php endforeach ?>
	    </ul>
	  <?php endif ?>
  <?php endif ?>
<?php else: // if $image is not set, display text list of artworks ?>
  <ul>
  <?php if (count($artworks) > 0): // There are artworks?> 
    <?php $li_class = (isset($tags) && $tags != '') ? 'artwork_list_with_tags' : ''; ?>
    <?php foreach ($artworks as $artwork): ?>
      <?php if ($artwork instanceof genericArtwork): ?>
        <li class="<?php echo $li_class; ?>">
          <?php $tmp_artwork_title = reaktor_link_to($artwork->getShortTitle(), $artwork->getLink()); ?>
          <?php if (isset($show_username) && $show_username): //Print artwork title username ?>
          
              <?php $tmp_username      = reaktor_link_to($artwork->getUser()->getUsername(), 
                                         '@portfolio?user='.$artwork->getUser()->getUsername()); ?>
              <?php echo __('%artwork_title% by %username%', array('%artwork_title%' => $tmp_artwork_title, 
                                                                   '%username%'      => $tmp_username)); ?>
          <?php else: //print artwork title alone?>
             <?php echo __($tmp_artwork_title )?> <br /> 
          <?php endif; ?>
          <?php if ($li_class != ''):?>
            <br /> 
            <?php $tmp_category_list = array(); ?>
            <b class='green'><?php echo __('Categories').':' ?></b>
            <?php foreach($artwork->getCategories() as $category):?>
               <?php $tmp_category_list[] = reaktor_link_to(ucfirst($category), '@findcategory?category='.$category); ?>
            <?php endforeach; ?>
            <?php echo join(', ', array_slice($tmp_category_list, 0, sfConfig::get("app_category_max_count_on_reaktors", 4))); ?>
          <?php endif; ?>
        </li>
      <?php endif; ?>
    <?php endforeach; ?>
  <?php else: // no artworks, display default placeholder text ?>
    <li><?php echo __('There are no published artworks in this subReaktor'); ?></li>
  <?php endif; ?>
  </ul>
<?php endif; ?>
