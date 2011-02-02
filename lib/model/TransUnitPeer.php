<?php

/**
 * Subclass for performing query and update operations on the 'trans_unit' table.
 *
 * 
 *
 * @package lib.model
 */ 
class TransUnitPeer extends BaseTransUnitPeer
{
  static public function getTargetLangArray()
  {
    $c = new Criteria();
    $catalogues = CataloguePeer::doSelect($c);
    $cat = array();
    foreach ($catalogues as $catalogue) {
      $cat_id = $catalogue->getCatId();
      $cat[$cat_id] = $catalogue->getTargetLang();
  }
  return $cat;
}
}
