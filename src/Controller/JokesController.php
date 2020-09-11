<?php

namespace App\Src\Controller;

use App\Src\Parameter;

/**
 * Class JokesController
 * @package App\Src\Controller
 */
class JokesController extends BackController
{
    /**
     * @param Parameter $get
     * @return void
     */
    public function saveJoke(Parameter $get)
    {
        if ($this->checkLoggedIn()) {
            $jokeApiId = $get->get('jokeApiId');
            $userId = $this->session->get('user')->getId();

            if (!$this->isExistingSavedJoke((int)$jokeApiId, $userId)) {
                $this->savedJokeDAO->addSavedJoke((int)$jokeApiId, $userId);
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
            header('Location: index.php');
        }
    }

    /**
     * @param string $jokeApiId
     * @param string $userId
     * @return \App\Src\Model\SavedJoke|mixed
     */
    public function isExistingSavedJoke(string $jokeApiId, string $userId)
    {
        if ($this->checkLoggedIn()) {
            return $this->savedJokeDAO->getSavedJoke($jokeApiId, $userId);
        }
    }

    /**
     * @param Parameter $get
     * @return void
     */
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

    /**
     * @return array
     */
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

    /**
     * @param Parameter $get
     * @return void
     */
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

    /**
     * @param Parameter $get
     * @return void
     */
    public function unflagJoke(Parameter $get)
    {
        if ($this->checkAdmin()) {
            $this->flaggedJokeDAO->deleteFlaggedJoke((int)$get->get('jokeId'));
            $this->session->set(
                'success_message',
                'The joke has successfully been unflagged!'
            );
            header('Location: index.php?route=administration', false);
        }
    }

    /**
     * @param Parameter $get
     * @return void
     */
    public function filterJoke(Parameter $get)
    {
        if ($this->checkAdmin()) {
            $this->flaggedJokeDAO->filterJoke((int)$get->get('jokeId'));
            $this->session->set(
                'success_message',
                'The joke has successfully been filtered! From now on, it will not be displayed to your visitors.'
            );
            header('Location: index.php?route=administration', false);
        }
    }

    /**
     * @return array
     */
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