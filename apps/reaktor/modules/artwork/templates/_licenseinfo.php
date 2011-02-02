<?php
/**
 * When viewing an artwork it should be possible to easily find out which license it has. This template displays 
 * the license according to the file given as a parameter. This is included in the artwork show template. Example of use:
 * 
 * include_partial("licenseinfo", array('thefile' => $thefile))
 * 
 * $file : ReaktorFile object. 
 *  
 * PHP version 5
 * 
 * @author    Daniel Andre Eikeland <dae@linpro.no>
 * @copyright 2008 Linpro AS
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 */
?>
<?php $license = $thefile->getLicense(); ?>

<h4><?php echo __('Copyright') ?></h4>
<?php 
    
switch ($license)
{
  case "free_use":
    echo __("The author of this artwork allows all other Reactor users to freely copy this artwork"); 
    break;
  case "non_commercial":
    echo __("The author of this artwork allows all other Reactor users to freely copy this artwork for educational or non-commercial use"); 
    break;
  case "contact":
  case "":
  case NULL:
    echo __("Please contact %the_author% if you want to use or copy this artwork in any way", array("%the_author%" => link_to(__('the author'), '@portfolio?user=' . $thefile->getUser()->getUsername())));
    break;
  case "no_allow":
    echo __("The author of this artwork does not allow any use of this artwork outside private use");
    break;
  default:
  	?>
	  <p style="margin-top: 0px;">
	    <a rel="license" href="http://creativecommons.org/licenses/<?php echo $license ?>/3.0/no">
	      <img alt="Creative Commons License" style="border-width:0" 
	        src="http://i.creativecommons.org/l/<?php echo $license ?>/3.0/no/80x15.png" width="80px" height="15px" />
	    </a>
	    <br />
  	  <?php echo __("Dette verket er lisensiert under et %licensenavn%", array(" %licensenavn%" => "")) ?>
	    <a rel="license" href="http://creativecommons.org/licenses/<?php echo $license ?>/3.0/no/">Creative Commons 3.0 Norway lisens</a>.
	  </p>
    <?php
    break;
}  
?>