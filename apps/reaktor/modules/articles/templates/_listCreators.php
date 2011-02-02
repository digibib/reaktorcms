<?php
/**
 * Component for dispaying the creator and last modifier of an article
 * Expects:
 * - $article : The article object
 * Available to the template:
 * - $created_by : The username of the creator
 * - $created_at : The time of the last update (mysql datetime)
 * - $updated_by : The username of the user who last modified the article
 * - $updated_at : The time of the last update (mysql datetime)
 * 
 * PHP version 5
 * 
 * @author    Hannes Magnunsson <bjori@linpro.no>
 * @copyright 2008 Linpro AS
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 */
?>

<div class="article_creators">
  <?php if ($created_by): ?>
  	<div class="createdby_block">
    	<span class="createddby">
        <?php echo __("Created by %username% on %date% at %time%", 
             array("%username%" => "<span class='author'>".$created_by."</span>",
                   "%date%" => "<abbr title='".date(DATE_ATOM, strtotime($created_at))."'>".date("d/m/Y", strtotime($created_at)),
                   "%time%" => date("H:i", strtotime($created_at))."</abbr>")); ?>
      </span>
  	</div>
    <?php if ($updated_by): ?>
      <div class="updatedby_block">
        <span class="updatedby">
          <?php echo __("Updated by %username% on %date% at %time%", 
               array("%username%" => "<span class='author'>".$updated_by."</span>",
                     "%date%" => "<abbr title='".date(DATE_ATOM, strtotime($updated_at))."'>".date("d/m/Y", strtotime($updated_at)),
                     "%time%" => date("H:i", strtotime($updated_at))."</abbr>")); ?>
        </span>
      </div>
    <?php endif; ?>
  <?php endif; ?>
</div>