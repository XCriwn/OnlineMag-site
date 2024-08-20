<?php

use core\Validator;

require base_path('core/Validator.php');

$db = \core\App::resolve(\database\Database::class);

$errors = [];

//authorize the user
authorize(getCurrentUserId() !== null);

$order_id = getCurrentOrderId();

//todo if order does not exist, then we create a new order for that user_id

//TODO check if the current $order_id is pointing towards an order that isn't INCOMPLETE anymore
//todo if so, then create a new order and take the new order id

if($order_id === false) {
    createNewOrderId();
    $order_id = getCurrentOrderId();
}

$status = $db->query("SELECT status FROM `order` WHERE id = :order_id", [
    "order_id" => $order_id['id']
])->find();

if($status !== "INCOMPLETE"){
    createNewOrderId();
    $order_id = getCurrentOrderId();
}

$item_exists = $db->query("SELECT product_count FROM `order_products` WHERE order_id = :order_id AND product_id = :product_id", [
    "product_id" => $_POST['id'],
    "order_id" => $order_id['id']
])->find();

if($item_exists){
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