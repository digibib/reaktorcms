<?php
/**
 * Expiry date partial. Included in article edit page to show and edit theme article expiry date 
 *  
 * PHP version 5
 * 
 * @author    Daniel Andre Eikeland <dae@linpro.no>
 * @copyright 2008 Linpro AS
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 */

  use_helper('Javascript');

?>
<div id="article_expiration_date">
  <h4><?php echo __('Theme article expiry date'); ?></h4>
  <p><?php echo __('After this date, the article will no longer be shown on the frontpages'); ?></p>
  <?php //Add form start tag 
      echo form_remote_tag(array(
      'update'   => 'article_expiration_date', 
      'url'      => '@setarticleexpirationdate?article_id='.$article->getId(),
      'loading'  => "Element.show('relate_article_ajax_indicator')",
      'complete' => "Element.hide('relate_article_ajax_indicator')",
      'script'   => true), array(
      'id'    => 'article_setexpirationdate_form', 
      'name'  => 'article_setexpirationdate_form'
  )); ?>
  <?php echo form_error('expiry_date'); ?>
  <?php 
    echo input_date_tag('expiry_date', $date, array(
    'rich'           => false, 
    'culture'        => $sf_user->getCulture(),  
    'year_start'     => date('Y'), 
    'year_end'       => date('Y')+2,
    'date_seperator' => '&nbsp;',
    'include_custom' => array('day'=>__('Day'), 'month'=>__('Month'), 'year'=>__('Year'))
  )); ?>
  <?php echo submit_tag(__('Set expiration date')); ?>
  <?php echo '</form>'; ?>
  <?php if ($sf_params->get("expiry_date") && !form_has_error('expiry_date')): ?>
    <b><?php echo __('Expiry date saved!') ?></b>
  <?php endif; ?>
</div>

