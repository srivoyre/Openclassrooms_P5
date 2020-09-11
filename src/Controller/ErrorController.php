<?php

namespace App\Src\Controller;

/**
 * Class ErrorController
 * @package App\Src\Controller
 */
class ErrorController extends Controller
{
    /**
     * @return void
     */
    public function errorNotFound()
    {
        return $this->view->render('error_404');
    }

    /**
     * @return void
     */
    public function errorServer()
    {
        return $this->view->render('error_500');
    }

    /**
     * @return void
     */
    public function errorPermission()
    {
        return $this->view->render('error_permission');
    }
}