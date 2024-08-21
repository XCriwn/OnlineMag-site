<?php

use database\Response;
use core\Session;


    function justDump($value){
    echo "<pre>";
    var_dump($value);
    echo "</pre>";
    }

    function dd($value){
        justDump($value);
        die();
    }

    function urlIs($value){
        return $_SERVER["REQUEST_URI"] === $value;
    }

    function abort($code = 404){
        http_response_code($code);
        view("status_codes/{$code}.php");
        die();
    }

    function authorize($condition){
        if(!$condition){
            abort(Response::FORBIDDEN);
        }
    }

    function specialChars($str) {
        return preg_match('/[^a-zA-Z0-9]/', $str) > 0;
    }

function hasOnlyDigits($str){
    // Return true if string is null or empty
    if (is_null($str) || $str === '') {
        return true;
    }
    // Check if the string contains only digits
    return preg_match('/^\d*$/', $str) === 1;
}

    function base_path($path) {
        return BASE_PATH . $path;
    }

    function view($path, $attributes = []) {
        extract($attributes);

        require base_path('views/' . $path);
    }

    function viewAndExit($path, $attributes = [])
    {
        extract($attributes);

        require base_path('views/' . $path);
        exit();
    }

    function redirect($path) {
        header("location: {$path}");
        exit();
    }

    function old($key, $default = '') {
        return \core\Session::get('old')[$key] ?? $default ;
    }

    function login($attributes = []) {
        \core\Authenticator::login($attributes);
    }

    function getCurrentUserId() {
        return $_SESSION['user']['id'] ?? NULL;
    }

    function getCurrentUserRole() {
        return $_SESSION['user']['role'] ?? NULL;
    }

    function getImage($value) {
        if(file_exists("assets/img/" . $value)){
            return "/assets/img/" . $value;
        }
        return "/assets/img/unknown.png";
    }

    function destroyImage($query, $attributes) {
        $db = \core\App::resolve(\database\Database::class);

        $image_pointer = $db->query($query, $attributes)->find();

        if (!unlink("assets/img/" . $image_pointer["image"])) {
            return false;
        }
        return true;

    }

    function destroyCategories($id) {
        $db = \core\App::resolve(\database\Database::class);
        //delete everything related with our product's id from product_category
        $db->query("DELETE FROM product_categories WHERE product_id = :product_id", [
            'product_id' => $_POST['id']
        ]);
    }

    function getAllCategories() {
        $db = \core\App::resolve(\database\Database::class);

        return $db -> query("select id,name from categories")->findAll();
    }

    function createNewOrderId(): bool
    {
        $db = \core\App::resolve(\database\Database::class);
        if(getCurrentOrderId() !== false){
            return false;
        }
        $db->query("INSERT INTO `order` (`user_id`, `status`) VALUES (:user_id, 'INCOMPLETE')", [
            "user_id" => getCurrentUserId()
        ]);
        return true;
    }

    function getCurrentOrderId() {
        $db = \core\App::resolve(\database\Database::class);
        return $db->query("SELECT id FROM `order` WHERE user_id = :user_id AND status = 'INCOMPLETE'", [
            'user_id' => getCurrentUserId()
        ])->find() ?? false;
    }
//    function getCurrentOrderStatus(){
//        $db = \core\App::resolve(\database\Database::class);
//        //TODO
//    }

function hasDuplicates($array) {
    $counts = array_count_values($array);
    foreach ($counts as $count) {
        if ($count > 1) {
            return true;
        }
    }
    return false;
}

