<?php
/**
 * Created by PhpStorm.
 * User: daved_000
 * Date: 3/26/2017
 * Time: 9:56 PM
 */

namespace Songdom\Controller;

class User
{

    protected $container;
    protected $service;

    public function __construct($container)
    {
        $this->container = $container;
        $this->service = new \Songdom\Service\User([
                'em' => $this->container['em']
            ]
        );
    }
    
    public function create($request, $response, $args)
    {
        $payload = $request->getParsedBody();
        $userData = [
                'username' => $payload['username'],
                'password' => $payload['password']
            ];

        $user = $this->service->create($userData);
        return $response->withJson($user);
    }
}