<?php

pake_desc('Generates a test coverage html report (requires xdebug)');
pake_task('lp-coverage', 'project_exists');

pake_desc('Generates a test coverage report output on the terminal (requires xdebug)');
pake_task('lp-coverage-basic', 'project_exists');

function run_lp_coverage($task, $args)
{
  $project_dir = realpath(dirname(__FILE__) . '/../../../..');
  system("/usr/bin/env php -dxdebug.extended_info=1 $project_dir/test/bin/coverage-html-report");
}

function run_lp_coverage_basic($task, $args)
{
  $project_dir = realpath(dirname(__FILE__) . '/../../../..');
  system("php $project_dir/test/bin/coverage");
}
