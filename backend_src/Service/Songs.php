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

    protected $db = null;
    public function __construct(array $args = []) 
    {
        if (!empty($args['db'])) {
            $this->db = $args['db'];
        }
    }

    public function getLyricsByKeywords(array $args = []) 
    {
        $data = [
            'url' => null,
            'lyrics' => []
        ];
        if (!empty($args['keywords'])) {
            $keywords = $args['keywords'];
            $song = $this->getSongByKeywords($keywords);
            if ($song) {
                $data = [
                    'url' => $song['url'],
                    'lyrics' => $song['lyrics']
                ];
            } else {
                
                $searchurl = 'http://songmeanings.com/query/?query=' . urlencode($keywords);
                $resp = file_get_contents($searchurl);
                preg_match_all('|//songmeanings\.com/songs/view/(\d+)/|i', $resp, $matches);
                $matches = array_values(array_unique($matches[0]));
                if (is_array($matches) && !empty($matches[0])) {
                    $url = trim($matches[0]);
                    $song = $this->getSongByURL($url);
                    if ($song) {
                        $data = [
                            'url' => $song['url'],
                            'lyrics' => $song['lyrics']
                        ];
                    } else {
                        $lyrics = $this->fetchAndScrapeLyrics($url, ['keywords' => $keywords]);
                        $data = [
                            'url' => $url,
                            'lyrics' => $lyrics
                        ];
                    }
                }
            }
        }
        return $data;
    }

    public function fetchAndScrapeLyrics($url, $args = []) 
    {
        $lyrics = [];
        if ($source_html = file_get_contents(self::cleanURL($url))) {
            $start_text = '<div class="holder lyric-box">';
            $end_text = '<div style="min-height: 25px; margin:0; padding: 12px 0 0 0; border-top: 1px dotted #ddd;">';
            $start_pos = strpos($source_html, $start_text) + strlen($start_text);
            $end_pos = strpos($source_html, $end_text);

            $lyrics = trim(substr($source_html, $start_pos, ($end_pos - $start_pos)));
            $lyrics = str_replace(array('<br>', '<br />'), "", $lyrics);
            $lyrics = explode("\n", strip_tags($lyrics));
            
            $song_data = [
                'url' => $url,
                'lyrics' => serialize($lyrics),
                'created' => date('Y-m-d H:i:s')
            ];
            if (!empty($args['keywords'])) {
                $song_data['keywords'] = $keywords;
            }
            $this->saveSong($song_data);
        }
        return $lyrics;
    }
    
    public function getSongByTitle($title) 
    {
        return $this->getSong('title', $title);
    }
    
    public function getSongByKeywords($keywords) 
    {
        return $this->getSong('keywords', $keywords);
    }
    
    public function getSongByURL($url) 
    {
        return $this->getSong('url', $url);
    }
    
    /**
     * get song from local db by a field match
     * 
     **/
    public function getSong($field, $match) 
    {
        $sql = "select song_id, title, lyrics, url from song where $field = " . $this->db->quote($match);
        try {
            $stmt = $this->db->query($sql);
        } catch (Exception $e) {
            error_log($e->getMessage());
            return false;
        }
        $row = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        $song_data = false;
               
        if (is_array($row) && isset($row[0]) && is_array($row[0]) && ($lyrics = $row[0]['lyrics'])) {
            $song_data = [
                'song_id' => $row[0]['song_id'],
                'url' => $row[0]['url'],
                'lyrics' => unserialize($row[0]['lyrics'])
            ];
        } 
        return $song_data;
    }

    public function saveSong($song) 
    {
        $prepare_sql = "insert into song (" . implode(", ", array_keys($song)) . ") values (" . implode(", ", array_map(function($x) { return ":" . $x; }, array_keys($song))) . ")";
        
        $stmt = $this->db->prepare($prepare_sql);
        try {
            $stmt->execute($song);
        } catch (Exception $e) {
            error_log($e->getMessage());
            return false;
        }
        return true;
    }

    public static function cleanURL($url) 
    {
        if (substr($url, 0, 2) == '//') {
            $url = 'http:' . $url;
        }
        return $url;
    }
}