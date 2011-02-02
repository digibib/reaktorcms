#! /usr/bin/php
<?php
/**
 * Used for loading batch data from data/fictures.yml
 * 
 * PHP version 5
 * 
 * @author    Russ Flynn <russ@linpro.no>
 * @copyright 2008 Linpro AS
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 */
 
define('SF_ROOT_DIR', realpath(dirname(__FILE__).'/..'));
define('SF_APP', 'reaktor');
define('SF_ENVIRONMENT', 'dev');
define('SF_DEBUG', true);
 
require_once SF_ROOT_DIR.DIRECTORY_SEPARATOR.'apps'.DIRECTORY_SEPARATOR.SF_APP.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'config.php';
 
// initialize database manager
$databaseManager = new sfDatabaseManager();
$databaseManager->initialize();

$data = new sfPropelData();
$data->loadData(sfConfig::get('sf_data_dir').DIRECTORY_SEPARATOR.'fixtures');

?>
