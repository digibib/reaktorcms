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

class favouriteComponents extends sfComponents
{
  /**
   * Function for listing favourites, independent of types
   * 
   * @return void
   */
  function executeListFavourites()
  {
    $MAX = 5; // Max favorites we should fetch
    $this->hasMoreFavorites = isset($this->hasMoreFavorites)?$this->hasMoreFavorites:false; // Used in the template to print "show all"
    $hadNoFav = !isset($this->favourites);

    switch($this->type)
    {
      case 'artwork':
        $fav_type = 'artwork';
        $artwork = ReaktorArtworkPeer::getArtworkById($this->artwork_or_user_id);
        $artwork = array_shift($artwork);
        if(count($artwork) > 0)
        {
          $user = sfGuardUserPeer::retrieveByPk($artwork->getUserId());       
          $username = $user->getUsername();
        $this->listOwner = $username;
        }
        break;
      case 'user':
      case 'article':
        $fav_type = $this->type;
        
        if($this->getUser()->isAuthenticated())
        {
          //User is logged in, get owner from requestparameter
          $username = !isset($this->listOwner)?$this->getRequestParameter('user'):$this->listOwner;
        }
        else
        {
           //User is not logged in, we get id from artwork_or_user_id, which will always be the user we're watching, except
           //when deleting, but user is not logged in, and thus should never be able to delete
           $user = sfGuardUserPeer::retrieveByPK($this->artwork_or_user_id);
           $username = $user->getUserName();
        }
        $this->listOwner = $username;
       
        break;
      default:
        if (!isset($this->listOwner))
        {
          $this->listOwner = "";
        }
        break;    
    }

    if (!isset($fav_type))
    {
      throw new Exception ('Unknown favourite type');
    } 
    
    $fav_obj = new Favourite();
    
    
    if (isset($this->who) && $this->who == 'Me')
    {
      if (!(isset($this->favourites) && $this->favourites))
        $this->favourites = $fav_obj->getMyLastFavs($fav_type,$this->artwork_or_user_id, $MAX+1);
         
    }
    else 
    {
      if (!(isset($this->favourites) && $this->favourites))
      {
        $this->favourites = $fav_obj->getLastFavs($fav_type,$this->artwork_or_user_id, $MAX+1);
      }
        
    }
   
    $this->isMyPage = false;
    if ($this->getUser()->isAuthenticated())
    {
      if ( isset($username) && $this->getUser()->getUsername() == $username)
      {        
        $this->isMyPage = true;
      }
      $this->isFavourite = $fav_obj->getIsFavourite($this->getUser()->getGuardUser()->getId(),$this->artwork_or_user_id,$fav_type);      
    } 
    else
    {
      $this->isFavourite = false;
    }
    if ($hadNoFav && count($this->favourites) > $MAX)
    {
      array_pop($this->favourites);
      $this->hasMoreFavorites = true;
    }
  }

  function executeFavouriteActions()
  {
    switch($this->type)
    {
      case 'artwork':
        $fav_type = 'artwork';
        $artwork = ReaktorArtworkPeer::getArtworkById($this->artwork_or_user_id);
        $artwork = array_shift($artwork);
        $user = sfGuardUserPeer::retrieveByPk($artwork->getUserId());
        $username = $user->getUsername();
        
        //$username = $artwork->getUser()->getUsername();
        break;
      case 'user':
        $fav_type = 'user';
            
        if($this->getUser()->isAuthenticated())
        {
          //User is logged in, get owner from requestparameter
          $username = $this->getRequestParameter('user');
        }
        else
        {
           //User is not logged in, we get id from artwork_or_user_id, which will always be the user we're watching, except
           //when deleting, but user is not logged in, and thus should never be able to delete
           $user = sfGuardUserPeer::retrieveByPK($this->artwork_or_user_id);
           $username = $user->getUserName();
        }
        $this->listOwner = $username;
       
        break;
      default:
        break;    
    }

    if (!isset($fav_type))
    {
      throw new Exception ('Unknown favourite type');
    } 
    
    $fav_obj = new Favourite();
    
    
    if (isset($this->who) && $this->who == 'Me')
    {
      if (!(isset($this->favourites) && $this->favourites))
        $this->favourites = $fav_obj->getMyLastFavs($fav_type,$this->artwork_or_user_id,5);
         
    } else 
    {
      if (!(isset($this->favourites) && $this->favourites))
        $this->favourites = $fav_obj->getLastFavs($fav_type,$this->artwork_or_user_id,5);
        
    }
   
    
    $this->isMyPage = false;
    if ($this->getUser()->isAuthenticated())
    {
      if ( $this->getUser()->getUsername() == $username)
      {
        
      $this->isMyPage = true;
      }
       $this->isFavourite = $fav_obj->getIsFavourite($this->getUser()->getGuardUser()->getId(),$this->artwork_or_user_id,$fav_type);
      
    } else
    {
      $this->isFavourite = false;
    }
  }

  /**
   * List users who have the artwork as a favourite, and users who have the 
   * owner of the artwork as a favourite
   *
   * @return void
   */
  function executeArtworkListFavourites()
  {
    $this->hasMoreFavourites = false;
  	$orglist = isset($this->list) ? $this->list : null;
    if (!isset($this->user_id))
    {
      $this->user_id = 0;
    }
    if (!isset($this->artwork_id))
    {
      $this->artwork_id = 0;
    }
    if (!isset($this->article_id))
    {
      $this->article_id = 0;
    }

    if (
        $this->getRequestParameter("module") == "profile"
        && $this->getRequestParameter("action") == "portfolio"
    )
    {
      $this->list = 'user';
      $this->types       = array('user');
      $this->showUsers   = false;
      $this->artwork_id = 0;
    }
    else
    {
      $this->types       = array('user', 'artwork', );
      $this->showUsers   = true;
    }

    if ($orglist != 'article')
    {
      $fav_obj           = array('user' => null, 'artwork' => null, 'article' => null);
      $user              = array('user' => null, 'artwork' => null, 'article' => null);
      $username          = array('user' => null, 'artwork' => null, 'article' => null);
      $this->favourites  = array('user' => null, 'artwork' => null, 'article' => null);
      $this->isFavourite = array('user' => null, 'artwork' => null, 'article' => null);
    }
    else
    {
      $this->types = array('article');
      $fav_obj = $user = $username = $this->favourites = $this->isFavourite = array('article' => null);
    }
    
  	foreach ($this->types as $type)
  	{
	    
  		switch($type)
	    {
	      case 'artwork':
	        $artwork = ReaktorArtworkPeer::getArtworkById($this->artwork_id);
	        $artwork = array_shift($artwork);
          if (!$artwork) {
            $this->list = 'user';
            continue;
          }
	        $user[$type] = sfGuardUserPeer::retrieveByPk($artwork->getUserId());
	        $username[$type] = $user[$type]->getUsername();	        
	        break;
	      case 'user':
	        
	        if($this->getUser()->isAuthenticated())
	        {
	          //User is logged in, get owner from requestparameter
	          $username[$type] = $this->getRequestParameter('user');
	          
	        }
	        else
	        {
	           //User is not logged in, we get id from artwork_or_user_id, which will always be the user we're watching, except
	           //when deleting, but user is not logged in, and thus should never be able to delete
	           $user[$type] = sfGuardUserPeer::retrieveByPK($this->user_id);
	           $username[$type] = $user[$type]->getUserName();
	        }
	       
	       
	        break;
        case 'article':
          break;
	      default:
	        break;    
	    }
	    $this->listOwner = $username[$type];
	    $fav_obj[$type] = new Favourite();
	    
	    
      if (!(isset($this->favourites[$type]) && $this->favourites[$type]))
      {
        if ($type == 'artwork')
        {
          if ($this->all)
          {
              $this->favourites[$type] = $fav_obj[$type]->getLastFavs($type,$this->artwork_id,6);
          } else
          {
      	    $this->favourites[$type] = $fav_obj[$type]->getLastFavs($type,$this->artwork_id,6);
            if (count($this->favourites[$type]) > 5)
            {
               
            	$this->hasMoreFavourites = true;
               array_pop($this->favourites[$type]);
            }
          }
        }
        elseif ($type == 'user')
        {
        	$this->favourites[$type] = $fav_obj[$type]->getLastFavs($type,$this->user_id,5);
        }
        elseif ($type == 'article')
        {
        	$this->favourites[$type] = $fav_obj[$type]->getLastFavs($type,$this->article_id, 5);
        }
      }
	    
	    if ($this->getUser()->isAuthenticated())
	    {
	      if ( $this->getUser()->getUsername() != $username[$type])
	      {
	        if ($type == 'artwork')
	        {
	      	  $this->isFavourite[$type] = $fav_obj[$type]->getIsFavourite($this->getUser()->getGuardUser()->getId(),$this->artwork_id,$type);
	        }
	        elseif ($type == 'user')
	        {
	        	$this->isFavourite[$type] = $fav_obj[$type]->getIsFavourite($this->getUser()->getGuardUser()->getId(),$this->user_id,$type);
	        }
          elseif ($type == 'article')
          {
	        	$this->isFavourite[$type] = $fav_obj[$type]->getIsFavourite($this->getUser()->getGuardUser()->getId(),$this->article_id,$type);
          }
	      }
	    } 
	    else
	    {
	      $this->isFavourite[$type] = false;
	    }
  	}
    if ($orglist != $this->list && $orglist == 'article')
    {
      $this->list = $orglist;
    }
  
  }
  
}

?>
