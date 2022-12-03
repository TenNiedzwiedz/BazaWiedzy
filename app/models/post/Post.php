<?php

  namespace app\models\post;

  use app\core\Application;
  use app\core\Model;

  class Post extends Model{

    public string $id;
    public int $productID = 0;
    public int $categoryID = 0;
    public int $subcategoryID = 0;
    public string $title = '';
    public string $remarks = '';
    public string $content = '';
    public string $tags = '';
    public int $addedBy;
    public string $addDate;
    public bool $accepted = false;
    public bool $visible = true;
    public int $views = 0;
    public bool $verified = false;
    public string $verifiedDate;
    public int $verifiedBy;


    public function rules(): array
    {
      return [
        'productID' => [self::RULE_REQUIRED],
        'categoryID' => [self::RULE_REQUIRED],
        'title' => [self::RULE_REQUIRED],
        'remarks' => [self::RULE_REQUIRED],
        'content' => [self::RULE_REQUIRED],
        'tags' => [self::RULE_REQUIRED],
      ];
    }

    public function labels(): array
    {
      return [
        'id' => 'ID',
        'productID' => 'Produkt',
        'categoryID' => 'Kategoria',
        'subcategoryID' => 'Podkategoria',
        'title' => 'Tytuł',
        'remarks' => 'Uwagi',
        'content' => 'Odpowiedź dla użytkownika',
        'tags' => 'Tagi',
        'addedBy' => 'Dodane przez',
        'addDate' => 'Data dodania',
        'views' => 'Wyśw.'
        ];
    }

  }
