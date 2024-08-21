<?php

//find the corresponding note
use core\Validator;
use database\Response;

//authorize the user
authorize(getCurrentUserRole() === 'admin');


$db = \core\App::resolve(\database\Database::class);

$product = $db->query("SELECT 
product.*, 
    GROUP_CONCAT(categories.name SEPARATOR ', ') AS category_names
FROM 
    product
LEFT JOIN 
    product_categories ON product.id = product_categories.product_id
LEFT JOIN 
    categories ON product_categories.category_id = categories.id
WHERE
    product.id = :id",[
    "id" => $_POST['id']
])->findOrFail(Response::NOT_FOUND);

//validate the form
if(Validator::notStringMinMax($_POST['name'], 0, 1000)) {
    $errors['name'] = 'A body of no more than 1000 characters is required.';
}
if(Validator::notStringMinMax($_POST['description'], 0, 1000)) {
    $errors['description'] = 'A body of no more than 1000 characters is required.';
}
if(!Validator::isFloatMinMax($_POST['price'], 0, 999999999)) {
    $errors['price'] = 'Price should be between 0 and 1 million.';
}
if(!Validator::hasMaxDecimals($_POST['price'], 2)) {
    $errors['price'] = 'Price should have no more than 2 decimals.';
}

$selectedCategories = array_map('trim', explode(',', $_POST['selected_categories']));
if (hasDuplicates($selectedCategories)) {
    $errors['selectedCategories'] = "There are duplicate categories.";
}

//if no errors, update the record in the products database table
if($_FILES["image"]["name"] !== "" && empty($errors)) {

    $error = Validator::checkImage();
    if($error === NULL){
        $error = Validator::addImage();
        if($error === NULL){

        destroyImage("select image from product where id = :id", [
            'id' => $_POST['id']
        ]);

        $db->query("update product set image = :image where id = :id", [
            'image' => $_FILES["image"]["name"],
            'id' => $_POST['id']
        ]);

        }
        else{
            $errors['image'] = $error;
        }
    }
    else{
        $errors['image'] = $error;
    }
}


if(!empty($errors)) {

    view('products/edit.view.php', [
        'errors' => $errors,
        'header' => 'Edit Product',
        'product' => $product,
        'categories' => getAllCategories()
    ]);
    die();
}

$db->query("update product set name = :name, description = :description, price = :price where id = :id", [
    'name' => $_POST['name'],
    'description' => $_POST['description'],
    'price' => $_POST['price'],
    'id' => $_POST['id']
]);

destroyCategories($_POST['id']);

// Get category IDs for the selected categories
$category_ids = $db->query("SELECT id FROM categories WHERE name IN (" . implode(',', array_fill(0, count($selectedCategories), '?')) . ")", $selectedCategories)->findAll();

// Insert into product_categories
foreach ($category_ids as $category_id) {
    $db->query("INSERT INTO `product_categories` (`product_id`, `category_id`) VALUES (:product_id, :category_id);", [
        'product_id' => $_POST['id'],
        'category_id' => $category_id['id']
    ]);
}

header("location: /product?id={$product['id']}");
die();