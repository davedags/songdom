<?php

namespace Songdom;

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

class App
{

    private $app;

    public function __construct($args = [])
    {

        $config = [];
        if ($this->debugMode()) {
            $config['displayErrorDetails'] = true;
        }

        $app = new \Slim\App([
            'settings' => $config
        ]);

        $container = $app->getContainer();

        $container['em'] = function () {
            return $this->getDoctrineEntityManager();
        };

        $app->options('/{routes:.+}', function ($request, $response, $args) {
            return $response;
        });
        
        $app->add(function ($req, $res, $next) {
            $response = $next($req, $res);
            return $response
                ->withHeader('Access-Control-Allow-Origin', '*')
                ->withHeader('Access-Control-Allow-Origin', '*')
                ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
                ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
        });
        
        //Routes
        $app->get('/search', 'Songdom\Controller\Song:getLyrics');
        $app->post('/users', 'Songdom\Controller\User:create');
                
        $this->app = $app;
    }

    public function getDoctrineEntityManager()
    {
        $entity_manager = false;
        if ($db_config = self::getDBConfig()) {
            $config = \Doctrine\ORM\Tools\Setup::createAnnotationMetadataConfiguration([__DIR__ . "/Entities"]);
            $conn = array_merge(['driver' => 'pdo_mysql'], $db_config);
            $entity_manager = \Doctrine\ORM\EntityManager::create($conn, $config);
        }
        return $entity_manager;
    }

    public static function getDBConfig()
    {
        $config = [];
        if (file_exists(__DIR__ . '/config/.env')) {
            $dotenv = new \Dotenv\Dotenv(__DIR__ . '/config');
            $dotenv->load();

            $config['host'] = $_ENV['SONGDOM_DB_HOST'];
            $config['dbname'] = $_ENV['SONGDOM_DB'];
            $config['user'] = $_ENV['SONGDOM_DB_USER'];
            $config['password'] = $_ENV['SONGDOM_DB_PASSWORD'];
            if (!empty($_ENV['driver'])) {
                $config['driver'] = $_ENV['driver'];
            }
        }
        return $config;
    }

    public function debugMode()
    {
        if (!empty($_GET['debug'])) {
            return true;
        }
    }

    public function getApp()
    {
        return $this->app;
    }
    
    public function run()
    {
        $this->getApp()->run();
    }

}