<?php
/**
 * Component template to print image links of a users latest approved artworks. Used in portfolio and mypage. 
 * Example of use:
 * 
 * include_component('artwork','lastArtworksFromUser',array(
 *      'id' => $userid,
 *      'portfolio' => true,
 *      'user' => $user,
 *      'orderBy' => $orderBy,
 * ))
 *   
 * Component can pass:
 * $id        : The id of the user who owns the portfolio page
 * $user      : sfGuardUser object, (used to set title of page)
 * $portfolio : If set then this template is used in portfolio
 * $mypage    : If set then this template is used in mypage
 * $orderby   : What to order/filter by (title, date, rating or format)
 * 
 *
 * PHP version 5
 *
 * @author    June Henriksen <juneih@linpro.no>
 * @author    Hannes Magnusson <bjori@linpro.no>
 * @author    Daniel Andre Eikeland <dae@linpro.no>  
 * @author    Russell Flynn <russ@linpro.no>
 * 
 * @copyright 2008 Linpro
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 * 
 */

use_helper('PagerNavigation','home', 'content'); 
$artwork_count = count($last);
$counter       = 0;

?> 

<?php if (isset($portfolio)): //#############Portfoliopage ##############?>
  <?php if (!isset($mypage)): //Only the three first files should have big thumbnails?>
    <?php $bigartwork = array_splice($last, 0, 3); ?>
    <?php foreach($bigartwork as $artwork): ?>
      <?php ++$counter; ?>
      <?php $file = $artwork->getFirstFile(); ?>

      <div class='big_artwork'>
        <h2><?php echo $artwork->getShortTitle(sfConfig::get('app_artwork_teaser_len', 20)-15) ?></h2>
        <div class= 'big_thumbnail'>
          <?php echo link_to(image_tag(url_for('@content_thumb?id='.$file[0]->getReaktorFile()->getId().'&filename='.$file[0]->getReaktorFile()->getFilename()), array('size' => '240x160','alt' =>$artwork->getTitle())), 
                        $artwork->getLink()) ?>
        </div>
        <div class="score">
          <?php echo showScore($artwork->getAverageRating()) ?>
        </div>
      </div>
    <?php endforeach; ?>
  <?php endif; ?>
<?php endif; ?>

<?php if ($artwork_count > 0): //No artworks either in this filter, or at all..?> 
	
  <?php if (count($last) > 0): ?>
    <?php if(isset($mypage)): ?>
      <ul class='my_page_image_listing'>
    <?php else: ?>
      <ul class='portfolio_image_list'>
    <?php endif; ?>
  <?php endif ?>
  <?php foreach ($last as $artwork): //Go trough the artwork list and print thumbnails?>
    <?php $file = $artwork->getFirstFile(); ?>
    
    <?php if (isset($portfolio)): //#############Portfoliopage ##############?>
      
        <li class="clearnone floatleft smallrightpad">
        
        <?php echo showMiniThumb(new genericArtwork($artwork)) ?>
        </li>
      
    <?php else: //##########################Mypage#####################?>
      <?php $my_page_class = (($counter+1) != $artwork_count)?"class='mediumrightpad'":"class='end_image'"; ?>            
      <li <?php echo $my_page_class ?>>
        <?php echo showMiniThumb($artwork) ?>
      </li>
    <?php endif; ?>
    <?php $counter++ ?>
      
  <?php endforeach ?>
  <?php if (count($last) > 0): ?>
  </ul>
  <?php endif ?>
<?php else: ?>
	<?php $no_artwork_class = isset($portfolio) ? "user_image_list floatleft smallrightpad" : '' ?>   
	<p class="my_page_image_list <?php echo $no_artwork_class ?>">
	  <?php echo __('Sorry, no artworks.'); ?><br />
    <?php if ($viewingMyOwnPage): ?>
      <b><?php echo reaktor_link_to(__('Upload artwork now!'), '@upload_content') ?></b>
    <?php endif; ?>
	</p>
<?php endif; ?>

<?php if (isset($portfolio)): //Page through artwork list on portfioliopage?>
  <?php $order = ( $orderBy )?'&orderBy=' . $orderBy:""; ?>
  <?php echo "<br class='clearboth' />".pager_navigation($artworks, '@portfolio?user='.$user->getUsername() . $order) ?>   
<?php endif ?>


