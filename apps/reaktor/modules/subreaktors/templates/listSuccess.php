<?php
/**
 * subReaktors filter the content of Reaktor either on location or content. This template lets the user change 
 * the order the subReaktors appear in, and an interface to add new Reaktors.
 * 
 * The controller passes the following information:
 * 
 * $subreaktors - Array of Subreaktors
 *  
 * PHP version 5
 * 
 * @author    Daniel Andre Eikeland <dae@linpro.no>
 * @author    June Henriksen <juneih@linpro.no> 
 * @copyright 2008 Linpro AS
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 */

use_helper('Javascript', 'content', 'PagerNavigation', 'wai'); 
reaktor::setReaktorTitle(__('List subReaktors')); ?>

<?php echo javascript_tag("
  function updateOrder()
  {
      dnd_s = document.getElementById('dnd_message_saving');
      dnd_d = document.getElementById('dnd_message_done');
      dnd_d.style.display = 'none';
      dnd_s.style.display = 'block';
      var options = {
                      method : 'post',
                      parameters : Sortable.serialize('subreaktor_list'),
                      onComplete : function(request) {
                        dnd_s.style.display = 'none';
                        dnd_d.style.display = 'block';
                      }
                    };
   
      new Ajax.Request('".url_for('@adminupdatesubreaktororder')."', options);
  }
"); ?>
<div style="display: none;" id="dnd_message_saving">
  <?php echo __("Please wait while saving the subReaktor order"); ?> ...
</div>
<div style="display: none;" id="dnd_message_done">
  <?php echo __("subReaktor order saved!"); ?>
</div>
<br />
<div class='grey_background extra_padding'>
  <h4><?php echo __('Add a new subReaktor/LokalReaktor'); ?></h4>
  <?php echo __("For more information on creating a new subReaktor, please refer to the documentation."); ?><br />
  <?php echo form_error('global'); ?>
  <?php echo form_tag('@addsubreaktor'); ?>
  
    <div >
      <br />
      <div >
        <?php echo wai_label_for('name', __('Name'), array(
          'title' => __('The name is displayed in links, mouse-overs and on imagemaps')
        )) ?>
        <div >
          <?php echo form_error('name') ?>
        </div>
        <?php echo input_tag('name', null, array(
          'class' => 'short_input'
        )); ?>
      </div>
      
      <div >
        <?php echo wai_label_for('reference', __('Reference'), array(
          'title' => __('Reference is what appears in the URL')
        )) ?>
        <div>
          <?php echo form_error('reference') ?>
        </div>
        <?php echo input_tag('reference', null, array(
          'class' => 'short_input'
        )); ?>
      </div>
      <div>
        <?php echo submit_tag(__('Create')) ?>
      </div>
    </div>
    
  <?php echo '</form>'; ?>

</div>



<br />
<?php if ($activeSubreaktors): ?>

  <h1 class='clear_both'><?php echo __('Current subReaktors') ?></h1>
  <span class='inform_msg'>
    <?php echo __('This is a drag-and-drop list to order subReaktors in the menu.') ?>
  </span>
  <ul id="subreaktor_list" class="sortable-list">
    <?php foreach ($activeSubreaktors as $aSubReaktor): ?>
      <li id="subreaktor_<?php echo $aSubReaktor->getId()?>" class='subreaktor_list clearboth' style="cursor: move;">
      	<div class='subreaktor_list_image'>
      	  <?php echo image_tag("logo" . ucfirst($aSubReaktor->getReference()) . ".gif", array()); ?>
      	</div>
      	<div class='subreaktor_list_info'>
      	  <h2 class='subreaktor_list_header'>
      	    <?php echo $aSubReaktor->getName() ?> <br />
      	  </h2>
          <?php echo link_to('http://www.minreaktor.no/' . $aSubReaktor->getReference(), '/' . $aSubReaktor->getReference()); ?><br />
          <?php echo __('This subReaktor is live'); ?><br />
          <?php echo ($aSubReaktor->getLokalReaktor()) ? __('This is a LokalReaktor') : __('This is a normal subReaktor'); ?>
      	</div>
        <div class='subreaktor_list_buttons'>
          <?php echo button_to(__('Edit'), '@editsubreaktor?id='.$aSubReaktor->getId()) ?>
        </div>
      </li>
    <?php endforeach; ?>
  </ul>
<?php endif; ?>

<?php if ($inactiveSubreaktors): ?>
  <h1 class='clear_both'><?php echo __('Current inactive subReaktors') ?></h1>
  
  <ul id="inactive_subreaktor_list" class="not-sortable-list">
    <?php foreach ($inactiveSubreaktors as $aSubReaktor): ?>
      <li id="subreaktor_<?php echo $aSubReaktor->getId()?>" class='subreaktor_list clearboth'>
      <div class='subreaktor_list_image'>
        <?php echo image_tag("logo" . ucfirst($aSubReaktor->getReference()) . ".gif", array()); ?>
      </div>
      <div class='subreaktor_list_info'>
        <h2 class='subreaktor_list_header'>
          <?php echo $aSubReaktor->getName() ?> <br />
        </h2>
          <?php echo link_to('http://www.minreaktor.no/' . $aSubReaktor->getReference(), '/' . $aSubReaktor->getReference()); ?><br />
          <?php echo __('This subReaktor is not live'); ?><br />
          <?php echo ($aSubReaktor->getLokalReaktor()) ? __('This is a LokalReaktor') : __('This is a normal subReaktor'); ?>
      </div>
        <div class='subreaktor_list_buttons'>
          <?php echo button_to(__('Edit'), '@editsubreaktor?id='.$aSubReaktor->getId()) ?>
        </div>
      </li>
    <?php endforeach; ?>
  </ul>
<?php endif; ?>
<script type="text/javascript">
  Sortable.create('subreaktor_list', { onUpdate: updateOrder });
</script>
