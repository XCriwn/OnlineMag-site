<?php
//todo this is for taking items out of the cart

use core\Validator;

require base_path('core/Validator.php');

$db = \core\App::resolve(\database\Database::class);



$product_count = $db->query("SELECT p.product_count, o.user_id FROM `order_products` p JOIN `order` o ON p.order_id = o.id WHERE order_id = :order_id AND product_id = :product_id", [
    "product_id" => $_POST['id'],
    "order_id" => $_POST['order_id']
])->find();

authorize(getCurrentUserId() === $product_count['user_id']);

justDump( $product_count['product_count']);

if($product_count['product_count'] - $_POST['quantity'] > 0) {
    //todo we need product_id, order_id, the count from form
    $db->query("UPDATE `order_products` SET `product_count` = :product_count WHERE product_id = :product_id AND order_id = :order_id", [
        "product_count" => $product_count['product_count'] - $_POST['quantity'],
        "product_id" => $_POST['id'],
        "order_id" => $_POST['order_id']
    ]);
}
else{
    $db->query("DELETE FROM `order_products` WHERE product_id = :product_id AND order_id = :order_id", [
        "product_id" => $_POST['id'],
        "order_id" => $_POST['order_id']
    ]);
}

redirect('/cart'); //todo smth better?
