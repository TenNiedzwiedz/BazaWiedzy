<?php

namespace app\core;

use app\core\Application;

abstract class DbModel
{

  public string $id;

  public function loadObjectData(Model $model)
  {
    $modelFields = get_object_vars($model);

    foreach($modelFields as $key => $value)
    {
      if(property_exists($this, $key))
      {
        $this->{$key} = $value;
      }
    }
  }

  /**
   * Saves object in DB based on fields defined in getDbFields().
   * 
   * @return bool
   */
  public function save(): bool
  {
    $tableName = $this->tableName();
    $attributes = $this->getDbFields();
    $params = array_map(fn ($attr) => ":$attr", $attributes);
    $statement = self::prepare("INSERT INTO $tableName (" . implode(',', $attributes) . ") VALUES (" . implode(',', $params) . ")");

    foreach ($attributes as $attribute) {
      $statement->bindValue(":$attribute", $this->{$attribute});
    }

    $statement->execute();
    return true;
  }

  /**
   * Updates object in DB.
   * 
   * @param array $where
   * @param array $body
   * 
   * @return bool
   */
  public function update(array $where, array $body = []): bool
  {
    $tableName = $this->tableName();
    $attributes = $this->getDbFields();
    $params = array_map(fn ($attr) => "$attr = :$attr", $attributes);
    $attributes = array_merge($attributes, array_keys($where));

    $sql = implode(" AND ", array_map(fn ($attr) => "$attr = :$attr", array_keys($where)));

    $statement = self::prepare("UPDATE $tableName SET " . implode(', ', $params) . " WHERE $sql");

    foreach ($attributes as $attribute) {
      $statement->bindValue(":$attribute", $this->{$attribute});
    }

    $result = $statement->execute();
    return $result;
  }

  /**
   * Finds object in DB
   * 
   * @param array $where
   * 
   * @return mixed
   */
  public static function findOne($where)
  {
    $tableName = static::tableName();
    
    $attributes = array_keys($where);
    $sql = implode(" AND ", array_map(fn ($attr) => "$attr = :$attr", $attributes));
    $statement = self::prepare("SELECT * FROM $tableName WHERE $sql");
    foreach ($where as $key => $value) {
      $statement->bindValue(":$key", $value);
    }

    $statement->execute();
 
    return $statement->fetchObject(static::class);
  }

  public static function findAll($where = [], $tableName = false)
  {
    if (!$tableName) {
      $tableName = static::tableName();
    }

    $sql = '';

    if (!empty($where)) {
      $attributes = array_keys($where);
      $sql = " WHERE " . implode(" AND ", array_map(fn ($attr) => "$attr = :$attr", $attributes));
    }

    $statement = self::prepare("SELECT * FROM $tableName" . $sql);

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

    $tableName = $this->tableName() . 'changes';
    $userID = Application::$app->session->get('userID');

    foreach ($dbFields as $field) {
      if ($objectCopy->{$field} != $this->{$field}) {
        $sql = "INSERT INTO $tableName (objectID, fieldName, oldValue, newValue, userID) VALUES ('" . $this->id . "', '" . $field . "', '" . $objectCopy->{$field} . "', '" . $this->{$field} . "', " . $userID . ")";

        $statement = $this->prepare($sql);
        $statement->execute();
      }
    }
  }

  abstract public static function tableName();

  abstract public function getDbFields();

  abstract public function getChangelogFields();
}
