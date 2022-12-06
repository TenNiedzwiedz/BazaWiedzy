<?php

namespace app\models\favourites;

use app\core\Model;

class Favourite extends Model
{
    public string $id;
    public string $userID;
    public string $postID;

    public function rules(): array
    {
        return [];
    }
}