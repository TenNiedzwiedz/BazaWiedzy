<?php

namespace app\core;

class View
{
  /**
   * Generates View for given parameters.
   * 
   * @param string $view
   * @param array $params
   * 
   * @return string Generated view
   */
  public function renderView(string $view, array $params = []) : string
  {
    $layoutContent = $this->renderLayout($params);
    $viewContent = $this->renderContent($view, $params);
    return str_replace('{{content}}', $viewContent, $layoutContent);
  }

  /**
   * Generates layout set in Application->layout.
   * 
   * @param array $params
   * 
   * @return string View layout
   */
  protected function renderLayout(array $params) : string
  {
    $layout = Application::$app->layout;
    foreach ($params as $key => $value) {
      $$key = $value;
    }
    ob_start();
    include_once Application::$ROOT_DIR."/views/layouts/$layout.php";
    return ob_get_clean();
  }

  /**
   * Generates content for given view.
   * 
   * @param string $view
   * @param array $params
   * 
   * @return string View content
   */
  protected function renderContent(string $view, array $params) : string
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
