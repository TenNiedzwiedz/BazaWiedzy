<?php

namespace app\models\post;

use app\core\Application;
use app\core\DbModel;
use app\core\Model;
use app\models\user\CurrentUser;

class DbPost extends DbModel
{

  public string $id;
  public string $title;
  public string $remarks;
  public string $content;
  public string $tags;
  public int $addedBy;
  public string $addDate;
  public bool $accepted = false;
  public bool $visible = true;
  public int $views = 0;
  public bool $verified = false;
  public string $verifiedDate = '0000-00-00 00:00:00';
  public int $verifiedBy = 0;

  public function loadObjectData(Model $model)
  {
    parent::loadObjectData($model);
    $this->tags = str_replace('&#34;', '"', $this->tags);
  }

  public function save(): bool
  {
    $user = new CurrentUser();
    $this->addedBy = $user->id;
    $currentDate = new \DateTime();
    $this->addDate = $currentDate->format('Y-m-d H:i:s');

    return parent::save();
  }

  public static function tableName()
  {
    return 'posts';
  }

  public function getDbFields()
  {
    return [ 'title', 'remarks', 'content', 'tags', 'addedBy', 'addDate', 'views', 'verified', 'verifiedDate', 'verifiedBy'];
  }

  public function getChangelogFields()
  {
    return ['title', 'remarks', 'content', 'tags', 'verifiedDate'];
  }
}
