<?php
namespace Src\App\Controllers\User;
use Src\App\Models\User\WatchVideoModel;
use Src\App\Views;

class WatchVideoController
{
          protected $WatchVideoModel;
          public function __construct()
          {
                    $this->WatchVideoModel = new WatchVideoModel();
          }

          public function load_video_watch_page(string $path = "User/WatchVideoView", array $data = []): Views
          {
                    $video_info = [
                              "user_id" => $_GET['user_id'],
                              "video_id" => $_GET['video_id'],
                              "is_paid" => $_GET['is_paid']
                    ];

                    $data = $this->WatchVideoModel->get_current_latest_video_info($video_info);

                    // Start the session if it has not been started.
                    if (session_status() === PHP_SESSION_NONE) {
                              session_start();
                    }

                    // Get the user ID from the session or cookie.
                    $appUser_id = $_SESSION['user_id'] ?? $_COOKIE['user_id'] ?? null;

                    // Close the session.
                    if (session_status() === PHP_SESSION_ACTIVE) {
                              session_write_close();
                    }

                    // Check if the user is the video owner.
                    if (!empty($appUser_id)  && $this->WatchVideoModel->is_video_owner($video_info,$appUser_id)) {
                              $path = "User/WatchVideoView";
                              var_dump("true");
                    } else {
                              // Check if the video is free.
                              if ($data['current_video_info']['price'] <= 0) {
                                        $path = "User/WatchVideoView";
                              } else {
                                        // Check if the user has paid for the video.
                                        if ($_GET['is_paid'] == 1 && !$this->WatchVideoModel->is_payment_history_exist($appUser_id, $video_info['video_id'])) {
                                                  $path = "Payment/PaymentView";
                                        }
                              }
                    }

                    return Views::make($path, $data);
          }
}