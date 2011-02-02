<?php
/**
 * Defines the reaktor application environment, can be called using http://reaktor/reaktor.php
 * Copy to index.php when required as the default loading environment 
 * 
 * PHP version 5
 * 
 * @author    Symfony auto-generated code <no@email.com>
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