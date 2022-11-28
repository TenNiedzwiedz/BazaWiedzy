<?php

namespace app\core;

class View
{
  public function renderView($view, $params = [])
  {
    $layoutContent = $this->layoutContent($params);
    $viewContent = $this->viewContent($view, $params);
    return str_replace('{{content}}', $viewContent, $layoutContent);
  }

  protected function layoutContent($params)
  {
    $layout = Application::$app->layout;
    foreach ($params as $key => $value) {
      $$key = $value;
    }
    ob_start();
    include_once Application::$ROOT_DIR."/views/layouts/$layout.php";
    return ob_get_clean();
  }

  protected function viewContent($view, $params)
  {
    foreach ($params as $key => $value) {
      $$key = $value;
    }
    ob_start();
    include_once Application::$ROOT_DIR."/views/$view.php";
    return ob_get_clean();
  }
}

?>
