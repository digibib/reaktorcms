<?php
/**
 * Template for managing user content, either by the user or an admin user
 * Users have access to all their uplaoded files, artworks and whether things are approved, awaiting approval etc.
 * 
 * Variables available to this template provided by the action:
 * - $thisUser             : The user object of the owner of this work - either the logged in user or if in admin mode could be a different user
 * - $route                : The route to use for the various modes, will change based on if whether we are admin or not editing this user content 
 * - $allArtworkCount      : The count of all this user's artwork 
 * - $draftArtworkCount    : The count of all this user's artwork still in draft status
 * - $rejectedArtworkCount : The count of all this user's artwork that has been rejected
 * - $uploadedCount        : The count of all this user's files that they have uploaded in total
 * - $orphanedCount        : The count of all this user's files that are not attached to artworks yet
 * 
 * PHP Version 5
 *
 * @author    Russ Flynn <russ@linpro.no>
 * @copyright 2008 Linpro AS
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 *
 */

if ($thisUser->getId() == $sf_user->getId()) 
{
  reaktor::setReaktorTitle(__("Manage my Artworks"));
}
else 
{
  reaktor::setReaktorTitle(__("Manage Artwork for %username%", array("%username%" => $thisUser->getUsername())));
}

?>
<?php include_partial("sideMenu"); ?>
<div id="my_content">
  <h1>
    <?php if ($thisUser->getId() == $sf_user->getId()): ?>
      <?php echo __("Manage my content - overview"); ?>
    <?php else: ?>
      <?php echo __("Content by %username%", array("%username%" => $thisUser->getUsername())); ?>
    <?php endif; ?>
  </h1>
  <p><?php echo __('From this page, you can manage your artworks. Find artworks by choosing from the menu to the left'); ?>.</p>
  <br />
  <h2><?php echo __('Creating slideshows, playlists and text collections'); ?></h2>
  <p style="margin-top: 0px;"><?php echo __("To create an artwork with more than one file:"); ?></p>
  <ul>
    <li>* <?php echo __('Find the artwork you want to expand, in the list') ?></li>
    <li>* <?php echo __('Use one of the "add more files" links in the list to add files to the artwork') ?></li>
  </ul>
  <p><?php echo __("This will make the artwork into a slideshow (for images), playlist (for audio) or a collection (for text)."); ?></p>
  <?php /* ?>
  <br />
  <?php if ($uploadedCount): ?>
    <ul class = "indentli">
      <?php if ($allArtworkCount): ?>
      <h2><?php echo __("Artwork"); ?></h2>
          <li><strong><?php echo reaktor_link_to(__("View all artwork (%count%)", 
                          array("%count%" => $allArtworkCount)), $route."?mode=allartwork&user=".$thisUser->getUsername()); ?></strong></li>
        <?php if ($draftArtworkCount): ?>
          <li><?php echo reaktor_link_to(__("View draft artwork - artwork I have not submitted for approval (%count%)", 
                          array("%count%" => $draftArtworkCount)), $route."?mode=draftartwork&user=".$thisUser->getUsername()); ?></li>
        <?php endif; ?>
        
        <?php if ($submittedArtworkCount): ?>
          <li><?php echo reaktor_link_to(__("View submitted artwork - artwork not yet approved (%count%)", 
                          array("%count%" => $submittedArtworkCount)), $route."?mode=submittedartwork&user=".$thisUser->getUsername()); ?></li>
        <?php endif; ?>
        
        <?php if ($approvedArtworkCount): ?>
          <li><?php echo reaktor_link_to(__("View approved artwork (%count%)", 
                          array("%count%" => $approvedArtworkCount)), $route."?mode=allapproved&user=".$thisUser->getUsername()); ?></li>
        <?php endif; ?>
      
        <?php if ($rejectedArtworkCount): ?>
          <li><?php echo reaktor_link_to(__("View rejected artwork (%count%)", 
                          array("%count%" => $rejectedArtworkCount)), $route."?mode=allrejected&user=".$thisUser->getUsername()); ?></li>
        <?php endif; ?>
      <?php endif; ?>
      
      <h2><?php echo __("All uploaded files"); ?></h2>
      <li><strong><?php echo reaktor_link_to(__("View all uploaded files (%count%)", 
                        array("%count%" => $uploadedCount)), $route."?mode=allfiles&user=".$thisUser->getUsername()); ?></strong></li>
      
      <?php if ($orphanedCount): ?>
        <li><?php echo reaktor_link_to(__("View all uploaded files that are not attached to artworks (%count%)", 
                        array("%count%" => $orphanedCount)), $route."?mode=orphanedfiles&user=".$thisUser->getUsername()); ?></li>
      <?php endif; ?>
    </ul>
  <?php elseif ($thisUser->getId() == $sf_user->getId()): ?>
    <?php echo __("You do not have any content to manage")." - ".reaktor_link_to(__("click here to upload artwork now!"), "@upload_content"); ?>
  <?php else: ?>
    <?php echo __("This user has not uploaded any files yet"); ?>
  <?php endif; */ ?>
</div>