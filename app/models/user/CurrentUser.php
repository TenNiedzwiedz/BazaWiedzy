<?php

namespace app\models\user;

use app\core\Application;
use app\core\DbModel;

class CurrentUser extends DbModel{

    public string $id;
    public string $userRole;
    public string $firstname;
    public string $lastname;

    public function __construct()
    {
        
        $id = Application::$app->session->get('userID');

        $user = DbUser::findOne(['id' => $id]);

        $this->id = $user->id;
        $this->userRole = $user->userRole;
        $this->firstname = $user->firstname;
        $this->lastname = $user->lastname;
    }

    public function getUsername()
    {
        return $this->firstname.' '.$this->lastname;
    }

    public static function tableName()
    {
        return 'users';
    }

    public function getDbFields()
    {
        return ['userRole', 'firstname', 'lastname'];
    }

    public function getChangelogFields()
    {
        return [];
    }

}