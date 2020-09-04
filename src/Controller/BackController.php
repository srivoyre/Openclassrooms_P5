<?php

namespace App\src\Controller;

use App\src\Parameter;
use http\Client\Curl\User;

/**
 * Class BackController
 * @package App\src\controller
 */
class BackController extends Controller
{
    /**
     * @return bool
     */
    private function checkLoggedIn()
    {
        if (!$this->session->get('user')) {
            $this->session->set(
                'warning_message',
                'Vous devez vous connecter pour accéder à cette page'
            );
            header('Location: index.php?route=login');
        } else {
            return true;
        }
    }

    /**
     * @return bool
     */
    private function checkAdmin()
    {
        $this->checkLoggedIn();
        if (!($this->session->get('user')->getIsAdmin())) {
            $this->session->set(
                'warning_message',
                'Vous ne disposez pas des autorisations suffisantes pour accéder à cette page'
            );
            header('Location: index.php?route=errorPermission');
        } else {
            return true;
        }
    }

    public function home()
    {
        if ($this->checkLoggedIn()) {
            $savedJokesArray = $this->getUserSavedJokesApiIdArray();
            return $this->view->render('home', [
                'savedJokesArray' => $savedJokesArray
            ]);
        }
    }

    public function administration()
    {
        if ($this->checkAdmin()) {
            $flaggedJokes = $this->flaggedJokeDAO->getFlaggedJokes(false);
            $users = $this->userDAO->getUsers();

            return $this->view->render('administration', [
                'flaggedJokes' => $flaggedJokes,
                'users' => $users
            ]);
        }
    }

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
    /**
     * @return View
     */
    public function profile()
    {
        if ($this->checkLoggedIn()) {
            $user = $this->userDAO->getUser($this->session->get('user')->getPseudo());
            $savedJokesArray = $this->getUserSavedJokesApiIdArray();
            return $this->view->render('profile', [
                'user' => $user,
                'savedJokesArray' => $savedJokesArray
            ]);
        }
    }

    /**
     * @param Parameter $post
     * @return View
     */
    public function updatePassword(Parameter $post)
    {
        if ($this->checkLoggedIn()) {
            if ($post->get('submit')) {
                $post->set('pseudo', $this->session->get('user')->getPseudo());
                $checkCurrentPassword = $this->userDAO->checkPassword($post, 'pseudo');
                if ($checkCurrentPassword) {
                    $errors = $this->validation->validate($post, 'User');
                    if (!$errors) {
                        $this->userDAO->updatePassword($post, $this->session->get('user')->getPseudo());
                        $this->session->set(
                            'success_message',
                            'Votre mot de passe a été mis à jour'
                        );
                    }
                    return $this->view->render('update_password', [
                        'errors' => $errors
                    ]);
                }
                $this->session->set(
                    'error_message',
                    'Le mot de passe actuel est incorrect'
                );
            }
            return $this->view->render('update_password');
        }
    }

    /**
     * @param Parameter $post
     * @return View
     */
    public function updateEmail(Parameter $post)
    {
        if ($this->checkLoggedIn()) {
            if ($post->get('submitEmail')) {
                $errors = $this->validation->validate($post, 'User');
                if (!$errors) {
                    $this->userDAO->updateEmail($post, $this->session->get('user')->getPseudo());
                    $this->session->set(
                        'success_message',
                        'Votre adresse e-mail a été mise à jour'
                    );
                    header('Location: index.php?route=profile');
                }
                return $this->view->render('profile', [
                    'user' => $this->session->get('user'),
                    'errors' => $errors
                ]);
            }
        }
    }

    public function logout()
    {
        if ($this->checkLoggedIn()) {
            $this->logoutOrDelete('logout');
        }
    }

    public function deleteAccount()
    {
        if ($this->checkLoggedIn()) {
            $this->userDAO->deleteUser($this->session->get('user')->getId());
            $this->logoutOrDelete('delete_account');
        }
    }

    /**
     * @param string $userId
     */
    public function deleteUser(string $userId)
    {
        if ($this->checkAdmin()) {
            $this->commentDAO->deleteUserComments($userId);
            $this->userDAO->deleteUser($userId);
            $this->session->set(
                'success_message',
                'L\'utilisateur a bien été supprimé'
            );
            header('Location: index.php?route=administration');
        }
    }

    /**
     * @param string $param
     */
    private function logoutOrDelete(string $param)
    {
        $this->session->stop();
        $this->session->start();
        if ($param === 'logout') {
            $this->session->set('info_message', 'À bientôt');
        } else {
            $this->session->set(
                'success_message',
                'Votre compte a bien été supprimé'
            );
        }
        header('Location: index.php');
    }
}