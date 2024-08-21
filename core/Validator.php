<?php

namespace core;
use function PHPUnit\Framework\isNull;

class Validator{
    public static function notStringMinMax($value, $min = 0, $max = INF): bool
    {
        $value = trim($value);
        return !(strlen($value) > $min && strlen($value) < $max); // returns false if correct
    }

    public static function isFloat($value): bool
    {
        return filter_var($value, FILTER_VALIDATE_FLOAT) !== false;
    }

    public static function isFloatMinMax($value, $min = 0, $max = INF): bool
    {
        $value = trim($value);
        if(!self::isFloat($value)) return false;
        return ($value > $min && $value < $max); // returns false if wrong, true if ok
    }

    public static function hasMaxDecimals($number, $max_decimals): bool
    {
        $parts = explode('.', (string)$number);
        if (count($parts) == 2) {
            return strlen($parts[1]) <= $max_decimals;
        }
        return true;
    }

    public static function email($value): bool
    {
        if(str_contains($value, '@') && strlen($value) > 3) return false;
        else return true;
    }

    public static function hasSpecialChars($value): bool
    {
        if(isNull($value) || $value === ""){return false;}
        return specialChars($value);
    }

    public static function phone_number($value): bool
    {
        return self::notStringMinMax($value, -1, 11) && hasOnlyDigits($value);
    }

    public static function checkImage(): ?string
    {
        if($_FILES["image"]["name"] === "") {
            return 'Please upload an image.';
        }
        $target_dir = "assets/img/";
        $fileInfo = pathinfo($_FILES["image"]["name"]);
        $target_file = $target_dir . $fileInfo['filename'] . time() . "." . $fileInfo['extension'];
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
        $errors['image'] = NULL;

//Check if image file is a actual image or fake image
        if(isset($_POST["submit"])) {
            $check = getimagesize($_FILES["image"]["tmp_name"]);
            if($check === false) {
                $errors['image'] = 'File is not an image';
            }
        }

//Check if file already exists
        if (file_exists($target_file) && $errors['image'] === NULL) {
            $errors['image'] = "Sorry, file already exists.";
        }

//Check file size
        if ($_FILES["image"]["size"] > 1000000 && $errors['image'] === NULL) {
            $errors['image'] = "Sorry, file is too large";
        }

//Check name size
        if (strlen($_FILES["image"]["name"]) > 254 && $errors['image'] === NULL) {
            $errors['image'] = "Sorry, file name is too large";
        }

//Allow certain file formats
        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
            && $imageFileType != "gif" && $errors['image'] === NULL) {
            $errors['image'] = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        }

        return $errors['image'];

// --end of image code--
    }

    public static function addImage(): ?string
    {
        $target_dir = "assets/img/";
        $fileInfo = pathinfo($_FILES["image"]["name"]);
        $target_file = $target_dir . $fileInfo['filename'] . time() . "." . $fileInfo['extension'];
        $target_file_name = $fileInfo['filename'] . time() . "." . $fileInfo['extension'];
        $errors['image'] = NULL;
        // SAVE the image
        if($errors['image'] === NULL) if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            $_FILES["image"]["name"] = $target_file_name;
            return null;
        }
        return $errors['image'] = "Sorry, there was an error uploading your file.";
    }



}