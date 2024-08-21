<?php

$db = \core\App::resolve(\database\Database::class);

if(!isset($_GET) || empty($_GET['order_id'])) redirect('/my_orders');

$orders = $db->query("SELECT o.*, u.id as user_id, u.first_name, u.last_name, u.email, u.country, u.state, u.city, u.street  FROM `order` o JOIN `users` u ON o.user_id = u.id WHERE o.id = :order_id AND o.status != 'INCOMPLETE'",[
    'order_id' => $_GET['order_id']
])->find();

authorize($orders !== false);
authorize(getCurrentUserId() === $orders['user_id'] || getCurrentUserRole() === 'admin');

$product = [];

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
WHERE
    order_products.order_id = :order_id
GROUP BY
    product.id
", [
        'order_id' => $_GET['order_id']
    ])->findAll();


view('order/my_order.view.php', [
    'header' => 'Your Previous Order',
    'orders' => $orders,
    'products' => $product
]);

