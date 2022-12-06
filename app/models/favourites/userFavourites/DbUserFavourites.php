<?php

namespace app\models\favourites\userFavourites;

use app\core\DbModel;

class DbUserFavourites extends DbModel
{
    public string $id;
    public string $favouriteTags;

    public static function tableName()
    {
        return 'userfavourites';
    }

    public function getDbFields()
    {
        return ['id', 'favouriteTags'];
    }

    public function getChangelogFields()
    {
        return false;
    }
}