<?php

namespace App\src\Controller;

use App\src\Model\DAO\FlaggedJokeDAO;
use App\src\Model\DAO\SavedJokeDAO;
use App\src\Model\DAO\UserDAO;
use App\src\Controller\View;
use App\src\Constraint\Validation;
use App\src\Model\FlaggedJoke;
use App\src\Request;

/**
 * Class Controller
 * @package App\src\controller
 */
abstract class Controller
{
    protected $userDAO;
    protected $savedJokeDAO;
    protected $flaggedJokeDAO;
    protected $view;
    protected $validation;
    private $request;
    protected $get;
    protected $post;
    protected $session;

    /**
     * Controller constructor.
     */
    public function __construct()
    {
        $this->userDAO = new UserDAO();
        $this->savedJokeDAO = new SavedJokeDAO();
        $this->flaggedJokeDAO = new FlaggedJokeDAO();
        $this->userDAO = new UserDAO();
        $this->view = new View();
        $this->validation = new Validation();
        $this->request = new Request();
        $this->get = $this->request->getGet();
        $this->post = $this->request->getPost();
        $this->session = $this->request->getSession();
    }

}