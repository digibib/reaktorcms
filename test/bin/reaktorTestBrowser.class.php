<?php
/**
 * reaktorTestBrowser 
 * 
 * @uses sfTestBrowser
 * @version $Id: reaktorTestBrowser.class.php 2133 2008-08-20 10:39:20Z bjori $
 * @copyright 2008 Linpro AS
 * @author Hannes Magnusson <bjori@linpro.no> 
 * @license http://www.gnu.org/copyleft/lesser.html LGPL License 2.1
 */

// Define bogus missing functions if xdebug is disabled
if (!function_exists("xdebug_call_file")) {
  function xdebug_call_file() {
    return null;
  }
  function xdebug_call_line() {
    return null;
  }
}

class reaktorTestBrowser extends sfTestBrowser
{
  /**
   * Contains the file currently being tested
   * 
   * @var string
   */
  private $TESTFILE;

  /**
   * Contains the user visible test descriptions
   * 
   * @var array(linenr => testdesc)
   */
  private $TESTNAMES = array();

  /**
   *  The prepared statement used by the dtor
   *  @var resource
   */
  private static $stmt = null;

  /**
   * Stores failure count between tests
   * 
   * @var int
   */
  private $lastFailed = 0;

  /**
   * Initialize the reaktor test browser, optionally passing 
   * /path/to/sqlite/db.file
   * 
   * @param string $db SQLite3 db location
   */
  public function __construct($db = null) {
     // Store the test filename and fetch all the test descriptions
    $this->TESTFILE = $filename = (xdebug_call_file() ? xdebug_call_file() : "unknown");
    // Disable per-test-stats if xdebug is disabled
    if ($filename != "unknown") {
      $this->TESTNAMES = self::getTokens($filename);
    } else {
      $this->TESTNAMES = array();
    }

    // Prepare the insert statement if we don't have one
    if ($filename != "unknown" && self::$stmt === null) {
      // ..but first we need to connect to the database
      if (!$db) {
        $db = "/tmp/tests.db";
      }
      $old = file_exists($db);
      $pdo = new PDO("sqlite:$db");

      // If the file didn't exist before we need to create the database then
      if (!$old) {
        $create = <<< EOT
CREATE TABLE tests (
filename TINYTEXT,
description TINYTEXT,
line TINYINT,
status TINYINT,
date INT
)
EOT;

        $pdo->exec($create);
      }
      self::$stmt = $pdo->prepare("INSERT INTO tests ".
                  "VALUES(:filename, :description, :line, :status, :date)");

      if (!self::$stmt) {
        throw new RuntimeException($pdo->errorInfo());
      }
    }

    // sfTestBrowser doesn't have a ctor atm, but it may in the future..
    if (is_callable(array("parent", __FUNCTION__), false)) {
      $args = func_get_args();
      return call_user_func_array(array("parent", __FUNCTION__), $args);
    }
  }

  /**
   * Stores the test results in the database
   * 
   * @return void
   */
  public function __destruct() {
    $filename = $this->TESTFILE;
    $t = $_SERVER["REQUEST_TIME"];

    // Loop over the results and insert into db
    foreach($this->TESTNAMES as $nfo) {
      $ret = self::$stmt->execute(array(
        ":filename"    => $filename,
        ":description" => $nfo["desc"],
        ":line"        => (int)$nfo["line"],
        ":status"      => (int)$nfo["success"],
        ":date"        => $t,
      ));
      if (!$ret) {
        trigger_error(self::$stmt->errorInfo(), E_USER_WARNING);
        break;
      }
    }
    // sfTestBrowser doesn't have a dtor atm, but it may in the future..
    if (is_callable(array("parent", __FUNCTION__), false)) {
      $args = func_get_args();
      return call_user_func_array(array("parent", __FUNCTION__), $args);
    }
  }

  public static function getTokens($filename) {
    $tests = array();
    $lastline = -1;

    $count = 0;
    foreach (token_get_all(file_get_contents($filename)) as $tokens) {
      if ($tokens[0] == T_COMMENT) {
        // Only "//" are user-intended-descriptions
        if (!($tokens[1][0] == "/" && $tokens[1][1] == "/")) {
          continue;
        }

        // Chop the comment characters
        $testdesc = substr($tokens[1], 2);
        $testdesc = trim($testdesc);

        // If it was a multiline comment, merge it
        if ($lastline == $tokens[2]-1) {
          $tests[$count-1]["desc"] .= "\n" . $testdesc;
        } else {
          ++$count;
          $tests[] = array(
            "line" => $tokens[2],
            "desc" => ucfirst($testdesc),
            "success" => true,
          );
        }
        $lastline = $tokens[2];
      }
    }
    return $tests;
  }

  /**
   * Mark a test as passed/failed
   * 
   * @param mixed $line 
   * @return void
   */
  protected function markTest($line, $pass) {
    foreach($this->TESTNAMES as $k => $test) {
      if ($test["line"] < $line) {
        $mark = $test;
        $key = $k;
      }
    }
    $mark["success"] = $pass;
    $this->TESTNAMES[$key] = $mark;
  }

  // Overwrite various sfTestBrowser methods
  public function test() {
    // Call the parent with whatever arguments we got
    $args = func_get_args();
    $retval = call_user_func_array(array("parent", __FUNCTION__), $args);

    $failed = $this->test->failed;
    // Check if the failure count has increased
    if ($this->lastFailed != $failed) {
      // Check if it was the test itself that called us
      // or if it was a $this->method() call
      if (xdebug_call_file() == $this->TESTFILE) {
        $line = xdebug_call_line();
        $this->markTest($line, false);
      }
    }

    $this->lastFailed = $failed;

    return $retval;
  }
  public function call() {
    $args = func_get_args();
    $retval = call_user_func_array(array("parent", __FUNCTION__), $args);

    $failed = $this->test->failed;
    if ($this->lastFailed != $failed) {
      if (xdebug_call_file() == $this->TESTFILE) {
        $line = xdebug_call_line();
        $this->markTest($line, false);
      }
    }
    $this->lastFailed = $failed;

    return $retval;
  }
  public function forward() {
    $args = func_get_args();
    $retval = call_user_func_array(array("parent", __FUNCTION__), $args);

    $failed = $this->test->failed;
    if ($this->lastFailed != $failed) {
      if (xdebug_call_file() == $this->TESTFILE) {
        $line = xdebug_call_line();
        $this->markTest($line, false);
      }
    }
    $this->lastFailed = $failed;

    return $retval;
  }
  public function isRedirected() {
    $args = func_get_args();
    $retval = call_user_func_array(array("parent", __FUNCTION__), $args);

    $failed = $this->test->failed;
    if ($this->lastFailed != $failed) {
      if (xdebug_call_file() == $this->TESTFILE) {
        $line = xdebug_call_line();
        $this->markTest($line, false);
      }
    }
    $this->lastFailed = $failed;

    return $retval;
  }
  public function isStatusCode() {
    $args = func_get_args();
    $retval = call_user_func_array(array("parent", __FUNCTION__), $args);

    $failed = $this->test->failed;
    if ($this->lastFailed != $failed) {
      if (xdebug_call_file() == $this->TESTFILE) {
        $line = xdebug_call_line();
        $this->markTest($line, false);
      }
    }
    $this->lastFailed = $failed;

    return $retval;
  }
  public function responseContains() {
    $args = func_get_args();
    $retval = call_user_func_array(array("parent", __FUNCTION__), $args);

    $failed = $this->test->failed;
    if ($this->lastFailed != $failed) {
      if (xdebug_call_file() == $this->TESTFILE) {
        $line = xdebug_call_line();
        $this->markTest($line, false);
      }
    }
    $this->lastFailed = $failed;

    return $retval;
  }
  public function isRequestParameter() {
    $args = func_get_args();
    $retval = call_user_func_array(array("parent", __FUNCTION__), $args);

    $failed = $this->test->failed;
    if ($this->lastFailed != $failed) {
      if (xdebug_call_file() == $this->TESTFILE) {
        $line = xdebug_call_line();
        $this->markTest($line, false);
      }
    }
    $this->lastFailed = $failed;

    return $retval;
  }
  public function isForwardedTo() {
    $args = func_get_args();
    $retval = call_user_func_array(array("parent", __FUNCTION__), $args);

    $failed = $this->test->failed;
    if ($this->lastFailed != $failed) {
      if (xdebug_call_file() == $this->TESTFILE) {
        $line = xdebug_call_line();
        $this->markTest($line, false);
      }
    }
    $this->lastFailed = $failed;

    return $retval;
  }
  public function isResponseHeader() {
    $args = func_get_args();
    $retval = call_user_func_array(array("parent", __FUNCTION__), $args);

    $failed = $this->test->failed;
    if ($this->lastFailed != $failed) {
      if (xdebug_call_file() == $this->TESTFILE) {
        $line = xdebug_call_line();
        $this->markTest($line, false);
      }
    }
    $this->lastFailed = $failed;

    return $retval;
  }
  public function checkResponseElement() {
    $args = func_get_args();
    $retval = call_user_func_array(array("parent", __FUNCTION__), $args);

    $failed = $this->test->failed;
    if ($this->lastFailed != $failed) {
      if (xdebug_call_file() == $this->TESTFILE) {
        $line = xdebug_call_line();
        $this->markTest($line, false);
      }
    }
    $this->lastFailed = $failed;

    return $retval;
  }
  public function setVar() {
    $args = func_get_args();
    $retval = call_user_func_array(array("parent", __FUNCTION__), $args);

    $failed = $this->test->failed;
    if ($this->lastFailed != $failed) {
      if (xdebug_call_file() == $this->TESTFILE) {
        $line = xdebug_call_line();
        $this->markTest($line, false);
      }
    }
    $this->lastFailed = $failed;

    return $retval;
  }
  public function post() {
    $args = func_get_args();
    $retval = call_user_func_array(array("parent", __FUNCTION__), $args);

    $failed = $this->test->failed;
    if ($this->lastFailed != $failed) {
      if (xdebug_call_file() == $this->TESTFILE) {
        $line = xdebug_call_line();
        $this->markTest($line, false);
      }
    }
    $this->lastFailed = $failed;

    return $retval;
  }
  public function getResponse() {
    $args = func_get_args();
    $retval = call_user_func_array(array("parent", __FUNCTION__), $args);

    $failed = $this->test->failed;
    if ($this->lastFailed != $failed) {
      if (xdebug_call_file() == $this->TESTFILE) {
        $line = xdebug_call_line();
        $this->markTest($line, false);
      }
    }
    $this->lastFailed = $failed;

    return $retval;
  }
  public function getRequest() {
    $args = func_get_args();
    $retval = call_user_func_array(array("parent", __FUNCTION__), $args);

    $failed = $this->test->failed;
    if ($this->lastFailed != $failed) {
      if (xdebug_call_file() == $this->TESTFILE) {
        $line = xdebug_call_line();
        $this->markTest($line, false);
      }
    }
    $this->lastFailed = $failed;

    return $retval;
  }

  // Helper methods for repeated actions


  /**
   * Login as $username, $password to the $uri
   * 
   * @param string $username 
   * @param string $password 
   * @param string $uri 
   * @return reaktorTestBrowser
   */
  function login($username, $password, $uri = "/no", $followRedirect = true) {
    return $this
      ->logout()
      ->get($uri)
      ->setField('username', $username)
      ->setField('password', $password)
      ->click('Sign in') && $followRedirect ?
        $this->followRedirect() :
      $this;
  }

  /**
   * logout
   * 
   * @param void
   */
  function logout() {
    sfConfig::set("mypage_mode", false);
    sfConfig::set("admin_mode", false);
    return $this->get("/no/logout");
  }

}
# vim: et sw=2 ts=2

