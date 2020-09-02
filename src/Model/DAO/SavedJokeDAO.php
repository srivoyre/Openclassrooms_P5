<?php

namespace App\src\Model\DAO;

use App\src\Parameter;
use App\src\Model\SavedJoke;

/**
 * Class SavedJokeDAO
 * @package App\src\Model\DAO
 */
class SavedJokeDAO extends DAO
{
    /**
     * @param array $row
     * @return SavedJoke
     */
    public function buildObject(array $row)
    {
        $savedJoke = new SavedJoke();
        $savedJoke->setId($row['id']);
        $savedJoke->setUserId($row['user_id']);
        $savedJoke->setJokeApiId($row['joke_api_id']);
        $savedJoke->setCreatedAt($row['createdAt']);

        return $savedJoke;
    }

    public function getSavedJokes(string $userId)
    {
        // We do not filter jokes saved by user. If the joke has been reported by another user,
        // those who saved it can still see it appear in their profiles.

        $sql = 'SELECT id, user_id, joke_api_id, createdAt 
                FROM savedJoke 
                WHERE user_id = ?
                ORDER BY createdAt DESC';
        $result = $this->createQuery($sql,[$userId]);
        $savedJokes = [];

        foreach ($result as $row) {
            $savedJokeId = $row['id'];
            $savedJokes[$savedJokeId] = $this->buildObject($row);
        }

        $result->closeCursor();

        return $savedJokes;
    }

    public function addSavedJoke(string $jokeApiId, string $userId)
    {
        $sql = 'INSERT INTO savedJoke (joke_api_id, user_id, createdAt) 
                VALUES(?,?,NOW())';
        $this->createQuery($sql, [
            $jokeApiId,
            $userId
        ]);
    }
    public function deleteSavedJoke(string $savedJokeId)
    {
        $sql = 'DELETE 
                FROM savedJoke 
                WHERE id = ?';
        $this->createQuery($sql, [$savedJokeId]);
    }

    public function deleteUserSavedJokes(string $userId)
    {
        $sql = 'DELETE 
                FROM savedJoke 
                WHERE user_id = ?';
        $this->createQuery($sql, [$userId]);
    }
}