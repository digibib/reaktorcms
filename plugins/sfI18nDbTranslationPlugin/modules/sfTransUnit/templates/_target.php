<?php $catalogues = CataloguePeer::getCatalogues(); ?>
<?php
echo input_hidden_tag("trans_unit[msg_id]", $trans_unit->getMsgId());
foreach ($catalogues as $catalogue) {
 $c = new Criteria();
 $c->add(TransUnitPeer::CAT_ID, $catalogue->getCatId());
 $c->add(TransUnitPeer::SOURCE, $trans_unit->getSource());
 $trans_unit_string = 'trans_unit_' . $catalogue->getCatId();
 $cat_id = $catalogue->getCatId();
 $$trans_unit_string = TransUnitPeer::doSelectOne($c);
 if ($$trans_unit_string) {
  $msg_id_string = 'msg_id_' . $catalogue->getCatId();
  echo input_hidden_tag("${trans_unit_string}[msg_id]", ${$trans_unit_string}->getMsgId());
 } else {
   $$trans_unit_string = new TransUnit();
 }

 echo '<strong>'.$catalogue->getTargetLang().'</strong>';
 echo '<br/>';
 echo checkbox_tag("${trans_unit_string}[default]", 1, '');
 echo " Set translation to source string";
 echo '<br/>';
 echo input_tag("${trans_unit_string}[target]", $$trans_unit_string->getTarget(), array('style' => 'width: 480px'));
 echo '<br/>';
 echo checkbox_tag("${trans_unit_string}[translated]", 1, ($$trans_unit_string->getTranslated() == 1) ? 1 : 0);
 echo " Translated";
 echo '<br/>';
 echo textarea_tag("${trans_unit_string}[comments]", $$trans_unit_string->getComments());
 echo '<br/>';
 echo checkbox_tag("${trans_unit_string}[global]", 1, '');
 echo " Use this comment for all translations";
 echo '<br/>';
 echo "<br/>\n";
}
