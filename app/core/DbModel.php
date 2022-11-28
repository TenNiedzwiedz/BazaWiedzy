<?php

  namespace app\core;

  use app\core\Application;

  abstract class DbModel extends Model
  {

    public string $id;

    public function save()
    {
      $tableName = $this->tableName();
      $attributes = $this->getDbFields();
      $params = array_map(fn($attr) => ":$attr", $attributes);
      $statement = self::prepare("INSERT INTO $tableName (".implode(',', $attributes).") VALUES (".implode(',', $params).")");

      foreach ($attributes as $attribute) {
        $statement->bindValue(":$attribute", $this->{$attribute});
      }

      $statement->execute();
      return true;
    }

    public function update($where, $body=[])
    {
      $tableName = $this->tableName();
      $attributes = $this->getDbFields();
      $params = array_map(fn($attr) => "$attr = :$attr", $attributes);
      $attributes = array_merge($attributes, array_keys($where));

      $sql = implode(" AND ", array_map(fn($attr) => "$attr = :$attr", array_keys($where)));

      $statement = self::prepare("UPDATE $tableName SET ".implode(', ', $params)." WHERE $sql");

      foreach ($attributes as $attribute) {
        $statement->bindValue(":$attribute", $this->{$attribute});
      }

      $statement->execute();
      return true;
    }

    public static function findOne($where)
    {
      $tableName = static::tableName();

      $attributes = array_keys($where);
      $sql = implode(" AND ", array_map(fn($attr) => "$attr = :$attr", $attributes));
      $statement = self::prepare("SELECT * FROM $tableName WHERE $sql");
      foreach ($where as $key => $value) {
        $statement->bindValue(":$key", $value);
      }

      $statement->execute();

      return $statement->fetchObject(static::class);
    }

    public static function findAll($where = [], $tableName = false)
    {
      if(!$tableName)
      {
        $tableName = static::tableName();
      }

      $sql = '';

      if(!empty($where))
      {
        $attributes = array_keys($where);
        $sql = " WHERE ".implode(" AND ", array_map(fn($attr) => "$attr = :$attr", $attributes));
      }

      $statement = self::prepare("SELECT * FROM $tableName".$sql);

      foreach ($where as $key => $value) {
        $statement->bindValue(":$key", $value);
      }

      $statement->execute();

      return $statement->fetchAll(\PDO::FETCH_CLASS, static::class);
    }

    public static function prepare($sql)
    {
      return Application::$app->db->pdo->prepare($sql);
    }

    public function changelog(DbModel $objectCopy)
    {
      $dbFields = $this->getChangelogFields();

      $tableName = $this->tableName().'changes';
      $userID = Application::$app->session->get('userID');

      foreach($dbFields as $field) {
        if($objectCopy->{$field} != $this->{$field})
        {
          $sql = "INSERT INTO $tableName (objectID, fieldName, oldValue, newValue, userID) VALUES ('".$this->id."', '".$field."', '".$objectCopy->{$field}."', '".$this->{$field}."', ".$userID.")";

          $statement = $this->prepare($sql);
          $statement->execute();
        }
      }
    }

    abstract public static function tableName();

    abstract public function getDbFields();

    abstract public function getChangelogFields();

  }
