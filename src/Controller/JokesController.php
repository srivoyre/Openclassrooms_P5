<?php

namespace App\Src\Controller;

use App\Src\Parameter;

/**
 * Class JokesController
 * @package App\Src\Controller
 */
class JokesController extends BackController
{
    public function saveJoke(Parameter $get)
    {
        if (!$this->checkLoggedIn()) {
            $frontController = new FrontController();
            $frontController->manageLogin($this->post);
        }
        $jokeApiId = $get->get('jokeApiId');
        $userId = $this->session->get('user')->getId();
        if (!$this->isExistingSavedJoke((string)$jokeApiId, $userId)) {
            $this->savedJokeDAO->addSavedJoke((string)$jokeApiId, $userId);
            $this->session->set(
                'success_message',
                'This joke has been saved! You can find it in your profile page.'
            );
        }
        else {
            $this->session->set(
                'info_message',
                'You already saved this joke!'
            );
        }
        header('Location: index.php', false);
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
            header('Location: '.$this->server->get('HTTP_REFERER'), false);
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

    public function flagJoke(Parameter $get)
    {
        $jokeApiId = (int)$get->get('jokeApiId');
        if($this->flaggedJokeDAO->isFlaggedJoke($jokeApiId)) {
            $this->flaggedJokeDAO->flagExistingJoke($jokeApiId);
        } else {
            $this->flaggedJokeDAO->addFlaggedJoke($jokeApiId);
        }
        $this->session->set(
            'success_message',
            'This joke has been reported! It will be reviewed by our team shortly.'
        );
        header('Location: '.$this->server->get('HTTP_REFERER'), false);
    }

    public function unflagJoke(Parameter $get)
    {
        if ($this->checkAdmin()) {
            $this->flaggedJokeDAO->deleteFlaggedJoke($get->get('jokeId'));
            $this->session->set(
                'success_message',
                'The joke has successfully been unflagged!'
            );
            header('Location: index.php?route=administration', false);
        }
    }

    public function filterJoke(Parameter $get)
    {
        if ($this->checkAdmin()) {
            $this->flaggedJokeDAO->filterJoke($get->get('jokeId'));
            $this->session->set(
                'success_message',
                'The joke has successfully been filtered! From now on, it will not be displayed to your visitors.'
            );
            header('Location: index.php?route=administration', false);
        }
    }

    public function getFilteredJokesApiIdArray()
    {
        $filteredJokes = $this->flaggedJokeDAO->getFlaggedJokes(true);
        $filteredJokesApiIdArray = [];
        foreach ($filteredJokes as $joke) {
            array_push($filteredJokesApiIdArray, $joke->getJokeApiId());
        }
        return $filteredJokesApiIdArray;
    }
}