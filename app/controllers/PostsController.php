<?php

namespace app\controllers;

use app\core\Application;
use app\core\Controller;
use app\core\Request;
use app\core\ErrorLog;
use app\core\Validator;
use app\core\exceptions\DataInvalid;
use app\models\user\CurrentUser;
use app\models\post\Post;
use app\models\post\DbPost;

class PostsController extends Controller
{
  public CurrentUser $currentUser;
  public Post $post;
  public DbPost $dbPost;
  public ErrorLog $errorLog;
  public Validator $validator;

  public array $params = [];

  public function __construct()
  {

    $this->currentUser = new CurrentUser();
    $this->post = new Post();
    $this->dbPost = new DbPost();
    $this->errorLog = new ErrorLog();
    $this->validator = new Validator();

    $this->params['currentUser'] = $this->currentUser;
    $this->params['post'] = $this->post;
  }

  /**
   * Renders addPost view. On POST adds new post.
   */
  public function addPost(Request $request)
  {
    if ($request->isPost()) {
      $body = $request->getBody();

      try {
        $this->post->loadData($body);
        $this->validator->validate($this->post, $this->errorLog);
      } catch (DataInvalid $e) {
        return $this->return400('addPost', $this->params);
      }

      $this->dbPost->loadObjectData($this->post);

      if ($this->dbPost->save()) {
        Application::$app->session->setFlash('success', 'Artykuł został dodany');
        Application::$app->response->redirect('/');
        exit;
      }
    }

    return $this->render('addPost', $this->params);
  }

  /**
   * Renders postList view for given product ID (default for all posts).
   */
  public function postList(Request $request)
  {

    $body = $request->getBody();

    if (isset($body['product'])) {
      $dbPostList = DbPost::FindAll(['productID' => $body['product']]);
    } else {
      $dbPostList = DbPost::FindAll();
    }

    foreach ($dbPostList as $dbPost) {
      $post = new Post();
      $post->loadDbObjectData($dbPost);
      $postList[] = $post;
    }

    $this->params['postList'] = $postList;

    return $this->render('postList', $this->params);
  }
}
