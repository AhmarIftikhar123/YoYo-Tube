<?php
namespace Src\App\Controllers;

use Src\App\Views;

class ProfileController
{

          public function View_Profile(): Views
          {
                    return Views::make("Profile_Views/User_Profile_View");
          }
}