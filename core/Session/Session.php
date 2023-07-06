<?php

namespace Core\Session;


abstract class Session
{

    /**
     * @return void
     */
    public static function start()
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            \session_start();
        }
    }

    /**
     * @param $key
     * @return string|null
     */
    public static function get($key) : ?string
    {
        if (isset($_SESSION[$key])) {
            return $_SESSION[$key];
        }
        return null;
    }

    /**
     * @param $key
     * @param $value
     * @return void
     */
    public static function set($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    /**
     * @param $key
     * @return void
     */
    public static function delete($key)
    {
        unset($_SESSION[$key]);
    }

    /**
     * @return void
     */
    public static function destroy()
    {
        if (session_status() === PHP_SESSION_ACTIVE) {
            \session_destroy();
        }
    }

}