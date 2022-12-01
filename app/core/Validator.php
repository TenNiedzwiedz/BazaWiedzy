<?php

namespace app\core;

class Validator
{
    public function validate(Model $model, ErrorLog $errorLog)
    {
        foreach ($model->rules() as $attribute => $rules) {
            $value = $model->{$attribute};
            foreach ($rules as $rule) {
              $ruleName = $rule;
              if (!is_string($ruleName)) {
                $ruleName = $rule[0];
              }
              if ($ruleName === Rules::RULE_REQUIRED && !$value) {
                $errorLog->addErrorForRule($attribute, Rules::RULE_REQUIRED);
              }
              if ($ruleName === Rules::RULE_EMAIL && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
                $errorLog->addErrorForRule($attribute, Rules::RULE_EMAIL);
              }
              if ($ruleName === Rules::RULE_MIN && strlen($value) < $rule['min']) {
                $errorLog->addErrorForRule($attribute, Rules::RULE_MIN, $rule);
              }
              if ($ruleName === Rules::RULE_MAX && strlen($value) > $rule['max']) {
                $errorLog->addErrorForRule($attribute, Rules::RULE_MAX, $rule);
              }
              if ($ruleName === Rules::RULE_MATCH && $value !== $model->{$rule['match']}) {
                $rule['match'] = $model->getLabel($rule['match']);
                $errorLog->addErrorForRule($attribute, Rules::RULE_MATCH, $rule);
              }
              if ($ruleName === Rules::RULE_UNIQUE) {
                $className = $rule['class'];
                $uniqueAttr = $rule['attribute'] ?? $attribute;
                $tableName = $className::tableName(); //tu się wyjebie
                $statement = Application::$app->db->prepare("SELECT * FROM $tableName WHERE $uniqueAttr = :attr");
                $statement->bindValue(":attr", $value);
                $statement->execute();
                $record = $statement->fetchObject();
                if ($record) {
                  $errorLog->addErrorForRule($attribute, Rules::RULE_UNIQUE, ['field' => $model->getLabel($attribute)]);
                }
              }
            }
        }
    }
}