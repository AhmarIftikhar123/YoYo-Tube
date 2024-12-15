<?php
namespace Src\App\Controllers\Logout;

class LogoutController
{
          public function logout()
          {
                    if (isset($_GET['logout'])) {
                              session_start();
                              session_destroy();
                              foreach ($_COOKIE as $cookie_name => $cookie_value) {
                                        setcookie($cookie_name, "", time() - 3600, "/"); // Expire the cookie
                              }
                              header("Location: /authentication");
                              exit();
                    }
          }
}

