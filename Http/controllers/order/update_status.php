<?php

authorize(getCurrentUserRole() === 'admin');

$db = \core\App::resolve(\database\Database::class);

$db->query("UPDATE `order` SET status = :status WHERE id = :order_id",[
    'status' => $_POST['status'],
    'order_id' => $_POST['order_id']
]);

$orders = $db->query("SELECT * FROM `order` WHERE status = 'PENDING' OR status = 'CANCELLED' OR status = 'COMPLETED'")->findAll();

view('order/manage.view.php', [
    'header' => 'Manage Orders',
    'orders' => $orders
]);