<?php

$email = $_POST['email'];
$password = $_POST['password'];


$form = \Http\forms\Login::validate($attributes = [
    'email' => $_POST['email'],
    'password' => $_POST['password']
]);

$user = (new \core\Authenticator())->attempt(
    $attributes['email'], $attributes['password']
);

if(! $user){
    $form->setErrorMessage(
        'email', 'Incorrect email address or password.'
    )->throw();
}

//take role and id from database and put it in the session
$db = \core\App::resolve(\database\Database::class);
login([
    'email' => $email,
    'role' => $user['role'],
    'id' => $user['id']
]);

redirect("/");

//viewAndExit('sessions/create.view.php', [
//    'header' => '',
//    'errors' => $form->getErrors(),
//]);


