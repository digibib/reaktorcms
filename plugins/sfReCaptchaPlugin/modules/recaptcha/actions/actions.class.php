<?php

/**
 * recaptcha actions.
 *
 * @package    sfReCaptchaPlugin
 * @subpackage recaptcha
 * @author     Arthur Koziel <arthur@arthurkoziel.com>
 * @version    SVN: $Id$
 */
class recaptchaActions extends sfActions
{
  public function executeIndex()
  {    
    if ($this->getRequest()->getMethod() == sfRequest::POST) {
      // captcha correct; do whatever you want here
    }
  }

  public function handleErrorIndex()
  {
    return sfView::SUCCESS;
  }

  public function executeMailhide()
  {
  }
}
