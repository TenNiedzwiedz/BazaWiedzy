<?php

namespace app\models\favourites;

use app\core\DbModel;

class DbFavourite extends DbModel
{
    public string $id;
    public string $userID;
    public string $postID;

    public static function tableName()
    {
        return 'favourites';
    }

    public function getDbFields()
    {
        return ['userID', 'postID'];
    }

    public function getChangelogFields()
    {
        return false;
    }
}