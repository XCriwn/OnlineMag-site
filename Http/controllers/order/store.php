<?php

use core\Validator;
use database\Response;

require base_path('core/Validator.php');

$db = \core\App::resolve(\database\Database::class);

$errors = [];

//authorize the user
authorize(getCurrentUserId() !== null);

if(!Validator::isPositiveInteger($_POST['quantity'], 0, 999999999)) {
    $errors['quantity'] = 'Quantity should be between 0 and 1 million.';
}

if(!empty($errors)) {

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
    product.id = :id
GROUP BY 
    product.id;", [
        'id'=>$_POST['id']
    ])->findOrFail(Response::NOT_FOUND);

    view('products/show.view.php', [
        'product' => $product,
        'header' => 'Product',
        'errors' => $errors
    ]);
    die();
}

$order_id = getCurrentOrderId();

if($order_id === false) {
    createNewOrderId();
    $order_id = getCurrentOrderId();
}

$status = $db->query("SELECT status FROM `order` WHERE id = :order_id", [
    "order_id" => $order_id['id']
])->find();

if($status !== "INCOMPLETE") {
    createNewOrderId();
    $order_id = getCurrentOrderId();
}

$item_exists = $db->query("SELECT product_count FROM `order_products` WHERE order_id = :order_id AND product_id = :product_id", [
    "product_id" => $_POST['id'],
    "order_id" => $order_id['id']
])->find();

if($item_exists) {
    $db->query("UPDATE `order_products` SET `product_count` = :product_count WHERE product_id = :product_id AND order_id = :order_id", [
        "product_count" => $item_exists['product_count'] + $_POST["quantity"],
        "product_id" => $_POST['id'],
        "order_id" => $order_id['id']
    ]);
}
else {
    $db->query("INSERT INTO `order_products` (`product_id`, `order_id`, `product_count`) VALUES (:product_id, :order_id, :product_count)", [
        "product_count" => $_POST["quantity"],
        "product_id" => $_POST['id'],
        "order_id" => $order_id['id']
    ]);
}

redirect('/product?id=' . $_POST['id']);