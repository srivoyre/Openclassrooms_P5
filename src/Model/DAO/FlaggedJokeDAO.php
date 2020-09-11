<?php

namespace App\Src\Model\DAO;

use App\Src\Parameter;
use App\Src\Model\FlaggedJoke;

/**
 * Class FlaggedJokeDAO
 * @package App\Src\Model\DAO
 */
class FlaggedJokeDAO extends DAO
{
    /**
     * @param array $row
     * @return FlaggedJoke
     */
    public function buildObject(array $row)
    {
        $flaggedJoke = new FlaggedJoke();
        $flaggedJoke->setId($row['id']);
        $flaggedJoke->setJokeApiId($row['joke_api_id']);
        $flaggedJoke->setFlagCount($row['flag_count']);
        $flaggedJoke->setFiltered($row['filtered']);
        $flaggedJoke->setCreatedAt($row['createdAt']);

        return $flaggedJoke;
    }

    /**
     * @param bool $filtered
     * @return array
     */
    public function getFlaggedJokes($filtered = false)
    {
        $sql = 'SELECT id, joke_api_id, flag_count, filtered, createdAt 
                FROM flaggedJoke 
                WHERE filtered = ?
                ORDER BY flag_count DESC, createdAt DESC';
        $result = $this->createQuery($sql,[$filtered]);
        $flaggedJokes = [];

        foreach ($result as $row) {
            $flaggedJokeId = $row['id'];
            $flaggedJokes[$flaggedJokeId] = $this->buildObject($row);
        }

        $result->closeCursor();

        return $flaggedJokes;
    }

    /**
     * @param int $jokeApiId
     * @return mixed
     */
    public function isFlaggedJoke(int $jokeApiId)
    {
        $sql = 'SELECT id, joke_api_id, flag_count, filtered, createdAt
                FROM flaggedJoke 
                WHERE joke_api_id = ?';
        $result = $this->createQuery($sql, [$jokeApiId]);
        $flaggedJoke = $result->fetch();
        $result->closeCursor();

        return $flaggedJoke;
    }

    /**
     * @param int $jokeApiId
     * @return void
     */
    public function addFlaggedJoke(int $jokeApiId)
    {
        $sql = 'INSERT INTO flaggedJoke (joke_api_id, flag_count, filtered, createdAt) 
                VALUES(?,?,?,NOW())';
        $this->createQuery($sql, [
            $jokeApiId,
            1,
            0
        ]);
    }

    /**
     * @param int $jokeApiId
     * @return void
     */
    public function flagExistingJoke(int $jokeApiId)
    {
        $sql = 'UPDATE flaggedJoke 
                SET flag_count = flag_count + 1 
                WHERE joke_api_id = :jokeApiId';
        $this->createQuery($sql, [
            'jokeApiId' => $jokeApiId
        ]);
    }

    /**
     * @param int $jokeId
     * @return void
     */
    public function filterJoke(int $jokeId)
    {
        $sql = 'UPDATE flaggedJoke 
                SET filtered = :bool 
                WHERE id = :jokeId';
        $this->createQuery($sql, [
            'bool' => 1,
            'jokeId' => $jokeId
        ]);
    }

    /**
     * @param int $flaggedJokeId
     * @return void
     */
    public function deleteFlaggedJoke(int $flaggedJokeId)
    {
        $sql = 'DELETE 
                FROM flaggedJoke 
                WHERE id = ?';
        $this->createQuery($sql, [$flaggedJokeId]);
    }
}