<?php

namespace Songdom;

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

class App
{

    private $app;

    public function __construct() 
    {
        $config = [];

        if (file_exists(__DIR__ . '/config/.env')) {
            $dotenv = new \Dotenv\Dotenv(__DIR__ . '/config');
            $dotenv->load();
            
            $config['db']['host'] = $_ENV['SONGDOM_DB_HOST'];
            $config['db']['dbname'] = $_ENV['SONGDOM_DB'];
            $config['db']['user'] = $_ENV['SONGDOM_DB_USER'];
            $config['db']['pass'] = $_ENV['SONGDOM_DB_PASSWORD'];
        } 
        
        $app = new \Slim\App([
            'settings' => $config
        ]);
        
        $container = $app->getContainer();
        
        if (!empty($config['db'])) {
            $container['db'] = function ($c) {
                $db = $c['settings']['db'];
                $pdo = new \PDO("mysql:host=" . $db['host'] . ";dbname=" . $db['dbname'], $db['user'], $db['pass']);
                $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
                $pdo->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_ASSOC);
                return $pdo;
            };
        } else {
            $container['db'] = null;
        }
                
        $app->options('/{routes:.+}', function ($request, $response, $args) {
            return $response;
        });
        
        $app->add(function ($req, $res, $next) {
            $response = $next($req, $res);
            return $response
                ->withHeader('Access-Control-Allow-Origin', '*')
                ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
                ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
        });
        
        $app->get('/search', 'Songdom\Controller\Song:getLyrics');
        
        
        $this->app = $app;
    }

    public function getApp() {
        return $this->app;
    }
    
    public function run() {
        $this->getApp()->run();
    }

}