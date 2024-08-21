<?php

use database\Response;

$db = \core\App::resolve(\database\Database::class);
//TODO profile stuff

$profile = $db->query("SELECT * FROM users WHERE id = :id", [
    'id'=>getCurrentUserId()
])->findOrFail(Response::NOT_FOUND);

authorize(getCurrentUserRole() !== NULL && getCurrentUserId() === $profile['id']);

$db->query('UPDATE users SET first_name = :first_name, last_name = :last_name, email = :email, phone_number = :phone_number, city = :city, state = :state, country = :country, street = :street WHERE id = :id', [
    'first_name' => $_POST['first_name'],
    'last_name' => $_POST['last_name'],
    'email' => $_POST['email'],
    'phone_number' => $_POST['phone_number'],
    'city' => $_POST['city'],
    'state' => $_POST['state'],
    'country' => $_POST['country'],
    'street' => $_POST['street'],
    'id' => getCurrentUserId()
]);

$profile = $db->query("SELECT * FROM users WHERE id = :id", [
    'id'=>getCurrentUserId()
])->findOrFail(Response::NOT_FOUND);

view('profile/profile_view.php', [
    'profile' => $profile,
    'header' => 'My Profile',
]);

