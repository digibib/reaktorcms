<?php
/**
 * RSS Feeds
 *
 * PHP Version 5
 *
 * @author    Russ Flynn <russ@linpro.no>
 * @copyright 2008 Linpro AS
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 *
 */

/**
 * RSS feed actions class
 *
 * PHP Version 5
 *
 * @author    Russ Flynn <russ@linpro.no>
 * @copyright 2008 Linpro AS
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 *
 */
class feedActions extends sfActions
{
  
  /**
   * @var sfAtom1Feed
   */
  protected $_atomFeed; 
  
  /**
   * Subreaktor object if found
   *
   * @var subreaktor
   */
  protected $_subreaktor = null;
  
  /**
   * LokalReaktor (subreaktor) object if found
   *
   * @var subreaktor
   */
  protected $_lokalReaktor = null;
  
  /**
   * Extra title information for subreaktors
   *
   * @var string
   */
  protected $_subreaktorTitle = '';
  
  /**
   * Pre execute tasks - using this to make sure all the following actions use 
   * the same template unless specified otherwise.
   *
   * @return null executes tasks before actions
   */
  public function preExecute()
  {
    sfConfig::set('sf_web_debug', false);
    
    $this->setTemplate('feed');
    $this->_atomFeed = new sfAtom1Feed();

    $this->_atomFeed->initialize(array(
      'authorEmail' => sfConfig::get('app_rss_email'),
      'authorName'  => sfConfig::get('app_rss_authorname'),
      'feedUrl'     => $this->getContext()->getRequest()->getUri(),
    ));

    // These should be null if none provided, which works for the following queries
    $this->_lokalReaktor = Subreaktor::getProvidedLokalReference();
    $this->_subreaktor   = Subreaktor::getProvidedSubreaktorReference();

    // Add subreaktor info to title
    if ($this->_lokalReaktor && $this->_subreaktor)
    {
      $this->_subreaktorTitle = ' in '.$this->_lokalReaktor.' ('.$this->_subreaktor.')';
    }
    elseif ($this->_lokalReaktor)
    {
      $this->_subreaktorTitle = ' in '.$this->_lokalReaktor;
    }
    elseif ($this->_subreaktor)
    {
      $this->_subreaktorTitle = ' in '.$this->_subreaktor;
    }
    
  }
  
  /**
   * Executes main feed action for artwork feeds
   *
   * @return void Renders the feedsuccess template
   */
  public function executeArtworkFeed()
  {
    $custom = array();
   
    $c     = new Criteria();
    $limit = sfConfig::get('app_rss_artwork_items', 5);
    $c->setLimit($limit);
    
    $route = '@show_artwork'; // Use the show_artwork route by default
    $link  = ''; //Use home URL by default
    $slug  = $this->getRequestParameter('slug');

    // Check for special feeds (like tags)
    if (strpos($slug, 'tagged_with') !== false || strpos($slug, 'in_category') !== false || strpos($slug, 'users_by') !== false)
    {
      $slugArray = explode("_", $slug);
      if ($slugArray[0] == 'articles')
      {
        $article = true;
        array_shift($slugArray);
      }
      else
      {
        $article = false;
      }
      $slug      = array_shift($slugArray).'_'.array_shift($slugArray);
      $params    = $slugArray;
    }

    switch($slug)
    {
      case 'latest_artworks':
        
        $title = 'latest artworks';
        //Should use the exact same query as the original list
        $entries = ReaktorArtworkPeer::getLatestSubmittedApproved($limit, null, null, $this->_subreaktor, $this->_lokalReaktor);
        break;

      case 'latest_comments':

        $title = sfContext::getInstance()->getI18N()->__('latest comments');
        $entries = sfComment::getReaktorsLatestComments($this->_subreaktor, $limit, $this->_lokalReaktor);
        break;

      case 'latest_commented':
        
        $title = sfContext::getInstance()->getI18N()->__('latest commented');
        $entries = ReaktorArtworkPeer::getLatestCommented($limit);
        break;

      case 'latest_users':
        
        $route = '@portfolio';
        $title = sfContext::getInstance()->getI18N()->__('latest users');
        $entries = sfGuardUserPeer::getLastUsers($limit, false, $this->_subreaktor, $this->_lokalReaktor);
        break;

      case 'most_popular':
        $title = sfContext::getInstance()->getI18N()->__('most popular');
        $entries = ReaktorArtworkPeer::mostPopularArtworks($this->_subreaktor, $limit, $this->_lokalReaktor);
        break;

      case 'tagged_with':
        $entries = array();
        $result = TagPeer::getObjectsTaggedWith($params, array('parent_approved' => true, 'approved' => true));
        if ($article)
        {
          $route = '@article';
          foreach($result as $entry)
          {
            // Filter out not-articles and internals articles
            if (!($entry instanceof Article) || $entry->getArticleType() == ArticlePeer::INTERNAL_ARTICLE)
            {
              continue;
            }
            $entries[] = $entry;
          }
        }
        // Not article..
        else
        {
          $route = '@show_artwork';
          // If it is an reaktorFile then we want the artworks it belongs to, 
          // not the file it self
          foreach($result as $entry)
          {
            if ($entry instanceof reaktorFile)
            {
              foreach($entry->getParentArtworks() as $artwork)
              {
                $entries[] = $artwork;
              }
            }
            else
            {
              $entries[] = $entry;
            }
          }
        }
        $title   = sfContext::getInstance()->getI18N()->__('Tagged with %tags%', array('%tags%' => implode(', ', $params)));
        break;
      
      case 'in_category':
        $entries = CategoryArtworkPeer::getArtworksInCategory($params[0]);
        $title   = sfContext::getInstance()->getI18N()->__('Tagged with %tags%', array('%tags%' => implode(', ', $params)));
        $route   = '@show_artwork';
        break;

      case 'users_by':
        $entries = sfGuardUserPeer::getUsernamesStartingWith($params[0]);
        $title   = sfContext::getInstance()->getI18N()->__('users starting with %char%', array('%char%' => $params[0]));
        $route = '@portfolio';
        break;

      case 'recommended_artwork':
        $title   = sfContext::getInstance()->getI18N()->__('Recommended');
        $entries = array();
        $lid = $this->_lokalReaktor ? Subreaktor::getProvidedLokalreaktor()->getId() : null;
        $sid = $this->_subreaktor ? Subreaktor::getProvidedSubreaktor()->getId() : null;

        if ($this->_lokalReaktor) 
        {
          $tentries = RecommendedArtworkPeer::getRecommendedArtwork($lid, $sid, true, $limit);
        } 
        elseif ($this->_subreaktor) 
        {
          $tentries = RecommendedArtworkPeer::getRecommendedArtwork($sid, null, true, $limit);
        } 
        else 
        {
          $tentries = RecommendedArtworkPeer::getRecommendedArtwork(null, null, true, $limit);
        }

        foreach($tentries as $entry) 
        {
          $entries[] = new genericArtwork($entry->getArtwork());
        }
        break;

    }

    /* Unable to create static link names, have to parse the type from the url */
    switch(substr_count($slug, "_")) {
      // popular_subreaktor, i.e popular_foto
      case 1:
        list ($popular, $ssubreaktor) = explode("_", $slug, 2);
        try {
          $subreaktor = Subreaktor::getByReference($ssubreaktor);
          $title = sfContext::getInstance()->getI18N()->__($slug);
          $entries = ReaktorArtworkPeer::mostPopularArtworks($subreaktor, $limit, $this->_lokalReaktor);
        } catch(Exception $e) {
        }
        break;

      /* [username_][favourite/latest][_module][_username], examples:
       * monkeyboy_favourite_user       // monkeyboys favourite users
       * monkeyboy_favourite_artworks   // monkeyboys favourite artworks
       * favorite_user_monkeyboy        // users who are favourite with monkeyboy
       *
       * monkeyboy_latest_commented     // Last commented monkeyboys artworks
       */
      case 2:
        list ($username, $str, $module) = explode("_", $slug, 3);
        $fav_obj = new Favourite();

        switch($module)
        {
          case "comments":
            switch($str)
            {
              case "written":
                $title = sprintf("%ss latest comments", $username);
                $entries = sfComment::getLatestWrittenComments(sfGuardUserPeer::getByUsername($username)->getId());
                break;
              case "received":
                $title = sprintf("%ss recently received comments", $username);
                $entries = sfComment::getLatestReceivedComments(sfGuardUserPeer::getByUsername($username)->getId());
                break;
            }
            break;

          case "commented":
            $title = sprintf("%ss latest commented artworks", $username);
            $entries = sfComment::getLatestCommented(sfGuardUserPeer::getByUsername($username)->getId());
            break;

          case "artwork":
          case "article":
          case "user":
            $user = sfGuardUserPeer::getByUsername($username);

            $title = sprintf("%ss favourite %ss", $user->getUsername(), $module);
            $entries = $fav_obj->getMyLastFavs($module, $user->getId(), $limit);

            if ($module == "artwork")
            {
              $route   = '@show_artwork';
              $custom["link"] = "getArtworkLink";
            }
            elseif ($module == "user")
            {
              $route   = '@portfolio';
            }
            elseif ($module == 'article')
            {
            	$route = '@article';
            }
            break;

          default:
            // Twisted logic. Users who have marked "monkeyboy" as favourite
            if ($username != "favourite")
            {
              break;
            }

            $username = $module;
            $module = $str;
            $route = '@portfolio';
            $user = sfGuardUserPeer::getByUsername($username);
            $title = sprintf("%s favourite with", $user->getUsername());
            $entries = $fav_obj->getLastFavs($module, $user->getId(), $limit);
            break;
        }
        break;

    } 

    if (!isset($entries))
    {
      $this->redirect404();
    }
    
    if (($route == '@show_artwork' || $route == '@article' || $route == '@show_artwork_file') && strpos($slug, "comment") === false)
    {
      $custom["title"] = 'getCustomFeedTitle';
      if ($route == "@article") {
          $custom["link"] = "getFeedPermalink";
      }
    }

    if (Subreaktor::isProvided())
    {
      $route = str_replace('@', '@subreaktor', $route);
    }
    
    $this->_atomFeed->setLink($link); 
    $this->_atomFeed->setTitle(sfConfig::get('app_rss_title').' - '.$title.$this->_subreaktorTitle);
    $resultItems = sfFeedPeer::convertObjectsToItems($entries, array('routeName' => $route, 'methods' => $custom));
    
    $this->_atomFeed->addItems($resultItems);
    
    $this->feed = $this->_atomFeed;
  }

  public function executeFileFeed()
  {
    $artwork = new genericArtwork($this->getRequestParameter('id'));
    $title = $artwork->getTitle();
    $entries = $artwork->getFiles();
    $this->_atomFeed->setTitle(sfConfig::get('app_rss_title').' - '.$title.$this->_subreaktorTitle);
    $resultItems = sfFeedPeer::convertObjectsToItems($entries);
    
    $this->_atomFeed->addItems($resultItems);
    
    $this->feed = $this->_atomFeed;

  }
  /**
   * Template for displaying a list of RSS feeds which are available around the site
   * 
   * @return null Just process the template
   */
  public function executeList()
  {
    $this->setTemplate('list');
  }

  public function executeUserFeed()
  {
    $limit    = sfConfig::get('app_rss_artwork_items', 5);
    $slug     = $this->getRequestParameter('slug');
    $username = $this->getRequestParameter('username');
    $route    = '@portfolio';

    switch($slug)
    {
      case 'shared_interest':
        $title    = sfContext::getInstance()->getI18N()->__('shared interest');
        $user = sfGuardUserPeer::getByUsername($username);
        if (!$user) {
          break;
        }
        $entries = sfGuardUserPeer::getUsersByMatchingInterests($user->getId(), $limit);
        break;
      case 'all':
        $max = $this->getRequestParameter("max", 5);
        if ($max == 0)
        {
          $max = PHP_INT_MAX;
        }
      	
        $title    = sfContext::getInstance()->getI18N()->__('All artworks');
        $user = sfGuardUserPeer::getByUsername($username);
        $route    = '@show_artwork';
        $entries = ReaktorArtworkPeer::getLatestSubmittedApprovedNotPaginated($max, $user->getId());
      	
      	break;
      /* $slug === subreaktor-reference */
      default:
        $sub = SubreaktorPeer::retrieveByReference($slug);
        if (!$sub)
        {
          break;
        }

        $user = sfGuardUserPeer::getByUsername($username);
        if (!$user)
        {
          break;
        }

        $max = $this->getRequestParameter("max", 5);
        if ($max == 0)
        {
          $max = PHP_INT_MAX;
        }

        $entries = ReaktorArtworkPeer::getLatestSubmittedApprovedNotPaginated($max, $user->getId(), $sub->getId());
        $route = '@show_artwork';
        $title = $sub->getName();
        break;
    }

    $c     = new Criteria();
    $c->setLimit($limit);

    if (!isset($entries))
    {
      $this->redirect404();
    }
    
    $this->_atomFeed->setTitle(sfConfig::get('app_rss_title').' - ' . $username. ' ' .$title);
    $resultItems = sfFeedPeer::convertObjectsToItems($entries, array('routeName' => $route));
    
    $this->_atomFeed->addItems($resultItems);
    
    $this->feed = $this->_atomFeed;
  }

  public function executeAdminFeed()
  {
    $slug   = $this->getRequestParameter('slug');
    $limit  = $this->getRequestParameter('limit');

    if ($limit < 1)
    {
      if ($limit == -1)
      {
        $limit = PHP_INT_MAX;
      }
      else
      {
        $limit = 5;
      }
    }
    if ($limit > 10 && !($this->getUser()->isAuthenticated() && $this->getUser()->hasCredential('staff')))
    {
      $limit = 5;
    }

    switch($slug)
    {
      case "users":
        $route = '@portfolio';
        $title = sfContext::getInstance()->getI18N()->__('latest users');
        $entries = sfGuardUserPeer::getLastUsers($limit, false, null, null);
        break;

      case "random_artwork":
        $random = true;
        $title = sfContext::getInstance()->getI18N()->__('random artworks');
      case "artworks":
        $route = '@show_artwork';
        if (!isset($random))
        {
          $random = false;
          $title = sfContext::getInstance()->getI18N()->__('latest artworks');
        }
        $entries = ReaktorArtworkPeer::getLatestSubmittedApproved($limit, null, $random, $this->_subreaktor, $this->_lokalReaktor);
        break;

      default:
        $this->forward404();
        break;
    }

    $this->_atomFeed->setTitle(sfConfig::get('app_rss_title').' - '.$title.$this->_subreaktorTitle);
    $result = sfFeedPeer::convertObjectsToItems($entries, array('routeName' => $route));
    $this->_atomFeed->addItems($result);
    $this->feed = $this->_atomFeed;
  }

  /**
   * This module has no index, forward all /index requests to 404
   * 
   * @return void
   */
  public function executeIndex()
  {
    $this->forward404();
  }
}

