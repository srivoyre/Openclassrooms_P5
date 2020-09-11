<?php

namespace App\Src\Controller;

use App\Src\Model\DAO\FlaggedJokeDAO;
use App\Src\Model\DAO\SavedJokeDAO;
use App\Src\Model\DAO\UserDAO;
use App\Src\Controller\View;
use App\Src\Constraint\Validation;
use App\Src\Request;

/**
 * Class Controller
 * @package App\Src\controller
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
    protected $server;

    /**
     * Controller constructor.
     */
    public function __construct()
    {
        $this->userDAO = new UserDAO();
        $this->savedJokeDAO = new SavedJokeDAO();
        $this->flaggedJokeDAO = new FlaggedJokeDAO();
        $this->view = new View();
        $this->validation = new Validation();
        $this->request = new Request();
        $this->get = $this->request->getGet();
        $this->post = $this->request->getPost();
        $this->session = $this->request->getSession();
        $this->server = $this->request->getServer();
    }

}