<?php
//todo manage orders as the admin

authorize(getCurrentUserRole() === 'admin');

$db = \core\App::resolve(\database\Database::class);

$query = "SELECT * FROM `order` WHERE ";
$parameters = [];

if(!empty($_POST) && $_POST['filter'] !== "0"){

    $query = $query . "status = :status";
    $parameters['status'] = $_POST['filter'];
}
else{
    $query = $query . "status = 'PENDING' OR status = 'CANCELLED' OR status = 'COMPLETED'";
}


$orders = $db->query($query, $parameters)->findAll();

view('order/manage.view.php', [
    'header' => 'Manage Orders',
    'orders' => $orders,
    'parameters' => $parameters
]);