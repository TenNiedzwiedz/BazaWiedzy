<?php

namespace app\core;

class ErrorLog
{
    public array $errors = [];

    public function addError(string $attribute, string $message)
    {
        $this->errors[$attribute][] = $message;
    }

    public function addErrorForRule(string $attribute, string $rule, $params = [])
    {
        $message = $this->errorMessages()[$rule] ?? '';

        foreach ($params as $key => $value) {
            $message = str_replace("{{$key}}", $value, $message);
        }

        $this->errors[$attribute][] = $message;
    }

    public function errorMessages()
    {
        return [
            Rules::RULE_REQUIRED => 'Te pole jest wymagane',
            Rules::RULE_EMAIL => 'Wprowadzono niepoprawny adres email',
            Rules::RULE_MIN => 'Minimalna długość tego pola wynosi {min}',
            Rules::RULE_MAX => 'Maksymalna długość tego pola wynosi {max}',
            Rules::RULE_MATCH => 'Wpisana wartość jest różna od pola {match}',
            Rules::RULE_UNIQUE => 'Taki {field} już istnieje',
        ];
    }

    public function hasError($attribute)
    {
        return $this->errors[$attribute] ?? false;
    }

    public function getFirstError($attribute)
    {
        return $this->errors[$attribute][0] ?? false;
    }
}
