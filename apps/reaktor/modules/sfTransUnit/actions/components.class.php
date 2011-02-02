<?php
/**
 * Components for translation functionality
 *
 * PHP version 5
 * 
 * @author    Russ Flynn <russ@linpro.no>
 * @author    Ole Petter Wikene <olepw@linpro.no>
 * @copyright 2008 Linpro AS
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 */

/**
 * Components for translation functionality
 *
 * PHP version 5
 * 
 * @author    Russ Flynn <russ@linpro.no>
 * @author    Ole Petter Wikene <olepw@linpro.no>
 * @copyright 2008 Linpro AS
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 */
class sfTransUnitComponents extends sfComponents
{
  /**
   * List the language options, used in header template
   * 
   * @return void Exectutes the _langLinks component
   */
  public function executeLangLinks()
  {
    $cache = reaktorCache::singleton("langbarnssadfasdfasdf");
    if (!($languages = $cache->get()))
    {
      $tmp = CataloguePeer::doSelect(new Criteria());
      $languages = array();
      foreach($tmp as $lang)
      {
        $languages[] = array(
          "targetLang" => $lang->getTargetLang(),
          "description" => $lang->getDescription(),
        );
      }
      $cache->set($languages);
    }

    $links = array();
    $i     = 0;
    
    // Generate the correct URLs
    foreach($languages as $language)
    {
      $links[$i]['class'] = '';
      if ($language["targetLang"] == $this->getUser()->getCulture())
      {
      	$links[$i]['class'] = 'selected';
      }
      $links[$i]['lang']          = $language["targetLang"];
      $links[$i++]['description'] = $language["description"];
    }

    // Pass the required array to the template
    $this->links = $links;
    $referer = sfRouting::getInstance()->getCurrentInternalUri();
    $this->ref =bin2hex(($referer));
  }

  /**
   * Reuseable translation component for translating database content
   *
   * @return void
   */
  public function executeNewTranslationForm()
  {
    if (!class_exists($this->translateObject))
    {
      throw new Exception ("You must pass an object name to translate");
    }
    
    $this->languages = CataloguePeer::getCatalogues(true);
  }
}
