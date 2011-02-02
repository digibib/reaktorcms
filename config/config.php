<?php
/**
 * Holds the location of Symfony installation files
 * 
 * PHP version 5
 * 
 * @author    Symfony auto-generated code <no@email.com>
 * @author    Russ Flynn <russ@linpro.no>
 * @copyright 2008 Linpro AS
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 */

if (is_dir("c:\windows"))
{
  $sf_symfony_lib_dir  = 'C:\xampp\php\PEAR\symfony';
  $sf_symfony_data_dir = 'C:\xampp\php\PEAR\data\symfony';  
}
else
{
  $sf_symfony_lib_dir  = '/usr/share/php/symfony';
  $sf_symfony_data_dir = '/usr/share/php/data/symfony';
}