<?php
namespace Src\App\Controllers;

use Src\App\Views;

class VideoPlayerController
{
          public function load_video_Player(): Views
          {
                    return Views::make("Video_Player/Video_Player_View");
          }
}