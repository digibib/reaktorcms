<?php
/**
 * Partial to show transcoder options on the artwork page for admin users to be able to re-trigger the process
 * This will display when the file has not finished transcoding, or when the file does not exist at all
 * Expects:
 * - $file : The file object that we are checking the transcoding status of 
 * 
 * PHP Version 5
 *
 * @author    Russ <russ@linpro.no>
 * @copyright 2008 Linpro AS
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 *
 */
?>

<div id="transcodershell" style="display:block;"></div>
<?php echo button_to_remote(__("Re-transcode file"), array(   
  'url' => '@re_transcode_file?id='.$file->getId(),
  'update' => 'transcodershell',
  'script' => 'true',
  'complete' => "$('player_warning').style.width='500px'; $('player_warning').style.height='500px';"
          
)); ?>
<?php echo button_to_remote(__("Read transcoder log"), array(   
  'url' => '@transcoderlog?id='.$file->getId(),
  'update' => 'transcodershell',
  'script' => 'true',
  'complete' => "$('player_warning').style.width='500px'; $('player_warning').style.height='500px';"
          
)); ?>
