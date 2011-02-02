<?php
/**
 * Sidebar components file
 * Some elements on the sidebar require a bit more logic than a partial can provide
 *
 * PHP Version 5
 *
 * @author    Russ Flynn <russ@linpro.no>
 * @copyright 2008 Linpro AS
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 *
 */

/**
 * Sidebar components class
 *
 * PHP Version 5
 *
 * @author    Russ Flynn <russ@linpro.no>
 * @copyright 2008 Linpro AS
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 *
 */
class sidebarComponents extends sfComponents
{
  
  /**
   * Display the main sidebar element
   *
   * @return void Template will be parsed
   */
  public function executeSidebar()
  {
    $residence = $subreaktor = $lokarreaktor = 0;

    if (Subreaktor::getProvidedSubreaktor() instanceof Subreaktor)
    {
      $subreaktor   = Subreaktor::getProvidedSubreaktor()->getId();
    }
    if (Subreaktor::getProvidedLokalreaktor() instanceof Subreaktor)
    {
      $lokarreaktor = Subreaktor::getProvidedLokalreaktor()->getId();
      $residence    = Subreaktor::getProvidedLokalreaktor()->getResidences();
    }

    //Get artwork count in subreaktor
    $apc_key = "artworkCount_r{$residence}_s{$subreaktor}_l{$lokarreaktor}";

    if (!function_exists("apc_store") || ! ($artwork_count = sfProcessCache::get($apc_key)) ) {
      $c = new Criteria();
      $c->add(ReaktorArtworkPeer::STATUS, 3);
      $c->addJoin(ReaktorArtworkPeer::USER_ID, sfGuardUserPeer::ID);
      $c->add(sfGuardUserPeer::SHOW_CONTENT, 1);
      $c->add(ReaktorArtworkPeer::DELETED, 0);
      $c->setDistinct();
      $c->addJoin(ReaktorArtworkPeer::ID, ReaktorArtworkFilePeer::ARTWORK_ID, Criteria::LEFT_JOIN);
      if (Subreaktor::getProvidedSubreaktor() instanceof Subreaktor)
      {
        $c->addJoin(ReaktorArtworkFilePeer::ARTWORK_ID, SubreaktorArtworkPeer::ARTWORK_ID, Criteria::LEFT_JOIN);
        $c->add(SubreaktorArtworkPeer::SUBREAKTOR_ID,  $subreaktor);
      }
      if (Subreaktor::getProvidedLokalreaktor() instanceof Subreaktor)
      {
        $c->addJoin(ReaktorArtworkFilePeer::ARTWORK_ID, LokalreaktorArtworkPeer::ARTWORK_ID, Criteria::LEFT_JOIN);
        $c->addJoin(LokalreaktorArtworkPeer::SUBREAKTOR_ID, LokalreaktorResidencePeer::SUBREAKTOR_ID, Criteria::LEFT_JOIN);
        $ctn = $c->getNewCriterion(LokalreaktorArtworkPeer::SUBREAKTOR_ID, $lokarreaktor);
        $ctn2 = $c->getNewCriterion(sfGuardUserPeer::RESIDENCE_ID, $residence, Criteria::IN);
        $ctn->addOr($ctn2);
        $c->add($ctn);        
      }
      
      $artwork_count = ReaktorArtworkPeer::doCount($c);
      
      if (function_exists("apc_store")) {
        sfProcessCache::set($apc_key, $artwork_count, 1800);
      }
    }

    $this->artwork_count = $artwork_count;
    $this->user_count    = sfGuardUserPeer::getOnlineCount();
    $action              = $this->getRequestParameter('action');
    $module              = $this->getRequestParameter('module');
    
    //Choose which articles to display, if any at all
    if (/*strpos($this->getRequest()->getUri(), 'admin') &&*/ $this->getUser()->hasCredential('staff')) //Display internal articles on admin pages
    {      
      $this->internal_articles = ArticlePeer::getByFieldAndOrType(ArticlePeer::INTERNAL_ARTICLE, 'date', null, null, ArticlePeer::PUBLISHED, 5);
    }
    

  }
  
  public function executeSidebarArticles()
  {
  	return '';
  }
}
