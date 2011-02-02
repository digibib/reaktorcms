<?php
/**
 * Metadata overview for an artwork
 *  
 * PHP version 5
 * 
 * @author    Daniel Andre Eikeland <dae@linpro.no>
 * @copyright 2008 Linpro AS
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 */
reaktor::setReaktorTitle(__('Artwork metadata for %artwork_title%', array("%artwork_title%" => $artwork->getTitle()))); 

?>

<h2><?php echo __('Metadata for %title%', array('%title%' => $artwork->getTitle())) ?></h2>
<table id="artwork_metadata_header">
  <tbody>
    <tr>
      <td style="text-align: right; padding: 3px;"><b><?php echo __('Id') ?>:</b></td><td style="padding: 3px;"><?php echo $artwork->getId() ?></td>
    </tr>
    <tr>
      <td style="text-align: right; padding: 3px;"><b><?php echo __('Title') ?>:</b></td><td style="padding: 3px;"><?php echo $artwork->getTitle() ?></td>
    </tr>
    <tr>
      <td style="text-align: right; padding: 3px;"><b><?php echo __('Link') ?>:</b></td><td style="padding: 3px;"><?php echo link_to(sfConfig::get('app_reaktor_url') . url_for($artwork->getLink()), $artwork->getLink()) ?></td>
    </tr>
    <tr>
      <td style="text-align: right; padding: 3px;"><b><?php echo __('Last updated') ?>:</b></td><td style="padding: 3px;"><?php echo $artwork->getCreatedAt() ?></td>
    </tr>
  </tbody>
</table>
<h3><?php echo __('Metadata for files in the artwork') ?></h3>
<?php use_helper("Javascript"); ?>
<?php foreach ($artwork->getFiles() as $aFile): ?>
  <h2><?php echo $aFile->getTitle() ?></h2>
	<table style="width: 100%;" cellspacing=0 class="metadata_table">
	  <thead>
	    <tr>
	      <td style="width: 90px;"><?php echo __('Metadataformat') ?></td>
	      <td style="width: 80px;"><?php echo __('Element') ?></td>
	      <td style="width: 80px;"><?php echo __('Qualifier') ?></td>
	      <td style="width: auto;"><?php echo __('Value') ?></td>
        <td style="width: 60px;">&nbsp;</td>
	    </tr>
	  </thead>
	  <tbody>
      <?php foreach ($aFile->getMetadatas(false) as $aMetadata): ?>
        <tr id="meta_element_<?php echo $aMetadata->getId() ?>">
          <td>dc</td>
          <td><?php echo $aMetadata->getMetaElement() ?></td>
          <td><?php echo $aMetadata->getMetaQualifier() ?></td>
          <td><textarea readonly="readonly"><?php echo $aMetadata->getMetaValue() ?></textarea></td>
			    <td class="actions"><?php echo link_to_remote(__('Remove'), array(
			      'url'      => '@remove_metadata?id=' . $aMetadata->getId(),
			      'loading'  => "Element.hide('meta_element_" . $aMetadata->getId() . "')",
			      )); ?></td>
        </tr>
      <?php endforeach; ?>
	  </tbody>
	</table>
<?php endforeach; ?>
