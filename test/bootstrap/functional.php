<?php

/*
 * This file is part of the symfony package.
 * (c) 2004-2006 Fabien Potencier <fabien.potencier@symfony-project.com>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

// guess current application
if (!isset($app))
{
  $traces = debug_backtrace();
  $caller = $traces[0];
  $array = explode(DIRECTORY_SEPARATOR, dirname($caller['file']));
  $app = array_pop($array);
}

// define symfony constant
if (!defined('SF_ROOT_DIR'))
{
  define('SF_ROOT_DIR',    realpath(dirname(__FILE__).'/../..'));
  define('SF_APP',         $app);
  define('SF_ENVIRONMENT', 'test');
  define('SF_DEBUG',       true);
}
// initialize symfony
require_once(SF_ROOT_DIR.DIRECTORY_SEPARATOR.'apps'.DIRECTORY_SEPARATOR.SF_APP.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'config.php');
include(SF_ROOT_DIR.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'db_info.php');

$ds = DIRECTORY_SEPARATOR;
require_once(SF_ROOT_DIR.$ds.'test'.$ds.'bin'.$ds.'reaktorTestBrowser.class.php');
// remove all cache
sfToolkit::clearDirectory(sfConfig::get('sf_cache_dir'));

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
      exec("mysql -u " . $username_test . " --password=" . $password_test . " " . $database_test . " < " .sfConfig::get("sf_root_dir")."/data/sql/".$file);
    }
  }
  
  // Load the fixtures
  $data = new sfPropelData();
  $data->loadData(sfConfig::get('sf_root_dir').'/data/fixtures/');
}

// If the magical $extract18n isset and the $i18ndata variable contains data,
// then dump it into file and import it
if (isset($extract18n) && $extract18n && strlen($i18ndata)) {
  $fp = tmpfile();
  fwrite($fp, $i18ndata);
  $tmp = stream_get_meta_data($fp);
  system("mysql -u " . $username_test . " --password=" . $password_test . " " . $database_test . " < " . $tmp["uri"]);
}


