<?php
namespace Src\App\Controllers\Profile;

use Src\App\Models\User\ProfileModel;
use Src\App\Views;

class ProfileController
{

          private ProfileModel $profileModel;
          public function __construct()
          {
                    $this->profileModel = new ProfileModel();
          }
          public function load_profile_page(string $path = "UserProfile/UserProfileView", array $data = []): Views
          {
                    if (!$this->profileModel->is_user_registered()) {
                              $this->profileModel->redirect_user_to_login();
                    }
                    return Views::make($path, $data);
          }

          public function updateProfile()
          {
                    if (!$this->profileModel->is_user_registered()) {
                              $this->profileModel->redirect_user_to_login();
                    }
                    if (empty($_FILES['new_profile_img']['name']) || empty($_POST['new_username'])) {
                              throw new \Exception("Please fill all the fields");
                    }
                    if (session_status() === PHP_SESSION_NONE) {
                              session_start();
                    }
                    if (isset($_SESSION['user_id']) || isset($_COOKIE['user_id'])) {
                              $user_id = $_SESSION['user_id'] ?? $_COOKIE['user_id'];
                              $new_profile_img = $_FILES['new_profile_img'];
                              $new_username = $_POST['new_username'];

                              if (session_status() === PHP_SESSION_ACTIVE) {
                                        session_write_close();
                              }
                              $is_profile_updated = $this->profileModel->update_profile($user_id, $new_profile_img, $new_username);

                              header("Content-Type: application/json");
                              if ($is_profile_updated === 1) {
                                        http_response_code(200);
                                        echo json_encode(["message" => "Profile updated successfully"]);
                                        exit();
                              } elseif ($is_profile_updated === 0) {
                                        http_response_code(200);
                                        echo json_encode(["message" => "No changes made to username"]);
                                        exit();
                              }
                              http_response_code(500);
                              echo json_encode(["error" => "Failed to update profile, please try again later"]);
                              exit();
                    } else {
                              http_response_code(401);
                              echo json_encode(["error" => "User not logged in"]);
                              exit();
                    }

          }
}