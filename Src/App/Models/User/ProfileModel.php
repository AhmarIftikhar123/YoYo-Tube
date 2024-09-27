<?php
namespace Src\App\Models\User;
use Src\App\Modle;

class ProfileModel extends Modle
{
          public function update_profile(int $user_id, array|string $profile_img, string $username): ?int
          {
                    $username = filter_var($username, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                    if (empty($username) || strlen($username) > 30 || strlen($username) <= 0) {
                              die("Invalid username");
                    }
                    $storage_dir = STORAGE_DIR . "/" . $username;
                    if (!is_dir($storage_dir)) {
                              mkdir($storage_dir, 0777, true);
                    }
                    $profile_img_path = $storage_dir . "/" . $profile_img['name'];

                    if ($profile_img['size'] > 597152) {
                              die("profile_img is too large");
                    }
                    if (!move_uploaded_file($profile_img['tmp_name'], $profile_img_path)) {
                              die("Failed to upload profile_img");
                    }
                    ;

                   return $this->update_user_info($user_id, $username, $profile_img_path);
          }

          public function update_user_info(int $user_id, string $username, string $profile_img_path): int
          {
                    $sql = "UPDATE users SET username = :username, profile_img = :profile_img WHERE id = :user_id";
                    try {
                              $stmt = $this->db->prepare($sql);
                              $stmt->execute(['user_id' => $user_id, 'username' => $username, 'profile_img' => $profile_img_path]);
                              return $stmt->rowCount();
                    } catch (\PDOException $e) {
                              throw $e;
                    }
          }
}