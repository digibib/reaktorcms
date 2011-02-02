<?php
/**
 * This partial contains the search box which can be found in the sidebar, also covering user searches
 * No parameters are required, simply include this partial and you will have a working search box
 * 
 * PHP version 5
 * 
 * @author    Daniel Andre Eikeland <dae@linpro.no>
 * @author    Russ Flynn <russ@linpro.no>
 * @copyright 2008 Linpro AS
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 */

use_helper('wai');
?>
<div id="tag_search_box">
  <?php echo reaktor_form_tag('@findtags'); ?>
    <h3><?php echo wai_label_for('tag', __('Search')); ?></h3>
    <?php echo input_tag('tag') ?><br />
    <?php echo wai_label_for('findtype_tags', __('tags')), " ", radiobutton_tag(
                                   'findtype', 
                                   'tags', 
                                   (($sf_params->get('findtype') != 'user') ? true : false), 
                                   array('alt' => __('Tags'))); ?><br />
    <?php echo wai_label_for('findtype_user', __('users')), " ", radiobutton_tag(
                                    'findtype', 
                                    'user', 
                                    (($sf_params->get('findtype') == 'user') ? true : false), 
                                    array('alt' => __('Tags'))); ?>
    <div style="text-align: right;">
      <span><?php echo __('(ex: car, bird, bike)'); ?></span>
      <?php echo submit_tag(__('Find')); ?>
    </div>
  </form>
</div>
