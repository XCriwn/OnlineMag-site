<?php

namespace core;

use database\Database;

class Authenticator
{
    /**
     * Attempt to login the user with the given email and password
     *
     * @param $email
     * @param $password
     * @return mixed
     */
    public function attempt($email, $password) : mixed
    {
        $user = App::resolve(Database::class)->query('select * from users where email = :email', [
            'email' => $email
        ])->find();

        if (!$user) {
            return false;
        }

        if (!password_verify($password, $user['password'])) {
            return false;
        }

        $this->login([
            'id'    => $user['id'],
            'email' => $email,
            'role'  => $user['role'],
        ]);

        return $user;
    }

    /**
     * Add logged in user detail to session
     *
     * @param $user
     */
    public static function login($user): void
    {
        $_SESSION['user'] = [
            'id'    => $user['id'],
            'email' => $user['email'],
            'role'  => $user['role'],
        ];

        session_regenerate_id(true);
    }

    /**
     * Log out the user and destroy the session
     *
     * @return void
     */
    public static function logout(): void
    {
        Session::destroy();
    }
}