<?php

namespace App\Manager\FormManager;

final class FormChangePassword
{
    /**
     * @param array $input
     * @return bool
     */
    public function checkPassword(array $input): bool
    {
        return (isset($input['password1']) && isset($input['password2']) && $input['password1'] === $input['password2']);
    }

    /**
     * @param $input
     * @return bool
     */
    public function validPassword($input): bool
    {
        $regex = "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/";
        return preg_match($regex, $input['password1']);
    }

    /**
     * @param array $input
     * @return array
     */
    public function isValid(array $input): array
    {
        $errors = [];
        if ($this->checkPassword($input) === false) {
            $errors['password'] = 'Passwords do not match';
        }
        if ($this->validPassword($input) === false) {
            $errors['regex'] = 'Your password must contain at least 8 characters, one uppercase, one lowercase and one special character';
        }
        if($this->checkPassword($input) === true && $this->validPassword($input) === true) {
            $errors['good'] = 'Your password has been successfully updated';
        }
        return $errors;
    }
}
