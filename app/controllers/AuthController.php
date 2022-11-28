<?php

namespace app\controllers;

use app\core\Application;
use app\core\Controller;
use app\core\Request;
use app\models\LoginForm;

class AuthController extends Controller
{

  public function login(Request $request)
  {
    $user = new LoginForm();


    if($request->isPost())
    {
      $body = $request->getBody();
      $user->loadData($body);
      if($user->validate() && $user->login($body))
      {
        Application::$app->session->setFlash('success', 'Dziękujemy za zalogowanie');
        Application::$app->session->set('userID', $user->id);
        Application::$app->session->set('userRole', $user->userRole);
        Application::$app->response->redirect('/');
      }
    }

    $params = [
      'model' => $user
      ];

    return $this->render('login', $params);
  }

  public function logout()
  {
    Application::$app->session->setFlash('success', 'Wylogowano pomyślnie');
    Application::$app->session->remove('userID');
    Application::$app->session->remove('userRole');
    Application::$app->response->redirect('/login');
  }

}
