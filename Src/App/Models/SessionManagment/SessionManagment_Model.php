<?php
namespace Src\App\Models\SessionManagment;

use Src\App\DB;

class SessionManagment_Model
{

          public function __construct(
                    private DB $db
          ) {
          }

          public function validate_cookie()
          {
                    $user_id = $token = null;
                    if (isset($_COOKIE['user_id']) && isset($_COOKIE['token'])) {
                              $user_id = $_COOKIE['user_id'];
                              $token = $_COOKIE['token'];

                              $is_valid_cookie_info = $this->validate_cookie_info($user_id, $token);

                              if (!$is_valid_cookie_info) {
                                        setcookie("user_id", "", time() - 3600, "/");
                                        setcookie("token", "", time() - 3600, "/");
                                        return false;
                              }
                              $user_info = $this->get_user_info_form_db($user_id);

                              return $user_info;
                    }
                    return;
          }

          public function validate_cookie_info(string $user_id, string $token)
          {

                    $sql = "SELECT * FROM persistent_logins WHERE user_id = :user_id AND token = :token AND expires_at > NOW()";
                    try {

                              $stmt = $this->db->prepare($sql);
                              $stmt->execute(['user_id' => $user_id, 'token' => $token]);
                              $row = $stmt->fetch();

                              return $row;
                    } catch (\Throwable $e) {
                              die("Error: " . $e->getMessage());
                    }
          }
          public function get_user_info_form_db(string $user_id)
          {

                    $sql = "SELECT * FROM users WHERE id = :user_id";

                    $stmt = $this->db->prepare($sql);
                    $stmt->execute(['user_id' => $user_id]);

                    return $stmt->fetch();
          }
}