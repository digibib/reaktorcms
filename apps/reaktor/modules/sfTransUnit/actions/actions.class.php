<?php

/**
 * trans_unit actions.
 *
 * @package    symfony
 * @subpackage plugin
 * @author     Gareth James <symfony@bemused.org>
 * @version    SVN: $Id$
 */
require_once(dirname(__FILE__).'/../lib/BasesfTransUnitActions.class.php');

class sfTransUnitActions extends BasesfTransUnitActions 
{
  public function executeEdit()
  {
    $this->trans_unit = $this->getTransUnitOrCreate();
    
    if ($this->getRequest()->getMethod() == sfRequest::POST)
    {
      $catalogues = CataloguePeer::getCatalogues();
      foreach ($catalogues as $catalogue) {
        $trans_unit_string = 'trans_unit_' . $catalogue->getCatId();
        $c                 = new Criteria();
        if($this->trans_unit->getSource())
        {
// Ticket 23733 - in some cases LIKE operator matches to much 
//          $c->add(TransUnitPeer::SOURCE, $this->trans_unit->getSource(), ' LIKE BINARY ');
          $c->add(TransUnitPeer::SOURCE, $this->trans_unit->getSource(), ' = BINARY ');
        }
        else
        {
          $c->add(TransUnitPeer::SOURCE, $this->getRequestParameter("${trans_unit_string}[target]"),Criteria::EQUAL);
        }
        $c->add(TransUnitPeer::CAT_ID, $catalogue->getCatId());      
        $trans_unit_cat = TransUnitPeer::doSelectOne($c);
        
        if ($trans_unit_cat) {
          $this->$trans_unit_string = $this->getTransUnitByMsgIdOrCreate($trans_unit_cat->getMsgId());
        } else {
// If translation is missing create the object
          $this->$trans_unit_string = $this->getTransUnitByMsgIdOrCreate();
          $this->$trans_unit_string->setSource($this->trans_unit->getSource());     
          $this->$trans_unit_string->setFilename($this->trans_unit->getFilename());     
          $this->$trans_unit_string->setModule($this->trans_unit->getModule());     
          $this->$trans_unit_string->setId($this->trans_unit->getId());     
        }
      }


      foreach ($catalogues as $catalogue) {
        $this->updateTransUnitCatIdFromRequest($catalogue->getCatId());
        $trans_unit_string = 'trans_unit_' . $catalogue->getCatId();
        $this->$trans_unit_string->setCatId($catalogue->getCatId());
        $this->saveTransUnit($this->$trans_unit_string); 
      }

      $this->setFlash('notice', 'Your modifications have been saved');

      if ($this->getRequestParameter('save_and_add'))
      {
        return $this->redirect('sfTransUnit/create');
      }
      else if ($this->getRequestParameter('save_and_list'))
      {
        return $this->redirect('sfTransUnit/list');
      }
      else
      {
        if ($this->trans_unit->getMsgId())
        {
          return $this->redirect('sfTransUnit/edit?msg_id='.$this->trans_unit->getMsgId());
        } 
        else
        {
          return $this->redirect('sfTransUnit/list');
        }
      }
    }
    else
    {
      $this->labels = $this->getLabels();
    }
  }
  
  
  
  
  function hex2bin($h)
    {
    if (!is_string($h)) return null;
   $r='';
    for ($a=0; $a<strlen($h); $a+=2) { $r.=chr(hexdec($h{$a}.$h{($a+1)})); }
    return $r;
  }                                                                      
  
  public function executeSetCulture()
  {
    $redirect = $this->getRequestParameter('ref');
    $redirect = $this->hex2bin($redirect);
    $newCulture = $this->getRequestParameter("lang");
    $cult = strpos($redirect, "sf_culture=");
    if ($cult !== false) {
      // 10 = sf_culture, +1 = =, 2 == no/en/
      $redirect = substr_replace($redirect, $newCulture, $cult+10+1, 2);
    }
    else
    {
      if (strpos($redirect, "?") !== false) {
        $redirect .= "&";
      }
      else
      {
        $redirect .= "?";
      }

      $redirect .= "sf_culture=" . $newCulture;
    }

      if ($this->getUser()->isAuthenticated())
      {
        $this->getUser()->getGuardUser()->setCulture($newCulture);
        $this->getUser()->getGuardUser()->save();
      }
      else
      {
        sfContext::getInstance()->getResponse()->setCookie(sfConfig::get('app_sf_guard_plugin_lang_cookie_name', 'lang'), 
         $newCulture, time()+60*60*24*10);
      }
      
      $this->redirect($redirect);
  }
  
	public function executeNextString()
	{
		$msg_id = $this->getRequestParameter('msg_id') + 1;
		$this->redirect('@trans_edit?msg_id='.$msg_id);
	}
	
  public function executePreviousString()
  {
    $msg_id = $this->getRequestParameter('msg_id') - 1;
    if ($msg_id <= 0) $msg_id = 1;
    $this->redirect('@trans_edit?msg_id='.$msg_id);
  }
  
  /**
   * Process the new translation form - if we are here then the validation must have passed
   *
   * @return void - the user is redirected
   */
  public function executeNewTranslation()
  {
    $languages       = $this->languages = CataloguePeer::getCatalogues(true);
    $translateObject = $this->getrequestParameter("translateObject");
    $translateField  = $this->getrequestParameter("translateField");
    
    if (!class_exists($translateObject))
    {
      throw new exception ("Need a class to translate");
    }
    else
    {
      $trans = new $translateObject;
    }
    
    $trans->setBasename($this->getrequestParameter("basename"));
    $trans->save();
    
    foreach ($languages as $key => $language)
    {
      $trans->setCulture($key);
      $trans->{"set".$translateField}($this->getrequestParameter($key));
      $trans->save();
    }
    
    // Send the user back to the page they want to go to
    $this->redirect($this->getrequestParameter("redirect"));
  }
  
  /**
   * Validator for adding new translation
   * Here and not in the yaml file because number of fields can change
   * Basename is validated in yaml - the languages here
   *
   * @return void
   */
  public function validateNewTranslation()
  {
    
    $languages = $this->languages = CataloguePeer::getCatalogues(true);
    
    foreach ($languages as $key => $language)
    {
      if (!$this->getrequestParameter($key))
      {
        $this->getRequest()->setError($key, $this->getContext()->getI18n()->__("Required"));
      }
    }
    
    if ($this->getRequest()->hasErrors())
    {
      return false;
    }
    
    return true;
  }
  
  /**
   * Handle errors for new translations if there are any
   * 
   * @return void
   */
  public function handleErrorNewTranslation()
  {
    // Send the response back to the calling module, with errors intact
    $this->forward($this->getrequestParameter("referingModule"), $this->getrequestParameter("referingAction"));
  }
 
}
