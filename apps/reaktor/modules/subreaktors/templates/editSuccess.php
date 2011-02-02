<?php
/**
 * The Reaktor site divides its content into sections according to nature of the artwork, these sections are the subReaktors 
 * and lokalReaktors. For flexibility reasons, it is possible to add more, and edit the existing ones. This is the template for
 * editing a subReaktor or lokalReaktor.
 * 
 * The controller passes the following information:
 * $lokalresidences   - an array of the residences to choose from, needed for drop down
 * $logo_filename     - the filename of the sub- or lokalReaktors logo
 * $logo_path         - the path to the sub- or lokalReaktors logo
 * $template_filename - the filename of the sub- lokalReaktor template
 * $template_path     - the path to the sub- lokalReaktor template
 *  
 * PHP version 5
 * 
 * @author    Daniel Andre Eikeland <dae@linpro.no>
 * @author    Russ Flynn <russ@linpro.no>
 * @author    June Henriksen <juneih@linpro.no>
 * @copyright 2008 Linpro AS
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 */

use_helper('Object', 'content', 'Javascript', 'doubleList', 'wai');
reaktor::setReaktorTitle(__('Edit %subReaktor_name% subReaktor', array("%subReaktor_name%" => $subreaktor->getName()))); ?>

<h1><?php echo __('Edit %subReaktor_name% subReaktor', array('%subReaktor_name%' => $subreaktor->getName())); ?></h1>
<div style = "position: relative; width: 100%;">
  
  <div class='grey_background extra_padding' >
      <b><?php echo __('Name').':'?></b><br /> 
      <?php echo $subreaktor->getName(); ?><br />
      <p class='inform_msg'>
        <?php echo __('The name will be translated into the users selected language. To change it, use the %translation_interface%', 
                    array('%translation_interface%' => '<b>' . link_to(__('translation interface'), '@subreaktornames') . '</b>')); ?>.<br />
      </p>   
      <b><?php echo __('Reference').': ';?></b><br />
      <?php echo $subreaktor->getReference(); ?><br />
      <p class='inform_msg'>
        <?php echo __('The reference is used to access the subReaktor, so that you can point to %subReaktor_url%', 
                    array('%subReaktor_url%' => '')); ?><br />
        <i>
          <?php echo link_to(sfConfig::get('app_reaktor_url') . '/' . $subreaktor->getReference(), 
                             '/' . $subreaktor->getReference()); ?>
        </i>
      </p>   

      <b><?php echo __('subReaktor logo:'); ?></b>
      <br />
      <?php echo image_tag($logo_filename); ?>
      <br /><br />
      <p class='inform_msg'>
      <?php echo __('To change the logo, update the file <i>%filename%</i> in the <i>%directory%</i> directory.', 
        array('%filename%' => $logo_filename, '%directory%' => $logo_path)); ?>
      </p>
      
    </div><br />
    
  <div class = 'float_left'>
   
    <div class = 'grey_boarder' style = "width: 450px;">
      <?php echo form_tag('@updatesubreaktor?id=' . $subreaktor->getId(), array(
      'id'        => 'sf_admin_edit_form',
      'name'      => 'sf_admin_edit_form',
      'onsubmit'  => 'double_list_submit(); return true;'
      )) ?>
        <?php if (!$subreaktor->getLive()): ?>
          <br />
          <?php echo form_error('subreaktor_reference'); ?>
          <?php echo wai_label_for('subreaktor_reference', __("Change the reference: ")); ?>
          <?php echo input_tag('subreaktor_reference', $subreaktor->getReference(), array("length" => 25, "class" => "short_input")) ?>
        <?php endif; ?>
        <br />
        <?php echo wai_label_for('subreaktor_live', __('Is this subReaktor live: ')); ?>
        <?php echo select_tag('subreaktor_live', options_for_select(array(
                              '1' => __('Yes'),
                              '' => __('No')), $subreaktor->getLive())); ?>
        <br />
        <?php echo wai_label_for('subreaktor_lokalreaktor', __('Is this subReaktor a LokalReaktor: ')); ?>
        <?php echo select_tag('subreaktor_lokalreaktor', options_for_select(array(
                              '1' => __('Yes'),
                              '' => __('No')), $subreaktor->getLokalReaktor())); ?>
        <br />
  
        <?php if($subreaktor->getLokalReaktor()):?>
  
          <h2><?php echo __('Choose residence') ?></h2>
  
          <div class="form-row">
            <?php $value = reaktor_double_list(ResidencePeer::getResidenceLevel(), $lokalresidences); echo $value ? $value : '&nbsp;' ?>
          </div>
        <?php endif ?>
  
        <div class='right_buttons '>
          <?php echo submit_tag(__('Update subReaktor')) ?>
          <?php echo button_to(__('Cancel'), '@listsubreaktors') ?>
        </div>
      <?php echo '</form>'; ?>
      <p class='clearboth'> </p>
    </div><br />
    
    
    
  </div>
  <?php if(!$subreaktor->getLokalReaktor()):?>
    <div class='float_right medium'>
    
      <div class='grey_boarder'>
        <h2><?php echo __("subReaktor categories"); ?></h2>
        
        <?php echo form_remote_tag(array(
            'update'   => 'subreaktorCategories',
            'url'      => 'subreaktors/categoryAction?subreaktor='.$subreaktor->getId().'&mode=add',
            'loading'  => "Element.show('category_indicator')",
            'complete' => "Element.hide('category_indicator'); doSubmit();",
            'success'  => "$('category').value = ''"),
            array("name" => "tag_form")
          ) ?>
          <div id = "category_indicator" style = "display: none;">
              <?php echo image_tag('spinning18x18.gif') ?>
            </div>
            
            <?php echo form_error('category') ?>  
          <div id="subreaktorCategories">          
            <?php include_partial('subreaktors/categoriesList', array('subreaktor' => $subreaktor)); ?>
        	</div>
      	</form>  
      </div>
      <br />
          
      <div class='grey_boarder' >  
        <h2><?php echo __("Auto-detection content types");?></h2>     
        <div id="mime_indicator" style="display: none;">
          <?php echo image_tag('spinning18x18.gif') ?>
        </div><br />
        
        <?php echo form_remote_tag(array(
          'update'   => 'subreaktorFiletypes',
          'url'      => 'subreaktors/filetypeAction?subreaktor='.$subreaktor->getId().'&mode=add',
          'loading'  => "Element.show('filetype_indicator')",
          'complete' => "Element.hide('filetype_indicator'); doSubmit();",
          'success'  => "$('filetype').value = ''"),
          array("name" => "filetype_form")
        ) ?>
          
          <?php echo form_error('filetype') ?>
          <?php //echo wai_label_for('filetype', __('Add content type to auto-detect:')) ?>
          <div>
            <?php include_component('subreaktors', 'newFiletypeField', array('subreaktor' => $subreaktor)) ?>
          </div>
          
        <?php echo '</form>'; ?>
        
        <div id="subreaktorFiletypes">
          <?php include_partial('subreaktors/filetypesList', array('subreaktor' => $subreaktor)); ?>
        </div>
        
      </div>
    </div>
  <?php endif; ?>
  <br />
  <p class='float_left clear_both inform_msg'>
      <?php echo __('To edit the frontpage for this subReaktor, edit the file <i>%file%</i> in the <i>%directory%</i> directory.', 
        array('%file%' => $template_filename, '%directory%' => $template_path));?>
  </p>
</div>




