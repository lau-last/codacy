<?php

namespace App\Manager;

use Core\QueryBuilder\Manager;
use Core\Session\Session;

final class Notification
{
    /**
     * @return string
     */
    public static function notificationInvalidComment(): string
    {
        return implode((new Manager())->fetch(
            (new \Core\QueryBuilder\Select('comment', ['COUNT(validation)']))
                ->where('validation = "invalid"')
        ));

    }

    /**
     * @return string
     */
    public static function notificationValidComment(): string
    {
        return implode((new Manager())->fetch(
            (new \Core\QueryBuilder\Select('comment', ['COUNT(validation)']))
                ->where('validation = "valid"')
        ));
    }


    /**
     * @return string
     */
    public static function notificationArticleManagement(): string
    {
        return implode(
            (new Manager())->fetch(
                (new \Core\QueryBuilder\Select('article', ['COUNT(*)']))
            )
        );
    }

    /**
     * @return string
     */
    public static function notificationUserManagement(): string
    {
        return implode(
            (new Manager())->fetch(
                (new \Core\QueryBuilder\Select('user', ['COUNT(*)']))
            )
        );
    }

    /**
     * @return string
     */
    public static function notificationConnection(): string
    {
        if ((new UserManager())->userIsConnected()) {
            return 'Connected';
        }
        return 'Offline';
    }

}
