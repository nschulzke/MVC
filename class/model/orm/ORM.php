<?php namespace model\orm;

use config\Application;

require_once Application::getDocRoot() . '/vendor/autoload.php';

use config\Database;
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

class ORM {

    private static $entityManager;

    /**
     * @return EntityManager
     */
    public static function getManager() {
        if (!isset (self::$entityManager))
            self::initManager();
        return self::$entityManager;
    }

    private static function initManager() {
        $paths = array( __DIR__ . '/entity/' );
        $isDevMode = false;

        // the connection configuration
        $dbParams = array(
            'driver'   => 'pdo_mysql',
            'user'     => Database::getUser(),
            'host'     => Database::getHost(),
            'password' => Database::getPass(),
            'dbname'   => Database::getName(),
        );

        $config = Setup::createXMLMetadataConfiguration( $paths, $isDevMode );
        self::$entityManager = EntityManager::create( $dbParams, $config );
        self::$entityManager->getConfiguration()->addEntityNamespace('entity', 'model\orm\entity');
    }

    private function __construct() {
    }

    private function __clone() {

    }
}