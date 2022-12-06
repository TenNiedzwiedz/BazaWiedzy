<?php

  require_once __DIR__.'/../app/vendor/autoload.php';

  use app\core\Application;

  use app\controllers\SiteController;
  use app\controllers\AuthController;
  use app\controllers\TagsController;
  use app\controllers\UsersController;
  use app\controllers\ChangelogController;
  use app\controllers\PostsController;

  $app = new Application(dirname(__DIR__).'/app');

  // Routes declaration

  $app->router->get('/', [SiteController::class, 'main']);

  $app->router->get('/login', [AuthController::class, 'login']);
  $app->router->post('/login', [AuthController::class, 'login']);
  $app->router->get('/logout', [AuthController::class, 'logout']);
  $app->router->get('/register', [UsersController::class, 'registerUser']);
  $app->router->post('/register', [UsersController::class, 'registerUser']);

  $app->router->get('/myprofile', [UsersController::class, 'myProfile']);
  $app->router->get('/settings', [UsersController::class, 'userSettings']);
  $app->router->post('/settings', [UsersController::class, 'userSettings']);
  //$app->router->get('/changepassword', [UsersController::class, 'changePassword']);
  $app->router->post('/changepassword', [UsersController::class, 'changePassword']);

  $app->router->get('/addtag', [TagsController::class, 'addTag']);
  $app->router->post('/addtag', [TagsController::class, 'addTag']);
  $app->router->get('/edittag', [TagsController::class, 'editTag']);
  $app->router->post('/edittag', [TagsController::class, 'editTag']);
  $app->router->get('/tags', [TagsController::class, 'showTags']);

  $app->router->get('/addpost', [PostsController::class, 'addPost']);
  $app->router->post('/addpost', [PostsController::class, 'addPost']);
  $app->router->get('/editpost', [PostsController::class, 'editPost']);
  $app->router->post('/editpost', [PostsController::class, 'editPost']);
  $app->router->get('/post', [PostsController::class, 'showPost']);

  $app->router->get('/postlist', [PostsController::class, 'postList']);
  $app->router->post('/postlist', [PostsController::class, 'postList']);

  $app->router->get('/users', [UsersController::class, 'usersList']);
  //$app->router->get('/edituser', [UsersController::class, 'editUser']);
  $app->router->post('/edituser', [UsersController::class, 'editUser']);

  $app->router->get('/changelog', [ChangelogController::class, 'showChangelog']);

  $app->run();
