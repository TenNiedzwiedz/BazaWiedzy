<?php

namespace app\models\favourites\userFavourites;

use app\core\Model;

class UserFavourites extends Model
{
    public string $id;
    public string $favouriteTags = ' ';

    public function rules(): array
    {
        return [];
    }
}