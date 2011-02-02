<?php
/**
 * The main file for profile actions.
 *
 * PHP version 5
 * 
 * @author    Ole Petter Wikene <olepw@linpro.no>
 * @copyright 2008 Linpro AS
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 */

class profileComponents extends sfComponents
{
  /*
   * Function for displaying the last created users
   * 
   * @return void
   */
  function executeLastUsers()
  {
    $limit = sfConfig::get('app_home_list_length', 5);
    $showcontent = !sfContext::getInstance()->getUser()->hasCredential('viewallcontent');
    $this->last = sfGuardUserPeer::getLastUsers($limit, $showcontent, $this->subreaktor, $this->lokalreaktor, true);
  }
  
  /**
   * Component for displaying and adding a users resources
   *
   * @return void
   */
  function executeResources()
  {
    $c = new Criteria();
    $c->add(UserResourcePeer::USER_ID, $this->user);
    //$c->setLimit(sfConfig::get('app_mypage_resources_length', 5));
    $this->resources = UserResourcePeer::doSelect($c);

    
  }
  /**
   * List users with matching interests, either all in a sidebar div, or a fixed length list
   * in a normal box.
   *
   * @return void
   */ 
  function executeMatchingInterests()
  {
    if ($this->all)
    {
      $this->users = sfGuardUserPeer::getUsersByMatchingInterests($this->user_id);
    }
    else
    {
      $this->users = sfGuardUserPeer::getUsersByMatchingInterests($this->user_id, sfConfig::get('app_home_list_length', 5));
    }
  }
  
  /**
   * Component for displaying userinfo on portifolio page
   *
   * @return void
   */
  function executePortfolioUserinfo()
  {
    $c = new Criteria();
    $username = $this->getRequestParameter('user');
    $c->add(sfGuardUserPeer::USERNAME,$username);
    $c->addJoin(sfGuardUserPeer::RESIDENCE_ID, ResidencePeer::ID, Criteria::LEFT_JOIN);
    //$user = sfGuardUserPeer::doSelectJoinResidence($c);
    $user = sfGuardUserPeer::doSelect($c);
    $this->user = array_shift($user);

    if (!$this->user)
    {
      return 0;
    }

    $c2 = new Criteria();
    $c2->add(UserInterestPeer::USER_ID, $this->user->getId());
    $this->interests = UserInterestPeer::doSelectJoinSubreaktor($c2);
    
  }
  
  function executeGetLoggedInStatus()
  {
    $this->status = sfGuardUserPeer::isUserOnline($this->userid) && $this->user->getShowLoginStatus();
  }
  
  function executeMostActiveUsers() 
  {
    $this->active = sfGuardUserPeer::getMostActiveSince(time()-2592000,array(11,12),20);
  }
}

?>
