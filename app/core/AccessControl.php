<?php

namespace app\core;

class AccessControl
{
  public static array $accessRules = [
    'guest' => [ 'login'],
    'user' => ['main', 'logout', 'myProfile', 'userSettings', 'changePassword', 'addPost'],
    'admin' => ['main', 'logout', 'myProfile', 'userSettings', 'changePassword', 'addPost', 'editUser', 'showChangelog']
    ];

  public static function checkAccess($route)
  {
    $userRole = Application::$app->session->get('userRole') ?: 'guest';

    if (is_string($route)) {
      $result = in_array($route, self::$accessRules[$userRole]);
    }

    if (is_array($route)) {
      $result = in_array($route[1], self::$accessRules[$userRole]);
    }

    if($result) {
      Application::$app->layout = $userRole;
    }

    return $result;
  }
}
