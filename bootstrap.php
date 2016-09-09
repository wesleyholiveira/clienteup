<?php

use Doctrine\ORM\EntityManager;

$config = Doctrine\ORM\Tools\Setup::createAnnotationMetadataConfiguration(array(__DIR__.'/src/Model/Entities'), true);
$em = EntityManager::create(ClienteUp\Config\BD::DadosConexao, $config);

