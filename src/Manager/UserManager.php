<?php

namespace App\Manager;

use App\Entity\UserEntity;
use App\SessionBlog\SessionBlog;
use Core\QueryBuilder\Delete;
use Core\QueryBuilder\Insert;
use Core\QueryBuilder\Manager;
use Core\QueryBuilder\Select;
use Core\QueryBuilder\Update;
use Exception;

final class UserManager extends UserEntity
{


    /**
     * @param array $input
     * @return void
     * @throws Exception
     */
    public function doPreRegistration(array $input): void
    {
        (new Manager())->queryExecute(
            new Insert('user', ['name', 'password', 'email', 'token', 'expiration_date']),
            [
                'name' => $input['name'],
                'password' => password_hash($input['password1'], PASSWORD_BCRYPT),
                'email' => $input['email'],
                'token' => bin2hex(random_bytes(32)),
                'expiration_date' => strtotime('1 hour')
            ]
        );

    }


    /**
     * @return bool
     */
    public static function userIsConnected(): bool
    {
        if (empty(SessionBlog::get('name')) === false) {
            return true;
        }

        return false;

    }


    /**
     * @return bool
     */
    public static function userIsAdmin(): bool
    {
        if (self::userIsConnected() === true && SessionBlog::get('role') == 'admin') {
            return true;
        }

        return false;

    }


    /**
     * @param $info
     * @return $this|null
     */
    public function getUserInfo($info): ?self
    {
        $dataUser = (new Manager())->fetch((
        new Select('user', ['*']))
            ->where('email = :email'), ['email' => $info]);

        if (empty($dataUser) === true) {
            return null;
        }

        return new UserManager($dataUser);

    }


    /**
     * @return array
     */
    public function getAllUsers(): array
    {
        $data = (new Manager())->fetchAll(new Select('user', ['*']));
        $users = [];

        foreach ($data as $res) {
            $users[] = new UserManager($res);
        }

        return $users;

    }


    /**
     * @param $id
     * @return void
     */
    public function setUserAdmin($id): void
    {
        (new Manager())->queryExecute(
            (new Update('user'))
                ->set('user.role = "admin"')
                ->where('id = :id'),
            ['id' => $id[0]]
        );

    }


    /**
     * @param $id
     * @return void
     */
    public function setUserUser($id): void
    {
        (new Manager())->queryExecute(
            (new Update('user'))
                ->set('user.role = "user"')
                ->where('id = :id'),
            ['id' => $id[0]]
        );

    }


    /**
     * @param $id
     * @return void
     */
    public function deleteUser($id): void
    {
        (new Manager())->queryExecute(
            (new Delete('user'))
                ->where('id = :id'),
            ['id' => $id[0]]
        );

    }


    /**
     * @param $token
     * @return void
     */
    public function setUserValid($token): void
    {
        (new Manager())->queryExecute(
            (new Update('user'))
                ->set('user.validation = "valid"')
                ->where('token = :token'),
            ['token' => $token[0]]
        );

    }


    /**
     * @param $token
     * @return $this|null
     */
    public function getUserByToken($token): ?self
    {
        $user = (new Manager())->fetch(
            (new Select('user', ['*']))
                ->where('token = :token'),
            ['token' => $token[0]]
        );
        if (empty($user) === true) {
            return null;
        }

        return new UserManager($user);

    }


    /**
     * @param $token
     * @return void
     */
    public function deleteUserByToken($token): void
    {
        (new Manager())->queryExecute(
            (new Delete('user'))
                ->where('token = :token'),
            ['token' => $token[0]]
        );

    }


    /**
     * @param array $input
     * @param $id
     * @return void
     */
    public function updateNewPassword(array $input, $id): void
    {
        (new Manager())->queryExecute(
            (new Update('user'))
                ->set('user.password = :password')
                ->where('id = :id'),
            [
                'password' => password_hash($input['password1'], PASSWORD_BCRYPT),
                'id' => $id[0]
            ]
        );

    }


}
