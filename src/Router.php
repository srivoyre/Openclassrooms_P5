<?php

namespace App\src;

use App\src\Controller\FrontController;
use App\src\Controller\BackController;
use App\src\Controller\ErrorController;
use Exception;

/**
 * Class Router
 * @package App\src
 */
class Router
{
    private $request;
    private $frontController;
    private $backController;
    private $errorController;

    /**
     * Router constructor.
     */
    public function __construct()
    {
        $this->request = new Request();
        $this->frontController = new FrontController();
        $this->backController = new BackController();
        $this->errorController = new ErrorController();
    }

    public function run()
    {
        $route = $this->request->getGet()->get('route');

        try {
            if (isset($route)) {
                $this->route($route);
            } elseif ($this->request->getSession()->get('user')) {
                $this->backController->home();
            } else {
                $this->frontController->home();
            }
        } catch (Exception $ex) {
            //$this->errorController->errorServer();
            echo $ex->getMessage();
        }
    }

    /**
     * @param $route
     */
    public function route($route)
    {
        switch ($route) {
            case 'saveJoke' :
                $this->backController->saveJoke($this->request->getGet());
                break;
            case 'removeJoke' :
                $this->backController->removeSavedJoke($this->request->getGet());
                break;
            case 'flagJoke' :
                $this->frontController->flagJoke($this->request->getGet());
                break;
            case 'register':
                $this->frontController->register($this->request->getPost());
                break;
            case 'login':
                $this->frontController->login($this->request->getPost());
                break;
            case 'profile':
                $this->backController->profile();
                break;
            case 'updateEmail':
                $this->backController->updateEmail($this->request->getPost());
                break;
            case 'updatePassword':
                $this->backController->updatePassword($this->request->getPost());
                break;
            case 'logout':
                $this->backController->logout();
                break;
            case 'deleteAccount':
                $this->backController->deleteAccount();
                break;
            case 'deleteUser':
                $this->backController->deleteUser($this->request->getGet()->get('userId'));
                break;
            case 'administration':
                $this->backController->administration();
                break;
            case 'errorPermission':
                $this->errorController->errorPermission();
                break;
            default:
                $this->errorController->errorNotFound();
                break;
        }
    }
}