<?php

/*
 * This file is part of the symfony package.
 * (c) 2004-2007 Fabien Potencier <fabien.potencier@symfony-project.com>
 * (c) 2008 Gareth James <symfony@bemused.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 *
 * @package    symfony
 * @subpackage plugin
 * @author     Gareth James <symfony@bemused.org>              
 * @version    SVN: $Id$
 */

class BasesfTransUnitActions extends autoSfTransUnitActions
{
  public function executeEdit()
  {
    $this->trans_unit = $this->getTransUnitOrCreate();
    
    $catalogues = CataloguePeer::getCatalogues();
    foreach ($catalogues as $catalogue) {
      $c = new Criteria();
      $c->add(TransUnitPeer::SOURCE, $this->trans_unit->getSource());
      $c->add(TransUnitPeer::CAT_ID, $catalogue->getCatId());      
      $trans_unit_cat = TransUnitPeer::doSelectOne($c);
      $trans_unit_string = 'trans_unit_' . $catalogue->getCatId();
      if ($trans_unit_cat) {
        $this->$trans_unit_string = $this->getTransUnitByMsgIdOrCreate($trans_unit_cat->getMsgId());
      } else {
        $this->$trans_unit_string = $this->getTransUnitOrCreate();		
      }
    }

    if ($this->getRequest()->getMethod() == sfRequest::POST)
    {
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

  protected function updateTransUnitCatIdFromRequest($cat_id)
  {
    $trans_unit_string = 'trans_unit_' . $cat_id;
    ${$trans_unit_string} = $this->getRequestParameter("trans_unit_$cat_id");
	$trans_source = $this->getRequestParameter('trans_unit');
    if (isset($trans_source['source']))
    {
      $this->$trans_unit_string->setSource($trans_source['source']);
    }
    if (isset(${$trans_unit_string}['target']) && isset(${$trans_unit_string}['translated'])) {
      $this->$trans_unit_string->setTranslated(1);
    } else if (! isset(${$trans_unit_string}['translated']))
    {
      $this->$trans_unit_string->setTranslated(0);
    }
    if (isset(${$trans_unit_string}['default']) ) {
      $this->$trans_unit_string->setTarget($this->$trans_unit_string->getSource());
    } else if (isset(${$trans_unit_string}['target']))
    {
      $this->$trans_unit_string->setTarget(${$trans_unit_string}['target']);
    }
    if (isset(${$trans_unit_string}['comments']))
    {
      $this->$trans_unit_string->setComments(${$trans_unit_string}['comments']);
    }
	
  
  }
  /*protected function updateTransUnitCatIdFromRequest($cat_id)
  {
    $trans_unit_string = 'trans_unit_' . $cat_id;
    ${$trans_unit_string} = $this->getRequestParameter("trans_unit_$cat_id");

    if (isset(${$trans_unit_string}['source']))
    {
      $this->$trans_unit_string->setSource(${$trans_unit_string}['source']);
    }
    if (isset(${$trans_unit_string}['target']) && (${$trans_unit_string}['target'] != $this->$trans_unit_string->getTarget())) {
      $this->$trans_unit_string->setTranslated(1);
    } else if (! isset(${$trans_unit_string}['translated']))
    {
      $this->$trans_unit_string->setTranslated(0);
    }
    if (isset(${$trans_unit_string}['default']) ) {
      $this->$trans_unit_string->setTarget($this->$trans_unit_string->getSource());
    } else if (isset(${$trans_unit_string}['target']))
    {
      $this->$trans_unit_string->setTarget(${$trans_unit_string}['target']);
    }
    if (isset(${$trans_unit_string}['comments']))
    {
      $this->$trans_unit_string->setComments(${$trans_unit_string}['comments']);
    }
  }*/

  protected function addFiltersCriteria($c)
  {
    if (isset($this->filters['source_is_empty']))
    {
      $criterion = $c->getNewCriterion(TransUnitPeer::SOURCE, '');
      $criterion->addOr($c->getNewCriterion(TransUnitPeer::SOURCE, null, Criteria::ISNULL));
      $c->add($criterion);
    }
    else if (isset($this->filters['source']) && $this->filters['source'] !== '')
    {
      $c->add(TransUnitPeer::SOURCE, '%' . $this->filters['source']. '%', Criteria::LIKE);
    }
    if (isset($this->filters['module_is_empty']))
    {
      $criterion = $c->getNewCriterion(TransUnitPeer::MODULE, '');
      $criterion->addOr($c->getNewCriterion(TransUnitPeer::MODULE, null, Criteria::ISNULL));
      $c->add($criterion);
    }
    else if (isset($this->filters['module']) && $this->filters['module'] !== '')
    {
      $c->add(TransUnitPeer::MODULE, '%' . $this->filters['module']. '%', Criteria::LIKE);
    }
    if (isset($this->filters['filename_is_empty']))
    {
      $criterion = $c->getNewCriterion(TransUnitPeer::FILENAME, '');
      $criterion->addOr($c->getNewCriterion(TransUnitPeer::FILENAME, null, Criteria::ISNULL));
      $c->add($criterion);
    }
    else if (isset($this->filters['filename']) && $this->filters['filename'] !== '')
    {
      $c->add(TransUnitPeer::FILENAME, '%' . $this->filters['filename']. '%', Criteria::LIKE);
    }
    if (isset($this->filters['translated_is_empty']))
    {
      $criterion = $c->getNewCriterion(TransUnitPeer::TRANSLATED, '');
      $criterion->addOr($c->getNewCriterion(TransUnitPeer::TRANSLATED, null, Criteria::ISNULL));
      $c->add($criterion);
    }
    else if (isset($this->filters['translated']) && $this->filters['translated'] !== '')
    {
      $c->add(TransUnitPeer::TRANSLATED, $this->filters['translated']);
    }
    if (isset($this->filters['cat_is_empty']))
    {
      $criterion = $c->getNewCriterion(TransUnitPeer::CAT_ID, '');
      $criterion->addOr($c->getNewCriterion(TransUnitPeer::CAT_ID, null, Criteria::ISNULL));
      $c->add($criterion);
    }
    else if (isset($this->filters['cat_id']) && $this->filters['cat_id'] !== '')
    {
      $c->add(TransUnitPeer::CAT_ID, $this->filters['cat_id']);
    }
    if (isset($this->filters['comments_is_empty']))
    {
      $criterion = $c->getNewCriterion(TransUnitPeer::COMMENTS, '');
      $criterion->addOr($c->getNewCriterion(TransUnitPeer::COMMENTS, null, Criteria::ISNULL));
      $c->add($criterion);
    }
    else if (isset($this->filters['comments']) && $this->filters['comments'] !== '')
    {
      $c->add(TransUnitPeer::COMMENTS, '%' . $this->filters['comments']. '%', Criteria::LIKE);
    }
    if (isset($this->filters['target_is_empty']))
    {
      $criterion = $c->getNewCriterion(TransUnitPeer::TARGET, '');
      $criterion->addOr($c->getNewCriterion(TransUnitPeer::TARGET, null, Criteria::ISNULL));
      $c->add($criterion);
    }
    else if (isset($this->filters['target']) && $this->filters['target'] !== '')
    {
      $c->add(TransUnitPeer::TARGET, '%' . $this->filters['target']. '%', Criteria::LIKE);
    }
    
  }

  protected function getTransUnitByMsgIdOrCreate($msg_id = NULL)
  {
    if (is_null($msg_id))
    {
      $trans_unit = new TransUnit();
    }
    else
    {
      $trans_unit = TransUnitPeer::retrieveByPk($msg_id);

      $this->forward404Unless($trans_unit);
    }
    return $trans_unit;
  }

  protected function getLabels()
  {
    return array(
      'trans_unit{source}' => sfContext::getInstance()->getI18N()->__('Key text').':',
      'trans_unit{target}' => sfContext::getInstance()->getI18N()->__('Translations').':',
    );
  }
}