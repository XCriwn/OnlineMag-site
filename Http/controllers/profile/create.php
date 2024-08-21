<?php
use database\Response;

$db = \core\App::resolve(\database\Database::class);

$profile = $db->query("SELECT * FROM users WHERE id = :id", [
    'id'=>getCurrentUserId()
])->findOrFail(Response::NOT_FOUND);

authorize(getCurrentUserRole() !== NULL  && getCurrentUserId() === $profile['id']);

view('profile/profile_view.php', [
    'profile' => $profile,
    'header' => 'My Profile',
]);
