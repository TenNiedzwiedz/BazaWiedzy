<?php

namespace app\models\post;

use app\core\Application;
use app\core\DbModel;
use app\models\user\CurrentUser;

class DbPost extends DbModel
{

  public string $id;
  public int $productID;
  public int $categoryID;
  public int $subcategoryID;
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
  public string $verifiedDate;
  public int $verifiedBy;


  public function save(): bool
  {
    $user = new CurrentUser();
    $this->addedBy = $user->id;
    $currentDate = new \DateTime();
    $this->addDate = $currentDate->format('Y-m-d H:i:s');

    return parent::save();
  }

  // public function update($where, $body=[]) : bool
  // {
  //   $postCopy = clone $this;
  //   $this->loadData($body);

  //   if($result = ($this->validate() && parent::update($where)))
  //   {
  //     $this->changelog($postCopy);
  //   }
  //   return $result;
  // }

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
