<?php

namespace App\Src\Controller;

use App\Src\Controller\JokesController;
use App\Src\Parameter;

/**
 * Class FrontController
 * @package App\Src\controller
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
        if (!$post->get('submit')) {
            return $this->view->render('register');
        }
        $errors = $this->checkUserInfo($post);
        if (!$errors) {
            $this->userDAO->register($post);
            $this->login($post, true);
        } else {
            return $this->view->render('register', [
                'post' => $post,
                'errors' => $errors
            ]);
        }
    }

    public function manageLogin(Parameter $post)
    {
        if($post->get('submit')) {
            $this->login($post);
        } elseif ($this->session->get('loggedIn')) {
            header('Location: index.php?route=profile', false);
            //return $this->view->render('home');
        } else {
            return $this->view->render('login');
        }
    }
    /**
     * @param Parameter $post
     * @return View
     */
    public function login(Parameter $post, $registering = false)
    {
        $checkPassword = $this->checkUserPassword($post);
        if ($checkPassword) {
            $this->session->set('loggedIn', true);
            $this->session->set('user', $checkPassword['user']);
            $msg = $registering ? 'Welcome '.$this->session->get('user')->getPseudo().'!' : 'Nice to see you again '.$this->session->get('user')->getPseudo(). ' !' ;
            $this->session->set(
                'info_message',
                $msg
            );
            return;
            //header('Location: index.php?route=profile', false);
        } else {
            $this->session->set(
                'error_message',
                'Invalid username / password.'
            );
            return $this->view->render('login', [
                'post' => $post
            ]);
        };
    }

    private function checkUserInfo(Parameter $post)
    {
        $errors = $this->validation->validate($post, 'User');
        if ($this->userDAO->checkUser(
            $post,
            'pseudo',
            'pseudo',
            'register'))
        {
            $errors['pseudo'] = $this->userDAO->checkUser($post, 'pseudo', 'pseudo','register');
        }
        if ($this->userDAO->checkUser(
            $post,
            'email',
            'email',
            'register'))
        {
            $errors['email'] = $this->userDAO->checkUser($post, 'email', 'email', 'register');
        }
        return $errors;
    }

    private function checkUserPassword(Parameter $post)
    {
        // We give the user the possibility to login with either his pseudo or his email
        $validUsername = '';
        $checkPseudo = $this->userDAO->checkUser($post, 'pseudo', 'pseudo', 'login');
        $checkEmail = $this->userDAO->checkUser($post, 'pseudo', 'email', 'login');

        if ($checkPseudo) {
            $validUsername = 'pseudo';
        } elseif ($checkEmail) {
            $validUsername = 'email';
        }

        return $validUsername ? $this->userDAO->checkPassword($post, $validUsername): '';
    }
}