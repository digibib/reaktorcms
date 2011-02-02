<?php
/**
 * RSS Feeds
 *
 * PHP Version 5
 *
 * @author    Daniel Andre Eikeland <dae@linpro.no>
 * @copyright 2008 Linpro AS
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 *
 */

/**
 * RSS feed components class
 *
 * PHP Version 5
 *
 * @author    Daniel Andre Eikeland <dae@linpro.no>
 * @copyright 2008 Linpro AS
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 *
 */
class feedComponents extends sfComponents
{
	
	public function executeForeignReader()
	{
		$this->feederror = null;
		if ($this->feedurl)
		{
			$timeout = $this->timeout?$this->timeout:1;
			
			try
			{
				$feed                = sfFeedPeer::createFromWeb($this->feedurl,array('adapter' => 'sfFopenAdapter', 'adapter_options' => array('timeout' => $timeout)));
	      $this->items         = (isset($this->items)) ? $this->items : 5;
	      $this->feedtitle     = (isset($this->title)) ? $this->title : '';
	      $this->feedstyle     = (isset($this->source)) ? $this->source : 'normal';
	      $this->ingresslength = (isset($this->ingresslength)) ? $this->ingresslength : 80;
	      $this->showreadmore  = (isset($this->showreadmore)) ? $this->showreadmore : true;
	      $this->headerlink    = (isset($this->headerlink)) ? $this->headerlink : false;
	      $this->feed          = $feed;
	      $this->feedcount     = 0;
			}
			catch (Exception $e)
			{
				$this->feederror = $e->getMessage();
        return sfView::NONE;
			}
		}
	}
	
}
