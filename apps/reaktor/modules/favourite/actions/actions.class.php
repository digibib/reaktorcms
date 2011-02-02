<?php

/**
 * Actions class for artwork view
 *  
 * PHP version 5
 * 
 * @author    Ole-Petter Wikene <olepw@linpro.no>
 * @copyright 2008 Linpro AS
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 */
 

class favouriteActions extends sfActions
{

  function executeAdd()
  {
    if (!$this->getRequest()->isXmlHttpRequest() || !$this->getUser()->hasCredential('markfavourite'))
    {
      $this->forward404();
    }
    $this->article_id = 0;
    $this->artwork_or_user_id = $this->getRequestParameter('id');
    Favourite::ADDFavourite($this->getRequestParameter('id'),$this->getRequestParameter('type'),$this->getUser()->getGuardUser()->getId());

    $this->type = $this->getRequestParameter('type');
    $this->both = $this->getRequestParameter('both');
    if ($this->both)
    {
      $this->artwork_id = $this->getRequestParameter('artwork_id');
      $this->user_id = $this->getRequestParameter('user_id');
    }
    else
    {
      $this->artwork_id = $this->user_id = 0;
    }
    if ($this->type == "article")
    {
      $this->article_id = $this->getRequestParameter('id');
    }
  }

  function executeRemove()
  {
	  
  	  if (!$this->getRequest()->isXmlHttpRequest() || !$this->getUser()->hasCredential('markfavourite'))
	  {
	    $this->forward404();
	  }
	  $this->both = $this->getRequestParameter('both');
	  if ($this->both)
	  {
	  	$this->artwork_id = $this->getRequestParameter('artwork_id');
	  	$this->user_id = $this->getRequestParameter('user_id');
	  }
	  if (!$this->getRequestParameter('who')) 
	  {
	    $this->artwork_or_user_id = $this->getRequestParameter('id');
	  }
	  else
	  {
	    $this->artwork_or_user_id = $this->getUser()->getGuardUser()->getId();
	  }
	  Favourite::deleteFavourite($this->getRequestParameter('id'),$this->getRequestParameter('type'),$this->getUser()->getGuardUser()->getId());
	  
	  $this->who = $this->getRequestParameter('who');
	  $this->type = $this->getRequestParameter('type');
	  $fav_obj = new Favourite();
	  
	  if (!$this->who)
	  {
	    $this->favourites = null;//$fav_obj->getLastFavs($this->getRequestParameter('type'),$this->getRequestParameter('id'));
	  }
	  else
	  {
	    $this->favourites = $fav_obj->getMyLastFavs($this->getRequestParameter('type'),$this->getUser()->getGuardUser()->getId());
	  }
    if ($this->type == "article")
    {
      $this->article_id = $this->getRequestParameter('id');
      $this->list = $this->type;
    }
    else {
      $this->article_id = 0;
    }
  }
  
  function executeListAll()
  {
    if (!$this->getRequest()->isXmlHttpRequest())
    {
      $this->forward404();
    }
    $this->who = $this->getRequestParameter('who');  
    $fav_obj = new Favourite();
    if (!$this->who)
    {
      $this->favourites = $fav_obj->getLastFavs($this->getRequestParameter('type'),$this->getRequestParameter('id'));
    }
    else
    {
      $this->favourites = $fav_obj->getMyLastFavs($this->getRequestParameter('type'),$this->getRequestParameter('id'));
    }
    $this->type = $this->getRequestParameter('type');
    
    $this->artwork_or_user_id = $this->getRequestParameter('id');
    if ($this->getUser()->isAuthenticated())
    {
      $this->isFavourite = $fav_obj->getIsFavourite($this->getUser()->getGuardUser()->getId(),$this->artwork_or_user_id,$this->type);
      $username = sfGuardUserPeer::retrieveByPK($this->getRequestParameter('id'));
    } else
    {
       $user = sfGuardUserPeer::retrieveByPK($this->artwork_or_user_id);
       $username = $user->getUserName();
    }
    $this->header = $this->getRequestParameter("header", null);
    //$this->favouriteCount = count($this->favourites);
    $this->listOwner = $username;
    if ($this->type == 'artwork')
    {
        if (!$this->who)
        {
            $this->artwork = new genericArtwork($this->artwork_or_user_id);
        }
    }
  }
  
  function executeListLast()
  {
    $this->hasMoreFavorites = true;
    if (!$this->getRequest()->isXmlHttpRequest())
    {
      $this->forward404();
    }
    $this->who = $this->getRequestParameter('who');  
    $fav_obj = new Favourite();
    if (!$this->who)
      $this->favourites = $fav_obj->getLastFavs($this->getRequestParameter('type'),$this->getRequestParameter('id'),6);
    else
      $this->favourites = $fav_obj->getMyLastFavs($this->getRequestParameter('type'),$this->getRequestParameter('id'),6);
    
      
    $this->type = $this->getRequestParameter('type');
    $this->artwork_or_user_id = $this->getRequestParameter('id');
    
    if ($this->getUser()->isAuthenticated())
    {
      $this->isFavourite = $fav_obj->getIsFavourite($this->getUser()->getGuardUser()->getId(),$this->artwork_or_user_id,$this->type);
      $username = sfGuardUserPeer::retrieveByPK($this->getRequestParameter('id'));
    } else
    {
      $this->isFavourite = false;
       $user = sfGuardUserPeer::retrieveByPK($this->artwork_or_user_id);
       $username = $user->getUserName();
    }
    $this->listOwner = $username;
    $this->header = $this->getRequestParameter("header", null);
    //$this->favouriteCount = $this->getRequestParameter("favouriteCount", 0);
    if (count($this->favourites) > 5)
    {
      array_pop($this->favourites);
      $this->hasMoreFavorites = true;
    }
    if ($this->type == 'artwork')
    {
        if (!$this->who)
        {
    	    $this->artwork = new genericArtwork($this->artwork_or_user_id);
        } else
        {
            //$this->artwork = new genericArtwork($this->artwork_or_user_id);
        }
    	
    }
  }
}
?>
