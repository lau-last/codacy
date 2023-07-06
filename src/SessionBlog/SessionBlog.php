<?php

namespace App\SessionBlog;

use App\Manager\UserManager;
use Core\Session\Session;

final class SessionBlog extends Session
{
    /**
     * @param UserManager|null $userInfo
     * @return void
     */
    public static function init(?UserManager $userInfo = null)
    {
        if ((!empty($userInfo))) {
            self::set('id', $userInfo->getId());
            self::set('name', $userInfo->getName());
            self::set('email', $userInfo->getEmail());
            self::set('role', $userInfo->getRole());
        }
    }
}
