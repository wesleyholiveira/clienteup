<?php

declare(strict_types=1);
require_once 'vendor/autoload.php';

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;
use ClienteUp\Model\Entidade\Products;

require_once "vendor/autoload.php";

// Create a simple "default" Doctrine ORM configuration for Annotations
$config = Setup::createAnnotationMetadataConfiguration(array(__DIR__."/src/Model/Entidade"), true);
// or if you prefer yaml or XML
//$config = Setup::createXMLMetadataConfiguration(array(__DIR__."/config/xml"), $isDevMode);
//$config = Setup::createYAMLMetadataConfiguration(array(__DIR__."/config/yaml"), $isDevMode);

// database configuration parameters
$conn = array(
    'driver' => 'pdo_mysql',
    'dbname' => 'teste',
    'user' => 'root',
    'password' => '',
    'host' => 'localhost'
);

// obtaining the entity manager
$entityManager = EntityManager::create($conn, $config);
$products = $entityManager->find('Products', array('id' => 1));

var_dump($products->getId());
