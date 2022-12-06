<?php

namespace app\models\tag;

use app\core\DbModel;

class DbTag extends DbModel{

    public string $id;
    public string $name;
    public bool $visible;

    public static function tableName()
    {
        return 'tags';
    }

    public function getDbFields()
    {
        return ['name', 'visible'];
    }

    public function getChangelogFields()
    {
        return [];
    }
}