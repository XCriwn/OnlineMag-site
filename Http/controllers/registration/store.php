<?php

use database\Response;
use Http\forms\Register;

$email = $_POST['email'];
$password = $_POST['password'];
$role = 'user';

// validate the form
$form = Register::validate($attributes = [
    'first_name' => $_POST['first_name'],
    'last_name' => $_POST['last_name'],
    'email' => $_POST['email'],
    'password' => $_POST['password'],
    'address_country' => $_POST['address_country'],
    'address_state' => $_POST['address_state'],
    'address_city' => $_POST['address_city'],
    'address_street' => $_POST['address_street'],
    'phone_number' => $_POST['phone_number'],
]);

if($form->hasErrors()){
    view("registration/create.view.php",[
        'errors' => $form->getErrors(),
        'header' => NULL,
    ]);
    exit();
}
// check is account already exists
$db = \core\App::resolve(\database\Database::class);
$user = $db->query('select * from users where email = :email', [
    'email' => $email
])->find();

if($user){
    // if yes, redirect to a login page
    redirect("/login");
}
else {
    // if not, then save it to the database, log the user in and redirect him
    $db->query('INSERT INTO users(first_name, last_name, email, password, phone_number, city, state, country, street, role) VALUES(:first_name, :last_name, :email, :password, :phone_number, :city, :state, :country, :street, :role) ', [
        'email' => $email,
        'password' => password_hash($password, PASSWORD_BCRYPT),
        'first_name' => $_POST['first_name'],
        'last_name' => $_POST['last_name'],
        'phone_number' => $_POST['phone_number'],
        'city' => $_POST['address_city'],
        'state' => $_POST['address_state'],
        'country' => $_POST['address_country'],
        'street' => $_POST['address_street'],
        'role' => $role,
    ]);
}

//mark that the user has logged in
login([
    'email' => $email,
    'role' => $role,
    'id' => $db->query("select id from users where email = :email", [
        'email'=>$_POST['email']
    ])->find()['id']
]);

redirect("/");