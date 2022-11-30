<?php

namespace app\core;

class Response
{
  /**
   * Sets http response code.
   * 
   * @param int $code
   */
  public function setStatusCode(int $code)
  {
    http_response_code($code);
  }

  /**
   * Redirects to given url.
   * 
   * @param string $url
   */
  public function redirect(string $url)
  {
    header('Location: '.$url);
  }

}
