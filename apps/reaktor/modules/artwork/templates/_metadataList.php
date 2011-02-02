<?php
/**
 * Show a nice metadata box for use on the artwork show page
 * Add elements by listing them below in the arrays, following the examples given.
 * This method of listing is used to aid with translation of the element titles.
 * Refer to metaMap.yml for the list of available metadata elements 
 * - $artwork: The artwork object (just in case we want to show some artwork values too
 * - $file:    The file object that contains the metadata
 *  
 * PHP Version 5
 *
 * @author    Russ <russ@linpro.no>
 * @copyright 2008 Linpro AS
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 *
 */

// Image files
/**
$metaArray["image"][__("Width")]["element"]   = "format";
$metaArray["image"][__("Width")]["qualifier"] = "width";
$metaArray["image"][__("Width")]["suffix"]    = "px";

$metaArray["image"][__("Height")]["element"]   = "format";
$metaArray["image"][__("Height")]["qualifier"] = "height";
$metaArray["image"][__("Height")]["suffix"]    = "px";
*/

$metaArray["image"][__("Created by")]["element"]   = "creator";
$metaArray["image"][__("Created by")]["qualifier"] = "";

$metaArray["image"][__("Created at")]["element"]   = "date";
$metaArray["image"][__("Created at")]["qualifier"] = "creation";
$metaArray["image"][__("Created at")]["date"]      = "d/m/Y h:i"; // See http://php.net/date for formatting options

$metaArray["image"][__("Camera")]["element"]   = "description";
$metaArray["image"][__("Camera")]["qualifier"] = "camera";

$metaArray["image"][__("Aperture")]["element"]   = "format";
$metaArray["image"][__("Aperture")]["qualifier"] = "aperture";

$metaArray["image"][__("Shutter")]["element"]   = "format";
$metaArray["image"][__("Shutter")]["qualifier"] = "shutter";

$metaArray["image"][__("Focal Length")]["element"]   = "format";
$metaArray["image"][__("Focal Length")]["qualifier"] = "focalLength";

$metaArray["image"][__("Software")]["element"]   = "description";
$metaArray["image"][__("Software")]["qualifier"] = "software";

$metaArray["image"][__("Production")]["element"]   = "description";
$metaArray["image"][__("Production")]["qualifier"] = "creation";
$metaArray["image"][__("Production")]["newline"] = true;      // Uses a block of text under the header instead of alongside

/*
$metaArray["image"][__("Description")]["element"]   = "description";
$metaArray["image"][__("Description")]["qualifier"] = "abstract";
$metaArray["image"][__("Description")]["newline"] = true;
*/


//Audio files
$metaArray["audio"][__("Track title")]["element"]   = "title";

$metaArray["audio"][__("Description")]["element"]   = "description";
$metaArray["audio"][__("Description")]["qualifier"] = "abstract";

$metaArray["audio"][__("Created by")]["element"]   = "creator";
$metaArray["audio"][__("Created by")]["qualifier"] = "";

$metaArray["audio"][__("Created at")]["element"]   = "date";
$metaArray["audio"][__("Created at")]["qualifier"] = "creation";
$metaArray["audio"][__("Created at")]["date"]      = "d/m/Y h:i"; // See http://php.net/date for formatting options

$metaArray["audio"][__("Production method")]["element"]   = "description";
$metaArray["audio"][__("Production method")]["qualifier"] = "creation";
$metaArray["audio"][__("Production method")]["newline"] = true;      // Uses a block of text under the header instead of alongside

//Video files
$metaArray["video"][__("Created by")]["element"]   = "creator";
$metaArray["video"][__("Created by")]["qualifier"] = "";

$metaArray["video"][__("Created at")]["element"]   = "date";
$metaArray["video"][__("Created at")]["qualifier"] = "creation";
$metaArray["video"][__("Created at")]["date"]      = "d/m/Y h:i"; // See http://php.net/date for formatting options

//PDFs
$metaArray["pdf"][__("Created by")]["element"]   = "creator";
$metaArray["pdf"][__("Created by")]["qualifier"] = "";

$metaArray["pdf"][__("Created at")]["element"]   = "date";
$metaArray["pdf"][__("Created at")]["qualifier"] = "creation";
$metaArray["pdf"][__("Created at")]["date"]      = "d/m/Y h:i"; // See http://php.net/date for formatting options

//Text files
$metaArray["text"][__("Created by")]["element"]   = "creator";
$metaArray["text"][__("Created by")]["qualifier"] = "";

$metaArray["text"][__("Created at")]["element"]   = "date";
$metaArray["text"][__("Created at")]["qualifier"] = "creation";
$metaArray["text"][__("Created at")]["date"]      = "d/m/Y h:i"; // See http://php.net/date for formatting options

//Flash animation
$metaArray["flash_animation"][__("Created by")]["element"]   = "creator";
$metaArray["flash_animation"][__("Created by")]["qualifier"] = "";

$metaArray["flash_animation"][__("Created at")]["element"]   = "date";
$metaArray["flash_animation"][__("Created at")]["qualifier"] = "creation";
$metaArray["flash_animation"][__("Created at")]["date"]      = "d/m/Y h:i"; // See http://php.net/date for formatting options

$hasmetainfo = false;

?>

<?php if (isset($metaArray[$file->getIdentifier()]) && !empty($metaArray[$file->getIdentifier()])): ?>
  <div id="meta_list" class="grey_background" style="margin-top: 10px;">
    <div class="clearboth"><h2><?php echo $file->getTitle(); ?></h2></div>
    <?php foreach ($metaArray[$file->getIdentifier()] as $name => $valuesArray): ?>
  	  <?php if (!isset($valuesArray["qualifier"])) $valuesArray["qualifier"] = ""; ?>
  	  <?php if ($value = $file->getMetaData($valuesArray["element"], $valuesArray["qualifier"])): ?>
  	  	<?php if(isset($valuesArray["date"])): ?>
  	  		<?php $value = date($valuesArray["date"], strtotime($value)); ?>
  	    <?php endif; ?>
  			<h4 <?php echo (isset($valuesArray["newline"]) && $valuesArray["newline"]) ? "" : "style='display:inline;'"; ?>>
  			  <?php echo $name.": "; ?></h4>
  			<?php if (isset($valuesArray["newline"]) && $valuesArray["newline"]): ?>
  				<p>
  					<?php echo nl2br($value); ?>
  				</p>
  			<?php else: ?>
    			<span>
      	  	<?php echo isset($valuesArray["prefix"]) ? $valuesArray["prefix"] : ""; ?>
      	  	<?php echo $value; ?>
      	  	<?php echo isset($valuesArray["suffix"]) ? $valuesArray["suffix"] : ""; ?>
            <br />
      	  </span>
      	<?php endif; ?>
        <?php $hasmetainfo = true; ?>
  	  <?php endif; ?>
  	<?php endforeach; ?>
    <?php if (!$hasmetainfo): ?>
      <p><?php echo __('The author has not given any additional details about this file'); ?></p>
    <?php endif; ?>
  </div>
<?php endif; ?>

