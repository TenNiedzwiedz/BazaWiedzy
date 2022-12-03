<?php

  namespace app\models\user\changePassword;

  use app\core\Application;
  use app\core\DbModel;

  class DbChangePassword extends DbModel{

    public string $id;
    public string $password = '';

    public static function tableName()
    {
      return 'users';
    }

    public function getDbFields()
    {
      return ['password'];
    }

    public function getChangelogFields()
    {
      return [];
    }


  }
