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

          public function load_video_watch_page(string $path = "User/WatchVideoView", array $data = [])
          {
                    $video_info = [
                              "user_id" => $_GET['user_id'],
                              "video_id" => $_GET['video_id'],
                              "is_paid" => $_GET['is_paid']
                    ];

                    $data = $this->WatchVideoModel->get_current_latest_video_info($video_info);

                    if ($this->WatchVideoModel->is_video_owner($video_info)) {
                              $path = "User/WatchVideoView";
                    } else {
                              if ($data['current_video_info']['price'] <= 0) {
                                        $path = "User/WatchVideoView";
                              } elseif ($_GET['is_paid'] == 1 && !$this->WatchVideoModel->is_payment_history_exist(USER_ID, $video_info['video_id'])) {
                                        $path = "Payment/PaymentView";
                              }
                    }
                    return Views::make($path, $data);
          }
}