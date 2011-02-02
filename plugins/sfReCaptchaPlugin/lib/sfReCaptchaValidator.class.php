<?php

/**
 * Verifies the response.
 *
 * @package    symfony
 * @subpackage sfReCaptchaValidator
 * @author     Arthur Koziel <arthur@arthurkoziel.com>
 * @version    SVN: $Id$
 */
class sfReCaptchaValidator extends sfValidator
{
  /**
   * Execute this validator.
   *
   * @param mixed A file or parameter value/array
   * @param error An error message reference
   *
   * @return bool true, if this validator executes successfully, otherwise false
   */
  public function execute(&$value, &$error)
  {
    if (sfConfig::get('sf_environment') === 'test') {
      return true;
    }

    // get values of challange and response fields
    $challenge = $this->getContext()->getRequest()->getParameter('recaptcha_challenge_field');
    $response = $this->getContext()->getRequest()->getParameter('recaptcha_response_field');

    // validate the given response against the challenge
    $resp = recaptcha_check_answer (sfConfig::get('app_recaptcha_privatekey'),
                                    $_SERVER["REMOTE_ADDR"],
                                    $challenge,
                                    $response);

    // if invalid, return error
    if (!$resp->is_valid)
    {
      $error = $resp->error;

      return false;
    }

    return true;
  }

  /**
   * Initializes the validator.
   *
   * @param sfContext The current application context
   * @param array   An associative array of initialization parameters
   *
   * @return bool true, if initialization completes successfully, otherwise false
   */
  public function initialize($context, $parameters = null)
  {
    require_once ('recaptchalib.php');
    
    parent::initialize($context);

    return true;
  }
}
