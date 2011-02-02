<?php
/**
 * This needs to be outside the containing <div> so it can be updated via an ajax call
 *
 * PHP Version 5
 *
 * @author    Russ <russ@linpro.no>
 * @copyright 2008 Linpro AS
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 *
 */
?>

<h1><?php echo __("My Artworks"); ?></h1>

<h2><?php echo reaktor_link_to(__("View all artwork (%count%)", array("%count%" => $total)), $route."?mode=allartwork&user=".$thisUser->getUsername()); ?></h2>	
                          
<?php if (isset($artworkCount[3])): ?>
<h2><?php echo reaktor_link_to(__("Approved (%count%)", array("%count%" => array_sum($artworkCount[3]))), $route."?mode=allapproved&user=".$thisUser->getUsername()); ?></h2>
	<ul class = "indentli">
	  <?php foreach($artworkCount[3] as $year => $count): ?>
		  <li><?php echo reaktor_link_to($year." (".$count.")", $route."_filtered?mode=allapproved&year=".$year."&user=".$thisUser->getUsername()); ?></li>
		<?php endforeach; ?>
	</ul>
<?php endif; ?>

<?php if (isset($artworkCount[2])): ?>
	<h2><?php echo reaktor_link_to(__("Awaiting approval (%count%)", array("%count%" => array_sum($artworkCount[2]))), $route."?mode=submittedartwork&user=".$thisUser->getUsername()); ?></h2>
<?php endif; ?>

<?php if (isset($artworkCount[1])): ?>
	<h2><?php echo reaktor_link_to(__("Drafts (%count%)", array("%count%" => array_sum($artworkCount[1]))), $route."?mode=draftartwork&user=".$thisUser->getUsername()); ?></h2>
<?php endif; ?>

<?php if (isset($artworkCount[4])): ?>
	<h2><?php echo reaktor_link_to(__("Rejected (%count%)", array("%count%" => array_sum($artworkCount[4]))), $route."?mode=allrejected&user=".$thisUser->getUsername()); ?></h2>
<?php endif; ?>

<?php if (isset($artworkCount[5]) && $sf_user->hasCredential("viewallcontent")): ?>
	<h2><?php echo reaktor_link_to(__("Removed (%count%)", array("%count%" => array_sum($artworkCount[5]))), $route."?mode=allremoved&user=".$thisUser->getUsername()); ?></h2>
<?php endif; ?>

<br />
<br />
<h1><?php echo __("My files"); ?></h1>

<?php if ($fileCount): ?>
	<h2><?php echo reaktor_link_to(__("All files (%count%)", 
                      array("%count%" => $fileCount)), $route."?mode=allfiles&user=".$thisUser->getUsername()); ?></h2>
  
  <h2><?php echo reaktor_link_to(__("Unused files (%count%)", 
                     array("%count%" => $unusedCount)), $route."?mode=orphanedfiles&user=".$thisUser->getUsername()); ?></h2>
<?php endif; ?>
<?php if ($unsuitableCount): ?>
  <h2><?php echo reaktor_link_to(__("Unsuitable files (%count%)", 
                     array("%count%" => $unsuitableCount)), $route."?mode=unsuitablefiles&user=".$thisUser->getUsername()); ?></h2>
<?php endif; ?>

<?php if ($total == 0): ?>
	<div id="sidebar_no_artworks">
		<?php if ($thisUser->getId() == $sf_user->getId()): ?>
      <?php echo __("You do not have any artwork");?>
  		<br /><br />
  		<?php echo reaktor_link_to(__("Upload artwork now!"), "@upload_content"); ?>
  	<?php else: ?>
  		<?php echo __("This user has no artwork"); ?>
  	<?php endif; ?>
	</div>
<?php endif; ?>