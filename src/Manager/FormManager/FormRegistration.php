<?php

namespace App\Manager\FormManager;

final class FormRegistration
{
    /**
     * @param array $input
     * @return bool
     */
    private function checkName(array $input): bool
    {
        return (isset($input['name']) && strlen($input['name']) > 2);
    }

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
     * @return bool
     */
    private function checkEmail(array $input): bool
    {
        return (isset($input['email']) && filter_var($input['email'], FILTER_VALIDATE_EMAIL));
    }


    /**
     * @param array $input
     * @return array
     */
    public function isValid(array $input): array
    {
        $errors = [];
        if ($this->checkName($input) === false) {
            $errors['name'] = 'The name must contain at least 3 characters';
        }

        if ($this->checkEmail($input) === false) {
            $errors['email'] = 'The email address is not valid';
        }

        if ($this->checkPassword($input) === false) {
            $errors['password'] = 'Passwords do not match';
        }

        if ($this->validPassword($input) === false) {
            $errors['regex'] = 'Your password must contain at least 8 characters, one uppercase, one lowercase and one special character';
        }

        return $errors;
    }
}
