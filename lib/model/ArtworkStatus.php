<?php

/**
 * Subclass for representing a row from the 'artwork_status' table.
 *
 * 
 *
 * @package lib.model
 */ 
class ArtworkStatus extends BaseArtworkStatus
{

  public function hydrate(ResultSet $rs, $startcol = 1)
  {
    parent::hydrate($rs, $startcol);
    $this->setCulture(sfContext::getInstance()->getUser()->getCulture());
  }
	
  public function __toString()
  {
    return $this->getDescription();
  }
}
