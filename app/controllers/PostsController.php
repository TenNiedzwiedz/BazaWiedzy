<?php

namespace app\controllers;

use app\core\Application;
use app\core\ChangeLog;
use app\core\Controller;
use app\core\Request;
use app\core\ErrorLog;
use app\core\Validator;
use app\core\exceptions\DataInvalid;
use app\models\user\CurrentUser;
use app\models\post\Post;
use app\models\post\DbPost;
use app\models\tag\DbTag;

class PostsController extends Controller
{
  public CurrentUser $currentUser;
  public Post $post;
  public DbPost $dbPost;
  public ErrorLog $errorLog;
  public Validator $validator;
  public ChangeLog $changeLog;

  public array $params = [];

  public function __construct()
  {

    $this->currentUser = new CurrentUser();
    $this->post = new Post();
    $this->dbPost = new DbPost();
    $this->errorLog = new ErrorLog();
    $this->validator = new Validator();
    $this->changeLog = new ChangeLog();

    $this->params['currentUser'] = $this->currentUser;
    $this->params['post'] = $this->post;
  }

  /**
   * Renders addPost view. On POST adds new post.
   */
  public function addPost(Request $request)
  {
    $dbTagList = DbTag::findAll(['visible' => true]);

    foreach($dbTagList as $tag) {
      $tags[] = '\''.$tag->name.'\'';
    }
    
    $tags = implode(',', $tags);

    $this->params['tagList'] = $tags ?? '';

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

  public function editPost(Request $request)
  {
    $dbTagList = DbTag::findAll(['visible' => true]);

    foreach($dbTagList as $tag) {
      $tags[] = '\''.$tag->name.'\'';
    }
    
    $tags = implode(',', $tags);

    $this->params['tagList'] = $tags ?? '';

    $body = $request->getBody();

    if(!isset($body['id']) || !DbPost::findOne(['id' => $body['id']]))
    {
      Application::$app->session->setFlash('danger', 'Nie znaleziono artykułu');
      Application::$app->response->redirect('/postlist');
      exit;
    }

    $this->post->loadDbObjectData(DbPost::findOne(['id' => $body['id']]));

    if ($request->isPost()) {
      try {
        $this->post->loadData($body);
        $this->validator->validate($this->post, $this->errorLog);
      } catch (DataInvalid $e) {
        return $this->return400('editPost', $this->params);
      }

      $dbPost = DbPost::findOne(['id' => $this->post->id]);
      $this->changeLog->logOriginalObject($dbPost);

      $dbPost->loadObjectData($this->post);
      $this->changeLog->pushChanges($dbPost, $this->currentUser->id);

      if($dbPost->update(['id' => $this->post->id])) {
        Application::$app->session->setFlash('success', 'Zmiany zostały zapisane');
        Application::$app->response->redirect('/post?id='.$this->post->id);
        exit;
      }
    }

    return $this->render('editPost', $this->params);
  }

  /**
   * Render showPost view for given id.
   */
  public function showPost(Request $request)
  {
    $body = $request->getBody();

    if(!isset($body['id']) || !DbPost::findOne(['id' => $body['id']]))
    {
      Application::$app->session->setFlash('danger', 'Nie znaleziono artykułu');
      Application::$app->response->redirect('/postlist');
      exit;
    }

    $dbPost = DbPost::findOne(['id' => $body['id']]);
    $dbPost->views++; 
    $this->post->loadDbObjectData($dbPost);
    $dbPost->update(['id' => $body['id']]);

    return $this->render('showPost', $this->params);
  }

  /**
   * Renders postList view for given tag (default for all posts).
   */
  public function postList(Request $request)
  {

    $body = $request->getBody();

    $dbPostList = DbPost::FindAll();

    if (isset($body['tags'])) {
      foreach ($dbPostList as $dbPost) {
        $post = new Post();
        $post->loadDbObjectData($dbPost);
        if(str_contains($post->tags, $body['tags'])) {
          $postList[] = $post;
        }
      }
    } else {
      foreach ($dbPostList as $dbPost) {
        $post = new Post();
        $post->loadDbObjectData($dbPost);
        $postList[] = $post;
      }
    }

    $this->params['postList'] = $postList ?? [];

    return $this->render('postList', $this->params);
  }
}
