<?php

  namespace app\models\user\changePassword;

  use app\core\Application;
  use app\core\Model;

  class ChangePassword extends Model{

    public string $id;
    public string $password = '';
    public string $newPassword = '';
    public string $confirmNewPassword = '';

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

    /**
     * Hash new password and save it as current password.
     */
    public function hashNewPassword()
    {
      $this->password = password_hash($this->newPassword, PASSWORD_DEFAULT);
    }

  }
