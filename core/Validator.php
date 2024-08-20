<?php

namespace core;
use function PHPUnit\Framework\isNull;

class Validator{
    public static function notStringMinMax($value, $min = 0, $max = INF): bool
    {
        $value = trim($value);
        return !(strlen($value) > $min && strlen($value) < $max); // returns false if correct
    }

    public static function isFloat($value) {
        return filter_var($value, FILTER_VALIDATE_FLOAT) !== false;
    }

    public static function isFloatMinMax($value, $min = 0, $max = INF): bool
    {
        $value = trim($value);
        if(!self::isFloat($value)) return false;
        return ($value > $min && $value < $max); // returns false if wrong, true if ok
    }

    public static function hasMinMaxNoSpecialChars($value, $min = 0, $max = INF){
        return !(self::hasSpecialChars($value) || self::notStringMinMax($value, $min, $max));
    }

    public static function email($value): bool
    {
        if(str_contains($value, '@') && strlen($value) > 3) return false;
        else return true;
    }

    public static function hasSpecialChars($value){
        if(isNull($value) || $value === ""){return false;}
        return specialChars($value);
    }

    public static function phone_number($value){
        return self::notStringMinMax($value, -1, 11) && hasOnlyDigits($value);
    }

    public static function priceIsValid($value, $min, $max){
        if(str_contains($value, '.')){
            $parts = explode('.', $value);
            $digitsAfterDot = strlen($parts[1]);
            $digitsBeforeDot = strlen($parts[0]);
            if($digitsAfterDot > 2 || $digitsBeforeDot >$max || self::notStringMinMax($value, $min)){
                return false;
            }
        }
        else if(self::notStringMinMax($value, $min, $max)){
            return false;
        }

        return true;
    }

    public static function checkImage(){
        //TODO image code goes here:

        if($_FILES["image"]["name"] === ""){
            return 'Please upload an image.';
        }
        $target_dir = "assets/img/";
        $target_file = $target_dir . basename($_FILES["image"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
        $errors['image'] = NULL;

//TODO Check if image file is a actual image or fake image
        if(isset($_POST["submit"])) {
            $check = getimagesize($_FILES["image"]["tmp_name"]);
            if($check === false) {
                $errors['image'] = 'File is not an image';
            }
        }

//TODO Check if file already exists
        if (file_exists($target_file) && $errors['image'] === NULL) {//TODO here we put errors
            $errors['image'] = "Sorry, file already exists.";
        }

//TODO Check file size
        if ($_FILES["image"]["size"] > 1000000 && $errors['image'] === NULL) {
            $errors['image'] = "Sorry, file is too large";
        }

//TODO Check name size
        if (strlen($_FILES["image"]["name"]) > 254 && $errors['image'] === NULL) {
            $errors['image'] = "Sorry, file name is too large";
        }

//TODO Allow certain file formats
        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
            && $imageFileType != "gif" && $errors['image'] === NULL) {
            $errors['image'] = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        }

        return $errors['image'];

//TODO --end of image code--
    }

    public static function addImage(){
        $target_dir = "assets/img/";
        $target_file = $target_dir . basename($_FILES["image"]["name"]) . time();
        $errors['image'] = NULL;
        // SAVE the image
        if($errors['image'] === NULL) if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            return null;
        }
        return $errors['image'] = "Sorry, there was an error uploading your file.";

    }

}