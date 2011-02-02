<?php
/**
 * The main class file for the home module
 * 
 * This is currently the default script that is loaded when a user
 * navigates to the site root as defined in the routing.yml file
 *
 * PHP version 5
 * 
 * @author    Russ Flynn <russ@linpro.no>
 * @copyright 2008 Linpro AS
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 */

/**
 * The main class for the home module
 * 
 * This is currently the default class that is loaded when a user 
 * navigates to the site root as defined in the routing.yml file
 * 
 * PHP version 5
 * 
 * @author    Russ Flynn <russ@linpro.no>
 * @copyright 2008 Linpro AS
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 */
class homeActions extends sfActions
{
  /**
   * Executes index action, since there is nothing here at the moment 
   * templates/indexSuccess.php would be processed
   * 
   * @return void
   *
   */
  public function executeIndex()
  {
    $this->setFlash('subreaktor', '', true);
    $limit = sfConfig::get('app_home_list_length', 5);
    $this->last = ReaktorArtworkPeer::getLatestSubmittedApproved($limit+1);
  }

  /**
   * Execute phpinfo template
   * 
   * @return void
   *
   */
  public function executePhpinfo()
  {
    $this->forward404Unless($this->getUser()->hasCredential("mustbeasuperadmin"));
  }
  
  /**
   * Execute error404 template
   * 
   * @return void
   *
   */
  public function executeError404()
  {
    // Lets check if a user is trying to access a i18n page without the correct URL
    if (!$this->getRequestParameter("sf_culture") && isset($_SERVER['REDIRECT_URL']))
    {
      $this->redirect($_SERVER['REDIRECT_URL']);
    }
  }  
}
