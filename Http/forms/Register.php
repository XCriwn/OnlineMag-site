<?php

namespace Http\forms;

use core\ValidationException;

class Register
{
    protected $errors = [];

    public function __construct(public array $attributes)
    {
        if(\core\Validator::notStringMinMax($attributes['first_name'])){
            $this->errors['password'] = "Please provide a valid first name.";
        }
        if(\core\Validator::notStringMinMax($attributes['last_name'])){
            $this->errors['password'] = "Please provide a valid last name.";
        }
        if(\core\Validator::email($attributes['email'])){
            $this->errors['email'] = "Please provide a valid email address.";
        }
        if(\core\Validator::notStringMinMax($attributes['password'])){
            $this->errors['password'] = "Please provide a valid password.";
        }
        if(\core\Validator::hasSpecialChars($attributes['address_country'])){
            $this->errors['address_country'] = "Please provide a valid country.";
        }
        if(\core\Validator::hasSpecialChars($attributes['address_state'])){
            $this->errors['address_state'] = "Please provide a valid state.";
        }
        if(\core\Validator::hasSpecialChars($attributes['address_city'])){
            $this->errors['address_city'] = "Please provide a valid city.";
        }
//        if(\core\Validator::hasSpecialChars($attributes['address_street'])){
//            $this->errors['address_street'] = "Please provide a valid street.";
//        }
        if(\core\Validator::phone_number($attributes['phone_number'])){
            $this->errors['phone_number'] = "Please provide a valid phone number.";
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