<?php

namespace Src\App;

use Src\App\Exceptions\RouteNotFoundException;
use Src\App\DB;

class App
{
          public static DB $db;

          public function __construct(
                    protected Router $router,
                    protected array $request,
                    protected Config $config
          ) {
                    self::$db = new DB($this->config->db);
          }

          public function run(): void
          {
                    try {
                              echo $this->router->resolve($this->request["request_method"], $this->request["request_uri"]);

                    } catch (RouteNotFoundException $e) {
                              header("HTTP/1.0 404 Not Found");
                              http_response_code(404);
                              echo Views::make("Exception_Views/404", ["message" => $e->getMessage() . " " . $this->request["request_uri"]]);
                    }
          }
}

