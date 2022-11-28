<?php

  namespace app\models;

  use app\core\Application;
  use app\core\DbModel;

  class User extends DbModel{

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

    public static function getCurrentUser()
    {
      $id = Application::$app->session->get('userID');
      $user = new User();
      $user = $user::findOne(['id' => $id]);
      return $user;
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

    public function update($where, $body=[])
    {
      $userCopy = clone $this;
      $this->loadData($body);
      if($result = ($this->validate() && parent::update($where)))
      {
        $this->changelog($userCopy);
      }
      return $result;
    }

    public static function tableName()
    {
      return 'users';
    }

    public function getDbFields()
    {
      return ['login', 'password', 'userRole', 'firstname', 'lastname', 'email'];
    }

    public function getChangelogFields()
    {
      return ['login', 'userRole', 'firstname', 'lastname', 'email'];
    }


  }
