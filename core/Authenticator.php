<?php

namespace core;

use database\Database;

class Authenticator
{

    public function attempt($email, $password){
        $user = App::resolve(Database::class)->query('select * from users where email = :email', [
            'email' => $email
        ])->find();

        if ($user) {
            if (password_verify($password, $user['password'])) {
                $this->login([
                    'email' => $email,
                    'role' => $user['role'],
                    'id' => $user['id']
                ]);
                return $user;
            }
        }

        return false;
    }

    public static function login($user){
        $_SESSION['user'] = [
            'email' => $user['email'],
            'role' => $user['role'],
            'id' => $user['id'],
        ];

        session_regenerate_id(true);
    }

    public static function logout(){
        Session::destroy();
    }
}