<?php

declare(strict_types=1);
require_once 'vendor/autoload.php';
require_once 'bootstrap.php';

use Silex\Application;
use ClienteUp\Model\Entities\Cliente;

$app = new Application();
$app['debug'] = true;

$cliente = $em->find('ClienteUp\Model\Entities\Cliente', 1);
var_dump($cliente);

$app->run();