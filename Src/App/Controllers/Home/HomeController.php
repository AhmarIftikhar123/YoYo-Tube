<?php
namespace Src\App\Controllers\Home;
use Src\App\Models\Home\HomeModel;
use Src\App\Views;

class HomeController
{
          public function load_home_page()
          {
                    $HomeModel = new HomeModel();
                    return Views::make("Home/HomeView",[
                              "HomeModel" => $HomeModel
                    ]);
          }
}