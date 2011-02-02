<?php
/**
 * This is the basic class file for the user management class built into Symfony
 * 
 * This class will probably not be used as we plan to use the extended features of the enhanced security module
 * 
 * PHP version 5
 * 
 * @author    Symfony auto-generated code <no@email.com>
 * @author    Russ Flynn <russ@linpro.no>
 * @copyright 2008 Linpro AS
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 */

/**
 * This is the basic class for the user management class built into Symfony
 * 
 * This class will probably not be used as we plan to use the extended features of the enhanced security module, 
 * but this does not mean it can be deleted. It is referenced in symfony/user/sfUser.class.php on line 107.
 * 
 * PHP version 5
 * 
 * @author    Symfony auto-generated code <no@email.com>
 * @author    Russ Flynn <russ@linpro.no>
 * @copyright 2008 Linpro AS
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 */
class myUser extends sfGuardSecurityUser
{
  /**
   * Return the number of artworks this user has submitted
   *
   * @param string $type The type to filter by
   * 
   * @return integer number of artworks
   */
  public function getArtworkCount($type = null)
  {
    return ReaktorArtworkPeer::countUserArtworks($this, $type);
  }
  
  /**
   * Return the user ID or false if not authed
   *
   * @return unknown
   */
  public function getId()
  {
    if ($this->isAuthenticated())
    {
      return $this->getGuardUser()->getId();
    }
    return false;
  }
  
  /**
   * Get the full name of the current user culture
   *
   * @return string The culture name
   */
  public function getCultureName()
  {
    $c = new Criteria();
    $c->add(CataloguePeer::TARGET_LANG, $this->getCulture());
    
    $catalogueRow = CataloguePeer::doSelectOne($c);
    
    if ($catalogueRow)
    {
      return $catalogueRow->getDescription();
    }
  }
  
  /**
   * Adding some functionality to the plugin signin function, need to set the reaktor login timestamp
   * Will be useful for seeing which users from the Prototype have used the new Reaktor, and when they came
   *
   * @param myUser   $user      The user object that has just signed in
   * @param boolean  $remember  Whethe the remember me checkbox was checked (or from cookie etc)
   * @param criteria $con       Extra criteria to pass to the save function
   */
  public function signIn($user, $remember = false, $con = null)
  {
    if (!$user->getFirstReaktorLogin())
    {
      $user->setFirstReaktorLogin(time());
    }
    parent::signIn($user, $remember, $con);
  }
}