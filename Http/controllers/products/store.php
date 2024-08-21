<?php

use core\Validator;

require base_path('core/Validator.php');
$db = \core\App::resolve(\database\Database::class);

$errors = [];

authorize(getCurrentUserRole() === 'admin');

if(Validator::notStringMinMax($_POST['name'], 0, 1000)) {
    $errors['name'] = 'A body of no more than 1000 characters is required.';
}
if(Validator::notStringMinMax($_POST['description'], 0, 1000)) {
    $errors['description'] = 'A body of no more than 1000 characters is required.';
}
if(!Validator::isFloatMinMax($_POST['price'], 0, 999999999)) {
    $errors['price'] = 'A price of no more than 1 million is required.';
}
if(!Validator::hasMaxDecimals($_POST['price'], 2)) {
    $errors['price'] = 'Price should have no more than 2 decimals.';
}

$selectedCategories = array_map('trim', explode(',', $_POST['selected_categories']));
if (hasDuplicates($selectedCategories)) {
    $errors['selectedCategories'] = "There are duplicate categories.";
}

$error = NULL;

if(empty($errors)) {
    $error = Validator::checkImage();
    if($error !== NULL){
        $errors['image'] = $error;
    }else{
        $error = Validator::addImage();
        if($error !== NULL){
            $errors['image'] = $error;
        }
    }
}

if(!empty($errors)){
    view('products/create.view.php', [
        'errors' => $errors,
        'header' => 'Create New Product',
        'categories' => getAllCategories()
    ]);
    die();
}

$db->query("INSERT INTO `product` (`name`, `description`, `price`, `image`) VALUES (
:name, :description, :price, :image
);", [
    'name' => $_POST['name'],
    'description' => $_POST['description'],
    'price' => $_POST['price'],
    'image' => htmlspecialchars( basename( $_FILES["image"]["name"]))
]);

$product = $db->query("SELECT `id` FROM `product` WHERE `name` = :name AND `description` = :description AND `price` = :price AND `image` = :image", [
    'name' => $_POST['name'],
    'description' => $_POST['description'],
    'price' => $_POST['price'],
    'image' => htmlspecialchars(basename($_FILES["image"]["name"]))
])->find();

$product_id = $product['id'];

// Get category IDs for the selected categories
$category_ids = $db->query("SELECT id FROM categories WHERE name IN (" . implode(',', array_fill(0, count($selectedCategories), '?')) . ")", $selectedCategories)->findAll();

// Insert into product_categories
foreach ($category_ids as $category_id) {
    $db->query("INSERT INTO `product_categories` (`product_id`, `category_id`) VALUES (:product_id, :category_id);", [
        'product_id' => $product_id,
        'category_id' => $category_id['id']
    ]);
}


header('location: /products');
die();
