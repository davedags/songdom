<?php
/**
 * Created by PhpStorm.
 * User: daved_000
 * Date: 3/26/2017
 * Time: 9:58 PM
 */

namespace Songdom\Service;


class User
{
    protected $em = null;
    public function __construct(array $args = [])
    {
        if (!empty($args['em'])) {
            $this->em = $args['em'];
        }
    }
    
    public function create()
    {
        //Fake User Object - TODO, implement creation
        $user = [
            'id' => 3,
            'username'=> 'dags'
        ];
        
        return $user;
    }
}