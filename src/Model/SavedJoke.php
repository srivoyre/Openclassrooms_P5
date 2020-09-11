<?php

namespace App\Src\Model;

/**
 * Class SavedJoke
 * @package App\Src\Model
 */
class SavedJoke
{
    private $id;
    private $userId;
    private $jokeApiId;
    private $createdAt;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * @param mixed $userId
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;
    }

    /**
     * @return mixed
     */
    public function getJokeApiId()
    {
        return $this->jokeApiId;
    }

    /**
     * @param mixed $jokeApiId
     */
    public function setJokeApiId($jokeApiId)
    {
        $this->jokeApiId = $jokeApiId;
    }

    /**
     * @return mixed
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param mixed $createdAt
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }

}