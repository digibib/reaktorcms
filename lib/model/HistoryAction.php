<?php

/**
 * Subclass for representing a row from the 'history_action' table.
 *
 * 
 *
 * @package lib.model
 */ 
class HistoryAction extends BaseHistoryAction
{
  
	public function hydrate(ResultSet $rs, $startcol = 1)
  {
    parent::hydrate($rs, $startcol);
    $this->setCulture(sfContext::getInstance()->getUser()->getCulture());
  }
  
}
