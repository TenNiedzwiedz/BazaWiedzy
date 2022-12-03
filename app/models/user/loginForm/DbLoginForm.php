<?php

namespace app\models\user\loginForm;

use app\core\Application;
use app\core\DbModel;
use app\core\exceptions\InvalidUser;

class DbLoginForm extends DbModel
{

  public string $id;
  public string $login;
  public string $password;
  public string $userRole;

  public function login()
  {
    $result = $this::findOne(['login' => $this->login]);

    if ($result) {
      if (password_verify($this->password, $result->password)) {
        $this->id = $result->id;
        $this->userRole = $result->userRole;
        return true;
      }
      throw new InvalidUser("Invalid user password");
    }
    throw new InvalidUser("User not found");
    return false;
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
