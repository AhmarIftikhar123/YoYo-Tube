<?php
namespace Src\App\Controllers\User;

use Src\App\Models\User\UserVideoModel;
use Src\App\Views;

class UserVideoController
{

          public function load_User_Videos_Page()
          {
                    $user_video_model = new UserVideoModel();
                    if (!UserVideoModel::$user_registered) {
                              $user_video_model->redirect_user_to_login();
                    }
                    return Views::make("User/UserVideoView", [
                              "user_video_model" => $user_video_model
                    ]);
          }
}