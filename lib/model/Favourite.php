<?php
/**
 * Reaktor file class - the entry point for all actions regarding
 * an uploaded file on the system
 *
 * PHP version 5
 *
 * @author    Ole-Petter Wikene <olepw@linpro.no>
 * @copyright 2008 Linpro AS
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 * @package lib.model
 */


class Favourite extends BaseFavourite
{
	/**
	 * Searching for my favourites or my friend favourites
	 *
	 * @var mixed
	 * @access public
	 */
	static $myfavs = false;

	/**
	 * Searching for friends or artworks
	 *
	 * @var string
	 * @access public
	 */
	static $type   = "";


	function getLastFavs($type,$artwork_or_user,$limit=null)
	{
		self::$myfavs = false;
		self::$type   = $type;

		$c = new Criteria();
		//$c->addJoin(FavouritePeer::USER_ID,sfGuardUserPeer::ID);
		$c->add(FavouritePeer::FAV_TYPE,$type);
		if ($type == "artwork")
    {
      $type_const = FavouritePeer::ARTWORK_ID;
    }
		elseif($type == "user")
    {
      $type_const = FavouritePeer::FRIEND_ID;
    }
    elseif($type == "article")
    {
      $type_const = FavouritePeer::ARTICLE_ID;
    }
		$c->add($type_const,$artwork_or_user);
		$c->addDescendingOrderByColumn(FavouritePeer::ID);
		if ($limit)
		$c->setLimit($limit);
		switch ($type)
		{
			case 'artwork':
				//$c->addJoin(FavouritePeer::ARTWORK_ID,ReaktorArtworkPeer::ID);
				$c->add(ReaktorArtworkPeer::STATUS, 3);
				return FavouritePeer::doSelectJoinReaktorArtwork($c);
				break;
			case 'user':
				return FavouritePeer::doSelectJoinsfGuardUserRelatedByUserId($c);
				break;
      case 'article':
        $c->add(ArticlePeer::STATUS, ArticlePeer::PUBLISHED);
        return FavouritePeer::doSelectJoinArticle($c);
			default:
				break;
		}
		return FavouritePeer::doSelect($c);
	}

	/**
	 * List of latest artworks or user
	 *
	 * @param string $type
	 * @param int $artwork_or_user
	 * @param int $limit
	 * @return array Favourite
	 */
	function getMyLastFavs($type,$artwork_or_user,$limit=null)
	{
		self::$myfavs = true;
		self::$type   = $type;

		$c = new Criteria();
		//$c->addJoin(FavouritePeer::USER_ID,sfGuardUserPeer::ID);
		$c->add(FavouritePeer::FAV_TYPE,$type);
		$c->add(FavouritePeer::USER_ID,$artwork_or_user);
		$c->addDescendingOrderByColumn(FavouritePeer::ID);
		if ($limit)
    {
      $c->setLimit($limit);
    }
		switch ($type)
		{
			case 'artwork':
				//$c->addJoin(FavouritePeer::ARTWORK_ID,ReaktorArtworkPeer::ID);
				$c->add(ReaktorArtworkPeer::STATUS, 3);
				return FavouritePeer::doSelectJoinReaktorArtwork($c);
				break;
			case 'user':
				return FavouritePeer::doSelectJoinsfGuardUserRelatedByFriendId($c);
				//$c->addJoin(FavouritePeer::FRIEND_ID,SfGuardUserPeer::ID);
				break;
      case 'article':
        $c->add(ArticlePeer::STATUS, ArticlePeer::PUBLISHED);
        return FavouritePeer::doSelectJoinArticle($c);
			default:
				break;
		}
		return FavouritePeer::doSelect($c);
	}


	function getIsFavourite($user_id,$artwork_or_userid,$fav_type)
	{
		if ($fav_type == "artwork")
    {
      $type_const = FavouritePeer::ARTWORK_ID;
    }
		elseif($fav_type == "user")
    {
      $type_const = FavouritePeer::FRIEND_ID;
    }
    elseif($fav_type == "article")
    {
      $type_const = FavouritePeer::ARTICLE_ID;
    }

		$c = new Criteria();
		$c->add($type_const,$artwork_or_userid);
		$c->add(FavouritePeer::USER_ID,$user_id);
		$c->add(FavouritePeer::FAV_TYPE,$fav_type);
		return count(FavouritePeer::doSelect($c));

	}

	static function deleteFavourite($artwork_or_user_id,$type,$userId)
	{
		if ($type == "artwork")
    {
      $type_const = FavouritePeer::ARTWORK_ID;
    }
		elseif($type == "user")
    {
      $type_const = FavouritePeer::FRIEND_ID;
    }
    elseif($type == "article")
    {
      $type_const = FavouritePeer::ARTICLE_ID;
    }

		$c = new Criteria();
		$c->add(FavouritePeer::USER_ID,$userId);
		$c->add($type_const,$artwork_or_user_id);
		$c->add(FavouritePeer::FAV_TYPE,$type);
		$fav_obj = FavouritePeer::doSelectOne($c);
		if ($fav_obj)
    {
      $fav_obj->delete();
    }
	}

	static function addFavourite($artwork_or_user_id,$type,$userId)
	{
		$fav_obj = new Favourite();
		$fav_obj->setUserId($userId);
		$c = new Criteria();
    		$c->add(FavouritePeer::USER_ID,$userId);
		if ($type == "artwork")
    {
      $c->add(FavouritePeer::ARTWORK_ID,$artwork_or_user_id);
    	$fav_obj->setArtworkId($artwork_or_user_id);
    }
		elseif ($type == "user")
    {
    	$c->add(FavouritePeer::FRIEND_ID,$artwork_or_user_id);
      $fav_obj->setFriendId($artwork_or_user_id);
    }
    elseif ($type == "article")
    {
    	$c->add(FavouritePeer::ARTICLE_ID,$artwork_or_user_id);
      $fav_obj->setArticleId($artwork_or_user_id);
    }
    $c->add(FavouritePeer::FAV_TYPE,$type);
		$fav_obj->setFavType($type);
		if (!FavouritePeer::doSelectOne($c))
		{
		  $fav_obj->save();
		}
		
		//Update logged in user's last active flag
		sfContext::getInstance()->getUser()->getGuardUser()->setLastActive(date('Y-m-d H:i:s'));    
    sfContext::getInstance()->getUser()->getGuardUser()->save();

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

	public function getCustomFeedTitle()
	{
		return $this->getFeedTitle();
	}
	
	/**
	 * Required by the Feed plugin to generate routes automatically
	 * Returns the favourite artwork title/username
	 *
	 * @return string the title for the feed element
	 */
	public function getFeedTitle()
	{
		switch($this->getFavType())
		{
			case "user":
				return $this->getFeedUser();
			case "artwork":
				return $this->getReaktorArtwork()->getTitle();
			case "article":
				return $this->getArticle()->getTitle();
		}
	}
	
	public function getFeedPermalink()
	{
	  switch ($this->getFavType())
	  {
	    case 'article':
	      return $this->getArticle()->getLink();
	  }
	}
  public function getArtworkLink() {
      return sprintf('@show_artwork?id=%d&title=%s', $this->getReaktorArtwork()->getId(), $this->getReaktorArtwork()->getTitle());
  }

	/**
	 * Returns instance of the user object in question
	 *
	 * @return sfGuardUser
	 */
	public function getUserObject()
	{
		switch(self::$myfavs) {
			case 0:
				return $this->getSfGuardUserRelatedByUserId();
			case 1:
				return $this->getSfGuardUserRelatedByFriendId();
		}
	}

	/**
	 * Required by the Feed plugin to generate routes automatically
	 *
	 * @return string the username of the friend
	 */
	public function getFeedUser()
	{
		if (self::$type != "user")
		{
			return null;
		}

		return $this->getUserObject()->getUsername();
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
	 
	public function getFeedUniqueId()
	{
		return sfContext::getInstance()->getController()->genUrl("@portfolio?user={$this->getFeedUser()}", true);
	}
	public function getFeedDescription() 
	{
		if (self::$type == 'article')
		{
			return $this->getArticle()->getTitle();
		}
		elseif (self::$type != "user")
		{
			return $this->getReaktorArtwork()->getDescription();
		}

		$user = $this->getUserObject();
		$desc = $user->getDescription();

		// If we have description, then return it
		if (trim($desc))
		{
			return $desc;
		}
		// Otherwise say "member since.." to make sure the feed is valid
		return "Member since: " . $user->getCreatedAt();

	}
}

