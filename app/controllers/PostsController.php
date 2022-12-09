<?php

namespace app\controllers;

use app\core\Application;
use app\core\ChangeLog;
use app\core\Controller;
use app\core\Request;
use app\core\ErrorLog;
use app\core\Validator;
use app\core\exceptions\DataInvalid;
use app\core\SearchEngine;
use app\models\favourites\DbFavourite;
use app\models\user\CurrentUser;
use app\models\post\Post;
use app\models\post\DbPost;
use app\models\tag\DbTag;
use app\models\user\DbUser;
use app\models\user\User;

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

    $this->post->content = str_replace("\n", "</br>", $this->post->content);

    $verifiedDate = new \DateTime($this->post->verifiedDate);
    $today = new \DateTime('now');
    $verifiedDaysAgo = date_diff($verifiedDate, $today);
    
    $this->params['verifiedDaysAgo'] = $verifiedDaysAgo->format('%a');

    if($this->post->verified) {
      $verifiedBy = new User();
      $verifiedBy->loadDbObjectData(DbUser::findOne(['id' => $this->post->verifiedBy]));  
    } else {
      $verifiedBy = $this->currentUser;
    }
    
    $this->params['verified'] = [
      'today' => $today->format('Y-m-d'), 
      'date' => $verifiedDate->format('Y-m-d'),
      'name' => $verifiedBy->getUsername()
    ];

    $isFav = (DbFavourite::findOne(['userID' => $this->currentUser->id, 'postID' => $dbPost->id])) ? true : false;
    $this->params['isFav'] = $isFav;

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

    $tagList = DbTag::findAll();

    if($postList ?? false) {
      foreach($tagList as $tag) {
        if(!isset($body['tags']) || ($body['tags'] != $tag->name)) {
          foreach($postList as $post) {
            if(str_contains($post->tags, $tag->name)) {
              $postByTagList[$tag->name][] = $post;
            }
          }
        }
      }
    }

    $this->params['postByTagList'] = $postByTagList ?? [];
    $this->params['postList'] = $postList ?? [];

    return $this->render('postList', $this->params);
  }

  public function verifyPost(Request $request)
  {
    $body = $request->getBody();

    if(isset($body['id']) && $body['id'] != 'undefined')
    {
      $this->post->loadDbObjectData(DbPost::findOne(['id' => $body['id']]));
      $today = new \DateTime();
      $this->post->verified = true;
      $this->post->verifiedBy = $this->currentUser->id;
      $this->post->verifiedDate = $today->format('Y-m-d H:i:s');

      if(isset($body['accept']) && $body['accept'] === true)
      {
        $this->post->accepted = true;
      }
      try {
        $this->validator->validate($this->post, $this->errorLog);
      } catch (DataInvalid $e) {
        return json_encode(['type' => 'danger', 'label' => 'Wystąpił błąd', 'message' => 'Spróbuj ponownie później (error-data-val)']);
      }

      $dbPost = DbPost::findOne(['id' => $this->post->id]);
      $this->changeLog->logOriginalObject($dbPost);

      $dbPost->loadObjectData($this->post);
      $this->changeLog->pushChanges($dbPost, $this->currentUser->id);

      if($dbPost->update(['id' => $dbPost->id])) {
        return json_encode(['type' => 'success', 'label' => 'Sukces', 'message' => 'Post został zweryfikowany']);
      }
      
      return json_encode(['type' => 'danger', 'label' => 'Wystąpił błąd', 'message' => 'Spróbuj ponownie później (error-update)']);
    }

    return json_encode(['type' => 'danger', 'label' => 'Wystąpił błąd', 'message' => 'Spróbuj ponownie później (error-body-val)']);
  }
 
  public function searchPosts(Request $request)
  {
    $dbTagList = DbTag::findAll(['visible' => true]);

    foreach($dbTagList as $tag) {
      $tags[] = '\''.$tag->name.'\'';
    }
    
    $tags = implode(',', $tags);

    $this->params['tagList'] = $tags ?? '';

    $body = $request->getBody();

    if(isset($body['searchWords']) && !empty($body['searchWords'])) {
      $query['content'] = $body['searchWords'];
    }
    if(isset($body['searchTags']) && !empty($body['searchTags'])) {
      $searchTagsList = json_decode($body['searchTags']);
      $searchTags = '';
      foreach($searchTagsList as $key => $tag) {
        if($key === array_key_first($searchTagsList)) {
          $searchTags .= '+'.$tag->value;
        } else {
          $searchTags .= ' +'.$tag->value;
        }
      }
      $query['tags'] = $searchTags;
    }

    if(isset($query) && !empty($query)) {
      $dbPostList = SearchEngine::findAllObjectsByQuery($this->dbPost, $query);

      if($dbPostList) {
        foreach($dbPostList as $dbPost) {
          $post = new Post();
          $post->loadDbObjectData($dbPost);
          $postList[] = $post;

          $tags = json_decode($dbPost->tags);
          if(count($tags) > 5)
          {
            $postTagList[$post->id] = array_slice($tags, 0, 5);
            $postTagList[$post->id][5] = json_decode('{"value":"..."}');
          } else {
            $postTagList[$post->id] = $tags;
          }
        }
      }
    }

    $this->params['searchWords'] = $body['searchWords'] ?? '';
    $this->params['searchTags'] = str_replace('"', '&#34;', $body['searchTags'] ?? '');
    $this->params['postList'] = $postList ?? [];
    $this->params['postTagList'] = $postTagList ?? [];

    return $this->render('search', $this->params);
  }

}
