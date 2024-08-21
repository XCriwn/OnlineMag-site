<?php

authorize(getCurrentUserRole() === 'admin');

$db = \core\App::resolve(\database\Database::class);

$db->query("UPDATE `order` SET status = :status WHERE id = :order_id",[
    'status' => $_POST['status'],
    'order_id' => $_POST['order_id']
]);

$orders = $db->query("SELECT o.*, u.first_name, u.last_name, u.email, u.country, u.state, u.city, u.street FROM `order` o JOIN `users` u ON o.user_id = u.id WHERE o.status = 'PENDING' OR o.status = 'CANCELLED' OR o.status = 'COMPLETED'")->findAll();

view('order/manage.view.php', [
    'header' => 'Manage Orders',
    'orders' => $orders
]);