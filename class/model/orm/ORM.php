<?php namespace model\orm;

// Normally loaded by index, but cli-config.php also loads this file
// so we want to make sure we have this
require_once directory( array( 'vendor', 'autoload.php' ), true );

use config\Database;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Setup;

class ORM
{

    private static $entityManager;

    /**
     * @return EntityManager
     */
    public static function getManager()
    {
        if ( !isset ( self::$entityManager ) )
            self::initManager();
        return self::$entityManager;
    }

    /**
     * Private function that sets up the manager, called by getManager() if none found
     */
    private static function initManager()
    {
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
        self::$entityManager->getConfiguration()->addEntityNamespace( 'entity', 'model\orm\entity' );
    }

    private function __construct()
    {
    }

    private function __clone()
    {

    }
}