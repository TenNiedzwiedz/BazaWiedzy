<?php

  namespace app\core;

  class Application {

    public Request $request;
    public Router $router;
    public Response $response;
    public View $view;

    public Database $db;
    public Session $session;

    public static string $ROOT_DIR;
    public static Application $app;

    public string $layout = 'guest';

    public function __construct($rootPath)
    {
      self::$ROOT_DIR = $rootPath;
      self::$app = $this;

      $this->request = new Request();
      $this->response = new Response();
      $this->view = new View();

      $this->db = new Database();
      $this->session = new Session();

      $this->isGuest();

      $this->router = new Router($this->request, $this->response, $this->view);
    }

    public function isGuest()
    {
      if (!$this->session->get('userID') && $this->request->getPath() != '/login')
      {
        $this->response->redirect('/login');
        exit;
      }
    }

    public function run()
    {
      try {
        echo $this->router->resolve();
      } catch (\Exception $e) {
        $this->response->setStatusCode($e->getCode());
        echo $this->view->renderView('_error', [
          'exception' => $e
        ]);
      }
    }

  }

?>
