<?php
/**
 * Helpful model functions for the subreaktor. 
 * 
 * PHP version 5
 *
 * @author    juneih <juneih@linpro.no>
 * @copyright 2008 Linpro
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 */

/**
 * Helpful model functions for the subreaktor.
 * 
 * PHP version 5
 *
 * @author    juneih <juneih@linpro.no>
 * @copyright 2008 Linpro
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 */ 
class Subreaktor extends BaseSubreaktor
{
	/**
	 * List of subreaktors
	 *
	 * @var array
	 */
	static protected $_subreaktors = null;
	
	/**
	 * List of categories
	 *
	 * @var array
	 */
	protected $_categories = null;
	
	/**
	 * List of residences for this lokalreaktor
	 *
	 * @var array
	 */
	protected $_residences = null;
	
	/**
	 * List of filetypes to autodetect
	 *
	 * @var array
	 */
	protected $_filetypes = null;
	
	static protected $_lokalreaktor = null;
	static protected $_subreaktor = null;
	
  public function hydrate(ResultSet $rs, $startcol = 1)
  {
    parent::hydrate($rs, $startcol);
    $this->setCulture(sfContext::getInstance()->getUser()->getCulture());
  }
	
  /**
   * To string returns the name of the subreaktor. 
   *
   * @return void
   */
  public function __toString()
  {
    return $this->getName();
  }
  
  static public function getAll()
  {
  	if (self::$_subreaktors === null)
  	{
  		self::_populateSubReaktors();
  	}
  	return self::$_subreaktors;
  }
  
  static public function getAllAsReferences()
  {
  	$retarr = array();
  	foreach (self::getAll() as $areaktor)
  	{
  		$retarr[] = $areaktor->getReference();
  	}
  	return $retarr;
  }
  
  static public function getAllAsIndexedArray()
  {
  	$subreaktors = self::getAll();
  	$arr = array();
  	foreach ($subreaktors as $subreaktor)
  	{
  		$arr[$subreaktor->getId()] = $subreaktor->getName();
  	}
  	return $arr;
  }
  
  static public function getByReference($reference)
  {
    if (self::$_subreaktors === null)
    {
      self::_populateSubReaktors();
    }
    if (isset(self::$_subreaktors[$reference]))
    {
      return self::$_subreaktors[$reference];
    }
    else
    {
      throw new Exception ("Trying to get a subreaktor that does not exist");
    }
  }

  /**
   * Returns a subreaktor by id
   *
   * @param integer $id
   * 
   * @return Subreaktor
   */
  static public function getById($id)
  {
    if (self::$_subreaktors === null)
    {
      self::_populateSubReaktors();
    }
    foreach (self::$_subreaktors as $aSubreaktor)
    {
    	if ($aSubreaktor->getId() == $id)
    	{
    	  return $aSubreaktor;
    	}
    }
  }
  
  static public function _populateSubReaktors()
  {
    self::$_subreaktors = array();
  	$c = new Criteria();
  	$c->addAscendingOrderByColumn(SubreaktorPeer::SUBREAKTOR_ORDER);
    $res = SubreaktorPeer::doSelectWithI18n($c);
    foreach ($res as $r)
    {
    	self::$_subreaktors[$r->getReference()] = $r;
    }
  }
  
  static public function isProvided()
  {
  	if (self::$_subreaktor !== null || self::$_lokalreaktor !== null)
  	{
  		return true;
  	}
  	else
  	{
	  	if (sfContext::getInstance()->getRequest()->getParameter('subreaktor') != '')
	  	{
	  		$providedreaktor = sfContext::getInstance()->getRequest()->getParameter('subreaktor');
	  		if (stristr($providedreaktor, '-') != '')
	  		{
	        $providedreaktors = split('-', sfContext::getInstance()->getRequest()->getParameter('subreaktor'));
	  			self::$_subreaktor = $providedreaktors[1];
	  		  self::$_lokalreaktor = $providedreaktors[0];
	  		}
	  		else
	  		{
	  			self::$_subreaktor = $providedreaktor;
	  		}
	  		return true;
	  	}
	  	else
	  	{
	  		return false;
	  	}
  	}
  }
  
	/**
	 * Adds the current subreaktor to route (if any). Does not return any value, just
	 * modifies the string directly.
	 *
	 * @param string $internal_uri
	 * 
	 * @return void
	 */
  static public function addSubreaktorToRoute($internal_uri)
	{
	  if (self::isValid())
	  {
	    $internal_uri = substr($internal_uri, 1);
	    $internal_uri = '@subreaktor'.$internal_uri;
	    if (!stristr($internal_uri, '&subreaktor='))
	    {
		    if (stristr($internal_uri, '#'))
		    {
	        $mark = substr($internal_uri, stripos($internal_uri, '#'));
	        $internal_uri = substr($internal_uri, 0, stripos($internal_uri, '#'));
		    	$internal_uri .= (stristr($internal_uri, '?')) ? '&' : '?';
	        $internal_uri .= 'subreaktor='.self::getProvided();
	        $internal_uri .= $mark;
		    }
		    else
		    {
			    $internal_uri .= (stristr($internal_uri, '?')) ? '&' : '?';
			    $internal_uri .= 'subreaktor='.self::getProvided();
		    }
	    }
	  }
	  return $internal_uri;
	}
  
  static public function isValid()
  {
  	$retval = false;
  	if (self::isProvided())
  	{
	    if (self::$_subreaktors === null)
	    {
	      self::_populateSubReaktors();
	    }
      if (self::$_lokalreaktor !== null && isset(self::$_subreaktors[self::$_lokalreaktor]))
      {
      	if (!self::$_subreaktors[self::$_lokalreaktor]->getLokalReaktor())
        {
        	self::$_lokalreaktor = null;
        }
        $retval = true;
      }
	    if (isset(self::$_subreaktors[self::$_subreaktor]))
	    {
	    	if (self::$_subreaktors[self::$_subreaktor]->getLokalReaktor())
	    	{
	    		self::$_lokalreaktor = self::$_subreaktor;
	    	}
	    	$retval = true;
	    }
  	}
    return $retval;
  }
  
  static public function getProvidedIfValid()
  {
  	if (self::isValid())
  	{
  		return self::getProvided();
  	}
  }
  
  static public function addProvidedLinkIfValid($url)
  {
    if (self::isValid())
    {
      $url .= (stristr($url, '?')) ? '&' : '?';
      $url .= 'subreaktor='.self::getProvided();
    }
    return $url;
  }
  
  static function hasProvidedValidLokal()
  {
  	if (self::isValid())
  	{
  		if (self::$_lokalreaktor !== null)
  		{
  			return true;
  		}
  	}
  	return false;
  }
  
  static function getProvidedLokalReference()
  {
  	if (self::isValid() && self::$_lokalreaktor !== null)
  	{
  		return self::$_lokalreaktor;
  	}
  }
  
  public function isLokalReaktor()
  {
    return $this->getLokalreaktor();
  }
  /**
   * Returns the provided lokalreaktor if it is valid
   *
   * @return Subreaktor
   */
  static function getProvidedLokalreaktor()
  {
    if (self::isValid() && self::$_lokalreaktor !== null)
    {
      if (isset(self::$_subreaktors[self::$_lokalreaktor])) {
        return self::$_subreaktors[self::$_lokalreaktor];
      }
    }
    return null;
  }
  
  function getResidences()
  {
    if (self::isValid() && self::$_lokalreaktor !== null)
    {
      //return self::$_subreaktors[self::$_lokalreaktor];
      if ($this->_residences === null)
      {
      	$this->_residences = array();
      	foreach (self::$_subreaktors[self::$_lokalreaktor]->getLokalreaktorResidences() as $aResidence)
      	{
      		$this->_residences[] = $aResidence->getResidenceId();
      	}
      }
      return $this->_residences;
    }
  }

  static function getProvidedSubreaktorReference()
  {
    if (self::isValid() && self::$_subreaktor !== null && self::$_subreaktor != self::$_lokalreaktor)
    {
      return self::$_subreaktor;
    }
  }

  /**
   * Returns the provided subreaktor if it is valid
   *
   * @return Subreaktor
   */
  static function getProvidedSubreaktor()
  {
    if (self::isValid() && self::$_subreaktor !== null)
    {
    	if (self::$_subreaktor != self::$_lokalreaktor)
    	{
    	  return self::$_subreaktors[self::$_subreaktor];
    	}
    }
    return null;
  }
  
  static public function getProvided()
  {
  	if (self::isProvided())
  	{
  		return sfContext::getInstance()->getRequest()->getParameter('subreaktor');
  	}
  	else
  	{
  		return '';
  	}
  }
  
  /**
   * Get categories
   * 
   * @return array The categories
   */
  public function getCategories()
  {
  	if ($this->_categories === null)
  	{
  	  $this->_populateCategories();
  	}
  	return $this->_categories;
  }
  
  public static function clear()
  {
    self::$_lokalreaktor = null;
    self::$_subreaktor   = null;
    self::$_subreaktors  = null;
  }
  
  protected function _populateLokalReaktorCategories()
  {
  	$c = new Criteria();
  	
  }
  
  protected function _populateCategories()
  {
  	if ($this->_categories === null)
  	{
  	  $this->_categories = array();
  	}
  	
  	$this->_categories = CategorySubreaktorPeer::getCategoriesUsedBySubreaktor($this);
  }
  
  public function getFiletypes()
  {
  	if ($this->_filetypes === null)
  	{
  	  $this->_populateFiletypes();	
  	}
  	return $this->_filetypes;
  }
  
  protected function _populateFiletypes()
  {
    $this->_filetypes = array();
    $c = new Criteria();
    $c->add(SubreaktorIdentifierPeer::SUBREAKTOR_ID, $this->getId());
    $res = SubreaktorIdentifierPeer::doSelect($c);
    foreach ($res as $r)
    {
      $this->_filetypes[$r->getIdentifier()] = $r->getIdentifier();
    }
  }
  
  static protected function _preCreateCheck()
  {
  	$template_path = SF_ROOT_DIR . DIRECTORY_SEPARATOR . 'apps/reaktor/modules/subreaktors/templates/';
  	$logo_path = sfConfig::get('sf_web_dir').'/images/';
  	if (!file_exists($template_path.'subreaktorTemplate.php'))
  	{
  		throw new exception('Cannot find the template file for new subreaktors.');
  	}
    if (!file_exists($logo_path.'logoForside.gif'))
    {
      throw new exception('Cannot find the frontpage header.');
    }
    return true;
  }

  static protected function _createFiles($name, $reference)
  {
    $template_path = SF_ROOT_DIR . DIRECTORY_SEPARATOR . 'apps/reaktor/modules/subreaktors/templates/';
    $logo_path = sfConfig::get('sf_web_dir').'/images/';
    if (!@copy($template_path.'subreaktorTemplate.php', $template_path.$reference.'ReaktorSuccess.php'))
    {
      throw new Exception("No write access to template folder");
    }
    if (!@copy($logo_path.'logoForside.gif', $logo_path.'logo'.ucfirst($reference).'.gif'))
    {
      throw new Exception("No write access to logo folder");
    }
    return true;
  }

  static protected function _renameFiles($from, $to)
  {
    $template_path = SF_ROOT_DIR . DIRECTORY_SEPARATOR . 'apps/reaktor/modules/subreaktors/templates/';
    $logo_path = sfConfig::get('sf_web_dir').'/images/';

    $sprintf_file_path = $template_path.'%sReaktorSuccess.php';
    if (!@rename(sprintf($sprintf_file_path, $from), sprintf($sprintf_file_path, $to)))
    {
      throw new Exception("Can't rename in template folder");
    }
    $sprintf_logo_path = $logo_path.'logo%s.gif';
    if (!@rename(sprintf($sprintf_logo_path, ucfirst($from)), sprintf($sprintf_logo_path, ucfirst($to))))
    {
      throw new Exception("Can't rename in logo folder");
    }
    return true;
  }

  static protected function _postCreateCheck($name, $reference)
  {
    $template_path = SF_ROOT_DIR . DIRECTORY_SEPARATOR . 'apps/reaktor/modules/subreaktors/templates/';
    $logo_path = sfConfig::get('sf_web_dir').'/images/';
    if (!file_exists($template_path.$reference.'ReaktorSuccess.php'))
    {
      throw new exception('Cannot find the new template file for the subreaktor.');
    }
    if (!file_exists($logo_path.'logo'.ucfirst($reference).'.gif'))
    {
      throw new exception('Cannot find the subreaktor header.');
    }
    return true;
  }
  
  public static function createNew($name, $reference)
  {
    try
    { 
      self::_preCreateCheck();
      self::_createFiles($name, $reference);
      self::_postCreateCheck($name, $reference);
    }
    catch (Exception $e)
    {
    	throw $e;
    }
  	$subreaktor = new Subreaktor();
    $subreaktor->setReference($reference);
    $subreaktor->save();
    foreach (CataloguePeer::getCatalogues() as $aCatalogue)
    {
    	$subreaktorname = new SubreaktorI18n();
    	$subreaktorname->setName($name);
    	$subreaktorname->setSubreaktor($subreaktor);
    	$subreaktorname->setCulture($aCatalogue->getTargetLang());
    	$subreaktorname->save();
    }
  	return $subreaktor;
  }

  public function editReference($newreference)
  {
    try
    { 
      self::_preCreateCheck();
      self::_renameFiles($this->getReference(), $newreference);
      self::_postCreateCheck(null, $newreference);
      $this->setReference($newreference);
    }
    catch (Exception $e)
    {
    	throw $e;
    }
    return $this;
  }

  /**
   * List all subcategories per reaktor with number of artworks belonging
   * to each subcategory.  
   * 
   * @param Subreaktor $subreaktor Subreaktor object
   * @param int $count List count
   * 
   * @return array $categories List of Categories and artwork count 
   */
  public static function listSubcategories($subreaktor, $count = null, &$categories = null, $lokalreaktor = null)  
  {
    $c = new Criteria();
    $c->clearSelectColumns();
    $c->addSelectColumn(CategoryI18nPeer::NAME);
    $c->addSelectColumn('count(distinct '.CategoryArtworkPeer::ARTWORK_ID.') as artworkcount');
    $c->add(CategoryI18nPeer::CULTURE, sfContext::getInstance()->getUser()->getCulture());
    
    $c->addJoin(CategoryArtworkPeer::CATEGORY_ID, CategoryI18nPeer::ID);
    $c->addJoin(ReaktorArtworkPeer::ID, CategoryArtworkPeer::ARTWORK_ID);
    $c->addjoin(CategorySubreaktorPeer::CATEGORY_ID, CategoryI18nPeer::ID);
    $c->add(ReaktorArtworkPeer::STATUS, 3);
    
    if (!$subreaktor instanceof Subreaktor)
    {
    	throw new Exception('Needs subreaktor object. If this is a lokalreaktor, 
    	  change the reference in the template to reference the $lokalreaktor variable, instead of $subreaktor');
    }
    
    $c->add(CategorySubreaktorPeer::SUBREAKTOR_ID, $subreaktor->getId());
    $c->addJoin(CategoryArtworkPeer::ARTWORK_ID, ReaktorArtworkPeer::ID, Criteria::LEFT_JOIN);
      
    $c->addJoin(ReaktorArtworkPeer::ID, SubreaktorArtworkPeer::ARTWORK_ID, Criteria::LEFT_JOIN);
    $c->add(SubreaktorArtworkPeer::SUBREAKTOR_ID, $subreaktor->getId());
    
    if ($lokalreaktor !== null)
    {
    	$c->addJoin(ReaktorArtworkPeer::ID, LokalreaktorArtworkPeer::ARTWORK_ID, Criteria::LEFT_JOIN);
      $c->add(LokalreaktorArtworkPeer::SUBREAKTOR_ID, $lokalreaktor->getId());
    }
    
    if (Subreaktor::getProvidedLokalreaktor() instanceof Subreaktor || isset($options['lokalreaktor']))
    {
      //$c->addJoin(CategoryArtworkPeer::ARTWORK_ID, ReaktorArtworkPeer::ID, Criteria::LEFT_JOIN);
	    
      if (isset($options['lokalreaktor']))
	    {
	      $c->addJoin(ReaktorArtworkPeer::ID, LokalreaktorArtworkPeer::ARTWORK_ID, Criteria::LEFT_JOIN);
	      $c->addJoin(LokalreaktorArtworkPeer::SUBREAKTOR_ID, LokalreaktorResidencePeer::SUBREAKTOR_ID, Criteria::LEFT_JOIN);
	      $ctn = $c->getNewCriterion(LokalreaktorArtworkPeer::SUBREAKTOR_ID, $options['lokalreaktor']->getId());
	      $ctn2 = $c->getNewCriterion(sfGuardUserPeer::RESIDENCE_ID, $options['lokalreaktor']->getResidences(), Criteria::IN);
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
	    
    }
    
    if ($count && is_int($count))
    {
      $c->setLimit($count);
    }
    
    $c->addJoin(ReaktorArtworkPeer::USER_ID, sfGuardUserPeer::ID, Criteria::LEFT_JOIN);
    if (!sfContext::getInstance()->getUser()->hasCredential('viewallcontent'))
    {
      $c->add(sfGuardUserPeer::SHOW_CONTENT, true);
    }
    
    $c->addGroupByColumn(CategoryI18nPeer::ID);
    $c->addDescendingOrderByColumn('artworkcount');
    $c->setDistinct();
    
    $rs = CategoryArtworkPeer::doSelectRS($c);
    
    if ($categories === null)
    {
      $categories = array();
    }
    
    while($rs->next())
    {
      $categories[$rs->getString(1)] = $rs->getInt(2);
    }
    
    return $categories;
  }

  /**
   * List all subcategories per reaktor with number of artworks belonging
   * to each subcategory.  
   * 
   * @param string $subreaktor Subreaktor name
   * @param int $count List count
   * 
   * @return array $categories List of Categories and artwork count 
   */
  public static function listLokalReaktorSubcategories($lokalreaktor, $count = null)  
  {
    if (self::$_subreaktors === null)
    {
    	self::_populateSubReaktors();
    }
    //$lokalreaktor_id = self::getProvidedSubreaktorTagId($lokalreaktor);
    $categories = array();
        
    foreach (self::$_subreaktors as $aSubreaktor)
    {
	  	if (!$aSubreaktor->getLokalReaktor())
	  	{
	  		//$resultset = array();
	  		$c = new Criteria();
		    $c->clearSelectColumns();
		    //$c->addSelectColumn('count('.SubreaktorArtworkPeer::ID.') as count_artworks');
	  		$c->add(SubreaktorArtworkPeer::SUBREAKTOR_ID, $aSubreaktor->getId());
	  		$c->addJoin(SubreaktorArtworkPeer::ARTWORK_ID, LokalreaktorArtworkPeer::ARTWORK_ID, Criteria::LEFT_JOIN);
        $c->addJoin(SubreaktorArtworkPeer::ARTWORK_ID, ReaktorArtworkPeer::ID);
        $c->addJoin(ReaktorArtworkPeer::USER_ID, sfGuardUserPeer::ID, Criteria::LEFT_JOIN);
	  		$ctn = $c->getNewCriterion(LokalreaktorArtworkPeer::SUBREAKTOR_ID, $lokalreaktor->getId());
        $ctn2 = $c->getNewCriterion(sfGuardUserPeer::RESIDENCE_ID, $lokalreaktor->getResidences(), Criteria::IN);
        $ctn->addOr($ctn2);
        $c->add($ctn);
	  		//$c->add(LokalreaktorArtworkPeer::SUBREAKTOR_ID, $lokalreaktor->getId());
	  		$c->add(ReaktorArtworkPeer::STATUS, 3);
		    if (!sfContext::getInstance()->getUser()->hasCredential('viewallcontent'))
		    {
		      $c->add(sfGuardUserPeer::SHOW_CONTENT, true);
		    }
	  		
	  		//$c->addGroupByColumn('count_artworks');
	  		$c->setDistinct();
	  		$artworksinsubreaktorandlokalreaktor = SubreaktorArtworkPeer::doCount($c);
	  		//while ($resultset->next())
	  		//{
	  		if ($artworksinsubreaktorandlokalreaktor > 0)
	  		{
	  		  $categories[$aSubreaktor->getName()] = array('reference' => $aSubreaktor->getReference(), 'count' => $artworksinsubreaktorandlokalreaktor);
	  		}
	  	}
    }
    //self::listSubcategories($lokalreaktor, $count, $categories);
    return $categories;
  }

  /**
   * Delete a category
   *
   * @param integer $category The ID of the category
   */
  function deleteCategory($category)
  {
    //echo "<pre>";var_dump($this->getCategories());die(); 
    if (isset($this->_categories[$category]))
    {
      unset($this->_categories[$category]);
    }
    
    $c = new Criteria();
    $c->add(CategorySubreaktorPeer::CATEGORY_ID, $category);
    $c->add(CategorySubreaktorPeer::SUBREAKTOR_ID, self::getId());
    CategorySubreaktorPeer::doDelete($c);
  }
  
  /**
   * Add a category to this subreaktor
   *
   * @param category|integer $category The category to add
   */
  function addCategory($category = 0)
  {
    // Set up the category -> subreaktor relation
    $newcategorysubreaktorrelation = new CategorySubreaktor();
    if ($category instanceof Category )
    {
      $newcategorysubreaktorrelation->setCategory($category);
      $categoryId = $category->getId();  
    }
    elseif ($category > 0)
    {
      $newcategorysubreaktorrelation->setCategoryId($category);
      $categoryId = $category;
    }
    else
    {
      return false;    
    }
    
    // Check for existence of this category relationship already
    $c = new Criteria();
    $c->add(CategorySubreaktorPeer::CATEGORY_ID, $categoryId);
    $c->add(CategorySubreaktorPeer::SUBREAKTOR_ID, $this->getId());
    
    sfLogger::getInstance()->debug('About to check for existing link');
    $existing = CategorySubreaktorPeer::doSelectOne($c);
       
    if (!$existing)
    {
      sfLogger::getInstance()->debug('Adding new relationship');
      $newcategorysubreaktorrelation->setSubreaktor($this);
      $newcategorysubreaktorrelation->save();
    }
  }
  
  /**
   * Delete a file type from the subreaktor identifiers table
   *
   * @param string $identifier The identifier (image, pdf etc)
   */
  public function deleteFileType($identifier)
  {
    $c = new Criteria();
    $c->add(SubreaktorIdentifierPeer::IDENTIFIER, $identifier);
    $c->add(SubreaktorIdentifierPeer::SUBREAKTOR_ID, $this->getId());
    SubreaktorIdentifierPeer::doDelete($c);
  }
  
  /**
   * Add a file type/identifier relationship
   *
   * @param string $identifier The identifier to add (image, pdf etc)
   */
  public function addFileType($identifier)
  {
    $c = new Criteria();
    $c->add(SubreaktorIdentifierPeer::IDENTIFIER, $identifier);
    $c->add(SubreaktorIdentifierPeer::SUBREAKTOR_ID, $this->getId());
    $res = SubreaktorIdentifierPeer::doSelect($c);
    if (empty($res))
    {
      SubreaktorIdentifierPeer::doInsert($c);
    }
  }
}
