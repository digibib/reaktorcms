<?php

pake_desc('Run all acceptance tests');
pake_task('lp-test-acceptance', 'project_exists');

pake_desc('Run all todo tests');
pake_task('lp-test-todo', 'project_exists');

pake_desc('Really run ALL tests');
pake_task('lp-test-all', 'project_exists');



function run_lp_test_todo($task, $args)
{
  if (isset($args[0]))
  {
    foreach ($args as $path)
    {
      $test_dir = realpath(sfConfig::get('sf_test_dir').'/../test-todo');
      $files = pakeFinder::type('file')->ignore_version_control()->follow_link()->name(basename($path).'Test.php')->in($test_dir.DIRECTORY_SEPARATOR.'tests'.DIRECTORY_SEPARATOR.dirname($path));
      foreach ($files as $file)
      {
        include($file);
      }
    }
  }
  else
  {
    require_once(sfConfig::get('sf_symfony_lib_dir').'/vendor/lime/lime.php');

    $h = new lime_harness(new lime_output_color());
    $h->base_dir = realpath(sfConfig::get('sf_test_dir').'/../test-todo');

    // register all tests
    $finder = pakeFinder::type('file')->ignore_version_control()->follow_link()->name('*Test.php');
    $h->register($finder->in($h->base_dir));

    $h->run();
  }
}


function run_lp_test_acceptance($task, $args)
{
  throw new Exception("Task not implemented yet! Check back later ...");
}


function run_lp_test_all($task, $args)
{
  throw new Exception("Task not implemented yet! Check back later ...");
}
