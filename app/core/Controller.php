<?php

namespace app\core;

class Controller
{
    public string $layout = 'guest';
    public string $action = '';

    public function setLayout($layout)
    {
      $this->layout = $layout;
    }

    public function render($view, $params = [])
    {
      return Application::$app->view->renderView($view, $params);
    }

    public function return400(string $view, array $params = [])
    {
      Application::$app->response->setStatusCode('400');
      return $this->render($view, $params);
    }

    public function return401(string $view, array $params = [])
    {
      Application::$app->response->setStatusCode('401');
      return $this->render($view, $params);
    }

}
