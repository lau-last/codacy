<?php

namespace Core\Session;

abstract class Session
{


    /**
     * @return void
     */
    public static function start(): void
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            \session_start();
        }

    }


    /**
     * @param string $key
     * @return string|null
     */
    public static function get(string $key) : ?string
    {
        if (isset($_SESSION[$key]) === true) {
            return $_SESSION[$key];
        }

        return null;

    }


    /**
     * @param $key
     * @param $value
     * @return void
     */
    public static function set($key, $value): void
    {
        $_SESSION[$key] = $value;

    }


    /**
     * @param $key
     * @return void
     */
    public static function delete($key): void
    {
        unset($_SESSION[$key]);

    }


    /**
     * @return void
     */
    public static function destroy(): void
    {
        if (session_status() === PHP_SESSION_ACTIVE) {
            \session_destroy();
        }

    }


}
