<?php

namespace app\controllers;

use app\core\Controller;
use app\models\favourites\DbFavourite;
use app\models\favourites\userFavourites\DbUserFavourites;
use app\models\favourites\userFavourites\UserFavourites;
use app\models\post\DbPost;
use app\models\post\Post;
use app\models\user\CurrentUser;

class FavouritesController extends Controller
{
    public CurrentUser $currentUser;

    public array $params = [];

    public function __construct()
    {
        $this->currentUser = new CurrentUser();

        $this->params['currentUser'] = $this->currentUser;
    }

    public function showFavourites()
    {
        if(!DbUserFavourites::findOne(['id' => $this->currentUser->id])) {
            $userFavourites = new UserFavourites();
            $userFavourites->id = $this->currentUser->id;
            $DbUserFavourites = new DbUserFavourites();
            $DbUserFavourites->loadObjectData($userFavourites);
            $DbUserFavourites->save();
        }

        $dbUserFavourites = DbUserFavourites::findOne(['id' => $this->currentUser->id]);
        $favouriteTags = json_decode($dbUserFavourites->favouriteTags) ?? [];
        $this->params['favouriteTags'] = $favouriteTags;

        $dbFavouriteList = DbFavourite::findAll(['userID' => $this->currentUser->id]); 

        foreach ($dbFavouriteList as $dbFavourite)
        {
            $post = new Post();
            $post->loadDbObjectData(DbPost::findOne(['id' => $dbFavourite->postID]));
            $postList[] = $post;
        }

        usort($postList, 'self::custom_sort');     

        foreach ($favouriteTags as $favouriteTag)
        {
            foreach ($postList as $post)
            {
                if(str_contains($post->tags, $favouriteTag->value)) {
                    $favouritePostList[$favouriteTag->value][] = $post;
                }
            }
        }

        $this->params['postList'] = $postList;
        $this->params['favouritePostList'] = $favouritePostList;

        return $this->render('showFavourites', $this->params);
    }

    function custom_sort($a,$b) {
        return $a->id > $b->id;
    }

}