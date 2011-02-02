<?php
/**
 * Select dropdown for picking a composite artwork to add this file to
 * Will show a list of artworks of the same type
 * - $artworks : The eligible artworks for this addition
 * - $thisUser : The user object that we are working with
 * 
 * PHP Version 5
 *
 * @author    Russ <russ@linpro.no>
 * @copyright 2008 Linpro AS
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 *
 */

use_helper("Javascript", "content");

?>

<p><?php echo __("Add to composite artwork"); ?></p>
<?php echo form_remote_tag(array(
        'update'   => 'composite_'.$file->getId(), 
        'url'      => 'userContent/add',
        'loading'  => "",
        'complete' => visual_effect('highlight', 'artwork_list_'.$file->getId()).
                      "new Ajax.Updater('artwork_list_".$file->getId()."', '".url_for("@getartworklist?fileId=".$file->getId())."')"), 
          array(
                'class' => 'composite_add_form', 
                'id'    => 'composite_add_form_'.$file->getId(), 
                'name'  => 'composite_add_form_'.$file->getId())); ?>
  <?php echo select_tag('artworkId', options_for_select($artworks, '', array("include_custom" => __("---Create new---")))); ?>
  <?php echo input_hidden_tag("fileId", $file->getId()); ?>
  <?php echo input_hidden_tag("user", $thisUser->getUsername()); ?>
  <?php echo input_hidden_tag("miniResult", true); ?>
  <?php echo submit_tag(__("Go"), array("name" => "link")); ?>
</form>