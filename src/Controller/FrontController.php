<?php

namespace App\src\Controller;

use App\src\Controller\JokesController;
use App\src\Parameter;

/**
 * Class FrontController
 * @package App\src\controller
 */
class FrontController extends Controller
{
    /**
     * @return View
     */
    public function home()
    {
        $jokesController = new JokesController();
        $filteredJokes = $jokesController->getFilteredJokesApiIdArray();
        return $this->view->render('home', [
            'filteredJokes' => $filteredJokes
        ]);
    }

    /**
     * @param Parameter $post
     * @return View
     */
    public function register(Parameter $post)
    {
        if ($post->get('submit')) {
            $errors = $this->validation->validate($post, 'User');
            if ($this->userDAO->checkUser($post, 'pseudo', 'pseudo', 'register')) {
                $errors['pseudo'] = $this->userDAO->checkUser($post, 'pseudo', 'pseudo','register');
            }

            if ($this->userDAO->checkUser($post, 'email', 'email', 'register')) {
                $errors['email'] = $this->userDAO->checkUser($post, 'email', 'email', 'register');
            }

            if (!$errors) {
                $this->userDAO->register($post);
                $this->login($post);
                $this->session->set(
                    'success_message',
                    'Welcome! You have successfully registered.'
                );
                header('Location: index.php?route=profile');
            }

            return $this->view->render('register', [
                'post' => $post,
                'errors' => $errors
            ]);
        }
        return $this->view->render('register');
    }

    /**
     * @param Parameter $post
     * @return View
     */
    public function login(Parameter $post)
    {
        if ($post->get('submit')) {

            // We give the user the possibility to login with either his pseudo or his email
            $validUsername = '';
            $checkPseudo = $this->userDAO->checkUser($post, 'pseudo', 'pseudo', 'login');
            $checkEmail = $this->userDAO->checkUser($post, 'pseudo', 'email', 'login');

            if ($checkPseudo) {
                $validUsername = 'pseudo';
            } elseif ($checkEmail) {
                $validUsername = 'email';
            }

            $checkPassword = $validUsername ? $this->userDAO->checkPassword($post, $validUsername): '';

            if ($checkPassword) {
                $this->session->set('loggedIn', true);
                $this->session->set('user', $checkPassword['user']);
                $this->session->set(
                    'info_message',
                    'Nice to see you again '.$this->session->get('user')->getPseudo(). ' !'
                );
                header('Location: index.php');
            } else {
                $this->session->set(
                    'error_message',
                    'Invalid username / password.'
                );
                return $this->view->render('login', [
                    'post' => $post
                ]);
            }
        }

        if ($this->session->get('loggedIn')) {
            header('Location: index.php');
        } else {
            return $this->view->render('login');
        }
        return $this->view->render('login');
    }
}