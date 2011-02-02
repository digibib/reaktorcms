<?php
/**
 * 
 *  
 * PHP version 5
 * 
 * @author    Daniel Andre Eikeland <dae@linpro.no>
 * @copyright 2008 Linpro AS
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 */

class adminComponents extends sfComponents
{
	  
  public function executeAdminArtworkList()
  {
  }
  
  /**
   * Print a summary of the logged in admin user's useful links and information.
   * Used in the sidebar. 
   *
   */
  public function executeAdminSummary()
  {
    $this->editorialteams = array();
    foreach ($this->getUser()->getGuardUser()->getEditorialTeams() as $aTeam)
    {
      $this->editorialteams[$aTeam->getId()] = $aTeam;
    }
  }
}