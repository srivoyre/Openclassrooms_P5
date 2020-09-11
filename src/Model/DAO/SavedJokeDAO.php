<?php

namespace App\Src\Model\DAO;

use App\Src\Parameter;
use App\Src\Model\SavedJoke;

/**
 * Class SavedJokeDAO
 * @package App\Src\Model\DAO
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

    public function getSavedJoke(int $jokeApiId, int $userId)
    {
        $sql = 'SELECT id, user_id, joke_api_id, createdAt 
                FROM savedJoke 
                WHERE user_id = ?
                    AND joke_api_id = ?
                ORDER BY createdAt DESC';

        $result = $this->createQuery($sql, [
            $userId,
            $jokeApiId
        ]);
        $savedJoke = $result->fetch();
        $result->closeCursor();

        if($savedJoke) {
            return $this->buildObject($savedJoke);
        }

        return $savedJoke;
    }

    public function getSavedJokes(int $userId)
    {
        // We do not filter jokes saved by user. If the joke has been reported by another user,
        // users who saved it can still see it appear in their profiles.

        $sql = 'SELECT id, user_id, joke_api_id, createdAt 
                FROM savedJoke 
                WHERE user_id = ?
                ORDER BY createdAt DESC';
        $result = $this->createQuery($sql,[$userId]);
        $savedJokes = [];
        foreach ($result->fetchAll() as $row) {
            array_push($savedJokes, $this->buildObject($row));
        }
        $result->closeCursor();
        return $savedJokes;

    }

    public function addSavedJoke(int $jokeApiId, int $userId)
    {
        $sql = 'INSERT INTO savedJoke (joke_api_id, user_id, createdAt) 
                VALUES(?,?,NOW())';
        $this->createQuery($sql, [
            $jokeApiId,
            $userId
        ]);
    }

    public function deleteSavedJoke(int $savedJokeId, int $userId)
    {
        $sql = 'DELETE 
                FROM savedJoke 
                WHERE joke_api_id = ?
                AND user_id = ?';
        $this->createQuery($sql, [
            $savedJokeId,
            $userId
        ]);
    }

    public function deleteUserSavedJokes(int $userId)
    {
        $sql = 'DELETE 
                FROM savedJoke 
                WHERE user_id = ?';
        $this->createQuery($sql, [$userId]);
    }
}