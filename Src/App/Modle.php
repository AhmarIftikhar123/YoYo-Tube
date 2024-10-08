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
          protected function redirect_user_to_login()
          {
                    echo "User not found. Redirecting to authentication page...";
                    echo "<script>setTimeout(() => { window.location.href = '/authentication'; }, 2000);</script>";
                    exit();
          }
          private function is_user_registered()
          {
                    if (!session_id()) {
                              session_start();
                    }

                    $isRegistered = isset($_SESSION['user_id']);

                    if (session_id()) {
                              session_write_close();
                    }

                    return $isRegistered;
          }
}
