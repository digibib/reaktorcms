<?php

/**
 * Subclass for performing query and update operations on the 'lokalreaktor_residence' table.
 *
 * 
 *
 * @package lib.model
 */ 
class LokalreaktorResidencePeer extends BaseLokalreaktorResidencePeer
{

  public static function getResidenceBySubreaktor(Subreaktor $subreaktor)
  {
    $c = new Criteria();
    $c->add(parent::SUBREAKTOR_ID, $subreaktor->getPrimaryKey());
    return parent::doSelectJoinResidence($c);
  }

  public static function getSubreaktorsByResidence($ResidenceId)
  {

if(is_numeric($ResidenceId)){
    $c = new Criteria();
    $c->add(parent::RESIDENCE_ID, $ResidenceId);
    return parent::doSelectJoinResidence($c);
    }

  }


}
