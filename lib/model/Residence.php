<?php

/**
 * Subclass for representing a row from the 'residence' table.
 *
 * 
 *
 * @package lib.model
 */ 
class Residence extends BaseResidence
{
  
  public function __toString()
  {
    return $this->getName();
  }
	
}
