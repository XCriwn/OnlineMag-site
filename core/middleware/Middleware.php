<?php

namespace core\middleware;

class Middleware
{
    const MAP = [
        'guest' => Guest::class,
        'auth' => Auth::class,
        //TODO
    ];

    public static function resolve($key){

        if(!$key){
            return;
        }

        $middleware = static::MAP[$key] ?? false;

        if(!$middleware){
            throw new \Exception("No middleware found for key '{$key}'.");
        }

        (new $middleware)->handle();
    }
}