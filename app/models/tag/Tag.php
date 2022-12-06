<?php

namespace app\models\tag;

use app\core\Model;

class Tag extends Model{

    public string $id;
    public string $name = '';
    public bool $visible = false;

    public function rules(): array
    {
        return [
            'name' => [self::RULE_REQUIRED],
        ];
    }

    public function labels():array
    {
        return [
            'id' => 'ID',
            'name' => 'Nazwa tagu',
            'visible' => 'Czy widoczne?'
        ];
    }
}