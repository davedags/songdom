<?php
/**
 * Created by PhpStorm.
 * User: daved_000
 * Date: 3/16/2017
 * Time: 11:29 PM
 */

namespace Songdom\Entities;

/**
 * @Entity
 * @Table(name="user")
 */
class User
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
    protected $username;
    /**
     * @Column(type="string")
     */
    protected $password;
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

    public function getUsername()
    {
        return $this->username;
    }

    public function setUsername($username)
    {
        $this->username = $username;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword($password)
    {
        $this->password = $password;
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
