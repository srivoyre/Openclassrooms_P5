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
        $sql = 'SELECT id, joke_api_id, flag_count, createdAt 
                FROM flagged-joke 
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
                FROM flagged-joke 
                WHERE joke_api_id = ?';
        $result = $this->createQuery($sql, [$jokeApiId]);
        $flaggedJoke = $result->fetch();
        $result->closeCursor();

        return $this->buildObject($flaggedJoke);
    }
    
    public function addFlaggedJoke(int $jokeApiId)
    {
        $sql = 'INSERT INTO flagged-joke (joke_api_id, flaged_count, filtered, createdAt) 
                VALUES(?,?,?,NOW())';
        $this->createQuery($sql, [
            $jokeApiId,
            0,
            0
        ]);
    }

    public function flagExistingJoke(int $jokeApiId)
    {
        $sql = 'UPDATE flagged-joke 
                SET flag_count = flag_count + 1 
                WHERE joke_api_id = :jokeApiId';
        $this->createQuery($sql, [
            'jokeApiId' => $jokeApiId
        ]);
    }

    public function deleteFlaggedJoke(int $flaggedJokeId)
    {
        $sql = 'DELETE 
                FROM flagged-joke 
                WHERE id = ?';
        $this->createQuery($sql, [$flaggedJokeId]);
    }
}