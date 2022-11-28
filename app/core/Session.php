<?php

namespace app\core;

class Session
{
  protected const FLASH_KEY = 'flash_messages';

  public function __construct()
  {
    session_start();
    $flashMessages = $_SESSION[self::FLASH_KEY] ?? [];
    foreach ($flashMessages as $key => &$flashMessage) {
      $flashMessage['remove'] = true;
    }
    $_SESSION[self::FLASH_KEY] = $flashMessages;
  }

  public function setFlash($key, $message)
  {
    $_SESSION[self::FLASH_KEY][$key] = [
      'remove' => false,
      'value' => $message
    ];
  }

  public function getFlash($key)
  {
    return $_SESSION[self::FLASH_KEY][$key]['value'] ?? false;
  }

  public function checkFlash()
  {
    $types = ['danger' => "Wystąpił błąd", 'warning' => 'Uwaga', 'success' => 'Sukces'];

    foreach($types as $type => $label)
    {
      if($this->getFlash($type))
      {
        return ['type' => $type, 'label' => $label, 'message' => $this->getFlash($type)];
      }
    }
    return false;
  }

  public function set($key, $value)
  {
    $_SESSION[$key] = $value;
  }

  public function get($key)
  {
    return $_SESSION[$key] ?? '';
  }

  public function remove($key)
  {
    unset($_SESSION[$key]);
  }

  public function __destruct()
  {
    $flashMessages = $_SESSION[self::FLASH_KEY] ?? [];
    foreach ($flashMessages as $key => $flashMessage) {
      if ($flashMessage['remove']) {
        unset($flashMessages[$key]);
      }
    }
    $_SESSION[self::FLASH_KEY] = $flashMessages;
  }

}
