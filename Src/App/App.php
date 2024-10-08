<?php

namespace Src\App;

use Src\App\Exceptions\RouteNotFoundException;
use Src\App\DB;
use Src\App\Models\SessionManagment\SessionManagment_Model;

class App
{
          public static DB $db;
          private SessionManagment_Model $SessionManagment;
          public function __construct(
                    protected Router $router,
                    protected array $request,
                    protected Config $config,
          ) {
                    self::$db = new DB($this->config->db);
                    $this->SessionManagment = new SessionManagment_Model(self::$db);
                    $this->validate_cookie($this->SessionManagment->validate_cookie());
          }

          public function run(): void
          {
                    try {
                              echo $this->router->resolve($this->request["request_method"], $this->request["request_uri"]);

                    } catch (RouteNotFoundException $e) {
                              header("HTTP/1.0 404 Not Found");
                              http_response_code(404);
                              // echo Views::make("Exception_Views/404", ["message" => $e->getMessage() . " " . $this->request["request_uri"]]);
                              echo $e->getMessage() . " " . $this->request["request_uri"];
                    }

          }
          // Session Management

          public function validate_cookie($is_valid_cookie_data)
          {
                    if ($is_valid_cookie_data) {
                              session_start();
                              session_regenerate_id(true);
                              $_SESSION["user_id"] = $is_valid_cookie_data["id"];
                              $_SESSION["username"] = $is_valid_cookie_data["username"];
                              $_SESSION["email"] = $is_valid_cookie_data["email"];
                              $_SESSION["profile_img"] = $is_valid_cookie_data["profile_img"];
                              session_write_close();
                    }
          }
}

