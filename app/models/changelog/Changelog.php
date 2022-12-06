<?php

namespace app\models\changelog;

use app\core\DbModel;
use app\core\Model;

class Changelog extends Model
{
    public string $id;
    public string $objectID;
    public string $fieldName;
    public string $oldValue;
    public string $newValue;
    public string $userID;
    public string $date;

    public function loadDbObjectData(DbModel $dbModel)
    {
        $dbModelFields = get_object_vars($dbModel);

        foreach($dbModelFields as $key => $value)
        {
          if(property_exists($this, $key))
          {
            $this->{$key} = htmlspecialchars($value);
          }
        }
    }

    public function rules(): array
    {
        return [];
    }

    public function labels(): array
    {
      return [
        'id' => 'ID',
        'fieldName' => 'Nazwa pola',
        'oldValue' => 'Poprzednia wartość',
        'newValue' => 'Nowa wartość',
        'userID' => 'ID użytkownika',
        'date' => 'Data i godzina zmiany'
      ];
    }

}