<?php

use database\Response;

//TODO product stuff (img and category?)
$currentUserId = getCurrentUserId();
$db = \core\App::resolve(\database\Database::class);

authorize(getCurrentUserRole() === 'admin');

destroyImage("select image from product where id = :id", [
    'id' => $_POST['id']
]);

$db->query("delete from product where id = :id", [
    'id' => $_POST['id']
]);

destroyCategories($_POST['id']);

header('location: /products');
exit();

