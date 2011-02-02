<?php
/**
 * The staff of Reaktor can recommend an artwork in a Subreaktor, or in a Subreaktor within a Lokalreaktor. 
 * This template displays the current recommended artwork depending on the template where this component is
 * used, typically the homepage, or a subreaktor frontpage. To include it in a template:
 * 
 * include_component("artwork","recommended");
 * 
 * This component is 'smart', when it is included in the filmreaktor template (filmReaktorSuccess.php) it will 
 * display the latest recommended film artwork. This default behavior is possible to override by passing an instance
 * of a suberaktor, or an ignore as the subreaktor and/or lokalreaktor parameter. The following example  will always 
 * display the latest recommended photo artwork in the entire reaktor, regardless of the template it's included in:  
 * 
 * include_component("artwork", "recommended", array('lokalreaktor' => 'ignore', 'subreaktor' => Subreaktor::getByReference('foto'));  
 * 
 * To display only the latest recommended photo artwork in groruddalen, use the above code, but leave out the lokalreaktor parameter.
 * 
 * To get an instance of a reaktor you use the following piece of code: Subreaktor::getByReference('foto'), where foto is the name
 * of the subreaktor. Other alteratives to foto are: tegning, film, lyd, tegneserier and tekst. To get an instance 
 * of a lokalreaktor the same piece of code is used, but the name of the lokalreaktor is used instead (groruddalen etc.).
 * 
 * The component's controller passes the following information:
 * 
 * $artwork - An artwork object 
 * 
 * PHP version 5
 *
 * @author    juneih <juneih@linpro.no>
 * @copyright 2008 Linpro
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 * 
 */
use_helper('home');
?>
<?php include_partial('feed/rssLink', array('description' => __('recommended artwork'), 'slug' => 'recommended_artwork')); ?>
<?php if (isset($artwork)): ?> 
 
  <div class="big_thumbnail">
    <?php
    $hash = spl_object_hash($artwork);
    $key = $hash."thumb".Subreaktor::getProvidedSubreaktorReference().Subreaktor::getProvidedLokalReference();
    $cache = reaktorCache::singleton($key);
    if (!($retval = $cache->get())):
      $retval = reaktor_link_to(image_tag(contentPath($artwork, "thumb"),
                               "alt='".$artwork->getTitle()."' title='".$artwork->getTitle()."'"." size=240x160"), 
                               "@show_artwork?id=".$artwork->getId()."&title=".$artwork->getTitle());
      $cache->set($retval);
    endif;
    echo $retval;
    ?>
  </div>
  
  <div class="artwork_link">
    
    <?php $tmp_artwork_title = reaktor_link_to($artwork->getShortTitle(), 
                                       '@show_artwork?id='.$artwork->getId().'&title='.$artwork->getTitle()); ?> 
    <?php $tmp_username      = reaktor_link_to($artwork->getUser()->getUsername(), 
                               '@portfolio?user='.$artwork->getUser()->getUsername()); ?>
    <?php if(!$artwork->isMultiUser()): ?>
      <?php echo __('%artwork_title% by %username%', array('%artwork_title%' => $tmp_artwork_title . '<br />', 
                                                           '%username%' => $tmp_username)); ?>
    <?php else: ?>
      <?php echo $tmp_artwork_title; ?>
    <?php endif; ?>
 
  </div>  
  <div class="score"><?php echo showScore($artwork->getAverageRating()); ?></div>
<?php else: //no artwork has been recommended, display default?>

  <div class='big_thumbnail'>
    <?php echo image_tag('old_default.gif', 'size=240x160') ?>
  </div>
  <div>       
    <?php echo __('No artwork has been recommended.') ?> 
    <br />
    <?php echo __('Reaktor staff will fix this shortly..') ?>
  </div>
 
<?php endif ?>
