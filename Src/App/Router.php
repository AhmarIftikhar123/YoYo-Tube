<?php
namespace Src\App;

use Src\App\Exceptions\RouteNotFoundException;

class Router
{
          private array $routes = [];

          public function get(string $route, callable|array $action): self
          {
                    $this->register("get", $route, $action);
                    return $this;
          }
          public function register(string $request_method, string $route, callable|array $action): void
          {
                    $this->routes[$request_method][$route] = $action;
          }
          public function post(string $route, callable|array $action): self
          {
                    $this->register("post", $route, $action);
                    return $this;
          }
          public function resolve(string $request_method, string $request_uri)
          {
                    $request_uri = explode("?", $request_uri)[0];
                    $purpose = $this->routes[$request_method][$request_uri] ?? null;
                    if (is_callable($purpose)) {
                              return call_user_func($purpose);
                    }
                    if (is_array($purpose)) {
                              [$class, $method] = $purpose;
                              if (class_exists($class)) {
                                        $class = new $class;
                                        if (method_exists($class, $method)) {
                                                  return call_user_func_array([$class, $method], []);
                                        }
                              }
                    }
                    throw new RouteNotFoundException(message: "Route not Found Exception:");
          }

          public function getRoutes(): array
          {
                    return $this->routes;
          }

}