<?php

/**
 * Subclass for representing a row from the 'residence_level' table.
 *
 * 
 *
 * @package lib.model
 */ 
class ResidenceLevel extends BaseResidenceLevel
{
  /**
   * We want to use internationalisation were we can, this function 
   * will take care of that.
   *
   * @param ResultSet $rs
   * @param integer $startcol
   * 
   * @return void
   */
  public function hydrate(ResultSet $rs, $startcol = 1)
  {
    parent::hydrate($rs, $startcol);
       
    $this->setCulture(sfContext::getInstance()->getUser()->getCulture());
  }

  public function __toString()
  {
    return $this->getName();
  }
}
