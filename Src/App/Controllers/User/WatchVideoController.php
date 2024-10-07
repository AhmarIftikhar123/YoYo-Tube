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
                    $data['current_video_info'] = $this->WatchVideoModel->is_valid_user($_GET);
                    $data['latest_videos_info'] = $this->WatchVideoModel->get_lates_videos();
                    if ($_GET['is_paid'] == 1) {
                              // $is_payment_history_exist = $this->WatchVideoModel->is_payment_history_exist($_GET['id']);
                              $path = "Payment/PaymentView";
                    }
                    return Views::make($path, $data);
          }
}