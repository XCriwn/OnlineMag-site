<?php

use database\Response;

$db = \core\App::resolve(\database\Database::class);
$currentUserId = getCurrentUserId();

authorize(getCurrentUserRole() !== NULL && isset($_GET['id']));

$product = $db->query("SELECT 
    product.*, 
    GROUP_CONCAT(categories.name SEPARATOR ', ') AS category_names
FROM 
    product
LEFT JOIN 
    product_categories ON product.id = product_categories.product_id
LEFT JOIN 
    categories ON product_categories.category_id = categories.id
WHERE 
    product.id = :id
GROUP BY 
    product.id;", [
    'id'=>$_GET['id']
])->findOrFail(Response::NOT_FOUND);

view('products/show.view.php', [
    'product' => $product,
    'header' => 'Product',
]);

