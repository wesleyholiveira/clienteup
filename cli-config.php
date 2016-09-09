<?php
// cli-config.php
require_once 'vendor/autoload.php';
require_once 'bootstrap.php';

use Doctrine\ORM\Tools\Console\ConsoleRunner;

return ConsoleRunner::createHelperSet($em);