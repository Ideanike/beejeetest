<?php

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Setup;

$isDevMode = true;
$proxyDir = null;
$cache = null;
$useSimpleAnnotationReader = false;
$config = Setup::createAnnotationMetadataConfiguration(
    array(dirname(__DIR__) . "/App/Entity"),
    $isDevMode,
    $proxyDir,
    $cache,
    $useSimpleAnnotationReader
);

$conn = array(
    'driver' => 'pdo_sqlite',
    'path' => 'db.sqlite',
);

$entityManager = EntityManager::create($conn, $config);