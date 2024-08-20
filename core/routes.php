<?php

//TODO replace note with product when its finished
$router->get('/', 'index.php');
$router->get('/about', 'about.php');
$router->get('/contact', 'contact.php');

$router->get('/products', 'products/index.php')->only('auth');
$router->post('/products', 'products/index.php')->only('auth');
$router->get('/product', 'products/show.php')->only('auth');
$router->get('/product/create', 'products/create.php')->only('auth');
$router->post('/product/store', 'products/store.php')->only('auth');
$router->get('/product/edit', 'products/edit.php')->only('auth');
$router->patch('/product', 'products/update.php')->only('auth');
$router->delete('/product', 'products/destroy.php')->only('auth');

$router->get('/register', 'registration/create.php')->only('guest');
$router->post('/register', 'registration/store.php')->only('guest');
$router->get('/login', 'sessions/create.php')->only('guest');
$router->post('/sessions', 'sessions/store.php')->only('guest');
$router->delete('/sessions', 'sessions/destroy.php')->only('auth');

$router->get('/profile', 'profile/create.php')->only('auth');
$router->post('/profile', 'profile/store.php')->only('auth');

$router->post('/order', 'order/store.php')->only('auth');

$router->delete('/cart', 'order/destroy.php')->only('auth');
$router->get('/cart', 'order/show.php')->only('auth');
$router->post('/cart', 'order/handle.php')->only('auth');

$router->get('/my_orders', 'order/my_orders.php')->only('auth');
$router->get('/my_order', 'order/my_order.php')->only('auth');

$router->get('/manage', 'order/manage.php')->only('auth');
$router->post('/manage', 'order/manage.php')->only('auth');
$router->patch('/update_status', 'order/update_status.php')->only('auth');


//$router->get('', '');


