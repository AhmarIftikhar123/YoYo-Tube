<?php
namespace Src\App;
abstract class Modle
{
          protected DB $db;
          public static bool $user_registered;
          public function __construct()
          {
                    $this->db = App::$db;
                    static::$user_registered = $this->is_user_registered();
          }
          public function redirect_user_to_login()
          {
                    // Set the headers for delayed redirection using the Refresh header
                    header('Refresh: 2; url=/authentication');

                    echo "User not found. Redirecting to authentication page in 2 seconds..." . "</br>";

                    // Provide a fallback for users without JavaScript
                    echo "If you are not redirected, click <a class='fw-bold' href='/authentication'>here</a>.";
                    exit();
          }

          private function is_user_registered()
          {
                    if (session_status() === PHP_SESSION_NONE) {
                              session_start();
                    }
                    $is_user_registered = isset($_SESSION['user_id']);

                    if (session_status() === PHP_SESSION_ACTIVE) {
                              session_write_close();
                    }

                    // Return whether the user is registered or not
                    return $is_user_registered;
          }

}
