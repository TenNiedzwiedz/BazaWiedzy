<?php

namespace app\controllers;

use app\core\Application;
use app\core\Controller;
use app\core\Request;
use app\models\user\CurrentUser;

class SiteController extends Controller
{
  public CurrentUser $currentUser;

  public array $params;

  public function __construct()
  {
    $this->currentUser = new CurrentUser();

    $this->params['currentUser'] = $this->currentUser;
  }

  /**
   * Renders main view.
   */
  public function main()
  {
    return $this->render('main', $this->params);
  }
}
