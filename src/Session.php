<?php

namespace App\src;

/**
 * Class Session
 * @package App\src
 */
class Session
{
    private $session;

    /**
     * Session constructor.
     * @param $session
     */
    public function __construct($session)
    {
        $this->session = $session;
    }

    /**
     * @param string $name
     * @param $value
     */
    public function set(string $name, $value)
    {
        $_SESSION[$name] = $value;
    }

    /**
     * @param string $name
     * @return mixed
     */
    public function get(string $name)
    {
        if(isset($_SESSION[$name]))
        {
            return $_SESSION[$name];
        }
    }

    /**
     * @param string $name
     * @return mixed
     */
    public function show(string $name)
    {
        if (isset($_SESSION[$name])) {
            $key = $this->get($name);
            $this->remove($name);
            return $key;
        }
    }

    /**
     * @param string $name
     */
    public function remove(string $name)
    {
        unset($_SESSION[$name]);
    }

    public function start()
    {
        session_start();
    }

    public function stop()
    {
        session_destroy();
    }
}