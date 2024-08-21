<?php
//todo manage orders as the admin

authorize(getCurrentUserRole() === 'admin');

$db = \core\App::resolve(\database\Database::class);

$query = "SELECT o.*, u.first_name, u.last_name, u.email, u.country, u.state, u.city, u.street FROM `order` o JOIN `users` u ON o.user_id = u.id WHERE ";
$parameters = [];

if(!empty($_POST) && $_POST['filter'] !== "0") {

    $query = $query . "o.status = :status";
    $parameters['status'] = $_POST['filter'];
}
else{
    $query = $query . "o.status = 'PENDING' OR o.status = 'CANCELLED' OR o.status = 'COMPLETED'";
}
$orders = $db->query($query, $parameters)->findAll();

//todo i want to take the user_id from order and find the user details associated with that user id


view('order/manage.view.php', [
    'header' => 'Manage Orders',
    'orders' => $orders,
    'parameters' => $parameters
]);