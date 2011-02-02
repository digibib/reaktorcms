<?php echo select_tag('filters[translated]', options_for_select(array(
  '' => 'all',
  '0' => 'untranslated',
  '1' => 'translated',
 ), isset($filters['translated']) ? $filters['translated'] : '' )) ?>
