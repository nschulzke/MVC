<?php
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../config/DBConfig.php';

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

$paths = array(__DIR__ . '/entities/');
$isDevMode = false;

// the connection configuration
$dbParams = array(
    'driver'   => 'pdo_mysql',
    'user'     => DBConfig::getUser(),
    'host'     => DBConfig::getHost(),
    'password' => DBConfig::getPass(),
    'dbname'   => DBConfig::getName(),
);

$config = Setup::createXMLMetadataConfiguration($paths, $isDevMode);
$entityManager = EntityManager::create($dbParams, $config);
?>