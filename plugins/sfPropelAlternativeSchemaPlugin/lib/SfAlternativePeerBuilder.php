<?php

require_once sfConfig::get('sf_symfony_lib_dir').'/addon/propel/builder/SfPeerBuilder.php';

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
 * @version    SVN: $Id: SfPeerBuilder.php 3663 2007-03-23 13:43:19Z fabien $
 */
class SfAlternativePeerBuilder extends sfPeerBuilder
{

  protected function addClassClose(&$script)
  {
    parent::addClassClose($script);

    $behavior_file_name = 'Base'.$this->getTable()->getPhpName().'Behaviors';
    $behavior_file_path = $this->getFilePath($this->getStubObjectBuilder()->getPackage().'.om.'.$behavior_file_name);
    $absolute_behavior_file_path = sfConfig::get('sf_root_dir').'/'.$behavior_file_path;
    
    if(file_exists($absolute_behavior_file_path))
    {
      unlink($absolute_behavior_file_path);
    }
    
    $behaviors = $this->getTable()->getAttribute('behaviors');
    if($behaviors)
    {
      file_put_contents($absolute_behavior_file_path, sprintf("<?php\nsfPropelBehavior::add('%s', %s);\n", $this->getTable()->getPhpName(), var_export(unserialize($behaviors), true)));
      $script .= sprintf("\n\ninclude_once '%s';\n", $behavior_file_path);
    }
  }

// TEMPORARY : remove these when bug #1585 and #2310 are solved
  protected function addDoSelectJoin(&$script)
  {
    $tmp = '';
    parent::addDoSelectJoin($tmp);

    if (DataModelBuilder::getBuildProperty('builderAddBehaviors'))
    {
      $mixer_script = "

    foreach (sfMixer::getCallables('{$this->getClassname()}:doSelectJoin:doSelectJoin') as \$callable)
    {
      call_user_func(\$callable, '{$this->getClassname()}', \$c, \$con);
    }

";
      $tmp = preg_replace('/public static function doSelectJoin.*\(Criteria \$c, \$con = null\)\n\s*{/', '\0'.$mixer_script, $tmp);
    }

    $script .= $tmp;
  }
  
  protected function addDoSelectJoinAllExcept(&$script)
  {
    $tmp = '';
    parent::addDoSelectJoinAllExcept($tmp);

    if (DataModelBuilder::getBuildProperty('builderAddBehaviors'))
    {
      $mixer_script = "

    foreach (sfMixer::getCallables('{$this->getClassname()}:doSelectJoinAllExcept:doSelectJoinAllExcept') as \$callable)
    {
      call_user_func(\$callable, '{$this->getClassname()}', \$c, \$con);
    }

";
      $tmp = preg_replace('/public static function doSelectJoinAllExcept.*\(Criteria \$c, \$con = null\)\n\s*{/', '\0'.$mixer_script, $tmp);
    }

    $script .= $tmp;
  }

  protected function addDoSelectJoinAll(&$script)
  {
    $tmp = '';
    parent::addDoSelectJoinAll($tmp);

    if (DataModelBuilder::getBuildProperty('builderAddBehaviors'))
    {
      $mixer_script = "

    foreach (sfMixer::getCallables('{$this->getClassname()}:doSelectJoinAll:doSelectJoinAll') as \$callable)
    {
      call_user_func(\$callable, '{$this->getClassname()}', \$c, \$con);
    }

";
      $tmp = preg_replace('/{/', '{'.$mixer_script, $tmp, 1);
    }

    $script .= $tmp;
  }

  protected function addDoSelectRS(&$script)
  {
    $tmp = '';
    parent::addDoSelectRS($tmp);

    if (DataModelBuilder::getBuildProperty('builderAddBehaviors'))
    {
      $mixer_script = "

    foreach (sfMixer::getCallables('{$this->getClassname()}:doSelectRS:doSelectRS') as \$callable)
    {
      call_user_func(\$callable, '{$this->getClassname()}', \$criteria, \$con);
    }

";
      $tmp = preg_replace('/{/', '{'.$mixer_script, $tmp, 1);
    }

    $script .= $tmp;
  }
// TEMPORARY

}
