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

    public function getLyrics($request, $response, $args)
    {
        $searchTerm = $request->getQueryParams()['q'];

        $songData = \Songdom\Service\Songs::getLyricsByKeywords(['keywords' => $searchTerm]);

        return $response->withJson($songData);
    }


