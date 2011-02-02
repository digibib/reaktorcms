<?php
/**
 * Defines the deafult application environment, copy of reaktor.php
 * Loaded when a user navigates to web root or explicitly calls index.php
 * 
 * PHP version 5
 * 
 * @author    Russ Flynn <russ@linpro.no>
 * @copyright 2008 Linpro AS
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 */

define('SF_ROOT_DIR', realpath(dirname(__FILE__).'/..'));
define('SF_APP', 'reaktor');
define('SF_ENVIRONMENT', 'prod');
define('SF_DEBUG', false);

require_once SF_ROOT_DIR.DIRECTORY_SEPARATOR.'apps'.DIRECTORY_SEPARATOR.SF_APP.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'config.php';

sfContext::getInstance()->getController()->dispatch();