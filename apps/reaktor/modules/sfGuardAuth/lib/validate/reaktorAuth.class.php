<?php


/**
 *
 * 
 * 
 * @author     Ole-Petter <olepw@linpro.no>
 * @version    SVN: $Id: reaktorAuth.class.php 1343 2008-06-20 08:04:58Z bjori $
 */
class reaktorAuth extends sfValidator
{
  public function initialize($context, $parameters = null)
  {
    // initialize parent
    parent::initialize($context);

    // set defaults
    $this->getParameterHolder()->set('username_error', 'Username or password is not valid.');
    $this->getParameterHolder()->set('password_field', 'password');
    $this->getParameterHolder()->set('remember_field', 'remember');
    $this->getParameterHolder()->set('validated_error', 'The account is not validated.');
    $this->getParameterHolder()->set('verified_error', 'The account has not been verified.');

    $this->getParameterHolder()->add($parameters);

    return true;
  }

  public function execute(&$value, &$error)
  {
    $password_field = $this->getParameterHolder()->get('password_field');
    $password = $this->getContext()->getRequest()->getParameter($password_field);

    $remember = false;
    $remember_field = $this->getParameterHolder()->get('remember_field');
    $remember = $this->getContext()->getRequest()->getParameter($remember_field);

    $username = $value;

    $user = sfGuardUserPeer::retrieveByUsername($username);
    // user exists?
    if ($user)
    {
      
      // password is ok?
      if ($user->checkPassword($password) || $user->getIsActive() == 0 )
      {
        // Make sure the account is active and verified
        if ($user->getIsActive() == 1 && $user->getIsVerified() == 1)
        {
          $this->getContext()->getUser()->signIn($user, $remember);
          return true;
        }
        // OK. So we failed, why?
        if ($user->getIsVerified() != 1)
        {
          $error = $this->getParameterHolder()->get('verified_error');
          return false;
        }
      }
    } else {
      $user = sfGuardUserPeer::retrieveByUsername($username,0);
      if ($user)
      {
        $error = $this->getParameterHolder()->get('validated_error');
        return false;
      }
    }

    $error = $this->getParameterHolder()->get('username_error');

    return false;
  }
}
