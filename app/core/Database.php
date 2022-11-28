<?php
namespace app\core;

require_once 'Config.php';

class Database
{
  private $dbHost = DB_HOST;
  private $dbUser = DB_USER;
  private $dbPass = DB_PASS;
  private $dbName = DB_NAME;

  public \PDO $pdo;

  public function __construct()
  {
    $dsn = 'mysql:host=' . $this->dbHost . ';dbname=' . $this->dbName;

    $this->pdo = new \PDO($dsn, $this->dbUser, $this->dbPass);
    $this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
  }

  public function prepare($sql)
  {
    return $this->pdo->prepare($sql);
  }

}
