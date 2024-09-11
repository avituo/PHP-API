<?php

namespace Src\Core;

class Router
{
    private $routes = [];

    public function add($method, $pattern, $callback)
    {
        $pattern = '@^' . preg_replace('/\{(\w+)}/', '(?P<$1>\d+)', $pattern) . '$@';
        $this->routes[] = [$method, $pattern, $callback];
    }

    public function get($pattern, $callback)
    {
        $this->add('GET', $pattern, $callback);
    }

    public function post($pattern, $callback)
    {
        $this->add('POST', $pattern, $callback);
    }

    public function put($pattern, $callback)
    {
        $this->add('PUT', $pattern, $callback);
    }

    public function delete($pattern, $callback)
    {
        $this->add('DELETE', $pattern, $callback);
    }

    public function run()
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        foreach ($this->routes as $route) {
            list($routeMethod, $routePattern, $routeCallback) = $route;
            if ($method === $routeMethod && preg_match($routePattern, $path, $matches)) {
                $params = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);
                return call_user_func_array($routeCallback, $params);
            }
        }

        http_response_code(404);
        echo json_encode(['error' => 'Route not found']);

        return;
    }
}

