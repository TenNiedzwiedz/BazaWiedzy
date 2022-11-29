<?php

  namespace app\models;

  use app\core\Application;
  use app\core\DbModel;

  class Post extends DbModel{

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

    public function save()
    {
      $user = User::getCurrentUser();
      $this->addedBy = $user->id;
      $currentDate = new \DateTime();
      $this->addDate = $currentDate->format('Y-m-d H:i:s');

      return parent::save();
    }

    public function update($where, $body=[])
    {
      $postCopy = clone $this;
      $this->loadData($body);

      if($result = ($this->validate() && parent::update($where)))
      {
        $this->changelog($postCopy);
      }
      return $result;
    }

    public static function tableName()
    {
      return 'posts';
    }

    public function getDbFields()
    {
      return ['productID', 'categoryID', 'subcategoryID', 'title', 'remarks', 'content', 'tags', 'addedBy', 'addDate'];
    }

    public function getChangelogFields()
    {
      return ['productID', 'categoryID', 'subcategoryID', 'title', 'remarks', 'content', 'tags'];
    }


  }
