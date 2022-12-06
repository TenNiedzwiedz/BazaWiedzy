<?php

namespace app\controllers;

use app\core\Controller;
use app\core\Request;
use app\models\favourites\DbFavourite;
use app\models\favourites\Favourite;
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

    public function addFavourite(Request $request)
    {
        $body = $request->getBody();

        if(isset($body['id']))
        {
            if(!DbFavourite::findOne(['userid' => $this->currentUser->id, 'postID' => $body['id']]))
            {
                $favourite = new Favourite();
                $favourite->userID = $this->currentUser->id;
                $favourite->postID = $body['id'];
                $dbFavourite = new DbFavourite();
                $dbFavourite->loadObjectData($favourite);
                $dbFavourite->save();
                return 'Dodano do Fav';
            }
            return 'fav już istnieje';
        }
        return 'brak id';
    }

    public function removeFavourite(Request $request)
    {
        $body = $request->getBody();

        if(isset($body['id']))
        {
            $dbFavourite = DbFavourite::findOne(['userID' => $this->currentUser->id, 'postID' => $body['id']]);
            if($dbFavourite)
            {
                $dbFavourite->userID = '0';
                $dbFavourite->postID = '0';
                if($dbFavourite->update(['id' => $dbFavourite->id]))
                {
                    return 'Usunieto z Fav';
                }
            }
            return 'brak fav do usuniecia';
        }
        return 'brak id';
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

        $postList = [];

        foreach ($dbFavouriteList as $dbFavourite)
        {
            $post = new Post();
            $post->loadDbObjectData(DbPost::findOne(['id' => $dbFavourite->postID]));
            $postList[] = $post;
        }

        usort($postList, 'self::custom_sort');     

        $favouritePostList = [];

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