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
                    return Views::make($path, $data);
          }

          public function updateProfile()
          {
                    session_start();
                    if (isset($_SESSION['user_id'])) {
                              $user_id = $_SESSION['user_id'];
                              $new_profile_img = $_FILES['new_profile_img'];
                              $new_username = $_POST['new_username'];
                              session_write_close();
                              $is_profile_updated = $this->profileModel->update_profile($user_id, $new_profile_img, $new_username);

                              if ($is_profile_updated > 0) {
                                        return $this->load_profile_page("UserProfile/UserProfileView", ["message" => "Profile updated successfully"]);
                              }
                              throw new \Exception("Profile not updated");

                    } else {
                              throw new \Exception("User not logged in");
                    }

          }
}