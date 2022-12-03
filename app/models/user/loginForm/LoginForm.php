<?php

  namespace app\models\user\loginForm;

  use app\core\Application;
  use app\core\Model;

  class LoginForm extends Model{

    public string $id;
    public string $login = '';
    public string $password = '';
    public string $userRole;

    public function rules(): array
    {
      return [
        'login' => [self::RULE_REQUIRED],
        'password' => [self::RULE_REQUIRED],
      ];
    }

    public function labels(): array
    {
      return [
        'login' => 'Login',
        'password' => 'Hasło',
        ];
    }

  }
