<?php

namespace App\Src\Controller;

/**
 * Class ErrorController
 * @package App\Src\Controller
 */
class ErrorController extends Controller
{
    /**
     * @return View
     */
    public function errorNotFound()
    {
        return $this->view->render('error_404');
    }

    /**
     * @return View
     */
    public function errorServer()
    {
        return $this->view->render('error_500');
    }

    /**
     * @return View
     */
    public function errorPermission()
    {
        return $this->view->render('error_permission');
    }
}