<?php
/**
 * Created by PhpStorm.
 * User: daved_000
 * Date: 2/20/2017
 * Time: 4:15 PM
 */

namespace Songdom\Controller;

class Song
{
    protected $container;
    protected $service;

    public function __construct($container) 
    {
        $this->container = $container;
        $this->service = new \Songdom\Service\Songs([
            'db' => $this->container['db']
            ]
        );
    }
    
    public function getLyrics($request, $response, $args)
    {
        
        $searchTerm = $request->getQueryParams()['q'];

        $songData = $this->service->getLyricsByKeywords([
            'keywords' => $searchTerm
        ]);

        return $response->withJson($songData);
    }


}