<?php

namespace app\controllers;

use app\core\Application;
use app\core\Controller;
use app\core\Request;
use app\models\User;
use app\models\Post;

class PostsController extends Controller
{

  public function addPost(Request $request)
  {
    $user = User::getCurrentUser();

    $post = new Post();

    if($request->isPost())
    {
      $body = $request->getBody();
      $post->loadData($body);

      if($post->validate() && $post->save())
      {
        Application::$app->session->setFlash('success', 'Artykuł został dodany');
        Application::$app->response->redirect('/');
        exit;
      }
    }

    $params = [
      'user' => $user,
      'post' => $post
    ];

    return $this->render('addPost', $params);
  }

}
