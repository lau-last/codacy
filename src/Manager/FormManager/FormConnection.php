<?php

namespace App\Manager\FormManager;

use App\Manager\UserManager;
use App\SessionBlog\SessionBlog;

final class FormConnection
{
    /**
     * @param array $input
     * @return bool
     */
    public function registerSession(array $input): bool
    {
        if (isset($input['email']) && isset($input['password'])) {

            $email = trim($input['email']);
            $password = trim($input['password']);
            $userInfo = (new UserManager())->getUserInfo($email);
            if ($userInfo === null || $userInfo->getValidation() !== 'valid') {
                return false;
            }

            if (password_verify($password, $userInfo->getPassword())) {
                if (password_needs_rehash($userInfo->getPassword(), PASSWORD_BCRYPT)) {
                    $password = password_hash($password, PASSWORD_BCRYPT);
                    $userInfo->setPassword($password);
                }
                SessionBlog::init($userInfo);
                return true;
            }
        }
        return false;
    }
}
