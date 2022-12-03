<?php

namespace app\controllers;

use app\core\Application;
use app\core\Controller;
use app\core\Request;
use app\models\Changelog;

class ChangelogController extends Controller
{
  public function showChangelog(Request $request) //TODO redo function
  {
    $body = $request->getBody();

    if(isset($body['object']) && isset($body['id']))
    {
      $changelogList = Changelog::findAll(['objectID' => $body['id']], $body['object'].'changes');

      $params = [
        'changelogList' => $changelogList
      ];
      return $this->render('changelog', $params);
    } else {
      Application::$app->response->redirect('/');
    }
  }

}
