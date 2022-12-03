<?php

  require_once __DIR__.'/../app/vendor/autoload.php';

  use app\core\Application;

  use app\Controllers\SiteController;
  use app\Controllers\AuthController;
  use app\Controllers\UsersController;
  use app\Controllers\ChangelogController;
  use app\Controllers\PostsController;

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

  $app->router->get('/addpost', [PostsController::class, 'addPost']);
  $app->router->post('/addpost', [PostsController::class, 'addPost']);

  $app->router->get('/postlist', [PostsController::class, 'postList']);
  $app->router->post('/postlist', [PostsController::class, 'postList']);

  $app->router->get('/users', [UsersController::class, 'usersList']);
  //$app->router->get('/edituser', [UsersController::class, 'editUser']);
  $app->router->post('/edituser', [UsersController::class, 'editUser']);

  $app->router->get('/changelog', [ChangelogController::class, 'showChangelog']);

  $app->run();

?>
