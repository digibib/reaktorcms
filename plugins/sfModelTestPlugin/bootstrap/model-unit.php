<?php
/*
 * This file is part of the sfPropelTestPlugin package.
 * (c) 2007 Rob Rosenbaum <rob@robrosenbaum.com>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

if (!@constant('SF_APP')) {
  die ('Constant "SF_APP" must be defined in your test script.'."\n");
}

if (!@constant('SF_ENVIRONMENT')) { // Only load constants in not done before (group tests)
  define('SF_ENVIRONMENT', 'test');
  define('SF_DEBUG', TRUE);
  define('SF_ROOT_DIR', realpath(dirname(__FILE__).'/../../..'));

  // symfony directories
  require_once(SF_ROOT_DIR.DIRECTORY_SEPARATOR.'apps'.DIRECTORY_SEPARATOR.SF_APP.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'config.php');

  $databaseManager = new sfDatabaseManager();
  $databaseManager->initialize();

  require_once($sf_symfony_lib_dir.'/vendor/lime/lime.php');
  require_once(dirname(__FILE__).'/../lib/sfModelTest.php');
}
