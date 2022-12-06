<?php

namespace app\controllers;

use app\core\Application;
use app\core\Controller;
use app\core\ErrorLog;
use app\core\exceptions\DataInvalid;
use app\core\exceptions\InvalidUser;
use app\core\Request;
use app\core\Validator;
use app\models\user\loginForm\LoginForm;
use app\models\user\loginForm\DbLoginForm;
use app\models\user\DbUser;

class AuthController extends Controller
{
  public Validator $validator;
  public ErrorLog $errorLog;

  public function __construct()
  {
    $this->validator = new Validator;
    $this->errorLog = new ErrorLog;
    $this->loginForm = new LoginForm;
    $this->dbLoginForm = new DbLoginForm;

    $this->params['model'] = $this->loginForm;
  }

  /**
   * Renders login view. On POST logs in given user.
   */
  public function login(Request $request)
  {
    if ($request->isPost()) {
      $body = $request->getBody();

      try {
        $this->loginForm->loadData($body);
        $this->validator->validate($this->loginForm, $this->errorLog);
      } catch (DataInvalid $e) {
        return $this->return400('login', $this->params);
      }

      $this->dbLoginForm->loadObjectData($this->loginForm);

      try {
        $this->dbLoginForm->login();
      } catch (InvalidUser $e) {
        $this->errorLog->addError('password', 'Wprowadzono niepoprawny login lub hasło');
        $this->loginForm->errors = $this->errorLog->errors;
        return $this->return401('login', $this->params);
      }

      $currentUser = DbUser::findOne(['id' => $this->dbLoginForm->id]);
      Application::$app->session->setFlash('success', 'Dziękujemy za zalogowanie');
      Application::$app->session->set('userID', $currentUser->id);
      Application::$app->session->set('userRole', $currentUser->userRole);
      Application::$app->response->redirect('/');
    }

    return $this->render('login', $this->params);
  }

  /**
   * Logs out current user.
   */
  public function logout()
  {
    Application::$app->session->setFlash('success', 'Wylogowano pomyślnie');
    Application::$app->session->remove('userID');
    Application::$app->session->remove('userRole');
    Application::$app->response->redirect('/login');
  }
}
