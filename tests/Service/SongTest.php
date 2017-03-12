<?php
/**
 * Created by PhpStorm.
 * User: daved_000
 * Date: 3/12/2017
 * Time: 6:22 PM
 */

namespace Songdom\tests\Service;


class SongTest extends \PHPUnit\Framework\TestCase
{

    protected static $service;

    public static function setupBeforeClass()
    {
        self::$service = new \Songdom\Service\Song();
    }

    public function testFetchAndScrapeLyrics()
    {
        $knownValidUrl = 'http://songmeanings.com/songs/view/9753/';
        $data = self::$service->fetchAndScrapeLyrics($knownValidUrl);
        $this->assertTrue(is_array($data));
        $this->assertEquals("Welcome to the jungle we've got fun and games", trim($data[0]));
    }
}