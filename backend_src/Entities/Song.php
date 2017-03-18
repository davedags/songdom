<?php
/**
 * Created by PhpStorm.
 * User: daved_000
 * Date: 3/16/2017
 * Time: 11:40 PM
 */

namespace Songdom\Entities;

/**
 * @Entity
 * @Table(name="song")
 */
class Song
{
    /**
     * @Id
     * @Column(name="song_id", type="integer")
     * @GeneratedValue
     */
    protected $id;
    /**
     * @Column(type="string")
     */
    protected $url;
    /**
     * @Column(type="text")
     */
    protected $lyrics;
    /**
     * @Column(type="string")
     */
    protected $keywords;
    /**
     * @Column(type="datetime", nullable=true)
     */
    protected $created;
    /**
     * @Column(type="datetime", nullable=true)
     */
    protected $modified;

    public function __construct()
    {
        // we set up "created"+"modified"
        $this->setCreated(new \DateTime());
        if ($this->getModified() == null) {
            $this->setModified(new \DateTime());
        }
    }

    public function getId()
    {
        return $this->id;
    }

    public function getUrl()
    {
        return $this->url;
    }

    public function setUrl($url)
    {
        $this->url = $url;
    }

    public function getLyrics()
    {
        return $this->lyrics;
    }

    public function setLyrics($lyrics)
    {
        $this->lyrics = $lyrics;
    }
    
    public function getKeywords()
    {
        return $this->keywords;
    }

    public function setKeywords($keywords)
    {
        $this->keywords = $keywords;
    }

    public function getCreated()
    {
        return $this->created;
    }

    public function setCreated($created)
    {
        $this->created = $created;
    }

    public function getModified()
    {
        return $this->modified;
    }

    public function setModified($modified)
    {
        $this->modified = $modified;
    }

    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function updateModifiedDatetime()
    {
        // update the modified time
        $this->setModified(new \DateTime());
    }
}