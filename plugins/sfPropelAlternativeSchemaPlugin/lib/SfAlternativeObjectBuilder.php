<?php

require_once sfConfig::get('sf_symfony_lib_dir').'/addon/propel/builder/SfObjectBuilder.php';

/*
 * This file is part of the symfony package.
 * (c) 2004-2006 Fabien Potencier <fabien.potencier@symfony-project.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * @package    symfony
 * @subpackage addon
 * @author     Fabien Potencier <fabien.potencier@symfony-project.com>
 * @version    SVN: $Id: SfObjectBuilder.php 3493 2007-02-18 09:23:10Z fabien $
 */
class SfAlternativeObjectBuilder extends SfObjectBuilder
{
  protected function addClassClose(&$script)
  {
    parent::addClassClose($script);

    $behavior_file_name = 'Base'.$this->getTable()->getPhpName().'Behaviors';
    $behavior_file_path = $this->getFilePath($this->getStubObjectBuilder()->getPackage().'.om.'.$behavior_file_name);
    
    $behaviors = $this->getTable()->getAttribute('behaviors');
    if($behaviors)
    {
      $script .= sprintf("\n\ninclude_once '%s';\n", $behavior_file_path);
    }
  }
}
