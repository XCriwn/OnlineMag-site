<?php

namespace Http\forms;

use core\ValidationException;

class Login
{
    protected $errors = [];

    public function __construct(public array $attributes)
    {
        if(\core\Validator::email($attributes['email'])){
            $this->errors['email'] = "Please provide a valid email address.";
        }
        if(\core\Validator::notStringMinMax($attributes['password'])){
            $this->errors['password'] = "Please provide a valid password.";
        }
    }

    public static function validate($attributes)
    {
        $instance = new static($attributes);

        return $instance->hasErrors() ? $instance->throw() : $instance;

    }

    public function throw(){
        ValidationException::throw($this->getErrors(), $this->attributes);
    }

    public function hasErrors(){
        return count($this->errors);
    }

    public function getErrors(){
        return $this->errors;
    }

    public function setErrorMessage($field, $message){
        $this->errors[$field] = $message;

        return $this;
    }
}