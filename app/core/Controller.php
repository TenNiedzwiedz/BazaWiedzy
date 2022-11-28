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

}
