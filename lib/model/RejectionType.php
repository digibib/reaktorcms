<?php

/**
 * Subclass for representing a row from the 'rejection_type' table.
 *
 * 
 *
 * @package lib.model
 */ 
class RejectionType extends BaseRejectionType
{

  public function hydrate(ResultSet $rs, $startcol = 1)
  {
    parent::hydrate($rs, $startcol);
    $this->setCulture(sfContext::getInstance()->getUser()->getCulture());
  }
	
  /*public function __toString()
  {
    return $this->getName();
  }*/
}
