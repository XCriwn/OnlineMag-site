<?php

$db = \core\App::resolve(\database\Database::class);

$order_id = getCurrentOrderId();

if($order_id === false) {
    createNewOrderId();
    $order_id = getCurrentOrderId();
}

$status = $db->query("SELECT user_id, status FROM `order` WHERE id = :order_id", [
    "order_id" => $order_id['id']
])->find();

authorize($status['user_id'] === getCurrentUserId());

if($status !== "INCOMPLETE") {
    createNewOrderId();
    $order_id = getCurrentOrderId();
}

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
    'order_id' => $order_id
]);