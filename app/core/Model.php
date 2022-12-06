<?php

namespace app\core;

abstract class Model
{
  public const RULE_REQUIRED = 'requaired';
  public const RULE_EMAIL = 'email';
  public const RULE_MIN = 'min';
  public const RULE_MAX = 'max';
  public const RULE_MATCH = 'match';
  public const RULE_UNIQUE = 'unique';

  public function loadData($data)
  {
    foreach ($data as $key => $value) {
      if (property_exists($this, $key)) {
        $this->{$key} = $value;
      }
    }
  }

  public function loadDbObjectData(DbModel $dbModel)
  {
    $dbModelFields = get_object_vars($dbModel);

    foreach($dbModelFields as $key => $value)
    {
      if(property_exists($this, $key))
      {
        $this->{$key} = $value;
      }
    }
  }

  abstract public function rules(): array;

  public function labels(): array
  {
    return [];
  }

  public function getLabel($attribute)
  {
    return $this->labels()[$attribute] ?? $attribute;
  }

  public array $errors = [];

  public function hasError($attribute)
  {
    return $this->errors[$attribute] ?? false;
  }

  public function getFirstError($attribute)
  {
    return $this->errors[$attribute][0] ?? false;
  }

}
