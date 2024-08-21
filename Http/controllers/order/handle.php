<?php

$db = \core\App::resolve(\database\Database::class);
$order_id = $_POST['order_id'];

$db->query("update `order` set status = 'PENDING' where id = :id AND user_id = :user_id", [
    'id' => $order_id,
    'user_id' => getCurrentUserId()
]);

redirect('/my_orders');
