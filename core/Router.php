<?php
namespace core;
use core\middleware\Auth;
use core\middleware\Guest;

class Router{
    protected $routes = [];

    protected function add($uri, $controller, $method) {
        $this->routes[] = [
            'uri' => $uri,
            'controller' => $controller,
            'method' => $method,
            'middleware' => null
        ];
        // or we can use compact('uri','controller','method');
        return $this;
    }

    function get($uri, $controller) {
        return $this->add($uri, $controller, 'GET');
    }
    function post($uri, $controller) {
        return $this->add($uri, $controller, 'POST');
    }
    function delete($uri, $controller) {
        return $this->add($uri, $controller, 'DELETE');
    }
    function put($uri, $controller) {
        return $this->add($uri, $controller, 'PUT');
    }
    function patch($uri, $controller) {
        return $this->add($uri, $controller, 'PATCH');
    }

    public function only($key) {
        $this->routes[array_key_last($this->routes)]['middleware'] = $key;

        return $this;
    }

    //TODO maybe a function like only but with all keys?

    public function route($uri, $method) {
        foreach($this->routes as $route) {
            if($route['uri'] === $uri && $route['method'] === strtoupper($method)) {
                middleware\Middleware::resolve($route['middleware']);

                return require base_path("Http/controllers/" . $route['controller']);
            }
        }
        abort();
    }

    public function previousUrl() {
        return $_SERVER['HTTP_REFERER'];
    }
}