<?php

namespace App\src\Model;

/**
 * Class FlaggedJoke
 * @package App\src\Model
 */
class FlaggedJoke
{
    private $id;
    private $jokeApiId;
    private $flagCount;
    private $filtered;
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
    public function getFlagCount()
    {
        return $this->flagCount;
    }

    /**
     * @param mixed $flagCount
     */
    public function setFlagCount($flagCount)
    {
        $this->flagCount = $flagCount;
    }
    
    /**
     * @return mixed
     */
    public function getFiltered()
    {
        return $this->filtered;
    }

    /**
     * @param mixed $filtered
     */
    public function setFiltered($filtered)
    {
        $this->filtered = $filtered;
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