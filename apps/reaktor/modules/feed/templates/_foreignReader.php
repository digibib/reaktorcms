<?php
/**
 * Component to parse and display a feed from a foreign website (could of course also parse reaktor
 * feeds ;) ) Displays header + short section of the ingress + "read more".
 * 
 * Needs the following parameters:
 * 'feedurl' - The url of the foreign feed. Must be a valid Atom/RSS feed
 * 
 * Optional parameters:
 * 'title'         - If you want to display a title above the items
 * 'items'         - If you want to display more than/fewer than 5 news items
 * 'ingresslength' - If you want to display a longer/shorter ingress
 * 'showreadmore'  - If you don't want to display the 'Read more'-link, set this to false
 * 'headerlink'    - If you want to make the item headers into links, set this to true
 *  
 * PHP version 5
 * 
 * @author    Daniel Andre Eikeland <dae@linpro.no>
 * @copyright 2008 Linpro AS
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 */
?>

<div class="foreignfeed_<?php echo $feedstyle; ?>">
	<ul class="foreignfeed_list">
		<?php if ($feederror): ?>
		  <li><?php //echo $feederror; ?>
		  <?php echo __('An error occured while reading source feed') ?>
		  </li>
    <?php else: ?>
		  <?php if ($feedtitle): ?>
		    <li><h4><?php echo $feedtitle; ?></h4></li>
		  <?php endif; ?>
			<?php foreach ($feed->getItems() as $item): ?>
			  <?php $feedcount++; ?>
			  <li>
	      <?php if (!$headerlink): ?>
	        <h5><?php echo $item->getTitle(); ?></h5>
	      <?php else: ?>
	        <b><a href="<?php echo $item->getLink(); ?>" target="_new"><?php echo $item->getTitle() ?></a></b><br />
	      <?php endif; ?>
			  <?php echo (strlen($item->getDescription()) > $ingresslength) ? substr($item->getDescription(), 0, ($ingresslength - 3)) . '[...] ' : $item->getDescription() . ' '; ?>
	      <?php if ($showreadmore): ?>
	        <a href="<?php echo $item->getLink(); ?>" target="_new"><?php echo __('Read more') ?></a>
	      <?php endif; ?>
	      </li>
			  <?php if ($feedcount >= $items): ?>
			    <?php break; ?>
			  <?php endif; ?>
			<?php endforeach; ?>
    <?php endif; ?>
	</ul>
</div>