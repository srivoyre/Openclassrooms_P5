<?php

namespace App\src\Model\DAO;

use App\src\Parameter;
use App\src\Model\FlaggedJoke;

/**
 * Class FlaggedJokeDAO
 * @package App\src\Model\DAO
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

    public function flagExistingJoke(int $jokeApiId)
    {
        $sql = 'UPDATE flaggedJoke 
                SET flag_count = flag_count + 1 
                WHERE joke_api_id = :jokeApiId';
        $this->createQuery($sql, [
            'jokeApiId' => $jokeApiId
        ]);
    }

    public function filterJoke(string $jokeId)
    {
        $sql = 'UPDATE flaggedJoke 
                SET filtered = :bool 
                WHERE id = :jokeId';
        $this->createQuery($sql, [
            'bool' => 1,
            'jokeId' => $jokeId
        ]);
    }

    public function deleteFlaggedJoke(int $flaggedJokeId)
    {
        $sql = 'DELETE 
                FROM flaggedJoke 
                WHERE id = ?';
        $this->createQuery($sql, [$flaggedJokeId]);
    }
}