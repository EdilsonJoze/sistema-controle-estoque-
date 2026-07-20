<?php

namespace App\Core;

class Router {
    private array $routes = [];

    public function add(string $method, string $path, string $controller, string $action): void {
        $this->routes[] = [
            'method'     => strtoupper($method),
            'path'       => trim($path, '/'),
            'controller' => $controller,
            'action'     => $action
        ];
    }

    public function dispatch(string $method, string $uri): void {
        $uri = trim($uri, '/');

        foreach ($this->routes as $route) {
            if ($route['method'] === strtoupper($method) && $route['path'] === $uri) {
                $controllerName = "App\\Controllers\\" . $route['controller'];
                $action = $route['action'];

                if (class_exists($controllerName)) {
                    $controller = new $controllerName();
                    if (method_exists($controller, $action)) {
                        $controller->$action();
                        return;
                    }
                }
            }
        }

        // Caso a rota não seja encontrada (Erro 404)
        http_response_code(404);
        require_once __DIR__ . '/../Views/404.php';
    }
}