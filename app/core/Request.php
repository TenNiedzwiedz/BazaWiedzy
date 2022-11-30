<?php

namespace app\core;

class Request
{

  /**
   * Returns path from request URI.
   * 
   * @return string Part of URL after domain, before '?'
   */
  public function getPath()
  {
    $path = $_SERVER['REQUEST_URI'] ?? '/';
    $position = strpos($path, '?');
    if ($position === false) {
      return $path;
    }
    return substr($path, 0, $position);
  }

  /**
   * Returns method form request.
   * 
   * @return string
   */
  public function getMethod()
  {
    return strtolower($_SERVER['REQUEST_METHOD']);
  }

  /**
   * Pulls out params from URI.
   * 
   * @return string Part of URL after '?'
   */
  public function getParams()
  {
    $path = $_SERVER['REQUEST_URI'] ?? '/';
    $position = strpos($path, '?');
    if ($position === false) {
      return null;
    }
    return substr($path, ($position+1), strlen($path));
  }

  /**
   * Checks if request method is GET.
   * 
   * @return bool True if method is GET
   */
  public function isGet()
  {
    return $this->getMethod() === 'get';
  }

  /**
   * Checks if request method is POST.
   * 
   * @return bool True if method is POST
   */
  public function isPost()
  {
    return $this->getMethod() === 'post';
  }

  /**
   * Sanatize params send in request and store them in array.
   * 
   * @return array $body
   */
  public function getBody()
  {
    $body = [];

    if($this->isGet()) {
      foreach ($_GET as $key => $value) {
        $body[$key] = filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS);
      }
    }

    if($this->isPost()) {
      foreach ($_POST as $key => $value) {
        $body[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);
      }
    }

    return $body;
  }
}
