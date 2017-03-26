<?php namespace model\orm;

// Normally loaded by index, but cli-config.php also loads this file
// so we want to make sure we have this
require_once directory( [ 'vendor', 'autoload.php' ], true );

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
        $paths = [ __DIR__ . '/entity/' ];
        $isDevMode = false;

        // the connection configuration
        $dbParams = [
            'driver'   => 'pdo_mysql',
            'user'     => Database::USER,
            'host'     => Database::HOST,
            'password' => Database::PASS,
            'dbname'   => Database::NAME,
        ];

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