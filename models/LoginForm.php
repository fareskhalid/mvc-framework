<?php

namespace app\models;

use app\core\Application;
use app\core\Model;
use Dotenv\Exception\ValidationException;

class LoginForm extends Model
{
    public string $email = '';
    public string $password = '';
    public function rules(): array
    {
        return [
            'email' => [self::RULE_REQUIRED, self::RULE_EMAIL],
            'password' => [self::RULE_REQUIRED]
        ];
    }

    public function labels(): array
    {
        return [
            'email' => 'Email',
            'password' => 'Password'
        ];
    }

    public function login()
    {
        $user = (new User)->findOne(['email' => $this->email]);
        if (!$user) {
            $this->addError('email', 'User does not exist with this email');
            return false;
        }
        // if the user exists then check the password
        if (password_verify($this->password, $user->password) === false) {
            $this->addError('password', 'Password is incorrect');
            return false;
        }
       return Application::$app->login($user);
    }
}