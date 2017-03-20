<?php
/**
 * Created by PhpStorm.
 * User: daved_000
 * Date: 2/20/2017
 * Time: 4:16 PM
 */

namespace Songdom\Service;

class Song
{

    protected $em = null;
    public function __construct(array $args = []) 
    {
        if (!empty($args['em'])) {
            $this->em = $args['em'];
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
                $search_url = 'http://songmeanings.com/query/?query=' . urlencode($keywords);
                $resp = file_get_contents($search_url);
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
                'lyrics' => serialize($lyrics)
            ];
            if (!empty($args['keywords'])) {
                $song_data['keywords'] = $args['keywords'];
            }
            $this->saveSong($song_data);
        }
        return $lyrics;
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
        if (!$this->usingDB()) {
            return false;
        }

        $query = $this->em->createQuery('SELECT s FROM \Songdom\Entities\Song s WHERE s.' . $field . ' = :value');
        $query->setParameter('value', $match);

        try {
            $song = $query->getSingleResult();
        } catch (\Doctrine\ORM\NoResultException $e) {
            return false;
        }

        return [
            'song_id' => $song->getId(),
            'url' => $song->getUrl(),
            'lyrics' => unserialize($song->getLyrics())
        ];
    }

    public function saveSong($song_data)
    {
        if (!$this->usingDB()) {
            return false;
        }

        $song = new \Songdom\Entities\Song();
        $song->setUrl($song_data['url']);
        $song->setLyrics($song_data['lyrics']);
        if (!empty($song_data['keywords'])) {
            $song->setKeywords($song_data['keywords']);
        }
        $this->em->persist($song);
        $this->em->flush();

        return true;
    }

    public function usingDB() {
        if (is_object($this->em)) {
            return true;
        } else{
            return false;
        }
    }
    
    public static function cleanURL($url) 
    {
        if (substr($url, 0, 2) == '//') {
            $url = 'http:' . $url;
        }
        return $url;
    }
}