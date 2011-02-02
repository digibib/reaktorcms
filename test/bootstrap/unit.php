<?php

/*
 * This file is part of the symfony package.
 * (c) 2004-2006 Fabien Potencier <fabien.potencier@symfony-project.com>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

$_test_dir = realpath(dirname(__FILE__).'/..');
define('SF_ROOT_DIR', realpath($_test_dir.'/..'));

// symfony directories
include(SF_ROOT_DIR.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'config.php');

require_once($sf_symfony_lib_dir.'/vendor/lime/lime.php');

include($base_dir.'/plugins/sfModelTestPlugin/bootstrap/model-unit.php');

class newLimeTest extends sfPropelTest
{
	
  function __construct($fixturesDirOrFile = null)
  {
  	parent::__construct($fixturesDirOrFile);
  }
	
}

// initialize test data
$databaseManager = new sfDatabaseManager();
$databaseManager->initialize();

// Clear and load sql table structure
if (!defined("NO_CLEAR"))
{
  $dirHandle = opendir(sfConfig::get('sf_root_dir').'/data/sql'); 
  while ($file = readdir($dirHandle))
  {
    if (substr($file, strlen($file) - 3, 3) == "sql")
    {
      exec("mysql -u reaktor_user --password=cT0PHPCm reaktor_test < ".sfConfig::get("sf_root_dir")."/data/sql/".$file);
    }
  }
  
  // Load the fixtures
  $data = new sfPropelData();
  $data->loadData(sfConfig::get('sf_root_dir').'/data/fixtures/');
}

