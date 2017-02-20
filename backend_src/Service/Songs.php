<?php
/**
 * Created by PhpStorm.
 * User: daved_000
 * Date: 2/20/2017
 * Time: 4:16 PM
 */

namespace Songdom\Service;

class Songs
{

    public function getLyricsByKeywords(array $args = []) {
        $data = [
            'url' => null,
            'lyrics' => []
        ];
        if (!empty($args['keywords'])) {
            $keywords = $args['keywords'];
            $searchurl = 'http://songmeanings.com/query/?query=' . urlencode($keywords);
            $resp = file_get_contents($searchurl);
            preg_match_all('|//songmeanings\.com/songs/view/(\d+)/|i', $resp, $matches);
            $matches = array_values(array_unique($matches[0]));
            if (is_array($matches) && !empty($matches[0])) {
                //Grab first match for now
                $url = trim($matches[0]);
                $lyrics = self::fetchAndScrapeLyrics($url);
                $data = [
                    'url' => $url,
                    'lyrics' => $lyrics
                ];
            }
        }
        return $data;
    }

    public static function fetchAndScrapeLyrics($url) {
        $lyrics = [];
        if ($source_html = file_get_contents(self::cleanURL($url))) {
            $start_text = '<div class="holder lyric-box">';
            $end_text = '<div style="min-height: 25px; margin:0; padding: 12px 0 0 0; border-top: 1px dotted #ddd;">';
            $start_pos = strpos($source_html, $start_text) + strlen($start_text);
            $end_pos = strpos($source_html, $end_text);

            $lyrics = trim(substr($source_html, $start_pos, ($end_pos - $start_pos)));
            $lyrics = str_replace(array('<br>', '<br />'), "", $lyrics);
            $lyrics = explode("\n", strip_tags($lyrics));
        }
        return $lyrics;
    }

    public static function cleanURL($url) {
        if (substr($url, 0, 2) == '//') {
            $url = 'http:' . $url;
        }
        return $url;
    }
}