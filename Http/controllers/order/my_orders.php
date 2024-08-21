<?php

$db = \core\App::resolve(\database\Database::class);

$orders = $db->query("SELECT * FROM `order` WHERE user_id = :user_id AND status != 'INCOMPLETE'",[
    'user_id' => getCurrentUserId()
])->findAll();

authorize(getCurrentUserId() !== NULL); //TODO improve security here

view('order/my_orders.view.php', [
    'header' => 'Your Orders',
    'orders' => $orders
]);