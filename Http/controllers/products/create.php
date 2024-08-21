<?php

authorize(getCurrentUserRole() === 'admin');

view('products/create.view.php', [
    'errors' => [],
    'header' => 'Create New Product',
    'categories' => getAllCategories()
]);