<?php

namespace App\Src;

/**
 * Class Request
 * @package App\Src
 */
class Request
{
    private $get;
    private $post;
    private $session;
    private $server;

    /**
     * Request constructor.
     */
    public function __construct()
    {
        $this->get = new Parameter(filter_input_array(INPUT_GET, FILTER_SANITIZE_FULL_SPECIAL_CHARS));
        $this->post = new Parameter(filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS));
        $this->session = new Session($_SESSION);
        $this->server = new Parameter(filter_input_array(INPUT_SERVER, FILTER_SANITIZE_FULL_SPECIAL_CHARS));
    }

    /**
     * @return Parameter
     */
    public function getGet()
    {
        return $this->get;
    }

    /**
     * @return Parameter
     */
    public function getPost()
    {
        return $this->post;
    }

    /**
     * @return Session
     */
    public function getSession()
    {
        return $this->session;
    }

    /**
     * @return Parameter
     */
    public function getServer()
    {
        return $this->server;
    }

}