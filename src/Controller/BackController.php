<?php

namespace App\Src\Controller;

use App\Src\Parameter;
use App\Src\Router;
use http\Client\Curl\User;

/**
 * Class BackController
 * @package App\Src\Controller
 */
class BackController extends Controller
{
    /**
     * @return bool
     */
    protected function checkLoggedIn()
    {
        if (!$this->session->get('user')) {
            $this->session->set(
                'warning_message',
                'You need to be logged in to perform this action!'
            );
            return $this->view->render('login');
        } else {
            return true;
        }
    }

    /**
     * @return bool
     */
    protected function checkAdmin()
    {
        $this->checkLoggedIn();
        if (!($this->session->get('user')->getIsAdmin())) {
            $this->session->set(
                'warning_message',
                'You do not have sufficient permission to access this page.'
            );
            header('Location: index.php?route=errorPermission');
            return false;
        } else {
            return true;
        }
    }

    /**
     * @return void
     */
    public function home()
    {
        if ($this->checkLoggedIn()) {
            $jokesController = new JokesController();
            $savedJokesArray = $jokesController->getUserSavedJokesApiIdArray();
            $filteredJokes = $jokesController->getFilteredJokesApiIdArray();
            return $this->view->render('home', [
                'savedJokesArray' => $savedJokesArray,
                'filteredJokes' => $filteredJokes
            ]);
        }
    }

    /**
     * @return void
     */
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

    /**
     * @return void
     */
    public function profile()
    {
        if ($this->checkLoggedIn()) {
            $user = $this->userDAO->getUser($this->session->get('user')->getPseudo());
            $jokesController = new JokesController();
            $savedJokesArray = $jokesController->getUserSavedJokesApiIdArray();
            return $this->view->render('profile', [
                'user' => $user,
                'savedJokesArray' => $savedJokesArray
            ]);
        }
    }

    /**
     * @param Parameter $post
     * @return void
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
                            'Your password has been successfully updated!'
                        );
                    }
                    return $this->view->render('update_password', [
                        'errors' => $errors
                    ]);
                }
                $this->session->set(
                    'error_message',
                    'Incorrect current password.'
                );
            }
            return $this->view->render('update_password');
        }
    }

    /**
     * @param Parameter $post
     * @return void
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
                        'Your email address has been successfully updated!'
                    );
                    header('Location: index.php?route=profile', false);
                } else {
                    return $this->view->render('profile', [
                        'user' => $this->session->get('user'),
                        'post' => $post,
                        'errors' => $errors,
                        'showUserInfo' => true
                    ]);
                }
            }
        }
    }

    /**
     * @return void
     */
    public function logout()
    {
        if ($this->checkLoggedIn()) {
            $this->logoutOrDelete('logout');
        }
    }

    /**
     * @return void
     */
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
            $this->savedJokeDAO->deleteUserSavedJokes($userId);
            $this->userDAO->deleteUser($userId);
            $this->session->set(
                'success_message',
                'The user has been successfully deleted!'
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
            $this->session->set(
                'info_message',
                'See you soon!'
            );
        } else {
            $this->session->set(
                'success_message',
                'Your account has been successfully deleted!'
            );
        }
        header('Location: index.php');
    }
}