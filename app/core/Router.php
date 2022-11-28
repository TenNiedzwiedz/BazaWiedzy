<?php

namespace app\core;

class Router
{
  public Request $request;
  public Response $response;
  public View $view;
  protected array $routes = [];

  public function __construct(Request $request, Response $response, View $view)
  {
    $this->request = $request;
    $this->response = $response;
    $this->view = $view;
  }

  public function get($path, $callback)
  {
    $this->routes['get'][$path] = $callback;
  }

  public function post($path, $callback)
  {
    $this->routes['post'][$path] = $callback;
  }

  public function resolve()
  {
    $path = $this->request->getPath();
    $method = $this->request->getMethod();
    $callback = $this->routes[$method][$path] ?? false;
    if ($callback === false) {
      throw new \Exception('Podana strona nie istnieje', 404);
    }

    if (AccessControl::checkAccess($callback) === false) {
      throw new \Exception('Nie posiadasz uprawnień, by wyświetlić tą stronę', 403);
    }

    if (is_string($callback)) {
      return $this->view->renderView($callback);
    }

    if (is_array($callback)) {
      $controller = new $callback[0]();
      Application::$app->controller = $controller;
      $controller->action = $callback[1];
      $callback[0] = $controller;
    }

    return call_user_func($callback, $this->request);
  }

}
