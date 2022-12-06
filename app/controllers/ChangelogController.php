<?php

namespace app\controllers;

use app\core\Application;
use app\core\Controller;
use app\core\Request;
use app\models\changelog\Changelog;
use app\models\changelog\DbChangelog;
use app\models\user\CurrentUser;

class ChangelogController extends Controller
{
  public CurrentUser $currentUser;

  public array $params =[];

  public function __construct()
  {
    $this->currentUser = new CurrentUser();

    $this->params['currentUser'] = $this->currentUser;
  }

  public function showChangelog(Request $request)
  {
    $body = $request->getBody();

    if(isset($body['object']) && isset($body['id']))
    {
      $dbChangelogList = DbChangelog::findAll(['objectID' => $body['id']], $body['object'].'changes');

      foreach ($dbChangelogList as $dbChangelog) {
        $changelog = new Changelog();
        $changelog->loadDbObjectData($dbChangelog);
        $changelogList[] = $changelog;
      }
      
      $this->params['changelogList'] = $changelogList ?? [];

      return $this->render('changelog', $this->params);
    } else {
      Application::$app->response->redirect('/');
    }
  }

}
