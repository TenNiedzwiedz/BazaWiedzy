<?php

  namespace app\models\user;

  use app\core\Application;
  use app\core\Model;

  class User extends Model{

    public string $id;
    public string $login = '';
    public string $password = '';
    public string $userRole;
    public string $firstname = '';
    public string $lastname = '';
    public string $email = '';

    public function rules(): array
    {
      return [
        'login' => [self::RULE_REQUIRED],
        'password' => [self::RULE_REQUIRED],
        'firstname' => [self::RULE_REQUIRED],
        'lastname' => [self::RULE_REQUIRED],
        'email' => [self::RULE_REQUIRED],
      ];
    }

    public function labels(): array
    {
      return [
        'id' => 'ID',
        'login' => 'Login',
        'password' => 'Hasło',
        'userRole' => 'Typ konta',
        'firstname' => 'Imię',
        'lastname' => 'Nazwisko',
        'email' => 'E-mail'
        ];
    }

    public function getUsername()
    {
      return $this->firstname.' '.$this->lastname;
    }

    public function getUserRole()
    {
      switch($this->userRole) {
        case 'admin':
          return 'Administrator';
          break;
        case 'user':
          return 'Użytkownik';
          break;
        default:
          return 'Brak';
          break;
      }
    }

  }
