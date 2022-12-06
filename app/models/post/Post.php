<?php

  namespace app\models\post;

  use app\core\Application;
use app\core\DbModel;
use app\core\Model;

  class Post extends Model{

    public string $id;
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

    public function loadData($data)
    {
      parent::loadData($data);
      $this->tags = str_replace('"', '&#34;', $this->tags);
    }

    public function loadDbObjectData(DbModel $dbModel)
    {
      parent::loadDbObjectData($dbModel);
      $this->tags = str_replace('"', '&#34;', $this->tags);
    }

    public function rules(): array
    {
      return [
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
