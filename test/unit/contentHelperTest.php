<?php

/**
 * Unit tests for the content helper
 * 
 * PHP version 5
 * 
 * @author    Kjell-Magne Oierud <kjellm@linpro.no>
 * @copyright 2008 Linpro AS
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 * @version   SVN: $Id: contentHelperTest.php 524 2008-03-28 00:58:49Z kjellm $
 */


require dirname(__FILE__).'/../bootstrap/unit.php';
require_once dirname(__FILE__).'/../../apps/reaktor/lib/helper/contentHelper.php';
                              
$t = new lime_test(1, new lime_output_color());
                              
$t->pass("Replace me!");