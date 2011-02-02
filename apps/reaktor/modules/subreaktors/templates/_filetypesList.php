<?php
/**
 * 
 *  
 * PHP version 5
 * 
 * @author    Daniel Andre Eikeland <dae@linpro.no>
 * @copyright 2008 Linpro AS
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 */
?>
<?php foreach ($subreaktor->getFiletypes() as $value): ?>
    <?php echo link_to_remote(image_tag("delete.png", array("width" => "10")), array(
      'update'   => 'subreaktorFiletypes',
      'url'      => 'subreaktors/filetypeAction',
      'with'     => "'filetype=".$value."&mode=delete&subreaktor=".$subreaktor->getId()."'",
      'loading'  => "Element.show('filetype_indicator')",
      'complete' => "Element.hide('filetype_indicator')",
      'confirm'  => __('Remove %content_type% from this subreaktor? Uploaded content of type %content_type% will no longer be assigned to this subreaktor', array('%content_type%'=> $value))
    )) ?>
  <?php echo $value; ?>
  <br />
<?php endforeach; ?>
<?php if (count($subreaktor->getFiletypes()) == 0): ?>
  <?php echo __('No filetypes are auto-detected in this subReaktor'); ?>
<?php endif; ?>
