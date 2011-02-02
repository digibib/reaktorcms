<?php

/**
 * subreaktors actions.
 *
 * @package    reaktor
 * @subpackage subreaktors
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 2692 2006-11-15 21:03:55Z fabien $
 */
class subreaktorsActions extends sfActions
{
  /**
   * Executes index action
   *
   */
  public function executeIndex()
  {
    if (Subreaktor::isValid())
    {
	  	$this->lokalreaktor = null;
	  	$this->subreaktor = null;
	  	
    	if (Subreaktor::hasProvidedValidLokal())
	  	{
	  		$this->lokalreaktor = Subreaktor::getProvidedLokalreaktor();
	  	}
	  	$this->subreaktor = Subreaktor::getProvidedSubreaktor();	  	
	  	
	  	if ($this->subreaktor)
	  	{
	  	  $this->forward404Unless($this->subreaktor->getLive() == 1 || $this->getUser()->hasCredential("subreaktoradministrator"));
	  	}
      if ($this->lokalreaktor)
      {
        $this->forward404Unless($this->lokalreaktor->getLive() == 1 || $this->getUser()->hasCredential("subreaktoradministrator"));
        $cache = reaktorCache::singleton("lokalreaktor_index_" . $this->lokalreaktor->getReference());
      }
      
      
      $bannerfarger = array('orange', 'turkis', 'graa');
      $this->bannerfarge = $bannerfarger[rand(0,count($bannerfarger)-1)];
      
	    if ($this->lokalreaktor)
	    {
	    	$last = $cache->get();
        if (!$last)
        {
          foreach (Subreaktor::getAll() as $aSubreaktor)
          {
            if (!$aSubreaktor->getLokalReaktor() && $aSubreaktor->getLive())
            {
              $last[] = array('subreaktor' => $aSubreaktor, 'last' => ReaktorArtworkPeer::getLatestSubmittedApproved(1, null, null, $aSubreaktor, $this->lokalreaktor));
            }
          }
          $cache->set(serialize($last));
        }
        else
        {
          $last = unserialize($last);
        }
        $this->last = $last;
	    }
	    if ($this->lokalreaktor == null && $this->subreaktor !== null || ($this->lokalreaktor !== null && $this->subreaktor !== null))
	    {
	      $this->setTemplate($this->subreaktor->getReference() . 'Reaktor');
	    }
	    else
	    {
	    	$this->setTemplate($this->lokalreaktor->getReference() . 'Reaktor');
	    }
    }
    else
    {
      $this->forward404();
    }
	    
  }
  
  public function executeList()
  {
  	$this->activeSubreaktors = SubreaktorPeer::getLiveReaktors();
  	$this->inactiveSubreaktors = SubreaktorPeer::getNotLiveReaktors();
  	
  }
  
  public function executeEdit()
  {
  	$this->subreaktor = SubreaktorPeer::retrieveByPK($this->getRequestParameter('id'));
    if (!$this->subreaktor)
    {
      $this->forward404();
    }

    $lokalresidences = array();
    if ($this->subreaktor->getLokalReaktor()) {
      $residences = LokalreaktorResidencePeer::getResidenceBySubreaktor($this->subreaktor);
      foreach($residences as $obj) {
        $lokalresidences[$obj->getResidenceId()] = $obj->getResidence()->getName();
      }
    }
    $this->lokalresidences = $lokalresidences;

  	$this->redirectUnless($this->subreaktor, '@listsubreaktors');
  	
  	$this->logo_filename = 'logo' . ucfirst($this->subreaktor->getReference()) . '.gif';
    $this->logo_path = sfConfig::get('sf_web_dir').'/images/';
    $this->template_filename = $this->subreaktor->getReference() . 'ReaktorSuccess.php';
    $this->template_path = SF_ROOT_DIR . DIRECTORY_SEPARATOR . 'apps/reaktor/modules/subreaktors/templates/';
  }

  public function handleErrorUpdate()
  {
  	$this->forward('subreaktors', 'edit');
  }
  
  public function executeUpdate()
  {
    $this->subreaktor = SubreaktorPeer::retrieveByPK($this->getRequestParameter('id'));
    $this->redirectUnless($this->subreaktor, '@listsubreaktors');
    
    //$this->subreaktor->setName($this->getRequestParameter('name'));
    if (!$this->subreaktor->getLive() && $this->getRequestParameter('subreaktor_reference'))
    {
      $newref = $this->getRequestParameter('subreaktor_reference');
      if ($newref != $this->subreaktor->getReference())
      {
        $this->subreaktor->editReference($newref);
        reaktorCache::deleteSimilar("lokalreaktor_index_");
      }
    }
    if ($this->getRequestParameter('subreaktor_live') != $this->subreaktor->getLive())
    {
      $this->subreaktor->setLive($this->getRequestParameter('subreaktor_live'));
      reaktorCache::deleteSimilar("lokalreaktor_index_");
    }
    $this->subreaktor->setLokalReaktor($this->getRequestParameter('subreaktor_lokalreaktor'));

    if ($this->getRequestParameter('subreaktor_lokalreaktor'))
    {
      $c = new Criteria();
      $c->add(LokalreaktorResidencePeer::SUBREAKTOR_ID, $this->subreaktor->getPrimaryKey());
      LokalreaktorResidencePeer::doDelete($c);


      $ids = $this->getrequestparameter('associated_lokalreaktor_residence');
      if (is_array($ids))
      {
        foreach ($ids as $id)
        {
          $lokalreaktorresidence = new LokalreaktorResidence();
          $lokalreaktorresidence->setsubreaktorid($this->subreaktor->getprimarykey());
          $lokalreaktorresidence->setresidenceid($id);
          $lokalreaktorresidence->save();
        }
      }
    }

    $this->subreaktor->save();
    reaktorCache::deleteSimilar('artwork_link_');
    $this->redirect('@editsubreaktor?id=' . $this->getRequestParameter('id'));
  }
  
  public function handleErrorAdd()
  {
  	$this->forward('subreaktors', 'list');
  }
  
  public function executeAdd()
  {
  	try
  	{
      $this->subreaktor = Subreaktor::createNew($this->getRequestParameter('name'), $this->getRequestParameter('reference'));
  	}
  	catch (Exception $e)
  	{
  	  $this->getRequest()->setError("global", $e->getMessage());
  	  $this->forward("subreaktors", "list");
  	}
    $this->redirect('@editsubreaktor?id=' . $this->subreaktor->getId());
  }
  
  public function handleErrorCategoryAction()
  {
    $this->subreaktor = SubreaktorPeer::retrieveByPK($this->getRequestParameter('subreaktor'));
  	sfLoader::loadHelpers(array('Partial', 'Javascript'));
    return $this->renderText(get_component('subreaktors', 'categoriesList', array('subreaktor' => $this->subreaktor)));
  }
  
  public function executeCategoryAction()
  {
    $this->subreaktor = SubreaktorPeer::retrieveByPK($this->getRequestParameter('subreaktor'));
   
    if (!$this->subreaktor || !$this->getRequest()->isXmlHttpRequest())
    {
    	die();
    }
    
    switch ($this->getRequestParameter('mode'))
    {
    	case 'delete':
    		$this->subreaktor->deleteCategory($this->getRequestParameter("category"));
    		break;
    	case 'add':
    		if ($this->getRequestParameter('category') > 0)
    		{
    		  $this->subreaktor->addCategory($this->getRequestParameter("category"));
    		}
    		else
    		{
    		  $this->subreaktor->addCategory(); // Adds a "blank" category
    		}
    		break;
    }
    sfLoader::loadHelpers(array('Partial', 'Javascript'));
  	return $this->renderText(get_component('subreaktors', 'categoriesList', array('subreaktor' => $this->subreaktor)));
  }
  
  public function executeFiletypeAction()
  {
    $this->subreaktor = SubreaktorPeer::retrieveByPK($this->getRequestParameter('subreaktor'));
    if (!$this->subreaktor || !$this->getRequest()->isXmlHttpRequest() || !$this->getRequestParameter('filetype'))
    {
      die();
    }
    switch ($this->getRequestParameter('mode'))
    {
      case 'delete':
        $this->subreaktor->deleteFileType($this->getRequestParameter("filetype"));
        break;
      case 'add':
      	$this->subreaktor->addFileType($this->getRequestParameter("filetype"));
        break;
    }
    sfLoader::loadHelpers(array('Partial', 'Javascript'));
    return $this->renderText(get_component('subreaktors', 'filetypesList', array('subreaktor' => $this->subreaktor)));
  }
  
  /**
   * Update Subreaktor order when draggin' and droppin'
   * 
   * @return void
   */
  public function executeUpdateOrder()
  {
    $this->forward404Unless($this->getRequest()->isXmlHttpRequest());
    try
    {
      $theorder = 1;
      
      foreach ($this->getRequestParameter('subreaktor_list') as $asubreaktor)
      {
      	sfContext::getInstance()->getLogger()->info("Now setting artwork " . $asubreaktor);
      	$subreaktor = SubreaktorPeer::retrieveByPK($asubreaktor);
        $subreaktor->setSubreaktorOrder($theorder);
        $subreaktor->save();
        $theorder++;
      }
      sfContext::getInstance()->getLogger()->info("Done");
      return $this->renderText($this->getContext()->getI18N()->__("Changes were saved"));
    } 
    catch (Exception $e)
    {
      return $this->renderText($this->getContext()->getI18N()->__("An error occured, your list was not updated"));
    }
    
  }
  
}
