<?php

namespace app\core;

use app\core\exceptions\DataInvalid;

class ModelWrapper
{
    public DbModel $dbModel;
    public Model $model;
    public ErrorLog $errorLog;
    public Validator $validator;

    public function __construct($modelClass, $dbModelClass = false)
    {
        $this->errorLog = new ErrorLog();
        $this->validator = new Validator();

        $this->model = new $modelClass($this->errorLog);
        if($dbModelClass)
        {
            $this->dbModel = new $dbModelClass();
        }
    }

    public function validate()
    {
        $this->validator->validate($this->model, $this->errorLog);
        if(!empty($this->errorLog->errors))
        {
            $this->model->errors = $this->errorLog->errors;
            throw new DataInvalid("Data faild validation");
        }
    }

    public function save(array $body)
    {
        $this->model->loadData($body);
        $this->validate();
    }
}