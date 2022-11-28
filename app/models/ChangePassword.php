<?php

  namespace app\models;

  use app\core\Application;
  use app\core\DbModel;

  class ChangePassword extends DbModel{

    public string $id;
    public string $password = '';
    public string $newPassword = '';
    public string $confirmNewPassword = '';

    public function update($where, $body=[])
    {
      $userCopy = clone $this;
      $this->loadData($body);
      if(!password_verify($this->password, $userCopy->password))
      {
        $this->addError('password', 'Wprowadzono niepoprawne obecne hasło');
        return false;
      }
      if($result = $this->validate())
      {
        $this->password = password_hash($this->newPassword, PASSWORD_DEFAULT);
        $result = parent::update(['id' => $this->id]);
      }

      return $result;
    }

    public function rules(): array
    {
      return [
        'password' => [self::RULE_REQUIRED],
        'newPassword' => [self::RULE_REQUIRED, [self::RULE_MIN, 'min' => 8], [self::RULE_MAX, 'max' => 24]],
        'confirmNewPassword' => [self::RULE_REQUIRED, [self::RULE_MATCH, 'match' => 'newPassword']],
      ];
    }

    public function labels(): array
    {
      return [
        'password' => 'Obecne hasło',
        'newPassword' => 'Nowe hasło',
        'confirmNewPassword' => 'Powtórz nowe hasło'
        ];
    }

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
