<?php

namespace App\Src;

/**
 * Class Session
 * @package App\Src
 */
class Session
{
    private $session;

    /**
     * Session constructor.
     * @param $session
     * @return void
     */
    public function __construct($session)
    {
        $this->session = $session;
    }

    /**
     * @param string $name
     * @param $value
     * @return void
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
     * @return void
     */
    public function remove(string $name)
    {
        unset($_SESSION[$name]);
    }

    /**
     * @return void
     */
    public function start()
    {
        session_start();
    }

    /**
     * @return void
     */
    public function stop()
    {
        session_destroy();
    }
}