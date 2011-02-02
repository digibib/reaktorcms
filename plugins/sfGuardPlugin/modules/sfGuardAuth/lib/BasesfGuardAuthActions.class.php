<?php

/* 
 * This file is part of the symfony package.
 * (c) 2004-2006 Fabien Potencier <fabien.potencier@symfony-project.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 *
 * @package    symfony
 * @subpackage plugin
 * @author     Fabien Potencier <fabien.potencier@symfony-project.com>
 * @version    SVN: $Id: BasesfGuardAuthActions.class.php 5003 2007-09-08 08:42:27Z fabien $
 */
class BasesfGuardAuthActions extends sfActions
{
  public function executeSignin()
  {
    $user = $this->getUser();
    if ($this->getRequest()->getMethod() == sfRequest::POST)
    {
      //Changed by Russ Flynn - possible fix to redirect error?
      //$referer = $user->getAttribute('referer', $this->getRequest()->getReferer());
      // $referer = $user->getAttribute('referer') ? $user->getAttribute('referer') : $this->getRequest()->getReferer();
      $referer = $this->getRequestParameter('referer') ? $this->getRequestParameter('referer') : "/fred";
      
      $user->getAttributeHolder()->remove('referer');

      $signin_url = sfConfig::get('app_sf_guard_plugin_success_signin_url', $referer);

      $this->redirect('' != $signin_url ? $signin_url : '@home');
    }
    elseif ($user->isAuthenticated())
    {
      $this->redirect('@home');
    }
    else
    {
      if (!$user->hasAttribute('referer'))
      {
        $user->setAttribute('referer', $this->getRequest()->getReferer());
      }

      $module = sfConfig::get('sf_login_module');
      if ($this->getModuleName() != $module)
      {
        $this->redirect($module.'/'.sfConfig::get('sf_login_action'));
      }
    }
  }

  public function executeSignout()
  {
    $this->getUser()->signOut();

    $signout_url = sfConfig::get('app_sf_guard_plugin_success_signout_url', $this->getRequest()->getReferer());

  }

  public function executeSecure()
  {
  }

  public function executePassword()
  {
    throw new sfException('This method is not yet implemented.');
  }

  public function handleErrorSignin()
  {
    $user = $this->getUser();
    if (!$user->hasAttribute('referer'))
    {
      $user->setAttribute('referer', $this->getRequest()->getReferer());
    }

    $module = sfConfig::get('sf_login_module');
    if ($this->getModuleName() != $module)
    {
      $this->forward(sfConfig::get('sf_login_module'), sfConfig::get('sf_login_action'));
    }

    return sfView::SUCCESS;
  }
}
