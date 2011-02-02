<?php
/**
 * Each string in Reaktor can be translated. This template is used in the adminportal to display how a string
 * has been translated. The string in the code is the source, usually plain english and can be used directly as
 * an English version. Other times, the source is just a placeholder and must be translated to english as well. 
 * 
 * This template holds the target forms, all the form to translate into the languages offered by the Reaktor site.
 *  
 * Example of use:
 * 
 * get_partial('target', array('type' => 'edit', 'trans_unit' => $trans_unit))
 * 
 * $type - This variable is not used, but it does indicate that the form is used in edit mote
 * $trans_unit - The object describing what is about to be translated
 * 
 * PHP version 5
 *
 * @author    Ole-Petter Wikene <olepw@linpro.no>
 * @author    Hannes Magnusson <bjori@linpro.no>
 * @author    Russ Flynn <russ@linpro.no>
 * @author    June Henriksen <juneih@linpro.no>
 * 
 * @copyright 2008 Linpro
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 */
$catalogues = CataloguePeer::getCatalogues(); 

echo input_hidden_tag("trans_unit[msg_id]", $trans_unit->getMsgId());
foreach ($catalogues as $catalogue) 
{
  $trans_unit_string = 'trans_unit_' . $catalogue->getCatId();
  
  if($trans_unit->getMsgId()) //Get current catalogue's/culture's translation of source 
  { 
    $c = new Criteria();
    $c->add(TransUnitPeer::CAT_ID, $catalogue->getCatId());  
// Ticket 23733
    $c->add(TransUnitPeer::SOURCE, $trans_unit->getSource(), ' = BINARY ');
    //$trans_unit_string = 'trans_unit_' . $catalogue->getCatId();
    //$cat_id = $catalogue->getCatId();
    $$trans_unit_string = TransUnitPeer::doSelectOne($c);
  }
  //if ($$trans_unit_string) {
  if (isset($$trans_unit_string)&&$$trans_unit_string) //If translated string is set
  {   
    $msg_id_string = 'msg_id_' . $catalogue->getCatId();
    echo input_hidden_tag("${trans_unit_string}[msg_id]", ${$trans_unit_string}->getMsgId());
  } 
  else {
    $$trans_unit_string = new TransUnit();
  }
  
  echo '<strong>'.$catalogue->getDescription().'</strong>'; //Header
  
  echo '<br />';//Is the string translated
  echo checkbox_tag("${trans_unit_string}[translated]", 1, $$trans_unit_string->getTranslated());
  echo __(" Publish translation for %language%", array('%language%' => $catalogue->getDescription()));  
  echo '<br /><br />';
  
  //Translation     
  echo label_for("${trans_unit_string}[target]", $catalogue->getDescription().' '.__("translation").':');
  echo textarea_tag("${trans_unit_string}[target]", $$trans_unit_string->getTarget(), array('style' => 'width: 480px; height: 200px;'));
  echo '<br />';

  //Copy source string
  echo '<div class="grey_text">'.checkbox_tag("${trans_unit_string}[default]", 1, '');//($catalogue->getTargetLang()=='en')?1:0);
  echo __("Copy source string and use it as translation for %language%", array('%language%' => $catalogue->getDescription())).'</div>';
  
 
  //Comment box
  echo '<br />';
   echo label_for("${trans_unit_string}[target]", __("Kommentar til oversettelse").':');
  echo textarea_tag("${trans_unit_string}[comments]", $$trans_unit_string->getComments(), array('style' => 'width: 480px; height: 30px;'));
  echo '<br />';
  
  //Use comment globally
  echo checkbox_tag("${trans_unit_string}[global]", 1, '');
  echo __(" Use this comment for all translations");
  echo '<br /><br /><br />';
  echo "<br />\n";
}

?>