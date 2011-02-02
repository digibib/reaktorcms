<?php
/**
 * Subclass for representing a row from the 'sf_comment' table.
 *
 * PHP Version 5
 *
 * @author    Russ Flynn <russ@linpro.no>
 * @copyright 2008 Linpro AS
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 *
 */

class sfComment extends BasesfComment
{
  protected 
    $user = null,
    $artwork = null;
  
  public function setArtwork($artwork)
  {
    $this->artwork = $artwork;
  }

  public function setUser($user)
  {
    $this->user = $user;
  }

  public function getArtwork()
  {
  if (!$this->artwork)
  {
    $this->artwork = ReaktorArtworkPeer::retrieveByPk($this->getCommentableId());
  }
    return $this->artwork;
  }

  public function getUser()
  {
  if (!$this->user)
  {
    $this->user = sfGuardUserPeer::retrieveByPK($this->getAuthorId());
  }
  return $this->user;
  }

  /**
   * Get latest commented artworks that belongs to a user
   *
   * @param integer $user_id
   * @return array comment objects
   */
  public static function getLatestCommented($user_id)
  {
    $c = new Criteria();
    $c->add(sfCommentPeer::COMMENTABLE_MODEL, 'ReaktorArtwork');
    $c->add(sfCommentPeer::NAMESPACE, 'frontend');
    $c->add(sfCommentPeer::UNSUITABLE, 2, Criteria::NOT_EQUAL);
    $c->add(sfCommentPeer::AUTHOR_ID, $user_id, Criteria::NOT_EQUAL);
    $c->add(ReaktorArtworkPeer::STATUS, 3, Criteria::EQUAL);
    $c->add(ReaktorArtworkPeer::USER_ID, $user_id);
    $c->addGroupByColumn(ReaktorArtworkPeer::TITLE);
    $c->setLimit(5);
    return sfCommentPeer::doSelectJoinUserAndArtwork($c);
  
  }
  
  /**
   * Get latest comments a user has written
   *
   * @param integer $user_id
   * @param integer $count
   * @return array comment object
   */
  public static function getLatestWrittenComments($user_id, $count = 5)
  {
    $c = new Criteria();
    $c->add(sfCommentPeer::COMMENTABLE_MODEL, 'ReaktorArtwork');
    $c->add(sfCommentPeer::NAMESPACE, 'frontend');    
    $c->add(sfCommentPeer::AUTHOR_ID, $user_id);
    $c->setLimit($count);
    $c->addDescendingOrderByColumn(sfCommentPeer::CREATED_AT);
    return sfCommentPeer::doSelectJoinUserAndArtwork($c);
  }
  
  /**
   * Get latests comments from artworks that belong to a subreaktor or lokalreaktor.
   * 
   * Comments are included if it belongs to an artwork with the given lokalreaktor as a category,
   * or if the user who owns the artworks has a residence that belong to the lokalReaktor.
   * 
   * This means a user do not have to belong to the lokalreaktor to have it's comments included, 
   * similarily all comments made by a user who does belong to the lokalreaktor isn't included. 
   *
   * @param string $subreaktor
   * @param int $count
   * @return array sfComment 
   */
  public static function getReaktorsLatestComments($subreaktor = null, $count = 5, $lokalreaktor = null)
  { 
    $c = new Criteria();
    
    $c->add(sfCommentPeer::COMMENTABLE_MODEL, 'ReaktorArtwork');
    $c->add(sfCommentPeer::NAMESPACE, 'frontend');     
    $c->add(sfCommentPeer::UNSUITABLE, 2, Criteria::NOT_EQUAL);
    $c->add(ReaktorArtworkPeer::STATUS, 3);
    
    $c->addJoin(sfCommentPeer::COMMENTABLE_ID, ReaktorArtworkPeer::ID, Criteria::LEFT_JOIN);
    $c->addJoin(ReaktorArtworkPeer::USER_ID, sfGuardUserPeer::ID, Criteria::LEFT_JOIN);
    
    if ($subreaktor instanceof Subreaktor)
    {
      $c->addJoin(ReaktorArtworkPeer::ID, SubreaktorArtworkPeer::ARTWORK_ID, Criteria::LEFT_JOIN);
      $c->add(SubreaktorArtworkPeer::SUBREAKTOR_ID, $subreaktor->getId());
    }
    elseif (Subreaktor::getProvidedSubreaktor() instanceof Subreaktor)
    {
      $c->addJoin(ReaktorArtworkPeer::ID, SubreaktorArtworkPeer::ARTWORK_ID, Criteria::LEFT_JOIN);
      $c->add(SubreaktorArtworkPeer::SUBREAKTOR_ID, Subreaktor::getProvidedSubreaktor()->getId());
    }
    
    if ($lokalreaktor instanceof Subreaktor)
    {      
      $c->addJoin(ReaktorArtworkPeer::ID, LokalreaktorArtworkPeer::ARTWORK_ID, Criteria::LEFT_JOIN);
      $c->addJoin(LokalreaktorArtworkPeer::SUBREAKTOR_ID, LokalreaktorResidencePeer::SUBREAKTOR_ID, Criteria::LEFT_JOIN);
      $ctn = $c->getNewCriterion(LokalreaktorArtworkPeer::SUBREAKTOR_ID, $lokalreaktor->getId());
      $ctn2 = $c->getNewCriterion(sfGuardUserPeer::RESIDENCE_ID, $lokalreaktor->getResidences(), Criteria::IN);
      $ctn->addOr($ctn2);
      $c->add($ctn);
      
    }
    elseif (Subreaktor::getProvidedLokalreaktor() instanceof Subreaktor)
    {
      $c->addJoin(ReaktorArtworkPeer::ID, LokalreaktorArtworkPeer::ARTWORK_ID, Criteria::LEFT_JOIN);
      $c->addJoin(LokalreaktorArtworkPeer::SUBREAKTOR_ID, LokalreaktorResidencePeer::SUBREAKTOR_ID, Criteria::LEFT_JOIN);
      $ctn = $c->getNewCriterion(LokalreaktorArtworkPeer::SUBREAKTOR_ID, Subreaktor::getProvidedLokalreaktor()->getId());
      $ctn2 = $c->getNewCriterion(sfGuardUserPeer::RESIDENCE_ID, Subreaktor::getProvidedLokalreaktor()->getResidences(), Criteria::IN);
      $ctn->addOr($ctn2);
      $c->add($ctn); 

    }

    $c->addDescendingOrderByColumn(sfCommentPeer::CREATED_AT);    
    $c->setLimit($count); 
    $c->setDistinct();
    return sfCommentPeer::doSelect($c);
  }
  
  /**
   * Get latest comments a user has received
   *
   * @param integer $user_id
   * @param integer $count
   * @return array comment object
   */
  public static function getLatestReceivedComments($user_id, $count = 5)
  {
    $c = new Criteria();
    $c->add(sfCommentPeer::COMMENTABLE_MODEL, 'ReaktorArtwork');
    $c->add(sfCommentPeer::NAMESPACE, 'frontend');    
    $c->add(sfCommentPeer::AUTHOR_ID, $user_id, Criteria::NOT_EQUAL);
    $c->add(ReaktorArtworkPeer::USER_ID, $user_id);
    $c->setLimit($count);
    $c->addDescendingOrderByColumn(sfCommentPeer::CREATED_AT);
    return sfCommentPeer::doSelectJoinUserAndArtwork($c);
  }

   /**
   * Required by the Feed plugin to generate routes automatically
   *
   * @return string The culture in question, "no" if none specified
   */
  public function getFeedsfCulture()
  {
    return sfContext::getInstance()->getRequest()->getParameter('sf_culture', 'no');
  }
  
  /**
   * Get the provided subreaktor for Feed generator
   *
   * @return subreaktor|null
   */
  public function getFeedSubreaktor()
  {
    if (subreaktor::isValid())
    {
      return Subreaktor::getProvided();
    }
  }
  
  /**
   * Return the parent artwork title rather than the comment title
   * This is so the link back to the artwork is correct
   *
   * @return string the artwork title
   */
  public function getFeedTitle()
  {
    return $this->getArtwork()->getTitle();
  }
  
  /**
   * Return the parent artwork Id rather than the comment Id
   * This is so the link back to the artwork is correct
   *
   * @return integer the artwork ID
   */
  public function getFeedId()
  {
    return $this->getArtwork()->getId();
  }
  
  /**
   * Return the feed title and text for use in the RSS body
   *
   * @return string the title and text of the comment
   */
  public function getFeedDescription()
  {
    return $this->getTitle().' - '.$this->getText();
  }
  
  /**
   * Generate valid absolute url for Atom IDs
   * NOTE: The URL generated is for the artwork, including the comment fragment 
   * 
   * @return string the artwork absolute URL
   */
  public function getFeedUniqueId()
  {
    return sfContext::getInstance()->getController()->genUrl($this->getArtwork()->getLink(), true) . "#message_" . $this->getId();
  }

  
}


