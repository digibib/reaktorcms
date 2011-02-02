<?php

/*
 * This file is part of the symfony package.
 * (c) Fabien Potencier <fabien.potencier@symfony-project.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * @package    symfony
 * @subpackage i18n
 * @author     Fabien Potencier <fabien.potencier@symfony-project.com>
 * @version    SVN: $Id: sfI18nModuleExtract.class.php 4362 2007-06-25 13:01:55Z fabien $
 */
class sfI18nModuleExtract extends sfI18nExtract
{
  protected $module = '';

  /**
   * Configures the current extract object.
   */
  public function configure()
  {
    if (!isset($this->parameters['module']))
    {
      throw new sfException('You must give a "module" parameter when extracting for a module.');
    }

    $this->module = $this->parameters['module'];

    $this->i18n->setMessageSourceDir(sfLoader::getI18NDir($this->module), $this->culture);
  }

  /**
   * Extracts i18n strings.
   *
   * This class must be implemented by subclasses.
   */
  public function extract()
  {
    // Extract from PHP files to find __() calls in actions/ lib/ and templates/ directories
    $moduleDir = sfConfig::get('sf_app_module_dir').'/'.$this->module;
    $this->extractFromPhpFiles(array(
      $moduleDir.'/'.sfConfig::get('sf_app_module_action_dir_name'),
      $moduleDir.'/'.sfConfig::get('sf_app_module_lib_dir_name'),
      $moduleDir.'/'.sfConfig::get('sf_app_module_template_dir_name'),
    ));

    // Extract from generator.yml files
    $generator = $moduleDir.'/'.sfConfig::get('sf_app_module_config_dir_name').'/generator.yml';
    if (file_exists($generator))
    {
      $yamlExtractor = new sfI18nYamlGeneratorExtractor();
      $message = $yamlExtractor->extract(file_get_contents($generator));
      foreach ($message as $amessage)
      {
        $_SESSION['messageLocations'][] = array('message' => $amessage, 'file' => $generator);
      }      
      $this->updateMessages($message);
    }

    // Extract from validate/*.yml files
    $validateFiles = glob($moduleDir.'/'.sfConfig::get('sf_app_module_validate_dir_name').'/*.yml');
    if (is_array($validateFiles))
    {
      foreach ($validateFiles as $validateFile)
      {
        $yamlExtractor = new sfI18nYamlValidateExtractor();
	      $message = $yamlExtractor->extract(file_get_contents($validateFile));
	      foreach ($message as $amessage)
	      {
	        $_SESSION['messageLocations'][] = array('message' => $amessage, 'file' => $validateFile);
	      }      
        $this->updateMessages($message);
      }
    }
  }
}
