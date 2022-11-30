<?php

namespace app\controllers;

use app\core\Application;
use app\core\Controller;
use app\core\Request;
use app\models\User;
use app\models\RegisterUser;
use app\models\ChangePassword;
use app\models\Post;

use app\core\table\Table;

class UsersController extends Controller
{

  public function registerUser(Request $request)
  {
    $user = new RegisterUser();

    if($request->isPost())
    {
      $body = $request->getBody();

      $user->loadData($body);

      if($user->validate() && $user->save())
      {
        Application::$app->session->setFlash('success', 'Dziękujemy za rejestrację! Możesz się teraz zalogować');
        Application::$app->response->redirect('/');
        exit;
      }
    }

    $params = [
        'model' => $user,
      ];

    return $this->render('registerForm', $params);
  }

  public function myProfile()
  {

    $user = User::getCurrentUser();

    $postList = Post::findAll(["addedBy" => $user->id]);

    $postList = array_reverse($postList);
    $postList = array_slice($postList, 0, 5);

    $params = [
      'user' => $user,
      'postList' => $postList
    ];

    return $this->render('myProfile', $params);
  }

  public function userSettings()
  {
    $user = User::getCurrentUser();

    $changePassword = new ChangePassword;

    $params = [
      'user' => $user,
      'model' => $changePassword
    ];

    return $this->render('userSettings', $params);
  }

  public function usersList()
  {
    $usersList = User::findAll();

    $params = [
      'usersList' => $usersList
    ];

    return $this->render('usersList', $params);
  }

  public function changePassword(Request $request)
  {
    $body = $request->getBody();

    $user = User::getCurrentUser();
    $id = $user->id;

    $changePassword = new ChangePassword;

    if($request->isPost())
    {
      $changePassword = $changePassword::findOne(['id' => $id]);

      if($changePassword->update(['id' => $changePassword->id], $body))
      {
        Application::$app->session->setFlash('success', 'Hasło zostało zmienione');
        Application::$app->response->redirect('/myprofile');
        exit;
      }
    }

    $params = [
      'user' => $user,
      'model' => $changePassword
    ];
    return $this->render('userSettings', $params);
  }

  public function editUser(Request $request)
  {
    $body = $request->getBody();
    $user = User::getCurrentUser();
    $changePassword = new ChangePassword;

    if(isset($body['id']))
    {
      $id = $body['id'];

      $user = new User();
      $user = $user::findOne(['id' => $id]);
    }

    if(!$user)
    {
      throw new \Exception('Użytkownik o podanym ID nie istnieje', 404);
    }

    if($request->isPost())
    {
      if($user->update(['id' => $user->id], $body))
      {
        Application::$app->session->setFlash('success', 'Zmiany zostały zapisane');
        Application::$app->response->redirect('/myprofile');
        exit;
      }
    }

    $params = [
      'user' => $user,
      'model' => $changePassword
    ];
    return $this->render('userSettings', $params);
  }

}
