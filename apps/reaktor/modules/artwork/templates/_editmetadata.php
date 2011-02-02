<?php
/**
 * Partial to edit metadata
 *  
 * PHP version 5
 * 
 * @author    Daniel Andre Eikeland <dae@linpro.no>
 * @copyright 2008 Linpro AS
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 */

use_helper('wai');

$theFile = '';

try
{
  // print 'fu' . $file_id;
  $theFile = new artworkFile($file_id);
}
catch (Exception $e)
{
  print $e->getMessage();
  print '<br />Try adding a number to the url.';
}
  
if ($theFile instanceof artworkFile)
{
  ?>
  <h3>Editing metadata for <?php echo $theFile->getTitle(); ?></h3>
  <?php echo form_tag('artwork/update') ?>
  <?php echo input_hidden_tag('artwork', $theFile->getId()) ?>
  <dl>
    <dt><b><?php echo wai_label_for('meta_author', __('Author')) ?></b></dt>
    <dd><?php echo form_error('meta_author') ?>
      <?php echo input_tag('meta_author', 
                  $theFile->getMetadata('contributor', 'author'), 
                  array ('size' => 60)) ?></dd>
  </dl>
  <dl>
    <dt><b><?php echo wai_label_for('meta_description', __('Description')) ?></b></dt>
    <dd><?php echo form_error('meta_description') ?>
      <?php echo input_tag('meta_description', 
                  $theFile->getMetadata('description', 'abstract'), 
                  array ('size' => 60)) ?></dd>
  </dl>
  <dl>
    <dt><b><?php echo wai_label_for('meta_license', __('License')) ?></b></dt>
    <dd><?php echo form_error('meta_license') ?>
      <?php echo select_tag('meta_license', options_for_select(array(
                  'by' => 'Creative Commons - Attribution (by)',
                  'by-sa' => 'Creative Commons - Attribution Share Alike (by-sa)',
                  'by-nd' => 'Creative Commons - Attribution No Derivatives (by-nd)',
                  'by-nc' => 'Creative Commons - Attribution Non-commercial (by-nc)',
                  'by-nc-sa' => 'Creative Commons - Attribution Non-commercial Share Alike (by-nc-sa)',
                  'by-nc-nd' => 'Creative Commons - Attribution Non-commercial No Derivatives (by-nc-nd)'),
                  $theFile->getMetadata('rights', 'license'))) ?></dd>
    <dd><?php echo link_to('Read more about Creative Commons\' licenses', 'http://creativecommons.org/about/license/', 'target="_new"'); ?></dd>
  </dl>
  <?php echo submit_tag(__('Save')); ?>
  <?php echo '</form>';
}
?>
<br />
I am the editmetadata partial. Find me in module/artwork/templates/_editmetadata.php
