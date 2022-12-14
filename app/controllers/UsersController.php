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
use app\models\user\User;
use app\models\user\DbUser;
//use app\models\RegisterUser;
use app\models\user\changePassword\ChangePassword;
use app\models\user\changePassword\DbChangePassword;
use app\models\post\Post;
use app\models\post\DbPost;

use app\core\table\Table;


class UsersController extends Controller
{
  public CurrentUser $currentUser;
  public ErrorLog $errorLog;
  public Validator $validator;
  public ChangeLog $changeLog;

  public array $params;

  public function __construct()
  {
    $this->currentUser = new CurrentUser();
    $this->errorLog = new ErrorLog();
    $this->validator = new Validator();
    $this->changeLog = new ChangeLog();

    $this->user = new User();
    $this->user->loadDbObjectData(DbUser::findOne(['id' => $this->currentUser->id]));

    $this->params['user'] = $this->user;
    $this->params['currentUser'] = $this->currentUser;
  }

  /**
   * Renders myProfile view for current user.
   */
  public function myProfile()
  {
    $dbPostList = DbPost::findAll(["addedBy" => $this->currentUser->id]);

    $dbPostList = array_reverse($dbPostList);
    $dbPostList = array_slice($dbPostList, 0, 5);

    foreach ($dbPostList as $dbPost) {
      $post = new Post();
      $post->loadDbObjectData($dbPost);

      $post->content = str_replace("\n", "</br>", $post->content);

      $postList[] = $post;

      $tags = json_decode($dbPost->tags);
      if(is_array($tags) && count($tags) > 5)
      {
        $tagList[$post->id] = array_slice($tags, 0, 5);
        $tagList[$post->id][5] = json_decode('{"value":"..."}');
      } else {
        $tagList[$post->id] = $tags;
      }
      
    }
    $addedPosts = count(DbPost::findAll(['addedBy' => $this->currentUser->id]));

    $this->params['addedPosts'] = $addedPosts ?? '0';
    $this->params['postList'] = $postList ?? [];
    $this->params['tagList'] = $tagList ?? [];

    return $this->render('myProfile', $this->params);
  }

  /**
   * Renders userSettings view for current user.
   */
  public function userSettings()
  {
    $changePassword = new ChangePassword();

    $this->params['model'] = $changePassword;

    return $this->render('userSettings', $this->params);
  }

  /**
   * Renders userList view.
   */
  public function usersList()
  {
    $dbUserList = DbUser::findAll();

    foreach ($dbUserList as $dbUser) {
      $user = new User();
      $user->loadDbObjectData($dbUser);
      $userList[] = $user;
    }

    $this->params['userList'] = $userList;

    return $this->render('usersList', $this->params);
  }

  /**
   * Changes password for given user ID (default: current user ID).
   */
  public function changePassword(Request $request)
  {    

    if ($request->isPost()) {
      $body = $request->getBody();

      $id = $body['id'] ?? $this->currentUser->id;
      
      if($dbChangePassword = DbChangePassword::findOne(['id' => $id]))
      {
        $changePassword = new ChangePassword;
        $this->params['model'] = $changePassword;

        $changePassword->loadData($body);

        try {
          $this->validator->validate($changePassword, $this->errorLog);
          $this->validator->validatePassword($changePassword, $dbChangePassword, $this->errorLog);
        } catch (DataInvalid $e) {
          return $this->return400('userSettings', $this->params);
        }

        $changePassword->hashNewPassword();
        $dbChangePassword->loadObjectData($changePassword);

        if($dbChangePassword->update(['id' => $id]))
        {
          Application::$app->session->setFlash('success', 'Has??o zosta??o zmienione');
          Application::$app->response->redirect('/myprofile');
          exit;
        }
      }

    }

    return $this->render('userSettings', $this->params);
  }

  /**
   * Updates details about current user.
   */
  public function editUser(Request $request)
  {
    $body = $request->getBody();

    $changePassword = new ChangePassword;
    $this->params['model'] = $changePassword;

    if ($request->isPost()) {
      try {
        $this->user->loadData($body);
        $this->validator->validate($this->user, $this->errorLog);
      } catch (DataInvalid $e) {
        return $this->return400('userSettings', $this->params);
      }

      $dbUser = DbUser::findOne(['id' => $this->currentUser->id]);
      $this->changeLog->logOriginalObject($dbUser);

      $dbUser->loadObjectData($this->user);
      $this->changeLog->pushChanges($dbUser, $this->currentUser->id);

      if ($dbUser->update(['id' => $this->user->id])) {
        Application::$app->session->setFlash('success', 'Zmiany zosta??y zapisane');
        Application::$app->response->redirect('/myprofile');
        exit;
      }
    }

    return $this->render('userSettings', $this->params);
  }
}
