<?php

/**
 * Subclass for representing a row from the 'catalogue' table.
 *
 * 
 *
 * @package lib.model
 */ 
class Catalogue extends BaseCatalogue
{
  public function __toString()
  {
  return $this->getDescription();
  }
  
}
