<?php namespace model\orm;

// Normally loaded by index, but cli-config.php also loads this file
// so we want to make sure we have this
require_once directory( [ 'vendor', 'autoload.php' ], true );

use config\Database;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Setup;

class ORM
{
    const ENTITY_NAMESPACE = __NAMESPACE__ . '\entity';
    
    private static $entityManager;
    
    /**
     * Private function that sets up the manager, called by getManager() if none found
     */
    private static function initManager()
    {
        $paths = [ __DIR__ . '/entity/' ];
        $isDevMode = false;
        
        // the connection configuration
        $dbParams = [
            'driver'   => Database::DRIVER,
            'host'     => Database::HOST,
            'dbname'   => Database::DBNAME,
            'user'     => Database::USER,
            'password' => Database::PASSWORD,
        ];
        
        $config = Setup::createXMLMetadataConfiguration( $paths, $isDevMode );
        self::$entityManager = EntityManager::create( $dbParams, $config );
        self::$entityManager->getConfiguration()->addEntityNamespace( 'entity', self::ENTITY_NAMESPACE );
    }
    
    /**
     * @return EntityManager
     */
    public static function getManager()
    {
        if ( !isset ( self::$entityManager ) )
            self::initManager();
        
        return self::$entityManager;
    }
    
    private function __construct()
    {
    }
    
    private function __clone()
    {
        
    }
}