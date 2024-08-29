<?php
use core\Validator;
use database\Response;

require base_path('core/Validator.php');

$db = \core\App::resolve(\database\Database::class);

$product_count = $db->query("SELECT p.product_count, o.user_id FROM `order_products` p JOIN `order` o ON p.order_id = o.id WHERE order_id = :order_id AND product_id = :product_id", [
    "product_id" => $_POST['id'],
    "order_id" => $_POST['order_id']
])->find();

authorize(getCurrentUserId() === $product_count['user_id']);

if(!Validator::isPositiveInteger($_POST['quantity'])) {
    $errors['quantity'] = 'Quantity should an integer higher than 0.';
}

if(!empty($errors)) {

    $order_id = getCurrentOrderId();

    if($order_id !== false) {

        $product = $db->query("SELECT 
    product.*, 
    GROUP_CONCAT(DISTINCT categories.name SEPARATOR ', ') AS category_names,
    ANY_VALUE(order_products.product_count) AS item_count
FROM 
    product
LEFT JOIN 
    product_categories ON product.id = product_categories.product_id
LEFT JOIN 
    categories ON product_categories.category_id = categories.id
JOIN
    order_products ON product.id = order_products.product_id
JOIN
    `order` ON order_products.order_id = `order`.id
WHERE 
    order_products.order_id = :order_id AND `order`.status = 'INCOMPLETE'
GROUP BY
    product.id
", [
            'order_id' => $order_id['id']
        ])->findAll();
    }
    else{
        $product = [];
    }

    view('order/show.view.php', [
        'header' => 'Your Cart',
        'products' => $product,
        'order_id' => $order_id,
        'errors' => $errors
    ]);
    die();
}

//justDump( $product_count['product_count']);

if($product_count['product_count'] - $_POST['quantity'] > 0) {
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

redirect('/cart');
