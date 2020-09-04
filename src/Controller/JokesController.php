<?php

namespace App\src\Controller;

use App\src\Parameter;
/**
 * Class JokesController
 * @package App\src\Controller
 */
class JokesController extends BackController
{

    public function saveJoke(Parameter $get)
    {
        if ($this->checkLoggedIn()) {
            $jokeApiId = $get->get('jokeApiId');
            $userId = $this->session->get('user')->getId();
            if(!$this->isExistingSavedJoke($jokeApiId, $userId)) {
                $this->savedJokeDAO->addSavedJoke($jokeApiId, $userId);
                $this->session->set(
                    'success_message',
                    'This joke has been saved! You can find it in your profile page.'
                );
            } else {
                $this->session->set(
                    'info_message',
                    'You already saved this joke!'
                );
            }
            header('Location: index.php');
        }
    }

    public function isExistingSavedJoke(string $jokeApiId, string $userId)
    {
        if ($this->checkLoggedIn()) {
            return $this->savedJokeDAO->getSavedJoke($jokeApiId, $userId);
        }
    }

    public function removeSavedJoke(Parameter $get)
    {
        if ($this->checkLoggedIn()) {
            $this->savedJokeDAO->deleteSavedJoke($get->get('jokeApiId'), $this->session->get('user')->getId());
            $this->session->set(
                'success_message',
                'The joke has successfully been removed from your favourites!'
            );
            header('Location: index.php?route=profile');
        }
    }

    public function getUserSavedJokesApiIdArray()
    {
        if ($this->checkLoggedIn()) {
            $savedJokes = $this->savedJokeDAO->getSavedJokes($this->session->get('user')->getId());
            $savedJokesArray = [];
            foreach ($savedJokes as $savedJoke) {
                array_push($savedJokesArray, $savedJoke->getJokeApiId());
            }
            return $savedJokesArray;
        }
    }

    public function unflagJoke(Parameter $get)
    {
        if ($this->checkAdmin()) {
            $this->flaggedJokeDAO->deleteFlaggedJoke($get->get('jokeId'));
            $this->session->set(
                'success_message',
                'The joke has successfully been unflagged!'
            );
            header('Location: index.php?route=administration');
        }
    }

    public function filterJoke(Parameter $get)
    {
        if ($this->checkAdmin()) {
            $this->flaggedJokeDAO->filterJoke($get->get('jokeId'));
            $this->session->set(
                'success_message',
                'The joke has successfully been filtered! From now on, it will never be displayed to your visitors.'
            );
            header('Location: index.php?route=administration');
        }
    }
}