<?php

  namespace app\models\user;

  use app\core\Application;
  use app\core\DbModel;

  class DbUser extends DbModel{

    public string $id;
    public string $login = '';
    public string $password = '';
    public string $userRole;
    public string $firstname = '';
    public string $lastname = '';
    public string $email = '';

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
