<?php
/**
 * The main template layout for the application
 *
 * This file will be called by default for every page (module) 
 * in the reaktor application. Everything which should be output 
 * to the browser that is outside the body tags should be defined 
 * or loaded from here.
 * 
 * It should not be necessary to edit this file, as it includes several others in the correct order.
 *  - global/header is the main header template which contains all the head tags and loads the menus etc
 *  - 
 *  
 * PHP version 5
 * 
 * @author    Russ Flynn <russ@linpro.no>
 * @copyright 2008 Linpro AS
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 */

include_partial('global/lightheader');

?>
  <div id="content">
    <div id="content_main">
      <?php echo $sf_data->getRaw('sf_content') ?>
    </div>
  </div>
</div>