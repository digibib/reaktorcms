<?php $cat_array = TransUnitPeer::getTargetLangArray() ?>
<?php echo select_tag('filters[cat_id]', options_for_select($cat_array, isset($filters['cat_id']) ? $filters['cat_id'] : '', array('include_blank' => true) )) ?>
