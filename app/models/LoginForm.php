<?php

  namespace app\models;

  use app\core\Application;
  use app\core\DbModel;

  class LoginForm extends DbModel{

    public string $id;
    public string $login = '';
    public string $password = '';
    public string $userRole;

    public function login($body)
    {

      if(isset($body['login']) && isset($body['password']))
      {
        $login = $body['login'];
        $password = $body['password'];
      } else {
        return false;
      }

      $result = $this::findOne(['login' => $login]);

      if($result)
      {
        if(password_verify($password, $result->password))
        {
          $this->loadData($result);
          return true;
        }
      }
      $this->addError('login', 'Wprowadzono niepoprawny login lub hasło');
      return false;
    }

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

    public static function tableName()
    {
      return 'users';
    }

    public function getDbFields()
    {
      return [];
    }

    public function getChangelogFields()
    {
      return [];
    }


  }
