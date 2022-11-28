<?php

namespace app\controllers;

use app\core\Application;
use app\core\Controller;
use app\core\Request;
use app\models\User;

class SiteController extends Controller
{

  public function main()
  {
    $user = User::getCurrentUser();

    $params = [
      'user' => $user
    ];

    return $this->render('main', $params);
  }

}
