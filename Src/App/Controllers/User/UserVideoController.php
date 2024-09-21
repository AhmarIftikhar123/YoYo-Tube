<?php
namespace Src\App\Controllers\User;

use Src\App\Models\User\UserVideoModel;
use Src\App\Views;

class UserVideoController
{

          public function load_User_Videos_Page()
          {
                    session_start();
                    if (!isset($_SESSION["user_id"])) {
                              echo "User not found. Redirecting to authentication page in 2 seconds.";
                              header("Refresh: 2; url=/authentication", true, 302);
                              die();
                    }
                    $user_video_model = new UserVideoModel();
                    // $get_user_posts = $user_video_model->get_user_posts($user_id);
                    echo Views::make("User/UserVideoView", [
                              "user_video_model" => $user_video_model
                    ]);
          }
}