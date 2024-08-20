<?php

$db = \core\App::resolve(\database\Database::class);

$product = $db->query("SELECT
    product.*,
    GROUP_CONCAT(categories.name SEPARATOR ', ') AS category_names  
FROM
    product
LEFT JOIN
    product_categories ON product.id = product_categories.product_id
LEFT JOIN
    categories ON product_categories.category_id = categories.id
GROUP BY
    product.id, product.name, product.description, product.price
ORDER BY
    product.id DESC
LIMIT 3")->findAll();


view('index_view.php', [
    'header' => 'Home',
    'products' => $product
]);