<?php

namespace app\controllers;

use app\core\Application;
use app\core\Controller;
use app\core\ErrorLog;
use app\core\exceptions\DataInvalid;
use app\core\Request;
use app\core\Validator;
use app\models\tag\DbTag;
use app\models\tag\Tag;
use app\models\user\CurrentUser;

class TagsController extends Controller
{
    public CurrentUser $currentUser;
    public ErrorLog $errorLog;
    public Validator $validator;

    public Tag $tag;

    public array $params = [];

    public function __construct()
    {
        $this->currentUser = new CurrentUser();
        $this->errorLog = new ErrorLog();
        $this->validator = new Validator();        

        $this->params['currentUser'] = $this->currentUser;
    }

    public function addTag(Request $request)
    {
        $tag = new Tag();
        $this->params['tag'] =  $tag;

        if($request->isPost()) {
            $body = $request->getBody();

            try {
                $tag->loadData($body);
                $this->validator->validate($tag, $this->errorLog);
            } catch (DataInvalid $e) {
                return $this->return400('addtag', $this->params);
            }

            $dbTag = new DbTag();
            $dbTag->loadObjectData($tag);

            if ($dbTag->save()) {
                Application::$app->session->setFlash('success', 'Tag został dodany');
                Application::$app->response->redirect('/tags');
                exit;
            }
        }
    
        return $this->render('addTag', $this->params);
    }

    public function editTag(Request $request)
    {
        $body = $request->getBody();

        if (!isset($body['id']) || !DbTag::findOne(['id' => $body['id']])) {
            Application::$app->session->setFlash('danger','Nie znaleziono taga');
            Application::$app->response->redirect('/tags');
            exit;
        }

        $tag = new Tag();
        $tag->loadDbObjectData(DbTag::findOne(['id' => $body['id']]));
        $this->params['tag'] =  $tag;

        if($request->isPost()) {
            if(!isset($body['visible'])) {
                $body['visible'] = false;
            }

            $tag->loadData($body);

            try {
                $this->validator->validate($tag, $this->errorLog);
            } catch (DataInvalid $e) {
                return $this->return400('editTag', $this->params);
            }

            $DbTag = new DbTag();
            $DbTag->loadObjectData($tag); //TODO aktualizacja tagów w wszystkich artykułach

            if($DbTag->update(['id' => $tag->id])) {
                Application::$app->session->setFlash('success', 'Zmiany zostały zapisane');
                Application::$app->response->redirect('/tags');
                exit;
            }
        }

        return $this->render('editTag', $this->params);
    }

    public function showTags()
    {
        $DbTagList = DbTag::findAll();

        foreach ($DbTagList as $DbTag) {
            $tag = new Tag();
            $tag->loadDbObjectData($DbTag);
            $tagList[] = $tag;
        }

        $tag = new Tag();
        $this->params['tag'] =  $tag;
        $this->params['tagList'] = $tagList ?? [];

        return $this->render('tagList', $this->params);
    }

}