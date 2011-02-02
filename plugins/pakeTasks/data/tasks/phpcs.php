<?php

pake_desc('Analyses a source code file for coding standard violations.');
pake_task('lp-phpcs', 'project_exists');

pake_desc('Analyses the entire source code for coding standard violations.');
pake_task('lp-phpcs-all', 'project_exists');

chdir(realpath(dirname(__FILE__) . '/../../../..'));

function run_lp_phpcs($task, $args)
{
  if (count($args) != 1) 
  {
    throw new Exception("Illegal usage\nUsage: symfony lp-phpcs <file>");
  }

  system("phpcs --standard=reaktor " . $args[0]);
}

function run_lp_phpcs_all($task, $args)
{
  $project_dir = LP_PROJECT_DIR;
  system("phpcs --report=summary --ignore=/om,/cache,/log,/codesniff,/test,/plugins,/templates .");
}
