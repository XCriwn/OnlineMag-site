<?php
//todo write here code to get all products currently in the cart
//todo if there's none, we should put a text saying there are none in view

$db = \core\App::resolve(\database\Database::class);
//todo we create a check / create for order id

$order_id = getCurrentOrderId();//dd($order_id);//TODO WHEN CURRENT ORDER ID DOESNT EXIST WHAT THEN??

//TODO check if the current $order_id is pointing towards an order that isn't INCOMPLETE anymore
//todo if so, then create a new order and take the new order id

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