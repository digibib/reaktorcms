<?php
/*
 * This file is part of the sfPropelTestPlugin package.
 * (c) 2007 Rob Rosenbaum <rob@robrosenbaum.com>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
abstract class sfModelTest extends lime_test
{
  protected $testDataDir;

  public function __construct($fixturesFileOrDir = null)
  {
    if ($fixturesFileOrDir === null) {
      $this->testDataDir = SF_ROOT_DIR . '/test/fixtures';
    } else if (file_exists($fixturesFileOrDir)) {
      $this->testDataDir = $fixturesFileOrDir;
    } else {
      throw new RuntimeException($fixturesFileOrDir.': No such file or directory');
    }

    if (!is_readable($this->testDataDir)) {
      throw new RuntimeException($this->testDataDir.': Could not read file or directory');
    }

    parent::__construct(null, new lime_output_color());
  }

  public function execute()
  {
    $reflection = new ReflectionClass(get_class($this));

    $this->diag($reflection);
    foreach ($reflection->getMethods() as $method) {
      if ($method->isPublic() && 0 === strpos($method->getName(), 'test_')) {
        $this->loadData();
        $this->setup();

        try {
          $method->invoke($this);
        } catch (Exception $e) {
          $this->output->red_bar('Uncaught exception: '.$e->getMessage());
          return false;
        }

        $this->teardown();
      }
    }
  }

  public function loadData()
  {
    $ormDataClass = $this->getORMDataClass();

    $sfData = new $ormDataClass();
    $sfData->setDeleteCurrentData(true);
    $sfData->loadData($this->testDataDir);
  }

  abstract public function getORMDataClass();

  /*
   * These are for child classes to override
   */
  public function setup()
  {
  }

  public function teardown()
  {
  }
}

class sfPropelTest extends sfModelTest
{
  public function getORMDataClass()
  {
    return 'sfPropelData';
  }
}

class sfDoctrineTest extends sfModelTest
{
  public function getORMDataClass()
  {
    return 'sfDoctrineData';
  }
}

class sfPropel13Test extends sfModelTest
{
  public function getORMDataClass()
  {
    return 'sfPropel13Data';
  }
}

