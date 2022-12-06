<?php

namespace app\models\changelog;

use app\core\DbModel;

class DbChangelog extends DbModel
{
    public string $id;
    public string $objectID;
    public string $fieldName;
    public string $oldValue;
    public string $newValue;
    public string $userID;
    public string $date;

    public static function tableName() //TODO Osobną klasę abstrakcyjną DBModelReadOnly bez tych funkcji i zapisu
    {
        return false;
    }

    public function getDbFields()
    {
        return false;
    }

    public function getChangelogFields()
    {
        return false;
    }
}